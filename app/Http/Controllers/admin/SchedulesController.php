<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Schedules;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SchedulesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $schedules = Schedules::all();

        if ($request->ajax()) {

            return DataTables::of($schedules)
                ->addColumn('actions', function ($schedule) {
                    return '
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bars"></i>                        
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <button class="dropdown-item btnEditar" id="' . $schedule->id . '"><i class="fas fa-edit"></i>  Editar</button>
                                <form action="' . route('admin.schedules.destroy', $schedule->id) . '" method="POST" class="frmEliminar d-inline">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button type="submit" class="dropdown-item"><i class="fas fa-trash"></i> Eliminar</button>
                                </form>
                            </div>
                        </div>';
                })
                ->rawColumns(['actions'])  // Declarar columnas que contienen HTML
                ->make(true);
        } else {
            return view('admin.schedules.index', compact('schedules'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.schedules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                "name" => "required|unique:schedules",
                "time_start" => "required|date_format:H:i",
                "time_end" => "required|date_format:H:i"
            ], [
                "name.unique" => "El nombre del horario ya está registrado.",
            ]);

            // Validación personalizada: evitar solapamiento de horarios
            $existingSchedule = Schedules::where(function ($query) use ($request) {
                $query->where('time_start', '<', $request->time_end)
                    ->where('time_end', '>', $request->time_start);
            })->exists();

            if ($existingSchedule) {
                return response()->json(['message' => 'El horario ingresado se superpone con un horario existente'], 400);
            }

            // Creación del horario
            Schedules::create($request->all());
            return response()->json(['message' => 'Horario registrado'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error en el registro: ' . $th->getMessage()], 500);
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
        $schedule = Schedules::find($id);
        return view('admin.schedules.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate(
                [
                    "name" => "unique:schedules,name," . $id,
                    "time_start" => "required|date_format:H:i",
                    "time_end" => "required|date_format:H:i"
                ],
                [
                    "name.unique" => "El nombre del horario ya está registrado."
                ]
            );

            // Validación personalizada: evitar solapamiento de horarios
            $existingSchedule = Schedules::where(function ($query) use ($request, $id) {
                $query->where('time_start', '<', $request->time_end)
                    ->where('time_end', '>', $request->time_start)
                    ->where('id', '!=', $id); // Excluir el horario actual
            })->exists();

            if ($existingSchedule) {
                return response()->json(['message' => 'El horario ingresado se superpone con un horario existente'], 400);
            }

            // Actualización del horario
            $schedule = Schedules::findOrFail($id);
            $schedule->update($request->all());

            return response()->json(['message' => 'Horario actualizado'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error actualizar: ' . $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $schedule = Schedules::find($id);
            $schedule->delete();
            return response()->json(['message' => 'Horario eliminado'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al eliminar el tipo'], 500);
        }
    }
}
