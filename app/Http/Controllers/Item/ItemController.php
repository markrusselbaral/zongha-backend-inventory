<?php

namespace App\Http\Controllers\Item;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\FileUploader;

class ItemController extends Controller
{
    use FileUploader;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $items = Item::with('category')
                ->whereNull('deleted_at')
                ->paginate(10);

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

         $productCode = 'Item-' . $timestamp . $randomString;

         return $productCode;
     }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:'.Item::class,
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $validatedData['product_code'] = $this->generateProductCode();

            $validatedData['image'] = $this->uploadFile($request, 'image', 'public/images');

            // dd($validatedData);

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
        try {
            $item = Item::with('category')->findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $item,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Item not found!',
            ], 404);
        }
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

     public function update(Request $request, $id)
     {
         try {
             $itemId = (int)$id;

             $item = Item::findOrFail($itemId);

             $validatedData = $request->validate([
                 'name' => 'required|string|max:255|unique:items,name,' . $itemId,
                 'category_id' => 'required|exists:categories,id',
                 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
             ]);

             if ($request->hasFile('image')) {

                 if ($item->image) {
                     Storage::disk('public')->delete('images/' . $item->image);
                 }

                 $imagePath = $this->uploadFile($request, 'image', 'public/images');
                 $validatedData['image'] = $imagePath;
             } else {
                 unset($validatedData['image']);
             }

             unset($validatedData['product_code']);

             $item->update($validatedData);

             return response()->json([
                 'status' => true,
                 'data' => $item,
                 'message' => 'Item updated successfully',
             ], 200);
         } catch (\Throwable $th) {
             return response()->json([
                 'error' => 'Error updating item!',
             ], 400);
         }
     }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = Item::findOrFail($id);

            $item->delete(); // Soft delete

            return response()->json([
                'status' => true,
                'message' => 'Item soft deleted successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error deleting item!',
            ]);
        }
    }


    public function showRetrieve()
    {
        try {
            $softDeletedItems = Item::onlyTrashed()->get();

            return response()->json([
                'status' => true,
                'data' => $softDeletedItems,
                'message' => 'Soft-deleted items retrieved successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error retrieving soft-deleted items!',
            ]);
        }
    }

    public function restore(string $id)
    {
        try {
            $item = Item::withTrashed()->findOrFail($id);

            if ($item->trashed()) {
                $item->restore();
                return response()->json([
                    'status' => true,
                    'message' => 'Item restored successfully',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Item is not soft-deleted',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error restoring item!',
            ]);
        }
    }

}
