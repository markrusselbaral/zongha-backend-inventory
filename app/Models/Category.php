<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'categories';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function items()
    {
        return $this->hasMany(Item::class, 'category_id');
    }

    public function allCategory($search)
    {
        $data = $this->when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
        ->paginate(10)
        ->withQueryString();
        return $data;
    }

    public function editCategory($id) {
        $show = $this->find($id);
        return $show;
    }

    public function addCategory($data) {
        $add = $this->create($data);
        return $add;
    }

    public function updateCategory($id, $data){
        $update = $this->find($id);
        $update->update($data);
        return $update;
    }

    public function deleteCategory($id) {
        $delete = $this->find($id);
        if($delete) {
            $delete->delete($id);
            return $delete;
        }
    }
}
