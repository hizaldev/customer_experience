<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class FollowUps extends Model
{
    use HasFactory, HasRoles, SoftDeletes, Blameable, HasUuids;

    protected $fillable = [
        'gangguan_id',
        'tgl_tindaklanjut',
        'kategori_penyebab_id',
        'pelaksana_satu',
        'pelaksana_dua',
        'pelaksana_tiga',
        'pelaksana_empat',
        'tindaklanjut',
    ];

    public function gangguan()
    {
        return $this->belongsTo(Gangguans::class);
    }
}
