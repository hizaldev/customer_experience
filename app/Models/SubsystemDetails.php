<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubsystemDetails extends Model
{
    use HasFactory, HasUuids, SoftDeletes, Blameable;

    protected $fillable = [
        'subsystem_id',
        'substation_id',
        'id_functloc',
        'substation',
        'keterangan',
    ];


    public function subsystem()
    {
        return $this->belongsTo(Subsystems::class);
    }

    public function subsystemDetail()
    {
        return $this->hasOne(Locations::class, 'id', 'substation_id');
    }
}
