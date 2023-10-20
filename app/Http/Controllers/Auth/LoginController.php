<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data   = $request->only(['xemail', 'xpassword']);
        $user  = User::where('email', $data['xemail'])->first();

        $generateToken = $this->generateToken();

        if (Hash::check($data['xpassword'], $user->password)) {

            $user->token = $generateToken;

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Successfuly logged in',
                'data' => $user
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to login',
        ]);
    }

    public function generateToken()
    {
        $token  = md5(date('Y-m-d H:i:s', time()) . 'xry&lAn' . date('i:s', time())) . rand(1000, 9999);

        return $token;
    }
}