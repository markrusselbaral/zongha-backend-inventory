<?php

namespace App\Http\Controllers\Product;

use App\Models\Item;
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
            $soldOut = 0;
            $quantity = 0;
            $search = $request->input('search');

            $query = Product::join('items', 'items.id', '=', 'products.item_id')
                ->select('items.*', 'products.*')
                ->with('warehouse');

            if ($id != 0) {
                $query->where('warehouse_id', $id);
            }

            $query->when($search, function ($query, $search) {
                    $query->where('items.name', 'like', '%' . $search . '%');
                });

            $data = $query->paginate(10)->withQueryString();

            if ($id == 0) {
                $soldOut = Product::where('quantity', 0)->count();
                $quantity = Product::sum('quantity');
            } else {
                $quantity = Product::where('warehouse_id', $id)->sum('quantity');
                $soldOut = Product::where('quantity', 0)->where('warehouse_id', $id)->count();
            }

            

            return response()->json(['data' => $data, 'status' => true, 'soldout' => $soldOut, 'quantity' => $quantity], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error fetching data: ' . $th->getMessage()], 500);
        }
    }

    public function create() {
        try {
            $data = Item::all();
            return response()->json(['data' => $data, 'status' => true], 200);
        } catch (\Throwable $th) {
            return response()->json(['error', 'Error fetching item : ' .$th->getMessage()], 500);
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

    public function multipleDelete(Request $request)
    {
        try {
            $ids = $request->input('ids');

            Product::whereIn('id', $ids)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Product deleted successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error deleting product!' . $th->getMessage()
            ], 500);
        }
    }
}
