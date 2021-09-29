<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'price', 'quantity',
        'product_id',
        'transaction_id'
    ];

    protected $appends = ['total_each_product'];

    public function getTotalEachProductAttribute()
    {
        return $this->price * $this->quantity;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
