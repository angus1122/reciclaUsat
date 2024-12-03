<?php

use App\Http\Controllers\admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\BrandmodelController;
use App\Http\Controllers\admin\MaintenanceschedulesController;
use App\Http\Controllers\admin\MaintenancesController;
use App\Http\Controllers\admin\OcuppantsController;
use App\Http\Controllers\Admin\RoutesController;
use App\Http\Controllers\admin\SchedulesController;
use App\Http\Controllers\admin\SchedulesdatesController;
use App\Http\Controllers\admin\SchedulesDetailsController;
use App\Http\Controllers\admin\SectorController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\UsertypeController;
use App\Http\Controllers\admin\VehiclecolorController;
use App\Http\Controllers\admin\VehicleController;
use App\Http\Controllers\admin\VehicleimagesController;
use App\Http\Controllers\admin\VehicleocuppantsController;
use App\Http\Controllers\admin\VehicletypeController;
use App\Http\Controllers\admin\ZoneController;
use App\Http\Controllers\admin\ZonecoordController;


Route::get('/', [AdminController::class, 'index'])->name('home');
Route::resource('brands', BrandController::class)->names('admin.brands');
Route::resource('models', BrandmodelController::class)->names('admin.models');
Route::resource('vehicles', VehicleController::class)->names('admin.vehicles');
Route::resource('vehicleimages', VehicleimagesController::class)->names('admin.vehicleimages');
Route::get('modelsbybrand/{id}', [BrandmodelController::class, 'modelsbybrand'])->name('admin.modelsbybrand');
Route::get('imageprofile/{id}/{vehicle_id}', [VehicleimagesController::class, 'profile'])->name('admin.imageprofile');
Route::resource('zones', ZoneController::class)->names('admin.zones');
Route::resource('zonecoords', ZonecoordController::class)->names('admin.zonecoords');
Route::resource('sectors', SectorController::class)->names('admin.sectors');
Route::resource('types', VehicletypeController::class)->names('admin.types');
Route::resource('colors', VehiclecolorController::class)->names('admin.colors');
Route::resource('usertypes', UsertypeController::class)->names('admin.usertypes');
Route::resource('users', UserController::class)->names('admin.users');
Route::resource('schedules', SchedulesController::class)->names('admin.schedules');
Route::get('vehicles/{id}/images', [VehicleController::class, 'showImages'])->name('vehicles.images');
Route::resource('vehicleocuppants', VehicleocuppantsController::class)->names('admin.vehicleocuppants');
Route::get('searchbydni/{id}', [VehicleocuppantsController::class, 'searchbydni'])->name('admin.searchbydni');
Route::post('vehicleocuppants/confirm', [VehicleocuppantsController::class, 'confirm'])->name('admin.vehicleocuppants.confirm');
Route::resource('ocuppants', OcuppantsController::class)->names('admin.ocuppants');
Route::resource('maintenances', MaintenancesController::class)->names('admin.maintenances');
Route::resource('maintenanceschedules', MaintenanceschedulesController::class)->names('admin.maintenanceschedules');
Route::resource('schedulesdates', SchedulesdatesController::class)->names('admin.schedulesdates');
Route::get('maintenanceschedules/ocuppantsbyvehicle/{vehicle_id}', [MaintenanceschedulesController::class, 'ocuppantsByVehicle'])->name('admin.ocuppantsbyvehicle');
Route::resource('routes', RoutesController::class)->names('admin.routes');

Route::resource('schedulesdetails', SchedulesDetailsController::class)->names('admin.schedulesdetails');




Route::put('admin/schedulesdetails/bulk-update', [SchedulesDetailsController::class, 'bulkUpdate'])
    ->name('admin.schedulesdetails.bulkUpdate');
