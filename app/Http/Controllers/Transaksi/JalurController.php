<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Constant\ConstantController;
use App\Http\Controllers\Controller;
use App\Imports\JalursImport;
use App\Models\Jalurs;
use App\Models\Locations;
use App\Models\Subsystems;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class JalurController extends Controller
{
    var $route = 'jalur.index';
    var $path_view = 'transaksi.jalur';

    function __construct()
    {
        $this->middleware('permission:transaksi_pqm_ktt-list|transaksi_pqm_ktt-import|role-edit|transaksi_pqm_ktt-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:transaksi_pqm_ktt-import', ['only' => ['store']]);
        $this->middleware('permission:transaksi_pqm_ktt-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:transaksi_pqm_ktt-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $item = User::find(Auth::user()->id);
        $subsystem = Subsystems::all();
        $subsystem_id = $request->get('subsystem_id') ? $request->get('subsystem_id') : null;
        $endDate =  $request->get('tgl_awal') ?  $request->get('tgl_awal') : Carbon::now()->locale('id')->isoFormat('Y-MM-DD');
        $startDate = $request->get('tgl_akhir') ?  $request->get('tgl_akhir') : Carbon::now()->subDays(30)->locale('id')->isoFormat('Y-MM-DD');

        $data = DB::table('jalurs')
            ->select(
                DB::raw(
                    '
                    jalurs.*,
                    upt.nm_lokasi as upt,
                    ultg.nm_lokasi as ultg,
                    substation.nm_lokasi as gi,
                    subsystems.subsystem as subsystem
                '
                )
            )
            ->leftjoin('locations as upt', function ($join) {
                $join->on('jalurs.upt_id', '=', 'upt.id');
            })
            ->leftjoin('locations as ultg', function ($join) {
                $join->on('jalurs.ultg_id', '=', 'ultg.id');
            })
            ->leftjoin('locations as substation', function ($join) {
                $join->on('jalurs.substation_id', '=', 'substation.id');
            })
            ->leftjoin('subsystems', function ($join) {
                $join->on('jalurs.subsystem_id', '=', 'subsystems.id');
            })
            ->whereBetween('jalurs.awal_jadwal', [$endDate, $startDate])
            ->whereNull('jalurs.deleted_at');
        if ($item->can('transaksi_jalur-list')) {
            $unit = Locations::byLevelTwo($item->level_induk, $item->level_upt, true)->get();
            $unit_id = $request->get('upt_id') ? $request->get('upt_id') : $item->level_upt;
            $ultg = [];
            $ultg_id = $request->get('ultg_id') ? $request->get('ultg_id') : $item->level_ultg;
            $substation = [];
            $substation_id = $request->get('substation_id') ? $request->get('substation_id') : $item->level_substation;
        }
        if ($item->can('transaksi_jalur-list-induk')) {
            $unit = Locations::byLevelTwo($item->level_induk, $item->level_upt, true)->get();
            $unit_id = $request->get('upt_id') ? $request->get('upt_id') : $item->level_upt;
            $ultg = [];
            $ultg_id = $request->get('ultg_id') ? $request->get('ultg_id') : $item->level_ultg;
            $substation = [];
            $substation_id = $request->get('substation_id') ? $request->get('substation_id') : $item->level_substation;
        }
        if ($item->can('transaksi_jalur-list-unit')) {
            $unit = Locations::byLevelTwo($item->level_induk, $item->level_upt, false)->get();
            $unit_id = $request->get('upt_id') ? $request->get('upt_id') : $item->level_upt;
            $ultg = Locations::byLevelThreeUltg($item->level_upt, $item->level_ultg, true)->get();;
            $ultg_id = $request->get('ultg_id') ? $request->get('ultg_id') : $item->level_ultg;
            $substation = [];
            $substation_id = $request->get('substation_id') ? $request->get('substation_id') : $item->level_substation;
        }

        // start filter pencarian
        if ($unit_id != null && $ultg_id == null && $substation_id == null && $subsystem_id == null) {
            $data->where('jalurs.upt_id', $unit_id);
        }

        if ($unit_id != null && $ultg_id != null && $substation_id == null && $subsystem_id == null) {
            $data->where('jalurs.upt_id', $unit_id)
                ->where('jalurs.ultg_id', $ultg_id);
        }

        if ($unit_id != null && $ultg_id != null && $substation_id != null && $subsystem_id == null) {
            $data->where('jalurs.upt_id', $unit_id)
                ->where('jalurs.ultg_id', $ultg_id)
                ->whereIn('jalurs.substation_id', [$substation_id]);
        }

        if ($unit_id != null && $ultg_id != null && $substation_id != null && $subsystem_id != null) {

            $data->where('jalurs.upt_id', $unit_id)
                ->where('jalurs.ultg_id', $ultg_id)
                ->whereIn('jalurs.substation_id', [$substation_id])
                ->where('jalurs.subsystem_id', $subsystem_id);
        }

        if ($unit_id != null && $ultg_id == null && $substation_id == null && $subsystem_id != null) {
            $data->where('jalurs.upt_id', $unit_id)
                ->where('jalurs.subsystem_id', $subsystem_id);
        }

        if ($unit_id != null && $ultg_id != null && $substation_id == null && $subsystem_id != null) {
            $data->where('jalurs.upt_id', $unit_id)
                ->where('jalurs.ultg_id', $ultg_id)
                ->where('jalurs.subsystem_id', $subsystem_id);
        }
        if (request()->ajax()) {

            return DataTables::of($data->get())
                ->addColumn('edit', function ($item) {
                    return '

                        <a class="btn btn-success btn-sm btn-icon w-100 text-white" href="' . route('fungsi.edit', $item->id) . '">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 15l8.385 -8.415a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3z"></path>
                                <path d="M16 5l3 3"></path>
                                <path d="M9 7.07a7 7 0 0 0 1 13.93a7 7 0 0 0 6.929 -6"></path>
                            </svg>
                        </a>
                    ';
                })
                ->addColumn('delete', function ($item) {
                    return '
                        <form action="' . route('fungsi.destroy', $item->id) . '" method="POST" id="form" class="form-inline" onSubmit="if (confirm(`Apakah anda yakin menghapus data? Data yang sudah dihapus tidak dapat dikembalikan`)) run; return false">
                            ' . method_field('delete') . csrf_field() . '
                            <button type="submit" class="btn btn-danger btn-sm btn-icon text-white w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 7l16 0"></path>
                                    <path d="M10 11l0 6"></path>
                                    <path d="M14 11l0 6"></path>
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                </svg>
                            </button>
                        </form>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['edit', 'delete'])
                ->make();
        }

        //dd($data);
        return view("$this->path_view.index", [
            'unit' => $unit,
            'unit_id' => $unit_id,
            'ultg' => $ultg,
            'ultg_id' => $ultg_id,
            'substation' => $substation,
            'substation_id' => $substation_id,
            'subsystem' => $subsystem,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("$this->path_view.create", []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            Excel::import(new JalursImport(), request()->file('file_jalur'));
            ConstantController::successAlert();
        } catch (Exception $e) {
            ConstantController::errorAlert($e->getMessage());
        }


        return redirect()->route($this->route);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Jalurs::find($id);

        return view("$this->path_view.edit", [
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'kd_fungsi' => 'required',
            'fungsi' => 'required',
        ]);

        try {
            $data['kd_fungsi'] = $request->kd_fungsi;
            $data['fungsi'] = $request->fungsi;
            $data['keterangan'] = $request->keterangan;

            $item = Jalurs::findOrFail($id);
            $item->update($data);

            ConstantController::successAlert();
        } catch (Exception $e) {
            ConstantController::errorAlert($e->getMessage());
        }
        return redirect()->route($this->route);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Jalurs::findOrFail($id);
        $item->delete();

        ConstantController::successDeleteAlert();
        return redirect()->route("$this->route");
    }
}
