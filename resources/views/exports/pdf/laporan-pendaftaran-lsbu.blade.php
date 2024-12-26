<!DOCTYPE html>
<html>
<head>
	<title>Export Laporan Pendaftaran LSBU</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	{{-- <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}"> --}}
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
      <h5>Export Laporan Pendaftaran LSBU Periode: <h5 class="font-weight-bold">{{ $rangeDate->start_date }} - {{ $rangeDate->end_date }}</h5></h5>
    </div>
  </div>
 
	<table class='table table-bordered table-striped'>
		<thead>
			<tr>
				<th>No</th>
				<th>Kode</th>
				<th>Cabang</th>
				<th>Kode Induk</th>
				<th>Cabang Induk</th>
				<th>Produk</th>
				<th>No. Rekening Tabungan Sumber Dana</th>
				<th>Jenis Rekening Tabungan Sumber Dana</th>
				<th>Nama Pemegang Rekening Tabungan Sumber Dana</th>
				<th>No Rekening Tujuan (BJBS)</th>
				<th>Jangka Waktu</th>
				<th>Setoran Bulanan</th>
				<th>Tanggal Pendebetan</th>
				<th>Jatuh Tempo</th>
			</tr>
		</thead>
		<tbody>
			@foreach($records as $row)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $row->kode_cabang }}</td>
				<td>{{ $row->nama_cabang }}</td>
				<td>{{ $row->kode_induk}}</td>
				<td>{{ $row->cabang_induk }}</td>
				<td>{{ $row->produk }}</td>
				<td>{{ $row->rekening_sumber }}</td>
				<td>{{ $row->tipe_rek_tujuan }}</td>
				<td>{{ $row->nama_nasabah }}</td>
				<td>{{ $row->rek_tujuan }}</td>
				<td>{{ $row->jangka_waktu }}</td>
				<td>{{ $row->setoran_bulanan }}</td>
				<td>{{ $row->tanggal_debet }}</td>
				<td>{{ $row->jatuh_tempo }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
 
</body>
</html>