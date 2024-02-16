<?php

namespace Database\Seeders;

use App\Models\Locations;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationTwoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Locations::create(['id' => '9ad8a61c-224b-49b3-ae16-20ee00c64530', 'parent_id' => '9ad8a5bf-e568-449f-a24f-e3e175f75382', 'nm_lokasi' => 'UPT SEMARANG', 'description' => 'UPT SEMARANG', 'id_functloc' => 'TRS-3517', 'sup_functloc' => 'TRS-3500', 'nlevel' => '2', 'status_id' => '9a6adbbe-eeb2-49ba-afd2-0e534440ab99', 'fungsi_id' => '9a6ae5a7-109c-43f2-9cdd-989753e529be', 'tegangan_id' => '9a6ae0c5-748b-4faa-b501-48a8eacad2a3', 'created_by' => 'System', 'created_at' => Carbon::now()]);
    }
}
