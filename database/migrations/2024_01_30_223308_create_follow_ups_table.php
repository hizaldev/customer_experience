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
        Schema::create('follow_ups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('gangguan_id');
            $table->date('tgl_tindaklanjut')->nullable();
            $table->uuid('kategori_penyebab_id');
            $table->string('pelaksana_satu')->nullable();
            $table->string('pelaksana_dua')->nullable();
            $table->string('pelaksana_tiga')->nullable();
            $table->string('pelaksana_empat')->nullable();
            $table->longText('tindaklanjut')->nullable();
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
        Schema::dropIfExists('follow_ups');
    }
};
