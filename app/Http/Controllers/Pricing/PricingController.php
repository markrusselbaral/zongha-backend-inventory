<?php

namespace App\Http\Controllers\Pricing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Pricing\PricingRequest;
use App\Models\Pricing;
use App\Models\Client;
use App\Models\Product;

class PricingController extends Controller
{
    function __construct()
    {
        $this->pricing = new Pricing;
        $this->client = new Client;
        $this->product = new Product;
    }

    public function index(Request $request)
    {
        try {
            $pricings = $this->pricing->displayPricings($request->search);
            return response()->json(['data' => $pricings]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch pricings: ' . $e->getMessage()], 500);
        }
    }

    public function create()
    {
        try {
            $clients = $this->client->allClients();
            $products = $this->product->allProducts();
            return response()->json(['clients' => $clients, 'products' => $products]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch data: ' . $e->getMessage()], 500);
        }
        
    }

    public function save(PricingRequest $request)
    {
        try {
            $this->pricing->addPricing($request->validated());
            return response()->json(['message' => 'Successfully Added a Pricing', 'status' => true]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to add a pricing: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        try {
            $pricing = $this->pricing->editPricing($id);
            return response()->json(['data' => $pricing]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch pricing: ' . $e->getMessage()], 500);
        }
    }

    public function update(PricingRequest $request, $id)
    {
        try {
            $this->pricing->updatePricing($request->validated(), $id);
            return response()->json(['message' => 'Successfully Updated a Pricing', 'status' => true]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to update a pricing: ' . $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $this->pricing->deletePricing($id);
            return response()->json(['message' => 'Successfully Deleted a Pricing', 'status' => true]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete a pricing: ' . $e->getMessage()], 500);
        }
    }

    public function multipleDelete(Request $request)
    {
        try {
            $this->pricing->multipleDeletePricing($request->data);
            return response()->json(['message' => 'Successfully Deleted a Pricing', 'status' => true]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete a pricing: ' . $e->getMessage()], 500);
        }
    }
}
