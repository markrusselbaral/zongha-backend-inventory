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

    public function displayClients()
    {
        return $this->paginate(5);
    }

    public function addClient($data)
    {
        return $this->create($data);
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
}
