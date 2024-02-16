<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Constant\ConstantController;
use App\Http\Controllers\Controller;
use App\Models\ConsumerDetails;
use App\Models\Consumers;
use App\Models\Locations;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use SimpleXMLElement;

class KonsumenKttController extends Controller
{
    var $route = 'konsumen.index';
    var $path_view = 'master.konsumen';

    function __construct()
    {
        $this->middleware('permission:master_konsumen-list|master_konsumen-create|role-edit|master_konsumen-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:master_konsumen-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:master_konsumen-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:master_konsumen-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Consumers::with(['lokasi'])->get();
        if (request()->ajax()) {
            return DataTables::of($data)
                ->addColumn('edit', function ($item) {
                    return '
                    
                        <a class="btn btn-success btn-sm btn-icon w-100 text-white" href="' . route('konsumen.edit', $item->id) . '">
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
                        <form action="' . route('konsumen.destroy', $item->id) . '" method="POST" id="form" class="form-inline" onSubmit="if (confirm(`Apakah anda yakin menghapus data? Data yang sudah dihapus tidak dapat dikembalikan`)) run; return false">
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
        return view("$this->path_view.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $content = file_get_contents('https://data.bmkg.go.id/DataMKG/MEWS/DigitalForecast/DigitalForecast-JawaTengah.xml');
        $xml = new SimpleXMLElement($content);
        $json = json_encode($xml);
        $phpArray = json_decode($json, true);
        // dd($phpArray);
        $location = Locations::where('nlevel', '3')
            ->where('fungsi_id', '9a6ae5a7-0f5f-4cb1-a117-d14792d30537')->get();
        return view(
            "$this->path_view.create",
            [
                'location' => $location,
                'bmkg' => $xml->forecast->area,
            ]
        );
    }

    public function listForm(Request $request)
    {
        $location_id = $request->location_id;
        $bay = Locations::where('parent_id', $location_id)->where('nlevel', '4')->get();
        $lists = "<div class='row'>";

        if (count($bay) > 0) {
            foreach ($bay as $p) {
                $lists .= "<div class='col-12 col-md-6'>
                    <div class='form-check'>
                        <div class='checkbox'>
                            <input type='checkbox' id='" . $p->id . "' class='form-check-input' value='" . $p->id . "' name='id_location_bay[]'>
                            <label for='" . $p->id . "'>" . $p->nm_lokasi . "</label>
                        </div>
                    </div>
                </div>";
            }

            // for ($i = 0; $i < count($bay); $i++) {
            // }
        } else {
            $lists .= "</div>";
        }

        // $callback = array('list_kota' => $lists); // Masukan variabel lists tadi ke dalam array $callback dengan index array : list_kota
        return response()->json(['list_kota' => $lists]);
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
            'nama_ktt' => 'required|unique:consumers,nama_ktt',
            'alamat' => 'required',
            'location_id' => 'required',
            'area_id' => 'required',
        ]);
        try {
            $data['nama_ktt'] = $request->nama_ktt;
            $data['alamat'] = $request->alamat;
            $data['location_id'] = $request->location_id;
            $data['area_id'] = $request->area_id;
            $konsumen = Consumers::create($data);
            $consumer = $konsumen->id;
            for ($i = 0; $i < count($request->id_location_bay); $i++) {
                $dataDetail['consumer_id'] = $consumer;
                $dataDetail['location_id'] = $request->location_id;
                $dataDetail['location_bay_id'] = $request->id_location_bay[$i];
                $konsumen = ConsumerDetails::create($dataDetail);
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
        $item = Consumers::find($id);
        $consumerDetail = ConsumerDetails::where('consumer_id', $id)->get();
        $bays = Locations::where('parent_id', $item->location_id)->get();
        $content = file_get_contents('https://data.bmkg.go.id/DataMKG/MEWS/DigitalForecast/DigitalForecast-JawaTengah.xml');
        $xml = new SimpleXMLElement($content);
        $json = json_encode($xml);
        $location = Locations::where('nlevel', '3')
            ->where('fungsi_id', '9a6ae5a7-0f5f-4cb1-a117-d14792d30537')->get();

        return view("$this->path_view.edit", [
            'item' => $item,
            'consumer_detail' => $consumerDetail,
            'bay' => $bays,
            'location' => $location,
            'bmkg' => $xml->forecast->area,
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
            'nama_ktt' => 'required',
            'alamat' => 'required',
            'location_id' => 'required',
            'area_id' => 'required',
        ]);

        try {
            $data['nama_ktt'] = $request->nama_ktt;
            $data['alamat'] = $request->alamat;
            $data['location_id'] = $request->location_id;
            $data['area_id'] = $request->area_id;
            $item = Consumers::findOrFail($id);
            $item->update($data);

            ConstantController::successAlert();
        } catch (Exception $e) {
            ConstantController::errorAlert($e->getMessage());
        }
        return redirect()->route("$this->route");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Consumers::findOrFail($id);
        $item->delete();
        ConsumerDetails::where('consumer_id', $id)->delete();

        ConstantController::successDeleteAlert();
        return redirect()->route("$this->route");
    }
}
