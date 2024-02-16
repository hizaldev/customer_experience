@extends('layouts.app')

@section('content')
     <!-- Page header -->
     <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2 align-items-center">
            <div class="col">
              <h2 class="page-title">
                Master Kategori Penyebab Gangguan
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
                  <h3 class="card-title">Kategori Penyebab Gangguan</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-vcenter card-table table-striped">
                          <thead>
                            <tr>
                              <th class="w-1"></th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="Tipe Gangguan" data-column="1">
                              </th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="Keterangan" data-column="2">
                              </th>
                              @can('master_kategori_penyebab_gangguan-edit')
                                  <th ></th>
                              @endcan
                              @can('master_kategori_penyebab_gangguan-delete')
                                  <th></th>
                              @endcan
                            </tr>
                            <tr>
                              <th class="w-1">No.</th>
                              <th>Kategori Penyebab Gangguan</th>
                              <th>Keterangan</th>
                              @can('master_kategori_penyebab_gangguan-edit')
                                  <th ></th>
                              @endcan
                              @can('master_kategori_penyebab_gangguan-delete')
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
                {data: 'kategori_penyebab', name: 'kategori_penyebab'},
                {data: 'keterangan', name: 'keterangan'},
                @can('master_kategori_penyebab_gangguan-edit')
                {
                    data: 'edit', 
                    name: 'edit',
                    orderable: false,
                    searchable: false,
                    width: '1%'
                },
                @endcan
                @can('master_kategori_penyebab_gangguan-delete')
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
                @can('master_kategori_penyebab_gangguan-create')
                    {
                        text: 'Tambah',
                        className: 'btn btn-primary btn-sm btn-fw mb-4 mr-2 p-1',
                        action: function ( e, dt, button, config ) {
                            window.location = '{{ route('kategoriGangguan.create') }}';
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
