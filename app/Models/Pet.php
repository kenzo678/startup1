<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'especie', 'sexo', 'peso', 'observaciones' , 'user_id']; 

    public function petUser(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function petsCoolTreatments() {
        return $this->hasMany(Tratamiento::class, 'pet_id');
    }
}
