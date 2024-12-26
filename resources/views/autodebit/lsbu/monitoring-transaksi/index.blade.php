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
            <div class="col-sm-12">
              <div class="row">
                <div class="col-sm">
                  <label>Kategori </label>
                  <select class="form-control" name="sd_pc_status" id="statusCategory">
                    <option value="R">Autodebit Sukses</option>
                    <option value="F">Autodebit Gagal</option>
                  </select>
                </div>
                <div class="col-sm">
                  <label>Nomor Rekening </label>
                  <input type="text" class="form-control" id="keyword" name="pencarian" placeholder="Masuk Keyword">
                </div>
                <div class="col-sm">
                  <label>Tanggal Mulai </label>
                  <input type="date" class="form-control" id="startDate" max="{{ $maxDate }}" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-sm">
                  <label>Tanggal Akhir </label>
                  <input type="date" class="form-control" id="endDate" min="{{ $maxDate }}" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-sm d-flex align-items-end">
                  <a href="javascript:void(0)" class="btn btn-primary btn-template" id="filterButton">Tampilkan</a>
                </div>
                <div class="col-sm d-flex align-items-end">
                  <a href="javascript:void(0)" class="btn btn-danger btn-template" id="resetButton">Reset</a>
                </div>
                <div class="col-sm d-flex align-items-end">
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
                                            <button class="btn btn-success btn-template-tambah" id="buttonExport">
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
        </div>
      </div>
    @endif
    <div class="card card-primary card-outline card-outline-tabs col-sm-12">
      <div class="row">
        <div class="card-body col-12">
          @if(request()->segment(4))
            @include('autodebit.lsbu.monitoring-transaksi.content.show')
          @else
            @include('autodebit.lsbu.monitoring-transaksi.content.content')
          @endif
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
          Export Monitoring Transaksi
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('autodebit.lsbu.monitoring-transaksi.export') }}" enctype="multipart/form-data" method="POST">
          @csrf
          <div class="row justify-content-center">
            <div class="col-sm-12">
              <label>Format File</label>
              <select class="form-control" name="export_type" required>
                <option value="1">Excel Spreadsheet</option>
                <option value="2">PDF Document</option>
              </select>
            </div>
          </div>
          <div class="row justify-content-center mt-2">
            <div class="col-sm-12">
              <label>Jenis Transaksi</label>
              <select class="form-control" name="sd_pc_status" id="sdPcStatusId" required>
                <option value="R">Autodebit Sukses</option>
                <option value="F">Autodebit Gagal</option>
              </select>
            </div>
          </div>
          <div class="row justify-content-center mt-2">
            <div class="col-sm-6">
              <label>Rentang Waktu Transaksi</label>
              <input type="date" class="form-control" name="start_date" max="{{ $maxDate }}" value="{{ $maxDate }}" id="start_date" required>
            </div>
            <div class="col-sm-6 d-flex align-items-end">
              <input type="date" class="form-control" name="end_date" max="{{ $maxDate }}" value="{{ $maxDate }}" id="end_date" required>
            </div>
          </div>
          <div class="row justify-content-center mt-2">
            <div class="col-sm-6">
              <label>Rentang Nominal Transaksi</label>
              <input type="text" class="form-control uangMasking" name="nominal_start" id="nominalStart" placeholder="Mulai dari" onchange="validationNumber(this.value, 1)" required>
            </div>
            <div class="col-sm-6 d-flex align-items-end">
              <input type="text" class="form-control uangMasking" name="nominal_end" id="nominalEnd" placeholder="Hingga" onchange="validationNumber(this.value, 2)" required>
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
      $('#endDate').attr('min', $(this).val())
    })
    $('#endDate').on('change', function(){
      $('#startDate').attr('max', $(this).val())
    })
    $('#start_date').on('change', function(){
      $('#end_date').attr('min', $(this).val())
    })
    $('#end_date').on('change', function(){
      $('#start_date').attr('max', $(this).val())
    })
    $('#resetButton').on('click', function(){
      $('#startDate').val('{{ $maxDate }}')
      $('#endDate').val('{{ $maxDate }}')
      $('#keyword').val('')
      $('#statusCategory').val('R')
      $('#fikri-request').DataTable().clear().destroy()
      loadingData()
    })
    $('#buttonExport').on('click', function(){
      $('#start_date').val($('#startDate').val())
      $('#end_date').val($('#endDate').val())
      $('#sdPcStatusId').val($('#statusCategory').val())
      $('#exportPopUp').modal('show')
    })
  })

  function validationNumber(value, type){
    var newValue = value.replaceAll('.', '')
    
    if(parseInt(newValue) > 99999999999999){
      alert('Tidak boleh melebihi nilai 999.999.999.999.999')
      type == 1 ? $('#nominalStart').val('') : $('#nominalEnd').val('')
    }
  }
</script>
@endsection