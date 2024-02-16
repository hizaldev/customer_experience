@extends('layouts.app')

@section('content')
     <!-- Page header -->
     <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2 align-items-center">
            <div class="col">
              <h2 class="page-title">
                Tegangan
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
                  <h3 class="card-title">Edit Tegangan </h3>
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
                        <form action="{{ route('tegangan.update', $item->id)}}" method="POST" enctype="multipart/form-data">
                          @method('PUT')
                          @csrf
                          <div class="form-group mb-3">
                            <label for="tegangan_id">Kode Tegangan Legacy</label>
                            <input type="text" class="form-control @error('tegangan_id') is-invalid @enderror" value="{{$item->tegangan_id}}" name="tegangan_id" id="tegangan_id" placeholder="Masukan Kode Tegangan">
                            @error('tegangan_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                          <label for="tegangan">Tegangan</label>
                          <input type="text" class="form-control @error('tegangan') is-invalid @enderror" value="{{$item->tegangan}}" name="tegangan" id="tegangan" placeholder="Masukan Tegangan">
                          @error('tegangan')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                        <div class="form-group mb-3">
                          <label class="form-label">Keterangan 
                          <textarea class="form-control" name="keterangan" rows="6" placeholder="Keterangan">{{$item->keterangan}}</textarea>
                          @error('keterangan')
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
@endpush
