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
                Dashboard
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <form method="GET" action="{{ route('home')}}" enctype="multipart/form-data" class="row row-cols-lg-auto g-3 align-items-center">
                    @csrf
                    
                      <div class="col-12">
                        <select name="unit" class="form-control" id="unit_id">
                            <option value="">-- Pilih Unit --</option>
                            @foreach ( $unit as $units )
                                <option value="{{$units->id}}" {{$selectUnit == $units->id ? 'selected' : ''}}>{{$units->nm_lokasi}}</option>
                            @endforeach
                        </select>
                      </div>
                    
                      <div class="col-12">
                        <select name="year" class="form-control" id="year">
                            {{ $last= 2023 }}
                            {{ $now = date('Y') }}
                            <option value="">-- Pilih Tahun --</option>
                            @for ($i = $now; $i >= $last; $i--)
                                <option value="{{ $i }}" {{$selectYear == $i ? 'selected' : ''}}>{{ $i }}</option>
                            @endfor
                        </select>
                      </div>
                    
                      <div class="col-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
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

            <div class="col-md-6">
                
                <div class="card">
                    <strong class="px-3 py-1">Gangguan Per ULTG</strong>
                  <div class="table-responsive">
                    <table class="table table-vcenter card-table table-striped">
                      <thead>
                        <tr>
                          <th>ULTG</th>
                          <th>Penghantar</th>
                          <th>Trafo</th>
                          <th>Busbar/ Diameter</th>
                          <th>Pembangkit</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ( $data_gangguan_type_by_ultg as $ultg )
                            <tr>
                                <td >{{$ultg->nm_lokasi}}</td>
                                <td class="text-muted" >{{$ultg->pht}}</td>
                                <td class="text-muted" >{{$ultg->trf}}</td>
                                <td class="text-muted" >{{$ultg->dia}}</td>
                                <td class="text-muted" >{{$ultg->kit}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Data gangguan tidak tersedia</td>
                            </tr>
                        @endforelse
                        
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <strong class="px-3 py-1">Keandalan KTT</strong>
                  <div class="table-responsive">
                    <table class="table table-vcenter card-table table-striped">
                      <thead>
                        <tr>
                          <th>KTT</th>
                          <th>Under SLA</th>
                          <th>Over SLA</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td >Asia Pasific Fiber</td>
                          <td class="text-muted" >0</td>
                          <td class="text-muted" >0</td>
                          <td class="text-muted" >0</td>
                        </tr>
                        <tr>
                            <td >Semen Grobogan</td>
                            <td class="text-muted" >0</td>
                            <td class="text-muted" >0</td>
                            <td class="text-muted" >0</td>
                          </tr>
                          <tr>
                            <td >Semindo</td>
                            <td class="text-muted" >0</td>
                            <td class="text-muted" >0</td>
                            <td class="text-muted" >0</td>
                          </tr>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    
                    <div class="d-flex align-items-center p-3">
                        <strong>Data Gangguan <span id="kategoriGangguan"></span></strong>
                        <div class="ms-auto lh-1">
                            <form method="GET" action="{{ route('home')}}" enctype="multipart/form-data" class="row row-cols-lg-auto g-3 align-items-center">
                                @csrf
                                
                                  <div class="col-12">
                                    <select name="tipe_gangguan_id" class="form-control" id="tipe_gangguan_id">
                                        @foreach ( $kategori as $kat )
                                            <option value="{{$kat->id}}" {{$kat->id == $selectKategori ? 'selected' : ''}}>{{$kat->tipe_gangguan}}</option>
                                        @endforeach
                                    </select>
                                  </div>
                                
                                  <div class="col-12">
                                    <button type="button" onclick="showDataTable()" class="btn btn-primary">Submit</button>
                                  </div>
                            </form>
                        </div>
                        </div>
                    <div class="p-3" id="chart-completion-tasks-9"></div>
                    <div class="table-responsive p-3">
                    <table class="table table-vcenter card-table table-striped">
                      <thead>
                        <tr class="px-0">
                          <th >Gangguan</th>
                          <th>Jan</th>
                          <th>Feb</th>
                          <th>Mar</th>
                          <th>Apr</th>
                          <th>May</th>
                          <th>Jun</th>
                          <th>Jul</th>
                          <th>Aug</th>
                          <th>Sep</th>
                          <th>Oct</th>
                          <th>Nov</th>
                          <th>Dec</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody id="dataRekapGangguan">
                        
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div> 
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
            showDataTable()
        });
        // @formatter:on
    </script>
    <script type="text/javascript"> 
        function showDataTable(){
            var unit_id = $("#unit_id").val()
            var tahun = $("#year").val()
            var tipe_gangguan_id = $("#tipe_gangguan_id").val()
            $.ajax({
                type:"POST",
                url:"{{route('showDataGangguanByCategories')}}",
                data :  {
                "_token": "{{ csrf_token() }}",
                "unit": unit_id,
                "tahun": tahun,
                "tipe_gangguan_id": tipe_gangguan_id,
                
                },
                    dataType:"json",
                beforeSend:function(e){
                    if(e&&e.overrideMimeType){e.overrideMimeType("application/json;charset=UTF-8");}
                },
                success:function(response){
                    console.log(response.length)
                    // dataGangguanDashboard
                    $('#dataRekapGangguan').empty();
                    setTimeout(() => {
                        if(response.length > 0){
                            $.each(response, function(key, value) {
                                $('#dataRekapGangguan').append('<tr><td class="py-1">'+ value.kategori_penyebab +'</td><td class="py-1 text-muted">'+ value.jan +'</td><td class="py-1 text-muted">'+ value.feb +'</td><td class="py-1 text-muted">'+ value.mar +'</td><td class="py-1 text-muted">'+ value.apr +'</td><td class="py-1 text-muted">'+ value.may +'</td><td class="py-1 text-muted">'+ value.jun +'</td><td class="py-1 text-muted">'+ value.jul +'</td><td class="py-1 text-muted">'+ value.aug +'</td><td class="py-1 text-muted">'+ value.sep +'</td><td class="py-1 text-muted">'+ value.okt +'</td><td class="py-1 text-muted">'+ value.nov +'</td><td class="py-1 text-muted">'+ value.des +'</td><td class="py-1 text-muted">'+ value.des +'</td></tr>');
                            });
                        }else{
                            $('#dataRekapGangguan').append('<tr><td colspan="13" class="text-center"> Tidak ada data rekap gangguan tersedia</td></tr>');
                        }
                    }, 1000);
                    $('#filter-pqm').modal('hide');
                },error:function(xhr,ajaxOptions,thrownError){
                    // alert(xhr.status+"\n"+xhr.responseText+"\n"+thrownError);
                }
            });
            $.ajax({
                type:"POST",
                url:"{{route('showDataChartRekapGangguanByCategories')}}",
                data :  {
                "_token": "{{ csrf_token() }}",
                "unit": unit_id,
                "tahun": tahun,
                "tipe_gangguan_id": tipe_gangguan_id,
                
                },
                    dataType:"json",
                beforeSend:function(e){
                    if(e&&e.overrideMimeType){e.overrideMimeType("application/json;charset=UTF-8");}
                },
                success:function(response){
                    console.log(response)
                    chartGangguan(response.data)
                },error:function(xhr,ajaxOptions,thrownError){
                    // alert(xhr.status+"\n"+xhr.responseText+"\n"+thrownError);
                    alert('Pilih Unit Terlebih dahulu');
                }
            });
        }

        function chartGangguan(data){
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-completion-tasks-9'), {
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
                    stacked: true,
                },
                plotOptions: {
                    bar: {
                        columnWidth: '30%',
                    }
                },
                dataLabels: {
                    enabled: false,
                },
                fill: {
                    opacity: 1,
                },
                series: data,
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
                  
                },
                yaxis: {
                    labels: {
                        padding: 4
                    },
                },
                labels: [
                    'jan', 'Feb', 'mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                ],
                colors: [
                    tabler.getColor("primary"), 
                    tabler.getColor("red"), 
                    tabler.getColor("purple"), 
                    tabler.getColor("green"),
                    tabler.getColor("yellow"),
                    tabler.getColor("pink"),
                    tabler.getColor("indigo"),
                    tabler.getColor("orange"),
                    tabler.getColor("lime"),
                    tabler.getColor("teal"),
                    tabler.getColor("indigo"),
                    tabler.getColor("cyan"),
                    tabler.getColor("muted")
                ],
                legend: {
                    show: true,
                },
            })).render();
        }
    </script>
@endpush
