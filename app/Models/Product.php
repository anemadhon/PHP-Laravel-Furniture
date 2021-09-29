<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    protected $fillable = [
        'name', 'slug', 'description',
        'price', 'quantity', 'category_id'
    ];

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true
            ]
        ];
    }
}
