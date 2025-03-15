<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function user(Request $request)
    {
        return $request->user();
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update($request->all());

            return Response::json(['message' => 'User updated successfully', 'user' => $user]);
        } catch (\Exception $e) {
            return Response::json(['error' => 'User update failed', 'message' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return Response::json(['message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            return Response::json(['error' => 'User deletion failed', 'message' => $e->getMessage()], 500);
        }
    }

    public function getAllUsers()
    {
        try {
            $users = User::all();
            return Response::json(['users' => $users]);
        } catch (\Exception $e) {
            return Response::json(['error' => 'Failed to retrieve users', 'message' => $e->getMessage()], 500);
        }
    }
}
