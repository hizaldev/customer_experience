<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Subsystems extends Model
{
    use HasFactory, HasRoles, HasUuids, SoftDeletes, Blameable;

    protected $fillable = [
        'subsystem',
        'keterangan',
    ];

    public function subsystemDetail()
    {
        return $this->hasMany(SubsystemDetails::class, 'subsystem_id', 'id');
    }

    public function gangguan()
    {
        return $this->belongsTo(Gangguans::class);
    }
}
