@extends('layouts.app')

@section('content')
     <!-- Page header -->
     <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2 align-items-center">
            <div class="col">
              <h2 class="page-title">
                Users
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
                  <h3 class="card-title">Ubah User </h3>
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
                        <form action="{{ route('users.update', $item->user_id)}}" method="POST" enctype="multipart/form-data">
                          @method('PUT')
                          @csrf
                            <div class="form-group mb-3">
                                <label for="exampleInputName1">Name</label>
                                <input type="text" class="form-control" name="name" value="{{$item->name}}" id="exampleInputName1" placeholder="Enter Role Name">
                            </div>
                            <div class="form-group mb-3">
                              <label for="exampleInputName1">Email</label>
                              <input type="text" class="form-control" name="email" value="{{$item->email}}" id="exampleInputName1" placeholder="Enter Role Email">
                            </div>
                            <div class="form-group mb-3">
                              <label for="role_id">Role <span class="text-danger">*</span> @foreach ( Auth::user()->getRoleNames() as $roleUser)
                               Role saat ini <strong>{{ Str::title($roleUser) }}</strong>
                              @endforeach <span class="text-warning">apabila tidak ada perubahan role abaikan saja</span></label>
                              <select name="role_id" class="form-control @error('role_id') is-invalid @enderror" id="role_id">
                                  <option value="">-- Pilih Role --</option>
                                  @foreach ( $role as $roles )
                                      <option value="{{$roles->id}}" {{$item->id == $roles->id ? 'selected' : ''}}>{{$roles->name}}</option>
                                  @endforeach
                              </select>
                              @error('role_id')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>
                            <div class="form-group mb-3">
                              <label for="level_upt">Unit <span class="text-danger">*</span> </label>
                              <select name="level_upt" class="form-control @error('level_upt') is-invalid @enderror" id="level_upt" required>
                                  <option value="">-- Pilih Unit --</option>
                                  @foreach ( $unit as $units )
                                      <option value="{{$units->id}}" {{$item->level_upt == $units->id ? 'selected' : ''}}>{{$units->description}}</option>
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
                                  @if ($item->level_ultg != null)
                                    @foreach ( $ultg as $ultgs )
                                        <option value="{{$ultgs->id}}" {{$item->level_ultg == $ultgs->id ? 'selected' : ''}}>{{$ultgs->description}}</option>
                                    @endforeach
                                  @endif
                              </select>
                              @error('level_ultg')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>
                            <div class="form-group mb-3">
                              <label for="level_substation">Gardu Induk <span class="text-danger">*</span> </label>
                              <select name="level_substation[]" class="form-control @error('level_substation') is-invalid @enderror js-example-basic-single" id="level_substation" multiple>
                                  <option value="">-- Pilih Gardu Induk --</option>
                                  @if ($item->level_substation != null)
                                    @foreach ( $gardu_induk as $gi )
                                        <option value="{{$gi->id}}" >{{$gi->description}}</option>
                                    @endforeach
                                  @endif
                              </select>
                              @error('level_substation')
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('addon-script')
    {{-- light dark --}}
    <script src="{{ asset('dist/js/demo-theme.min.js') }}"></script>
    <script src="{{ asset('dist/js/jquery-3.5.1.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('/dist/libs/tom-select/dist/js/tom-select.base.min.js') }}" defer></script>
    <script>
        $("#user_id").select2({
            theme: "bootstrap-5",
            containerCssClass: "select2--small", // For Select2 v4.0
            selectionCssClass: "select2--small", // For Select2 v4.1
            dropdownCssClass: "select2--small",
        });
        $("#role_id").select2({
            theme: "bootstrap-5",
            containerCssClass: "select2--small", // For Select2 v4.0
            selectionCssClass: "select2--small", // For Select2 v4.1
            dropdownCssClass: "select2--small",
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
