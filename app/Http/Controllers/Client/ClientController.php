<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ClientRequest;

class ClientController extends Controller
{
    function __construct()
    {
        $this->client = new Client;
    }


    public function index()
    {
        try {
            $clients = $this->client->displayClients();
            return response()->json(['data' => $clients]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch clients: ' . $e->getMessage()], 500);
        }
    }

    public function save(ClientRequest $request)
    {
        try {
            $this->client->addClient($request->validated());
            return response()->json(['message' => 'Successfully Added a Client', 'status' => true]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to add a client: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        try {
            $client = $this->client->editClient($id);
            return response()->json(['data' => $client]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch client: ' . $e->getMessage()], 500);
        }
    }

    public function update(ClientRequest $request, $id)
    {
        try {
            $this->client->updateClient($request->validated(), $id);
            return response()->json(['message' => 'Successfully Updated a Client', 'status' => true]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to update a client: ' . $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $this->client->deleteClient($id);
            return response()->json(['message' => 'Successfully Deleted a Client', 'status' => true]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete a client: ' . $e->getMessage()], 500);
        }
    }

    public function multipleDelete(Request $request)
    {
        try {
            $this->client->multipleDeleteClient($request->data);
            return response()->json(['message' => 'Successfully Deleted a Client', 'status' => true]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete a client: ' . $e->getMessage()], 500);
        }
    }
}
