<?php

namespace App\Http\Controllers\Warehouse;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class WarehouseController extends Controller
{
    function __construct() {
        $this->warehouse = new Warehouse();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $data = $this->warehouse->allWarehouse($request->search);
            return response()->json(['data' => $data, 'status' => true], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error fetching data: ' . $th->getMessage()], 500);
        }
    }

    public function tabWarehouse() {
        try {
            $data = $this->warehouse->tabWarehouse();
            return response()->json(['data' => $data, 'status' => true], 200);
        } catch (\Throwable $th) {
            return response()->json(['error', 'Error fetching data: ' . $th->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'location' => 'required|string|max:200'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors(), 'status' => true ], 422);
        }

        try {
            $data = [
                'name' => $request->input('name'),
                'location' => $request->input('location'),
            ];
            $this->warehouse->storeWarehouse($data);
            return response()->json(['status' => true, 'message' => 'Warehouse added successfully.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Failed adding this product: ' . $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $data = $this->warehouse->showWarehouse($id);
            return response()->json(['status' => true, 'data' => $data], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Warehouse not found: ' . $th->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'location' => 'required|string|max:100'
        ]);
        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        try {
            $data = [
                'name' => $request->input('name'),
                'location' => $request->input('location'),
            ];
            $this->warehouse->updateWarehouse($id, $data);
            return response()->json(['status' => true, 'message' => 'Warehouse updated successfully.']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error updating this warehouse: ' . $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->warehouse->deleteWarehouse($id);
            return response()->json(['status' => true, 'message' => 'Warehouse deleted successfully.']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Error deleting warehouse:' . $th->getMessage()], 500);
        }
    }

    public function multipleDelete(Request $request)
    {
        try {
            $ids = $request->input('ids');

            $this->warehouse->multipleDelete($ids);

            return response()->json([
                'status' => true,
                'message' => 'Categories deleted successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error deleting categories!',
            ]);
        }
    }
}
