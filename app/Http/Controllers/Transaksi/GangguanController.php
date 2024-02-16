<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Constant\ConstantController;
use App\Http\Controllers\Controller;
use App\Models\Gangguans;
use App\Models\JenisGangguans;
use App\Models\Locations;
use App\Models\Subsystems;
use App\Models\TipeGangguans;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class GangguanController extends Controller
{
    var $route = 'gangguan.index';
    var $path_view = 'transaksi.gangguan';

    function __construct()
    {
        $this->middleware('permission:transaksi_gangguan-list|transaksi_gangguan-create|role-edit|transaksi_gangguan-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:transaksi_gangguan-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:transaksi_gangguan-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:transaksi_gangguan-delete', ['only' => ['destroy']]);
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

        $data = DB::table('gangguans')
            ->select(
                DB::raw(
                    '
                    gangguans.id,
                    gangguans.tgl_gangguan,
                    jenis_gangguans.jenis_gangguan,
                    tipe_gangguans.tipe_gangguan,
                    upt.nm_lokasi as upt,
                    ultg.nm_lokasi as ultg,
                    substation.nm_lokasi as gi,
                    bay.nm_lokasi as bay,
                    subsystems.subsystem as subsystem
                '
                )
            )
            ->leftjoin('locations as upt', function ($join) {
                $join->on('gangguans.upt_id', '=', 'upt.id');
            })
            ->leftjoin('locations as ultg', function ($join) {
                $join->on('gangguans.ultg_id', '=', 'ultg.id');
            })
            ->leftjoin('locations as substation', function ($join) {
                $join->on('gangguans.substation_id', '=', 'substation.id');
            })
            ->leftjoin('locations as bay', function ($join) {
                $join->on('gangguans.bay_id', '=', 'bay.id');
            })
            ->leftjoin('jenis_gangguans', function ($join) {
                $join->on('gangguans.jenis_gangguan_id', '=', 'jenis_gangguans.id');
            })
            ->leftjoin('tipe_gangguans', function ($join) {
                $join->on('gangguans.tipe_gangguan_id', '=', 'tipe_gangguans.id');
            })
            ->leftjoin('subsystems', function ($join) {
                $join->on('gangguans.subsystem_id', '=', 'subsystems.id');
            })
            ->whereBetween('gangguans.tgl_gangguan', [$endDate, $startDate])
            ->whereNull('gangguans.deleted_at');
        if ($item->can('transaksi_gangguan-list')) {
            $unit = Locations::byLevelTwo($item->level_induk, $item->level_upt, true)->get();
            $unit_id = $request->get('upt_id') ? $request->get('upt_id') : $item->level_upt;
            $ultg = [];
            $ultg_id = $request->get('ultg_id') ? $request->get('ultg_id') : $item->level_ultg;
            $substation = [];
            $substation_id = $request->get('substation_id') ? $request->get('substation_id') : $item->level_substation;
        }
        if ($item->can('transaksi_gangguan-list-induk')) {
            $unit = Locations::byLevelTwo($item->level_induk, $item->level_upt, true)->get();
            $unit_id = $request->get('upt_id') ? $request->get('upt_id') : $item->level_upt;
            $ultg = [];
            $ultg_id = $request->get('ultg_id') ? $request->get('ultg_id') : $item->level_ultg;
            $substation = [];
            $substation_id = $request->get('substation_id') ? $request->get('substation_id') : $item->level_substation;
        }
        if ($item->can('transaksi_gangguan-list-unit')) {
            $unit = Locations::byLevelTwo($item->level_induk, $item->level_upt, false)->get();
            $unit_id = $request->get('upt_id') ? $request->get('upt_id') : $item->level_upt;
            $ultg = Locations::byLevelThreeUltg($item->level_upt, $item->level_ultg, true)->get();;
            $ultg_id = $request->get('ultg_id') ? $request->get('ultg_id') : $item->level_ultg;
            $substation = [];
            $substation_id = $request->get('substation_id') ? $request->get('substation_id') : $item->level_substation;
        }
        if ($item->can('transaksi_gangguan-list-ultg')) {
            $unit = Locations::byLevelTwo($item->level_induk, $item->level_upt, false)->get();
            $unit_id = $request->get('upt_id') ? $request->get('upt_id') : $item->level_upt;
            $ultg = Locations::byLevelThreeUltg($item->level_upt, $item->level_ultg, false)->get();
            $ultg_id = $request->get('ultg_id') ? $request->get('ultg_id') : $item->level_ultg;
            $substation = Locations::byLevelThreeSubstation($item->level_ultg, $item->level_substation, true)->get();
            $substation_id = $request->get('substation_id') ? $request->get('substation_id') : $item->level_substation;
        }
        if ($item->can('transaksi_gangguan-list-substation')) {
            $unit = Locations::byLevelTwo($item->level_induk, $item->level_upt, false)->get();
            $unit_id = $request->get('upt_id') ? $request->get('upt_id') : $item->level_upt;
            $ultg = Locations::byLevelThreeUltg($item->level_upt, $item->level_ultg, false)->get();
            $ultg_id = $request->get('ultg_id') ? $request->get('ultg_id') : $item->level_ultg;
            $substation = Locations::byLevelThreeSubstation($item->level_ultg, $item->level_substation, false)->get();
            $substation_id = $request->get('substation_id') ? $request->get('substation_id') : $item->level_substation;
        }

        // start filter pencarian
        if ($unit_id != null && $ultg_id == null && $substation_id == null && $subsystem_id == null) {
            $data->where('gangguans.upt_id', $unit_id);
        }

        if ($unit_id != null && $ultg_id != null && $substation_id == null && $subsystem_id == null) {
            $data->where('gangguans.upt_id', $unit_id)
                ->where('gangguans.ultg_id', $ultg_id);
        }

        if ($unit_id != null && $ultg_id != null && $substation_id != null && $subsystem_id == null) {
            $data->where('gangguans.upt_id', $unit_id)
                ->where('gangguans.ultg_id', $ultg_id)
                ->whereIn('gangguans.substation_id', [$substation_id]);
        }

        if ($unit_id != null && $ultg_id != null && $substation_id != null && $subsystem_id != null) {

            $data->where('gangguans.upt_id', $unit_id)
                ->where('gangguans.ultg_id', $ultg_id)
                ->whereIn('gangguans.substation_id', [$substation_id])
                ->where('gangguans.subsystem_id', $subsystem_id);
        }

        if ($unit_id != null && $ultg_id == null && $substation_id == null && $subsystem_id != null) {
            $data->where('gangguans.upt_id', $unit_id)
                ->where('gangguans.subsystem_id', $subsystem_id);
        }

        if ($unit_id != null && $ultg_id != null && $substation_id == null && $subsystem_id != null) {
            $data->where('gangguans.upt_id', $unit_id)
                ->where('gangguans.ultg_id', $ultg_id)
                ->where('gangguans.subsystem_id', $subsystem_id);
        }
        // end filter pencarian
        if (request()->ajax()) {
            return DataTables::of($data)
                ->addColumn('addInvestigasi', function ($item) {
                    return '
            
                        <a class="btn btn-warning btn-sm btn-icon w-100 text-white" href="' . route('investigasi.edit', $item->id) . '" title="Tambah / Edit Investigasi" data-bs-toggle="tooltip"
                        data-bs-placement="top">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-zoom-scan" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4 8v-2a2 2 0 0 1 2 -2h2" />
                                <path d="M4 16v2a2 2 0 0 0 2 2h2" />
                                <path d="M16 4h2a2 2 0 0 1 2 2v2" />
                                <path d="M16 20h2a2 2 0 0 0 2 -2v-2" />
                                <path d="M8 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M16 16l-2.5 -2.5" />
                            </svg>
                        </a>
                    ';
                })
                ->addColumn('addTindaklanjut', function ($item) {
                    return '
            
                        <a class="btn btn-secondary btn-sm btn-icon w-100 text-white" href="' . route('tindaklanjut.edit', $item->id) . '">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-zoom-scan" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M4 8v-2a2 2 0 0 1 2 -2h2" />
                                <path d="M4 16v2a2 2 0 0 0 2 2h2" />
                                <path d="M16 4h2a2 2 0 0 1 2 2v2" />
                                <path d="M16 20h2a2 2 0 0 0 2 -2v-2" />
                                <path d="M8 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M16 16l-2.5 -2.5" />
                            </svg>
                        </a>
                    ';
                })
                ->addColumn('show', function ($item) {
                    return '
                
                    <a onClick="showDetail(this,`' . $item->id . '`)" class="btn btn-primary btn-sm btn-icon w-100 text-white" data-bs-toggle="modal" data-bs-target="#modal-team" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-scan-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 8v-2a2 2 0 0 1 2 -2h2" /><path d="M4 16v2a2 2 0 0 0 2 2h2" />
                            <path d="M16 4h2a2 2 0 0 1 2 2v2" /><path d="M16 20h2a2 2 0 0 0 2 -2v-2" /><path d="M7 12c3.333 -4.667 6.667 -4.667 10 0" />
                            <path d="M7 12c3.333 4.667 6.667 4.667 10 0" /><path d="M12 12h-.01" />
                        </svg>
                    </a>
                ';
                })
                ->addColumn('edit', function ($item) {
                    return '
                    
                        <a class="btn btn-success btn-sm btn-icon w-100 text-white" href="' . route('gangguan.edit', $item->id) . '">
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
                        <form action="' . route('gangguan.destroy', $item->id) . '" method="POST" id="form" class="form-inline" onSubmit="if (confirm(`Apakah anda yakin menghapus data? Data yang sudah dihapus tidak dapat dikembalikan`)) run; return false">
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
                ->rawColumns(['edit', 'delete', 'show', 'addInvestigasi', 'addTindaklanjut'])
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
        $item = User::find(Auth::user()->id);
        // untuk penambahan ini ada 4 user yang bisa menambahkan data gangguan
        // user kantor induk
        // pengisian lokasi di mulai dari pemilihan upt
        // user upt
        // user upt lokasi upt terpilih secara otomatis
        // user ultg
        // user ultg lokasi upt, ultg terpilih secara otomatis
        // user Gardu Induk
        // user gardu induk upt, ultg, gardu induk terpilih secara otomatis dan bay yang muncul sesuai dengan lokasinya
        if ($item->can('transaksi_gangguan-list')) {

            $unit = Locations::byLevelTwo($item->level_induk, $item->level_upt, true)->get();
            $selectUnit = '';
            $ultg = [];
            $selectUltg = '';
            $substation = [];
            $selectSubstation = '';
            $bay = [];
            $selectBay = '';
            $subsystem = [];
        }
        if ($item->can('transaksi_gangguan-list-induk')) {
            $unit = Locations::byLevelTwo($item->level_induk, $item->level_upt, true)->get();
            $selectUnit = '';
            $ultg = [];
            $selectUltg = '';
            $substation = [];
            $selectSubstation = '';
            $bay = [];
            $selectBay = '';
            $subsystem = [];
        }
        if ($item->can('transaksi_gangguan-list-unit')) {
            $unit = Locations::byLevelTwo($item->level_induk, $item->level_upt, false)->get();
            $selectUnit = $item->level_upt;
            $ultg = Locations::byLevelThreeUltg($item->level_upt, $item->level_ultg, true)->get();;
            $selectUltg = '';
            $substation = [];
            $selectSubstation = '';
            $bay = [];
            $selectBay = '';
            $subsystem = [];
        }
        if ($item->can('transaksi_gangguan-list-ultg')) {
            $unit = Locations::byLevelTwo($item->level_induk, $item->level_upt, false)->get();
            $selectUnit = $item->level_upt;
            $ultg = Locations::byLevelThreeUltg($item->level_upt, $item->level_ultg, false)->get();
            $selectUltg = $item->level_ultg;
            $substation = Locations::byLevelThreeSubstation($item->level_ultg, $item->level_substation, true)->get();
            $selectSubstation = '';
            $bay = [];
            $selectBay = '';
            $subsystem = [];
        }
        if ($item->can('transaksi_gangguan-list-substation')) {
            $unit = Locations::byLevelTwo($item->level_induk, $item->level_upt, false)->get();
            $selectUnit = $item->level_upt;
            $ultg = Locations::byLevelThreeUltg($item->level_upt, $item->level_ultg, false)->get();
            $selectUltg = $item->level_ultg;
            $substation = Locations::byLevelThreeSubstation($item->level_ultg, $item->level_substation, false)->get();
            $selectSubstation = $item->level_substation;
            $bay = Locations::where('nlevel', 4)->where('parent_id', $item->substation)->get();
            $selectBay = '';
            $subsystem = DB::table('subsystems')
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
                ->where('subsystem_details.substation_id', $item->substation)
                ->whereNull('subsystems.deleted_at')->get();
        }

        $jenisGangguan = JenisGangguans::all();
        $tipeGangguan = TipeGangguans::all();
        return view("$this->path_view.create", [
            'unit' => $unit,
            'selectUnit' => $selectUnit,
            'ultg' => $ultg,
            'selectUltg' => $selectUltg,
            'substation' => $substation,
            'selectSubstation' => $selectSubstation,
            'bay' => $bay,
            'selectBay' => $selectBay,
            'jenisGangguan' => $jenisGangguan,
            'tipeGangguan' => $tipeGangguan,
            'subsystem' => $subsystem,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'upt_id' => 'required',
            'ultg_id' => 'required',
            'substation_id' => 'required',
            'subsystem_id' => 'required',
            'bay_id' => 'required',
            'jenis_gangguan_id' => 'required',
            'tipe_gangguan_id' => 'required',
            'tgl_gangguan' => 'required',
        ]);
        try {
            $data['upt_id'] = $request->upt_id;
            $data['ultg_id'] = $request->ultg_id;
            $data['substation_id'] = $request->substation_id;
            $data['bay_id'] = $request->bay_id;
            $data['jenis_gangguan_id'] = $request->jenis_gangguan_id;
            $data['tipe_gangguan_id'] = $request->tipe_gangguan_id;
            $data['anounciator'] = $request->anounciator;
            $data['description'] = $request->description;
            $data['tgl_gangguan'] = $request->tgl_gangguan;
            $data['arus_gangguan'] = $request->arus_gangguan == null ? 0.000 : $request->arus_gangguan;
            $data['arus_gangguan_s'] = $request->arus_gangguan_s == null ? 0.000 : $request->arus_gangguan_s;
            $data['arus_gangguan_t'] = $request->arus_gangguan_t == null ? 0.000 : $request->arus_gangguan_t;
            $data['arus_gangguan_n'] = $request->arus_gangguan_n == null ? 0.000 : $request->arus_gangguan_n;
            $data['is_main_gangguan'] = $request->tipe_gangguan_id == '9b2e4a83-ebda-44cd-a5a4-e6b257b7a940' &&  $request->is_main_gangguan == null ? 'Tidak' : "Ya";
            $data['subsystem_id'] = $request->subsystem_id;
            $data['indikasi_relay'] = $request->indikasi_relay;
            $data['count_cb_r'] = $request->count_cb_r;
            $data['count_cb_s'] = $request->count_cb_s;
            $data['count_cb_t'] = $request->count_cb_t;
            $data['count_la_r'] = $request->count_la_r;
            $data['count_la_s'] = $request->count_la_s;
            $data['count_la_t'] = $request->count_la_t;
            $data['beban_sebelum_mw'] = $request->beban_sebelum_mw == null ? 0.000 : $request->beban_sebelum_mw;
            $data['beban_sebelum_mvar'] = $request->beban_sebelum_mvar == null ? 0.000 : $request->beban_sebelum_mvar;
            $data['penyebab_gangguan'] = $request->penyebab_gangguan;
            $data['kondisi_lingkungan'] = $request->cuaca;
            Gangguans::create($data);
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
        $user = User::find(Auth::user()->id);
        $item = Gangguans::find($id);
        if ($user->can('transaksi_gangguan-list')) {
            $unit = Locations::byLevelTwo($user->level_induk, $user->level_upt, true)->get();
            $ultg = [];
            $substation = [];
            $bay = [];
            $subsystem = DB::table('subsystems')
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
                ->where('subsystem_details.substation_id', $item->substation_id)
                ->whereNull('subsystems.deleted_at')->get();
        }
        if ($user->can('transaksi_gangguan-list-induk')) {
            $unit = Locations::byLevelTwo($user->level_induk, $user->level_upt, true)->get();
            $ultg = Locations::byLevelThreeUltg($user->level_upt, $user->level_ultg, true)->get();;
            $substation = Locations::byLevelThreeSubstation($user->level_ultg, $user->level_substation, true)->get();
            $bay = Locations::where('nlevel', 4)->where('parent_id', $item->substation_id)->get();
            $subsystem = DB::table('subsystems')
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
                ->where('subsystem_details.substation_id', $item->substation_id)
                ->whereNull('subsystems.deleted_at')->get();
        }
        if ($user->can('transaksi_gangguan-list-unit')) {
            $unit = Locations::byLevelTwo($user->level_induk, $user->level_upt, false)->get();
            $ultg = Locations::byLevelThreeUltg($user->level_upt, $user->level_ultg, true)->get();;
            $substation = Locations::byLevelThreeSubstation($user->level_ultg, $user->level_substation, true)->get();
            $bay = Locations::where('nlevel', 4)->where('parent_id', $item->substation_id)->get();
            $subsystem = DB::table('subsystems')
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
                ->where('subsystem_details.substation_id', $item->substation_id)
                ->whereNull('subsystems.deleted_at')->get();
        }
        if ($user->can('transaksi_gangguan-list-ultg')) {
            $unit = Locations::byLevelTwo($user->level_induk, $user->level_upt, false)->get();
            $ultg = Locations::byLevelThreeUltg($user->level_upt, $user->level_ultg, false)->get();
            $substation = Locations::byLevelThreeSubstation($user->level_ultg, $user->level_substation, true)->get();
            $bay = Locations::where('nlevel', 4)->where('parent_id', $item->substation_id)->get();
            $subsystem = DB::table('subsystems')
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
                ->where('subsystem_details.substation_id', $item->substation_id)
                ->whereNull('subsystems.deleted_at')->get();
        }
        if ($user->can('transaksi_gangguan-list-substation')) {
            $unit = Locations::byLevelTwo($user->level_induk, $user->level_upt, false)->get();
            $ultg = Locations::byLevelThreeUltg($user->level_upt, $user->level_ultg, false)->get();
            $substation = Locations::byLevelThreeSubstation($user->level_ultg, $user->level_substation, false)->get();
            $bay = Locations::where('nlevel', 4)->where('parent_id', $item->substation_id)->get();
            $subsystem = DB::table('subsystems')
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
                ->where('subsystem_details.substation_id', $item->substation_id)
                ->whereNull('subsystems.deleted_at')->get();
        }
        $jenisGangguan = JenisGangguans::all();
        $tipeGangguan = TipeGangguans::all();
        return view("$this->path_view.edit", [
            'item' => $item,
            'unit' => $unit,
            'ultg' => $ultg,
            'substation' => $substation,
            'bay' => $bay,
            'jenisGangguan' => $jenisGangguan,
            'tipeGangguan' => $tipeGangguan,
            'subsystem' => $subsystem,
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
            'upt_id' => 'required',
            'ultg_id' => 'required',
            'substation_id' => 'required',
            'bay_id' => 'required',
            'jenis_gangguan_id' => 'required',
            'tipe_gangguan_id' => 'required',
            'tgl_gangguan' => 'required',
        ]);

        try {
            $data['upt_id'] = $request->upt_id;
            $data['ultg_id'] = $request->ultg_id;
            $data['substation_id'] = $request->substation_id;
            $data['bay_id'] = $request->bay_id;
            $data['jenis_gangguan_id'] = $request->jenis_gangguan_id;
            $data['tipe_gangguan_id'] = $request->tipe_gangguan_id;
            $data['anounciator'] = $request->anounciator;
            $data['description'] = $request->description;
            $data['tgl_gangguan'] = $request->tgl_gangguan;
            $data['arus_gangguan'] = $request->arus_gangguan == null ? 0.000 : $request->arus_gangguan;
            $data['arus_gangguan_s'] = $request->arus_gangguan_s == null ? 0.000 : $request->arus_gangguan_s;
            $data['arus_gangguan_t'] = $request->arus_gangguan_t == null ? 0.000 : $request->arus_gangguan_t;
            $data['arus_gangguan_n'] = $request->arus_gangguan_n == null ? 0.000 : $request->arus_gangguan_n;
            $data['is_main_gangguan'] = $request->tipe_gangguan_id == '9b2e4a83-ebda-44cd-a5a4-e6b257b7a940' &&  $request->is_main_gangguan == null ? 'Tidak' : "Ya";
            $data['subsystem_id'] = $request->subsystem_id;
            $data['indikasi_relay'] = $request->indikasi_relay;
            $data['count_cb_r'] = $request->count_cb_r;
            $data['count_cb_s'] = $request->count_cb_s;
            $data['count_cb_t'] = $request->count_cb_t;
            $data['count_la_r'] = $request->count_la_r;
            $data['count_la_s'] = $request->count_la_s;
            $data['count_la_t'] = $request->count_la_t;
            $data['beban_sebelum_mw'] = $request->beban_sebelum_mw == null ? 0.000 : $request->beban_sebelum_mw;
            $data['beban_sebelum_mvar'] = $request->beban_sebelum_mvar == null ? 0.000 : $request->beban_sebelum_mvar;
            $data['penyebab_gangguan'] = $request->penyebab_gangguan;
            $data['kondisi_lingkungan'] = $request->cuaca;
            $item = Gangguans::findOrFail($id);
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
        $item = Gangguans::findOrFail($id);
        $item->delete();

        ConstantController::successDeleteAlert();
        return redirect()->route("$this->route");
    }

    public function showDataGangguan(Request $request)
    {
        $detail = Gangguans::with(['investigasi', 'tindaklanjut', 'substation', 'bay', 'jenisGangguan', 'tipeGangguan', 'subsystem'])->where('id', $request->gangguan_id)->first();
        $timeInvestigasi = $detail->investigasi == null ? "Belum ada Investigasi" : "Updated " . $detail->investigasi->created_at->locale('id')->isoFormat('D MMMM Y hh:mm');
        $timeTindakLanjut = $detail->tindaklanjut == null ? "Belum ada Tindaklanjut" : "Updated " . $detail->tindaklanjut->created_at->locale('id')->isoFormat('D MMMM Y hh:mm');
        $statusInvestigasi = $detail->investigasi == null ? 'active' : '';
        $statusTindaklanjut = $detail->tindaklanjut == null ? 'active' : '';
        $actionInvestigasi = $detail->investigasi == null ? '' : $detail->investigasi->investigasi;
        $actionTindaklanjut = $detail->tindaklanjut == null ? '' : $detail->tindaklanjut->tindaklanjut;
        $lists = "";
        $lists .= "
                    <div class='row'>
                        <div class='col-md-12'>
                        <h3>$detail->description</h3>

                        </div>
                        <div class='col-12 col-md-4'>
                            <h3>Time Line Penanganan Gangguan</h3>
                            <div class='card-body'>
                                <ul class='steps steps-vertical'>
                                <li class='step-item $statusInvestigasi '>
                                    <div class='h4 m-0'>Input Data Gangguan</div>
                                    <div class='text-muted'>updated " . $detail->created_at->locale('id')->isoFormat('D MMMM Y hh:mm') . "</div>
                                </li>
                                <li class='step-item $statusTindaklanjut'>
                                    <div class='h4 m-0'>Investigasi Gangguan</div>
                                    <div class='text-muted'>$timeInvestigasi</div>
                                    <div class='text-muted'>$actionInvestigasi</div>
                                </li>
                                <li class='step-item'>
                                    <div class='h4 m-0'>Tindaklanjut Gangguan</div>
                                    <div class='text-muted'>$timeTindakLanjut</div>
                                    <div class='text-muted'>$actionTindaklanjut</div>
                                </li>
                                </ul>
                            </div>
                        </div>
                        <div class='col-12 col-md-8'>
                            <div class='row'>
                                <h3 class='mt-3'>Informasi Gangguan</h3>
                                <div class='col-12 col-md-6'>
                                    <div clas='table-responsive'>
                                        <table class='table table-striped'>
                                            <tr>
                                                <td>Gardu Induk</td>
                                                <td>:</td>
                                                <td>" . $detail->substation->nm_lokasi . "</td>
                                            </tr>
                                            <tr>
                                                <td>Bay</td>
                                                <td>:</td>
                                                <td>" . $detail->bay->nm_lokasi . "</td>
                                            </tr>
                                            <tr>
                                                <td>Tgl Jam Gangguan</td>
                                                <td>:</td>
                                                <td>$detail->tgl_gangguan</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class='col-12 col-md-6'>
                                    <div clas='table-responsive'>
                                        <table class='table table-striped'>
                                            <tr>
                                                <td>Gangguan</td>
                                                <td>:</td>
                                                <td>" . $detail->jenisGangguan->jenis_gangguan . "</td>
                                            </tr>
                                            <tr>
                                                <td>Cuaca</td>
                                                <td>:</td>
                                                <td>$detail->kondisi_lingkungan</td>
                                            </tr>
                                            <tr>
                                                <td>Subsystem</td>
                                                <td>:</td>
                                                <td>" . $detail->subsystem->subsystem . "</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <h3>Indikasi Gangguan</h3>
                                <div class='col-12 col-md-6'>
                                    <div clas='table-responsive'>
                                        <table class='table table-striped'>
                                            <tr>
                                                <td>Announciator</td>
                                            </tr>
                                            <tr>
                                                <td>$detail->anounciator</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class='col-12 col-md-6'>
                                    <div clas='table-responsive'>
                                        <table class='table table-striped'>
                                            <tr>
                                                <td>Info Relay Proteksi</td>
                                            </tr>
                                            <tr>
                                                <td>$detail->indikasi_relay</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <h3>Counter Gangguan Gangguan</h3>
                                <div class='col-12 col-md-12'>
                                    <div clas='table-responsive'>
                                        <table class='table table-striped'>
                                            <tr>
                                                <td>Arus Gangguan R</td>
                                                <td>Arus Gangguan S</td>
                                                <td>Arus Gangguan T</td>
                                                <td>Arus Gangguan N</td>
                                            </tr>
                                            <tr>
                                                <td>$detail->arus_gangguan A</td>
                                                <td>$detail->arus_gangguan_s A</td>
                                                <td>$detail->arus_gangguan_t A</td>
                                                <td>$detail->arus_gangguan_n A</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class='col-12 col-md-12'>
                                    <div clas='table-responsive'>
                                        <table class='table table-striped'>
                                            <tr>
                                                <td>MW (Beban sebelum Gangguan)</td>
                                                <td>MVar (Beban sebelum Gangguan)</td>
                                            </tr>
                                            <tr>
                                                <td>$detail->beban_sebelum_mw MW</td>
                                                <td>$detail->beban_sebelum_mvar Mvar</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class='col-12 col-md-12'>
                                    <div clas='table-responsive'>
                                        <table class='table table-striped'>
                                            <tr>
                                                <td>Counter PMT R</td>
                                                <td>Counter PMT S</td>
                                                <td>Counter PMT T</td>
                                            </tr>
                                            <tr>
                                                <td>$detail->count_cb_r</td>
                                                <td>$detail->count_cb_s</td>
                                                <td>$detail->count_cb_t</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class='col-12 col-md-12'>
                                    <div clas='table-responsive'>
                                        <table class='table table-striped'>
                                            <tr>
                                                <td>Counter LA R</td>
                                                <td>Counter LA S</td>
                                                <td>Counter LA T</td>
                                            </tr>
                                            <tr>
                                                <td>$detail->count_la_r</td>
                                                <td>$detail->count_la_s</td>
                                                <td>$detail->count_la_t</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                ";

        $callback = array('list_data' => $lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
        return response()->json($callback);
    }
}
