<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductGalleryRequest;
use App\Models\ProductGallery;
use Illuminate\Http\Request;

class ProductGalleryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductGalleryRequest $request)
    {
        foreach ($request->file('url') as $index => $url)
        {
            ProductGallery::create([
                'product_id' => $request->validated()['product_id'],
                'url' => $url->storePubliclyAs('assets/product-gallery', $request->product_slug.'-'.($index + 1).'.'.$url->extension(), 'public')
            ]);
        }

        return redirect()->route('admin.products.index');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductGallery  $productGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductGallery $productGallery)
    {
        $productGallery->delete();

        return back();
    }
}
