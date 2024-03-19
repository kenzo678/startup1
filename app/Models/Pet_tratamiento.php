<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet_tratamiento extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'desc', 'pet_id']; 

    public function petTrat(){
        return $this->belongsTo(Pet::class, 'pet_id');
    }
}
