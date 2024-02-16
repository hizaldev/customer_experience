@extends('layouts.app')

@section('content')
     <!-- Page header -->
     <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2 align-items-center">
            <div class="col">
              <h2 class="page-title">
                Lokasi Unit
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
                  <h3 class="card-title">Unit Induk</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-vcenter card-table table-striped">
                          <thead>
                            <tr>
                              <th class="w-1"></th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="Functloc" data-column="1">
                              </th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="Sup Functloc" data-column="2">
                              </th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="Nama Lokasi" data-column="3">
                              </th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="Description" data-column="4">
                              </th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="Level" data-column="5">
                              </th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="Status" data-column="6">
                              </th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="Tegangan" data-column="7">
                              </th>
                              @can('lokasi_induk-edit')
                                  <th ></th>
                              @endcan
                              @can('lokasi_induk-delete')
                                  <th></th>
                              @endcan
                            </tr>
                            <tr>
                              <th class="w-1">No.</th>
                              <th>Functloc</th>
                              <th>Sup Functloc</th>
                              <th>Nama Lokasi</th>
                              <th>Deskripsi</th>
                              <th>Level</th>
                              <th>Status</th>
                              <th>Tegangan</th>
                              @can('lokasi_induk-edit')
                                  <th ></th>
                              @endcan
                              @can('lokasi_induk-delete')
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
                url: '{!! url()->current() !!}'
            },
            columns : [
                { data: 'DT_RowIndex', 'orderable': false, 'searchable': false, width: '5%' },
                {data: 'id_functloc', name: 'id_functloc'},
                {data: 'sup_functloc', name: 'sup_functloc'},
                {data: 'nm_lokasi', name: 'nm_lokasi'},
                {data: 'description', name: 'description'},
                {data: 'nlevel', name: 'nlevel'},
                {data: 'status.status', name: 'status.status'},
                {data: 'tegangan.tegangan', name: 'tegangan.tegangan'},
                @can('lokasi_induk-edit')
                {
                    data: 'edit', 
                    name: 'edit',
                    orderable: false,
                    searchable: false,
                    width: '1%'
                },
                @endcan
                @can('lokasi_induk-delete')
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
                @can('lokasi_induk-create')
                    {
                        text: 'Tambah',
                        className: 'btn btn-primary btn-sm btn-fw mb-4 mr-2 p-1',
                        action: function ( e, dt, button, config ) {
                            window.location = '{{ route('induks.create') }}';
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
@endpush
