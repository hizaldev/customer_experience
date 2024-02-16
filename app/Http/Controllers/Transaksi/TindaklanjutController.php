<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Constant\ConstantController;
use App\Http\Controllers\Controller;
use App\Models\CauseCategory;
use App\Models\FollowUps;
use App\Models\Gangguans;
use App\Models\Investigations;
use Exception;
use Illuminate\Http\Request;

class TindaklanjutController extends Controller
{
    var $route = 'tindaklanjut.edit';
    var $path_view = 'transaksi.tindaklanjut';


    function __construct()
    {
        $this->middleware('permission:transaksi_tindaklanjut_gangguan-list|transaksi_tindaklanjut_gangguan-create|role-edit|transaksi_tindaklanjut_gangguan-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:transaksi_tindaklanjut_gangguan-create', ['only' => ['edit', 'update']]);
        $this->middleware('permission:transaksi_tindaklanjut_gangguan-edit', ['only' => ['create', 'store']]);
        $this->middleware('permission:transaksi_tindaklanjut_gangguan-delete', ['only' => ['destroy']]);
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
        $followUp = FollowUps::where('gangguan_id', $id)->first();
        $kategoriPenyebab = CauseCategory::all();
        return view("$this->path_view.edit", [
            'investigasi' => $investigasi,
            'gangguan' => $gangguan,
            'tindaklanjut' => $followUp,
            'kategoriPenyebab' => $kategoriPenyebab,
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
            'tgl_tindaklanjut' => 'required',
            'tindaklanjut' => 'required',
            'kategori_penyebab_id' => 'required',
            'pelaksana_satu' => 'required',
        ]);

        try {
            $data['gangguan_id'] = $id;
            $data['tgl_tindaklanjut'] = $request->tgl_tindaklanjut;
            $data['kategori_penyebab_id'] = $request->kategori_penyebab_id;
            $data['tindaklanjut'] = $request->tindaklanjut;
            $data['pelaksana_satu'] = $request->pelaksana_satu;
            $data['pelaksana_dua'] = $request->pelaksana_dua;
            $data['pelaksana_tiga'] = $request->pelaksana_tiga;
            $data['pelaksana_empat'] = $request->pelaksana_empat;
            $investigasiCheck = FollowUps::where('gangguan_id', $id)->first();
            if ($investigasiCheck != null) {
                $investigasiCheck->update($data);
            } else {
                FollowUps::create($data);
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
