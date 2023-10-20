<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helper\Security;
use Illuminate\Http\Request;

class SessioncheckController extends Controller
{
    public function tokenCheck(Request $request)
    {
        $data = $request->all();

        $sessionCheck = Security::sessionCheck($data['x']);

        // check token
        if ($sessionCheck == true) {
            return response()->json([
                'success' => true,
                'message' => 'Token still active'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Token invalid',
        ]);
    }
}
