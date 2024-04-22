<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PetController1 extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except('showEditScreen', 'editThePet', 'deletePet');
        $this->middleware('check.pet')->only('showEditScreen', 'editThePet', 'deletePet');
    }

    public function registerPet(Request $req) {
        $incomingFields = $req->validate([
            'nombre' => 'required',
            'fecha_nac'=>'required',
            'especie' => 'required',
            'sexo' => 'required|in:m,f',
            'peso' => 'required|numeric',
            'observaciones' => '',
        ]);

        $incomingFields['nombre'] = strip_tags($incomingFields['nombre']);
        $incomingFields['especie'] = strip_tags($incomingFields['especie']);
        $incomingFields['observaciones'] = strip_tags($incomingFields['observaciones']);
        $incomingFields['visible'] = 0;
        $incomingFields['user_id'] = auth()->id();
        Pet::create($incomingFields);
        return redirect('/');
    }

    public function visibility(Pet $pet) {
        $v = ($pet['visible']) ? 0 : 1;
        $pet->update(['visible'=> $v]);
        Log::info("Visibility changed for pet $pet", ['pets visibility' => $pet['visible']]);
        return redirect('/');
    }

    public function showEditScreen(Pet $pet) {
        return view('edit-pet', ['pet'=> $pet]);
    }

    public function editThePet(Pet $pet, Request $req) {
        $incomingFields = $req->validate([
            'peso'=>'required|numeric',
            'observaciones' => '',
        ]);
        $incomingFields['observaciones'] = strip_tags($incomingFields['observaciones']);
        $pet->update($incomingFields);
        return redirect('/');
    }

    public function deletePet(Pet $pet) {
        $pet->delete();
        return redirect('/');
    }
}

