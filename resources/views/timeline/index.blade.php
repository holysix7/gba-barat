@extends('content')

@section('info')
  <div class="row">
    <ul class="nav nav-tabs tab-menu nav-merchant" id="custom-tabs-three-tab" role="tablist">
      <li class="nav-item tab-item col-md">
        <a class="nav-link tab-link active"
          data-toggle="pill" href="#custom-tabs-infowarga" role="tab"
          aria-controls="custom-tabs" aria-selected="true" style="display: flex; color: black;">
          <b>Informasi Warga <i class="fa fa-users"></i></b>
        </a>
      </li>
      <li class="nav-item tab-item col-md">
        <a class="nav-link tab-link"
          data-toggle="pill" href="#custom-tabs-so" role="tab"
          aria-controls="custom-tabs" aria-selected="true" style="display: flex; color: black;">
          <b>Struktur Organisasi RW <i class="fa fa-building"></i></b>
        </a>
      </li>
    </ul>
    <div class="tab-content w-100" id="custom-tabs-three-tabContent">
      <div class="tab-pane fade mt-4 active show" id="custom-tabs-infowarga"
        role="tabpanel" aria-labelledby="custom-tabs">
        @include('timeline.content.info-warga')
      </div>
    </div>
    <div class="tab-content w-100" id="custom-tabs-three-tabContent">
      <div class="tab-pane fade mt-4 " id="custom-tabs-so"
        role="tabpanel" aria-labelledby="custom-tabs">
        @include('timeline.content.struktur-organisasi')
      </div>
    </div>
  </div>
@endsection