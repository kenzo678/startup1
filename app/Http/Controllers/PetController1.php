<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController1 extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except('showEditScreen', 'editThePet', 'deletePet');
        $this->middleware('check.pet')->only('showEditScreen', 'editThePet', 'deletePet');
    }

    public function registerPet(Request $req) {
        $incomingFields = $req->validate([
            'nombre' => 'required',
            'especie' => 'required',
            'sexo' => 'required|in:m,f',
            'peso' => 'required|numeric',
            'observaciones' => '',
        ]);

        $incomingFields['nombre'] = strip_tags($incomingFields['nombre']);
        $incomingFields['especie'] = strip_tags($incomingFields['especie']);
        $incomingFields['observaciones'] = strip_tags($incomingFields['observaciones']);
        $incomingFields['user_id'] = auth()->id();
        Pet::create($incomingFields);
        return redirect('/');
    }

    public function showEditScreen(Pet $pet) {
        return view('edit-pet', ['pet'=> $pet]);
    }

    public function editThePet(Pet $pet, Request $req) {
        $incomingFields = $req->validate([
            'nombre' => 'required',
            'peso'=>'required|numeric',
            'observaciones' => '',
        ]);

        $incomingFields['nombre'] = strip_tags($incomingFields['nombre']);
        $incomingFields['observaciones'] = strip_tags($incomingFields['observaciones']);
        $pet->update($incomingFields);
        return redirect('/');

    }

    public function deletePet(Pet $pet) {
        $pet->delete();
        return redirect('/');

    }
}

