<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Usertype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $users = DB::select('CALL sp_users()');

        if ($request->ajax()) {

            return DataTables::of($users)
                ->addColumn('actions', function ($user) {
                    return '
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bars"></i>                        
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <button class="dropdown-item btnEditar" id="' . $user->id . '"><i class="fas fa-edit"></i>  Editar</button>
                                <form action="' . route('admin.users.destroy', $user->id) . '" method="POST" class="frmEliminar d-inline">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button type="submit" class="dropdown-item"><i class="fas fa-trash"></i> Eliminar</button>
                                </form>
                            </div>
                        </div>';
                })
                ->rawColumns(['actions'])  // Declarar columnas que contienen HTML
                ->make(true);
        } else {
            return view('admin.users.index', compact('users'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usertype = Usertype::pluck('name', 'id');

        return view('admin.users.create', compact('usertype'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $logo = '';

            $request->validate([
                "dni" => "nullable|unique:users|regex:/^\d{8}$/",
                "name" => "nullable|unique:users",
                "license" => "nullable|unique:users|regex:/^[A-Z]{1}[0-9]{8}$/",
                "email" => "nullable|unique:users",
                "password" => "required|min:8",
                "birthdate" => [
                    "nullable",
                    "date",
                    "before_or_equal:" . \Carbon\Carbon::now()->toDateString(),
                    "before:" . \Carbon\Carbon::now()->subYears(18)->toDateString(),
                ]
            ], [
                "dni.unique" => "El numero de dni ya ha sido registrado.",
                "dni.regex" => "El formato del dni es inválido. Debe ser como '12345678'",
                "birthdate.before_or_equal" => "La fecha de nacimiento no puede ser una fecha futura.",
                "birthdate.before" => "Debe ser mayor de 18 años para registrarse.",
                "name.unique" => "El nombre ya ha sido registrado.",
                "license.unique" => "La licencia ya ha sido registrada.",
                "license.regex" => "El formato de la licencia es inválido. Debe ser como 'Q12345678'",
                "email.unique" => "El correo ya ha sido registrado.",
                "password.min" => "La contraseña debe tener al menos 8 caracteres."
            ]);


            $d = $request->password;
            $request['password'] = Hash::make($d);
            User::create($request->all());
            return response()->json(['message' => 'Personal registrado'], 200);
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
        $user = User::find($id);

        $usertype = Usertype::pluck('name', 'id');
        return view('admin.users.edit', compact('user', 'usertype'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $request->validate([
                "dni" => "nullable|unique:users,dni," . $id . "|regex:/^\d{8}$/",
                "name" => "nullable|unique:users,name," . $id,
                "license" => "nullable|unique:users,license," . $id . "|regex:/^[A-Z]{1}[0-9]{8}$/",
                "email" => "nullable|unique:users,email," . $id,
                "password" => "nullable|min:8," . $id,
                "birthdate" => [
                    "nullable",
                    "date",
                    "before_or_equal:" . \Carbon\Carbon::now()->toDateString(),
                    "before:" . \Carbon\Carbon::now()->subYears(18)->toDateString(),
                ]
            ], [
                "dni.unique" => "El número de DNI ya ha sido registrado.",
                "dni.regex" => "El formato del DNI es inválido. Debe ser como '12345678'.",
                "name.unique" => "El nombre ya ha sido registrado.",
                "birthdate.date" => "La fecha de nacimiento debe ser una fecha válida.",
                "birthdate.before_or_equal" => "La fecha de nacimiento no puede ser una fecha futura.",
                "birthdate.before" => "Debe se mayor de 18 años para registrarse.",
                "license.unique" => "La licencia ya ha sido registrada.",
                "license.regex" => "El formato de la licencia es inválido. Debe ser como 'Q12345678'.",
                "email.unique" => "El correo electrónico ya ha sido registrado.",
                "password.min" => "La contraseña debe tener al menos 8 caracteres."
            ]);

            $user = User::find($id);

            // Verificar si el usuario está asignado a un vehículo con 'status' activo (1)
            $vehicleAssignment = DB::table('vehicleocuppants')
                ->where('user_id', $id)
                ->where('status', 1) // Verifica que la asignación esté activa
                ->first();

            // Si el usuario tiene una asignación activa, no se puede cambiar el 'usertype_id'
            if ($vehicleAssignment) {
                if ($request->has('usertype_id') && $request->usertype_id != $user->usertype_id) {
                    return response()->json(['message' => 'No se puede cambiar tipo de usuario, ya que tiene una asignación activa.'], 400);
                }
            }

            $data = $request->except(['password']); // Excluir el campo password por defecto

            // Verificar si se envió una nueva contraseña
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }
            $user->update($data);

            return response()->json(['message' => 'Personal actualizado'], 200);
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
            $user = User::find($id);

            // Verifica si el usuario tiene asignación activa en un vehículo
            $vehicleAssignment = DB::table('vehicleocuppants')
                ->where('user_id', $id)
                ->where('status', 1) // Verifica que la asignación esté activa
                ->first();

            // Si tiene asignación activa, no se puede eliminar
            if ($vehicleAssignment) {
                return response()->json(['message' => 'No se puede eliminar el usuario ya que tiene una asignación activa en un vehículo.'], 409);
            }

            if ($user->usertype_id == 1) {
                return response()->json(['message' => 'Este usuario tipo "Administrador" no se puede eliminar'], 400);
            }

            $user->delete();

            return response()->json(['message' => 'Usuario eliminado'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al eliminar el tipo: ' . $th->getMessage()], 500);
        }
    }
}
