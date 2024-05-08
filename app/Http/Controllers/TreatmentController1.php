<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use App\Models\Pet_tratamiento;
use Illuminate\Support\Facades\Log;

class TreatmentController1 extends Controller
{
    public function index() { //para la API
        return Pet_tratamiento::all();
    }

    public function createTratamiento(Request $req) {
        $incomingFields = $req->validate([
            'pet_id'=>'required',
            'veterinarian_id'=>'required',
            'title' => 'required',
            'description' => 'required',
            'treatment_date' => 'required',
            'checkup_date' => 'required'
        ]);

        Log::info('Validation passed', $incomingFields);

        $pet = Pet::findOrFail($incomingFields['pet_id']);
        if ($pet->visible !== 1) {
            Log::info('No se puede crear el tratamiento. Mascota no ha sido puesta visible por el dueno.');
            return back()->withInput()->withErrors(['message' => 'No se puede crear el tratamiento. Mascota no ha sido puesta visible por el dueno.']);
        }

        foreach ($incomingFields as $key => $value) {
            $incomingFields[$key] = strip_tags($value);
        }
        
        Pet_tratamiento::create($incomingFields);
        return redirect('/vet');
    }

    public function showEditScreen(Pet_tratamiento $trt) {
        //use policy or middleware to 
        //protect this view from unauthorized users
        //for a better, safer method
        /*
        Log::info('Pet:', ['pet' => $trt['pet_id']]);
        $pet = Pet::find($trt['pet_id']);
        if(auth()->user()->id !== $pet->user_id){
            return view('edit-trat', ['trt'=> $trt]);
        } else {
            return redirect('/');
        }
        */
        return view('edit-trat', ['trt' => $trt]);
    }

    public function editTratamiento(Pet_tratamiento $trt, Request $req) {
        $pet = Pet::find($trt->pet_id);
        if(auth()->user()->id !== $pet->user_id){
        return redirect('/');
        } else {

        $incomingFields = $req->validate([
            'titulo' => 'required',
            'desc' => 'required'
        ]);

        $incomingFields['titulo'] = strip_tags($incomingFields['titulo']);
        $incomingFields['desc'] = strip_tags($incomingFields['desc']);
        $trt->update($incomingFields);
        return redirect('/vet');

        }
    }

    public function deleteTratamiento(Pet_tratamiento $trt) {
        $pet = Pet::find($trt->pet_id);
        if(auth()->user()->id !== $pet->user_id){
            return redirect('/vet');
        } else {
            $trt->delete();
            return redirect('/vet');
        }
    }
}
