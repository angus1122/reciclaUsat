<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('maintenanceschedules', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->time("time_start");
            $table->time("time_end");
            $table->unsignedBigInteger("maintenance_id");
            $table->unsignedBigInteger("vehicle_id");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("maintenancetype_id");
            $table->foreign("maintenance_id")->references("id")->on("maintenances");
            $table->foreign("vehicle_id")->references("id")->on("vehicles");
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("maintenancetype_id")->references("id")->on("maintenancetypes");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenanceschedules');
    }
};
