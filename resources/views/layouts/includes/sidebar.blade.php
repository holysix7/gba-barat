<aside class="main-sidebar sidebar-light-primary elevation-4" style="background: #000000BF !important;">
  <!-- Brand Logo -->
  <div class="brand-link" style="border-bottom: 0 !important;">
    <span class="brand-text font-weight-bold" style="color: #FFFFFF;">GBA Barat RW 14</span>
  </div>

  <!-- Sidebar -->
  <div class="sidebar" style="padding: 0px 3px !important;">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
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
                <i class="nav-icon fa fa-building" style="color: {{ request()->segment(1) == 'dkm' ? '#FFFFFF' : 'grey' }}"></i>
              </div>
              <div class="col-sm-9">
                <p style="color: {{ request()->segment(1) == 'dkm' ? '#FFFFFF' : 'grey' }}">
                  DKM
                </p>
              </div>
            </div>
          </a>
        </li>
        
        <li class="nav-item {{ request()->segment(1) == 'rt01' ? 'menu-open' : '' }}">
          <a href="javascript:void(0)" class="nav-link {{ request()->segment(1) == 'rt01' ? 'active nav-change-template' : '' }} ">
            <div class="row">
              <div class="col-sm-2">
                <i class="nav-icon fa fa-building" style="color : {{ request()->segment(1) == 'rt01' ? '#FFFFFF' : 'grey' }}"></i>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-9">
                    <p style="color: {{ request()->segment(1) == 'rt01' ? '#FFFFFF' : 'grey' }}">
                      RT 01
                    </p>
                  </div>
                  <div class="col-sm-3">
                    <i class="right fas fa-angle-left" style="color: {{ request()->segment(1) == 'rt01' ? '#FFFFFF' : 'grey' }}"></i>
                  </div>
                </div>
              </div>
            </div>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item {{ request()->segment(2) == 'data-warga' ? 'menu-open' : '' }}">
              <a href="{{ URL::to('/') . '/' . 'rt01' . '/' . 'data-warga' }}" class="nav-link {{ request()->segment(2) == 'data-warga' ? 'active nav-change-template' : '' }}">
                <div class="row">
                  <div class="col-sm-3">
                    <i class="nav-icon" style="color : {{ request()->segment(2) == 'data-warga' ? '#FFFFFF' : 'grey' }}; margin-left: 15px;"></i>
                  </div>
                  <div class="col-sm-9">
                    <p style="color: {{ request()->segment(2) == 'data-warga' ? '#FFFFFF' : 'grey' }}">
                      Data Warga
                    </p>
                  </div>
                </div>
              </a>
            </li>
          </ul>
        </li>
        
        <li class="nav-item {{ request()->segment(1) == 'rt02' ? 'menu-open' : '' }}">
          <a href="javascript:void(0)" class="nav-link {{ request()->segment(1) == 'rt02' ? 'active nav-change-template' : '' }} ">
            <div class="row">
              <div class="col-sm-2">
                <i class="nav-icon fa fa-building" style="color : {{ request()->segment(1) == 'rt02' ? '#FFFFFF' : 'grey' }}"></i>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-9">
                    <p style="color: {{ request()->segment(1) == 'rt02' ? '#FFFFFF' : 'grey' }}">
                      RT 02
                    </p>
                  </div>
                  <div class="col-sm-3">
                    <i class="right fas fa-angle-left" style="color: {{ request()->segment(1) == 'rt02' ? '#FFFFFF' : 'grey' }}"></i>
                  </div>
                </div>
              </div>
            </div>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item {{ request()->segment(2) == 'data-warga' ? 'menu-open' : '' }}">
              <a href="{{ URL::to('/') . '/' . 'rt02' . '/' . 'data-warga' }}" class="nav-link {{ request()->segment(2) == 'data-warga' ? 'active nav-change-template' : '' }}">
                <div class="row">
                  <div class="col-sm-3">
                    <i class="nav-icon" style="color : {{ request()->segment(2) == 'data-warga' ? '#FFFFFF' : 'grey' }}; margin-left: 15px;"></i>
                  </div>
                  <div class="col-sm-9">
                    <p style="color: {{ request()->segment(2) == 'data-warga' ? '#FFFFFF' : 'grey' }}">
                      Data Warga
                    </p>
                  </div>
                </div>
              </a>
            </li>
          </ul>
        </li>
        
        <li class="nav-item {{ request()->segment(1) == 'rt03' ? 'menu-open' : '' }}">
          <a href="javascript:void(0)" class="nav-link {{ request()->segment(1) == 'rt03' ? 'active nav-change-template' : '' }} ">
            <div class="row">
              <div class="col-sm-2">
                <i class="nav-icon fa fa-building" style="color : {{ request()->segment(1) == 'rt03' ? '#FFFFFF' : 'grey' }}"></i>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-9">
                    <p style="color: {{ request()->segment(1) == 'rt03' ? '#FFFFFF' : 'grey' }}">
                      RT 03
                    </p>
                  </div>
                  <div class="col-sm-3">
                    <i class="right fas fa-angle-left" style="color: {{ request()->segment(1) == 'rt03' ? '#FFFFFF' : 'grey' }}"></i>
                  </div>
                </div>
              </div>
            </div>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item {{ request()->segment(2) == 'data-warga' ? 'menu-open' : '' }}">
              <a href="{{ URL::to('/') . '/' . 'rt03' . '/' . 'data-warga' }}" class="nav-link {{ request()->segment(2) == 'data-warga' ? 'active nav-change-template' : '' }}">
                <div class="row">
                  <div class="col-sm-3">
                    <i class="nav-icon" style="color : {{ request()->segment(2) == 'data-warga' ? '#FFFFFF' : 'grey' }}; margin-left: 15px;"></i>
                  </div>
                  <div class="col-sm-9">
                    <p style="color: {{ request()->segment(2) == 'data-warga' ? '#FFFFFF' : 'grey' }}">
                      Data Warga
                    </p>
                  </div>
                </div>
              </a>
            </li>
          </ul>
        </li>
        
        <li class="nav-item {{ request()->segment(1) == 'rt04' ? 'menu-open' : '' }}">
          <a href="javascript:void(0)" class="nav-link {{ request()->segment(1) == 'rt04' ? 'active nav-change-template' : '' }} ">
            <div class="row">
              <div class="col-sm-2">
                <i class="nav-icon fa fa-building" style="color : {{ request()->segment(1) == 'rt04' ? '#FFFFFF' : 'grey' }}"></i>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-9">
                    <p style="color: {{ request()->segment(1) == 'rt04' ? '#FFFFFF' : 'grey' }}">
                      RT 04
                    </p>
                  </div>
                  <div class="col-sm-3">
                    <i class="right fas fa-angle-left" style="color: {{ request()->segment(1) == 'rt04' ? '#FFFFFF' : 'grey' }}"></i>
                  </div>
                </div>
              </div>
            </div>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item {{ request()->segment(2) == 'data-warga' ? 'menu-open' : '' }}">
              <a href="{{ URL::to('/') . '/' . 'rt04' . '/' . 'data-warga' }}" class="nav-link {{ request()->segment(2) == 'data-warga' ? 'active nav-change-template' : '' }}">
                <div class="row">
                  <div class="col-sm-3">
                    <i class="nav-icon" style="color : {{ request()->segment(2) == 'data-warga' ? '#FFFFFF' : 'grey' }}; margin-left: 15px;"></i>
                  </div>
                  <div class="col-sm-9">
                    <p style="color: {{ request()->segment(2) == 'data-warga' ? '#FFFFFF' : 'grey' }}">
                      Data Warga
                    </p>
                  </div>
                </div>
              </a>
            </li>
          </ul>
        </li>
        
        <li class="nav-item {{ request()->segment(1) == 'rt05' ? 'menu-open' : '' }}">
          <a href="javascript:void(0)" class="nav-link {{ request()->segment(1) == 'rt05' ? 'active nav-change-template' : '' }} ">
            <div class="row">
              <div class="col-sm-2">
                <i class="nav-icon fa fa-building" style="color : {{ request()->segment(1) == 'rt05' ? '#FFFFFF' : 'grey' }}"></i>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-9">
                    <p style="color: {{ request()->segment(1) == 'rt05' ? '#FFFFFF' : 'grey' }}">
                      RT 05
                    </p>
                  </div>
                  <div class="col-sm-3">
                    <i class="right fas fa-angle-left" style="color: {{ request()->segment(1) == 'rt05' ? '#FFFFFF' : 'grey' }}"></i>
                  </div>
                </div>
              </div>
            </div>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item {{ request()->segment(2) == 'data-warga' ? 'menu-open' : '' }}">
              <a href="{{ URL::to('/') . '/' . 'rt05' . '/' . 'data-warga' }}" class="nav-link {{ request()->segment(2) == 'data-warga' ? 'active nav-change-template' : '' }}">
                <div class="row">
                  <div class="col-sm-3">
                    <i class="nav-icon" style="color : {{ request()->segment(2) == 'data-warga' ? '#FFFFFF' : 'grey' }}; margin-left: 15px;"></i>
                  </div>
                  <div class="col-sm-9">
                    <p style="color: {{ request()->segment(2) == 'data-warga' ? '#FFFFFF' : 'grey' }}">
                      Data Warga
                    </p>
                  </div>
                </div>
              </a>
            </li>
          </ul>
        </li>
        
        <li class="nav-item {{ request()->segment(1) == 'rt06' ? 'menu-open' : '' }}">
          <a href="javascript:void(0)" class="nav-link {{ request()->segment(1) == 'rt06' ? 'active nav-change-template' : '' }} ">
            <div class="row">
              <div class="col-sm-2">
                <i class="nav-icon fa fa-building" style="color : {{ request()->segment(1) == 'rt06' ? '#FFFFFF' : 'grey' }}"></i>
              </div>
              <div class="col-sm-10">
                <div class="row">
                  <div class="col-sm-9">
                    <p style="color: {{ request()->segment(1) == 'rt06' ? '#FFFFFF' : 'grey' }}">
                      RT 06
                    </p>
                  </div>
                  <div class="col-sm-3">
                    <i class="right fas fa-angle-left" style="color: {{ request()->segment(1) == 'rt06' ? '#FFFFFF' : 'grey' }}"></i>
                  </div>
                </div>
              </div>
            </div>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item {{ request()->segment(2) == 'data-warga' ? 'menu-open' : '' }}">
              <a href="{{ URL::to('/') . '/' . 'rt06' . '/' . 'data-warga' }}" class="nav-link {{ request()->segment(2) == 'data-warga' ? 'active nav-change-template' : '' }}">
                <div class="row">
                  <div class="col-sm-3">
                    <i class="nav-icon" style="color : {{ request()->segment(2) == 'data-warga' ? '#FFFFFF' : 'grey' }}; margin-left: 15px;"></i>
                  </div>
                  <div class="col-sm-9">
                    <p style="color: {{ request()->segment(2) == 'data-warga' ? '#FFFFFF' : 'grey' }}">
                      Data Warga
                    </p>
                  </div>
                </div>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>

  </div>
  <!-- /.sidebar -->
</aside>