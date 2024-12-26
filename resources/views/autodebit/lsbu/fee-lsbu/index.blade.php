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
          <div class="row justify-content-end">
            <div class="col-sm-3">
              @foreach(session('menus') as $menu)
                @foreach(session('permissions') as $permission)
                  @if(count($menu) > 0)
                    @foreach($menu['childs'] as $child)
                      @if(count($child['grand_childs']) > 0)
                        @foreach($child['grand_childs'] as $grand_child)
                          @if(request()->segment(2) == $child['slug'])
                            @if(request()->segment(3) == $grand_child['slug'])
                              @if($permission['permission_id'] == 6)
                                @if($permission['application_id'] == $grand_child['id'])
                                  @if($permission['isactive'] == true)
                                    <div class="row">
                                      <div class="col-sm-12 d-flex justify-content-end">
                                        <button class="btn btn-success btn-template-tambah" id="buttonExport" target="_blank">
                                          <i class="mdi mdi-export"></i>
                                          Export {{$grand_child['description']}}
                                        </button>
                                      </div>
                                    </div>
                                  @endif
                                @endif
                              @endif
                            @endif
                          @endif
                        @endforeach
                      @endif
                    @endforeach
                  @endif
                @endforeach
              @endforeach
            </div>
          </div>
        </div>
      </div>
    @endif
    <div class="card card-primary card-outline card-outline-tabs col-sm-12">
      <div class="row">
        <div class="card-body col-12">
          @include('autodebit.lsbu.fee-lsbu.content.content')
        </div>
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="exportPopUp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titleId">
          Export Fee LSBU
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('autodebit.lsbu.fee-lsbu.export') }}" enctype="multipart/form-data" method="POST">
          @csrf
          <div class="row justify-content-center">
            <div class="col-sm-12">
              <label>Format File</label>
              <select class="form-control" name="export_type">
                <option value="1">Excel Spreadsheet</option>
                <option value="2">PDF Document</option>
              </select>
            </div>
          </div>
          <div class="row justify-content-center mt-2">
            <div class="col-sm-12">
              <label>Tanggal Mulai</label>
              <input type="date" class="form-control" name="start_date" max="{{ $maxDate }}" value="{{ $maxDate }}" id="start_date">
            </div>
          </div>
          <div class="row justify-content-center mt-2">
            <div class="col-sm-12">
              <label>Tanggal Selesai</label>
              <input type="date" class="form-control" name="end_date" max="{{ $maxDate }}" value="{{ $maxDate }}" id="end_date">
            </div>
          </div>
          <div class="row justify-content-center mt-2">
            <div class="col-sm-12">
              <button class="btn btn-success login-btn">Export</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
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
    $('#startDate').on('change', function(){
      $('#end_date').attr('min', $(this).val())
    })
    $('#endDate').on('change', function(){
      $('#start_date').attr('max', $(this).val())
    })
    $('#buttonExport').on('click', function(){
      $('#start_date').val($('#start_date').val())
      $('#end_date').val($('#end_date').val())
      $('#exportPopUp').modal('show')
    })
  })
</script>
@endsection