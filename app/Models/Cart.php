<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_price', 'purchase_quantity',
        'product_id', 'user_id'
    ];

    protected $appends = ['total_each_product'];

    public function getTotalEachProductAttribute()
    {
        return $this->purchase_price * $this->purchase_quantity;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
