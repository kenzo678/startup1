<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use App\Models\Pet_tratamiento;
use Illuminate\Support\Facades\Log;

class TreatmentController1 extends Controller
{
    public function createTratamiento(Request $req) {
        $incomingFields = $req->validate([
            'titulo' => 'required',
            'desc' => 'required',
            'pet_id'=>'required'
        ]);

        $incomingFields['titulo'] = strip_tags($incomingFields['titulo']);
        $incomingFields['desc'] = strip_tags($incomingFields['desc']);
        Pet_tratamiento::create($incomingFields);
        return redirect('/');
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
        return redirect('/');

        }
    }

    public function deleteTratamiento(Pet_tratamiento $trt) {
        $pet = Pet::find($trt->pet_id);
        if(auth()->user()->id !== $pet->user_id){
            return redirect('/');
        } else {
            $trt->delete();
            return redirect('/');
        }
    }
}
