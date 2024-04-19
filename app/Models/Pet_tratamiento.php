<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet_tratamiento extends Model
{
    use HasFactory;

    protected $fillable = [ 'pet_id', 'veterinarian_id' ,'title', 'description', 'treatment_date', 'checkup_date']; 

    public function pet(){
        return $this->belongsTo(Pet::class, 'pet_id');
    }

    public function vet(){
        return $this->belongsTo(Vet::class, 'veterinarian_id');
    }
}
