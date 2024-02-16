@extends('layouts.app')

@section('content')
     <!-- Page header -->
     <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2 align-items-center">
            <div class="col">
              <h2 class="page-title">
                master Status
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
                  <h3 class="card-title">Edit Status </h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('island.update', $item->id)}}" method="POST" enctype="multipart/form-data">
                          @method('PUT')
                          @csrf
                          <div class="row">
                            <div class="col-md-4">
                              
                              <div class="form-group mb-3">
                                <label for="subsystem">Subsystem Penyaluran</label>
                                <input type="text" class="form-control @error('subsystem') is-invalid @enderror" name="subsystem" value="{{$item->subsystem}}" id="subsystem" placeholder="Masukan Subsystem Penyaluran">
                                @error('subsystem')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                              </div>
                              <div class="form-group mb-3">
                                <label class="form-label">Keterangan 
                                <textarea class="form-control" name="keterangan" rows="6" placeholder="Keterangan">{{$item->keterangan}}</textarea>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                              </div>
                            </div>
                            <div class="col-md-8">
                              <div class="form-group mb-3">
                                <label >Gardu Induk</label>
                                <div class="col-sm-12 mb-3">
                                    <select class="form-control form-select fom-select-sm js-example-basic-single w-full" multiple name="substation_id[]" id="select2_member" required>
                                      @foreach ( $subsystemDetail as $detail )
                                          <option value="{{$detail->substation_id}}" selected>{{$detail->substation}}</option>
                                      @endforeach
                                    </select>
                                </div>
                            </div>
                            </div>
                          </div>
                          <button type="submit" class="btn btn-primary mr-2 mt-2">Submit</button>
                          <a href="#" class="btn btn-secondary mt-2" role="button" aria-pressed="true" value="Go Back" onclick="history.back(-1)">Cancel</a>
                      </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>    
@endsection

@push('addon-style')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('addon-script')
    {{-- light dark --}}
    <script src="{{ asset('dist/js/demo-theme.min.js') }}"></script>
    <script src="{{ asset('dist/js/jquery-3.5.1.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.js-example-basic-single').select2({
                // theme: "bootstrap-5",
                placeholder: 'Cari GI/GITET',
                minimumInputLength: 2,
                containerCssClass: "select2--small", // For Select2 v4.0
                selectionCssClass: "select2--small", // For Select2 v4.1
                dropdownCssClass: "select2--small",
                ajax: {
                  url: "{{ route('island.getLocations') }}",
                  dataType: 'json',
                  delay: 250,
                  processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.description,
                                id: item.id
                            }
                        })
                    };
                  },
                  cache: true
                }
            });
        });
    </script>
@endpush