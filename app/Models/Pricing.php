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
            ->join('products', 'pricings.client_id', '=', 'products.id')
            ->join('items', 'products.item_id', '=', 'items.id')
            ->select(
                'pricings.id',
                'pricings.price',
                'clients.name as client_name',
                'clients.tin_name', 
                'clients.tin_number', 
                'clients.type', 
                'items.name as product_name'
            )
            ->when($search, function ($query, $search) {
                $query->where('clients.name', 'like', '%' . $search . '%');
                $query->orWhere('clients.tin_name', 'like', '%' . $search . '%');
                $query->orWhere('clients.type', 'like', '%' . $search . '%');
                $query->orWhere('items.name', 'like', '%' . $search . '%');
            })
            ->paginate(5);
        
        return $pricings;
    }



    public function addPricing($data)
    {
        return $this->create($data);
    }

    public function editPricing($id)
    {
        return $this->with(['client', 'product'])->find($id);
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
