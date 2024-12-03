<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Routes;
use App\Models\Routezone;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoutesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $routes = DB::select("CALL sp_getroutedetails();");

        $zones = Zone::all();

        $zonesMap = DB::table('zones')
            ->leftJoin('zonecoords', 'zones.id', '=', 'zonecoords.zone_id')
            ->select('zones.name as zone', 'zonecoords.latitude', 'zonecoords.longitude')
            ->get();

        // Agrupa las coordenadas por zona
        $groupedZones = $zonesMap->groupBy('zone');

        $perimeter = $groupedZones->map(function ($zone) {
            $coords = $zone->map(function ($item) {
                return [
                    'lat' => $item->latitude,
                    'lng' => $item->longitude,
                ];
            })->toArray();

            return [
                'name' => $zone[0]->zone,
                'coords' => $coords,
            ];
        })->values();

        // Mapear las rutas con sus coordenadas de inicio y final
        $routesWithCoords = collect($routes)->map(function ($route) {
            return [
                'name' => $route->name,
                'start' => [
                    'lat' => $route->latitud_start,
                    'lng' => $route->longitude_start,
                ],
                'end' => [
                    'lat' => $route->latitude_end,
                    'lng' => $route->longitude_end,
                ],
            ];
        });

        return view('admin.routes.index', compact('routes', 'perimeter', 'routesWithCoords'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $zones = Zone::all();

        $zonesMap = DB::table('zones')
            ->leftJoin('zonecoords', 'zones.id', '=', 'zonecoords.zone_id')
            ->select('zones.name as zone', 'zonecoords.latitude', 'zonecoords.longitude')
            ->get();

        // Agrupar coordenadas por zona
        $groupedZones = $zonesMap->groupBy('zone');

        $perimeter = $groupedZones->map(function ($zone) {
            $coords = $zone->map(function ($item) {
                return [
                    'lat' => $item->latitude,
                    'lng' => $item->longitude,
                ];
            })->toArray();

            return [
                'name' => $zone[0]->zone,
                'coords' => $coords,
            ];
        })->values();

        return view('admin.routes.create', compact('zones', 'perimeter'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Definir las reglas de validación
        $rules = [
            'name' => 'required|string|max:255',
            'status' => 'nullable|boolean',
            'latitud_start' => 'required|numeric',
            'longitude_start' => 'required|numeric',
            'latitude_end' => 'required|numeric',
            'longitude_end' => 'required|numeric',
        ];

        // Validación manual
        $validator = Validator::make($request->all(), $rules);

        // Si la validación falla, redirigir con los errores
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Datos no Válidos');
        }

        // Si la validación pasa, procesar los datos
        $data = $request->all();

        // var_dump($request->all());


        // $data = $request->validate([
        //     'name' => 'required|string|max:255',
        //     //'zone_id' => 'required|exists:zones,id',
        //     'status' => 'nullable|boolean',
        //     'latitud_start' => 'required|numeric',
        //     'longitude_start' => 'required|numeric',
        //     'latitude_end' => 'required|numeric',
        //     'longitude_end' => 'required|numeric',
        // ]);

        $route = new Routes();
        $route->name = $data['name'];
        //$route->zone_id = $data['zone_id'];
        $route->status = $request->has('status');
        $route->latitud_start = $data['latitud_start'];
        $route->longitude_start = $data['longitude_start'];
        $route->latitude_end = $data['latitude_end'];
        $route->longitude_end = $data['longitude_end'];
        $route->save();

        return redirect()->back()->with('success', 'Ruta creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $route = Routes::findOrFail($id);

        $routezones = DB::select('
            SELECT rz.id, z.name 
            FROM routezones rz 
            INNER JOIN zones z ON rz.zone_id = z.id 
            WHERE rz.route_id = ?', [$id]);

        $zonesMap = DB::table('zones')
            ->leftJoin('zonecoords', 'zones.id', '=', 'zonecoords.zone_id')
            ->whereIn('zones.id', function ($query) use ($id) {
                $query->select('zone_id')
                    ->from('routezones')
                    ->where('route_id', $id);
            })
            ->select('zones.name as zone', 'zonecoords.latitude', 'zonecoords.longitude')
            ->get();

        // Agrupa las coordenadas por zona
        $groupedZones = $zonesMap->groupBy('zone');

        $perimeter = $groupedZones->map(function ($zone) {
            $coords = $zone->map(function ($item) {
                return [
                    'lat' => $item->latitude,
                    'lng' => $item->longitude,
                ];
            })->toArray();

            return [
                'name' => $zone[0]->zone,
                'coords' => $coords,
            ];
        })->values();

        return view('admin.routes.show', compact('route', 'routezones', 'perimeter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $route = Routes::find($id);
        //$zones = Zone::pluck('name','id');

        $zones = Zone::all();

        $zonesMap = DB::table('zones')
            ->leftJoin('zonecoords', 'zones.id', '=', 'zonecoords.zone_id')
            ->select('zones.name as zone', 'zonecoords.latitude', 'zonecoords.longitude')
            ->get();

        // Agrupa las coordenadas por zona
        $groupedZones = $zonesMap->groupBy('zone');

        $perimeter = $groupedZones->map(function ($zone) {
            $coords = $zone->map(function ($item) {
                return [
                    'lat' => $item->latitude,
                    'lng' => $item->longitude,
                ];
            })->toArray();

            return [
                'name' => $zone[0]->zone,
                'coords' => $coords,
            ];
        })->values();

        return view('admin.routes.edit', compact('route', 'zones', 'perimeter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            //'zone_id' => 'required|exists:zones,id',
            'status' => 'nullable|boolean',
            'latitud_start' => 'required|numeric',
            'longitude_start' => 'required|numeric',
            'latitude_end' => 'required|numeric',
            'longitude_end' => 'required|numeric',
        ]);

        $route = Routes::findOrFail($id);
        $route->name = $data['name'];
        //$route->zone_id = $data['zone_id'];
        $route->status = $request->has('status');
        $route->latitud_start = $data['latitud_start'];
        $route->longitude_start = $data['longitude_start'];
        $route->latitude_end = $data['latitude_end'];
        $route->longitude_end = $data['longitude_end'];
        $route->save();

        return redirect()->back()->with('success', 'Ruta actualizada exitosamente');
    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $route = Routes::find($id);
        $routezone = Routezone::where('route_id', $id)->count();
        if ($routezone > 0) {
            return redirect()->route('admin.routes.index')->with('error', 'Ruta tiene zonas registradas');
        } else {
            $route->delete();
            return redirect()->route('admin.routes.index')->with('success', 'Ruta eliminada');
        }
    }
}
