<?php

namespace App\Services;

use App\Models\Cart;

class CartService
{
    public function checkCurrentPrice(array $data)
    {
        if ($data['product_price'] != $data['purchase_price'])
        {
            return $data['product_price'];
        }

        return $data['purchase_price'];
    }

    public function updateOrCreateCart(array $data)
    {
        if (self::getData($data['validated']['product_id']))
        {
            self::updateCart($data);
        }

        if (!self::getData($data['validated']['product_id']))
        {
            self::storeCart($data);
        }
    }

    private static function updateCart(array $data)
    {
        $cart = self::getData($data['validated']['product_id']);

        $cart->purchase_quantity = $cart->purchase_quantity + $data['validated']['purchase_quantity'];

        $cart->save();
    }

    private static function storeCart(array $data)
    {
        auth()->user()->carts()->create($data['validated']);
    }

    private static function getData(int $id)
    {
        return Cart::where('product_id', $id)->first();
    }
}
