<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'items';
    protected $guarded = [''];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id');
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
