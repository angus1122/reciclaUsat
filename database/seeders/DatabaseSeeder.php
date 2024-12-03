<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Maintenancestatus;
use App\Models\Maintenancetype;
use App\Models\Maintenancetypes;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(DepartmentSeeder::class);
        $this->call(ProvinceSeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(SectorSeeder::class);
        $this->call(VehicletypeSeeder::class);
        $this->call(UsertypeSeeder::class);
        $this->call(MaintenancetypeSeeder::class);
        $this->call(MaintenancestatuSeeder::class);
    }
}
