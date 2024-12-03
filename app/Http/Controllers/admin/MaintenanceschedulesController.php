<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Maintenances;
use App\Models\Maintenanceschedules;
use App\Models\Maintenancetypes;
use App\Models\Schedulesdates;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Vehicleocuppants;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class MaintenanceschedulesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create(Request $request)
    {
        try {
            $maintenance_id = $request->get('maintenance_id');
            $maintenance = Maintenances::findOrFail($maintenance_id);
            $vehicle_id = Vehicle::where('status', '!=', 0)->pluck('name', 'id');
            $vehicle_id_selected = $request->get('vehicle_id');

            // validacion usertype_id = 2
            $user_id = [];
            if ($vehicle_id_selected) {
                $user_id = User::join('vehicleocuppants', 'vehicleocuppants.user_id', '=', 'users.id')
                    ->where('vehicleocuppants.vehicle_id', $vehicle_id_selected)
                    ->where('users.usertype_id', 2)
                    ->pluck('users.name', 'users.id');
            }

            if (!$vehicle_id_selected) {
                $user_id = [];
            }

            // el tipo de mantenimiento
            $maintenancetype_id = Maintenancetypes::pluck('name', 'id');

            return view('admin.maintenanceschedules.create', compact('vehicle_id', 'user_id', 'maintenancetype_id', 'maintenance_id'));
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error en el registro: ' . $th->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        try {

            $maintenance_id = $request->input('maintenance_id');

            $request->validate([
                'maintenance_id' => 'required|exists:maintenances,id',
                'name' => 'required|string',
                'time_start' => 'required|date_format:H:i',
                'time_end' => 'required|date_format:H:i|after:time_start',
            ], [
                'time_end.after' => 'La hora final debe ser posterior a la hora de inicio.',
            ]);

            // Validación solapamiento de horarios
            $existingSchedule = Maintenanceschedules::where(function ($query) use ($request) {
                $query->where('time_start', '<', $request->time_end)
                    ->where('time_end', '>', $request->time_start);
            })->where('name', $request->name)
                ->where('vehicle_id', $request->vehicle_id)
                ->where('maintenance_id', $request->maintenance_id)
                ->exists();

            if ($existingSchedule) {
                return response()->json(['message' => 'El horario de mantenimiento se solapa con un horario existente'], 409);
            }

            // Obtener todos los datos del request y agregar los valores predeterminados
            $data = $request->all();

            $data['maintenance_id'] = $maintenance_id;  // Asignar 'maintenance_id' recibido en el request

            // Registrar la asignación con los datos combinados
            Maintenanceschedules::create($data);

            return response()->json(['message' => 'Horario registrado exitosamente.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error en el registro: ' . $th->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $schedule = DB::select('CALL sp_schedules(2,' . $id . ')')[0];
        $schedule->time_start = Carbon::parse($schedule->time_start)->format('H:i');
        $schedule->time_end = Carbon::parse($schedule->time_end)->format('H:i');
        $schedule->startdate = Carbon::parse($schedule->startdate)->format('d/m/Y');
        $schedule->lastdate = Carbon::parse($schedule->lastdate)->format('d/m/Y');

        $dates = DB::select('CALL sp_dates(' . $id . ')');
        $dates = collect($dates)->map(function ($date) {
            $date->date = Carbon::parse($date->date)->format('d/m/Y');
            return $date;
        });

        if ($request->ajax()) {

            return DataTables::of($dates)
                ->addColumn('logo', function ($date) {
                    return '<img src="' . ($date->logo == '' ? asset('storage/scheduledates_logo/no_image.png') : asset($date->logo)) . '" width="100px" height="70px" class="card">';
                })
                ->addColumn('actions', function ($date) {
                    return '      
                    <form action="' . route('admin.schedulesdates.update', $date->id) . '" method="POST" class="frmBaja d-inline">
                        ' . csrf_field() . method_field('PATCH') . '
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-minus-circle"></i></button>
                    </form>';
                })
                ->rawColumns(['logo', 'actions'])  // Declarar columnas que contienen HTML
                ->make(true);
        } else {
            return view('admin.maintenanceschedules.show', compact('schedule', 'dates'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $maintenanceschedule = Maintenanceschedules::find($id);
        $maintenance_id = $maintenanceschedule->maintenance_id;
        $vehicle_id = Vehicle::where('status', '!=', 0)->pluck('name', 'id');
        $user_id = User::pluck('name', 'id');
        $maintenancetype_id = Maintenancetypes::pluck('name', 'id');

        // Obtén el primer vehículo
        $firstVehicle = Vehicle::first();

        $user_id = [];
        if ($firstVehicle) {
            $user_id = User::whereIn('id', function ($query) use ($firstVehicle) {
                $query->select('user_id')
                    ->from('vehicleocuppants')
                    ->where('vehicle_id', $firstVehicle->id);
            })
                ->pluck('name', 'id');
        }

        return view('admin.maintenanceschedules.edit', compact('maintenanceschedule', 'maintenance_id', 'vehicle_id', 'user_id', 'maintenancetype_id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        try {
            $maintenance_id = $request->input('maintenance_id');

            $request->validate([
                'maintenance_id' => 'required|exists:maintenances,id',
                'name' => 'required|string',
                'time_start' => 'required|date_format:H:i',
                'time_end' => 'required|date_format:H:i|after:time_start',
            ], [
                'time_end.after' => 'La hora final debe ser posterior a la hora de inicio.',
            ]);

            // Validación solapamiento de horarios
            $existingSchedule = Maintenanceschedules::where(function ($query) use ($request, $id) {
                $query->where('time_start', '<', $request->time_end)
                    ->where('time_end', '>', $request->time_start)
                    ->where('id', '!=', $id); // Excluir el horario actual
            })->where('name', $request->name)
                ->where('vehicle_id', $request->vehicle_id)
                ->where('maintenance_id', $request->maintenance_id)
                ->exists();

            if ($existingSchedule) {
                return response()->json(['message' => 'El horario de mantenimiento se solapa con un horario existente'], 409);
            }
            $userId = $request->user_id;
            if ($userId === null) {
                $request->merge(['user_id' => null]);
            }

            $data = $request->all();  // Obtén todos los datos enviados por el formulario

            $data['maintenance_id'] = $maintenance_id;  // Asignar 'maintenance_id' recibido en el request

            $maintenanceschedule = Maintenanceschedules::findOrFail($id);

            $maintenanceschedule->update($data);

            return response()->json(['message' => 'Horario actualizado exitosamente.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error en la actualización: ' . $th->getMessage()], 500);
        }
    }

    /*
     */
    public function destroy(string $id)
    {
        try {
            $maintenanceschedule = Maintenanceschedules::find($id);
            $maintenanceschedule->delete();
            return response()->json(['message' => 'Horario de mantenimiento eliminado'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al eliminar el horario porque tiene fechas asignadas'], 500);
        }
    }

    public function ocuppantsByVehicle(Request $request, string $vehicle_id)
    {
        try {
            // Filtra los ocupantes con usertype_id = 2
            $occupants = Vehicleocuppants::where('vehicle_id', $vehicle_id)
                ->join('users', 'vehicleocuppants.user_id', '=', 'users.id')
                ->where('users.usertype_id', 2)
                ->select('users.id', 'users.name')
                ->get();

            if ($occupants->isEmpty()) {
                return response()->json([]);
            }

            return response()->json($occupants, 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error interno del servidor.'], 500);
        }
    }
}
