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
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('level_induk')->after('consumer_id')->nullable();
            $table->uuid('level_upt')->after('level_induk')->nullable();
            $table->uuid('level_ultg')->after('level_upt')->nullable();
            $table->string('level_substation', 255)->after('level_ultg')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('level_induk');
            $table->dropColumn('level_upt');
            $table->dropColumn('level_ultg');
            $table->dropColumn('level_substation');
        });
    }
};
