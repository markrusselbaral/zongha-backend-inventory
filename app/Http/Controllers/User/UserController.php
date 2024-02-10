<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserSaveRequest;
use App\Http\Requests\User\UserUpdateRequest;

class UserController extends Controller
{
    function __construct()
    {
        $this->user = new User;
    }

    public function index()
    {
        try {
            $users = $this->user->displayUser();
            return response()->json(['data' => $users]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch users: ' . $e->getMessage()], 500);
        }
    }

    public function save(UserSaveRequest $request)
    {
        try {
            $this->user->addUser($request->validated(), $request->role);
            return response()->json(['message' => 'Successfully Added a User', 'status' => true]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to add a user: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        try {
            $user = $this->user->editUser($id);
            return response()->json(['data' => $user]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to fetch user: ' . $e->getMessage()], 500);
        }
    }

    public function update(UserUpdateRequest $request, $id)
    {
        try {
            $this->user->updateUser($request->validated(), $id, $request->role);
            return response()->json(['message' => 'Successfully Updated a User', 'status' => true]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to update a user: ' . $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $this->user->deleteUser($id);
            return response()->json(['message' => 'Successfully Deleted a User', 'status' => true]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete a user: ' . $e->getMessage()], 500);
        }
    }
}
