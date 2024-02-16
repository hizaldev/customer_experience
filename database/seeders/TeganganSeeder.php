<?php

namespace Database\Seeders;

use App\Models\Voltages;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeganganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        voltages::create(["id" => "9a6ae0c5-748b-4faa-b501-48a8eacad2a3", "tegangan_id" => "0", "tegangan" => "-", "keterangan" => "-", "created_by" => "System", "created_at" => Carbon::now()]);
        voltages::create(["id" => "9a6ae0c5-8b49-4564-b2dc-14c555a9dd2a", "tegangan_id" => "1", "tegangan" => "12-220 V", "keterangan" => "Tegangan Rendah DC", "created_by" => "System", "created_at" => Carbon::now()]);
        voltages::create(["id" => "9a6ae0c5-8b9c-4310-a85b-3412c78a93e3", "tegangan_id" => "2", "tegangan" => "20 kV", "keterangan" => "Tegangan Menengah", "created_by" => "System", "created_at" => Carbon::now()]);
        voltages::create(["id" => "9a6ae0c5-8bd2-466d-8412-e4c84e79f873", "tegangan_id" => "3", "tegangan" => "30kV", "keterangan" => "Tegangan Tinggi", "created_by" => "System", "created_at" => Carbon::now()]);
        voltages::create(["id" => "9a6ae0c5-8c06-4828-8cf1-6835835e6928", "tegangan_id" => "4", "tegangan" => "70kV", "keterangan" => "Tegangan Tinggi", "created_by" => "System", "created_at" => Carbon::now()]);
        voltages::create(["id" => "9a6ae0c5-8c31-46f0-9e98-1d386553a1a8", "tegangan_id" => "5", "tegangan" => "150kV", "keterangan" => "Tegangan Tinggi", "created_by" => "System", "created_at" => Carbon::now()]);
        voltages::create(["id" => "9a6ae0c5-8db0-4db5-8f2b-46d5da2003de", "tegangan_id" => "6", "tegangan" => "275kV", "keterangan" => "Tegangan Ekstra Tinggi", "created_by" => "System", "created_at" => Carbon::now()]);
        voltages::create(["id" => "9a6ae0c5-8de8-499e-9a9a-d42bdeb05e53", "tegangan_id" => "7", "tegangan" => "500kV", "keterangan" => "Tegangan Ekstra Tinggi", "created_by" => "System", "created_at" => Carbon::now()]);
    }
}
