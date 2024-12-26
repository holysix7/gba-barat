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
    @if(empty(request()->segment(4)))
      <div class="row header-menu">
        <div class="col-md-12">
          <form action="{{ route('autodebit.lsbu.approval.export') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="row">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-sm-2">
                    <label>Jenis Approval</label>
                  </div>
                  {{-- <div class="col-sm-2">
                    <label>Status Approval</label>
                  </div> --}}
                  <div class="col-sm-3">
                    <label>Nama Pemegang / Nomor Rekening</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-sm-2">
                    <select class="form-control" name="pendaftaran_rekening" id="approvalType">
                      <option value="1">Pendaftaran Rekening</option>
                      <option value="2">Tunda Autodebet</option>
                      <option value="4">Lanjut Autodebet</option>
                      <option value="3">Penutupan Rekening</option>
                    </select>
                  </div>
                  {{-- <div class="col-sm-2">
                    <select class="form-control cari" name="sd_pc_app_status">
                      <option value=''>Pilih</option>
                      <option value="1">Menunggu Approval</option>
                      <option value="0">Rejected</option>
                    </select>
                  </div> --}}
                  <div class="col-sm-3">
                    <input type="text" class="form-control cari" name="search" placeholder="Nama Pemegang / Nomor Rekening" id="searchKey">
                  </div>
                  <div class="col-sm-2">
                    <a href="javascript:void(0)" class="btn btn-primary btn-template" id="filterButton">Tampilkan</a>
                  </div>
                  <div class="col-sm-2">
                    <a href="javascript:void(0)" class="btn btn-danger btn-template" id="resetButton">Reset</a>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    @endif
    <div class="card card-primary card-outline card-outline-tabs col-sm-12">
      <div class="row">
        <div class="card-body col-12">
          @if(empty(request()->segment(4)))
            @include('autodebit.mygoal.approval.content.content')
          @else
            @if(request()->segment(4) == 'show')
              @include('autodebit.mygoal.approval.content.show')
            @endif
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
@endsection