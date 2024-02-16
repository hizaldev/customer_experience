<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Constant\ConstantController;
use App\Http\Controllers\Controller;
use App\Imports\PqmImport;
use App\Models\Consumers;
use App\Models\Locations;
use App\Models\Pqm;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PqmController extends Controller
{
    var $route = 'pqm.index';
    var $path_view = 'transaksi.pqm';

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
    public function index()
    {
        $item = User::find(Auth::user()->id);
        $unit = $item->level_upt != null ? Locations::where('nlevel', 2)->where('id', $item->level_upt)->get() : Locations::where('nlevel', 2)->get();
        // $data = Pqm::with(['location_upt', 'location_ultg', 'location_gi'])->get();
        // dd($data);
        $data = DB::table('pqm_consumers')
            ->select(
                DB::raw(
                    '
                    pqm_consumers.*,
                    upt.nm_lokasi as upt,
                    ultg.nm_lokasi as ultg,
                    substation.nm_lokasi as gi
                '
                )
            )
            ->leftjoin('locations as upt', function ($join) {
                $join->on('pqm_consumers.upt_id', '=', 'upt.id');
            })
            ->leftjoin('locations as ultg', function ($join) {
                $join->on('pqm_consumers.ultg_id', '=', 'ultg.id');
            })
            ->leftjoin('locations as substation', function ($join) {
                $join->on('pqm_consumers.substation_id', '=', 'substation.id');
            });
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
        $this->validate($request, [
            'level_upt' => 'required',
            'level_ultg' => 'required',
            'level_substation' => 'required',
        ]);
        try {
            Excel::import(new PqmImport($request->level_upt, $request->level_ultg, $request->level_substation,), request()->file('file_pqm'));
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
        $item = Pqm::find($id);

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

            $item = Pqm::findOrFail($id);
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
        $item = Pqm::findOrFail($id);
        $item->delete();

        ConstantController::successDeleteAlert();
        return redirect()->route("$this->route");
    }
}
