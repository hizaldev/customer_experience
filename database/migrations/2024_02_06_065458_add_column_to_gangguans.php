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
        Schema::table('gangguans', function (Blueprint $table) {
            $table->double('arus_gangguan_s', 15, 8)->after('arus_gangguan')->default(0.000);
            $table->double('arus_gangguan_t', 15, 8)->after('arus_gangguan_s')->default(0.000);
            $table->double('arus_gangguan_n', 15, 8)->after('arus_gangguan_t')->default(0.000);
            $table->enum('is_main_gangguan', ['Ya', 'Tidak'])->after('tgl_gangguan')->default('Tidak');
            $table->uuid('subsystem_id')->after('tipe_gangguan_id')->nullable();
            $table->string('description')->after('bay_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gangguans', function (Blueprint $table) {
            $table->dropColumn('arus_gangguan_s');
            $table->dropColumn('arus_gangguan_t');
            $table->dropColumn('arus_gangguan_n');
            $table->dropColumn('is_main_gangguan');
            $table->dropColumn('subsystem_id');
            $table->dropColumn('description');
        });
    }
};
