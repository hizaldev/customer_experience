<?php

namespace Database\Seeders;

use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        status::create(["id" => "9a6adbbe-d992-40c4-b00b-275fb7683ec8", "id_status" => "0", "status" => "PLN Rencana", "created_by" => "System", "created_at" => Carbon::now()]);
        status::create(["id" => "9a6adbbe-ee6d-4c7f-9616-5ce0ae745c80", "id_status" => "1", "status" => "PLN Belum Operasi", "created_by" => "System", "created_at" => Carbon::now()]);
        status::create(["id" => "9a6adbbe-eeb2-49ba-afd2-0e534440ab99", "id_status" => "2", "status" => "PLN Operasi", "created_by" => "System", "created_at" => Carbon::now()]);
        status::create(["id" => "9a6adbbe-f0f8-4550-b8b1-d5ccb89c64c3", "id_status" => "3", "status" => "PLN Tidak Operasi", "created_by" => "System", "created_at" => Carbon::now()]);
        status::create(["id" => "9a6adbbe-f137-4107-a0ac-06ebd2b8b57c", "id_status" => "4", "status" => "Pembangkit Aset Transmisi", "created_by" => "System", "created_at" => Carbon::now()]);
        status::create(["id" => "9a6adbbe-f1c9-4caa-8024-480d5d7efeb2", "id_status" => "5", "status" => "Konsumen Aset Transmisi", "created_by" => "System", "created_at" => Carbon::now()]);
        status::create(["id" => "9a6adbbe-f236-4b59-b5df-62d43c1add58", "id_status" => "6", "status" => "Pembangkit Aset Luar", "created_by" => "System", "created_at" => Carbon::now()]);
        status::create(["id" => "9a6adbbe-f295-42c0-9879-91d35b9fdb2b", "id_status" => "7", "status" => "Konsumen Aset Luar", "created_by" => "System", "created_at" => Carbon::now()]);
        status::create(["id" => "9a6adbbe-f2d2-4a91-8479-368f8950d817", "id_status" => "8", "status" => "Gardu Hubung", "created_by" => "System", "created_at" => Carbon::now()]);
        status::create(["id" => "9a6adbbe-f30b-443e-b028-878cd4d3d9b3", "id_status" => "9", "status" => "Operasi belum STP", "created_by" => "System", "created_at" => Carbon::now()]);
    }
}
