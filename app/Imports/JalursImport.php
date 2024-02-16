<?php

namespace App\Imports;

use App\Models\Jalurs;
use App\Models\Locations;
use App\Models\SubsystemDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;

class JalursImport implements ToModel, WithHeadingRow, SkipsOnFailure
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // catatan
        // pencarian substation id berdasarkan dari id functloc 16 dari kiri
        // pencarian ultg diambil dari section_id setelah didapat substation id
        // pencarian upt id berdasarkan dari id functloc 8 dari kiri
        // pencarian subsystem id diambil dari subsystem detail berdasarkan subsystem id dari data pertama yang didapat
        $idFlSubstation = substr($row['id_functloc'], 0, 16);
        $idFlUpt = substr($row['id_functloc'], 0, 8);
        $location = Locations::where('id_functloc', $idFlSubstation)->first();
        $locationUltg = $location != null ? Locations::where('id', $location->section_id)->first() : null;
        $locationUpt = $location != null ? Locations::where('id_functloc', $idFlUpt)->first() : null;
        $subsystem = SubsystemDetails::where('substation_id', $location != null ? $location->id : '28q4627863286')->first();
        return new Jalurs([
            'subsystem_id' => $subsystem != null ? $subsystem->subsystem_id : null,
            'upt_id' => $locationUpt != null ? $locationUpt->id : Auth::user()->level_upt,
            'ultg_id' => $locationUltg != null ? $locationUltg->id : null,
            'substation_id' => $subsystem != null ? $subsystem->substation_id : null,
            'no_wo' => $row['no_wo'],
            'no_notif' => $row['no_notif'],
            'location' => $row['lokasi'],
            'uraian_pekerjaan' => $row['uraian_pekerjaan'],
            'tegangan' => $row['tegangan'],
            'id_functloc' => $row['id_functloc'],
            'peralatan_padam' => $row['peralatan_padam'],
            'sifat' => $row['sifat'],
            'penanggung_jawab' => $row['penanggung_jawab'],
            'no_spk' => $row['no_spk'],
            'awal_usulan' => $row['awal_usulan'],
            'akhir_usulan' => $row['akhir_usulan'],
            'jam_usulan' => $row['jam_usulan'],
            'awal_jadwal' => $row['awal_jadwal'] == "" ? null : $row['awal_jadwal'],
            'akhir_jadwal' => $row['akhir_jadwal'] == "" ? null : $row['akhir_jadwal'],
            'jam_jadwal' => $row['jam_jadwal'],
            'rencana' => $row['rencana'],
            'keterangan' => $row['keterangan'],
            'created_by' => Auth::user()->name,
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now(),
        ]);
    }

    public function onFailure(Failure ...$failures)
    {
        // Handle the failures how you'd like.
    }

    // public function sheets(): array
    // {
    //     return [
    //         'sheet_for_import' => new FirstSheetImport()
    //     ];
    // }

    // public function batchSize(): int
    // {
    //     return 1000;
    // }

    // public function chunkSize(): int
    // {
    //     return 1000;
    // }
}
