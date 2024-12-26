<!DOCTYPE html>
<html>
<head>
	<title>Export Daftar Rekening LSBU</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="{{ asset('app.css') }}">
	<link rel="stylesheet" href="{{ asset('main.css') }}">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
  <div class="row justify-content-center">
    <div class="col-sm-12 text-center">
      <h5>Export Daftar Rekening LSBU Periode: <h5 class="font-weight-bold">{{ $rangeDate->start_date }} - {{ $rangeDate->end_date }}</h5> Dengan Status Autodebit: {{ $statusAutodebit }}</h5>
    </div>
  </div>
 
	<table class='table table-bordered table-striped'>
		<thead>
			<tr>
				<th>No</th>
				<th>Nomor Rekening</th>
				<th>Nama Rekening</th>
				<th>Produk</th>
				<th>Tanggal Debet</th>
				<th>Periode</th>
				<th>Status</th>
				<th>Buka Rekening</th>
			</tr>
		</thead>
		<tbody>
			@foreach($records as $row)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $row->sd_pc_dst_extacc }}</td>
				<td>{{ $row->sp_pc_dst_name }}</td>
				<td>{{ $row->sd_p_name }}</td>
				<td>{{ $row->sp_pc_period_date }}</td>
				<td>{{ $row->sp_pc_period }}</td>
				<td>{{ $row->sp_pc_status }}</td>
				<td>{{ $row->sp_pc_reg_date }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
 
</body>
</html>