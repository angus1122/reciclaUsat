<?php

namespace Database\Seeders;

use App\Models\Maintenancestatu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaintenancestatuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $s1 = new Maintenancestatu();
        $s1->name = 'Iniciado';
        $s1->save();

        $s2 = new Maintenancestatu();
        $s2->name = 'Finalizado';
        $s2->save();
    }
}
