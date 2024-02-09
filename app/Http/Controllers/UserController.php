<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Helper\ArrayHelper;

class UserController extends Controller
{
    function __construct()
    {
        $this->user = new User;
        $this->arrayHelper = new ArrayHelper;
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

    public function save(UserRequest $request)
    {
        try {
            $this->user->addUser($request->validated());
            return response()->json(['message' => 'Successfully Added a User', 'status' => true]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to add a user: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $user = $this->user->editUser($id);
        return response()->json(['data' => $user]);
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $this->user->updateUser($this->arrayHelper->user($request), $id);
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
