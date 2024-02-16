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
        Schema::create('gangguans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('upt_id');
            $table->uuid('ultg_id');
            $table->uuid('substation_id');
            $table->uuid('bay_id');
            $table->uuid('jenis_gangguan_id');
            $table->uuid('tipe_gangguan_id');
            $table->longText('anounciator')->nullable();
            $table->dateTime('tgl_gangguan');
            $table->double('arus_gangguan', 15, 8)->default(0.000);
            $table->longText('indikasi_relay')->nullable();
            $table->string('count_cb_r', 50)->nullable();
            $table->string('count_cb_s', 50)->nullable();
            $table->string('count_cb_t', 50)->nullable();
            $table->string('count_la_r', 50)->nullable();
            $table->string('count_la_s', 50)->nullable();
            $table->string('count_la_t', 50)->nullable();
            $table->double('beban_sebelum_mw', 15, 8)->default(0.000);
            $table->double('beban_sebelum_mvar', 15, 8)->default(0.000);
            $table->longText('penyebab_gangguan')->nullable();
            $table->string('kondisi_lingkungan', 50)->nullable();
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
        Schema::dropIfExists('gangguans');
    }
};
