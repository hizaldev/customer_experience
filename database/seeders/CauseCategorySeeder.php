<?php

namespace Database\Seeders;

use App\Models\CauseCategory;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CauseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CauseCategory::create(["id" => "9b3c394d-5e8c-4e1d-9065-2d1762daa86c", "kategori_penyebab" => "Alat", "keterangan" => "-", "created_by" => "System", "created_at" => Carbon::now()]);
        CauseCategory::create(["id" => "9b3c3958-b818-43c6-85f4-4110b31aac48", "kategori_penyebab" => "APPL", "keterangan" => "-", "created_by" => "System", "created_at" => Carbon::now()]);
        CauseCategory::create(["id" => "9b44a9ac-9bdd-4b1a-8490-6de97fe65506", "kategori_penyebab" => "Banjir", "keterangan" => "-", "created_by" => "System", "created_at" => Carbon::now()]);
        CauseCategory::create(["id" => "9b44a9b6-a657-448a-a478-f2883c55e237", "kategori_penyebab" => "Benda Asing", "keterangan" => "-", "created_by" => "System", "created_at" => Carbon::now()]);
        CauseCategory::create(["id" => "9b44a9c0-278f-4a44-b2af-d0f72df7dffd", "kategori_penyebab" => "Binatang", "keterangan" => "-", "created_by" => "System", "created_at" => Carbon::now()]);
        CauseCategory::create(["id" => "9b44a9c9-708d-4eb6-8a0d-71ed545ff91e", "kategori_penyebab" => "Distribusi", "keterangan" => "-", "created_by" => "System", "created_at" => Carbon::now()]);
        CauseCategory::create(["id" => "9b44a9d2-e191-454d-87f2-a912225a1f94", "kategori_penyebab" => "Lainnya", "keterangan" => "-", "created_by" => "System", "created_at" => Carbon::now()]);
        CauseCategory::create(["id" => "9b44a9dd-4973-43b9-97cd-7d4780ef2c4b", "kategori_penyebab" => "Layang - Layang", "keterangan" => "-", "created_by" => "System", "created_at" => Carbon::now()]);
        CauseCategory::create(["id" => "9b44a9e6-ba31-4c13-85b7-478bc0107df6", "kategori_penyebab" => "Masa Garansi", "keterangan" => "-", "created_by" => "System", "created_at" => Carbon::now()]);
        CauseCategory::create(["id" => "9b44a9f0-724c-4a4c-aaab-e9263165afa5", "kategori_penyebab" => "Pembangkit", "keterangan" => "-", "created_by" => "System", "created_at" => Carbon::now()]);
        CauseCategory::create(["id" => "9b44a9fd-6a83-446d-afc9-716df4fb2274", "kategori_penyebab" => "Petir", "keterangan" => "-", "created_by" => "System", "created_at" => Carbon::now()]);
        CauseCategory::create(["id" => "9b44aa0d-3881-4642-9189-e3c5e4b4d296", "kategori_penyebab" => "Sistem", "keterangan" => "-", "created_by" => "System", "created_at" => Carbon::now()]);
        CauseCategory::create(["id" => "9b44aa15-16fb-4a7e-aed8-c077d7c7826d", "kategori_penyebab" => "Tegakan", "keterangan" => "-", "created_by" => "System", "created_at" => Carbon::now()]);
    }
}
