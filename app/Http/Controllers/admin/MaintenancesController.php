<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Maintenances;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MaintenancesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $maintenances = Maintenances::all()->map(function ($maintenance) {
            $maintenance->startdate = Carbon::parse($maintenance->startdate)->format('d/m/Y');
            $maintenance->lastdate = Carbon::parse($maintenance->lastdate)->format('d/m/Y');
            return $maintenance;
        });

        if ($request->ajax()) {

            return DataTables::of($maintenances)
                ->addColumn('actions', function ($maintenance) {
                    return '
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bars"></i>                        
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <button class="dropdown-item btnEditar" id="' . $maintenance->id . '"><i class="fas fa-edit"></i>  Editar</button>
                                <form action="' . route('admin.maintenances.destroy', $maintenance->id) . '" method="POST" class="frmEliminar d-inline">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button type="submit" class="dropdown-item"><i class="fas fa-trash"></i> Eliminar</button>
                                </form>
                            </div>
                        </div>';
                })
                ->addColumn('schedules', function ($maintenance) {
                    return '<button class="btn btn-success btn-sm btnSchedules" data-id="' . $maintenance->id . '">
                    <i class="far fa-calendar-alt"></i></button>';
                })
                ->rawColumns(['schedules', 'actions'])  // Declarar columnas que contienen HTML
                ->make(true);
        } else {
            return view('admin.maintenances.index', compact('maintenances'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.maintenances.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                "name" => "required|unique:maintenances",
                "startdate" => "required|date",
                "lastdate" => "required|date",
            ], [
                "name.unique" => "El nombre del mantenimiento ya está registrado.",
            ]);

            if ($request->lastdate <= $request->startdate) {
                return response()->json(['message' => 'La fecha final debe ser mayor a la fecha de inicio.'], 409);
            }

            $existing = Maintenances::where(function ($query) use ($request) {
                $query->where('startdate', '<', $request->lastdate)
                    ->where('lastdate', '>', $request->startdate);
            })->exists();

            if ($existing) {
                return response()->json(['message' => 'El mantenimiento ingresado se solapa con un mantenimiento existente'], 400);
            }

            Maintenances::create($request->all());
            return response()->json(['message' => 'Mantenimiento registrado'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error en el registro: ' . $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $maintenance = Maintenances::find($id);

        $maintenance->startdate = Carbon::parse($maintenance->startdate)->format('d/m/Y');
        $maintenance->lastdate = Carbon::parse($maintenance->lastdate)->format('d/m/Y');

        $schedules = DB::select('CALL sp_schedules(1,' . $id . ')');

        $schedules = collect($schedules)->map(function ($schedule) {
            $schedule->time_start = Carbon::parse($schedule->time_start)->format('H:i');
            $schedule->time_end = Carbon::parse($schedule->time_end)->format('H:i');
            return $schedule;
        });

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
                                <button class="dropdown-item btnDates" id="' . $schedule->id . '"><i class="fas fa-calendar-plus"></i>  Fechas</button>
                                <form action="' . route('admin.maintenanceschedules.destroy', $schedule->id) . '" method="POST" class="frmEliminar d-inline">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button type="submit" class="dropdown-item"><i class="fas fa-trash"></i> Eliminar</button>
                                </form>
                            </div>
                        </div>';
                })
                ->rawColumns(['actions'])  // Declarar columnas que contienen HTML
                ->make(true);
        } else {
            return view('admin.maintenances.show', compact('maintenance', 'schedules'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $maintenance = Maintenances::find($id);
        return view('admin.maintenances.edit', compact('maintenance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $request->validate([
                "name" => " unique:maintenances,name," . $id,
                "startdate" => "required|date",
                "lastdate" => "required|date",
            ], [
                "name.unique" => "El nombre del mantenimiento ya está registrado.",
            ]);

            if ($request->lastdate <= $request->startdate) {
                return response()->json(['message' => 'La fecha final debe ser mayor a la fecha de inicio.'], 409);
            }

            $existing = Maintenances::where(function ($query) use ($request, $id) {
                $query->where('startdate', '<', $request->lastdate)
                    ->where('lastdate', '>', $request->startdate)
                    ->where('id', '!=', $id);
            })->exists();

            if ($existing) {
                return response()->json(['message' => 'El mantenimiento ingresado se solapa con un mantenimiento existente'], 400);
            }

            $maintenance = Maintenances::findOrFail($id);
            $maintenance->update($request->all());

            return response()->json(['message' => 'Mantenimiento actualizado'], 200);
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
            $maintenance = Maintenances::find($id);
            $maintenance->delete();
            return response()->json(['message' => 'Mantenimiento eliminado'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al eliminar el mantenimiento porque tiene horarios asignados'], 500);
        }
    }
}
