<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class BmkgWeathers extends Model
{
    use HasFactory, HasRoles, SoftDeletes;

    protected $fillable = [
        'id',
        'cuaca',
        'image',
        'potensi_cuaca',
        'keterangan',
    ];
}
