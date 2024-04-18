<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Veterinaria extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['id','nombre', 'telf', 'email', 'direccion','tipo','password']; 
    
    public function vets() {
        return $this->hasMany(Vet::class, 'clinic_id');
    }
}
