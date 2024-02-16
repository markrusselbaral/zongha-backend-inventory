<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function displayPurchases($search)
    {
        $purchases =  $this->join('clients', 'clients.id', '=', 'purchases.client_id')
            ->join('products', 'products.id', '=', 'purchases.product_id')
            ->join('items', 'items.id', '=', 'products.item_id')
            ->select(
                'clients.name',
                'clients.tin_name',
                'clients.tin_number',
                'clients.type', 
                'purchases.*',
                'products.*', 
                'items.product_code',
                'items.name'
            ) 
            ->when($search, function ($query, $search) {
                $query->where('clients.name', 'like', '%' . $search . '%');
                $query->orWhere('clients.tin_name', 'like', '%' . $search . '%');
                $query->orWhere('clients.tin_number', 'like', '%' . $search . '%');
                $query->orWhere('clients.type', 'like', '%' . $search . '%');
                $query->orWhere('purchases.type', 'like', '%' . $search . '%');
                $query->orWhere('purchases.status', 'like', '%' . $search . '%');
                $query->orWhere('purchases.mode_of_payment', 'like', '%' . $search . '%');
                $query->orWhere('items.product_code', 'like', '%' . $search . '%');
                $query->orWhere('items.name', 'like', '%' . $search . '%');
            })
            ->paginate(5)
            ->withQueryString();           
        return $purchases;
    }

    public function createPurchase($client_id, $product_id)
    { 
        $purchase = Client::join('pricings', 'pricings.client_id', '=', 'clients.id')
            ->join('products', 'products.id', '=', 'pricings.product_id')
            ->join('items', 'items.id', '=', 'products.item_id')
            ->when($client_id, function ($query) use ($client_id) {
                $query->selectRaw('
                    clients.id,
                    clients.name,
                    clients.tin_name,
                    clients.tin_number,
                    clients.type
                ')->where('clients.id', $client_id);
            })
            ->when($product_id, function ($query) use ($product_id) {
                $query->selectRaw('
                    items.name as product_name,
                    items.product_code,
                    pricings.price,
                    pricings.product_id as product_id
                ')->where('products.id', $product_id);
            })
            ->first(); 
        return $purchase;
    }

    public function addPurchase($data)
    {
        return $this->create($data);
    }

    public function editPurchase($id)
    {
        return $this->find($id);
    }

    public function updatePurchase($data, $id)
    {
        $purchase = $this->find($id);
        $purchase->update($data);
    }

    public function deletePurchase($id)
    {
        $purchase = $this->find($id);
        $purchase->delete();
    }

    public function multipleDeletePurchase($date)
    {
        $pricing = $this->whereIn('id', $data);
        $pricing->delete();
    }


}
