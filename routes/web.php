<?php

use App\Http\Controllers\clinicController1;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PetController1;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TreatmentController1;
use App\Http\Controllers\VetController1;
use App\Http\Controllers\userController1;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* * /
Route::get('/', function () {
    $poasts=Post::all();
    return view('home', ['ponsts' => $poasts]); //used to be welcome, i changed it >:)
});
/ * */

/* */
Route::get('/', function () {
    //$poasts=Post::where('user_id', auth()->id())->get();
    $pets=[];
    if(auth()->check()){
        $pets=auth()->user()->usersCoolPets()->latest()->get();
    }
    return view('home', ['pets'=>$pets]);
});
/* */
Route::get('/home', function () {
    return view('home');
});

Route::post('/register', [userController1::class, 'register']);
Route::post('/logout', [userController1::class, 'logout']);
Route::post('/login', [userController1::class, 'login']);

//vetlogin
Route::get('/vet', function () {
     return view('vethome'); 
    });
Route::post('/loginvet', [VetController1::class, 'login']);//->name('login');
Route::post('/logoutvet', [VetController1::class, 'logout']);//->name('logout');

//clinicaVeterinaria
Route::get('/clinica', function () {
    $vets=[];
    if(auth()->guard('veterinaria')->check()){
        $vets=auth()->guard('veterinaria')->user()->clinicaVets()->latest()->get();
    }
     return view('vetdashboard', ['vets'=>$vets]); 
    });
Route::post('/loginclinic', [clinicController1::class, 'login']);
Route::post('/registerclinic', [clinicController1::class, 'register']);
Route::post('/clinilogout', [clinicController1::class, 'logout']);
//vets desde clinica dashboard
Route::post('/register-vet', [VetController1::class, 'register']);
Route::get('edit-vet/{vet}', [VetController1::class, 'showEditScreen']);
Route::put('edit-vet/{vet}', [VetController1::class, 'editTheVet']);
Route::delete('delete-vet/{vet}', [VetController1::class, 'deleteVet']);

//pets
Route::post('/register-pet', [PetController1::class, 'registerPet']);
Route::post('/petvisibility/{pet}', [PetController1::class, 'visibility']);
Route::get('edit-pet/{pet}', [PetController1::class, 'showEditScreen']);
Route::put('edit-pet/{pet}', [PetController1::class, 'editThePet']);
Route::delete('delete-pet/{pet}', [PetController1::class, 'deletePet']);

//Tratamientos
Route::post('/register-trat', [TreatmentController1::class, 'createTratamiento']);//->middleware('check.pet.visible');
Route::get('edit-trat/{trat}', [TreatmentController1::class, 'showEditScreen']);//->middleware('check.pet.visible');
Route::put('edit-trat/{trat}', [TreatmentController1::class, 'editTratamiento']);//->middleware('check.pet.visible');
Route::delete('delete-trat/{trat}', [TreatmentController1::class, 'deleteTratamiento']);//->middleware('check.pet.visible');


//blogpost routes
Route::post('/create-post', [PostController::class, 'createPost']);
Route::get('edit-post/{post}', [PostController::class, 'showEditScreen']);
Route::put('edit-post/{post}', [PostController::class, 'editThePost']);
Route::delete('delete-post/{post}', [PostController::class, 'deletePost']);



//EOF