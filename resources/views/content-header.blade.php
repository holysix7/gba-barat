<div class="row">
  <div class="col-md-6">
    @foreach(session('menus') as $menu)
      @if($menu['type'] == 3)
        @if(request()->segment(1) == $menu['slug'])
          <h4><b>{{ $menu['description'] }}</b></h4>
        @endif
      @else
        @foreach($menu['childs'] as $child)
          @if(request()->segment(1) == 'autodebit' || request()->segment(1) == 'informasi-notifikasi')
            @if(request()->segment(2) == $child['slug'])
              @foreach($child['grand_childs'] as $grandChild)
                @if(request()->segment(3) == $grandChild['slug'])
                  @if(request()->segment(4) == 'confirm')
                    <h4><b>Inquiry Pendaftaran {{$grandChild['description']}}</b></h4>
                    <p class="text-muted">{{$child['description']}}</p>
                  @elseif(request()->segment(4) == 'show')
                    <h4><b>Detail {{$grandChild['description']}} @if(request()->segment(3) == 'approval') {{ request()->segment(6) > 1 ? request()->segment(6) > 2 ? request()->segment(6) > 3 ? 'Lanjut Autodebet' : 'Penutupan Rekening' : 'Tunda Autodebet' : 'Pendaftaran' }} @endif</b></h4>
                    <p class="text-muted">{{$child['description']}}</p>
                  @elseif(request()->segment(4) == 'result')
                    <h4><b>Hasil {{$grandChild['description']}}</b></h4>
                    <p class="text-muted">{{$child['description']}}</p>
                  @elseif(request()->segment(4) == 'new')
                    <h4><b>Pembukaan {{$grandChild['description']}}</b></h4>
                    <p class="text-muted">{{$child['description']}}</p>
                  @elseif(request()->segment(4) == 'edit')
                    <h4><b>Ubah {{$grandChild['description']}}</b></h4>
                    <p class="text-muted">{{$child['description']}}</p>
                  @else
                    <h4><b>{{$grandChild['description']}}</b></h4>
                    <p class="text-muted">{{$child['description']}}</p>
                  @endif
                
                @endif
              @endforeach
            @endif
          @else
            @if(request()->segment(1) == $menu['slug'])
              @if(request()->segment(2) == $child['slug'])
                @if(request()->segment(3) == 'edit')
                  <h4><b>Edit {{$child['description']}}</b></h4>
                @elseif(request()->segment(3) == 'new')
                  <h4><b>Tambah {{$child['description']}}</b></h4>
                @elseif(request()->segment(3) == 'show')
                  <h4><b>Detail {{$child['description']}}</b></h4>
                @else
                  <h4><b>{{$child['description']}}</b></h4>
                @endif
                <p class="text-muted">{{$menu['description']}}</p>
              @endif
            @endif
          @endif
        @endforeach
      @endif
    @endforeach
  </div>
  <div class="col-md-6 d-flex justify-content-end align-items-center">
    @if(request()->segment(3))
      @foreach(session('menus') as $menu)
        @foreach($menu['childs'] as $child)
          @if(request()->segment(1) == 'autodebit' || request()->segment(1) == 'informasi-notifikasi')
            @if(request()->segment(2) == $child['slug'])
              @foreach($child['grand_childs'] as $grandChild)
                @if(request()->segment(3) == $grandChild['slug'])
                  @if(request()->segment(3) != 'laporan-pendaftaran' && request()->segment(3) != 'laporan-penutupan' && request()->segment(3) != 'approval' && request()->segment(3) != 'fee-lsbu' && request()->segment(3) != 'log-activity' && request()->segment(3) != 'monitoring-transaksi')
                    @if(request()->segment(4))
                      <a href="{{ url('/' . $menu['slug'] . '/' . $child['slug']) . '/' . $grandChild['slug']}}" class="btn btn-primary-outline" style="font-size: 18px; font-weight: bold;padding: 12px; padding-left: 25px; padding-right: 25px; background: #f4f6f9 !important; border-color: #f4f6f9 !important;"><i class="fas fa-angle-left">&nbsp;Kembali</i></a>
                    @else
                    {{-- {{ dd('wkwk') }} --}}
                      {{-- <a href="{{ url('/' . $menu['slug'] . '/' . $child['slug'] . '/' . $grandChild['slug'] . '/new') }}" class="btn btn-primary btn-template-tambah" id="buttonTambah">
                        Tambah
                        {{$grandChild['description']}}
                      </a> --}}
                      
                      {{--
                        PERUBAHAN PERMISSION SYSTEM  
                      --}}

                        @foreach(getPermissions(Session::get('role')->id, 'create') as $createPermission)
                          @php $permission = false @endphp
                          @if(request()->segment(3))
                            {{-- @if(request()->segment(3) == $createPermission['application_slug'])
                              @if($createPermission['parent_id'] == 4)
                                @if($createPermission['create'] == true)
                                @php $permission = true @endphp
                                @endif
                              @endif
                              @if($createPermission['parent_id'] == 2)
                                @if($createPermission['create'] == true)
                                @php $permission = true @endphp
                                @endif
                              @endif
                            @endif --}}
                            @if(request()->segment(3) == $createPermission['application_slug'])
                              @if($createPermission['parent_id'] == 4)
                                @if($createPermission['create'] == true)
                                @php $permission = true @endphp
                                @endif
                              @else
                                @if($createPermission['create'] == true)
                                @php $permission = true @endphp
                                @endif
                              @endif
                            @endif
                          @elseif(request()->segment(2))
                            @if(request()->segment(2) == $createPermission['application_slug'])
                              @if(request()->segment(2) != 'setup-eq')
                                @if($createPermission['create'] == true)
                                  @php $permission = true @endphp
                                @endif
                              @endif
                            @endif
                          @endif
                          
                          @if($permission == true)
                            <div class="col-sm-6">
                              <div class="row">
                                <div class="col-sm-12 d-flex justify-content-end">
                                  {{-- <a href="{{ route('setting.accounttype.new') }}" class="btn btn-primary btn-template-tambah" id="buttonTambah"> --}}
                                  <a href="{{ $createPermission['application_slug'] }}/new" class="btn btn-primary btn-template-tambah" id="buttonTambah">
                                    Tambah
                                    {{$createPermission['application_name']}}
                                  </a>
                                </div>
                              </div>
                            </div>
                            @php break; @endphp
                          @endif
                        @endforeach
                      
                      {{--
                        END PERUBAHAN  
                      --}}
                    @endif
                  @endif
                  @if(request()->segment(3) == 'approval' || request()->segment(3) == 'laporan-penutupan')
                    @if(request()->segment(4))
                      {{-- <a href="{{ url('/' . $menu['slug'] . '/' . $child['slug']) . '/' . $grandChild['slug']}}" class="btn btn-primary-outline" style="font-size: 18px; font-weight: bold;padding: 12px; padding-left: 25px; padding-right: 25px; background: #f4f6f9 !important; border-color: #f4f6f9 !important;"><i class="fas fa-angle-left">&nbsp;Kembali</i></a> --}}
                      <a href="{{ redirect()->back() }}" class="btn btn-primary-outline" style="font-size: 18px; font-weight: bold;padding: 12px; padding-left: 25px; padding-right: 25px; background: #f4f6f9 !important; border-color: #f4f6f9 !important;"><i class="fas fa-angle-left">&nbsp;Kembali</i></a>
                    @endif
                  @endif
                @endif
              @endforeach
            @endif
          @else
            @if(request()->segment(2) == $child['slug'])
              @if(request()->segment(3))
                <a href="{{ url('/' . $menu['slug'] . '/' . $child['slug'])}}" class="btn btn-primary-outline" style="font-size: 18px; font-weight: bold;padding: 12px; padding-left: 25px; padding-right: 25px; background: #f4f6f9 !important; border-color: #f4f6f9 !important;"><i class="fas fa-angle-left">&nbsp;Kembali</i></a>
              @else
                {{-- <a href="{{ url('/' . $menu['slug'] . '/' . $child['slug'] . '/new') }}" class="btn btn-primary btn-template-tambah" id="buttonTambah">
                  Tambah
                  {{$child['description']}}
                </a> --}}

                {{--
                  PERUBAHAN PERMISSION SYSTEM  
                --}}
                  @foreach(getPermissions(Session::get('role')->id, 'create') as $createPermission)
                    @php $permission = false @endphp
                    @if(request()->segment(3))
                      @if(request()->segment(3) == $createPermission['application_slug'])
                        @if($createPermission['parent_id'] == 4)
                          @if($createPermission['create'] == true)
                          @php $permission = true @endphp
                          @endif
                        @endif
                        @if($createPermission['parent_id'] == 2)
                          @if($createPermission['create'] == true)
                          @php $permission = true @endphp
                          @endif
                        @endif
                      @endif
                    @elseif(request()->segment(2))
                      @if(request()->segment(2) == $createPermission['application_slug'])
                        @if(request()->segment(2) != 'setup-eq')
                          @if($createPermission['create'] == true)
                            @php $permission = true @endphp
                          @endif
                        @endif
                      @endif
                    @endif
                    
                    @if($permission == true)
                      <div class="col-sm-6">
                        <div class="row">
                          <div class="col-sm-12 d-flex justify-content-end">
                            {{-- <a href="{{ route('setting.accounttype.new') }}" class="btn btn-primary btn-template-tambah" id="buttonTambah"> --}}
                            <a href="{{ $createPermission['application_slug'] }}/new" class="btn btn-primary btn-template-tambah" id="buttonTambah">
                              Tambah
                              {{$createPermission['application_name']}}
                            </a>
                          </div>
                        </div>
                      </div>
                    @endif
                  @endforeach

                {{--
                  END PERUBAHAN  
                --}}
              @endif
            @endif
          @endif
        @endforeach
      @endforeach
    @else
      @foreach(session('menus') as $menu)
      {{-- {{ dd($menu) }} --}}
        @foreach($menu['childs'] as $child)
          @if(request()->segment(2) == $child['slug'])
            @if(request()->segment(3))
              <a href="{{ url('/' . $menu['slug'] . '/' . $child['slug'])}}" class="btn btn-primary-outline" style="font-size: 18px; font-weight: bold;padding: 12px; padding-left: 25px; padding-right: 25px; background: #f4f6f9 !important; border-color: #f4f6f9 !important;"><i class="fas fa-angle-left">&nbsp;Kembali</i></a>
            @else
                @foreach(getPermissions(Session::get('role')->id, 'create') as $createPermission)
                  @php $permission = false @endphp
                  @if(request()->segment(3))
                    @if(request()->segment(3) == $createPermission['application_slug'])
                      @if($createPermission['parent_id'] == 4)
                        @if($createPermission['create'] == true)
                        @php $permission = true @endphp
                        @endif
                      @endif
                      @if($createPermission['parent_id'] == 2)
                        @if($createPermission['create'] == true)
                        @php $permission = true @endphp
                        @endif
                      @endif
                    @endif
                  @elseif(request()->segment(2))
                    @if(request()->segment(2) == $createPermission['application_slug'])
                      @if(request()->segment(2) != 'setup-eq')
                        @if($createPermission['create'] == true)
                          @php $permission = true @endphp
                        @endif
                      @endif
                    @endif
                  @endif
                  
                  @if($permission == true)
                    <div class="col-sm-6">
                      <div class="row">
                        <div class="col-sm-12 d-flex justify-content-end">
                          <a href="{{ $createPermission['application_slug'] }}/new" class="btn btn-primary btn-template-tambah" id="buttonTambah">
                            Tambah
                            {{$createPermission['application_name']}}
                          </a>
                        </div>
                      </div>
                    </div>
                  @endif
                @endforeach
            @endif
          @endif
        @endforeach
      @endforeach
    @endif
  </div>
</div>

@foreach(getPermissions(Session::get('role')->id, 'update') as $updatePermission)
  @php $permissionUpdate = false @endphp
  @if(request()->segment(3))
    @if(request()->segment(3) == $updatePermission['application_slug'])
      @if($updatePermission['parent_id'] == 4)
        @if($updatePermission['update'] == true)
          @php $permissionUpdate = true @endphp
        @endif
      @endif
      @if($updatePermission['parent_id'] == 2)
        @if($updatePermission['update'] == true)
          @php $permissionUpdate = true @endphp
        @endif
      @endif
    @else
      @if(request()->segment(2) == $updatePermission['application_slug'])
        @if(request()->segment(2) != 'setup-eq')
          @if($updatePermission['update'] == true)
            @php $permissionUpdate = true @endphp
          @endif
        @endif
      @endif
    @endif
  @elseif(request()->segment(2))
    @if(request()->segment(2) == $updatePermission['application_slug'])
      @if(request()->segment(2) != 'setup-eq')
        @if($updatePermission['update'] == true)
          @php $permissionUpdate = true @endphp
        @endif
      @endif
    @endif
  @endif

  @if($permissionUpdate == true)
    @if($updatePermission['update'] == true)
      <input type="hidden" value="true" id="updatePermission">
    @else
      <input type="hidden" value="false" id="updatePermission">
    @endif
  @endif
@endforeach

@foreach(getPermissions(Session::get('role')->id, 'delete') as $deletePermission)
  @php $permissionDelete = false @endphp
  @if(request()->segment(3))
    @if(request()->segment(3) == $deletePermission['application_slug'])
      @if($deletePermission['parent_id'] == 4)
        @if($deletePermission['delete'] == true)
          @php $permissionDelete = true @endphp
        @endif
      @endif
      @if($deletePermission['parent_id'] == 2)
        @if($deletePermission['delete'] == true)
          @php $permissionDelete = true @endphp
        @endif
      @endif
    @else
      @if(request()->segment(2) == $deletePermission['application_slug'])
        @if(request()->segment(2) != 'setup-eq')
          @if($deletePermission['delete'] == true)
            @php $permissionDelete = true @endphp
          @endif
        @endif
      @endif
    @endif
  @elseif(request()->segment(2))
    @if(request()->segment(2) == $deletePermission['application_slug'])
      @if(request()->segment(2) != 'setup-eq')
        @if($deletePermission['delete'] == true)
          @php $permissionDelete = true @endphp
        @endif
      @endif
    @endif
  @endif

  @if($permissionDelete == true)
    @if($deletePermission['delete'] == true)
      <input type="hidden" value="true" id="deletePermission">
    @else
      <input type="hidden" value="false" id="deletePermission">
    @endif
  @endif
@endforeach