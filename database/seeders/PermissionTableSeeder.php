<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'settings_role-list',
            'settings_role-create',
            'settings_role-edit',
            'settings_role-delete',
            'settings_permission-list',
            'settings_permission-create',
            'settings_permission-edit',
            'settings_permission-delete',
            'settings_user-list-all',
            'settings_user-list',
            'settings_user-create',
            'settings_user-edit',
            'settings_user-delete',
            'master_tegangan-list',
            'master_tegangan-create',
            'master_tegangan-edit',
            'master_tegangan-delete',
            'master_status-list',
            'master_status-create',
            'master_status-edit',
            'master_status-delete',
            'master_fungsi-list',
            'master_fungsi-create',
            'master_fungsi-edit',
            'master_fungsi-delete',
            'master_cuaca-list',
            'master_cuaca-create',
            'master_cuaca-edit',
            'master_cuaca-delete',
            'lokasi_induk-list',
            'lokasi_induk-create',
            'lokasi_induk-edit',
            'lokasi_induk-delete',
            'lokasi_unit_pelayanan-list',
            'lokasi_unit_pelayanan-create',
            'lokasi_unit_pelayanan-edit',
            'lokasi_unit_pelayanan-delete',
            'lokasi_unit_layanan-list',
            'lokasi_unit_layanan-create',
            'lokasi_unit_layanan-edit',
            'lokasi_unit_layanan-delete',
            'lokasi_gardu_induk-list',
            'lokasi_gardu_induk-create',
            'lokasi_gardu_induk-edit',
            'lokasi_gardu_induk-delete',
            'master_konsumen-list',
            'master_konsumen-create',
            'master_konsumen-edit',
            'master_konsumen-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
