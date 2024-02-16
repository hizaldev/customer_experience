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
                        <form action="{{ route('konsumen.update', $item->id)}}" method="POST" enctype="multipart/form-data">
                          @method('PUT')
                          @csrf
                          <div class="form-group mb-3">
                              <label for="nama_ktt">Nama Konsumen KTT</label>
                              <input type="text" class="form-control @error('nama_ktt') is-invalid @enderror" name="nama_ktt" id="nama_ktt" value="{{ $item->nama_ktt}}" placeholder="Masukan Nama Konsumen KTT">
                              @error('nama_ktt')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                          <div class="form-group mb-3">
                            <label class="form-label">Alamat 
                            <textarea class="form-control" name="alamat" rows="6" placeholder="Alamat">{{ $item->alamat}}</textarea>
                            @error('alamat')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          <div class="form-group mb-3">
                            <label for="location_id">Gardu Induk</label></label>
                            <select name="location_id" class="form-control @error('location_id') is-invalid @enderror" id="location_id">
                                <option value="">-- Pilih Gardu Induk --</option>
                                @foreach ( $location as $lokasi )
                                    <option value="{{$lokasi->id}}" {{$item->location_id == $lokasi->id ? 'selected' : ''}}>{{$lokasi->nm_lokasi}}</option>
                                @endforeach
                            </select>
                            @error('location_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          <div class="form-group mb-3">
                            <label class="control-label">Bay</label>
                            <div id="id_location_bay">
                              <div class='row'>
                                <?php foreach($bay as $bays) : ?>
                                    <div class='col-12 col-lg-6'>
                                        <div class='form-check'>
                                            <div class='checkbox'>
                                                <input type='checkbox' id='{{$bays->id}}' class='form-check-input' value='{{$bays->id }}' name="id_location_bay[]">
                                                <label for='{{$bays->id}}'>{{$bays->nm_lokasi }}</label>
                                            </div>
                                          </div>
                                    </div>
                                <?php endforeach ?>
                             </div>
                            </div>
                           
                          </div>
                          <div class="form-group mb-3">
                            <label for="area_id">Area BMKG ID</label></label>
                            <select name="area_id" class="form-control @error('area_id') is-invalid @enderror" id="area_id">
                                <option value="">-- Pilih Area BMKG --</option>
                                @foreach ( $bmkg as $bm )
                                  <option value="{{$bm->attributes()->id}}" {{$item->area_id == $bm->attributes()->id ? 'selected' : ''}}>{{$bm->name[1]}}</option>
                              @endforeach
                            </select>
                            @error('area_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <span class="text-success"> *Data bersumber dari data area <a href="https://data.bmkg.go.id/">BMKG</a></span>
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

@endpush

@push('addon-script')
    {{-- light dark --}}
    <script src="{{ asset('dist/js/demo-theme.min.js') }}"></script>
    <script src="{{ asset('dist/js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('/dist/libs/tom-select/dist/js/tom-select.base.min.js') }}" defer></script>
    <script>
      // @formatter:off
      document.addEventListener("DOMContentLoaded", function () {
        var el;
        window.TomSelect && (new TomSelect(el = document.getElementById('location_id'), {
          copyClassesToDropdown: false,
          dropdownParent: 'body',
          controlInput: '<input>',
          render:{
            item: function(data,escape) {
              if( data.customProperties ){
                return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
              }
              return '<div>' + escape(data.text) + '</div>';
            },
            option: function(data,escape){
              if( data.customProperties ){
                return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
              }
              return '<div>' + escape(data.text) + '</div>';
            },
          },
        }));
      });
      // @formatter:on
    </script>
   <script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function () {
      var el;
      window.TomSelect && (new TomSelect(el = document.getElementById('area_id'), {
        copyClassesToDropdown: false,
        dropdownParent: 'body',
        controlInput: '<input>',
        render:{
          item: function(data,escape) {
            if( data.customProperties ){
              return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
            }
            return '<div>' + escape(data.text) + '</div>';
          },
          option: function(data,escape){
            if( data.customProperties ){
              return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
            }
            return '<div>' + escape(data.text) + '</div>';
          },
        },
      }));
    });
    // @formatter:on
  </script>
@endpush
