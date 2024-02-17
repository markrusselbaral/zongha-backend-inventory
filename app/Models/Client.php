<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function pricing()
    {
        return $this->hasMany(Pricing::class);
    }

    public function allClients()
    {
        return $this->select('id', 'name')->get();
    }

    public function displayClients($search)
    {
        $client = $this->when($search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
                $query->orWhere('tin_name', 'like', '%' . $search . '%');
                $query->orWhere('tin_number', 'like', '%' . $search . '%');
                $query->orWhere('type', 'like', '%' . $search . '%');
            })
            ->paginate(10)
            ->withQueryString();
        return $client;
    }

    public function addClient($data)
    {
        $client =  $this->create($data);
        return $client->id;
    }

    public function editClient($id)
    {
        return $this->find($id);
    }

    public function updateClient($data, $id)
    {
        $client = $this->find($id);
        $client->update($data);
    }

    public function deleteClient($id)
    {
        $client = $this->find($id);
        $client->delete();
    }

    public function multipleDeleteClient($data)
    {
        $pricing = $this->whereIn('id', $data);
        $pricing->delete();
    }
}
