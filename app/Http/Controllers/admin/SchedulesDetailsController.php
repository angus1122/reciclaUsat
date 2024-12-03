<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Routes;
use App\Models\ScheduleDetail;
use App\Models\Schedules;
use App\Models\Vehicle;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class SchedulesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ScheduleDetail::select(
            'schedule_details.id',
            'v.name as vehicle',
            'r.name as route',
            'schedule_details.programming_date',
            'schedule_details.start_time',
            'schedule_details.end_time',
            'schedule_details.status',
            'schedule_details.vehicle_id',
            'schedule_details.route_id'
        )
        ->join('vehicles as v', 'schedule_details.vehicle_id', '=', 'v.id')
        ->join('routes as r', 'schedule_details.route_id', '=', 'r.id');

        if ($request->ajax()) {
            if ($request->filled('vehicle_id')) {
                $query->where('schedule_details.vehicle_id', $request->vehicle_id);
            }
            if ($request->filled('route_id')) {
                $query->where('schedule_details.route_id', $request->route_id);
            }
            if ($request->filled('start_date')) {
                $query->where('schedule_details.programming_date', '>=', $request->start_date);
            }
            if ($request->filled('end_date')) {
                $query->where('schedule_details.programming_date', '<=', $request->end_date);
            }

            return DataTables::of($query)
                ->addColumn('checkbox', function($detail) {
                    return '<input type="checkbox" class="schedule-checkbox" value="'.$detail->id.'">';
                })
                ->addColumn('actions', function ($detail) {
                    return '
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bars"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <button class="dropdown-item btnEditar" id="' . $detail->id . '"><i class="fas fa-edit"></i> Editar</button>
                                <form action="' . route('admin.schedulesdetails.destroy', $detail->id) . '" method="POST" class="frmEliminar d-inline">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button type="submit" class="dropdown-item"><i class="fas fa-trash"></i> Eliminar</button>
                                </form>
                            </div>
                        </div>';
                })
                ->rawColumns(['checkbox', 'actions'])
                ->make(true);
        }

        $vehicles = Vehicle::pluck('name', 'id');
        $routes = Routes::pluck('name', 'id');
        return view('admin.schedulesdetails.index', compact('vehicles', 'routes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vehicles = Vehicle::pluck('name', 'id');
        $routes = Routes::pluck('name', 'id');
        return view('admin.schedulesdetails.create', compact('vehicles', 'routes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'vehicle_id' => 'required|exists:vehicles,id',
                'route_id' => 'required|exists:routes,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'start_time' => 'required',
                'end_time' => 'required|after:start_time',
            ]);

            $schedule = Schedules::create([
                'name' => "Programación " . Carbon::now()->format('Y-m-d'),
                'time_start' => $request->start_time,
                'time_end' => $request->end_time,
                'description' => "Programación automática"
            ]);

            $period = CarbonPeriod::create($request->start_date, $request->end_date);
            $dates = collect($period)->map(function ($date) {
                return $date->format('Y-m-d');
            });

            if ($request->skip_weekends) {
                $dates = $dates->filter(function ($date) {
                    return !in_array(Carbon::parse($date)->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY]);
                });
            }

            if ($request->alternate_days) {
                $dates = $dates->filter(function ($date, $key) {
                    return $key % 2 === 0;
                });
            }

            foreach ($dates as $date) {
                try {
                    ScheduleDetail::create([
                        'schedule_id' => $schedule->id,
                        'vehicle_id' => $request->vehicle_id,
                        'route_id' => $request->route_id,
                        'programming_date' => $date,
                        'start_time' => $request->start_time,
                        'end_time' => $request->end_time
                    ]);
                } catch (\Exception $e) {
                    continue;
                }
            }

            return response()->json(['message' => 'Programación creada exitosamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error en el registro: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $scheduleDetail = ScheduleDetail::findOrFail($id);
        $vehicles = Vehicle::pluck('name', 'id');
        $routes = Routes::pluck('name', 'id');
        return view('admin.schedulesdetails.edit', compact('scheduleDetail', 'vehicles', 'routes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $scheduleDetail = ScheduleDetail::findOrFail($id);
            
            $request->validate([
                'vehicle_id' => 'required|exists:vehicles,id',
                'route_id' => 'required|exists:routes,id',
                'start_time' => 'required',
                'end_time' => 'required|after:start_time',
                'status' => 'required|in:active,inactive'
            ]);

            $scheduleDetail->update($request->all());
            
            return response()->json(['message' => 'Programación actualizada exitosamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error en la actualización: ' . $e->getMessage()], 500);
        }
    }

    public function bulkUpdate(Request $request)
    {
        try {
            $selectedIds = json_decode($request->selected_ids);
            
            // Validar que hay IDs seleccionados
            if (empty($selectedIds)) {
                return response()->json(['message' => 'No se seleccionaron registros para actualizar'], 422);
            }

            // Filtrar solo los campos que se van a actualizar
            $updateData = array_filter($request->only([
                'vehicle_id',
                'start_time',
                'end_time',
                'status'
            ]), function($value) {
                return $value !== null && $value !== '';
            });

            // Verificar si hay datos para actualizar
            if (empty($updateData)) {
                return response()->json(['message' => 'No hay datos para actualizar'], 422);
            }

            // Realizar la actualización
            $updated = ScheduleDetail::whereIn('id', $selectedIds)
                ->update($updateData);

            if ($updated) {
                return response()->json(['message' => 'Programaciones actualizadas exitosamente'], 200);
            } else {
                return response()->json(['message' => 'No se encontraron registros para actualizar'], 404);
            }

        } catch (\Exception $e) {
            Log::error('Error en la actualización masiva: ' . $e->getMessage());
            return response()->json(['message' => 'Error en la actualización: ' . $e->getMessage()], 500);
        }
    }


    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $scheduleDetail = ScheduleDetail::findOrFail($id);
            
            // Verificar si el detalle pertenece a un schedule
            if ($scheduleDetail->schedule_id) {
                $schedule = Schedules::find($scheduleDetail->schedule_id);
                
                // Si es el último detalle del schedule, eliminar también el schedule
                $remainingDetails = ScheduleDetail::where('schedule_id', $scheduleDetail->schedule_id)
                    ->where('id', '!=', $id)
                    ->count();
                    
                if ($remainingDetails === 0 && $schedule) {
                    $schedule->delete();
                }
            }
            
            $scheduleDetail->delete();
            
            if (request()->ajax()) {
                return response()->json([
                    'message' => 'Programación eliminada exitosamente'
                ], 200);
            }
            
            return redirect()->route('admin.schedulesdetails.index')
                ->with('success', 'Programación eliminada exitosamente');
                
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'message' => 'Error al eliminar la programación: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('admin.schedulesdetails.index')
                ->with('error', 'Error al eliminar la programación: ' . $e->getMessage());
        }
    }
}
