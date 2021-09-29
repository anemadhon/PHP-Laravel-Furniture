<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\CartRequest;
use App\Services\DataTablesService;
use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DataTablesService $dataTables)
    {
        $carts = auth()->user()->carts->load('product');

        if (request()->ajax())
        {
            return $dataTables->create([
                'data' => $carts->all(),
                'modul' => 'users.carts'
            ]);
        }

        return view('user.cart.index', [
            'total_amount' => $carts->sum('total_each_product')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CartRequest $request)
    {
        $product = Product::select(['quantity', 'price'])->withSum('details as total_purchased_quantity', 'quantity')->findOrFail($request->validated()['product_id']);
        $maxQuantityValidator = $product->quantity - $product->total_purchased_quantity;

        $validator = Validator::make($request->all(), [
            'purchase_quantity' => ['required', 'integer', 'min:1', "max:$maxQuantityValidator"]
        ]);

        if ($validator->fails())
            return back()->withErrors($validator);

        $validated['product_id'] = $request->validated()['product_id'];
        $validated['purchase_quantity'] = $validator->validated()['purchase_quantity'];
        $validated['purchase_price'] = (new CartService())->checkCurrentPrice([
            'product_price' => $product->price,
            'purchase_price' => $request->validated()['purchase_price']
        ]);

        (new CartService())->updateOrCreateCart([
            'validated' => $validated
        ]);
        
        return redirect()->route('dashboard.users.carts.index', auth()->user());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Cart $cart)
    {
        $cart->delete();

        return back();
    }
}
