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
        Schema::create('schedulesdates', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->unsignedBigInteger("maintenanceschedules_id");
            $table->unsignedBigInteger("maintenances_id");
            $table->unsignedBigInteger("maintenancestatus_id");
            $table->foreign("maintenanceschedules_id")->references("id")->on("maintenanceschedules");
            $table->foreign("maintenances_id")->references("id")->on("maintenances");
            $table->foreign("maintenancestatus_id")->references("id")->on("maintenancestatus");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedulesdates');
    }
};
