<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category' => function($query)
        {
            return $query->select(['id', 'name']);
        }, 'galleries' => function($query)
        {
            return $query->select(['product_id', 'url']);
        }])->withSum('details', 'quantity');

        $products->when(request('search') ?? false, fn($query, $key) => 
            $query->where('name', 'like', '%'.$key.'%')
                ->orWhere('description', 'like', '%'.$key.'%')
                ->orWhereHas('category', fn($query) => 
                    $query->where('name', 'like', '%'.$key.'%')
                )
        );

        return view('user.product.index', [
            'products' => $products->paginate(12)
        ]);
    }

    public function show(Product $product)
    {
        return view('user.product.show', [
            'product' => $product->load(['category' => function($query)
            {
                return $query->select(['id', 'name']);
            }, 'galleries' => function($query)
            {
                return $query->select(['product_id', 'url']);
            }])->LoadSum('details', 'quantity')
        ]);
    }
}
