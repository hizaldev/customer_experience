@extends('layouts.app')

@section('content')
     <!-- Page header -->
     <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2 align-items-center">
            <div class="col">
              <h2 class="page-title">
                Data Gangguan
              </h2>
            </div>
          </div>
        </div>
      </div>
      <!-- Page body -->
      <div class="page-body">
        <div class="container-xl">
          <div class="row row-cards">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Data Gangguan</h3>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" class="mb-4" id="search-form">
                      @csrf
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group mb-3">
                            <label for="upt_id">Unit <span class="text-danger">*</span> </label>
                            <select name="upt_id" class="form-control @error('upt_id') is-invalid @enderror" id="level_upt" required>
                                @canany([
                                  'transaksi_gangguan-list',
                                  'transaksi_gangguan-list-induk',
                                ])
                                  <option value="">-- Pilih Unit --</option>
                                @endcan
                                @foreach ( $unit as $units )
                                    <option value="{{$units->id}}" {{$unit_id == $units->id ? 'selected' : ''}}>{{$units->description}}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group mb-3">
                            <label for="level_ultg">ULTG <span class="text-danger">*</span> </label>
                            <select name="ultg_id" class="form-control" id="level_ultg">
                                @canany([
                                  'transaksi_gangguan-list',
                                  'transaksi_gangguan-list-induk',
                                  'transaksi_gangguan-list-unit',
                                ])
                                  <option value="">-- Pilih ULTG --</option>
                                @endcan
                                @foreach ( $ultg as $ultg )
                                    <option value="{{$ultg->id}}" {{$ultg_id == $ultg->id ? 'selected' : ''}}>{{$ultg->description}}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group mb-3">
                            <label for="level_substation">Gardu Induk <span class="text-danger">*</span> </label>
                            <select name="substation_id" class="form-control js-example-basic-single" id="level_substation">
                                <option value="">-- Pilih Gardu Induk --</option>
                                @foreach ( $substation as $gi )
                                    <option value="{{$gi->id}}" {{$sub_station_id == $gi->id ? 'selected' : ''}}>{{$gi->description}}</option>
                                @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group mb-3">
                            <label for="level_upt">Subsystem <span class="text-danger">*</span> </label>
                            <select name="subsystem_id" class="form-control" id="subsystem_id">
                                <option value="">-- Pilih Subsystem --</option>
                                @foreach ( $subsystem as $subs )
                                    <option value="{{$subs->id}}">{{$subs->subsystem}}</option>
                                @endforeach
                            </select>
                          </div>
                          <div class="form-group mb-3">
                            <label for="cuaca">Tanggal Awal</label>
                            <input type="date" class="form-control" name="tgl_awal" id="tgl_awal" value="{{$start_date}}" placeholder="Masukan Tanggal Awal">
                          </div>
                          <div class="form-group mb-3">
                            <label for="cuaca">Tanggal Akhir</label>
                            <input type="date" class="form-control" name="tgl_akhir" id="tgl_akhir" value="{{$end_date}}" placeholder="Masukan Tanggal Akhir">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-6 col-sm-4 col-md-2 col-xl-auto py-3">
                            <button type="submit" class="btn btn-sm btn-facebook w-100">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M11.36 20.213l-2.36 .787v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414" />
                                <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                <path d="M20.2 20.2l1.8 1.8" />
                              </svg>
                              Filter
                            </button>
                          </div>
                        </div>
                        
                      </div>
                    </form>
                    <div class="table-responsive">
                        <table id="example" class="table table-vcenter card-table table-striped">
                          <thead>
                            <tr>
                              <th class="w-1"></th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="Subsystem" data-column="1">
                              </th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="UPT" data-column="2">
                              </th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="ULTG" data-column="3">
                              </th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="Gardu Induk" data-column="4">
                              </th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="Bay" data-column="5">
                              </th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="Waktu Gangguan" data-column="6">
                              </th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="Jenis Gangguan" data-column="7">
                              </th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="Tipe Gangguan" data-column="8">
                              </th>
                              @can('transaksi_gangguan-show')
                                  <th ></th>
                              @endcan
                              @can('transaksi_investigasi_gangguan-create')
                                <th ></th>
                              @endcan
                              @can('transaksi_tindaklanjut_gangguan-create')
                                <th ></th>
                              @endcan 
                              @can('transaksi_gangguan-edit')
                                  <th ></th>
                              @endcan
                              @can('transaksi_gangguan-delete')
                                  <th></th>
                              @endcan
                            </tr>
                            <tr>
                              <th class="w-1">No.</th>
                              <th>Subsystem</th>
                              <th>UPT</th>
                              <th>ULTG</th>
                              <th>Gardu Induk</th>
                              <th>Bay</th>
                              <th>Waktu Gangguan</th>
                              <th>Jenis Gangguan</th>
                              <th>Tipe Gangguan</th>
                              @can('transaksi_gangguan-show')
                                  <th ></th>
                              @endcan
                              @can('transaksi_investigasi_gangguan-create')
                                <th ></th>
                              @endcan
                              @can('transaksi_tindaklanjut_gangguan-create')
                                <th ></th>
                              @endcan 
                              @can('transaksi_gangguan-edit')
                                  <th ></th>
                              @endcan
                              @can('transaksi_gangguan-delete')
                                  <th></th>
                              @endcan
                            </tr>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>
                      </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      {{-- start modal --}}
        <div class="modal modal-blur fade" id="modal-team" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Data Detail Gangguan</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div id="showdata"></div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
          </div>
        </div>
      {{-- end modal --}}    
@endsection

@push('addon-style')

@endpush

@push('addon-script')
    {{-- light dark --}}
    <script src="{{ asset('dist/js/demo-theme.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('dist/js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('dist/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dist/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('dist/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dist/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('dist/js/jszip.min.js') }}"></script>
    <script src="{{ asset('dist/js/buttons.html5.min.js') }}"></script>
    <!-- Page specific script -->
    <script>
        var datatables = $('#example').DataTable({
            processing : true,
            serverSide  : true,
            ordering : true,
            sDom: 'Blrtip',
            ajax: {
                url: '{!! url()->current() !!}',
                data: function (d) {
                    d.upt_id = $('select[name=upt_id]').val();
                    d.ultg_id = $('select[name=ultg_id]').val();
                    d.substation_id = $('select[name=substation_id]').val();
                    d.subsystem_id = $('select[name=subsystem_id]').val();
                    d.tgl_awal = $('#tgl_awal').val();
                    d.tgl_akhir = $('#tgl_akhir').val();
                }
            },
            columns : [
                { data: 'DT_RowIndex', 'orderable': false, 'searchable': false, width: '5%' },
                {data: 'subsystem', name: 'subsystem'},
                {data: 'upt', name: 'upt'},
                {data: 'ultg', name: 'ultg'},
                {data: 'gi', name: 'gi'},
                {data: 'bay', name: 'bay'},
                {data: 'tgl_gangguan', name: 'tgl_gangguan'},
                {data: 'jenis_gangguan', name: 'jenis_gangguan'},
                {data: 'tipe_gangguan', name: 'tipe_gangguan'},
                @can('transaksi_gangguan-show')
                  {
                      data: 'show', 
                      name: 'show',
                      orderable: false,
                      searchable: false,
                      width: '1%'
                  },
                @endcan
                @can('transaksi_investigasi_gangguan-create')
                  {
                      data: 'addInvestigasi', 
                      name: 'addInvestigasi',
                      orderable: false,
                      searchable: false,
                      width: '1%'
                  },
                @endcan
                @can('transaksi_tindaklanjut_gangguan-create')
                  {
                      data: 'addTindaklanjut', 
                      name: 'addTindaklanjut',
                      orderable: false,
                      searchable: false,
                      width: '1%'
                  },
                @endcan
                @can('transaksi_gangguan-edit')
                  {
                      data: 'edit', 
                      name: 'edit',
                      orderable: false,
                      searchable: false,
                      width: '1%'
                  },
                @endcan
                @can('transaksi_gangguan-delete')
                {
                    data: 'delete', 
                    name: 'delete',
                    orderable: false,
                    searchable: false,
                    width: '1%'
                },
                @endcan
            ],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100,  "All"]],
            buttons : [ 
                @can('transaksi_gangguan-create')
                    {
                        text: 'Tambah',
                        className: 'btn btn-primary btn-sm btn-fw mb-4 mr-2 p-1',
                        action: function ( e, dt, button, config ) {
                            window.location = '{{ route('gangguan.create') }}';
                        }        
                    },
                @endcan
                {
                    extend : 'excelHtml5',
                    text : 'export',
 
                    className: 'btn btn-success btn-fw mb-4 btn-sm',
                } 
            ]
        })
        $('.filter-input').keyup(function(){
            datatables.column($(this).data('column'))
            .search($(this).val())
            .draw();
        });

        $('.filter-select').change(function(){
            datatables.column($(this).data('column'))
            .search($(this).val())
            .draw();
        });

        $('#search-form').on('submit', function(e) {
            datatables.draw();
            e.preventDefault();
        });
    </script>
    <script type="text/javascript"> 
      function showDetail(txt,value){
        console.log(value);
        $value = value;
         $.ajax({
          type:"POST",
          url:"{{route('gangguan.showDataGangguan')}}",
          data :  {
            "_token": "{{ csrf_token() }}",
            "gangguan_id": value
          },
          dataType:"json",
        beforeSend:function(e){
          if(e&&e.overrideMimeType){e.overrideMimeType("application/json;charset=UTF-8");}
        },
        success:function(response){
          $("#showdata").html(response.list_data).show();
        },error:function(xhr,ajaxOptions,thrownError){
          alert(xhr.status+"\n"+xhr.responseText+"\n"+thrownError);
        }});
      }
    </script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#level_upt').on('change', function() {
            var idUpt = $(this).val();
            if(idUpt) {
                console.log('ada perubahan neh');
                $.ajax({
                    url: "{{ url('api/ultg') }}/"+idUpt ,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="ultg_id"]').empty();
                        $('select[name="ultg_id"]').append('<option value="">-- Pilih ULTG --</option>');
                        $.each(data, function(key, value) {
                            $('select[name="ultg_id"]').append('<option value="'+ value.id +'">'+ value.description +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="ultg_id"]').empty();
            }
        });
        $('#level_ultg').on('change', function() {
            var idSection = $(this).val();
            if(idSection) {
                console.log('ada perubahan neh');
                $.ajax({
                    url: "{{ url('api/gardu_induk') }}/"+idSection ,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                      $('#level_substation').empty();
                      $('#level_substation').append('<option value="">-- Pilih Gardu Induk --</option>');
                      $.each(data, function(key, value) {
                          $('#level_substation').append('<option value="'+ value.id +'">'+ value.description +'</option>');
                      });
                    }
                });
            }else{
                $('select[name="level_substation"]').empty();
            }
        });
      });
    </script>
@endpush
