<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Constant\ConstantController;
use App\Http\Controllers\Controller;
use App\Models\Gangguans;
use App\Models\Investigations;
use Exception;
use Illuminate\Http\Request;

class InvestigasiController extends Controller
{
    var $route = 'investigasi.edit';
    var $path_view = 'transaksi.investigasi';

    function __construct()
    {
        $this->middleware('permission:transaksi_investigasi_gangguan-list|transaksi_investigasi_gangguan-create|role-edit|transaksi_investigasi_gangguan-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:transaksi_investigasi_gangguan-create', ['only' => ['edit', 'update']]);
        $this->middleware('permission:transaksi_investigasi_gangguan-edit', ['only' => ['create', 'store']]);
        $this->middleware('permission:transaksi_investigasi_gangguan-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        $gangguan = Gangguans::with(['substation', 'bay', 'jenisGangguan', 'tipeGangguan'])->where('id', $id)->first();
        $investigasi = Investigations::where('gangguan_id', $id)->first();
        return view("$this->path_view.edit", [
            'investigasi' => $investigasi,
            'gangguan' => $gangguan,
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
            'tgl_investigasi' => 'required',
            'investigasi' => 'required',
            'pelaksana_satu' => 'required',
        ]);

        try {
            $data['gangguan_id'] = $id;
            $data['tgl_investigasi'] = $request->tgl_investigasi;
            $data['investigasi'] = $request->investigasi;
            $data['pelaksana_satu'] = $request->pelaksana_satu;
            $data['pelaksana_dua'] = $request->pelaksana_dua;
            $data['pelaksana_tiga'] = $request->pelaksana_tiga;
            $data['pelaksana_empat'] = $request->pelaksana_empat;
            $investigasiCheck = Investigations::where('gangguan_id', $id)->first();
            if ($investigasiCheck != null) {
                $investigasiCheck->update($data);
            } else {
                Investigations::create($data);
            }
            ConstantController::successAlert();
        } catch (Exception $e) {
            ConstantController::errorAlert($e->getMessage());
        }
        return redirect()->route($this->route, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
