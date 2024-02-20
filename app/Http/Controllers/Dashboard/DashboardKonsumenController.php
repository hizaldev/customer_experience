<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Constant\ConstantController;
use App\Http\Controllers\Controller;
use App\Models\BmkgWeathers;
use App\Models\Consumers;
use App\Models\Jalurs;
use App\Models\Locations;
use App\Models\Pqm;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleXMLElement;

class DashboardKonsumenController extends Controller
{

    public function index(Request $request)
    {
        $item = User::find(Auth::user()->id);

        if ($item->can('dashborad_konsumen-induk')) {
            $consumer = Consumers::get();
        }
        if ($item->can('dashborad_konsumen-unit')) {
            $consumer = Consumers::get('upt_id', $item->level_upt);
        }
        if ($item->can('dashborad_konsumen-konsumen')) {
            $consumer = Consumers::where('id', $item->consumer_id)->get();
        }

        $consumerId = $request->get('consumer_id') ? $request->get('consumer_id') : '9b2e4a83-ebda-44cd-a5a4-e6b257b7a940';
        $infoKonsumen = Consumers::where('id', $consumerId)->first();
        $areaId = $infoKonsumen ? $infoKonsumen->area_id : '999999';
        $dataKonsumem = $infoKonsumen ? $infoKonsumen->nama_ktt : 'UPT Semarang';
        $dataGarduInduk = $infoKonsumen ? $infoKonsumen->location_id : '9b2e4a83-ebda-44cd-a5a4-e6b257b7a940';
        $location = Locations::find($infoKonsumen == !null ? $infoKonsumen->location_id : '9b2e4a83-ebda-44cd-a5a4-e6b257b7a940');
        $idfuncloc = $location ? $location->id_functloc : '9b2e4a83-ebda-44cd-a5a4-e6b257b7a940';
        $petugasGiKonsumen = User::where('level_substation', 'LIKE', "%{$dataGarduInduk}%")->get();
        // dd($idfuncloc);
        $endDate = Carbon::now()->locale('id')->isoFormat('Y-MM-DD');
        $startDate = Carbon::now()->subDays(30)->locale('id')->isoFormat('Y-MM-DD');
        $dataCt = ConstantController::getDataHealtyIndex('CT_PROSES', $idfuncloc);
        $dataPt = ConstantController::getDataHealtyIndex('CVT_PROSES', $idfuncloc);
        $dataPmt = ConstantController::getDataHealtyIndex('PMT_PROSES', $idfuncloc);
        $dataPms = ConstantController::getDataHealtyIndex('PMS_PROSES', $idfuncloc);
        $dataLa = ConstantController::getDataHealtyIndex('LA_PROSES', $idfuncloc);
        $stringDate = Carbon::now()->format('Ymd');
        $content = file_get_contents('https://data.bmkg.go.id/DataMKG/MEWS/DigitalForecast/DigitalForecast-JawaTengah.xml');
        $xml = new SimpleXMLElement($content);
        $dataBmkg = $xml->forecast->area;

        $dataCuacaDiniHari = ConstantController::GetValueMapingDataBmkg($dataBmkg, $areaId, $stringDate . '0000', 'Weather', 'icon');
        $dataTemperaturDiniHari = ConstantController::GetValueDataBmkg($dataBmkg, $areaId, $stringDate . '0000', 'Temperature', 'C');
        $dataHumidityDiniHari = ConstantController::GetValueDataBmkg($dataBmkg, $areaId, $stringDate . '0000', 'Humidity', '%');
        $dataWinSpeedDiniHari = ConstantController::GetValueDataBmkg($dataBmkg, $areaId, $stringDate . '0000', 'Wind speed', 'KPH');

        $dataCuacaPagiHari = ConstantController::GetValueMapingDataBmkg($dataBmkg, $areaId, $stringDate . '0600', 'Weather', 'icon');
        $dataTemperaturPagiHari = ConstantController::GetValueDataBmkg($dataBmkg, $areaId, $stringDate . '0600', 'Temperature', 'C');
        $dataHumidityPagiHari = ConstantController::GetValueDataBmkg($dataBmkg, $areaId, $stringDate . '0600', 'Humidity', '%');
        $dataWinSpeedPagiHari = ConstantController::GetValueDataBmkg($dataBmkg, $areaId, $stringDate . '0600', 'Wind speed', 'KPH');

        $dataCuacaSiangHari = ConstantController::GetValueMapingDataBmkg($dataBmkg, $areaId, $stringDate . '1200', 'Weather', 'icon');
        $dataTemperaturSiangHari = ConstantController::GetValueDataBmkg($dataBmkg, $areaId, $stringDate . '1200', 'Temperature', 'C');
        $dataHumiditySiangHari = ConstantController::GetValueDataBmkg($dataBmkg, $areaId, $stringDate . '1200', 'Humidity', '%');
        $dataWinSpeedSiangHari = ConstantController::GetValueDataBmkg($dataBmkg, $areaId, $stringDate . '1200', 'Wind speed', 'KPH');

        $dataCuacaSoreHari = ConstantController::GetValueMapingDataBmkg($dataBmkg, $areaId, $stringDate . '1800', 'Weather', 'icon');
        $dataTemperaturSoreHari = ConstantController::GetValueDataBmkg($dataBmkg, $areaId, $stringDate . '1800', 'Temperature', 'C');
        $dataHumiditySoreHari = ConstantController::GetValueDataBmkg($dataBmkg, $areaId, $stringDate . '1800', 'Humidity', '%');
        $dataWinSpeedSoreHari = ConstantController::GetValueDataBmkg($dataBmkg, $areaId, $stringDate . '1800', 'Wind speed', 'KPH');
        // dd($dataCuacaDiniHari);


        return view('dashboard.home', [
            'konsumen' => $consumer,
            'consumer_id' => $consumerId,
            'data_konsumen' => $dataKonsumem,
            'area_id' => $areaId,
            'petugas' => $petugasGiKonsumen,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'substation_id' => $dataGarduInduk,
            'index_ct' => $dataCt,
            'index_pt' => $dataPt,
            'index_pmt' => $dataPmt,
            'index_pms' => $dataPms,
            'index_la' => $dataLa,
            'data_cuaca_dini_hari' => $dataCuacaDiniHari,
            'data_temperatur_dini_hari' => $dataTemperaturDiniHari,
            'data_humidity_dini_hari' => $dataHumidityDiniHari,
            'data_kecepatan_angin_dini_hari' => $dataWinSpeedDiniHari,
            'data_cuaca_pagi_hari' => $dataCuacaPagiHari,
            'data_temperatur_pagi_hari' => $dataTemperaturPagiHari,
            'data_humidity_pagi_hari' => $dataHumidityPagiHari,
            'data_kecepatan_angin_pagi_hari' => $dataWinSpeedPagiHari,
            'data_cuaca_siang_hari' => $dataCuacaSiangHari,
            'data_temperatur_siang_hari' => $dataTemperaturSiangHari,
            'data_humidity_siang_hari' => $dataHumiditySiangHari,
            'data_kecepatan_angin_siang_hari' => $dataWinSpeedSiangHari,
            'data_cuaca_sore_hari' => $dataCuacaSoreHari,
            'data_temperatur_sore_hari' => $dataTemperaturSoreHari,
            'data_humidity_sore_hari' => $dataHumiditySoreHari,
            'data_kecepatan_angin_sore_hari' => $dataWinSpeedSoreHari,



        ]);
    }


    public function showInfoChart(Request $request)
    {
        $detail = Pqm::whereBetween('datetime', [$request->start_date, $request->end_date])->where('substation_id', $request->substation_id)->get();
        // $callback = array('data' => $detail);
        $data2 = [];
        foreach ($detail as $details) {
            $data2['dist_vr_min'][] = number_format((float)$details->dist_vr_min, 2, '.', '');
            $data2['dist_vs_min'][] = number_format((float)$details->dist_vs_min, 2, '.', '');
            $data2['dist_vt_min'][] = number_format((float)$details->dist_vt_min, 2, '.', '');
            $data2['datetime'][] = $details->datetime;
            $data2['presentase_r'][] = number_format((float)$details->presentase_r, 2, '.', '');
            $data2['presentase_s'][] = number_format((float)$details->presentase_s, 2, '.', '');
            $data2['presentase_t'][] = number_format((float)$details->presentase_t, 2, '.', '');
            $data2['dist_dur'][] = $details->dist_dur * 1000;
        }
        return response()->json($data2);
    }

    public function showDataGangguan(Request $request)
    {
        $getDataSubsistem = DB::table('subsystem_details')
            ->select(
                DB::raw(
                    '
                       distinct subsystem_details.subsystem_id
                    '
                )
            )
            ->where('subsystem_details.substation_id', $request->substation_id)
            ->first();
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
            ->where('gangguans.substation_id', $request->substation_id)
            ->whereBetween('gangguans.tgl_gangguan', [$request->start_date, $request->end_date])
            ->whereNull('gangguans.deleted_at');
        if ($getDataSubsistem != null) {
            $data->orWhere('gangguans.subsystem_id', $getDataSubsistem->subsystem_id);
        }
        return response()->json($data->get());
    }

    public function showDatajalur(Request $request)
    {
        $getDataSubsistem = DB::table('subsystem_details')
            ->select(
                DB::raw(
                    '
                       distinct subsystem_details.subsystem_id
                    '
                )
            )
            ->where('subsystem_details.substation_id', $request->substation_id)
            ->first();
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
            ->where('jalurs.substation_id', $request->substation_id)
            ->whereBetween('jalurs.awal_jadwal', [$request->start_date, $request->end_date])
            ->whereNull('jalurs.deleted_at');
        if ($getDataSubsistem != null) {
            $data->orWhere('jalurs.subsystem_id', $getDataSubsistem->subsystem_id);
        }
        return response()->json($data->get());
    }
}
