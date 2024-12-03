<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'schedule_id',
        'vehicle_id',
        'route_id',
        'programming_date',
        'start_time',
        'end_time',
        'status'
    ];

    protected $dates = [
        'programming_date'
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedules::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function route()
    {
        return $this->belongsTo(Routes::class);
    }
}
