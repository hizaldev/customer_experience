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
        Schema::create('jalurs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('upt_id');
            $table->uuid('ultg_id')->nullable();
            $table->uuid('substation_id')->nullable();
            $table->uuid('subsystem_id')->nullable();
            $table->string('no_wo')->nullable();
            $table->string('no_notif')->nullable();
            $table->string('location')->nullable();
            $table->longText('uraian_pekerjaan');
            $table->string('tegangan', 5);
            $table->string('id_functloc', 22)->nullable();
            $table->string('peralatan_padam')->nullable();
            $table->string('sifat', 10)->nullable();
            $table->string('penanggung_jawab', 50)->nullable();
            $table->string('no_spk', 100)->nullable();
            $table->date('awal_usulan')->nullable();
            $table->date('akhir_usulan')->nullable();
            $table->string('jam_usulan', 12)->nullable();
            $table->date('awal_jadwal')->nullable();
            $table->date('akhir_jadwal')->nullable();
            $table->string('jam_jadwal', 12)->nullable();
            $table->string('rencana', 12)->nullable();
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('jalurs');
    }
};
