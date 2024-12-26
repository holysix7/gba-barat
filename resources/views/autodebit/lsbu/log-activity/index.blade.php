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
          <div class="row">
            <div class="col-sm-9">
              <div class="row">
                {{-- <div class="col-sm-3">
                  <label>Kategori </label>
                </div> --}}
                <div class="col-sm-7">
                  <label>Log/Deksripsi </label>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-9">
              <div class="row">
                {{-- <div class="col-sm-3 status">
                  <select class="form-control" name="sd_pc_status" id="statusCategory">
                    <option value="All" selected>Semua</option>
                    <option value="Create">Pendaftaran Autodebit</option>
                    <option value="Closing">Penutupan Autodebit</option>
                    <option value="Edit">Ubah Status Autodebit</option>
                    <option value="Approval">Approval Autodebit</option>
                    <option value="Export">Export Laporan</option>
                    <option value="Delete">Hapus Log Activity</option>
                  </select>
                </div> --}}
                <div class="col-sm-7">
                  <input type="text" class="form-control" id="keyword" name="pencarian" placeholder="Masukan Keyword">
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
        </div>
      </div>
    @endif
    <div class="card card-primary card-outline card-outline-tabs col-sm-12">
      <div class="row">
        <div class="card-body col-12">
          @if(request()->segment(4))
            @include('autodebit.lsbu.log-activity.content.show')
          @else
            @include('autodebit.lsbu.log-activity.content.content')
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
  $(document).ready(function(){
    $('#resetButton').on('click', function(){
      $('#keyword').val('')
      $('#fikri-request').DataTable().clear().destroy()
      loadingData()
    })
  })
</script>
@endsection