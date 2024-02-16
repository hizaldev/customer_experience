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
            $table->string('nip', 20)->after('email')->nullable();
            $table->string('pernr', 20)->after('nip')->nullable();
            $table->string('phone', 50)->after('pernr')->nullable();
            $table->string('posisi_id', 50)->after('phone')->nullable();
            $table->string('posisi_name', 100)->after('posisi_id')->nullable();
            $table->string('organisasi_id', 50)->after('posisi_name')->nullable();
            $table->string('organisasi_name', 100)->after('organisasi_id')->nullable();
            $table->string('personel_area_id', 50)->after('organisasi_name')->nullable();
            $table->string('personel_area_name', 100)->after('personel_area_id')->nullable();
            $table->string('personel_sub_area_id', 50)->after('personel_area_name')->nullable();
            $table->string('personel_sub_area_name', 100)->after('personel_sub_area_id')->nullable();
            $table->string('business_area', 50)->after('personel_sub_area_name')->nullable();
            $table->string('business_area_name', 100)->after('business_area')->nullable();
            $table->string('substation')->after('business_area_name')->nullable();
            $table->string('otp', 6)->after('substation')->default('0');
            $table->string('fcm_token')->after('otp')->nullable();
            $table->dateTime('last_otp')->after('fcm_token')->nullable();
            $table->dateTime('last_login')->after('last_otp')->nullable();
            $table->enum('status_user', ['Internal', 'Eksternal'])->after('last_login')->default('Internal');
            $table->uuid('consumer_id')->after('status_user')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nip');
            $table->dropColumn('pernr');
            $table->dropColumn('phone');
            $table->dropColumn('posisi_id');
            $table->dropColumn('posisi_name');
            $table->dropColumn('organisasi_id');
            $table->dropColumn('organisasi_name');
            $table->dropColumn('personel_area_id');
            $table->dropColumn('personel_area_name');
            $table->dropColumn('personel_sub_area_id');
            $table->dropColumn('personel_sub_area_name');
            $table->dropColumn('business_area');
            $table->dropColumn('business_area_name');
            $table->dropColumn('substation');
            $table->dropColumn('otp');
            $table->dropColumn('fcm_token');
            $table->dropColumn('last_otp');
            $table->dropColumn('last_login');
            $table->dropColumn('status_user');
            $table->dropColumn('consumer_id');
        });
    }
};
