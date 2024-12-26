<!DOCTYPE html>
<html>
<head>
	<title>Export Laporan Fee LSBU</title>
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
      <h5>Export Laporan Fee LSBU Periode: <h5 class="font-weight-bold">{{ $rangeDate->start_date }} - {{ $rangeDate->end_date }}</h5></h5>
    </div>
  </div>
 
	<table class='table table-bordered table-striped'>
		<thead>
			<tr>
				<th>No</th>
				<th>Kode Cabang</th>
				<th>Nama Cabang</th>
				<th>Kode Induk</th>
				<th>Cabang Induk</th>
				<th>Produk</th>
				<th>Eksternal Sumber</th>
				<th>Nama Pemilik</th>
				<th>Eksternal Tujuan</th>
				<th>Setoran Bulanan</th>
				<th>Tanggal Debet</th>
				<th>Total Periode</th>
				<th>Jatuh Tempo</th>
				<th>Fee</th>
			</tr>
		</thead>
		<tbody>
			@foreach($records as $row)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $row->kode_cabang }}</td>
				<td>{{ $row->nama_cabang }}</td>
				<td>{{ $row->kode_induk }}</td>
				<td>{{ $row->cabang_induk }}</td>
				<td>{{ $row->produk }}</td>
				<td>{{ $row->eksternal_sumber }}</td>
				<td>{{ $row->nama_pemilik }}</td>
				<td>{{ $row->eksternal_tujuan }}</td>
				<td>{{ getRupiah($row->setoran_bulanan) }}</td>
				<td>{{ $row->tanggal_debet }}</td>
				<td>{{ $row->total_periode }}</td>
				<td>{{ $row->jatuh_tempo }}</td>
				<td>{{ getRupiah($row->fee) }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
 
</body>
</html>