<?php

namespace App\Helper;
use Illuminate\Http\Request;

class ArrayHelper
{
    public function user(Request $request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ];
    }
}
