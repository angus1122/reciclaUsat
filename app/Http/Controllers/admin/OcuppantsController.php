<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class OcuppantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
     public function index(Request $request)
{
    try {
        $vehicleoccupants = DB::select('CALL sp_assignmenthistorical(2)');

        // Verifica si es una solicitud AJAX
        if ($request->ajax()) {
            // Devuelve los datos en formato JSON
            return response()->json([
                'data' => $vehicleoccupants
            ]);
        } else {
            // Si no es Ajax, devuelve la vista con los datos
            return view('admin.ocuppantsactive.index', compact('vehicleoccupants'));
        }
    } catch (\Throwable $th) {
        return response()->json(['message' => 'Error en el registro: ' . $th->getMessage()], 500);
    }
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
