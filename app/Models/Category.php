<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(Item::class, 'category_id');
    }

    public function allCategory() {
        $all = $this->all();
        return $all;
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
