<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pricing()
    {
        return $this->hasMany(Pricing::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function allProducts()
    {
        $products =  $this->with(['item' => function ($query) {
            $query->select('id','name');
        }])->select('item_id')->get();
        return $products;
    }
}
