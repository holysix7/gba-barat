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
        <!-- <div class="row">
          <div class="col-sm-9">
            <div class="row">
              <div class="col-sm-7">
                <label>Log/Deskripsi</label>
              </div>
            </div>
          </div>
        </div> -->
        <div class="row">
          @php
          $userPusat = [1, 2, 3, 5, 7];
          @endphp
          @if(in_array(Session::get('role')->id, $userPusat))
          <div class="col-sm-3">
            <label for="brach_code">Banch Office</label>
            <select class="form-control select2" id="branch_code" name="branch_code">
              <option value="">Semua Cabang</option>
              @foreach($branchs as $row)
                <option value="{{ $row->code }}">{{ $row->name }} ({{ $row->code }})</option>
              @endforeach
            </select>
          </div>
          @endif
          <div class="col-sm-9">
            <div class="row">
              <div class="col-sm-7">
                <label for="keyword">Log/Deskripsi</label>
                <input type="text" class="form-control" id="keyword" name="pencarian" placeholder="Masukan Keyword">
              </div>
              <div class="col-sm-2 align-self-end">
                <a href="javascript:void(0)" class="btn btn-primary btn-template" id="filterButton">Tampilkan</a>
              </div>
              <div class="col-sm-2 align-self-end">
                <a href="javascript:void(0)" class="btn btn-danger btn-template" id="resetButton">Reset</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card card-primary card-outline card-outline-tabs col-sm-12">
      <div class="row">
        <div class="card-body col-12">
          @include('autodebit.mygoal.log-activity.content.content')
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
  $(document).ready(function() {
    $('#resetButton').on('click', function() {
      $('#keyword').val('')
      $('#mygoals-table').DataTable().clear().destroy()
      loadingData()
    });
    $('.select2').select2();
  })
</script>
@endsection