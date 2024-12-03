<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenanceschedules extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function maintenances()
    {
        return $this->belongsTo(Maintenances::class, 'maintenances_id');
    }
}
