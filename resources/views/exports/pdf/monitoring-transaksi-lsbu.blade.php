<!DOCTYPE html>
<html>
<head>
	<title>Export Laporan Monitoring Transaksi {{ $sd_pc_status == 'R' ? 'Sukses' : 'Gagal' }} LSBU</title>
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
      <h5>Export Laporan Monitoring Transaksi {{ $sd_pc_status == 'R' ? 'Sukses' : 'Gagal' }} LSBU Periode: <h5 class="font-weight-bold">{{ $rangeDate->start_date }} sampai dengan {{ $rangeDate->end_date }}</h5></h5>
    </div>
  </div>
 
	<table class='table table-bordered table-striped'>
		@if($sd_pc_status == 'R')
			<thead>
				<tr>
					<th class="text-center">No</th>
					<th class="text-center">Kode Cabang</th>
					<th class="text-center">Nama Cabang</th>
					<th class="text-center">Kode Induk</th>
					<th class="text-center">Cabang Induk</th>
					<th class="text-center">Produk</th>
					<th class="text-center">Rekening Sumber</th>
					<th class="text-center">Nama Pemilik</th>
					<th class="text-center">Rekening Tujuan</th>
					<th class="text-center">Setoran Bulanan</th>
					<th class="text-center">Tanggal Debet</th>
					<th class="text-center">Total Periode</th>
					<th class="text-center">Jatuh Tempo</th>
					<th class="text-center">Fee</th>
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
					<td>{{ date("d-m-Y", strtotime($row->jatuh_tempo)) }}</td>
					<td>{{ getRupiah($row->fee) }}</td>
				</tr>
				@endforeach
			</tbody>
		@else
			<thead>
				<tr>
					<th class="text-center">No</th>
					<th class="text-center">Kode Cabang</th>
					<th class="text-center">Nama Cabang</th>
					<th class="text-center">Kode Induk</th>
					<th class="text-center">Cabang Induk</th>
					<th class="text-center">Produk</th>
					<th class="text-center">Rekening Sumber</th>
					<th class="text-center">Nama Pemilik</th>
					<th class="text-center">Rekening Tujuan</th>
					<th class="text-center">Setoran Bulanan</th>
					<th class="text-center">Tanggal Debet</th>
					<th class="text-center">Periode Gagal</th>
					<th class="text-center">Keterangan Gagal</th>
					<th class="text-center">Fee</th>
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
					<td>{{ $row->rek_sumber }}</td>
					<td>{{ $row->nama_pemilik }}</td>
					<td>{{ $row->rek_tujuan }}</td>
					<td>{{ getRupiah($row->setoran_bulanan) }}</td>
					<td>{{ $row->tanggal_debet }}</td>
					<td>{{ $row->periode_gagal }}</td>
					<td> 
						@switch ($row->keterangan_gagal)
							@case('KSM5363')
							  Account Inactive
								@break
							
							@case('KSM0125')
							  Account Blocked
								@break

							@case('KSM5362')
							  Account Closed
								@break

							@case('KSM5417')
							  Balance Not Available
								@break
								
              @case('KSM2133')
                Negative Amount Not Allowed
                @break

              @case('KSM4955')
                Amount Must Be Greater Than Zero
                @break
							
							@default:
							  General Error
								@break
						@endswitch
					</td>
					<td>{{ getRupiah($row->fee) }}</td>
				</tr>
				@endforeach
			</tbody>
		@endif
	</table>
 
</body>
</html>