@extends('layouts.app')

@section('content')

@section('style')
<link rel="stylesheet" href="{{ url('adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <h4><b>Iuran {{ strtoupper(request()->segment(1)) }}</b></h4>
      </div>
    </div>
    <div class="card card-primary card-outline card-outline-tabs col-sm-12">
      <div class="row" style="padding-top: 20px;">
        <div class="col-sm-12 d-flex justify-content-end">
          <button type="submit" class="btn btn-success btn-template-tambah" id="buttonExport">
            <i class="mdi mdi-export"></i>
            Export Iuran
          </button>
        </div>
      </div>
      <div class="row">
        <div class="card-body col-12">
          <section class="content">
            <div class="container-fluid">
              <div class="row d-flex justify-content-center">
                <div class="col-12">
                  <table id="fikri-request" class="table table-bordered table-striped">
                  </table>
                </div>
              </div>
            </div>
          </section>
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
          Export Data Warga
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('iuran.export') }}" enctype="multipart/form-data" method="POST">
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
@endsection
@push('script')
  <script type="text/javascript">
    $(document).ready(function() {
      loadingData()
      $('#buttonExport').on('click', function(){
        $('#exportPopUp').modal('show')
      })
    })

    function loadingData(){
      var table = $('#fikri-request').DataTable({
        serverSide: true,
        ajax: {
          url: "{{ route('iuran.get-list') }}",
          type: 'POST',
          data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            rt: "{{ request()->segment(1) }}"
          }
        },
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        responsive: true,
        dom: '<"top"fB>rt<"bottom"lip><"clear">',
        processing: true,
        buttons: [],
        oLanguage: {
          oPaginate: {
            sFirst: "Halaman Pertama",
            sPrevious: "Sebelumnya",
            sNext: "Selanjutnya",
            sLast: "Halaman Terakhir"
          }
        },
        columns: [
          {
            title: "No",
            width: "5%",
            data: 'no'
          },
          {
            title: "RT",
            data: 'rt',
            width: "10%"
          },
          {
            title: "Nomor Kartu Keluarga",
            data: 'no_kk',
            width: "15%"
          },
          {
            title: "Kepala Keluarga",
            data: 'kepala_keluarga',
            width: "10%"
          },
          {
            title: "Nama Lengkap",
            data: 'name',
            width: "10%"
          },
          {
            title: "Tanggal Lahir",
            data: 'tgl_lahir',
            width: "10%"
          },
          {
            title: "Jenis Kelamin",
            data: "jenis_kelamin",
            width: "10%"
          },
          {
            title: "Alamat",
            data: "address",
            width: "15%"
          },
          {
            title: "Nomor Telepon (WA)",
            data: 'no_telp',
            width: "10%"
          }
        ],
      })
    }
  </script>
@endpush