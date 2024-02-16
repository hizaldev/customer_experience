<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Constant\ConstantController;
use App\Http\Controllers\Controller;
use App\Models\Locations;
use App\Models\SubsystemDetails;
use App\Models\Subsystems;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SubsystemController extends Controller
{
    var $route = 'island.index';
    var $path_view = 'master.subsystem';

    function __construct()
    {
        $this->middleware('permission:master_subsystem-list|master_subsystem-create|role-edit|master_subsystem-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:master_subsystem-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:master_subsystem-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:master_subsystem-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = Subsystems::with('subsystemDetail')->get();
        $data = Subsystems::join('subsystem_details', function ($join) {
            $join->on('subsystems.id', '=', 'subsystem_details.subsystem_id')
                ->whereNull('subsystem_details.deleted_at');
        })
            ->groupBy('subsystems.id')
            ->get(['subsystems.id', 'subsystems.subsystem', 'subsystems.keterangan', DB::raw('count(subsystem_details.id) as count_substation')]);
        if (request()->ajax()) {
            // dd($data);
            return DataTables::of($data)
                ->addColumn('show', function ($item) {
                    return '
            
                        <a onClick="showDetail(this,`' . $item->id . '`)" class="btn btn-primary btn-sm btn-icon w-100 text-white" data-bs-toggle="modal" data-bs-target="#modal-team" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-scan-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 8v-2a2 2 0 0 1 2 -2h2" />
                                <path d="M4 16v2a2 2 0 0 0 2 2h2" /><path d="M16 4h2a2 2 0 0 1 2 2v2" />
                                <path d="M16 20h2a2 2 0 0 0 2 -2v-2" /><path d="M7 12c3.333 -4.667 6.667 -4.667 10 0" />
                                <path d="M7 12c3.333 4.667 6.667 4.667 10 0" /><path d="M12 12h-.01" />
                            </svg>
                        </a>
                    ';
                })
                ->addColumn('edit', function ($item) {
                    return '
                    
                        <a class="btn btn-success btn-sm btn-icon w-100 text-white" href="' . route('island.edit', $item->id) . '">
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
                        <form action="' . route('island.destroy', $item->id) . '" method="POST" id="form" class="form-inline" onSubmit="if (confirm(`Apakah anda yakin menghapus data? Data yang sudah dihapus tidak dapat dikembalikan`)) run; return false">
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
                ->rawColumns(['edit', 'delete', 'show'])
                ->make();
        }

        return view("$this->path_view.index");
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
        // dd($request->all());
        $this->validate($request, [
            'subsystem' => 'required|unique:subsystems,subsystem',
        ]);
        try {
            $data['subsystem'] = $request->subsystem;
            $data['keterangan'] = $request->keterangan;
            $subsystem = Subsystems::create($data);

            for ($i = 0; $i < count($request->substation_id); $i++) {
                $substation = Locations::find($request->substation_id[$i]);
                if ($substation) {
                    $dataSubsystem['subsystem_id'] = $subsystem->id;
                    $dataSubsystem['substation_id'] = $substation->id;
                    $dataSubsystem['id_functloc'] = $substation->id_functloc;
                    $dataSubsystem['substation'] = $substation->nm_lokasi;
                    SubsystemDetails::create($dataSubsystem);
                }
            }

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
        $item = Subsystems::find($id);
        $subsystemDetail = SubsystemDetails::where('subsystem_id', $id)->get();
        return view("$this->path_view.edit", [
            'item' => $item,
            'subsystemDetail' => $subsystemDetail,
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
            'subsystem' => 'required',
        ]);

        try {
            $data['subsystem'] = $request->subsystem;
            $data['keterangan'] = $request->keterangan;
            $subsystem = Subsystems::findOrFail($id);
            $subsystem->update($data);

            SubsystemDetails::where('subsystem_id', $id)->delete();
            for ($i = 0; $i < count($request->substation_id); $i++) {
                $subsystemDetail = SubsystemDetails::withTrashed()
                    ->where('subsystem_id', $id)
                    ->where('substation_id', $request->substation_id[$i])
                    ->first();
                if ($subsystemDetail) {
                    $subsystemDetail->restore();
                } else {
                    $substation = Locations::find($request->substation_id[$i]);
                    if ($substation) {
                        $dataSubsystem['subsystem_id'] = $subsystem->id;
                        $dataSubsystem['substation_id'] = $substation->id;
                        $dataSubsystem['id_functloc'] = $substation->id_functloc;
                        $dataSubsystem['substation'] = $substation->nm_lokasi;
                        SubsystemDetails::create($dataSubsystem);
                    }
                }
            }

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
        $item = Subsystems::findOrFail($id);
        $item->delete();

        ConstantController::successDeleteAlert();
        return redirect()->route("$this->route");
    }

    public function showDataSubstation(Request $request)
    {
        $detail = Subsystems::with('subsystemDetail')->where('id', $request->subsystem)->first();


        $lists = "";

        $lists .= "
                    <div class='row'>
                        <h3>Data Subsystem</h3>
                        <div class='col-12 col-md-12'>
                            <div clas='table-responsive'>
                                <table class='table table-striped'>
                                    <tr>
                                        <td>Subsystem</td>
                                        <td>:</td>
                                        <td>$detail->subsystem</td>
                                    </tr>
                                    <tr>
                                        <td>Keterangan</td>
                                        <td>:</td>
                                        <td>$detail->keterangan</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <h3>Gardu Induk Subsystem (" . $detail->subsystemDetail->count() . " GI/GITET)</h3>
                
                        <div class='col-12 col-md-12'>
                            <div clas='table-responsive'>
                                <table class='table table-striped'>
                                    <tr>
                                        <td>Id Functloc</td>
                                        <td>Gardu Induk</td>
                                    </tr>
                ";

        foreach ($detail->subsystemDetail as $substation) {
            $lists .= " <tr>
                <td>$substation->id_functloc </td>
                <td>$substation->substation </td>
            </tr>";
        }

        $lists .= "
                                </table>
                            </div>
                        </div>
                    </div>
        ";

        $callback = array('list_data' => $lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
        return response()->json($callback);
    }

    public function getLocations()
    {
        $categoryNews = Locations::where('nlevel', 3)
            ->where('fungsi_id', '9a6ae5a7-0f5f-4cb1-a117-d14792d30537')
            ->where('description', 'LIKE', '%' . request()->get('q') . '%')
            ->get();
        return response()->json($categoryNews);
    }
}
