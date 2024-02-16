@extends('layouts.app')

@section('content')
     <!-- Page header -->
     <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2 align-items-center">
            <div class="col">
              <h2 class="page-title">
                Role
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
                  <h3 class="card-title">Buat Role </h3>
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
                        <form action="{{ route('roles.update', $role->id)}}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-group mb-3">
                                <label for="exampleInputName1">Name</label>
                                <input type="text" class="form-control" name="name" value="{{$role->name}}" id="exampleInputName1" placeholder="Enter Role Name">
                            </div>
                            <div class="row">
                                <div class="accordion" id="accordionPanelsStayOpenExample">
                                @php
                                    $before = 'first';
                                @endphp
                                @foreach ( $permissions as $permision )
                                        @php
                                            $data = explode('-', $permision->name);
                                      
                                        @endphp
                                        @if ( $before != $data[0])
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne{{ $permision->id }}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne{{ $permision->id }}">
                                                    {{ $data[0] }}
                                                </button>
                                                </h2>
                                                <div id="panelsStayOpen-collapseOne{{ $permision->id }}" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        @foreach ( $permissions as $permit )
                                                            @php
                                                                $filter = explode('-', $permit->name)
                                                            @endphp
                                                            @if ($data[0] == $filter[0])
                                                                <div class="col-3">
                                                                    <div class="form-check mb-3">
                                                                        <input class="form-check-input" type="checkbox" id="flexCheckChecked{{ $permit->id}}" name="permission[]" value="{{ $permit->id}}" {{ in_array($permit->id, $rolePermissions) ? 'checked' : ''}}>
                                                                        <label class="form-check-label" for="flexCheckChecked{{ $permit->id}}">
                                                                           {{ $permit->name }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                        
                                                            @endif
                                                                
                                                        @endforeach
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            
                                        @endif
                                        @php
                                            $before = $data[0];
                                        @endphp
                                @endforeach
                                </div>

                            </div>
         
                            <button type="submit" class="btn btn-primary mr-2 mt-2">Submit</button>
                            <a href="#" class="btn btn-dark mt-2" role="button" aria-pressed="true" value="Go Back" onclick="history.back(-1)">Cancel</a>
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
