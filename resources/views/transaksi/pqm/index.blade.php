@extends('layouts.app')

@section('content')
     <!-- Page header -->
     <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2 align-items-center">
            <div class="col">
              <h2 class="page-title">
                PQM Konsumen Tegangan Tinggi
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
                  <h3 class="card-title">PQM Konsumen Tegangan Tinggi</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-vcenter card-table table-striped">
                          <thead>
                            <tr>
                              <th class="w-1"></th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="UPT" data-column="1">
                              </th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="ULTG" data-column="1">
                              </th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="Gardu Induk" data-column="1">
                              </th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="Timestamp" data-column="2">
                              </th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder=">SS1 DistDur (Detik)" data-column="3">
                              </th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="Prosentasi R(%)" data-column="4">
                              </th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="Prosentasi S(%)" data-column="5">
                              </th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="Prosentasi T(%)" data-column="6">
                              </th>
                              @can('transaksi_pqm_ktt-edit')
                                  <th ></th>
                              @endcan
                              @can('transaksi_pqm_ktt-delete')
                                  <th></th>
                              @endcan
                            </tr>
                            <tr>
                              <th class="w-1">No.</th>
                              <th>UPT</th>
                              <th>ULTG</th>
                              <th>Gardu Induk</th>
                              <th>Timestamp</th>
                              <th>SS1 DistDur (Detik)</th>
                              <th>Prosentasi R(%)</th>
                              <th>Prosentasi S(%)</th>
                              <th>Prosentasi T(%)</th>
                             
                              @can('transaksi_pqm_ktt-edit')
                                  <th ></th>
                              @endcan
                              @can('transaksi_pqm_ktt-delete')
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
      @can('transaksi_pqm_ktt-import')
        {{-- start modal --}}
          <div class="modal modal-blur fade" id="modal-team" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Import Data PQM</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('pqm.store')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="modal-body">
                    <div class="form-group mb-3">
                      <label for="level_upt">Unit <span class="text-danger">*</span> </label>
                      <select name="level_upt" class="form-control @error('level_upt') is-invalid @enderror" id="level_upt" required>
                          <option value="">-- Pilih Unit --</option>
                          @foreach ( $unit as $units )
                              <option value="{{$units->id}}" >{{$units->description}}</option>
                          @endforeach
                      </select>
                      @error('level_upt')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <div class="form-group mb-3">
                      <label for="level_ultg">ULTG <span class="text-danger">*</span> </label>
                      <select name="level_ultg" class="form-control @error('level_ultg') is-invalid @enderror" id="level_ultg">
                          <option value="">-- Pilih ULTG --</option>
                      </select>
                      @error('level_ultg')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <div class="form-group mb-3">
                      <label for="level_substation">Gardu Induk <span class="text-danger">*</span> </label>
                      <select name="level_substation" class="form-control @error('level_substation') is-invalid @enderror js-example-basic-single" id="level_substation">
                          <option value="">-- Pilih Gardu Induk --</option>
                      </select>
                      @error('level_substation')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <div class="mb-3">
                      <div class="form-label">File PQM</div>
                      <input type="file" name="file_pqm" class="form-control" />
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Import Data</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        {{-- end modal --}}
      @endcan    
@endsection

@push('addon-style')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('addon-script')
    {{-- light dark --}}
    <script src="{{ asset('dist/js/demo-theme.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('/dist/libs/tom-select/dist/js/tom-select.base.min.js') }}" defer></script>
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
                url: '{!! url()->current() !!}'
            },
            columns : [
                { data: 'DT_RowIndex', 'orderable': false, 'searchable': false, width: '5%' },
                {data: 'upt', name: 'upt'},
                {data: 'ultg', name: 'ultg'},
                {data: 'gi', name: 'gi'},
                {data: 'datetime', name: 'datetime'},
                {data: 'dist_dur', name: 'dist_dur'},
                {data: 'presentase_r', name: 'presentase_r'},
                {data: 'presentase_s', name: 'presentase_s'},
                {data: 'presentase_t', name: 'presentase_t'},
                @can('transaksi_pqm_ktt-edit')
                {
                    data: 'edit', 
                    name: 'edit',
                    orderable: false,
                    searchable: false,
                    width: '1%'
                },
                @endcan
                @can('transaksi_pqm_ktt-delete')
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
                @can('transaksi_pqm_ktt-import')
                    {
                        text: 'Import Data PQM KTT',
                        className: 'btn btn-primary btn-sm btn-fw mb-4 mr-2 p-1',
                        action: function ( e, dt, button, config ) {
                            // window.location = '{{ route('fungsi.create') }}';
                            $('#modal-team').modal('show')
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
    </script>

    <script>
      $(document).ready(function(){
          $('.js-example-basic-single').select2({
              // theme: "bootstrap-5",
              // minimumInputLength: 2,
              containerCssClass: "select2--small", // For Select2 v4.0
              selectionCssClass: "select2--small", // For Select2 v4.1
              dropdownCssClass: "select2--small",
            
          });
      });
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

                        
                        $('select[name="level_ultg"]').empty();
                        $('select[name="level_ultg"]').append('<option value="">-- Pilih ULTG --</option>');
                        $.each(data, function(key, value) {
                            $('select[name="level_ultg"]').append('<option value="'+ value.id +'">'+ value.description +'</option>');
                        });


                    }
                });
            }else{
                $('select[name="unit_id"]').empty();
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
                        // $('select[name="level_substation"]').empty();
                        // $('select[name="level_substation"]').append('<option value="">-- Pilih Gardu Induk --</option>');
                        // $.each(data, function(key, value) {
                        //     $('select[name="level_substation"]').append('<option value="'+ value.id +'">'+ value.description +'</option>');
                        // });


                    }
                });
            }else{
                $('select[name="unit_id"]').empty();
            }
        });
        
      });
    </script>
@endpush
