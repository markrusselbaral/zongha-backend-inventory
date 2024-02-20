<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function displayPricings($search)
    {
        $pricings = $this->join('clients', 'pricings.client_id', '=', 'clients.id')
            ->join('products', 'pricings.product_id', '=', 'products.id')
            ->join('warehouses', 'warehouses.id','=', 'products.warehouse_id')
            ->join('items', 'items.id', '=', 'products.item_id')
            ->select(
                'warehouses.name as warehouse_name',
                'pricings.id',
                'pricings.price',
                'clients.id as client_id',
                'clients.name as client_name',
                'clients.tin_name', 
                'clients.tin_number', 
                'clients.type', 
                'items.name as product_name',
                'pricings.updated_at',
                'products.id as product_id',
                
            )
            ->when($search, function ($query, $search) {
                $query->where('clients.name', 'like', '%' . $search . '%');
                $query->orWhere('clients.tin_name', 'like', '%' . $search . '%');
                $query->orWhere('clients.type', 'like', '%' . $search . '%');
                $query->orWhere('items.name', 'like', '%' . $search . '%');
            })
            ->orderBy('pricings.id')
            ->paginate(10)
            ->withQueryString();
        return $pricings;

    }



    public function addPricing($data)
    {
        return $this->create($data);
    }

    public function editPricing($id)
    {
        $pricing = $this->join('clients', 'clients.id', '=', 'pricings.client_id')
                ->join('products', 'pricings.product_id', '=', 'products.id')
                ->join('items', 'products.item_id', '=', 'items.id')
                ->select('clients.name', 'pricings.client_id', 'pricings.product_id','items.name as product_name', 'pricings.id as pricing_id', 'pricings.price')
                ->where('pricings.id', '=', $id)
                ->first();
        return $pricing;
    }

    public function updatePricing($data, $id)
    {
        $pricing = $this->find($id);
        $pricing->update($data);
    }

    public function deletePricing($id)
    {
        $pricing = $this->find($id);
        $pricing->delete();
    }

    public function multipleDeletePricing($data)
    {
        $pricing = $this->whereIn('id', $data);
        $pricing->delete();
    }

}
