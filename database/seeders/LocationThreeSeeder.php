<?php

namespace Database\Seeders;

use App\Models\Locations;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationThreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        locations::create(['parent_id' => '9ad8a61c-224b-49b3-ae16-20ee00c64530', 'nm_lokasi' => 'ULTG Kudus', 'description' => 'ULTG KUDUS', 'id_functloc' => 'TRS-3517-B21.B21', 'sup_functloc' => 'TRS-3517', 'latitude' => '', 'longitude' => '', 'nlevel' => '3', 'status_id' => '9a6adbbe-eeb2-49ba-afd2-0e534440ab99', 'fungsi_id' => '9a6ae5a7-0d8e-4ce8-b809-9b7ff557a338', 'tegangan_id' => '9a6ae0c5-748b-4faa-b501-48a8eacad2a3', 'section_id' => '', 'created_by' => 'System', 'created_at' => Carbon::now()]);
        locations::create(['parent_id' => '9ad8a61c-224b-49b3-ae16-20ee00c64530', 'nm_lokasi' => 'ULTG Semarang', 'description' => 'ULTG SEMARANG', 'id_functloc' => 'TRS-3517-B30.B30', 'sup_functloc' => 'TRS-3517', 'latitude' => '', 'longitude' => '', 'nlevel' => '3', 'status_id' => '9a6adbbe-eeb2-49ba-afd2-0e534440ab99', 'fungsi_id' => '9a6ae5a7-0d8e-4ce8-b809-9b7ff557a338', 'tegangan_id' => '9a6ae0c5-748b-4faa-b501-48a8eacad2a3', 'section_id' => '', 'created_by' => 'System', 'created_at' => Carbon::now()]);
        locations::create(['parent_id' => '9ad8a61c-224b-49b3-ae16-20ee00c64530', 'nm_lokasi' => 'ULTG Rembang', 'description' => 'ULTG REMBANG', 'id_functloc' => 'TRS-3517-B33-B33', 'sup_functloc' => 'TRS-3517', 'latitude' => '-7,15911', 'longitude' => '110,4105', 'nlevel' => '3', 'status_id' => '9a6adbbe-eeb2-49ba-afd2-0e534440ab99', 'fungsi_id' => '9a6ae5a7-0d8e-4ce8-b809-9b7ff557a338', 'tegangan_id' => '9a6ae0c5-748b-4faa-b501-48a8eacad2a3', 'section_id' => '', 'created_by' => 'System', 'created_at' => Carbon::now()]);
        locations::create(['parent_id' => '9ad8a61c-224b-49b3-ae16-20ee00c64530', 'nm_lokasi' => 'GUDANG P3B JB APP SEMARANG', 'description' => 'GUDANG P3B JB APP SEMARANG', 'id_functloc' => 'TRS-3517-GDG.001', 'sup_functloc' => 'TRS-3517', 'latitude' => '-7,16026805', 'longitude' => '110,4106922', 'nlevel' => '3', 'status_id' => '9a6adbbe-eeb2-49ba-afd2-0e534440ab99', 'fungsi_id' => '9a6ae5a7-11aa-4bf0-84bf-7ad633540160', 'tegangan_id' => '9a6ae0c5-748b-4faa-b501-48a8eacad2a3', 'section_id' => '', 'created_by' => 'System', 'created_at' => Carbon::now()]);
        locations::create(['parent_id' => '9ad8a61c-224b-49b3-ae16-20ee00c64530', 'nm_lokasi' => 'MARKAS PDKB SEMARANG JARINGAN', 'description' => 'MARKAS PDKB SEMARANG JARINGAN', 'id_functloc' => 'TRS-3517-HLM.621', 'sup_functloc' => 'TRS-3517', 'latitude' => '', 'longitude' => '', 'nlevel' => '3', 'status_id' => '9a6adbbe-eeb2-49ba-afd2-0e534440ab99', 'fungsi_id' => '9a6ae5a7-0f8e-48b0-8931-f2b1241ce20b', 'tegangan_id' => '9a6ae0c5-748b-4faa-b501-48a8eacad2a3', 'section_id' => '', 'created_by' => 'System', 'created_at' => Carbon::now()]);
        locations::create(['parent_id' => '9ad8a61c-224b-49b3-ae16-20ee00c64530', 'nm_lokasi' => 'MARKAS PDKB SEMARANG GI', 'description' => 'MARKAS PDKB SEMARANG GI', 'id_functloc' => 'TRS-3517-HLM.622', 'sup_functloc' => 'TRS-3517', 'latitude' => '', 'longitude' => '', 'nlevel' => '3', 'status_id' => '9a6adbbe-eeb2-49ba-afd2-0e534440ab99', 'fungsi_id' => '9a6ae5a7-0f8e-48b0-8931-f2b1241ce20b', 'tegangan_id' => '9a6ae0c5-748b-4faa-b501-48a8eacad2a3', 'section_id' => '', 'created_by' => 'System', 'created_at' => Carbon::now()]);
        locations::create(['parent_id' => '9ad8a61c-224b-49b3-ae16-20ee00c64530', 'nm_lokasi' => 'LAB. P3B JB APP SEMARANG', 'description' => 'LAB. P3B JB APP SEMARANG', 'id_functloc' => 'TRS-3517-LAB.001', 'sup_functloc' => 'TRS-3517', 'latitude' => '', 'longitude' => '', 'nlevel' => '3', 'status_id' => '9a6adbbe-eeb2-49ba-afd2-0e534440ab99', 'fungsi_id' => '9a6ae5a7-1035-451e-92da-9b8daf506e04', 'tegangan_id' => '9a6ae0c5-748b-4faa-b501-48a8eacad2a3', 'section_id' => '', 'created_by' => 'System', 'created_at' => Carbon::now()]);
    }
}
