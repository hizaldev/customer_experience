<?php

namespace Database\Seeders;

use App\Models\BmkgWeathers;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BmkgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BmkgWeathers::create(['id' => 0, 'cuaca' => 'Cerah', 'image' => 'https://www.bmkg.go.id/asset/img/icon-cuaca/cerah-am.png', 'potensi_cuaca' => '<p>Cuaca Cerah cenderung membuat sistem kondisi lebih aman dari potensi gangguan petir tetapi perlu perhatian terhadap potensi gangguan diakibatkan karena layang-layang dan benda lain di SUTT 150 kV dan SUTET 500 kV.</p>', 'created_by' => 'System', 'created_at' => Carbon::now()]);
        BmkgWeathers::create(['id' => 1, 'cuaca' => 'Cerah Berawan', 'image' => 'https://www.bmkg.go.id/asset/img/icon-cuaca/cerah%20berawan-am.png', 'potensi_cuaca' => '<p>Cuaca Cerah sedikit berawan cenderung membuat sistem kondisi lebih aman dari potensi gangguan petir tetapi perlu perhatian terhadap potensi gangguan diakibatkan karena layang-layang dan benda lain di SUTT 150 kV dan SUTET 500 kV.</p>', 'created_by' => 'System', 'created_at' => Carbon::now()]);
        BmkgWeathers::create(['id' => 2, 'cuaca' => 'Cerah Berawan', 'image' => 'https://www.bmkg.go.id/asset/img/icon-cuaca/cerah%20berawan-am.png', 'potensi_cuaca' => '<p>Cuaca Cerah cenderung membuat sistem kondisi lebih aman dari potensi gangguan petir tetapi perlu perhatian terhadap potensi gangguan diakibatkan karena layang-layang dan benda lain di SUTT 150 kV dan SUTET 500 kV.</p>', 'created_by' => 'System', 'created_at' => Carbon::now()]);
        BmkgWeathers::create(['id' => 3, 'cuaca' => 'Berawan', 'image' => 'https://www.bmkg.go.id/asset/img/icon-cuaca/berawan-am.png', 'potensi_cuaca' => '<p>Cuaca Cerah berawan membuat kondisi sistem lebih siaga dikarenakan adanya potensi gangguan petir tetapi perlu perhatian terhadap potensi gangguan diakibatkan karena layang-layang dan benda lain di SUTT 150 kV dan SUTET 500 kV.</p>', 'created_by' => 'System', 'created_at' => Carbon::now()]);
        BmkgWeathers::create(['id' => 4, 'cuaca' => 'Berawan Tebal', 'image' => 'https://www.bmkg.go.id/asset/img/icon-cuaca/berawan%20tebal-am.png', 'potensi_cuaca' => '<p>Cuaca Cerah berawan membuat kondisi sistem lebih siaga dikarenakan adanya potensi gangguan petir tetapi perlu perhatian terhadap potensi gangguan diakibatkan karena layang-layang dan benda lain di SUTT 150 kV dan SUTET 500 kV.</p>', 'created_by' => 'System', 'created_at' => Carbon::now()]);
        BmkgWeathers::create(['id' => 5, 'cuaca' => 'Udara Kabur', 'image' => 'https://www.bmkg.go.id/asset/img/icon-cuaca/udara%20kabur-am.png', 'potensi_cuaca' => '<p>Humidity tinggi membuat kondisi sistem lebih siaga dikarenakan adanya potensi gangguan akibat polutan batubara maupun debu tetapi perlu perhatian terhadap potensi gangguan diakibatkan karena layang-layang dan benda lain di SUTT 150 kV dan SUTET 500 kV.', 'created_by' => 'System', 'created_at' => Carbon::now()]);
        BmkgWeathers::create(['id' => 10, 'cuaca' => 'Asap ', 'image' => 'https://www.bmkg.go.id/asset/img/icon-cuaca/asap-am.png', 'potensi_cuaca' => '<p>Humidity tinggi membuat kondisi sistem lebih siaga dikarenakan adanya potensi gangguan akibat polutan batubara maupun debu tetapi perlu perhatian terhadap potensi gangguan diakibatkan karena layang-layang dan benda lain di SUTT 150 kV dan SUTET 500 kV.', 'created_by' => 'System', 'created_at' => Carbon::now()]);
        BmkgWeathers::create(['id' => 45, 'cuaca' => 'Kabut', 'image' => 'https://www.bmkg.go.id/asset/img/icon-cuaca/kabut-am.png', 'potensi_cuaca' => '<p>Humidity tinggi membuat kondisi sistem lebih siaga dikarenakan adanya potensi gangguan akibat polutan batubara maupun debu tetapi perlu perhatian terhadap potensi gangguan diakibatkan karena layang-layang dan benda lain di SUTT 150 kV dan SUTET 500 kV.', 'created_by' => 'System', 'created_at' => Carbon::now()]);
        BmkgWeathers::create(['id' => 60, 'cuaca' => 'Hujang Ringan', 'image' => 'https://www.bmkg.go.id/asset/img/icon-cuaca/hujan%20ringan-am.png', 'potensi_cuaca' => '<p>Cuaca hujan membuat kondisi sistem siaga dikarenakan adanya potensi gangguan petir di SUTT 150 kV dan SUTET 500 kV.</p>', 'created_by' => 'System', 'created_at' => Carbon::now()]);
        BmkgWeathers::create(['id' => 61, 'cuaca' => 'Hujan Sedang', 'image' => 'https://www.bmkg.go.id/asset/img/icon-cuaca/hujan%20sedang-am.png', 'potensi_cuaca' => '<p>Cuaca hujan membuat kondisi sistem siaga dikarenakan adanya potensi gangguan petir di SUTT 150 kV dan SUTET 500 kV.</p>', 'created_by' => 'System', 'created_at' => Carbon::now()]);
        BmkgWeathers::create(['id' => 63, 'cuaca' => 'Hujan Lebat', 'image' => 'https://www.bmkg.go.id/asset/img/icon-cuaca/hujan%20lebat-am.png', 'potensi_cuaca' => '<p>Hujan lebat berpotensi menyebabkan gangguan petir terhadap jaringan SUTT dan SUTET serta adanya bahaya gangguan alam terhadap sistem transmisi</p>', 'created_by' => 'System', 'created_at' => Carbon::now()]);
        BmkgWeathers::create(['id' => 80, 'cuaca' => 'Hujan Lokal', 'image' => 'https://www.bmkg.go.id/asset/img/icon-cuaca/hujan%20lokal-am.png', 'potensi_cuaca' => '<p>Hujan di sekitar area berpotensi menyebabkan adanya gangguan terhadap instalasi SUTT SUTET</p>', 'created_by' => 'System', 'created_at' => Carbon::now()]);
        BmkgWeathers::create(['id' => 95, 'cuaca' => 'Hujan Petir', 'image' => 'https://www.bmkg.go.id/asset/img/icon-cuaca/hujan%20petir-am.png', 'potensi_cuaca' => '<p>Hujan disertai petir berpotensi menyebabkan gangguan instalasi di Gardu Induk dan SUTT SUTET</p>', 'created_by' => 'System', 'created_at' => Carbon::now()]);
        BmkgWeathers::create(['id' => 97, 'cuaca' => 'Hujan Petir', 'image' => 'https://www.bmkg.go.id/asset/img/icon-cuaca/hujan%20petir-am.png', 'potensi_cuaca' => '', 'created_by' => 'System', 'created_at' => Carbon::now()]);
    }
}
