<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Constant\ConstantController;
use App\Http\Controllers\Controller;
use App\Models\Functions;
use App\Models\Locations;
use App\Models\Status;
use App\Models\Voltages;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GarduIndukController extends Controller
{
    var $route = 'garduInduk.index';
    var $path_view = 'lokasi.gardu_induk';

    function __construct()
    {
        $this->middleware('permission:lokasi_gardu_induk-list|lokasi_gardu_induk-create|role-edit|lokasi_gardu_induk-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:lokasi_gardu_induk-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:lokasi_gardu_induk-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:lokasi_gardu_induk-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Locations::with(['status', 'tegangan', 'fungsi'])->where('nlevel', 4)->get();
        if (request()->ajax()) {
            return DataTables::of($data)
                ->addColumn('edit', function ($item) {
                    return '
                    
                        <a class="btn btn-success btn-sm btn-icon w-100 text-white" href="' . route('garduInduk.edit', $item->id) . '">
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
                        <form action="' . route('garduInduk.destroy', $item->id) . '" method="POST" id="form" class="form-inline" onSubmit="if (confirm(`Apakah anda yakin menghapus data? Data yang sudah dihapus tidak dapat dikembalikan`)) run; return false">
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

        return view("$this->path_view.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $status = Status::orderBy('id_status', 'Asc')->get();
        $fungsi = Functions::orderBy('kd_fungsi', 'Asc')->get();
        $tegangan = Voltages::orderBy('tegangan_id', 'Asc')->get();
        return view("$this->path_view.create", [
            'status' => $status,
            'fungsi' => $fungsi,
            'tegangan' => $tegangan,
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
            'id_functloc' => 'required|unique:locations,id_functloc',
            'sup_functloc' => 'required',
            'nm_lokasi' => 'required',
            'description' => 'required',
            'fungsi_id' => 'required',
            'tegangan_id' => 'required',
            'status_id' => 'required',
        ]);
        try {
            $parent = Locations::where('id_functloc', $request->sup_functloc)
                ->where('nlevel', 3)
                ->firstOrFail();
            $data['parent_id'] = $parent->id;
            $data['id_functloc'] = $request->id_functloc;
            $data['sup_functloc'] = $request->sup_functloc;
            $data['nm_lokasi'] = $request->nm_lokasi;
            $data['description'] = $request->description;
            $data['nlevel'] = 4;
            $data['status_id'] = $request->status_id;
            $data['tegangan_id'] = $request->tegangan_id;
            $data['fungsi_id'] = $request->fungsi_id;
            Locations::create($data);
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
        $item = Locations::find($id);
        $status = Status::orderBy('id_status', 'Asc')->get();
        $fungsi = Functions::orderBy('kd_fungsi', 'Asc')->get();
        $tegangan = Voltages::orderBy('tegangan_id', 'Asc')->get();
        return view("$this->path_view.edit", [
            'item' => $item,
            'status' => $status,
            'fungsi' => $fungsi,
            'tegangan' => $tegangan,
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
            'id_functloc' => 'required',
            'sup_functloc' => 'required',
            'nm_lokasi' => 'required',
            'description' => 'required',
            'fungsi_id' => 'required',
            'tegangan_id' => 'required',
            'status_id' => 'required',
        ]);

        try {
            $parent = Locations::where('id_functloc', $request->sup_functloc)
                ->where('nlevel', 3)
                ->firstOrFail();
            $data['parent_id'] = $parent->id;
            $data['id_functloc'] = $request->id_functloc;
            $data['sup_functloc'] = $request->sup_functloc;
            $data['nm_lokasi'] = $request->nm_lokasi;
            $data['description'] = $request->description;
            $data['status_id'] = $request->status_id;
            $data['tegangan_id'] = $request->tegangan_id;
            $data['fungsi_id'] = $request->fungsi_id;

            $item = Locations::findOrFail($id);
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
        $item = Locations::findOrFail($id);
        $item->delete();

        ConstantController::successDeleteAlert();
        return redirect()->route("$this->route");
    }
}
