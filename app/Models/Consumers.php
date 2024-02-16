<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Consumers extends Model
{
    use HasFactory, HasUuids, Blameable, SoftDeletes, HasRoles;

    protected $fillable = [
        'nama_ktt',
        'alamat',
        'location_id',
        'area_id',
    ];

    public function lokasi()
    {
        return $this->hasOne(Locations::class, 'id', 'location_id');
    }
}
