<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    
    protected $guarded=[];

    public function occupants()
    {
        return $this->hasMany(Vehicleocuppants::class, 'vehicle_id');
    }
    
}
