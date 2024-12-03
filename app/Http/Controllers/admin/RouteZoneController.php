<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Routes;
use App\Models\Routezone;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouteZoneController extends Controller
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
    public function create()
    {
        // return view('admin.routezones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Routezone::create($request->all());
        return redirect()->route('admin.routes.show', $request->route_id)->with('success', 'Agregado correctamente');
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $route = Routes::find($id);
        // $lastcoord = Zonecoord::select('latitude as lat', 'longitude as lng')
        // ->where('zone_id', $id)->latest()->first();
        $zones = Zone::pluck('name', 'id');

        return view('admin.routezone.create', compact('route', 'zones'));
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
        $rz = RouteZone::find($id);
        $route_id = $rz->route_id;
        $rz->delete();
        return redirect()->route('admin.routes.show', $route_id)->with('Success', 'Eliminado correctamente');
    }
}
