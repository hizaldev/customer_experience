@extends('layouts.app')

@section('content')
     <!-- Page header -->
     <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2 align-items-center">
            <div class="col">
              <h2 class="page-title">
                Data Gangguan
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
                  <h3 class="card-title">Edit Data Gangguan </h3>
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
                  <form action="{{ route('gangguan.update', $item->id)}}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group mb-3">
                      <label for="level_upt">Unit <span class="text-danger">*</span> </label>
                      <select name="upt_id" class="form-control @error('level_upt') is-invalid @enderror" id="level_upt" required>
                          @canany([
                            'transaksi_gangguan-list',
                            'transaksi_gangguan-list-induk',
                          ])
                            <option value="">-- Pilih Unit --</option>
                          @endcan
                          @foreach ( $unit as $units )
                              <option value="{{$units->id}}" {{$item->upt_id == $units->id ? 'selected' : ''}}>{{$units->description}}</option>
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
                      <select name="ultg_id" class="form-control @error('level_ultg') is-invalid @enderror" id="level_ultg">
                          @canany([
                            'transaksi_gangguan-list',
                            'transaksi_gangguan-list-induk',
                            'transaksi_gangguan-list-unit',
                          ])
                            <option value="">-- Pilih ULTG --</option>
                          @endcan
                          @foreach ( $ultg as $ultg )
                              <option value="{{$ultg->id}}" {{$item->ultg_id == $ultg->id ? 'selected' : ''}}>{{$ultg->description}}</option>
                          @endforeach
                      </select>
                      @error('level_ultg')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <div class="form-group mb-3">
                      <label for="level_substation">Gardu Induk <span class="text-danger">*</span> </label>
                      <select name="substation_id" class="form-control @error('level_substation') is-invalid @enderror js-example-basic-single" id="level_substation">
                          <option value="">-- Pilih Gardu Induk --</option>
                          @foreach ( $substation as $gi )
                              <option value="{{$gi->id}}" {{$item->substation_id == $gi->id ? 'selected' : ''}}>{{$gi->description}}</option>
                          @endforeach
                      </select>
                      @error('level_substation')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <div class="form-group mb-3">
                      <label for="level_bay">Bay <span class="text-danger">*</span> </label>
                      <select name="bay_id" class="form-control @error('level_bay') is-invalid @enderror js-example-basic-single" id="level_bay">
                          <option value="">-- Pilih Bays --</option>
                          @foreach ( $bay as $bays )
                              <option value="{{$bays->id}}" {{$item->bay_id == $bays->id ? 'selected' : ''}}>{{$bays->description}}</option>
                          @endforeach
                      </select>
                      @error('level_bay')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <div class="form-group mb-3">
                      <label for="description">Deskripsi Gangguan</label>
                      <input type="text" class="form-control @error('description') is-invalid @enderror" value="{{$item->description}}" name="description" id="description" placeholder="Masukan Deskripsi Gangguan">
                      @error('description')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <div class="form-group mb-3">
                      <label for="tgl_gangguan">Tanggal Jam Gangguan</label>
                      <input type="datetime-local" class="form-control @error('tgl_gangguan') is-invalid @enderror" value="{{$item->tgl_gangguan}}" name="tgl_gangguan" id="tgl_gangguan">
                      @error('tgl_gangguan')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Jenis Gangguan</label>
                      <div class="form-selectgroup">
                        @foreach ( $jenisGangguan as $jenis )
                          <label class="form-selectgroup-item">
                            <input type="radio" name="jenis_gangguan_id" value="{{$jenis->id}}" class="form-selectgroup-input" {{$jenis->id == $item->jenis_gangguan_id ? 'checked' : ''}}>
                            <span class="form-selectgroup-label">{{$jenis->jenis_gangguan}}</span>
                          </label>
                        @endforeach
                      </div>
                      @error('jenis_gangguan_id')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <div class="form-group mb-3">
                      <label for="tipe_gangguan_id">Tipe Gangguan <span class="text-danger">*</span> </label>
                      <select name="tipe_gangguan_id" class="form-control @error('tipe_gangguan_id') is-invalid @enderror" id="tipe_gangguan_id" required>
                          <option value="">-- Pilih Tipe Gangguan --</option>
                          @foreach ( $tipeGangguan as $tipe )
                              <option value="{{$tipe->id}}" {{$item->tipe_gangguan_id == $tipe->id ? 'selected' : ''}}>{{$tipe->tipe_gangguan}}</option>
                          @endforeach
                      </select>
                      @error('tipe_gangguan_id')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <div class="collapse" id="collapseMainGangguan">
                      <div class="mb-3">
                        <label class="form-label">Apakah Gangguan ini merupakan Main Gangguan?</label>
                        <div>
                          <label class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_main_gangguan" {{$item->is_main_gangguan == 'Ya' ? 'checked' : ''}}>
                            <span class="form-check-label">Ya, ini main gangguan</span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group mb-3">
                      <label for="subsystem_id">Subsystem Gardu Induk <span class="text-danger">*</span> </label>
                      <select name="subsystem_id" class="form-control @error('subsystem_id') is-invalid @enderror" id="subsystem_id" required>
                          <option value="">-- Pilih Subsystem --</option>
                          @foreach ( $subsystem as $system )
                              <option value="{{$system->id}}" {{$item->subsystem_id == $system->id ? 'selected' : ''}}>{{$system->subsystem}}</option>
                          @endforeach
                      </select>
                      @error('subsystem_id')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <div class="form-group mb-3">
                      <label for="cuaca">Cuaca</label>
                      <input type="text" class="form-control @error('cuaca') is-invalid @enderror" name="cuaca" value="{{$item->kondisi_lingkungan}}" id="cuaca" placeholder="Masukan Cuaca">
                      @error('cuaca')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <div class="form-group mb-3">
                      <label class="form-label">Announciator 
                      <textarea class="form-control" name="anounciator" rows="6" placeholder="Announciator">{{$item->anounciator}}</textarea>
                      @error('anounciator')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <div class="form-group mb-3">
                      <label class="form-label">Indikasi Relay 
                      <textarea class="form-control" name="indikasi_relay" rows="6" placeholder="Indikasi Relay">{{$item->indikasi_relay}}</textarea>
                      @error('indikasi_relay')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="mb-3">
                          <label class="form-label">Arus Gangguan R</label>
                          <div class="input-group mb-2">
                            <input type="number" step="any" class="form-control  @error('arus_gangguan') is-invalid @enderror" value="{{$item->arus_gangguan}}" name="arus_gangguan"  placeholder="000.00">
                            <span class="input-group-text">
                              A
                            </span>
                          </div>
                          @error('arus_gangguan')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="mb-3">
                          <label class="form-label">Arus Gangguan S</label>
                          <div class="input-group mb-2">
                            <input type="number" step="any" class="form-control  @error('arus_gangguan_s') is-invalid @enderror" value="{{$item->arus_gangguan_s}}" name="arus_gangguan_s"  placeholder="000.00">
                            <span class="input-group-text">
                              A
                            </span>
                          </div>
                          @error('arus_gangguan_s')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-3">
                          <div class="mb-3">
                            <label class="form-label">Arus Gangguan T</label>
                            <div class="input-group mb-2">
                              <input type="number" step="any" class="form-control  @error('arus_gangguan_t') is-invalid @enderror" value="{{$item->arus_gangguan_t}}" name="arus_gangguan_t"  placeholder="000.00">
                              <span class="input-group-text">
                                A
                              </span>
                            </div>
                            @error('arus_gangguan_t')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                      </div>
                      <div class="col-md-3">
                        <div class="mb-3">
                          <label class="form-label">Arus Gangguan N</label>
                          <div class="input-group mb-2">
                            <input type="number" step="any" class="form-control  @error('arus_gangguan_n') is-invalid @enderror" value="{{$item->arus_gangguan_n}}" name="arus_gangguan_n"  placeholder="000.00">
                            <span class="input-group-text">
                              A
                            </span>
                          </div>
                          @error('arus_gangguan_n')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                    </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group mb-3">
                          <label for="count_cb_r">Counter PMT R</label>
                          <input type="text" class="form-control @error('count_cb_r') is-invalid @enderror" value="{{$item->count_cb_r}}" name="count_cb_r" id="count_cb_r" placeholder="">
                          @error('count_cb_r')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group mb-3">
                          <label for="count_cb_s">Counter PMT S</label>
                          <input type="text" class="form-control @error('count_cb_s') is-invalid @enderror" value="{{$item->count_cb_s}}" name="count_cb_s" id="count_cb_s" placeholder="">
                          @error('count_cb_s')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group mb-3">
                          <label for="count_cb_t">Counter PMT T</label>
                          <input type="text" class="form-control @error('count_cb_t') is-invalid @enderror" value="{{$item->count_cb_t}}" name="count_cb_t" id="count_cb_t" placeholder="">
                          @error('count_cb_t')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                      
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group mb-3">
                          <label for="count_la_r">Counter LA R</label>
                          <input type="text" class="form-control @error('count_la_r') is-invalid @enderror" value="{{$item->count_la_r}}" name="count_la_r" id="count_la_r" placeholder="">
                          @error('count_la_r')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group mb-3">
                          <label for="count_la_s">Counter LA S</label>
                          <input type="text" class="form-control @error('count_la_s') is-invalid @enderror" value="{{$item->count_la_s}}" name="count_la_s" id="cuaca" placeholder="">
                          @error('count_la_s')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group mb-3">
                          <label for="count_la_t">Counter LA T</label>
                          <input type="text" class="form-control @error('cuaca') is-invalid @enderror" value="{{$item->count_la_t}}" name="count_la_t" id="count_la_t" placeholder="">
                          @error('count_la_t')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                      
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label">MW Sebelum Gangguan</label>
                          <div class="input-group mb-2">
                            <input type="number" step="any" class="form-control  @error('beban_sebelum_mw') is-invalid @enderror" value="{{$item->beban_sebelum_mw}}" name="beban_sebelum_mw"  placeholder="000.00">
                            <span class="input-group-text">
                              MW
                            </span>
                          </div>
                          @error('beban_sebelum_mw')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label">MVar Sebelum Gangguan</label>
                          <div class="input-group mb-2">
                            <input type="number" step="any" class="form-control @error('beban_sebelum_mvar') is-invalid @enderror" value="{{$item->beban_sebelum_mvar}}"  name="beban_sebelum_mvar"  placeholder="000.00">
                            <span class="input-group-text">
                              MVar
                            </span>
                          </div>
                          @error('beban_sebelum_mvar')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                    </div>
                    <div class="form-group mb-3">
                      <label class="form-label">Penyebab Gangguan 
                      <textarea class="form-control" name="penyebab_gangguan" rows="6" placeholder="Penyebab Gangguan">{{$item->penyebab_gangguan}}</textarea>
                      @error('penyebab_gangguan')
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('/dist/libs/tom-select/dist/js/tom-select.base.min.js') }}" defer></script>
    <script src="{{ asset('dist/js/jquery-3.5.1.js') }}"></script>
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

                        
                        $('select[name="ultg_id"]').empty();
                        $('select[name="ultg_id"]').append('<option value="">-- Pilih ULTG --</option>');
                        $.each(data, function(key, value) {
                            $('select[name="ultg_id"]').append('<option value="'+ value.id +'">'+ value.description +'</option>');
                        });


                    }
                });
            }else{
                $('select[name="ultg_id"]').empty();
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
                $('select[name="level_substation"]').empty();
            }
        });

        $('#level_substation').on('change', function() {
            var idGi = $(this).val();
            if(idGi) {
                console.log('ada perubahan neh');
                $.ajax({
                    url: "{{ url('api/bay') }}/"+idGi ,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {

                            $('#level_bay').empty();
                            $('#level_bay').append('<option value="">-- Pilih Bay --</option>');
                            $.each(data, function(key, value) {
                                $('#level_bay').append('<option value="'+ value.id +'">'+ value.description +'</option>');
                            });
                        // $('select[name="level_substation"]').empty();
                        // $('select[name="level_substation"]').append('<option value="">-- Pilih Gardu Induk --</option>');
                        // $.each(data, function(key, value) {
                        //     $('select[name="level_substation"]').append('<option value="'+ value.id +'">'+ value.description +'</option>');
                        // });


                    }
                });
                $.ajax({
                    url: "{{ url('api/subsystem') }}/"+idGi ,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                      $('#subsystem_id').empty();
                      $('#subsystem_id').append('<option value="">-- Pilih Subsystem Bro --</option>');
                      $.each(data, function(key, value) {
                          $('#subsystem_id').append('<option value="'+ value.id +'">'+ value.subsystem +'</option>');
                      });
                    }
                });
            }else{
                $('select[name="level_bay"]').empty();
            }
        });

        if($("#tipe_gangguan_id").val() == '9b2e4a83-ebda-44cd-a5a4-e6b257b7a940'){
          $('#collapseMainGangguan').collapse('show')
        }

        $('#tipe_gangguan_id').on('change', function() {
            var gangguan_id = $(this).val();
            console.log(gangguan_id)
           
            if(gangguan_id == '9b2e4a83-ebda-44cd-a5a4-e6b257b7a940'){
              console.log('collapse show')
              $('#collapseMainGangguan').collapse('show')
            }else{
              console.log('collapse hide')
              $('#collapseMainGangguan').collapse('hide')
            }
        });
        
      });
    </script>
@endpush
