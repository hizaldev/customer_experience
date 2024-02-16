<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Jalurs extends Model
{
    use HasFactory, HasUuids, SoftDeletes, HasRoles, Blameable;

    protected $fillable = [
        'upt_id',
        'ultg_id',
        'substation_id',
        'subsystem_id',
        'no_wo',
        'no_notif',
        'location',
        'uraian_pekerjaan',
        'tegangan',
        'id_functloc',
        'peralatan_padam',
        'sifat',
        'penanggung_jawab',
        'no_spk',
        'awal_usulan',
        'akhir_usulan',
        'jam_usulan',
        'awal_jadwal',
        'akhir_jadwal',
        'jam_jadwal',
        'rencana',
        'keterangan',
        'created_by',
        'created_at',
        'updated_at',
    ];
}
