<div class="col-12">
  <table id="fikri-request" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Nama</th>
        <th>Jenis Kelamin</th>
        <th>Tanggal Lahir</th>
        <th>No Telp</th>
      </tr>
    </thead>
    <tbody>
      @foreach($data as $row)
        <tr>
          <td>{{ data_get($row, 'name') }}</td>
          <td>{{ data_get($row, 'jenis_kelamin') }}</td>
          <td>{{ data_get($row, 'tgl_lahir') }}</td>
          <td>{{ data_get($row, 'no_telp') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    var table = $('#fikri-request').DataTable({
      ordering: false 
    });
  })
</script>
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