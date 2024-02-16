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
        Schema::create('pqm_consumers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('upt_id');
            $table->uuid('ultg_id');
            $table->uuid('substation_id');
            $table->dateTime('datetime');
            $table->double('dist_dur', 15, 8)->default(0.000);
            $table->double('presentase_r', 15, 8)->default(0.000);
            $table->double('voltage_r', 15, 8)->default(0.000);
            $table->double('dist_vr_min', 15, 8)->default(0.000);
            $table->double('dist_vr_max', 15, 8)->default(0.000);
            $table->double('dist_vr_avg', 15, 8)->default(0.000);
            $table->double('dist_vr_eng', 15, 8)->default(0.000);
            $table->double('presentase_s', 15, 8)->default(0.000);
            $table->double('voltage_s', 15, 8)->default(0.000);
            $table->double('dist_vs_min', 15, 8)->default(0.000);
            $table->double('dist_vs_max', 15, 8)->default(0.000);
            $table->double('dist_vs_avg', 15, 8)->default(0.000);
            $table->double('dist_vs_eng', 15, 8)->default(0.000);
            $table->double('presentase_t', 15, 8)->default(0.000);
            $table->double('voltage_t', 15, 8)->default(0.000);
            $table->double('dist_vt_min', 15, 8)->default(0.000);
            $table->double('dist_vt_max', 15, 8)->default(0.000);
            $table->double('dist_vt_avg', 15, 8)->default(0.000);
            $table->double('dist_vt_eng', 15, 8)->default(0.000);
            $table->string('gardu_induk', 255)->nullable();
            $table->string('bay', 255)->nullable();
            $table->string('kondisi', 255)->nullable();
            $table->string('waktu_gangguan', 50)->nullable();
            $table->string('penyebab', 50)->nullable();
            $table->string('keterangan', 50)->nullable();
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
        Schema::dropIfExists('pqm_consumers');
    }
};
