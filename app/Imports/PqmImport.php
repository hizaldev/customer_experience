<?php

namespace App\Imports;

use App\Models\Pqm;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PqmImport implements ToModel, WithHeadingRow
{
    private $upt_id;
    private $ultg_id;
    private $substation_id;

    public function __construct(string $upt_id, string $ultg_id, string $substation_id)
    {
        $this->upt_id = $upt_id;
        $this->ultg_id = $ultg_id;
        $this->substation_id = $substation_id;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Pqm([
            'upt_id'        => $this->upt_id,
            'ultg_id'       => $this->ultg_id,
            'substation_id' => $this->substation_id,
            'datetime' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['timestamp']),
            'dist_dur' => $row['ss1_distdur'],
            'presentase_r' => $row['prosentasi_r'],
            'voltage_r' => $row['maginitude_tegangan_r'],
            'dist_vr_min' => $row['ss1_distv1min'],
            'dist_vr_max' => $row['ss1_distv1max'],
            'dist_vr_avg' => $row['ss1_distv1avg'],
            'dist_vr_eng' => $row['ss1_distv1engy'],
            'presentase_s' => $row['prosentasi_s'],
            'voltage_s' => $row['maginitude_tegangan_s'],
            'dist_vs_min' => $row['ss1_distv2min'],
            'dist_vs_max' => $row['ss1_distv2max'],
            'dist_vs_avg' => $row['ss1_distv2avg'],
            'dist_vs_eng' => $row['ss1_distv2engy'],
            'presentase_t' => $row['prosentasi_t'],
            'voltage_t' => $row['maginitude_tegangan_t'],
            'dist_vt_min' => $row['ss1_distv3min'],
            'dist_vt_max' => $row['ss1_distv3max'],
            'dist_vt_avg' => $row['ss1_distv3avg'],
            'dist_vt_eng' => $row['ss1_distv3engy'],
            'gardu_induk' => $row['gardu_induk'],
            'bay' => $row['bay'],
            'kondisi' => $row['kondisi'],
            'waktu_gangguan' => $row['waktu_gangguan'],
            'penyebab' => $row['penyebab'],
            'keterangan' => $row['keterangan'],
            // 'created_by' => Auth::user()->name,
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
