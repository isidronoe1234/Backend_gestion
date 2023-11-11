<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //Función para agregar un usuario
    public function login(Request $request) {
        $credentials = $request->only('NUE', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json($user, 200);
        } else {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }
    }
}
