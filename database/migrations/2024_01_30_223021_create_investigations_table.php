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
        Schema::create('investigations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('gangguan_id');
            $table->date('tgl_investigasi')->nullable();
            $table->string('pelaksana_satu')->nullable();
            $table->string('pelaksana_dua')->nullable();
            $table->string('pelaksana_tiga')->nullable();
            $table->string('pelaksana_empat')->nullable();
            $table->longText('investigasi')->nullable();
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
        Schema::dropIfExists('investigations');
    }
};
