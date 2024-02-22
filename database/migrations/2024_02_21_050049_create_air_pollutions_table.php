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
        Schema::create('air_pollution', function (Blueprint $table) {
            $table->id();
            $table->integer('air_quality_index');
            $table->integer('city_id');
            $table->float('co');
            $table->float('no');
            $table->float('no2');
            $table->float('o3');
            $table->float('so2');
            $table->float('pm2_5');
            $table->float('pm10');
            $table->float('nh3');
            $table->dateTime('datetime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('air_pollutions');
    }
};
