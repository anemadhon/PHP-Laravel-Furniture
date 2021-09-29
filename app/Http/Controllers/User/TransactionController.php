<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\MidtransService;
use Illuminate\Support\Facades\DB;
use App\Services\DataTablesService;
use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DataTablesService $dataTables)
    {
        if (request()->ajax())
        {
            return $dataTables->create([
                'data' => auth()->user()->transactions->all(),
                'modul' => 'users.transactions'
            ]);
        }

        return view('user.transaction.index');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $carts = auth()->user()->carts->load('product');

        $max = $carts->sum('total_each_product');

        $validated = Validator::make($request->all(), [
            'phone_number' => ['required', 'string', 'exists:users,phone_number'],
            'address' => ['required', 'string', 'exists:users,address_one'],
            'courier' => ['required', 'string', Rule::in(['jne', 'tiki', 'pos'])],
            'shipping_type' => ['required', 'string'],
            'shipping_cost' => ['required', 'integer'],
            'total_amount' => ['required', 'integer', "size:$max"]
        ]);

        if ($validated->fails()) 
            return back()->withErrors($validated);
        
        $dataValidated = $validated->validated();

        DB::beginTransaction();
        
        try
        {
            $transaction = (new TransactionService())->checkout([
                'validated' => $dataValidated,
                'carts' => $carts
            ]);

            $payment = (new MidtransService())->createTransaction([
                'order_id' => $transaction->code,
                'gross_amount' => (int) ($dataValidated['total_amount'] + $dataValidated['shipping_cost']),
                'user_name' => auth()->user()->name,
                'user_email' => auth()->user()->email
            ]);

            if ($payment['status'])
            {
                DB::commit();
                
                return redirect($payment['url']);
            }
            
            if (!$payment['status'])
            {
                DB::rollback();

                return back()->withErrors($payment['error'], 'checkout');
            }
        }
        catch (\Exception $error)
        {
            DB::rollback();

            return back()->withErrors($error->getMessage(), 'checkout');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Transaction $transaction)
    {
        return view('user.transaction.show', [
            'transaction' => $transaction->load(['shipping', 'payment', 'details'])
        ]);
    }
}
