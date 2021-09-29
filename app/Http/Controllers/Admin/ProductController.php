<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('manage-apps');

        $products = Product::with(['category', 'galleries'])->withSum('details', 'quantity');

        $products->when(request('search') ?? false, fn($query, $key) => 
            $query->where('name', 'like', '%'.$key.'%')
                ->orWhere('description', 'like', '%'.$key.'%')
                ->orWhereHas('category', fn($query) => 
                    $query->where('name', 'like', '%'.$key.'%')
                )
        );

        return view('admin.product.index', [
            'products' => $products->paginate(12)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('manage-apps');

        return view('admin.product.form', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $this->authorize('manage-apps');

        Product::create($request->validated());

        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $this->authorize('manage-apps');

        return view('admin.product.show', [
            'product' => $product->load(['category', 'galleries'])->loadSum('details', 'quantity')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $this->authorize('manage-apps');

        return view('admin.product.form', [
            'product' => $product,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->authorize('manage-apps');

        $product->update($request->validated());

        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->authorize('manage-apps');

        $product->delete();

        return back();
    }
}
