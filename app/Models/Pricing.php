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

    public function displayPricings()
    {
        return $this->with(['client', 'product'])->paginate(5);
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

}
