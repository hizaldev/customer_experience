<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class JenisGangguans extends Model
{
    use HasFactory, HasUuids, SoftDeletes, HasRoles;

    protected $fillable = [
        'jenis_gangguan',
        'keterangan',
    ];

    public function gangguan()
    {
        return $this->belongsTo(Gangguans::class);
    }
}
