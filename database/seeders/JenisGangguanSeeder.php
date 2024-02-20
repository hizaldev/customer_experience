<?php

namespace Database\Seeders;

use App\Models\JenisGangguans;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisGangguanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisGangguans::create(["id" => "9b29f832-f964-48bd-9eb1-49c66d8ec961", "jenis_gangguan" => "Trip", "keterangan" => "-", "created_by" => "System", "created_at" => Carbon::now()]);
        JenisGangguans::create(["id" => "9b2e4a9d-b219-4f55-9505-0fef79bc6962", "jenis_gangguan" => "Reclose", "keterangan" => "-", "created_by" => "System", "created_at" => Carbon::now()]);
        JenisGangguans::create(["id" => "9b29f9c1-7c26-4165-b7fa-9b18ba2d2e82", "jenis_gangguan" => "Reclose Trip", "keterangan" => "-", "created_by" => "System", "created_at" => Carbon::now()]);
    }
}
