<?php

namespace App\Http\Controllers;

use App\Models\Vet;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;

class VetController1 extends Controller
{
    //public function __construct() {
    //    $this->middleware('auth')->except('showEditScreen', 'editTheVet', 'deleteVet');
    //    $this->middleware('check.vet')->only('showEditScreen',/* 'editTheVet',*/ 'deleteVet','login','logout');
    //}
    
    public function index() { //para la API
        return Vet::all();
    }

    public function register(Request $request) {
        try {
            $incomingFields = $request->validate([
                'veterinaria_id' => ['required', 'min:1', 'max:30'],
                'id'=>['required'],
                'nombre' => ['required', 'min:3', 'max:30'],
                'email' => ['max:50', 'email', Rule::unique('vets', 'email')],
                'password' => ['required', 'min:8']
            ]);

            Log::info('Validation passed', $incomingFields);

            $incomingFields['password'] = bcrypt($incomingFields['password']);

            foreach ($incomingFields as $key => $value) {
                $incomingFields[$key] = strip_tags($value);
            }

            $vet = Vet::create($incomingFields);
            Log::info('Vet created', ['vet' => $vet]);

            return redirect('/clinica')->with('success', 'Vet registered successfully.');
        } catch (\Exception $e) {
            Log::error('Vet registration failed', ['error' => $e->getMessage()]);

            return back()->withInput()->withErrors('Clinic registration failed. Please try again.')->withInput();
            
            }
    }

    public function logout() {
        auth()->guard('vet')->logout();
        return redirect('/vet');
    }

    public function login(Request $request) {
        $incomingFields = $request->validate([
            'CI' => ['required'],
            'loginpassword' => ['required']
        ]);

        Log::info('Validation passed', $incomingFields);

        try {
            if(auth()->guard('vet')->attempt(['id' => $incomingFields['CI'], 'password' => $incomingFields['loginpassword']])) {
                $request->session()->regenerate();
                Log::info('Vet logged in', ['vet' => auth()->guard('vet')]);
                return redirect('/vet');
            }
        } catch (\Throwable $e) {
            Log::error('Error occurred during login attempt', ['error' => $e->getMessage()]);
            return redirect('/vet');
        }
    
        Log::warning('Login attempt failed', ['codigo' => $incomingFields['CI']]);
        return redirect('/vet');
    }  

    public function showEditScreen(Vet $vet) {
        return view('edit-vet', ['vet'=> $vet]);
    }

    public function editTheVet(Vet $vet, Request $req) {

        $incomingFields = $req->validate([
            'nombre' => ['required', 'min:3', 'max:30'],
            'email' => ['required','max:50', 'email'],
        ]);

        $incomingFields['nombre'] = strip_tags($incomingFields['nombre']);
        $incomingFields['email'] = strip_tags($incomingFields['email']);
        $vet->update($incomingFields);
        return redirect('/clinica');

    }

    public function deleteVet(Vet $vet) {
        $vet->delete();
        return redirect('/clinica');
    }

    public function showTrats()
    {
        try {
            $vet = Auth::guard('apivets')->user();
            
            // Check if the user is authenticated
            if (!$vet) {
                return response()->json(['error' => 'Doctor(a) no autenticada'], 401);
            }
    
            // Check if the relationship exists
            if (!$vet->clinicaVets) {
                return response()->json(['error' => 'No se encontraron tratamientos/visitas'], 404);
            }
    
            return Auth::guard('apivets')->user()->vetTrats()->latest()->get();
        } catch (JWTException $e) {
            return response()->json(['error' => 'Doctor(a) no autenticada'], 401);
        }
        
    }
}
