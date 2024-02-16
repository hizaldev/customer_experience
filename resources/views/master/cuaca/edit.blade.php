@extends('layouts.app')

@section('content')
     <!-- Page header -->
     <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2 align-items-center">
            <div class="col">
              <h2 class="page-title">
                Setup Cuaca BMKG
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
                  <h3 class="card-title">Edit Setup Cuaca dan Potensi BMKG  </h3>
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
                        <form action="{{ route('cuaca.update', $item->id)}}" method="POST" enctype="multipart/form-data">
                          @method('PUT')
                          @csrf
                          <div class="form-group mb-3">
                            <label for="id">ID BMKG</label>
                            <input type="text" class="form-control @error('id') is-invalid @enderror" value="{{$item->id}}" name="id" id="id" placeholder="Masukan ID Cuaca BMKG">
                            @error('id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          <div class="form-group mb-3">
                            <label for="cuaca">Cuaca</label>
                            <input type="text" class="form-control @error('cuaca') is-invalid @enderror" value="{{$item->cuaca}}" name="cuaca" id="cuaca" placeholder="Masukan Cuaca BMKG">
                            @error('cuaca')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          <div class="form-group mb-3">
                            <label for="image">Url Image Cuaca</label>
                            <input type="text" class="form-control @error('image') is-invalid @enderror" value="{{$item->image}}" name="image" id="image" placeholder="Masukan Url Image">
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          <div class="form-group mb-3">
                            <label class="form-label">Potensi Cuaca 
                            <textarea class="form-control" name="potensi_cuaca" rows="6" placeholder="Potensi Cuaca">{{$item->potensi_cuaca}}</textarea>
                            @error('potensi_cuaca')
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
