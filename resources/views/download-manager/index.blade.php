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
    @include('content-header-permission')
    <div class="row header-menu">
      <div class="col-md-3">
        <label>Produk </label>
        <div class="row">
          <div class="col-sm-12">
            <select class="form-control" name="produk" id="produkId">
              <option value="ALL">Seluruh Produk</option>
              <option value="LSBU">LSBU</option>
              <option value="MYGOALS">MYGOALS</option>
              <option value="REGULER">REGULER</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <label>Kategori Laporan </label>
        <div class="row">
          <div class="col-sm-12">
            <select class="form-control" name="kategori" id="kategoriId">
              <option value="ALL">Seluruh Kategori</option>
              <option value="TRANSAKSI">Transaksi</option>
              <option value="PENDAFTARAN">Pendaftaran</option>
              <option value="PENUTUPAN">Penutupan</option>
              <option value="FEE">Fee</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-md-6 d-flex align-items-end justify-content-end">
        <div class="row" style="width: 80%;">
          <div class="col-sm-6">
            <button class="btn btn-primary btn-template" id="filterButton">Tampilkan</button>
          </div>
          <div class="col-sm-6">
            <a href="javascript:void(0)" class="btn btn-danger btn-template" id="resetButton">Reset</a>
          </div>
        </div>
      </div>
    </div>
    <div class="card card-primary card-outline card-outline-tabs col-sm-12">
      <div class="row">
        <div class="card-body col-12">
          @if(request()->segment(3))
            @include('download-manager.content.new')
          @else
            @include('download-manager.content.content')
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
  $('#resetButton').on('click', function(){
    $('#produkId').val('ALL')
    $('#kategoriId').val('ALL')
    $('#fikri-request').DataTable().clear().destroy()
    loadingData()
  })
</script>
@endsection