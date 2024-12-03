<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenances extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function maintenanceschedules()
    {
        return $this->hasMany(Maintenanceschedules::class, 'maintenances_id');
    }
}
