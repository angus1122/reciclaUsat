<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Usertype;
use App\Models\Vehicle;
use App\Models\Vehicleocuppants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class VehicleocuppantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $vehicleoccupants = DB::select('CALL sp_assignmenthistorical(1)');

        if ($request->ajax()) {
            return DataTables::of($vehicleoccupants)->make(true);
        } else {
            return view('admin.ocuppant.index', compact('vehicleoccupants'));
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

    public function store(Request $request)
    {
        try {
            $vehicle_id = $request->input('vehicle_id');
            $dni = $request->user_id;

            $occupantSQL = DB::table('users')->select('id', 'usertype_id', 'name')->where('dni', $dni)->first();
            if (!$occupantSQL) {
                return response()->json(['message' => 'Usuario no encontrado.'], 404);
            }

            $name = $occupantSQL->name;
            $id = $occupantSQL->id;
            $usertype_id = $occupantSQL->usertype_id;

            // Verifica si ya está asignado al mismo vehículo
            if (Vehicleocuppants::where('user_id', $id)
                ->where('status', '1')
                ->where('vehicle_id', $vehicle_id)
                ->exists()
            ) {
                return response()->json(['status' => 'warning', 'message' => 'El usuario ' . $name . ' ya está asignado a este vehículo.'], 409);
            }

            // Verifica si el usuario ya está asignado a otro vehículo
            $existingOccupant = Vehicleocuppants::where('user_id', $id)->where('status', '1')->first();

            if ($existingOccupant) {
                return response()->json([
                    'status' => 'warning',
                    'message' => 'El usuario ' . $name . ' ya está asignado a otro vehículo.',
                    'user_id' => $id,
                    'vehicle_id' => $vehicle_id,
                    'usertype_id' => $usertype_id,
                ], 400);
            }

            // Verifica la capacidad del vehículo
            $vehicle = Vehicle::find($vehicle_id);
            $occupant_capacity = $vehicle->occupant_capacity;

            $assignedOccupantsCount = Vehicleocuppants::where('vehicle_id', $vehicle_id)
                ->where('status', '1')
                ->count();

            if ($assignedOccupantsCount >= $occupant_capacity) {
                return response()->json(['message' => 'No se puede asignar más ocupantes. La capacidad máxima del vehículo es de ' . $occupant_capacity . ' personas.'], 400);
            }

            if ($usertype_id == 2) {
                $existingDriver = Vehicleocuppants::where('vehicle_id', $vehicle_id)
                    ->where('usertype_id', 2)
                    ->where('status', '1')
                    ->exists();

                if ($existingDriver) {
                    return response()->json([
                        'status' => 'warning',
                        'message' => 'Solo se puede asignar un conductor por vehículo.',
                    ], 409);
                }
            }

            if ($assignedOccupantsCount == $occupant_capacity - 1 && $usertype_id != 2) {
                $driverAssigned = Vehicleocuppants::where('vehicle_id', $vehicle_id)
                    ->where('usertype_id', 2)
                    ->where('status', '1')
                    ->exists();

                if (!$driverAssigned) {
                    return response()->json([
                        'status' => 'warning',
                        'message' => 'Falta asignar un conductor antes de completar la asignación al vehículo.',
                    ], 409);
                }
            }            

            // Registrar la asignación
            Vehicleocuppants::create(['status' => '1', 'vehicle_id' => $vehicle_id, 'user_id' => $id, 'usertype_id' => $usertype_id,]);

            return response()->json(['message' => 'Asignación registrada exitosamente.'], 200);
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
        $vehicle = Vehicle::find($id);
        $user = User::find($id);
        $usertype = Usertype::find($id);

        return view('admin.ocuppant.create', compact('vehicle', 'user', 'usertype'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $ocuppantId)
    {
        // Encontrar el ocupante por ID
        try {
            $ocuppant = Vehicleocuppants::with('vehicle')->findOrFail($ocuppantId);

            if ($ocuppant->vehicle) {
                $ocuppant->status = 0;
                $ocuppant->save();
                return response()->json(['message' => 'Usuario dado de baja exitosamente.'], 200);
            } else {
                return response()->json(['message' => 'No se pudo dar de baja al ocupante.'], 400);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error en la actualización: ' . $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function searchByDni(string $id)
    {
        $validated = Validator::make(['dni' => $id], ['dni' => ['required', 'regex:/^\d{8}$/']]);
        if ($validated->fails()) {return response()->json(['message' => "El formato del DNI es inválido. Debe ser como '12345678'.",], 400);}
        
        $user = User::where('dni', $id)->with('usertype')->first();

        if (!$user) {
            return response()->json(['message' => 'No se encontró usuario.'], 400);
        }

        if ($user->usertype_id == 1 || $user->usertype_id == 4) {
            return response()->json(['message' => 'Los usuarios tipo Administrador y Ciudadano no pueden ser asignados.'], 400);
        }

        if ($user) {
            return response()->json([
                'usertype_id' => $user->usertype ? $user->usertype->name : null,
                'name' => $user->name,
            ]);
        }
    }

    //Funcion de confirmacion antes de dar de baja
    public function confirm(Request $request)
    {
        try {
            $user_id = $request->input('user_id');
            $vehicle_id = $request->input('vehicle_id');
            $usertype_id = $request->input('usertype_id');

            // Verifica la capacidad del vehículo
            $vehicle = Vehicle::findOrFail($vehicle_id);
            $activeOccupants = Vehicleocuppants::where('vehicle_id', $vehicle_id)
                ->where('status', '1')
                ->count();

            if ($activeOccupants >= $vehicle->occupant_capacity) {
                return response()->json([
                    'status' => 'error',
                    'message' => "No se puede asignar más ocupantes. La capacidad máxima del vehículo es de {$vehicle->occupant_capacity} personas."
                ], 400);
            }

            if ($usertype_id == 2) {
                $existingDriver = Vehicleocuppants::where('vehicle_id', $vehicle_id)
                    ->where('usertype_id', 2)
                    ->where('status', '1')
                    ->exists();

                if ($existingDriver) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Solo se puede asignar un conductor por vehículo.'
                    ], 400);
                }
            }

            if ($activeOccupants  == $vehicle->occupant_capacity - 1 && $usertype_id != 2) {
                // Verificar si ya hay un conductor asignado
                $driverAssigned = Vehicleocuppants::where('vehicle_id', $vehicle_id)
                    ->where('usertype_id', 2)  // Verificamos si hay un conductor asignado
                    ->where('status', '1')  // Verificamos que el conductor esté activo
                    ->exists();

                if (!$driverAssigned) {
                    return response()->json([
                        'status' => 'warning',
                        'message' => 'Falta asignar un conductor antes de completar la asignación al vehículo.',
                    ], 409);
                }
            }      

            // Desasigna al usuario del vehículo actual si existe
            Vehicleocuppants::where('user_id', $user_id)
                ->where('status', '1')
                ->update(['status' => '0']);

            // Registra la nueva asignación
            Vehicleocuppants::create([
                'status' => '1',
                'vehicle_id' => $vehicle_id,
                'user_id' => $user_id,
                'usertype_id' => $usertype_id,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Asignación confirmada exitosamente.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'Error al confirmar asignación: ' . $th->getMessage()], 500);
        }
    }
}
