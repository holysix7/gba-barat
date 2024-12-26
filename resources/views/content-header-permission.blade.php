@if(request()->segment(1) != 'download-manager' && request()->segment(1) != 'data-warehouse')
  <div class="row header-menu">
    <div class="col-md-12">
      <label>Cari </label>
      <div class="row">
        <div class="col-sm-6">
          <div class="row">
            <div class="col-sm-8">
              <input type="text" class="form-control" id="keyword" placeholder="Pencarian">
            </div>
            <div class="col-sm-4">
              <button class="btn btn-primary btn-template" id="filterButton">Tampilkan</button>
            </div>
          </div>
        </div>
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
          {{-- @elseif(request()->segment(1))
            @if(request()->segment(1)) --}}
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
      </div>
    </div>
  </div>
@endif

@foreach(getPermissions(Session::get('role')->id, 'update') as $updatePermission)
  @if(request()->segment(2) == $updatePermission['application_slug'])
    @if($updatePermission['update'] == true)
      <input type="hidden" value="true" id="updatePermission">
    @else
      <input type="hidden" value="false" id="updatePermission">
    @endif
  @endif
@endforeach

@foreach(getPermissions(Session::get('role')->id, 'delete') as $deletePermission)
  @if(request()->segment(2) == $deletePermission['application_slug'])
    @if($deletePermission['delete'] == true)
      <input type="hidden" value="true" id="deletePermission">
    @else
      <input type="hidden" value="false" id="deletePermission">
    @endif
  @endif
@endforeach

@foreach(getPermissions(Session::get('role')->id, 'delete') as $deletePermission)
  @if(request()->segment(1) == $deletePermission['application_slug'])
    @if($deletePermission['delete'] == true)
      <input type="hidden" value="true" id="deletePermission">
    @else
      <input type="hidden" value="false" id="deletePermission">
    @endif
  @endif
@endforeach