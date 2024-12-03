<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Maintenances;
use App\Models\Maintenanceschedules;
use App\Models\Schedules;
use App\Models\Schedulesdates;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SchedulesdatesController extends Controller
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
    /*public function create(Request $request)
    {
        try {
            // Obtén el ID del horario de mantenimiento desde el request
            $schedule_id = $request->get('schedule_id');

            // Verifica que el ID sea válido
            if (!$schedule_id) {
                return response()->json(['message' => 'El ID de horario de mantenimiento no existe'], 409);
            }

            // Busca el horario de mantenimiento relacionado
            $schedule = Maintenanceschedules::findOrFail($schedule_id);
            // Obtén el maintenance_id relacionado
            $maintenance_id = $schedule->maintenance_id;

            // Mapear el valor del día (Lunes, Martes, etc.) a un número (1 = Lunes, ..., 7 = Domingo)
            $dayMapping = [
                'Lunes' => 1,
                'Martes' => 2,
                'Miércoles' => 3,
                'Jueves' => 4,
                'Viernes' => 5,
                'Sábado' => 6,
                'Domingo' => 7,
            ];

            $dayNumber = $dayMapping[$schedule->name] ?? null;

            if (!$dayNumber) {
                return response()->json(['message' => 'El nombre del día no es válido.'], 409);
            }



            // Devuelve la vista para crear una nueva fecha, pasando el horario
            return view('admin.schedulesdates.create', compact('schedule_id', 'maintenance_id'));
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error en el registro: ' . $th->getMessage()], 500);
        }
    }*/

    public function create(Request $request)
    {
        try {
            // Obtén el ID del horario de mantenimiento desde el request
            $schedule_id = $request->get('schedule_id');

            // Verifica que el ID sea válido
            if (!$schedule_id) {
                return response()->json(['message' => 'El ID de horario de mantenimiento no existe'], 409);
            }

            // Busca el horario de mantenimiento relacionado
            $schedule = Maintenanceschedules::findOrFail($schedule_id);
            // Obtén el maintenance_id relacionado
            $maintenance_id = $schedule->maintenance_id;

            // Obtener las fechas de inicio y fin del mantenimiento
            $maintenance = Maintenances::findOrFail($maintenance_id);
            $startdate = Carbon::parse($maintenance->startdate); // Convertir a Carbon
            $lastdate = Carbon::parse($maintenance->lastdate);

            // Mapear el valor del día (Lunes, Martes, etc.) a un número (1 = Lunes, ..., 7 = Domingo)
            $dayMapping = [
                'Lunes' => 1,
                'Martes' => 2,
                'Miércoles' => 3,
                'Jueves' => 4,
                'Viernes' => 5,
                'Sábado' => 6,
                'Domingo' => 7,
            ];

            $dayNumber = $dayMapping[$schedule->name] ?? null;

            if (!$dayNumber) {
                return response()->json(['message' => 'El nombre del día no es válido.'], 409);
            }

            // Devuelve la vista para crear una nueva fecha, pasando el horario, fechas y el día permitido
            return view('admin.schedulesdates.create', compact('schedule_id', 'maintenance_id', 'startdate', 'lastdate', 'dayNumber'));
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
            $logo = '';
            $schedule_id = $request->input('schedule_id');

            // Obtener el horario de mantenimiento relacionado
            $schedule = Maintenanceschedules::findOrFail($schedule_id);
            // Validar que el mantenimiento relacionado exista
            $maintenance_id = $schedule->maintenance_id;

            if (!$maintenance_id) {
                return response()->json(['message' => 'No se pudo encontrar el ID de mantenimiento relacionado.'], 404);
            }

            // Obtener el número del día correspondiente al nombre (Lunes, Martes, etc.)
            $dayMapping = [
                'Lunes' => 1,
                'Martes' => 2,
                'Miércoles' => 3,
                'Jueves' => 4,
                'Viernes' => 5,
                'Sábado' => 6,
                'Domingo' => 7,
            ];
            $expectedDay = $dayMapping[$schedule->name] ?? null;

            if (!$expectedDay) {
                return response()->json(['message' => 'El día de la semana especificado no es válido.'], 400);
            }

            // Validar que la fecha seleccionada sea del día permitido
            $selectedDate = Carbon::parse($request->date);
            if ($selectedDate->dayOfWeekIso != $expectedDay) {
                return response()->json([
                    'message' => 'La fecha seleccionada no corresponde al día permitido (' . $schedule->name . ').',
                ], 400);
            }

            // Validación personalizada: evitar fechas duplicadas para el mismo horario
            $existingDate = Schedulesdates::where('date', $request->date)
                ->where('maintenanceschedules_id', $schedule_id)
                ->where('maintenances_id', $maintenance_id)
                ->exists();

            if ($existingDate) {
                return response()->json([
                    'message' => 'Ya existe una asignación de fecha para este horario y esta fecha.',
                ], 409);
            }

            $request->validate([
                "name" => "unique:brands",
            ]);

            if ($request->logo != '') {
                $image = $request->file('logo')->store('public/scheduledates_logo');
                $logo = Storage::url($image);
            }

            // Crear el registro en la tabla schedulesdates
            Schedulesdates::create([
                'maintenanceschedules_id' => $schedule_id,
                'maintenances_id' => $maintenance_id,
                'date' => $request->date,
                'logo' => $logo,
                'description' => $request->description,
                'maintenancestatus_id' => 1, // Valor predeterminado
            ]);

            return response()->json(['message' => 'Fecha de horario registrada exitosamente.'], 200);
        } catch (\Throwable $th) {
            // Registrar el error en el log
            Log::error('Error en store: ' . $th->getMessage());

            return response()->json([
                'message' => 'Error en el registro: ' . $th->getMessage(),
            ], 500);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $scheduleId)
    {
        try {
            // Encuentra el registro de schedulesdates por ID
            $date = Schedulesdates::findOrFail($scheduleId);

            // Verifica si el estado ya está en 2 (finalizado)
            if ($date->maintenancestatus_id == 2) {
                return response()->json([
                    'message' => 'La fecha ya está finalizada.',
                ], 400); // Puedes usar el código de estado 400 para indicar un conflicto de solicitud.
            }

            // Actualiza el estado del mantenimiento
            $date->maintenancestatus_id = 2; // Cambia el estado a finalizado
            $date->save();

            return response()->json(['message' => 'Fecha finalizada exitosamente.'], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error en la actualización: ' . $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
