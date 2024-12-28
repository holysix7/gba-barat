<aside class="main-sidebar sidebar-light-primary elevation-4" style="background: #000000BF !important;">
  <!-- Brand Logo -->
  <div class="brand-link d-flex justify-content-center" style="border-bottom: 0 !important;">
    {{-- <span class="brand-text font-weight-bold" style="color: #FFFFFF;">GBA Barat RW 14</span> --}}
    <img src="{{ url('images/logo.jpeg') }}" style="width: 70px; height: 70px">
  </div>

  <?php 
    $menu_rt = [
      [
        'name'    => 'RW',
        'url'     => 'rw',
        'submenu' => [
          [
            'name'  => 'Data Warga',
            'url'   => 'data-warga',
            'icon'  => 'users'
          ],
          [
            'name'  => 'Iuran RT',
            'url'   => 'iuran',
            'icon'  => 'money-bill'
          ],
          [
            'name'  => 'Laporan Keuangan',
            'url'   => 'laporan-keuangan',
            'icon'  => 'book'
          ],
        ],
      ],
      [
        'name'    => 'RT 01',
        'url'     => 'rt01',
        'submenu' => [
          [
            'name'  => 'Data Warga',
            'url'   => 'data-warga',
            'icon'  => 'users'
          ],
          [
            'name'  => 'Iuran',
            'url'   => 'iuran',
            'icon'  => 'money-bill'
          ],
        ],
      ],
      [
        'name'    => 'RT 02',
        'url'     => 'rt02',
        'submenu' => [
          [
            'name'  => 'Data Warga',
            'url'   => 'data-warga',
            'icon'  => 'users'
          ],
          [
            'name'  => 'Iuran',
            'url'   => 'iuran',
            'icon'  => 'money-bill'
          ],
        ],
      ],
      [
        'name'    => 'RT 03',
        'url'     => 'rt03',
        'submenu' => [
          [
            'name'  => 'Data Warga',
            'url'   => 'data-warga',
            'icon'  => 'users'
          ],
          [
            'name'  => 'Iuran',
            'url'   => 'iuran',
            'icon'  => 'money-bill'
          ],
        ],
      ],
      [
        'name'    => 'RT 04',
        'url'     => 'rt04',
        'submenu' => [
          [
            'name'  => 'Data Warga',
            'url'   => 'data-warga',
            'icon'  => 'users'
          ],
          [
            'name'  => 'Iuran',
            'url'   => 'iuran',
            'icon'  => 'money-bill'
          ],
        ],
      ],
      [
        'name'    => 'RT 05',
        'url'     => 'rt05',
        'submenu' => [
          [
            'name'  => 'Data Warga',
            'url'   => 'data-warga',
            'icon'  => 'users'
          ],
          [
            'name'  => 'Iuran',
            'url'   => 'iuran',
            'icon'  => 'money-bill'
          ],
        ],
      ],
      [
        'name'    => 'RT 06',
        'url'     => 'rt06',
        'submenu' => [
          [
            'name'  => 'Data Warga',
            'url'   => 'data-warga',
            'icon'  => 'users'
          ],
          [
            'name'  => 'Iuran',
            'url'   => 'iuran',
            'icon'  => 'money-bill'
          ],
        ],
      ],
    ];
  ?>
  <!-- Sidebar -->
  <div class="sidebar" style="padding: 0px 3px !important;">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item {{ request()->segment(1) == 'profile' ? 'menu-open' : '' }}">
          <a href="{{ URL::to('/') . '/' . 'dashboard' }}" class="nav-link">
            <div class="row">
              <div class="col-sm-2">
                <i class="nav-icon fa fa-database" style="color: {{ request()->segment(1) == 'dashboard' ? '#FFFFFF' : 'grey' }}"></i>
              </div>
              <div class="col-sm-9">
                <p style="color: {{ request()->segment(1) == 'dashboard' ? '#FFFFFF' : 'grey' }}">
                  Dashboard
                </p>
              </div>
            </div>
          </a>
        </li>

        <li class="nav-item {{ request()->segment(1) == 'profile' ? 'menu-open' : '' }}">
          <a href="{{ URL::to('/') . '/' . 'profile' }}" class="nav-link">
            <div class="row">
              <div class="col-sm-2">
                <i class="nav-icon fa fa-user" style="color: {{ request()->segment(1) == 'dkm' ? '#FFFFFF' : 'grey' }}"></i>
              </div>
              <div class="col-sm-9">
                <p style="color: {{ request()->segment(1) == 'dkm' ? '#FFFFFF' : 'grey' }}">
                  Profile
                </p>
              </div>
            </div>
          </a>
        </li>

        <li class="nav-item {{ request()->segment(1) == 'dkm' ? 'menu-open' : '' }}">
          <a href="{{ URL::to('/') . '/' . 'dkm' }}" class="nav-link">
            <div class="row">
              <div class="col-sm-2">
                <i class="nav-icon fa fa-moon" style="color: {{ request()->segment(1) == 'dkm' ? '#FFFFFF' : 'grey' }}"></i>
              </div>
              <div class="col-sm-9">
                <p style="color: {{ request()->segment(1) == 'dkm' ? '#FFFFFF' : 'grey' }}">
                  DKM
                </p>
              </div>
            </div>
          </a>
        </li>
        
        @foreach($menu_rt as $row)
          <li class="nav-item {{ request()->segment(1) == $row['url'] ? 'menu-open' : '' }}">
            <a href="javascript:void(0)" class="nav-link {{ request()->segment(1) == $row['url'] ? 'active nav-change-template' : '' }} ">
              <div class="row">
                <div class="col-sm-2">
                  <i class="nav-icon fa fa-building" style="color : {{ request()->segment(1) == $row['url'] ? '#FFFFFF' : 'grey' }}"></i>
                </div>
                <div class="col-sm-10">
                  <div class="row">
                    <div class="col-sm-9">
                      <p style="color: {{ request()->segment(1) == $row['url'] ? '#FFFFFF' : 'grey' }}">
                        {{ $row['name'] }}
                      </p>
                    </div>
                    <div class="col-sm-3">
                      <i class="right fas fa-angle-left" style="color: {{ request()->segment(1) == $row['url'] ? '#FFFFFF' : 'grey' }}"></i>
                    </div>
                  </div>
                </div>
              </div>
            </a>
            <ul class="nav nav-treeview">
              @foreach($row['submenu'] as $submenu)
                <li class="nav-item {{ request()->segment(1) == $row['url'] && request()->segment(2) == $submenu['url'] ? 'menu-open' : '' }}">
                  <a href="{{ URL::to('/') . '/' . $row['url'] . '/' . $submenu['url'] }}" class="nav-link {{ request()->segment(1) == $row['url'] && request()->segment(2) == $submenu['url'] ? 'active nav-change-template' : '' }}">
                    <div class="row">
                      <div class="col-sm-3">
                        <i class="nav-icon fa fa-{{$submenu['icon']}}" style="color : {{ request()->segment(1) == $row['url'] && request()->segment(2) == $submenu['url'] ? '#FFFFFF' : 'grey' }}; margin-left: 15px;"></i>
                      </div>
                      <div class="col-sm-9">
                        <p style="color: {{ request()->segment(1) == $row['url'] && request()->segment(2) == $submenu['url'] ? '#FFFFFF' : 'grey' }}">
                          {{ $submenu['name'] }}
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
              @endforeach
            </ul>
          </li>
        @endforeach
      </ul>
    </nav>

  </div>
  <!-- /.sidebar -->
</aside>