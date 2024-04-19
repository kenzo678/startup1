<?php

namespace App\Http\Controllers;

use App\Models\Veterinaria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class clinicController1 extends Controller
{
    public function register(Request $request) {
        try {
            $incomingFields = $request->validate([
                'codigo' => ['required', 'min:3', 'max:20'],
                'nombre' => ['required', 'min:3', 'max:30', Rule::unique('veterinaria', 'nombre')],
                'telf' => ['required', 'min:3', 'max:12'],
                'email' => ['max:50', 'email', Rule::unique('veterinaria', 'email')],
                'direccion'=>['required', 'max:100'],
                'password' => ['required', 'min:8', 'max:25']
            ]);

            Log::info('Validation passed', $incomingFields);

            $incomingFields['password'] = bcrypt($incomingFields['password']);

            $vete = Veterinaria::create($incomingFields);
            Log::info('Vet created', ['veterinaria' => $vete]);

            //auth('vet')->login($vet);
            auth()->guard('veterinaria')->login($vete);
            Log::info('Clinica logged in successfully', ['veteinaria' => $vete]);

            return redirect('/clinica')->with('success', 'Clinica registered successfully.');
        } catch (\Throwable $e) {
            Log::error('Clinica registration failed', ['error' => $e->getMessage()]);

            return back()->withErrors('Clinic registration failed. Please try again.')->withInput();
        }
    }

    public function logout() {
        auth()->guard('veterinaria')->logout();
        return redirect('/clinica');
    }

    public function login(Request $request) {
        $incomingFields = $request->validate([
            'codigo' => ['required'],
            'loginpassword' => ['required']
        ]);
    
        try {
            if(auth()->guard('veterinaria')->attempt(['codigo' => $incomingFields['codigo'], 'password' => $incomingFields['loginpassword']])) {
                $request->session()->regenerate();
                return redirect('/clinica');
            }
        } catch (\Throwable $e) {
            Log::error('Error occurred during login attempt', ['error' => $e->getMessage()]);
        }
    
        Log::warning('Login attempt failed', ['codigo' => $incomingFields['codigo']]);
    
        return back()->withErrors([
            'codigo' => 'The provided credentials do not match our records.',
        ]);
    }
    
}
