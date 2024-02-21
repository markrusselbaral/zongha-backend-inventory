<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Client;
use App\Models\Product;
use App\Http\Requests\Purchase\PurchaseRequest;

class PurchaseController extends Controller
{
    function __construct()
    {
        $this->purchase = new Purchase;
        $this->client = new Client;
        $this->product = new Product;
    }
    public function index(Request $request)
    {
        try {
            $purchases = $this->purchase->displayPurchases($request->search);
            return response()->json(['data' => $purchases]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch purchases: ' . $e->getMessage()], 500);
        }
    }

    public function productsAndClients()
    {
        try {
            $products = $this->product->allProducts();
            $clients = $this->client->allClients();
            return response()->json(['products' => $products, 'clients' => $clients]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch products and clients: ' . $e->getMessage()], 500);
        }
    }

    public function create(Request $request)
    {
        try {
            $purchase = $this->purchase->createPurchase($request->client_id, $request->product_id);
            return response()->json(['data' => $purchase]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch products and clients: ' . $e->getMessage()], 500);
        }
        
    }

    public function save(PurchaseRequest $request)
    {
        $data = $request->validated();

        $client = Client::find($data['client_id']);
        if (!$client) {
            $data['client_id'] = $this->client->addClient([
                'name' => $request->name,
                'tin_name' => $request->tin_name,
                'tin_number' => $request->tin_number,
                'type' => 'Retail'
            ]);
        }

        if (!$this->purchase->addPurchase($data)) {
            return response()->json(['message' => 'Cannot deduct quantity. Insufficient quantity available.', 'status' => false]);
        } else {
            return response()->json(['message' => 'Successfully Added a Purchase.', 'status' => true]);
        }
    }


    public function edit($id)
    { 
        try {
            $purchase = $this->purchase->editPurchase($id);
            return response()->json(['data' => $purchase]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch purchase: ' . $e->getMessage()], 500);
        }
    }

    public function update(PurchaseRequest $request, $id)
    {
        $this->purchase->updatePurchase($request->validated(), $id);
        return response()->json(['message' => 'Successfully Updated a Purchase', 'status' => true]);
    }

    public function delete($id)
    {
        try {
            $this->purchase->deletePurchase($id);
            return response()->json(['message' => 'Successfully Deleted a Purchase', 'status' => true]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete a purchase: ' . $e->getMessage()], 500);
        }
    }

    public function multipleDelete(Request $request)
    {
        try {
            $this->purchase->multipleDeletePurchase($request->data);
            return response()->json(['message' => 'Successfully Deleted a Purchase', 'status' => true]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete a purchase: ' . $e->getMessage()], 500);
        }
    }

    

    
}
