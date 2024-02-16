<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Pqm extends Model
{
    use HasFactory, HasUuids, SoftDeletes, HasRoles;

    protected $table = 'pqm_consumers';

    protected $fillable = [
        'upt_id',
        'ultg_id',
        'substation_id',
        'datetime',
        'dist_dur',
        'presentase_r',
        'voltage_r',
        'dist_vr_min',
        'dist_vr_max',
        'dist_vr_avg',
        'dist_vr_eng',
        'presentase_s',
        'voltage_s',
        'dist_vs_min',
        'dist_vs_max',
        'dist_vs_avg',
        'dist_vs_eng',
        'presentase_t',
        'voltage_t',
        'dist_vt_min',
        'dist_vt_max',
        'dist_vt_avg',
        'dist_vt_eng',
        'gardu_induk',
        'bay',
        'kondisi',
        'waktu_gangguan',
        'penyebab',
        'keterangan',
    ];

    public function location_upt()
    {
        return $this->hasOne(Pqm::class, 'id', 'upt_id');
    }

    public function location_ultg()
    {
        return $this->hasOne(Pqm::class, 'id', 'ultg_id');
    }

    public function location_gi()
    {
        return $this->hasOne(Pqm::class, 'id', 'substation_id');
    }
}
