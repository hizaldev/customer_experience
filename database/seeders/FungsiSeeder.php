<?php

namespace Database\Seeders;

use App\Models\Functions;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FungsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        functions::create(["id" => "9a6ae5a7-0203-46e0-b010-be76dee2bcaa", "kd_fungsi" => "0", "fungsi" => "BUILDING", "nlevel" => 4, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-092c-43aa-bf8e-64b20c6e8f74", "kd_fungsi" => "1", "fungsi" => "T/R BAY", "nlevel" => 4, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-096f-4264-aa86-798b705dfa64", "kd_fungsi" => "2", "fungsi" => "T/L BAY", "nlevel" => 4, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-09a5-42dc-a975-ea5cee46817a", "kd_fungsi" => "3", "fungsi" => "BUSBAR", "nlevel" => 4, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-0b5d-4ae1-bd62-e8b1988e928c", "kd_fungsi" => "4", "fungsi" => "T/R BAY (LOW VOLTAGE)", "nlevel" => 4, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-0ba2-47e0-9e14-5782dee7b667", "kd_fungsi" => "5", "fungsi" => "MOBILE TRANSFORMER/SUBSTATION", "nlevel" => 4, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-0bf1-45d4-a50d-7535cd20a85d", "kd_fungsi" => "6", "fungsi" => "SUTT/SUTET", "nlevel" => 4, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-0c39-43cf-8be0-f244a10b9d37", "kd_fungsi" => "7", "fungsi" => "SKTT/SKLT", "nlevel" => 4, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-0c7b-4957-a7d3-069815eeb9e1", "kd_fungsi" => "8", "fungsi" => "TOWER", "nlevel" => 4, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-0cea-48f9-bfcc-d270022f3fdf", "kd_fungsi" => "9", "fungsi" => "JOINT", "nlevel" => 4, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-0d36-4f4a-91ee-8ec4a629289c", "kd_fungsi" => "A", "fungsi" => "KANTOR INDUK", "nlevel" => 2, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-0d8e-4ce8-b809-9b7ff557a338", "kd_fungsi" => "B", "fungsi" => "BASECAMP", "nlevel" => 2, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-0e81-4471-bb31-a727610bb81d", "kd_fungsi" => "C", "fungsi" => "CAPASITOR/SVC/MSC", "nlevel" => 4, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-0ebd-4192-bf4d-ab7a4d448408", "kd_fungsi" => "D", "fungsi" => "DIAMETER", "nlevel" => 4, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-0ef9-43f2-997f-89dccc8c4dda", "kd_fungsi" => "E", "fungsi" => "COUPLE", "nlevel" => 4, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-0f30-477f-ad12-b02ad7367054", "kd_fungsi" => "F", "fungsi" => "OFFICE", "nlevel" => 1, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-0f5f-4cb1-a117-d14792d30537", "kd_fungsi" => "G", "fungsi" => "SUBSTATION", "nlevel" => 3, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-0f8e-48b0-8931-f2b1241ce20b", "kd_fungsi" => "H", "fungsi" => "PDKB HQ", "nlevel" => 3, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-0fbf-4046-9f06-dcb00ba1df93", "kd_fungsi" => "I", "fungsi" => "INCOMER/CH/SHELTER", "nlevel" => 3, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-0ff7-4091-a097-9695093e84b1", "kd_fungsi" => "K", "fungsi" => "PEMBANGKIT/KONSUMEN", "nlevel" => 4, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-1035-451e-92da-9b8daf506e04", "kd_fungsi" => "L", "fungsi" => "LABORATORY", "nlevel" => 3, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-1069-463a-b1d9-668457a2f227", "kd_fungsi" => "M", "fungsi" => "MASTER STATION/SERVER", "nlevel" => 3, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-109c-43f2-9cdd-989753e529be", "kd_fungsi" => "O", "fungsi" => "OFFICE", "nlevel" => 2, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-10cf-4c7d-a49a-6ba4edd21bfc", "kd_fungsi" => "P", "fungsi" => "TRAFO PS", "nlevel" => 4, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-1103-4b9d-9241-dc1af6a7e80b", "kd_fungsi" => "R", "fungsi" => "REAKTOR", "nlevel" => 4, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-1138-476e-b293-7fff64d52cdb", "kd_fungsi" => "S", "fungsi" => "BUS SECTION", "nlevel" => 4, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-1172-4bcd-a14b-4ea4d7f94ee3", "kd_fungsi" => "T", "fungsi" => "CORIDOR", "nlevel" => 3, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-11aa-4bf0-84bf-7ad633540160", "kd_fungsi" => "W", "fungsi" => "WAREHOUSE", "nlevel" => 3, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-11e0-4e0b-a547-e9750f2c711e", "kd_fungsi" => "X", "fungsi" => "GROUP TOWER", "nlevel" => 4, "created_by" => "System", "created_at" => Carbon::now()]);
        functions::create(["id" => "9a6ae5a7-122c-457c-9802-fc69bc68d331", "kd_fungsi" => "Z", "fungsi" => "Company", "nlevel" => 1, "created_by" => "System", "created_at" => Carbon::now()]);
    }
}
