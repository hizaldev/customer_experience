<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Locations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    // api UPT
    public function ultg(Request $request, $id_parent)
    {
        return Locations::where('parent_id', $id_parent)
            ->where('nlevel', 3)
            ->where('fungsi_id', '9a6ae5a7-0d8e-4ce8-b809-9b7ff557a338')
            ->get(['id', 'description']);
    }

    public function garduInduk(Request $request, $section_id)
    {
        return Locations::where('section_id', $section_id)
            ->where('nlevel', 3)
            ->where('fungsi_id', '9a6ae5a7-0f5f-4cb1-a117-d14792d30537')
            ->get(['id', 'description']);
    }

    public function bays(Request $request, $id_parent)
    {
        return Locations::where('parent_id', $id_parent)
            ->where('nlevel', 4)
            // ->where('fungsi_id', '9a6ae5a7-0f5f-4cb1-a117-d14792d30537')
            ->get(['id', 'description']);
    }

    public function garduIndukAll(Request $request)
    {
        return Locations::where('nlevel', 3)
            ->where('fungsi_id', '9a6ae5a7-0f5f-4cb1-a117-d14792d30537')
            ->get(['id', 'description']);
    }

    public function subsystem(Request $request, $substation_id)
    {
        return DB::table('subsystems')
            ->select(
                DB::raw(
                    '
                    DISTINCT subsystems.id, subsystems.subsystem
                '
                )
            )
            ->leftjoin('subsystem_details', function ($join) {
                $join->on('subsystem_details.subsystem_id', '=', 'subsystems.id');
            })
            ->where('subsystem_details.substation_id', $substation_id)
            ->whereNull('subsystems.deleted_at')->get();
    }
}
