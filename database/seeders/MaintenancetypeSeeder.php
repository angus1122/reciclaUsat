<?php

namespace Database\Seeders;

use App\Models\Maintenancetypes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaintenancetypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $z1 = new Maintenancetypes();
        $z1->name = 'Limpieza';
        $z1->save();

        $z2 = new Maintenancetypes();
        $z2->name = 'Reparación';
        $z2->save();
    }
}
