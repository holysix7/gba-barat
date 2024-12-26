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
    <div class="row header-menu">
      <div class="col-md-12">
        <div class="row">
          <div class="col-sm-3">
            <label>Kode Skema</label>
          </div>
          <div class="col-sm-3">
            <label>Deskripsi Skema</label>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3">
            <select class="form-control" id="kodeSkema">
              <option value="">Pilih</option>
            </select>
          </div>
          <div class="col-sm-3">
            <input type="text" class="form-control" placeholder="Masukkan Keyword...">
          </div>
          <div class="col-sm-2">
            <a href="javascript:void(0)" class="btn btn-primary btn-template" id="filterButton">Tampilkan</a>
          </div>
          <div class="col-sm-2">
            <a href="javascript:void(0)" class="btn btn-danger btn-template" id="resetButton">Reset</a>
          </div>
          <div class="col-sm-2">
            <div class="row">
              <div class="col-sm-12 d-flex justify-content-end">
                <a href="{{ route('skemaproses.daftarskema.new') }}" class="btn btn-primary btn-template-tambah" id="buttonTambah">
                  Tambah
                  @foreach(session('menus') as $menu)
                    @foreach($menu['childs'] as $child)
                      @if(request()->segment(2) == $child['slug'])
                        {{$child['description']}}
                      @endif
                    @endforeach
                  @endforeach
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card card-primary card-outline card-outline-tabs col-sm-12">
      <div class="row">
        <div class="card-body col-12">
          @include('skemaproses.daftarskema.content.content')
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
@endsection