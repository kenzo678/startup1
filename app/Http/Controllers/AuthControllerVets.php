<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthControllerVets extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:apivets', ['except' => ['loginv']]);
    }

    //vets

    public function loginv()
    {
        $credentials = request(['id', 'password']);

        $token = Auth::guard('apivets')->attempt($credentials);
        if($token === false){
            return response()->json(['error' => 'No autorizado'], 401);
        }
        return $this->respondWithTokenv($token);
    }

    public function mev()
    {
        return response()->json(Auth::guard('apivets')->user());
    }

    public function logoutv()
    {
        Auth::guard('apivets')->logout();

        return response()->json(['mensaje' => 'Cierre de sesión de vet exitoso']);
    }

    public function refreshv()
    {
    return $this->respondWithTokenv(Auth::guard('apivets')->refresh());
    }

    protected function respondWithTokenv($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            //'expires_in' => auth()->factory()->getTTL() * 60
            'expires_in' => auth('apivets')->factory()->getTTL() * 60,
            'vet' => 'yeag :3'
        ]);
    }
}
