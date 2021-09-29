<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\DataTablesService;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DataTablesService $dataTables)
    {
        $this->authorize('manage-apps');

        if (request()->ajax())
        {
            return $dataTables->create([
                'data' => Transaction::with('user')->get(),
                'modul' => 'users.transactions',
                'is_admin' => true
            ]);
        }

        return view('admin.transaction.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Transaction $transaction)
    {
        $this->authorize('manage-apps');

         return view('admin.transaction.show', [
            'transaction' => $transaction->load(['shipping', 'payment', 'details', 'user'])
         ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Transaction $transaction)
    {
        $this->authorize('manage-apps');

        if (request()->ajax())
        {
            return $transaction->update([
                'status' => $request->status
            ]);
        }
    }

    public function updatePayment(Request $request, User $user, Transaction $transaction)
    {
        $this->authorize('manage-apps');

        if (request()->ajax())
        {
            return $transaction->shipping()->update([
                'status' => $request->status
            ]);
        }
    }
}
