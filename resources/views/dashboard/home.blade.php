@extends('layouts.app')

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                Overview
                </div>
                <h2 class="page-title">
                Dashboard Konsumen {{$data_konsumen}}
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <form method="GET" action="{{ route('dashboard_konsumen')}}" enctype="multipart/form-data" class="d-flex mb-4">
                    @csrf
                    <div class="btn-list">
                    <span class="d-none d-sm-inline">
                        <div class="form-group">
                            <select name="consumer_id" class="form-control" id="consumer_id">
                                <option value="">-- Pilih Konsumen KTT --</option>
                                @foreach ( $konsumen as $kons )
                                    <option value="{{$kons->id}}" {{$consumer_id == $kons->id ? 'selected' : ''}}>{{$kons->nama_ktt}}</option>
                                @endforeach
                            </select>
                        </div>
                    </span>
                    <button type="submit" class="btn btn-primary d-none d-sm-inline-block">Submit</button>
                    <button type="button" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#filter-pqm" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter-code" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M11.19 20.27l-2.19 .73v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v1.5" />
                            <path d="M20 21l2 -2l-2 -2" />
                            <path d="M17 17l-2 2l2 2" />
                        </svg>
                        Filter Tgl
                    </button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                {{-- start bmkg --}}
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader mb-1">Informasi sistem</div>
                                    <div class="ms-auto">
                                        <div class="subheader mb-1">Tengah Malam</div>
                    
                                    </div>
                                </div>
                                <div class="d-flex align-items-baseline">
                                    <div class="h1 mb-0 me-2">
                                        <span class="text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                            <img src="{{$data_cuaca_dini_hari != null ? $data_cuaca_dini_hari->image : '-'}}" alt="">
                                        </span>
                                    </div>
                                        <div class="me-auto">
                                            <span class=" h4 d-inline-flex align-items-center lh-1">
                                                {{$data_temperatur_dini_hari}} C
                                            </span>
                                        </div>
                                    </div>
                                
                                <div class="h3 mb-1">{{$data_cuaca_dini_hari != null ? $data_cuaca_dini_hari->cuaca : 'Belum ada prakiraan cuaca'}}</div>
                                <div class="d-flex align-items-center">
                                    <div class="subheader mb-1">
                                        <div class="h3 mb-1 text-dark">{{$data_humidity_dini_hari != null ? $data_humidity_dini_hari : '0'}} %</div>
                                        Humidity
                                    </div>
                                    <div class="ms-auto">
                                        <div class="subheader mb-1">
                                            <div class="h3 mb-1 text-dark">{{$data_kecepatan_angin_dini_hari != null ? $data_kecepatan_angin_dini_hari : '0'}} Kph</div>
                                            Kecepatan Angin
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex mb-2">
                                    {!!$data_cuaca_dini_hari != null ? $data_cuaca_dini_hari->potensi_cuaca : '<p>Tidak ada informasi</p>'!!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader mb-1">Informasi sistem</div>
                                    <div class="ms-auto">
                                        <div class="subheader mb-1">Pagi hari</div>
                    
                                    </div>
                                </div>
                                <div class="d-flex align-items-baseline">
                                    <div class="h1 mb-0 me-2">
                                        <span class="text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                            <img src="{{$data_cuaca_pagi_hari != null ? $data_cuaca_pagi_hari->image : '-'}}" alt="">
                                        </span>
                                    </div>
                                        <div class="me-auto">
                                            <span class=" h4 d-inline-flex align-items-center lh-1">
                                                {{$data_temperatur_pagi_hari}} C
                                            </span>
                                        </div>
                                    </div>
                                
                                <div class="h3 mb-1">{{$data_cuaca_pagi_hari != null ? $data_cuaca_pagi_hari->cuaca : 'Belum ada prakiraan cuaca'}}</div>
                                <div class="d-flex align-items-center">
                                    <div class="subheader mb-1">
                                        <div class="h3 mb-1 text-dark">{{$data_humidity_pagi_hari != null ? $data_humidity_pagi_hari : '0'}} %</div>
                                        Humidity
                                    </div>
                                    <div class="ms-auto">
                                        <div class="subheader mb-1">
                                            <div class="h3 mb-1 text-dark">{{$data_kecepatan_angin_pagi_hari != null ? $data_kecepatan_angin_pagi_hari : '0'}} Kph</div>
                                            Kecepatan Angin
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex mb-2">
                                    {!!$data_cuaca_pagi_hari != null ? $data_cuaca_pagi_hari->potensi_cuaca : '<p>Tidak ada informasi</p>'!!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader mb-1">Informasi sistem</div>
                                    <div class="ms-auto">
                                        <div class="subheader mb-1">Siang Hari hari</div>
                    
                                    </div>
                                </div>
                                <div class="d-flex align-items-baseline">
                                    <div class="h1 mb-0 me-2">
                                        <span class="text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                            <img src="{{$data_cuaca_siang_hari != null ? $data_cuaca_siang_hari->image : '-'}}" alt="">
                                        </span>
                                    </div>
                                        <div class="me-auto">
                                            <span class=" h4 d-inline-flex align-items-center lh-1">
                                                {{$data_temperatur_siang_hari}} C
                                            </span>
                                        </div>
                                    </div>
                                
                                <div class="h3 mb-1">{{$data_cuaca_siang_hari != null ? $data_cuaca_siang_hari->cuaca : 'Belum ada prakiraan cuaca'}}</div>
                                <div class="d-flex align-items-center">
                                    <div class="subheader mb-1">
                                        <div class="h3 mb-1 text-dark">{{$data_humidity_siang_hari != null ? $data_humidity_siang_hari : '0'}} %</div>
                                        Humidity
                                    </div>
                                    <div class="ms-auto">
                                        <div class="subheader mb-1">
                                            <div class="h3 mb-1 text-dark">{{$data_kecepatan_angin_siang_hari != null ? $data_kecepatan_angin_siang_hari : '0'}} Kph</div>
                                            Kecepatan Angin
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex mb-2">
                                    {!!$data_cuaca_siang_hari != null ? $data_cuaca_siang_hari->potensi_cuaca : '<p>Tidak ada informasi</p>'!!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader mb-1">Informasi sistem</div>
                                    <div class="ms-auto">
                                        <div class="subheader mb-1">Sore Hari hari</div>
                    
                                    </div>
                                </div>
                                <div class="d-flex align-items-baseline">
                                    <div class="h1 mb-0 me-2">
                                        <span class="text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                            <img src="{{$data_cuaca_sore_hari != null ? $data_cuaca_sore_hari->image : '-'}}" alt="">
                                        </span>
                                    </div>
                                        <div class="me-auto">
                                            <span class=" h4 d-inline-flex align-items-center lh-1">
                                                {{$data_temperatur_sore_hari}} C
                                            </span>
                                        </div>
                                    </div>
                                
                                <div class="h3 mb-1">{{$data_cuaca_sore_hari != null ? $data_cuaca_sore_hari->cuaca : 'Belum ada prakiraan cuaca'}}</div>
                                <div class="d-flex align-items-center">
                                    <div class="subheader mb-1">
                                        <div class="h3 mb-1 text-dark">{{$data_humidity_sore_hari != null ? $data_humidity_sore_hari : '0'}} %</div>
                                        Humidity
                                    </div>
                                    <div class="ms-auto">
                                        <div class="subheader mb-1">
                                            <div class="h3 mb-1 text-dark">{{$data_kecepatan_angin_sore_hari != null ? $data_kecepatan_angin_sore_hari : '0'}} Kph</div>
                                            Kecepatan Angin
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex mb-2">
                                    {!!$data_cuaca_siang_hari != null ? $data_cuaca_sore_hari->potensi_cuaca : '<p>Tidak ada informasi</p>'!!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-danger">Sumber data BMKG https://data.bmkg.go.id/prakiraan-cuaca/</p>
                {{-- end bmkg --}}
            <div class="col-lg-6">
                <div class="card">
                <div class="card-body">
                    {{-- <h3 class="card-title"></h3> --}}
                    <div class="d-flex">
                        <h3 class="card-title">Data PQM Konsumen <span id="startDate">{{$start_date}}</span> s/d <span id="endDate">{{$end_date}}</span></h3>
                      </div>
                    {{-- <div id="chart-mentions" class="chart-lg"></div> --}}
                    {{-- <div id="chart-line-stroke" class="chart-lg"></div> --}}
                    <div id="chart-temperature" class="chart-lg"></div>
                    <div id="chart-tasks-overview"></div>
                </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100" >
                    <div class="card-body">
                        <h3 class="card-title">Petugas Kami</h3>
                        <div class="divide-y">
                            @forelse ( $petugas as $officer )
                                <div>
                                    <div class="row">
                                        <div class="col-auto">
                                            <span class="avatar">JL</span>
                                        </div>
                                        <div class="col">
                                            <div class="text-truncate">
                                            <strong>{{$officer->name}}</strong>
                                            </div>
                                            <div class="text-muted">{{$officer->posisi_name}}</div>
                                        </div>
                                        <div class="col-auto align-self-center">
                                            <a href="#" class="text-success">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-whatsapp" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9"></path>
                                                    <path d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1"></path>
                                                </svg>
                                            </a>
                                            
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div>
                                    <div class="row">
                                    <div class="col-auto">
                                        <span class="avatar">JL</span>
                                    </div>
                                    <div class="col">
                                        <div class="text-truncate">
                                        <strong>Fullan</strong>
                                        </div>
                                        <div class="text-muted">Junior Officer Gardu Induk</div>
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <a href="#" class="text-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-whatsapp" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9"></path>
                                                <path d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1"></path>
                                            </svg>
                                        </a>
                                    </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                    <div class="col-auto">
                                        <span class="avatar">JL</span>
                                    </div>
                                    <div class="col">
                                        <div class="text-truncate">
                                        <strong>Fullan</strong>
                                        </div>
                                        <div class="text-muted">Junior Officer Gardu Induk</div>
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <a href="#" class="text-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-whatsapp" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9"></path>
                                                <path d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1"></path>
                                            </svg>
                                        </a>
                                    </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                    <div class="col-auto">
                                        <span class="avatar">JL</span>
                                    </div>
                                    <div class="col">
                                        <div class="text-truncate">
                                        <strong>Fullan</strong>
                                        </div>
                                        <div class="text-muted">Junior Officer Gardu Induk</div>
                                    </div>
                                    <div class="col-auto align-self-center">
                                        <a href="#" class="text-success">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-whatsapp" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9"></path>
                                                <path d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1"></path>
                                            </svg>
                                        </a>
                                    </div>
                                    </div>
                                </div>
                            @endforelse
                            
                           
                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">History Gangguan KTT dan Subsytem KTT <span id="startDateGangguan">{{$start_date}}</span> s/d <span id="endDateGangguan">{{$end_date}}</span></h3>
                    </div>
                    <div class="card-table table-responsive">
                        
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                    <th>Subsystem</th>
                                    <th>UPT</th>
                                    <th>ULTG</th>
                                    <th>Gardu Induk</th>
                                    <th>Bay</th>
                                    <th>Waktu Gangguan</th>
                                    <th>Jenis Gangguan</th>
                                    <th>Tipe Gangguan</th>
                                </tr>
                            </thead>
                            <tbody id="dataGangguanDashboard">
                                
                            </tbody>
                            
                        </table>
                        
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Jadwal Pemeliharaan KTT dan Subsytem KTT <span id="startDateJalur">{{$start_date}}</span> s/d <span id="endDateJalur">{{$end_date}}</span></h3>
                    </div>
                    <div class="card-table table-responsive">
                        
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                    <th>Subsystem</th>
                                    <th>Gardu Induk</th>
                                    <th>Peralatan Padam</th>
                                    <th>Uraian Pekerjaan</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Berakhir</th>
                                </tr>
                            </thead>
                            <tbody id="dataJalurDashboard">
                                
                            </tbody>
                            
                        </table>
                        
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Healty Index Peralatan</h3>
                    </div>
                    <div class="card-table table-responsive">
                        <h3 class="px-4 pt-2">Current Transformer</h3>
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                <th>Gardu Induk</th>
                                <th>Bay</th>
                                <th>Phasa</th>
                                <th>Status HI</th>
                                <th>Prioritas</th>
                                <th>Justifikasi</th>
                                </tr>
                            </thead>
                            @forelse ( $index_ct['data'] as $ct )
                                <tr>
                                    <td>{{$ct['GI']}}</td>
                                    <td class="text-muted">{{$ct['BAY']}}</td>
                                    <td class="text-muted">{{$ct['PHASA']}}</td>
                                    <td class="{{$ct['STATUS_HI'] == "POOR" ? 'text-red' : 'text-green'}}">{{$ct['STATUS_HI']}}</td>
                                    <td class="text-muted">{{$ct['PRIORITAS_PENGGANTIAN']}}</td>
                                    <td class="text-green">{{$ct['JUSTIFIKASI_PRIORITAS']}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center"> Tidak Ada Data Healty Index Tersedia</td>
                                </tr>
                            @endforelse
                           
                            
                        </table>
                        <h3 class="px-4 pt-2">Potential Transformer</h3>
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                <th>Gardu Induk</th>
                                <th>Bay</th>
                                <th>Phasa</th>
                                <th>Status HI</th>
                                <th>Prioritas</th>
                                <th>Justifikasi</th>
                                </tr>
                            </thead>
                            @forelse ( $index_pt['data'] as $pt )
                                <tr>
                                    <td>{{$pt['GI']}}</td>
                                    <td class="text-muted">{{$pt['BAY']}}</td>
                                    <td class="text-muted">{{$pt['PHASA']}}</td>
                                    <td class="{{$pt['STATUS_HI'] == "POOR" ? 'text-red' : 'text-green'}}">{{$pt['STATUS_HI']}}</td>
                                    <td class="text-muted">{{$pt['PRIORITAS_PENGGANTIAN']}}</td>
                                    <td class="text-green">{{$pt['JUSTIFIKASI_PRIORITAS']}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center"> Tidak Ada Data Healty Index Tersedia</td>
                                </tr>
                            @endforelse
                           
                            
                        </table>
                        <h3 class="px-4 pt-2">Circuit Breaker</h3>
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                <th>Gardu Induk</th>
                                <th>Bay</th>
                                <th>Phasa</th>
                                <th>Status HI</th>
                                <th>Prioritas</th>
                                <th>Justifikasi</th>
                                </tr>
                            </thead>
                            @forelse ( $index_pmt['data'] as $pmt )
                                <tr>
                                    <td>{{$pmt['GI']}}</td>
                                    <td class="text-muted">{{$pmt['BAY']}}</td>
                                    <td class="text-muted">{{$pmt['PHASA']}}</td>
                                    <td class="{{$pmt['STATUS_HI'] == "POOR" ? 'text-red' : 'text-green'}}">{{$pmt['STATUS_HI']}}</td>
                                    <td class="text-muted">{{$pmt['PRIORITAS_PENGGANTIAN']}}</td>
                                    <td class="text-green">{{$pmt['JUSTIFIKASI_PRIORITAS']}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center"> Tidak Ada Data Healty Index Tersedia</td>
                                </tr>
                            @endforelse
                        </table>
                        <h3 class="px-4 pt-2">Disconnecting Switch</h3>
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                <th>Gardu Induk</th>
                                <th>Bay</th>
                                <th>Phasa</th>
                                <th>Status HI</th>
                                <th>Prioritas</th>
                                <th>Justifikasi</th>
                                </tr>
                            </thead>
                            @forelse ( $index_pms['data'] as $pms )
                                <tr>
                                    <td>{{$pms['GI']}}</td>
                                    <td class="text-muted">{{$pms['BAY']}}</td>
                                    <td class="text-muted">{{$pms['PHASA']}}</td>
                                    <td class="{{$pms['STATUS_HI'] == "POOR" ? 'text-red' : 'text-green'}}">{{$pms['STATUS_HI']}}</td>
                                    <td class="text-muted">{{$pms['PRIORITAS_PENGGANTIAN']}}</td>
                                    <td class="text-green">{{$pms['JUSTIFIKASI_PRIORITAS']}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center"> Tidak Ada Data Healty Index Tersedia</td>
                                </tr>
                            @endforelse
                        </table>
                        <h3 class="px-4 pt-2">Lightning Arrester</h3>
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                <th>Gardu Induk</th>
                                <th>Bay</th>
                                <th>Phasa</th>
                                <th>Status HI</th>
                                <th>Prioritas</th>
                                <th>Justifikasi</th>
                                </tr>
                            </thead>
                            @forelse ( $index_la['data'] as $la )
                                <tr>
                                    <td>{{$la['GI']}}</td>
                                    <td class="text-muted">{{$la['BAY']}}</td>
                                    <td class="text-muted">{{$la['PHASA']}}</td>
                                    <td class="{{$la['STATUS_HI'] == "POOR" ? 'text-red' : 'text-green'}}">{{$la['STATUS_HI']}}</td>
                                    <td class="text-muted">{{$la['PRIORITAS_PENGGANTIAN']}}</td>
                                    <td class="text-green">{{$la['JUSTIFIKASI_PRIORITAS']}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center"> Tidak Ada Data Healty Index Tersedia</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    {{-- start modal filter date --}}
    <div class="modal modal-blur fade" id="filter-pqm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Filter Tanggal Data Dashbaord</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form action="#" method="POST" id="filterDataPqm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="start_date">Tanggal Awal</label>
                                <input type="date" class="form-control" name="start_date" id="start_date" value="{{ $start_date}}" value="">
                              </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="start_date">Tanggal Akhir</label>
                                <input type="date" class="form-control" name="end_date" id="end_date" value="{{$end_date}}">
                            </div>
                        </div>
                    </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="showChart()" class="btn btn-primary mr-2 mt-2">Submit</button>
              </div>
          </div>
        </div>
      </div>
    {{-- end modal --}}    
@endsection

@push('addon-style')

@endpush

@push('addon-script')
    <script src="{{ asset('dist/js/demo-theme.min.js') }}"></script>
    <!-- Libs JS -->
    <script src="{{ asset('dist/js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('dist/libs/apexcharts/dist/apexcharts.min.js') }}" defer></script>
    <script src="{{ asset('dist/libs/jsvectormap/dist/js/jsvectormap.min.js') }}" defer></script>
    <script src="{{ asset('dist/libs/jsvectormap/dist/maps/world.js') }}" defer></script>
    <script src="{{ asset('dist/libs/jsvectormap/dist/maps/world-merc.js') }}" defer></script>
    <script>
        // @formatter:off
        document.addEventListener("DOMContentLoaded", function () {
            showChart()
        });
        // @formatter:on
    </script>
    <script type="text/javascript"> 
        function showChart(){
            var startDate = $("#start_date").val()
            var endDate = $("#end_date").val()
            var substationId = $("#substation_id").val()
            document.getElementById("startDate").innerHTML = startDate;
            document.getElementById("endDate").innerHTML = endDate;
            document.getElementById("startDateGangguan").innerHTML = startDate;
            document.getElementById("endDateGangguan").innerHTML = endDate;
            document.getElementById("startDateJalur").innerHTML = startDate;
            document.getElementById("endDateJalur").innerHTML = endDate;
          
            // data PQM
            $.ajax({
                type:"POST",
                url:"{{route('showInfoChart')}}",
                data :  {
                "_token": "{{ csrf_token() }}",
                "start_date": startDate,
                "end_date": endDate,
                "substation_id": "{{$substation_id}}",
                
                },
                    dataType:"json",
                beforeSend:function(e){
                    if(e&&e.overrideMimeType){e.overrideMimeType("application/json;charset=UTF-8");}
                },
                success:function(response){
                    document.getElementById('chart-temperature').innerHTML = "";
                    document.getElementById('chart-tasks-overview').innerHTML = "";
                    chartPqm(response)
                    $('#filter-pqm').modal('hide');
                },error:function(xhr,ajaxOptions,thrownError){
                    alert(xhr.status+"\n"+xhr.responseText+"\n"+thrownError);
                }
            });
            // data Gangguan
            $.ajax({
                type:"POST",
                url:"{{route('showDataDashboardGangguan')}}",
                data :  {
                "_token": "{{ csrf_token() }}",
                "start_date": startDate,
                "end_date": endDate,
                "substation_id": "{{$substation_id}}",
                
                },
                    dataType:"json",
                beforeSend:function(e){
                    if(e&&e.overrideMimeType){e.overrideMimeType("application/json;charset=UTF-8");}
                },
                success:function(response){
                    console.log(response.length)
                    // dataGangguanDashboard
                    $('#dataGangguanDashboard').empty();
                    if(response.length > 0){
                        $.each(response, function(key, value) {
                            $('#dataGangguanDashboard').append('<tr><td>'+ value.subsystem +'</td><td>'+ value.upt +'</td><td>'+ value.ultg +'</td><td>'+ value.gi +'</td><td>'+ value.bay +'</td><td>'+ value.tgl_gangguan +'</td><td>'+ value.jenis_gangguan +'</td><td>'+ value.tipe_gangguan +'</td></tr>');
                        });
                    }else{
                        $('#dataGangguanDashboard').append('<tr><td colspan="8" class="text-center"> Tidak ada data gangguan tersedia</td></tr>');
                    }
                    
                },error:function(xhr,ajaxOptions,thrownError){
                    alert(xhr.status+"\n"+xhr.responseText+"\n"+thrownError);
                }
            });

            // data jalur
            $.ajax({
                type:"POST",
                url:"{{route('showDataDashboardJalur')}}",
                data :  {
                "_token": "{{ csrf_token() }}",
                "start_date": startDate,
                "end_date": endDate,
                "substation_id": "{{$substation_id}}",
                
                },
                    dataType:"json",
                beforeSend:function(e){
                    if(e&&e.overrideMimeType){e.overrideMimeType("application/json;charset=UTF-8");}
                },
                success:function(response){
                    console.log(response.length)
                    // dataGangguanDashboard
                    $('#dataJalurDashboard').empty();
                    if(response.length > 0){
                        $.each(response, function(key, value) {
                            $('#dataJalurDashboard').append('<tr><td>'+ value.subsystem +'</td><td>'+ value.gi +'</td><td>'+ value.peralatan_padam +'</td><td>'+ value.uraian_pekerjaan +'</td><td>'+ value.awal_jadwal +'</td><td>'+ value.akhir_jadwal +'</td></tr>');
                        });
                    }else{
                        $('#dataJalurDashboard').append('<tr><td colspan="8" class="text-center"> Tidak ada data Jadwal Pemeliharaan tersedia</td></tr>');
                    }
                    
                },error:function(xhr,ajaxOptions,thrownError){
                    alert(xhr.status+"\n"+xhr.responseText+"\n"+thrownError);
                }
            });
            
        }
        function chartPqm(data){
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-temperature'), {
                    chart: {
                        type: "line",
                        fontFamily: 'inherit',
                        height: 300,
                        parentHeightOffset: 0,
                        toolbar: {
                            show: false,
                        },
                        animations: {
                            enabled: false
                        },
                    },
                    fill: {
                        opacity: 1,
                    },
                    stroke: {
                        width: 2,
                        lineCap: "round",
                        curve: "smooth",
                    },
                    series: [{
                        name: "Dist VR Min",
                        data: data.dist_vr_min
                    },{
                        name: "Dist VS Min",
                        data: data.dist_vs_min
                    },
                    {
                        name: "Dist VT Min",
                        data: data.dist_vt_min
                    },
                    ],
                    tooltip: {
                        theme: 'dark'
                    },
                    grid: {
                        padding: {
                            top: -20,
                            right: 0,
                            left: -4,
                            bottom: -4
                        },
                        strokeDashArray: 4,
                    },
                    dataLabels: {
                        enabled: true,
                    },
                    xaxis: {
                        labels: {
                            padding: 0,
                        },
                        tooltip: {
                            enabled: false
                        },
                        categories: data.datetime,
                    },
                    yaxis: {
                        labels: {
                            padding: 4
                        },
                    },
                    colors: [tabler.getColor("red"), tabler.getColor("yellow"), tabler.getColor("green")],
                    legend: {
                        show: true,
                    },
                    markers: {
                        size: 2
                    },
            })).render();
            
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-tasks-overview'), {
                chart: {
                    type: "bar",
                    fontFamily: 'inherit',
                    height: 240,
                    parentHeightOffset: 0,
                    toolbar: {
                        show: false,
                    },
                    animations: {
                        enabled: false
                    },
                },
                plotOptions: {
                    bar: {
                        columnWidth: '50%',
                    }
                },
                dataLabels: {
                    enabled: false,
                },
                fill: {
                    opacity: 1,
                },
                series: [{
                    name: "Dist Duration",
                    data: data.dist_dur
                }],
                tooltip: {
                    theme: 'dark'
                },
                grid: {
                    padding: {
                        top: -20,
                        right: 0,
                        left: -4,
                        bottom: -4
                    },
                    strokeDashArray: 4,
                },
                xaxis: {
                    labels: {
                        padding: 0,
                    },
                    tooltip: {
                        enabled: false
                    },
                    axisBorder: {
                        show: false,
                    },
                    categories: data.datetime,
                },
                yaxis: {
                    labels: {
                        padding: 4
                    },
                },
                colors: [tabler.getColor("primary")],
                legend: {
                    show: true,
                },
            })).render();
        }

      </script>
    
@endpush
