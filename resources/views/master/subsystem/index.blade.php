@extends('layouts.app')

@section('content')
     <!-- Page header -->
     <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2 align-items-center">
            <div class="col">
              <h2 class="page-title">
                Master Subsystem Penyaluran
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
                  <h3 class="card-title">Subsystem Penyaluran</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-vcenter card-table table-striped">
                          <thead>
                            <tr>
                              <th class="w-1"></th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="Subsystem" data-column="1">
                              </th>
                              <th>
                                <input type="text" class="form-control filter-input" placeholder="Keterangan" data-column="2">
                              </th>
                              <th>
                                
                              </th>
                              @can('master_subsystem-show')
                                  <th ></th>
                              @endcan
                              @can('master_subsystem-edit')
                                  <th ></th>
                              @endcan
                              @can('master_subsystem-delete')
                                  <th></th>
                              @endcan
                            </tr>
                            <tr>
                              <th class="w-1">No.</th>
                              <th>Subsystem</th>
                              <th>Keterangan</th>
                              <th>GI dalam Subsystem</th>
                              @can('master_subsystem-show')
                                  <th ></th>
                              @endcan
                              @can('master_subsystem-edit')
                                  <th ></th>
                              @endcan
                              @can('master_subsystem-delete')
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
      @can('master_subsystem-show')
        {{-- start modal --}}
          <div class="modal modal-blur fade" id="modal-team" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Detail Data Subsistem</h5>
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
      @endcan    
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
                {data: 'subsystem', name: 'subsystem'},
                {data: 'keterangan', name: 'keterangan'},
                {data: 'count_substation', name: 'count_substation'},
                @can('master_subsystem-show')
                {
                    data: 'show', 
                    name: 'show',
                    orderable: false,
                    searchable: false,
                    width: '1%'
                },
                @endcan
                @can('master_subsystem-edit')
                {
                    data: 'edit', 
                    name: 'edit',
                    orderable: false,
                    searchable: false,
                    width: '1%'
                },
                @endcan
                @can('master_subsystem-delete')
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
                @can('master_subsystem-create')
                    {
                        text: 'Tambah',
                        className: 'btn btn-primary btn-sm btn-fw mb-4 mr-2 p-1',
                        action: function ( e, dt, button, config ) {
                            window.location = '{{ route('island.create') }}';
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
    <script type="text/javascript"> 
      function showDetail(txt,value){
        console.log(value);
        $value = value;
         $.ajax({
          type:"POST",
          url:"{{route('island.showDataSubstation')}}",
          data :  {
            "_token": "{{ csrf_token() }}",
            "subsystem": value
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
@endpush
