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
        Schema::create('locations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('parent_id');
            $table->string('nm_lokasi', 200)->nullable();
            $table->string('description', 200)->nullable();
            $table->string('id_functloc', 40)->nullable();
            $table->string('sup_functloc', 40)->nullable();
            $table->string('latitude', 40)->nullable();
            $table->string('longitude', 40)->nullable();
            $table->bigInteger('nlevel');
            $table->uuid('status_id');
            $table->uuid('fungsi_id');
            $table->uuid('tegangan_id');
            $table->uuid('section_id')->nullable();
            $table->string('created_by', 50)->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->string('deleted_by', 50)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
