<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Status extends Model
{
    use HasFactory, SoftDeletes, HasUuids, HasRoles;

    protected $table = 'status';

    protected $fillable = [
        'id_status',
        'status',
        'keterangan',
    ];

    public function lokasi()
    {
        return $this->belongsTo(Locations::class);
    }
}
