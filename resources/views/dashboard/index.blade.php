<section class="content">
  <div class="container-fluid">
    <div class="row">
      <ul class="nav nav-tabs tab-menu nav-merchant" id="custom-tabs-three-tab" role="tablist">
        @foreach(Session::get('menus') as $menu)
        @if($menu['slug'] == 'dashboard')
        @foreach(Session::get('menus') as $menuCheck)
        {{-- Session::get('menus') --}}
        @if($menuCheck['slug'] == 'autodebit')
        @foreach($menuCheck['childs'] as $row => $child)
        <li class="nav-item tab-item col-md">
          <a class="nav-link tab-link @if($row == 0) active  @endif" id="custom-tabs-{{$child['slug']}}-tab"
            data-toggle="pill" href="#custom-tabs-{{$child['slug']}}" role="tab"
            aria-controls="custom-tabs-{{$child['slug']}}" aria-selected="true" style="display: flex; color: black;">
            @if($child['slug'] == 'tandamata-berjangka')
            Tandamata Berjangka
            @elseif($child['slug'] == 'tandamata-simuda')
            Tandamata SiMuda
            @elseif($child['slug'] == 'my-goals')
            Autodebit MyGoals
            @elseif($child['slug'] == 'regular')
            Autodebit Regular
            @elseif($child['slug'] == 'lsbu')
            LSBU
            @endif
          </a>
        </li>
        @endforeach
        @endif
        @endforeach
        @endif
        @endforeach
      </ul>
      <div class="tab-content w-100" id="custom-tabs-three-tabContent">
        @foreach(Session::get('menus') as $menu)
        @if($menu['slug'] == 'dashboard')
        @foreach(Session::get('menus') as $menuCheck)
        @if($menuCheck['slug'] == 'autodebit')
        @foreach($menuCheck['childs'] as $row => $child)
        <div class="tab-pane fade mt-4 @if($row == 0) active show  @endif" id="custom-tabs-{{$child['slug']}}"
          role="tabpanel" aria-labelledby="custom-tabs-{{$child['slug']}}">
          @if($child['slug'] == 'tandamata-berjangka')
          @include('dashboard.content.tanda-berjangka')
          @elseif($child['slug'] == 'tandamata-simuda')
          @include('dashboard.content.tanda-simuda')
          @elseif($child['slug'] == 'my-goals')
          @include('dashboard.content.autodebit-mygoals')
          @elseif($child['slug'] == 'regular')
          @include('dashboard.content.autodebit-regular')
          @elseif($child['slug'] == 'lsbu')
          @include('dashboard.content.lsbu')
          @endif
        </div>
        @endforeach
        @endif
        @endforeach
        @endif
        @endforeach
      </div>
    </div>
  </div>
</section>

@push('script')
<script type="text/javascript">
  $(document).ready(function () {
    // loadingData()

    logActivity(JSON.stringify([
      'View',
      'Melihat list',
      'Dashboard',
      'General',
      '{{ Route::current()->getName() }}'
    ]))
  })
</script>
@endpush