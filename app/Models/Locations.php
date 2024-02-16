<?php

namespace App\Models;

use App\Blameable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Locations extends Model
{
    use HasFactory, HasRoles, HasUuids, SoftDeletes;

    protected $fillable = [
        'parent_id',
        'nm_lokasi',
        'description',
        'id_functloc',
        'sup_functloc',
        'nlevel',
        'status_id',
        'fungsi_id',
        'tegangan_id',
    ];

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function tegangan()
    {
        return $this->hasOne(Voltages::class, 'id', 'tegangan_id');
    }

    public function fungsi()
    {
        return $this->hasOne(Functions::class, 'id', 'fungsi_id');
    }

    public function konsumen()
    {
        return $this->belongsTo(Consumers::class);
    }

    public function subsystemDetail()
    {
        return $this->belongsTo(SubsystemDetails::class);
    }

    public function upt_pqm()
    {
        return $this->belongsTo(Consumers::class);
    }

    public function gangguan()
    {
        return $this->belongsTo(Locations::class);
    }

    // menampilkan data level 1 berdasarkan level 1 sample data upt by induk
    public function scopeByLevelOne($query, $levelInduk)
    {
        return $query->where('nlevel', 1)->where('id', $levelInduk);
    }

    // menampilkan data level 2 berdasarkan level 1 sampple data upt by induk
    public function scopeByLevelTwo($query, $levelInduk, $levelUpt, $isInduk)
    {
        return $isInduk
            //  menampilkan unit level 2 berdasarkan induknya
            ? $query->where('nlevel', 2)->where('parent_id', $levelInduk)
            // menampilkan data upt berdasarkan uptnya select UPT
            : $query->where('nlevel', 2)->where('id', $levelUpt);
    }

    // menampilkan data level 2 berdasarkan level 1 sampple data upt by induk
    public function scopeByLevelThreeUltg($query, $levelUpt, $levelUltg, $isUpt)
    {
        return $isUpt
            //  menampilkan unit level 3 berdasarkan upt nya
            ? $query->where('nlevel', 3)->where('parent_id', $levelUpt)->where('fungsi_id', '9a6ae5a7-0d8e-4ce8-b809-9b7ff557a338')
            // menampilkan data upt berdasarkan uptnya select ULTG
            : $query->where('nlevel', 3)->where('id', $levelUltg);
    }

    // menampilkan data level 2 berdasarkan level 1 sampple data upt by induk
    public function scopeByLevelThreeSubstation($query, $levelUltg, $levelSubstation, $isUltg)
    {
        // isUltg ini menggambarkan bahwa dia user dengan role ULTG
        $in = explode(",", $levelSubstation);
        return $isUltg
            //  menampilkan unit level 3 substation berdasarkan ULTGnya nya
            ? $query->where('nlevel', 3)->where('section_id', $levelUltg)
            // menampilkan data substation berdasarkan ULTG nya select Substation
            : $query->whereIn('id', $in);
    }
}
