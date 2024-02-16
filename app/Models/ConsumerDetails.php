<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class ConsumerDetails extends Model
{
    use HasFactory, HasRoles, Blameable, SoftDeletes, HasUuids;

    protected $fillable = [
        'consumer_id',
        'location_id',
        'location_bay_id',
    ];
}
