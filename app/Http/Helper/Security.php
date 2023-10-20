<?php

namespace App\Http\Helper;

use App\Models\User;

class Security
{
    static function sessionCheck($x)
    {
        $user = User::where('token', $x)->count('token');

        // check token
        if ($user > 0) {
            return true;
        }

        return false;
    }
}