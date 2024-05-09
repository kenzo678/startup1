<?php

namespace App\Http\Controllers;

use App\Models\Vet;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    public function registerv() {

        $request = request();

        // Retrieve only the specified fields from the request
        $fieldds = $request->only(['veterinaria_id','id', 'nombre', 'email', 'password']);
    
        // Validate the incoming fields
        $incomingFields = Validator::make($fieldds, [
            'veterinaria_id' => ['required', 'min:1', 'max:30'],
            'id'=>['required'],
            'nombre' => ['required', 'min:3', 'max:30'],
            'email' => ['max:50', 'email', Rule::unique('vets', 'email')],
            'password' => ['required', 'min:8']
        ])->validate();

        Log::info('Vet validation passed (API)', $incomingFields);

        $incomingFields['password'] = bcrypt($incomingFields['password']);
        
        foreach ($incomingFields as $key => $value) {
            $incomingFields[$key] = strip_tags($value);
        }
        
        $clnc = Vet::create($incomingFields);
        Log::info('Vet created via API', ['vetapi' => $clnc]);

        return response()->json([
            'Doctor(a) Veterinari@ creado via API' => $clnc->nombre,
        ]);
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
