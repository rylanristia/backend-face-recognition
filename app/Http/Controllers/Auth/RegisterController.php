<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->all();

        $user = User::where('email', $data['email'])->count('email');

        // check email
        if ($user > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Failed, email has been registered'
            ]);
        }

        $dataset = [
            'name' => $data['xname'],
            'email' => $data['xemail'],
            'password' => Hash::make($data['xpassword']),
            'token' => md5(date('Y-m-d H:i:s', time()) . 'xry&lAn' . date('i:s', time())) . rand(1000, 9999)
        ];

        User::create($dataset);

        return response()->json([
            'success' => true,
            'message' => 'Account successfuly register'
        ]);
    }
}