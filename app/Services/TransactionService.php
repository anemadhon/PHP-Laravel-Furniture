<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Payment;
use App\Models\Shipping;
use App\Models\TransactionDetail;

class TransactionService
{
    public function checkout(array $data)
    {
        $transaction = self::insertTransaction();

        self::insertTransactionShipping($data, $transaction->id);

        self::insertTransactionPayment($data, $transaction->id);
        
        self::insertTransactionDetails($data, $transaction->id);

        self::deleteCart($data['carts']);

        return $transaction;
    }

    private static function insertTransaction()
    {
        return auth()->user()->transactions()->create([
            'code' => self::createUniqueCode('FTR'),
            'status' => 'PENDING'
        ]);
    }

    private static function insertTransactionShipping(array $data, int $transaction_id)
    {
        Shipping::create([
            'status' => 'PENDING',
            'courier' => $data['validated']['courier'],
            'costs' => $data['validated']['shipping_cost'],
            'awb_number' => self::createUniqueCode('FTR-AWB-NUM'),
            'transaction_id' => $transaction_id
        ]);
    }
    
    private static function insertTransactionPayment(array $data, int $transaction_id)
    {
        Payment::create([
            'status' => 'PENDING',
            'method' => 'MIDTRANS',
            'url' => '',
            'total' => (int) ($data['validated']['total_amount'] + $data['validated']['shipping_cost']),
            'transaction_id' => $transaction_id
        ]);
    }
    
    private static function insertTransactionDetails(array $data, int $transaction_id)
    {
        $dataCart = [];

        foreach ($data['carts'] as $index => $cart)
        {
            $dataCart[] = [
                'code' => self::createUniqueCode('FTR-'.($index + 1)),
                'price' => $cart->purchase_price,
                'quantity' => $cart->purchase_quantity,
                'transaction_id' => $transaction_id,
                'product_id' => $cart->product->id,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString()
            ];
        }

        TransactionDetail::insert($dataCart);
    }

    private static function deleteCart(object $carts)
    {
        Cart::destroy($carts->pluck('id'));
    }

    private static function createUniqueCode(string $flag)
    {
        return $flag.'-'.mt_rand(0000,9999).'-'.time();
    }
}
