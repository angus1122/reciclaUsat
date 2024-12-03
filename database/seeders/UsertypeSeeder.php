<?php

namespace Database\Seeders;

use App\Models\Usertype;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsertypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $t1 = new Usertype();
        $t1->name = 'Administrador';
        $t1->save();

        $t2 = new Usertype();
        $t2->name = 'Conductor';
        $t2->save();

        $t3 = new Usertype();
        $t3->name = 'Recolector';
        $t3->save();

        $t4 = new Usertype();
        $t4->name = 'Ciudadano';
        $t4->save();
    }
}
