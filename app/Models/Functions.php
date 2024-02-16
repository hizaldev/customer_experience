<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Functions extends Model
{
    use HasFactory, HasRoles, HasUuids, SoftDeletes;
    protected $fillable = [
        'kd_fungsi',
        'fungsi',
        'nlevel',
        'keterangan',
    ];

    public function lokasi()
    {
        return $this->belongsTo(Locations::class);
    }
}
