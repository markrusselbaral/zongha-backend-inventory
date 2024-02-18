<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

class ProductController extends Controller
{
    function __construct(){
        $this->product = new Product();
    }

    public function index(Request $request, $id)
    {
        try {
            $search = $request->input('name');

            $query = Product::with(['item', 'warehouse']);

            if ($id != 0) {
                $query->where('warehouse_id', $id);
            }

            if ($search) {
                $query->whereHas('item', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%');
                });
            }

            $data = $query->paginate(10)->withQueryString();
            $sumQuantity = $query->sum('quantity');
            $soldOutCount = $query->where('quantity', 0)->count();

            return response()->json(['data' => $data, 'sum_quantity' => $sumQuantity, 'sold_out_count' => $soldOutCount, 'status' => true], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error fetching data: ' . $th->getMessage()], 500);
        }
    }

    public function save(ProductRequest $request) {
        try {
            $this->product->saveProduct($request->validated());
            return response()->json(['status' => true, 'message' => 'Product added successfully.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error adding this product: ' . $th->getMessage()], 500);
        }
    }

    public function edit($id) {
        try {
            $data = $this->product->editProduct($id);
            return response()->json(['data' => $data, 'status' => true], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Product not found: ' . $th->getMessage()], 404);
        }
    }


    public function update(UpdateProductRequest $request, $id){
        try {
            $this->product->updateProduct($request->validated(), $id);
            return response()->json(['status' => true, 'message' => 'Product updated successfully.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error updating this product: ' . $th->getMessage()], 500);
        }
    }

    public function delete($id) {
        try {
            $this->product->deleteProduct($id);
            return response()->json(['status' => true, 'success' => 'Product deleted successfully.'],200);
        } catch (\Throwable $th) {
            return response()->json(['status' => true, 'error' => 'Error deleting this product!'],500);
        }
    }
}
