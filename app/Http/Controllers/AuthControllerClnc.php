<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthControllerClnc extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:apiclnc', ['except' => ['loginc']]);
    }

    // clinica veterinaria

    public function loginc()
    {
        $credentials = request(['ID', 'password']);

        $token = Auth::guard('apiclnc')->attempt($credentials);
        if($token === false){
            return response()->json(['error' => 'No autorizado'], 401);
        }
        return $this->respondWithTokenc($token);
    }

    public function mec()
    {
        return response()->json(Auth::guard('apiclnc')->user());
    }

    public function logoutc()
    {
        Auth::guard('apiclnc')->logout();

        return response()->json(['mensaje' => 'Cierre de sesión de veterinaria exitoso']);
    }

    public function refreshc()
    {
    return $this->respondWithTokenc(Auth::guard('apiclnc')->refresh());
    }

    protected function respondWithTokenc($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            //'expires_in' => auth()->factory()->getTTL() * 60
            'expires_in' => auth('apiclnc')->factory()->getTTL() * 60,
            'clinic' => 'yeag :3'
        ]);
    }

}
