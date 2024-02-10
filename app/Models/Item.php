<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';
    protected $guarded = [''];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id');
    }
}
