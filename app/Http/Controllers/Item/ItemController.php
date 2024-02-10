<?php

namespace App\Http\Controllers\Item;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    function __construct(){
        $this->items = new Item();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $items = Item::with('category')->paginate(10);

            return response()->json([
                'status' => true,
                'data' => $items,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error fetching items!',
            ]);
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

    public function generateProductCode()
    {
        $timestamp = now()->format('YmdHis');
        $randomString = Str::random(5);

        $productCode = $timestamp . $randomString;

        return $productCode;
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $validatedData['product_code'] = $this->generateProductCode();

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $validatedData['image'] = $imagePath;
            }

            $item = Item::create($validatedData);

            return response()->json([
                'status' => true,
                'data' => $item,
                'message' => 'Item stored successfully',
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error storing item!',
            ]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
