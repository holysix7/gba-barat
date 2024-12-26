@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{ url('adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')

<section class="content">
  <div class="container-fluid">
    @include('content-header')
    @if(!request()->segment(3))
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
          </div>
        </div>
      </div>
    @endif
    @if(request()->segment(3) == 'show')
      <div class="row header-menu">
        <div class="col-md-12 d-flex justify-content-end">
          <div class="row">
            <a href="javascript:void(0)" class="btn btn-primary btn-template" onclick="modalFunction(null, null, 'tambah')"><i class="mdi mdi-tooltip-edit"></i>&nbsp;Tambah Group Account Type</a>
          </div>
        </div>
      </div>
    @endif
    <div class="card card-primary card-outline card-outline-tabs col-sm-12">
      <div class="row">
        <div class="card-body col-12">
          @if(request()->segment(3))
            @if(request()->segment(3) == 'new')
              @include('setting.group-account.content.new')
            @else
              @if(request()->segment(3) == 'show')
                @include('setting.group-account.content.show')
              @else
                @include('setting.group-account.content.edit')
              @endif
            @endif
          @else
            @include('setting.group-account.content.content')
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('script')
<script src="{{ url('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/select2/js/select2.full.min.js') }} "></script>
<script src="{{ url('js/utils.js') }} "></script>
<script type="text/javascript">
</script>
@endsection