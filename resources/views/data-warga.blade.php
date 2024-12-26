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
        <h4><b>Data Warga</b></h4>
      </div>
    </div>
    <div class="card card-primary card-outline card-outline-tabs col-sm-12">
      <div class="row">
        <div class="card-body col-12">
          <section class="content">
            <div class="container-fluid">
              <div class="row d-flex justify-content-center">
                <div class="col-12">
                  <table id="fikri-request" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th>Tanggal Lahir</th>
                        <th>No Telp</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($data as $index => $row)
                        <tr>
                          <td>{{ $index+1 }}</td>
                          <td>{{ data_get($row, 'name') }}</td>
                          <td>{{ data_get($row, 'jenis_kelamin') }}</td>
                          <td>{{ data_get($row, 'address.name') }}</td>
                          <td>{{ data_get($row, 'tgl_lahir') }}</td>
                          <td>{{ data_get($row, 'no_telp') }}</td>
                        </tr>
                      @endforeach
                    </tbody>
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