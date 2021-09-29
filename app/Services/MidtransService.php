<?php

namespace App\Services;

use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;
use App\Models\Transaction;

class MidtransService
{
    public function createTransaction(array $data)
    {
        self::config();

        $midtrans = [
            'transaction_details' => [
                'order_id' =>  $data['order_id'],
                'gross_amount' => (int) $data['gross_amount'],
            ],
            'customer_details' => [
                'first_name'    => $data['user_name'],
                'email'         => $data['user_email'],
            ],
            'enabled_payments' => ['gopay','bank_transfer'],
            'vtweb' => []
        ];

        try
        {
            return [
                'status' => true,
                'url' => Snap::createTransaction($midtrans)->redirect_url
            ];
        }
        catch (\Exception $error)
        {
            return [
                'status' => false,
                'error' => $error
            ];
        }
    }

    public function callbackHandling()
    {
        self::config();

        $notification = self::setNotification();
        
        $transaction = Transaction::findOrFail($notification['order_id']);

        self::updateStatusTransaction($notification, $transaction);
    }

    public static function config()
    {
        Config::$serverKey = config('services.midtrans.server');
        Config::$isProduction = config('services.midtrans.production');
        Config::$isSanitized = config('services.midtrans.sanitized');
        Config::$is3ds = config('services.midtrans.3ds');
    }

    private static function setNotification()
    {
        $notification = new Notification();

        return [
            'status' => $notification->transaction_status,
            'type' => $notification->payment_type,
            'fraud' => $notification->fraud_status,
            'order_id' => $notification->order_id
        ];
    }

    private static function updateStatusTransaction(array $notification, object $transaction)
    {
        if ($notification['status'] == 'capture' && $notification['type'] == 'credit_card' && $notification['fraud'] == 'challenge') 
        {
            $transaction->status = 'PENDING';
        }
        
        if ($notification['status'] == 'capture' && $notification['type'] == 'credit_card' && $notification['fraud'] != 'challenge') 
        {
            $transaction->status = 'SUCCESS';
        }

        if ($notification['status'] == 'settlement')
        {
            $transaction->status = 'SUCCESS';
        }

        if($notification['status'] == 'pending')
        {
            $transaction->status = 'PENDING';
        }

        if ($notification['status'] == 'deny')
        {
            $transaction->status = 'CANCELLED';
        }

        if ($notification['status'] == 'expire')
        {
            $transaction->status = 'CANCELLED';
        }

        if ($notification['status'] == 'cancel')
        {
            $transaction->status = 'CANCELLED';
        }

        $transaction->save();
    }
}
