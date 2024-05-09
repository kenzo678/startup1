<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        $token = Auth::guard('api')->attempt($credentials);
        if($token === false){
            return response()->json(['error' => 'No autorizado'], 401);
        }
        return $this->respondWithToken($token);
    }

    public function register() {

        $request = request();

        // Retrieve only the specified fields from the request
        $fieldds = $request->only(['id', 'nombre', 'email', 'telf', 'password']);
    
        // Validate the incoming fields
        $incomingFields = Validator::make($fieldds, [
            'id' => ['required', 'numeric', Rule::unique('users', 'id')],
            'nombre' => ['required', 'min:3', 'max:10'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'telf' => ['required', 'numeric', 'digits_between:6,12'],
            'password' => ['required', 'min:8'],
        ])->validate();

        Log::info('User validation passed (API)', $incomingFields);

        $incomingFields['password'] = bcrypt($incomingFields['password']);
        
        foreach ($incomingFields as $key => $value) {
            $incomingFields[$key] = strip_tags($value);
        }
        
        $user = User::create($incomingFields);
        Log::info('User created via API', ['userapi' => $user]);

        return response()->json([
            'usuario crado via API' => $user->nombre,
        ]);
    }

    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json(['mensaje' => 'Cierre de sesión exitoso']);
    }

    public function refresh()
    {
    return $this->respondWithToken(Auth::guard('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            //'expires_in' => auth()->factory()->getTTL() * 60
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

}
