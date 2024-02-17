<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    function __construct() {
        $this->category = new Category();
    }

    public function index(Request $request)
    {
        try {
            $search = $request->input('name');

            if (!empty($search)) {
                $data = Category::where('name', 'like', '%' . $search . '%')->get();
            } else {
                $data = $this->category->allCategory();
            }

            return response()->json([
                'categories' => $data,
                'status' => 200,
                'message' => 'Success fetching the data.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Error fetching the data!'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name,except,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => 422,
            ], 422);
        }
        $data = [
            'name' => $request->input('name'),
        ];
        try {
            $add = $this->category->addCategory($data);
            return response()->json([
                'data' => $add,
                'status' => 200,
                'message' => 'Category added successfully.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Error adding this category!'
            ], 500);
        }

    }

    public function show(string $id)
    {
        try {
            $data = $this->category->editCategory($id);
            return response()->json([
                'data' => $data,
                'status' => 200,
                'message' => 'Category found.'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'Category not found!'
            ], 404);
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => 422,
            ], 422);
        }

        try {
            $data = ['name' => $request->input('name')];
            $update = $this->category->updateCategory($id, $data);

            return response()->json([
                'data' => $update,
                'status' => 200,
                'message' => 'Category updated successfully.',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'Error updating the category: ' . $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $item = Category::findOrFail($id);

            $item->delete(); // Soft delete

            return response()->json([
                'status' => true,
                'message' => 'Category deleted successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error deleting category!',
            ]);
        }
    }

    public function multipleDelete(Request $request)
    {
        try {
            $ids = $request->input('ids');

            Category::whereIn('id', $ids)->delete();

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


    public function showRetrieve()
    {
        try {
            $data = Category::onlyTrashed()->get();

            return response()->json([
                'status' => true,
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error retrieving category!',
            ]);
        }
    }

    public function restore(string $id)
    {
        try {
            $item = Category::withTrashed()->findOrFail($id);

            if ($item->trashed()) {
                $item->restore();
                return response()->json([
                    'status' => true,
                    'message' => 'Category restored successfully',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Category is not soft-deleted',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error restoring category!',
            ]);
        }
    }
}
