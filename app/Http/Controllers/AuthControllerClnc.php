<?php

namespace App\Http\Controllers;

use App\Models\Veterinaria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    public function registerc() {

        $request = request();

        // Retrieve only the specified fields from the request
        $fieldds = $request->only(['id', 'nombre', 'telf', 'email', 'direccion','tipo','password']);
    
        // Validate the incoming fields
        $incomingFields = Validator::make($fieldds, [
            'id' => ['required', 'min:3', 'max:20'],
            'nombre' => ['required', 'min:3', 'max:30', Rule::unique('veterinaria', 'nombre')],
            'telf' => ['required', 'min:3', 'max:12'],
            'email' => ['max:50', 'email', Rule::unique('veterinaria', 'email')],
            'direccion'=>['required', 'max:100'],
            'tipo'=>['required'],
            'password' => ['required', 'min:8', 'max:25']
        ])->validate();

        Log::info('Clnc validation passed (API)', $incomingFields);

        $incomingFields['password'] = bcrypt($incomingFields['password']);
        
        foreach ($incomingFields as $key => $value) {
            $incomingFields[$key] = strip_tags($value);
        }
        
        $clnc = Veterinaria::create($incomingFields);
        Log::info('Clnc created via API', ['clncapi' => $clnc]);

        return response()->json([
            'veterinaria creado via API' => $clnc->nombre,
        ]);
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
