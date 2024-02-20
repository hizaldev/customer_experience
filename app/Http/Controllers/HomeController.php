<?php

namespace App\Http\Controllers;

use App\Models\CauseCategory;
use App\Models\Locations;
use App\Models\TipeGangguans;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($user->can('home_page-induk')) {
            $unit = Locations::byLevelTwo($user->level_induk, $user->level_upt, true)->get();
        }

        if ($user->can('home_page-unit')) {
            $unit = Locations::byLevelTwo($user->level_induk, $user->level_upt, false)->get();
        }

        $selectYear = $request->get('year') ? $request->get('year') : Carbon::now()->locale('id')->isoFormat('Y');
        $selectUnit = $request->get('unit') ? $request->get('unit') : '9b2e4a83-ebda-44cd-a5a4-e6b257b7a940';
        $kategori = TipeGangguans::all();
        $gangguanTypeByUltg = $this->getDataGangguanTipeByUltg($selectUnit, $selectYear);
        // dd($gangguanTypeByUltg);
        $selectKategori = '9b2e4a83-ebda-44cd-a5a4-e6b257b7a940';

        if ($user->can('home_page-consumen')) {
            return view('home_guest');
        } else {
            return view('home', [
                'unit' => $unit,
                'selectYear' => $selectYear,
                'selectUnit' => $selectUnit,
                'selectKategori' => $selectKategori,
                'kategori' => $kategori,
                'data_gangguan_type_by_ultg' => $gangguanTypeByUltg,
            ]);
        }
    }

    // mysql
    public function getDataGangguanByCategories($unit, $tahun, $tipeGangguan)
    {
        $query = DB::select("
            select kategori_penyebab, 
                case when jan.jan > 0 then jan.jan else 0 end as jan,
                case when feb.feb > 0 then feb.feb else 0 end as feb,
                case when mar.mar > 0 then mar.mar else 0 end as mar,
                case when apr.apr > 0 then apr.apr else 0 end as apr,
                case when may.may > 0 then may.may else 0 end as may,
                case when jun.jun > 0 then jun.jun else 0 end as jun,
                case when jul.jul > 0 then jul.jul else 0 end as jul,
                case when aug.aug > 0 then aug.aug else 0 end as aug,
                case when sep.sep > 0 then sep.sep else 0 end as sep,
                case when okt.okt > 0 then okt.okt else 0 end as okt,
                case when nov.nov > 0 then nov.nov else 0 end as nov,
                case when des.des > 0 then des.des else 0 end as des
            from cause_categories cc 
            left join (
                select fu.kategori_penyebab_id, count(*) jan from gangguans g 
                join follow_ups fu on g.id =fu.gangguan_id 
                where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN '$tahun-01-01' and '$tahun-01-31' and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
                GROUP BY fu.kategori_penyebab_id 
            ) as jan on cc.id = jan.kategori_penyebab_id
            left join (
                select fu.kategori_penyebab_id, count(*) feb from gangguans g 
                join follow_ups fu on g.id =fu.gangguan_id 
                where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN '$tahun-02-01' and '$tahun-02-31' and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
                GROUP BY fu.kategori_penyebab_id 
            ) as feb on cc.id = feb.kategori_penyebab_id
            left join (
                select fu.kategori_penyebab_id, count(*) mar from gangguans g 
                join follow_ups fu on g.id =fu.gangguan_id 
                where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN '$tahun-03-01' and '$tahun-03-31' and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
                GROUP BY fu.kategori_penyebab_id 
            ) as mar on cc.id = mar.kategori_penyebab_id
            left join (
                select fu.kategori_penyebab_id, count(*) apr from gangguans g 
                join follow_ups fu on g.id =fu.gangguan_id 
                where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN '$tahun-04-01' and '$tahun-04-31' and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
                GROUP BY fu.kategori_penyebab_id 
            ) as apr on cc.id = apr.kategori_penyebab_id
            left join (
                select fu.kategori_penyebab_id, count(*) may from gangguans g 
                join follow_ups fu on g.id =fu.gangguan_id 
                where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN '$tahun-05-01' and '$tahun-05-31' and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
                GROUP BY fu.kategori_penyebab_id 
            ) as may on cc.id = may.kategori_penyebab_id
            left join (
                select fu.kategori_penyebab_id, count(*) jun from gangguans g 
                join follow_ups fu on g.id =fu.gangguan_id 
                where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN '$tahun-06-01' and '$tahun-06-31' and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
                GROUP BY fu.kategori_penyebab_id 
            ) as jun on cc.id = jun.kategori_penyebab_id
            left join (
                select fu.kategori_penyebab_id, count(*) jul from gangguans g 
                join follow_ups fu on g.id =fu.gangguan_id 
                where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN '$tahun-07-01' and '$tahun-07-31' and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
                GROUP BY fu.kategori_penyebab_id 
            ) as jul on cc.id = jul.kategori_penyebab_id
            left join (
                select fu.kategori_penyebab_id, count(*) aug from gangguans g 
                join follow_ups fu on g.id =fu.gangguan_id 
                where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN '$tahun-08-01' and '$tahun-08-31' and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
                GROUP BY fu.kategori_penyebab_id 
            ) as aug on cc.id = aug.kategori_penyebab_id
            left join (
                select fu.kategori_penyebab_id, count(*) sep from gangguans g 
                join follow_ups fu on g.id =fu.gangguan_id 
                where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN '$tahun-09-01' and '$tahun-08-31' and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
                GROUP BY fu.kategori_penyebab_id 
            ) as sep on cc.id = sep.kategori_penyebab_id
            left join (
                select fu.kategori_penyebab_id, count(*) okt from gangguans g 
                join follow_ups fu on g.id =fu.gangguan_id 
                where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN '$tahun-10-01' and '$tahun-10-31' and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
                GROUP BY fu.kategori_penyebab_id 
            ) as okt on cc.id = okt.kategori_penyebab_id
            left join (
                select fu.kategori_penyebab_id, count(*) nov from gangguans g 
                join follow_ups fu on g.id =fu.gangguan_id 
                where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN '$tahun-11-01' and '$tahun-11-31' and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
                GROUP BY fu.kategori_penyebab_id 
            ) as nov on cc.id = nov.kategori_penyebab_id
            left join (
                select fu.kategori_penyebab_id, count(*) des from gangguans g 
                join follow_ups fu on g.id =fu.gangguan_id 
                where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN '$tahun-12-01' and '$tahun-12-31' and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
                GROUP BY fu.kategori_penyebab_id 
            ) as des on cc.id = des.kategori_penyebab_id
            where cc.deleted_at is null
        ");
        return $query;
    }
    // postgresql
    // public function getDataGangguanByCategories($unit, $tahun, $tipeGangguan)
    // {
    //     $query = DB::select("
    //         select kategori_penyebab, 
    //         case when jan.jan > 0 then jan.jan else 0 end as jan,
    //         case when feb.feb > 0 then feb.feb else 0 end as feb,
    //         case when mar.mar > 0 then mar.mar else 0 end as mar,
    //         case when apr.apr > 0 then apr.apr else 0 end as apr,
    //         case when may.may > 0 then may.may else 0 end as may,
    //         case when jun.jun > 0 then jun.jun else 0 end as jun,
    //         case when jul.jul > 0 then jul.jul else 0 end as jul,
    //         case when aug.aug > 0 then aug.aug else 0 end as aug,
    //         case when sep.sep > 0 then sep.sep else 0 end as sep,
    //         case when okt.okt > 0 then okt.okt else 0 end as okt,
    //         case when nov.nov > 0 then nov.nov else 0 end as nov,
    //         case when des.des > 0 then des.des else 0 end as des
    //         from cause_categories cc 
    //         left join (
    //             select fu.kategori_penyebab_id, count(*) jan from gangguans g 
    //             join follow_ups fu on g.id =fu.gangguan_id 
    //             where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN to_date('$tahun-01-01', 'YYYY-MM-DD') and to_date('$tahun-01-31', 'YYYY-MM-DD') and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
    //             GROUP BY fu.kategori_penyebab_id 
    //         ) as jan on cc.id = jan.kategori_penyebab_id
    //         left join (
    //             select fu.kategori_penyebab_id, count(*) feb from gangguans g 
    //             join follow_ups fu on g.id =fu.gangguan_id 
    //             where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN to_date('$tahun-02-01', 'YYYY-MM-DD') and to_date('$tahun-02-29', 'YYYY-MM-DD') and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
    //             GROUP BY fu.kategori_penyebab_id 
    //         ) as feb on cc.id = feb.kategori_penyebab_id
    //         left join (
    //             select fu.kategori_penyebab_id, count(*) mar from gangguans g 
    //             join follow_ups fu on g.id =fu.gangguan_id 
    //             where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN to_date('$tahun-03-01', 'YYYY-MM-DD') and to_date('$tahun-03-31', 'YYYY-MM-DD') and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
    //             GROUP BY fu.kategori_penyebab_id 
    //         ) as mar on cc.id = mar.kategori_penyebab_id
    //         left join (
    //             select fu.kategori_penyebab_id, count(*) apr from gangguans g 
    //             join follow_ups fu on g.id =fu.gangguan_id 
    //             where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN to_date('$tahun-04-01', 'YYYY-MM-DD') and to_date('$tahun-04-30', 'YYYY-MM-DD') and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
    //             GROUP BY fu.kategori_penyebab_id 
    //         ) as apr on cc.id = apr.kategori_penyebab_id
    //         left join (
    //             select fu.kategori_penyebab_id, count(*) may from gangguans g 
    //             join follow_ups fu on g.id =fu.gangguan_id 
    //             where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN to_date('$tahun-05-01', 'YYYY-MM-DD') and to_date('$tahun-05-31', 'YYYY-MM-DD') and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
    //             GROUP BY fu.kategori_penyebab_id 
    //         ) as may on cc.id = may.kategori_penyebab_id
    //         left join (
    //             select fu.kategori_penyebab_id, count(*) jun from gangguans g 
    //             join follow_ups fu on g.id =fu.gangguan_id 
    //             where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN to_date('$tahun-06-01', 'YYYY-MM-DD') and to_date('$tahun-06-30', 'YYYY-MM-DD') and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
    //             GROUP BY fu.kategori_penyebab_id 
    //         ) as jun on cc.id = jun.kategori_penyebab_id
    //         left join (
    //             select fu.kategori_penyebab_id, count(*) jul from gangguans g 
    //             join follow_ups fu on g.id =fu.gangguan_id 
    //             where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN to_date('$tahun-07-01', 'YYYY-MM-DD') and to_date('$tahun-07-31', 'YYYY-MM-DD') and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
    //             GROUP BY fu.kategori_penyebab_id 
    //         ) as jul on cc.id = jul.kategori_penyebab_id
    //         left join (
    //             select fu.kategori_penyebab_id, count(*) aug from gangguans g 
    //             join follow_ups fu on g.id =fu.gangguan_id 
    //             where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN to_date('$tahun-08-01', 'YYYY-MM-DD') and to_date('$tahun-08-31', 'YYYY-MM-DD') and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
    //             GROUP BY fu.kategori_penyebab_id 
    //         ) as aug on cc.id = aug.kategori_penyebab_id
    //         left join (
    //             select fu.kategori_penyebab_id, count(*) sep from gangguans g 
    //             join follow_ups fu on g.id =fu.gangguan_id 
    //             where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN to_date('$tahun-09-01', 'YYYY-MM-DD') and to_date('$tahun-09-30', 'YYYY-MM-DD') and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
    //             GROUP BY fu.kategori_penyebab_id 
    //         ) as sep on cc.id = sep.kategori_penyebab_id
    //         left join (
    //             select fu.kategori_penyebab_id, count(*) okt from gangguans g 
    //             join follow_ups fu on g.id =fu.gangguan_id 
    //             where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN to_date('$tahun-10-01', 'YYYY-MM-DD') and to_date('$tahun-10-31', 'YYYY-MM-DD') and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
    //             GROUP BY fu.kategori_penyebab_id 
    //         ) as okt on cc.id = okt.kategori_penyebab_id
    //         left join (
    //             select fu.kategori_penyebab_id, count(*) nov from gangguans g 
    //             join follow_ups fu on g.id =fu.gangguan_id 
    //             where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN to_date('$tahun-11-01', 'YYYY-MM-DD') and to_date('$tahun-11-30', 'YYYY-MM-DD') and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
    //             GROUP BY fu.kategori_penyebab_id 
    //         ) as nov on cc.id = nov.kategori_penyebab_id
    //         left join (
    //             select fu.kategori_penyebab_id, count(*) des from gangguans g 
    //             join follow_ups fu on g.id =fu.gangguan_id 
    //             where g.is_main_gangguan = 'Ya' and g.tgl_gangguan BETWEEN to_date('$tahun-12-01', 'YYYY-MM-DD') and to_date('$tahun-12-31', 'YYYY-MM-DD') and g.deleted_at is null and fu.deleted_at is null and g.tipe_gangguan_id ='$tipeGangguan' and g.upt_id ='$unit'
    //             GROUP BY fu.kategori_penyebab_id 
    //         ) as des on cc.id = des.kategori_penyebab_id
    //                 where cc.deleted_at is null
    //     ");
    //     return $query;
    // }

    public function getDataGangguanTipeByUltg($unit, $tahun)
    {
        $query = DB::select("
            select 
                l.nm_lokasi, 
                case when pht.pht > 0 then pht.pht else 0 end as pht, 
                case when trf.trf > 0 then trf.trf else 0 end as trf, 
                case when dia.dia > 0 then dia.dia else 0 end as dia, 
                case when kit.kit > 0 then kit.kit else 0 end as kit 
            from locations l 
            left join (
                select g.ultg_id , count(*) as pht from gangguans g 
                where g.is_main_gangguan ='Ya' 
                and g.tipe_gangguan_id = '9b2e4a83-ebda-44cd-a5a4-e6b257b7a940' 
                and g.upt_id ='$unit'
                and g.tgl_gangguan BETWEEN '$tahun-01-01' and '$tahun-12-31'
                group by  g.ultg_id, g.tipe_gangguan_id = '9b2e4a83-ebda-44cd-a5a4-e6b257b7a940' 
            ) pht on l.id = pht.ultg_id
            left join (
                select g.ultg_id , count(*) as trf from gangguans g 
                where g.is_main_gangguan ='Ya' 
                and g.tipe_gangguan_id = '9b2e4a9d-b219-4f55-9505-0fef79bc6962' 
                and g.upt_id ='$unit'
                and g.tgl_gangguan BETWEEN '$tahun-01-01' and '$tahun-12-31'
                group by  g.ultg_id, g.tipe_gangguan_id = '9b2e4a83-ebda-44cd-a5a4-e6b257b7a940' 
            ) trf on l.id = trf.ultg_id
            left join (
                select g.ultg_id , count(*) as dia from gangguans g 
                where g.is_main_gangguan ='Ya' 
                and g.tipe_gangguan_id = '9b2e4a9d-b219-4f55-9505-0fef79bc6962' 
                and g.upt_id ='$unit'
                and g.tgl_gangguan BETWEEN '$tahun-01-01' and '$tahun-12-31'
                group by  g.ultg_id, g.tipe_gangguan_id = '9b2e4a83-ebda-44cd-a5a4-e6b257b7a940' 
            ) dia on l.id = dia.ultg_id
            left join (
                select g.ultg_id , count(*) as kit from gangguans g 
                where g.is_main_gangguan ='Ya' 
                and g.tipe_gangguan_id = '9b2e4a9d-b219-4f55-9505-0fef79bc6962' 
                and g.upt_id ='$unit'
                and g.tgl_gangguan BETWEEN '$tahun-01-01' and '$tahun-12-31'
                group by  g.ultg_id, g.tipe_gangguan_id = '9b2e4a83-ebda-44cd-a5a4-e6b257b7a940' 
            ) kit on l.id = kit.ultg_id
            where nlevel = 3 
            and fungsi_id ='9a6ae5a7-0d8e-4ce8-b809-9b7ff557a338' 
            and parent_id = '$unit'
        ");
        return $query;
    }

    public function showDataGangguanByCategories(Request $request)
    {
        $data = $this->getDataGangguanByCategories($request->unit, $request->tahun, $request->tipe_gangguan_id);
        return response()->json($data);
    }

    public function showDataChartRekapGangguanByCategories(Request $request)
    {
        $data = $this->getDataGangguanByCategories($request->unit, $request->tahun, $request->tipe_gangguan_id);
        $data2 = [];
        foreach ($data as $dat) {
            $data2['data'][] = [
                'name' => $dat->kategori_penyebab,
                'data' => [$dat->jan, $dat->feb, $dat->mar, $dat->apr, $dat->may, $dat->jun, $dat->jul, $dat->aug, $dat->sep, $dat->okt, $dat->nov, $dat->des,]
            ];
        }
        return response()->json($data2);
    }
}
