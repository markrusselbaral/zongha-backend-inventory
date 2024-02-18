<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{
    use HasFactory;

    protected $table = 'warehouses';
    protected $guarded = [''];

    public function product() {
        return $this->hasMany(Product::class, 'warehouse_id');
    }

    public function tabWarehouse() {
        $warehouse = $this->all();
        if($warehouse) {
            return $warehouse;
        }
        return false;
    }

    public function allWarehouse($search) {
        $warehouse = $this->when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
        ->paginate(10)
        ->withQueryString();
        return $warehouse;
    }

    public function showWarehouse($id) {
        $warehouse = $this->find($id);
        return $warehouse;
    }
    public function storeWarehouse($data) {
        $warehouse = $this->create($data);
        return $warehouse;
    }

    public function updateWarehouse($id, $data) {
        $warehouse = $this->find($id);

        if ($warehouse) {
            $update = $warehouse->update($data);
            return $update;
        }

        return false;
    }

    public function deleteWarehouse($id) {
        $warehouse = $this->find($id);
        if($warehouse) {
            $delete = $warehouse->delete();
            return $delete;
        }
        return false;
    }


    public function multipleDelete($data)
    {
        $pricing = $this->whereIn('id', $data);
        $pricing->delete();
    }
}
