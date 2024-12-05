<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Brandmodel;
use App\Models\Vehicle;
use App\Models\Vehiclecolor;
use App\Models\Vehicleimage;
use App\Models\Vehicleocuppants;
use App\Models\Vehicletype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vehicles = DB::select('CALL sp_vehicles(1,0)');

        foreach ($vehicles as $vehicle) {
            $assignedcount = DB::table('vehicleocuppants')
                ->where('vehicle_id', $vehicle->id)
                ->where('status', 1)
                ->count();

            $vehicle->assigned_users = $assignedcount;
        }

        if ($request->ajax()) {

            return DataTables::of($vehicles)
                ->addColumn('logo', function ($vehicle) {
                    return '<img src="' . ($vehicle->logo == '' ? asset('storage/brand_logo/no_image.png') : asset($vehicle->logo)) . '" width="100px" height="70px" class="card">';
                })
                ->addColumn('status', function ($vehicle) {
                    return $vehicle->status == 1 ? '<div style="color: green"><i class="fas fa-check"></i> Activo</div>' : '<div style="color: red"><i class="fas fa-times"></i> Inactivo</div>';
                })
                ->addColumn('actions', function ($vehicle) {
                    return '
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bars"></i>                        
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item btnEditar" id="' . $vehicle->id . '"><i class="fas fa-edit"></i>  Editar</button>
                            <button class="dropdown-item btnImagenes" id="' . $vehicle->id . '"><i class="fas fa-image"></i>  Imágenes</button>
                            <form action="' . route('admin.vehicles.destroy', $vehicle->id) . '" method="POST" class="frmEliminar d-inline">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="dropdown-item"><i class="fas fa-trash"></i> Eliminar</button>
                            </form>
                        </div>
                    </div>';
                })
                ->addColumn('ocuppants', function ($vehicle) {
                    return '<button class="btn btn-success btn-sm btnOcuppants" data-id="' . $vehicle->id . '">
                    <i class="fas fa-people-arrows"></i>&nbsp;&nbsp;(' . $vehicle->assigned_users . ')</button>';
                })
                ->rawColumns(['logo', 'status', 'ocuppants', 'actions'])
                ->make(true);
        } else {
            return view('admin.vehicles.index', compact('vehicles'));
        }
    }

    public function create()
    {
        $brandsSQL = Brand::whereRaw("id IN (SELECT brand_id FROM brandmodels)");
        $brands = $brandsSQL->pluck("name", "id");
        $models = Brandmodel::where("brand_id", $brandsSQL->first()->id)->pluck("name", "id");
        $types = Vehicletype::pluck("name", "id");
        $colors = Vehiclecolor::pluck("name", "id", "color_code");
        return view("admin.vehicles.create", compact("brands", "models", "types", "colors"));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                "code" => "unique:vehicles",
                "name" => "unique:vehicles",
                "plate" => "unique:vehicles|regex:/^[A-Z0-9]{3}-[0-9]{3}$/",
                "year" => "required|numeric|between:1970,2024",
                "occupant_capacity" => "required|numeric|gt:0",
                "load_capacity" => "required|numeric|gt:0",
            ], [
                "code.unique" => "El código ya ha sido registrado.",
                "plate.unique" => "La placa ya ha sido registrada.",
                "plate.regex" => "El formato de la placa es inválido. Debe ser como 'ABC-123' o 'A1B-123'",
                "year.between" => "El año debe estar entre 1970 y 2024.",
                "occupant_capacity.gt" => "La capacidad de ocupantes debe ser mayor a 0",
                "load_capacity.gt" => "La capacidad de carga debe ser mayor a 0"
            ]);

            $plate = strtoupper($request->input('plate'));

            if (!isset($request->status)) {
                $status = 0;
            } else {
                $status = 1;
            }

            $vehicle = Vehicle::create($request->except("image") + ["plate" => $plate, "status" => $status]);

            if ($request->image != "") {
                $image = $request->file("image")->store("public/vehicles_images/" . $vehicle->id);
                $urlImage = Storage::url($image);
                Vehicleimage::create([
                    "image" => $urlImage,
                    "profile" => 1,
                    "vehicle_id" => $vehicle->id
                ]);
            }

            return response()->json(['message' => 'Vehículo registrado correctamente'], 200);
        } catch (\Throwable $th) {

            return response()->json(['message' => 'Error en el registro: ' . $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function showImages(string $id)
    {
        $images = Vehicleimage::where("vehicle_id", $id)->get();
        return view("admin.vehicles.showI", compact("images"));
    }
    /*
try {
            $vehicle = DB::select('CALL sp_vehicles(2,' . $id . ')')[0];

            if ($vehicle->status !== 1) {
                return response()->json(['message' => 'El vehículo no está activo.'], 400);
            }

            $ocuppant = DB::select("
            SELECT 
            v2.id, u.name AS usernames, ut.name AS usertype, v2.created_at AS date
            FROM vehicleocuppants v2 
            INNER JOIN vehicles v ON v2.vehicle_id = v.id
            INNER JOIN users u ON v2.user_id = u.id
            INNER JOIN usertypes ut ON v2.usertype_id = ut.id
            WHERE v2.status = 1
            AND v.id = ?
            ", [$id]);

            return view('admin.vehicles.show', compact('vehicle', 'ocuppant'));
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error en la actualización: ' . $th->getMessage()], 500);
        }
*/
    public function show(Request $request, string $id)
    {
        $vehicle = DB::select('CALL sp_vehicles(2,' . $id . ')')[0];

        if ($vehicle->status !== 1) {
            return response()->json(['message' => 'El vehículo no está activo.'], 400);
        }

        $ocuppants = DB::select("
        SELECT 
        v2.id, u.name AS usernames, ut.name AS usertype, v2.created_at AS date
        FROM vehicleocuppants v2 
        INNER JOIN vehicles v ON v2.vehicle_id = v.id
        INNER JOIN users u ON v2.user_id = u.id
        INNER JOIN usertypes ut ON v2.usertype_id = ut.id
        WHERE v2.status = 1
        AND v.id = ?
        ", [$id]);

        if ($request->ajax()) {

            return DataTables::of($ocuppants)
                ->addColumn('actions', function ($ocuppant) {
                    return '      
                    <form action="' . route('admin.vehicleocuppants.update', $ocuppant->id) . '" method="POST" class="frmBaja d-inline">
                        ' . csrf_field() . method_field('PATCH') . '
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-user-minus"></i></button>
                    </form>';
                })
                ->rawColumns(['actions'])  // Declarar columnas que contienen HTML
                ->make(true);
        } else {
            return view('admin.vehicles.show', compact('vehicle', 'ocuppants'));
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $vehicle = Vehicle::find($id);

        $brandsSQL = Brand::whereRaw("id IN (SELECT brand_id FROM brandmodels)");
        $brands = $brandsSQL->pluck("name", "id");
        $models = Brandmodel::where("brand_id", $vehicle->brand_id)->pluck("name", "id");
        $types = Vehicletype::pluck("name", "id");
        $colors = Vehiclecolor::pluck("name", "id", "color_code");
        return view("admin.vehicles.edit", compact("brands", "models", "types", "colors", "vehicle"));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $request->validate([
                "code" => "unique:vehicles,code," . $id,
                "name" => "unique:vehicles,name," . $id,
                "plate" => "unique:vehicles,plate," . $id . "|regex:/^[A-Z0-9]{3}-[0-9]{3}$/",
                "year" => "required|numeric|between:1970,2024",
                "occupant_capacity" => "required|numeric|gt:0",
                "load_capacity" => "required|numeric|gt:0"
            ], [
                "code.unique" => "El código ya ha sido registrado.",
                "plate.unique" => "La placa ya ha sido registrada.",
                "plate.regex" => "El formato de la placa es inválido. Debe ser como 'ABC-123' o 'A1B-123'",
                "year.between" => "El año debe estar entre 1970 y 2024.",
                "occupant_capacity.gt" => "La capacidad de ocupantes debe ser mayor a 0",
                "load_capacity.gt" => "La capacidad de carga debe ser mayor a 0"
            ]);

            // Obtener la capacidad máxima actual y el número de ocupantes asignados
            $assignedOccupantsCount = Vehicleocuppants::where('vehicle_id', $id)->where('status', 1)->count();

            // Verificar si se está intentando reducir la capacidad por debajo del número de ocupantes actuales
            if ($assignedOccupantsCount > 0 && $request->occupant_capacity < $assignedOccupantsCount) {
                return response()->json([
                    'message' => 'No se puede reducir la capacidad de ocupantes por debajo de los ocupantes ya asignados.',
                ], 400);
            }
            if (!isset($request->status)) {
                $status = 0;
            } else {
                $status = 1;
            }

            $vehicle = Vehicle::find($id);

            $vehicle->update($request->except("image") + ["status" => $status]);

            if ($request->image != "") {
                $image = $request->file("image")->store("public/vehicles_images/" . $vehicle->id);
                $urlImage = Storage::url($image);
                DB::select("UPDATE vehicleimages SET profile=0 WHERE vehicle_id=$id");
                Vehicleimage::create([
                    "image" => $urlImage,
                    "profile" => 1,
                    "vehicle_id" => $vehicle->id
                ]);
            }

            return response()->json(['message' => 'Vehículo actualizado correctamente'], 200);
        } catch (\Throwable $th) {

            return response()->json(['message' => 'Error en la actualización: ' . $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {
            $vehicle = Vehicle::find($id);
            $vehicle->delete();
            return response()->json(['message' => 'Vehículo eliminado correctamente'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error al eliminar el vehiculo, primero tiene que eliminar imagenes relacionadas'], 500);
        }
    }


    public function ocuppantsByVehicle(string $id)
    {
        $occupants = Vehicleocuppants::where("vehicle_id", $id)
            ->join('users', 'vehicleocuppants.user_id', '=', 'users.id')
            ->select('users.id', 'users.name') // Asegúrate de que "name" sea un atributo válido
            ->get();
        return $occupants;
    }
}
