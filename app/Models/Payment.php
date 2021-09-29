<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'status', 'method', 'url',
        'total', 'transaction_id'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
