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
                  <h3 class="card-title">Data Gangguan</h3>
                </div>
                <div class="card-body">
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                          <tbody>
                            <tr>
                              <td >Gardu Induk</td>
                              <td >:</td>
                              <td class="text-muted" >
                                {{$gangguan->substation->nm_lokasi}}
                              </td>
                            </tr>
                            <tr>
                              <td >Bay</td>
                              <td >:</td>
                              <td class="text-muted" >
                                {{$gangguan->bay->nm_lokasi}}
                              </td>
                            </tr>
                            <tr>
                              <td >Tgl Jam Gangguan</td>
                              <td >:</td>
                              <td class="text-muted" >
                                {{$gangguan->tgl_gangguan}}
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                          <tbody>
                            <tr>
                              <td >Gangguan</td>
                              <td >:</td>
                              <td class="text-muted" >
                                {{$gangguan->jenisGangguan->jenis_gangguan}}
                              </td>
                            </tr>
                            <tr>
                              <td >Group Gangguan</td>
                              <td >:</td>
                              <td class="text-muted" >
                                {{$gangguan->tipeGangguan->tipe_gangguan}}
                              </td>
                            </tr>
                            <tr>
                              <td >Cuaca</td>
                              <td >:</td>
                              <td class="text-muted" >
                                {{$gangguan->kondisi_lingkungan}}
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                          <thead>
                            <tr>
                              <th>Anounciator</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="text-muted" >
                                {{$gangguan->anounciator}}
                              </td>
                            </tr>
                            
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                          <thead>
                            <tr>
                              <th>Indikasi Relay</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="text-muted" >
                                {{$gangguan->indikasi_relay}}
                              </td>
                            </tr>
                            
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                          <thead>
                            <tr>
                              <th>Arus Gangguan</th>
                              <th>MW (Beban Sebelum Gangguan)</th>
                              <th>Mvar (Beban Sebelum Gangguan)</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="text-muted" >
                                {{$gangguan->arus_gangguan}} A
                              </td>
                              <td class="text-muted" >
                                {{$gangguan->beban_sebelum_mw}} MW
                              </td>
                              <td class="text-muted" >
                                {{$gangguan->beban_sebelum_mvar}} MVar
                              </td>
                            </tr>
                            
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                          <thead>
                            <tr>
                              <th>Counter PMT R</th>
                              <th>Counter PMT S</th>
                              <th>Counter PMT T</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="text-muted" >
                                {{$gangguan->count_cb_r == null ? 0 : $gangguan->count_cb_r}}
                              </td>
                              <td class="text-muted" >
                                {{$gangguan->count_cb_s == null ? 0 : $gangguan->count_cb_s}}
                              </td>
                              <td class="text-muted" >
                                {{$gangguan->count_cb_t == null ? 0 : $gangguan->count_cb_t}}
                              </td>
                            </tr>
                            
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                          <thead>
                            <tr>
                              <th>Counter LA R</th>
                              <th>Counter LA S</th>
                              <th>Counter LA T</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="text-muted" >
                                {{$gangguan->count_la_r == null ? 0 : $gangguan->count_la_r}}
                              </td>
                              <td class="text-muted" >
                                {{$gangguan->count_la_s == null ? 0 : $gangguan->count_la_s}}
                              </td>
                              <td class="text-muted" >
                                {{$gangguan->count_la_t == null ? 0 : $gangguan->count_la_t}}
                              </td>
                            </tr>
                            
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Data Investigasi Gangguan </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                      <div class="col-md-8">
                        
                        <div class="form-group mb-3">
                          <label for="tgl_investigasi">Tanggal Investigasi</label>
                          <input type="date" class="form-control" value="{{$investigasi != null ? $investigasi->tgl_investigasi : '' }}" disabled>
                        </div>
                        
                        <div class="form-group mb-3">
                          <label class="form-label">Hasil Investigasi
                          <textarea class="form-control" placeholder="Investigasi Gangguan" disabled>{{$investigasi != null ? $investigasi->investigasi : '' }}</textarea>
                        </div>
                        
                      </div>
                      <div class="col-md-4">
                        <div class="form-group mb-3">
                          <label for="pelaksana_satu">Pelaksana 1</label>
                          <input type="text" class="form-control" value="{{$investigasi != null ? $investigasi->pelaksana_satu : '' }}" placeholder="Pelaksana Investigasi 1" disabled>
                        </div>
                        <div class="form-group mb-3">
                          <label for="pelaksana_dua">Pelaksana 2</label>
                          <input type="text" class="form-control" value="{{$investigasi != null ? $investigasi->pelaksana_dua : '' }}" placeholder="Pelaksana Investigasi 2" disabled>
                        </div>
                        <div class="form-group mb-3">
                          <label for="pelaksana_tiga">Pelaksana 3</label>
                          <input type="text" class="form-control" value="{{$investigasi != null ? $investigasi->pelaksana_tiga : '' }}" placeholder="Pelaksana Investigasi 3" disabled>
                        </div>
                        <div class="form-group mb-3">
                          <label for="pelaksana_empat">Pelaksana 4</label>
                          <input type="text" class="form-control" value="{{$investigasi != null ? $investigasi->pelaksana_empat : '' }}" placeholder="Pelaksana Investigasi 4" disabled>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Tindaklanjut Gangguan </h3>
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
                  <form action="{{ route('tindaklanjut.update', $gangguan->id)}}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="row">
                      <div class="col-md-8">
                        
                        <div class="form-group mb-3">
                          <label for="tgl_tindaklanjut">Tanggal Tindaklanjut</label>
                          <input type="date" class="form-control @error('tgl_tindaklanjut') is-invalid @enderror" value="{{$tindaklanjut != null ? $tindaklanjut->tgl_tindaklanjut : '' }}" name="tgl_tindaklanjut" id="tgl_tindaklanjut">
                          @error('tgl_tindaklanjut')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                        <div class="form-group mb-3">
                          <label for="kategori_penyebab_id">Penyebab Gangguan <span class="text-danger">*</span> </label>
                          <select name="kategori_penyebab_id" class="form-control @error('kategori_penyebab_id') is-invalid @enderror" id="kategori_penyebab_id" required>
                              @php
                                $idPenyebab = $tindaklanjut != null ? $tindaklanjut->kategori_penyebab_id : '';
                              @endphp
                              <option value="">-- Pilih Tipe Gangguan --</option>
                              @foreach ( $kategoriPenyebab as $penyebab )
                                  <option value="{{$penyebab->id}}" {{$idPenyebab == $penyebab->id ? 'selected' : ''}}>{{$penyebab->kategori_penyebab}}</option>
                              @endforeach
                          </select>
                          @error('kategori_penyebab_id')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                        <div class="form-group mb-3">
                          <label class="form-label">Hasil Tindaklanjut
                          <textarea class="form-control @error('tindaklanjut') is-invalid @enderror" name="tindaklanjut" rows="8" placeholder="Tindaklanjut Gangguan">{{$tindaklanjut != null ? $tindaklanjut->tindaklanjut : '' }}</textarea>
                          @error('tindaklanjut')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                        
                      </div>
                      <div class="col-md-4">
                        <div class="form-group mb-3">
                          <label for="pelaksana_satu">Pelaksana 1</label>
                          <input type="text" class="form-control @error('pelaksana_satu') is-invalid @enderror" name="pelaksana_satu" value="{{$tindaklanjut != null ? $tindaklanjut->pelaksana_satu : '' }}" id="pelaksana_satu" placeholder="Masukan Pelaksana 1">
                          @error('pelaksana_satu')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                        <div class="form-group mb-3">
                          <label for="pelaksana_dua">Pelaksana 2</label>
                          <input type="text" class="form-control @error('pelaksana_dua') is-invalid @enderror" name="pelaksana_dua" value="{{$tindaklanjut != null ? $tindaklanjut->pelaksana_dua : '' }}" id="pelaksana_dua" placeholder="Masukan Pelaksana 2">
                          @error('pelaksana_dua')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                        <div class="form-group mb-3">
                          <label for="pelaksana_tiga">Pelaksana 3</label>
                          <input type="text" class="form-control @error('pelaksana_tiga') is-invalid @enderror" name="pelaksana_tiga" value="{{$tindaklanjut != null ? $tindaklanjut->pelaksana_tiga : '' }}" id="pelaksana_tiga" placeholder="Masukan Pelaksana 3">
                          @error('pelaksana_tiga')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                        <div class="form-group mb-3">
                          <label for="pelaksana_empat">Pelaksana 4</label>
                          <input type="text" class="form-control @error('pelaksana_empat') is-invalid @enderror" name="pelaksana_empat" value="{{$tindaklanjut != null ? $tindaklanjut->pelaksana_empat : '' }}" id="pelaksana_empat" placeholder="Masukan Pelaksana 4">
                          @error('pelaksana_empat')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mr-2 mt-2">Submit</button>
                    <a href="{{route('gangguan.index')}}" class="btn btn-secondary mt-2" role="button" aria-pressed="true" >Close</a>
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
