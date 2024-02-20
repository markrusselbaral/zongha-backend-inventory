<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function allProducts()
    {
        $products =  $this->with(['item' => function ($query) {
            $query->select('id','name');
        }])->join('warehouses', 'warehouses.id', '=', 'products.warehouse_id')
        ->select('products.item_id', 'products.id as product_id', 'warehouses.name')->get();
        return $products;
    }

    public function warehouse(){
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function allItems()
    {
        $data['warehouses'] = $this->with(['warehouse' => function ($query) {
            $query->select('id', 'name');
        }])->select('warehouse_id')->get();

        $data['items'] = $this->with(['item' => function ($query) {
            $query->select('id','name', 'product_code', 'image');
        }])->select('item_id')->get();

        return $data;
    }

    public function saveProduct($data)
    {
        $product = $this->with(['warehouse', 'item'])->create($data);

        return $product;
    }


    public function editProduct($id)
    {
        $product = $this->with(['warehouse', 'item'])->find($id);

        return $product;
    }

    public function updateProduct($data, $id)
    {
        $product = $this->find($id);
        $product->update($data);
        return $product;
    }

    public function deleteProduct($id) {
        $data = $this->find($id);
        if($data) {
            $data->delete();
            return $data;
        }
    }
}
