<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Vehiclecolor;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VehiclecolorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $colors = Vehiclecolor::all();
        
        if ($request->ajax()) {

            return DataTables::of($colors)
                ->addColumn('actions', function ($color) {
                    return '
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bars"></i>                
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <button class="dropdown-item btnEditar" id="' . $color->id . '"><i class="fas fa-edit"></i>  Editar</button>
                                <form action="' . route('admin.colors.destroy', $color->id) . '" method="POST" class="frmEliminar d-inline">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button type="submit" class="dropdown-item"><i class="fas fa-trash"></i> Eliminar</button>
                                </form>
                            </div>
                        </div>';
                })
                ->addColumn('color', function ($color) {
                    // Devuelve solo el código de color sin HTML
                    return $color->color_code;
                })
                ->rawColumns(['actions'])  // Declarar columnas que contienen HTML
                ->make(true);
        } else {
            return view('admin.colors.index', compact('colors'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.colors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                "name" => "unique:vehiclecolors",
            ]);

            $code_color = Vehiclecolor::where('color_code', $request->color_code)->first();

            if ($code_color) {
                return response()->json(['message' => 'Color ya existe'], 400);
            }

            Vehiclecolor::create($request->except('hex_code'));

            return response()->json(['message' => 'Color registrado'], 200);
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
    public function edit(Request $request, string $id)
    {
        $colors = Vehiclecolor::find($id);
        return view('admin.colors.edit', compact('colors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $request->validate([
                "name" => "unique:vehiclecolors,name," . $id,
            ]);

            $colors = Vehiclecolor::find($id);

            $code_color = Vehiclecolor::where('color_code', $request->color_code)
                ->where('id', '!=', $id)
                ->first();

            if ($code_color) {
                return response()->json(['message' => 'Color ya existe'], 400);
            }

            $colors->update($request->except('hex_code'));

            return response()->json(['message' => 'Color actualizado'], 200);
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
            $colors = Vehiclecolor::find($id);
            $colors->delete();
            return response()->json(['message' => 'Color eliminado'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al eliminar el color'], 500);
        }
    }
}
