<?php

namespace Database\Seeders;

use App\Models\TipeGangguans;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipeGangguanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipeGangguans::create(["id" => "9b2e4a83-ebda-44cd-a5a4-e6b257b7a940", "tipe_gangguan" => "Penghantar", "keterangan" => "-", "created_by" => "System", "created_at" => Carbon::now()]);
        TipeGangguans::create(["id" => "9b2e4a9d-b219-4f55-9505-0fef79bc6962", "tipe_gangguan" => "Trafo / Incoming Trafo", "keterangan" => "-", "created_by" => "System", "created_at" => Carbon::now()]);
        TipeGangguans::create(["id" => "9b2e4aa7-9717-4d66-bee6-83fd7029a46c", "tipe_gangguan" => "Kopel - Busbar - Diameter", "keterangan" => "-", "created_by" => "System", "created_at" => Carbon::now()]);
        TipeGangguans::create(["id" => "9b44a967-6a44-4ea0-80b1-c6489eadc11f", "tipe_gangguan" => "Pembangkit", "keterangan" => "-", "created_by" => "System", "created_at" => Carbon::now()]);
    }
}
