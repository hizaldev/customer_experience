<?php

namespace Database\Seeders;

use App\Models\Locations;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationOneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Locations::create(['id' => '9ad8a5bf-e568-449f-a24f-e3e175f75382', 'parent_id' => 'bb0ab0ee-36c0-41a3-ac00-fdb8abea6795', 'nm_lokasi' => 'UITJBT', 'description' => 'Unit Induk Transmisi Jawa Bagian Tengah', 'id_functloc' => 'TRS-3500', 'sup_functloc' => 'TRS', 'nlevel' => '1', 'status_id' => '9a6adbbe-eeb2-49ba-afd2-0e534440ab99', 'fungsi_id' => '9a6ae5a7-0d36-4f4a-91ee-8ec4a629289c', 'tegangan_id' => '9a6ae0c5-748b-4faa-b501-48a8eacad2a3', 'created_by' => 'System', 'created_at' => Carbon::now()]);
    }
}
