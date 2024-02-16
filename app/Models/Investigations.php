<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Investigations extends Model
{
    use HasFactory, HasUuids, SoftDeletes, Blameable, HasRoles;

    protected $fillable = [
        'gangguan_id',
        'tgl_investigasi',
        'pelaksana_satu',
        'pelaksana_dua',
        'pelaksana_tiga',
        'pelaksana_empat',
        'investigasi',
    ];

    public function gangguan()
    {
        return $this->belongsTo(Gangguans::class);
    }
}
