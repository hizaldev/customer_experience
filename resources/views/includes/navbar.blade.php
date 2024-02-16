<header class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
      <div class="navbar">
        <div class="container-xl">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('home') }}" >
                <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                </span>
                <span class="nav-link-title">
                  Home
                </span>
              </a>
            </li>
            @canany([
              'dashborad_konsumen-konsumen', 
              'dashborad_konsumen-induk',
              'dashborad_konsumen-unit',
              
              
            ])
            <li class="nav-item">
              <a class="nav-link" href="{{ route('dashboard_konsumen') }}" >
                <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-dashboard" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M4 4h6v8h-6z"></path>
                    <path d="M4 16h6v4h-6z"></path>
                    <path d="M14 12h6v8h-6z"></path>
                    <path d="M14 4h6v4h-6z"></path>
                 </svg>
                </span>
                <span class="nav-link-title">
                  Dashboard Konsumen
                </span>
              </a>
            </li>
            @endcan
            @canany([
              'transaksi_pqm_ktt-list', 
              'transaksi_gangguan-list',
              'transaksi_gangguan-list-induk',
              'transaksi_gangguan-list-unit',
              'transaksi_gangguan-list-ultg',
              'transaksi_gangguan-list-substation',
              'transaksi_jalur-list', 
              
            ])
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/lifebuoy -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-transfer" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 10h-16l5.5 -6" /><path d="M4 14h16l-5.5 6" /></svg>
                  </span>
                  <span class="nav-link-title">
                    Transaksi
                  </span>
                </a>
                  <div class="dropdown-menu">
                    @can('transaksi_pqm_ktt-list')
                      <a class="dropdown-item" href="{{route('pqm.index')}}" rel="noopener">PQM KTT</a>
                    @endcan
                    @canany([
                      'transaksi_gangguan-list',
                      'transaksi_gangguan-list-induk',
                      'transaksi_gangguan-list-unit',
                      'transaksi_gangguan-list-ultg',
                      'transaksi_gangguan-list-substation',
                    ])
                      <a class="dropdown-item" href="{{route('gangguan.index')}}" rel="noopener">Data Gangguan</a>
                    @endcan
                    @can('transaksi_jalur-list')
                    <a class="dropdown-item" href="{{route('jalur.index')}}" rel="noopener">Data Jadwal Pemeliharaan (Jalur)</a>
                  @endcan
                  </div>
              </li>
            @endcan
            @canany([
              'lokasi_induk-list', 
              'lokasi_unit_pelayanan-list', 
              'lokasi_gardu_induk-list', 
            ])
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/lifebuoy -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pin" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M15 4.5l-4 4l-4 1.5l-1.5 1.5l7 7l1.5 -1.5l1.5 -4l4 -4"></path>
                      <path d="M9 15l-4.5 4.5"></path>
                      <path d="M14.5 4l5.5 5.5"></path>
                   </svg>
                  </span>
                  <span class="nav-link-title">
                    Lokasi
                  </span>
                </a>
                  <div class="dropdown-menu">
                    @can('lokasi_induk-list')
                      <a class="dropdown-item" href="{{route('induks.index')}}" rel="noopener">Unit Induk</a>
                    @endcan
                    @can('lokasi_unit_pelayanan-list')
                      <a class="dropdown-item" href="{{route('unitPelayanan.index')}}" rel="noopener">Unit Pelayanan (level 2)</a>
                    @endcan
                    @can('lokasi_unit_layanan-list')
                      <a class="dropdown-item" href="{{route('unitLayanan.index')}}" rel="noopener">Unit Layanan / Gardu induk (level 3)</a>
                    @endcan
                    @can('lokasi_gardu_induk-list')
                      <a class="dropdown-item" href="{{route('garduInduk.index')}}" rel="noopener">Bay - Tranmsisi (level 4)</a>
                    @endcan
                  </div>
              </li>
            @endcan
            @canany([
              'master_tegangan-list', 
              'master_status-list', 
              'master_fungsi-list', 
              'master_cuaca-list', 
              'master_konsumen-list',
              'master_jenis_gangguan-list',
              'master_tipe_gangguan-list',
              'master_kategori_penyebab_gangguan-list',
              'master_subsystem-list',
            ])
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/lifebuoy -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M19.875 6.27a2.225 2.225 0 0 1 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z"></path>
                      <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                  </svg>
                  </span>
                  <span class="nav-link-title">
                    Master
                  </span>
                </a>
                  <div class="dropdown-menu">
                    @can('master_tegangan-list')
                      <a class="dropdown-item" href="{{route('tegangan.index')}}" rel="noopener">Tegangan</a>
                    @endcan
                    @can('master_status-list')
                      <a class="dropdown-item" href="{{route('status.index')}}" rel="noopener">Status</a>
                    @endcan
                    @can('master_fungsi-list')
                      <a class="dropdown-item" href="{{route('fungsi.index')}}" rel="noopener">Fungsi</a>
                    @endcan
                    @can('master_cuaca-list')
                      <a class="dropdown-item" href="{{route('cuaca.index')}}" rel="noopener">Cuaca BMKG</a>
                    @endcan
                    @can('master_konsumen-list')
                      <a class="dropdown-item" href="{{route('konsumen.index')}}" rel="noopener">Konsumen KTT</a>
                    @endcan
                    @can('master_konsumen-list')
                      <a class="dropdown-item" href="{{route('jenisGangguan.index')}}" rel="noopener">Jenis Gangguan</a>
                    @endcan
                    @can('master_konsumen-list')
                      <a class="dropdown-item" href="{{route('tipeGangguan.index')}}" rel="noopener">Tipe Gangguan</a>
                    @endcan
                    @can('master_kategori_penyebab_gangguan-list')
                      <a class="dropdown-item" href="{{route('kategoriGangguan.index')}}" rel="noopener">Kategori Penyebab Gangguan</a>
                    @endcan
                    @can('master_subsystem-list')
                      <a class="dropdown-item" href="{{route('island.index')}}" rel="noopener">Subsystem</a>
                    @endcan
                  </div>
              </li>
            @endcan
            @canany([
                'settings_permission-list', 
                'settings_role-list',
                'settings-user-list',
                'settings-user-list-all',
              ])
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#navbar-help" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/lifebuoy -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M19.875 6.27a2.225 2.225 0 0 1 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z"></path>
                      <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                  </svg>
                  </span>
                  <span class="nav-link-title">
                    Setting
                  </span>
                </a>
                  <div class="dropdown-menu">
                    @can('settings_role-list')
                      <a class="dropdown-item" href="{{route('roles.index')}}" rel="noopener">Role</a>
                    @endcan
                    @can('settings_permission-list')
                      <a class="dropdown-item" href="{{route('permisions.index')}}" rel="noopener">Permission</a>
                    @endcan
                    @canany(['settings_user-list','settings_user-list-all',])
                      <a class="dropdown-item" href="{{route('users.index')}}" rel="noopener">User</a>
                    @endcan
                  </div>
              </li>
            @endcan
          </ul>
        </div>
      </div>
    </div>
  </header>