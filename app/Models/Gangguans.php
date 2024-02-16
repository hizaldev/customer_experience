<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Gangguans extends Model
{
    use HasFactory, HasRoles, SoftDeletes, Blameable, HasUuids;

    protected $table = 'gangguans';

    protected $fillable = [
        'upt_id',
        'ultg_id',
        'substation_id',
        'bay_id',
        'description',
        'anounciator',
        'jenis_gangguan_id',
        'tipe_gangguan_id',
        'subsystem_id',
        'tgl_gangguan',
        'is_main_gangguan',
        'arus_gangguan',
        'arus_gangguan_s',
        'arus_gangguan_t',
        'arus_gangguan_n',
        'indikasi_relay',
        'count_cb_r',
        'count_cb_s',
        'count_cb_t',
        'count_la_r',
        'count_la_s',
        'count_la_t',
        'beban_sebelum_mw',
        'beban_sebelum_mvar',
        'penyebab_gangguan',
        'kondisi_lingkungan',
    ];

    public function substation()
    {
        return $this->hasOne(Locations::class, 'id', 'substation_id');
    }

    public function bay()
    {
        return $this->hasOne(Locations::class, 'id', 'bay_id');
    }

    public function jenisGangguan()
    {
        return $this->hasOne(JenisGangguans::class, 'id', 'jenis_gangguan_id');
    }

    public function tipeGangguan()
    {
        return $this->hasOne(TipeGangguans::class, 'id', 'tipe_gangguan_id');
    }

    public function investigasi()
    {
        return $this->hasOne(Investigations::class, 'gangguan_id', 'id');
    }

    public function tindaklanjut()
    {
        return $this->hasOne(FollowUps::class, 'gangguan_id', 'id');
    }

    public function subsystem()
    {
        return $this->hasOne(Subsystems::class, 'id', 'subsystem_id');
    }
}
