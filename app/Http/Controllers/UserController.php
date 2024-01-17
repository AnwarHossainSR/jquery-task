<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function saveUser(UserRequest $request)
    {

        try {
            // Save the user to the database
            User::create($request->validated());

            return response()->json(['success' => true, 'message' => 'User saved successfully'], 200);
        } catch (\Throwable $th) {
            //return error message with 500 status
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }
}
