<div class="col-12">
  <table id="fikri-request-noremote" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Nama</th>
        <th>Jenis Kelamin</th>
        <th>Tanggal Lahir</th>
        <th>No Telp</th>
      </tr>
    </thead>
    <tbody>
      @foreach($data->families as $row)
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