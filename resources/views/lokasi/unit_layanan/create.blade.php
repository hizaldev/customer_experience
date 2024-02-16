@extends('layouts.app')

@section('content')
     <!-- Page header -->
     <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2 align-items-center">
            <div class="col">
              <h2 class="page-title">
                Lokasi 
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
                  <h3 class="card-title">Tambah Unit Layanan (Level 3)</h3>
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
                        <form action="{{ route('unitLayanan.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="id_functloc">ID Functloc</label>
                                <input type="text" class="form-control @error('id_functloc') is-invalid @enderror" name="id_functloc" id="id_functloc" placeholder="Masukan ID Functloc">
                                @error('id_functloc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                              <label for="sup_functloc">Sup Functloc</label>
                              <input type="text" class="form-control @error('sup_functloc') is-invalid @enderror" name="sup_functloc" id="sup_functloc" placeholder="Masukan Sup Functloc">
                              @error('sup_functloc')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                            <div class="form-group mb-3">
                              <label for="nm_lokasi">Nama Lokasi</label>
                              <input type="text" class="form-control @error('nm_lokasi') is-invalid @enderror" name="nm_lokasi" id="nm_lokasi" placeholder="Masukan Lokasi Unit">
                              @error('nm_lokasi')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>
                            <div class="form-group mb-3">
                              <label for="description">Nama Lengkap Lokasi</label>
                              <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" placeholder="Masukan Lengkap Lokasi Unit">
                              @error('description')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>
                            <div class="form-group mb-3">
                              <label for="fungsi_id">Fungsi</label>
                              <select name="fungsi_id" class="form-control @error('fungsi_id') is-invalid @enderror" id="fungsi_id">
                                  <option value="">-- Pilih Fungsi --</option>
                                  @foreach ( $fungsi as $fungsi )
                                      <option value="{{$fungsi->id}}" {{old('status_id') == $fungsi->id ? 'selected' : ''}}>{{$fungsi->kd_fungsi}} - {{$fungsi->fungsi}}</option>
                                  @endforeach
                              </select>
                              @error('fungsi_id')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>
                            <div class="form-group mb-3">
                              <label for="tegangan_id">Tegangan</label>
                              <select name="tegangan_id" class="form-control @error('tegangan_id') is-invalid @enderror" id="tegangan_id">
                                  <option value="">-- Pilih Tegangan --</option>
                                  @foreach ( $tegangan as $teg )
                                      <option value="{{$teg->id}}" {{old('tegangan_id') == $teg->id ? 'selected' : ''}}>{{$teg->tegangan_id}} - {{$teg->tegangan}}</option>
                                  @endforeach
                              </select>
                              @error('tegangan_id')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>
                            <div class="form-group mb-3">
                              <label for="status_id">Status</label>
                              <select name="status_id" class="form-control @error('status_id') is-invalid @enderror" id="status_id">
                                  <option value="">-- Pilih Status --</option>
                                  @foreach ( $status as $stat )
                                      <option value="{{$stat->id}}" {{old('status_id') == $stat->id ? 'selected' : ''}}>{{$stat->id_status}} - {{$stat->status}}</option>
                                  @endforeach
                              </select>
                              @error('status_id')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
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
        window.TomSelect && (new TomSelect(el = document.getElementById('status_id'), {
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
        window.TomSelect && (new TomSelect(el = document.getElementById('fungsi_id'), {
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
        window.TomSelect && (new TomSelect(el = document.getElementById('tegangan_id'), {
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
