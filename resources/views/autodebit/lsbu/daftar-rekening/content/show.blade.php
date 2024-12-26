@section('style')
<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

<div class="container-fluid">
  <div class="row" id="contentPrintId">
    <div class="col-sm-12">
      <div class="m-4">
        <div class="row m-2 mt-4 justify-content-between">
          <div class="col-sm-5">
            <div class="card border-card-lsbu-rekening">
              <div class="card-header bg-detail-lsbu-rekening">
                <div class="row">
                  <div class="col-sm-2 text-center">
                    <i class="mdi mdi-database" style="font-size: 40px;"></i>
                  </div>
                  <div class="col-sm-10">
                    <h4>Autodebit LSBU</h4>
                    <h5>{{ $record->sp_pc_period }} Bulan</h5>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12">
                    <h5>Saldo Telah Tercapai Sampai Saat ini</h5>
                    <h4>{{ getRupiah($record->sp_pc_debet_total_amount) }}</h4>
                  </div>
                </div>
                <div class="row mt-4">
                  <div class="col-sm-6">
                    <h5>Autodebit telah berjalan</h5>
                    <h4>{{ $record->sp_pc_current_period_sukses }} Bulan</h4>
                  </div>
                  <div class="col-sm-6 text-right">
                    <h5>Dari</h5>
                    <h4>{{ $record->sp_pc_period }} Bulan</h4>
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-sm-12">
                    <div class="progress">
                      <div class="progress-bar" role="progressbar" style="width: {{ $record->progress }}%;" aria-valuenow="{{ $record->progress }}" aria-valuemin="0" aria-valuemax="100">{{ $record->progress }} %</div>
                    </div>
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-sm-6">
                    <h5>0%</h5>
                  </div>
                  <div class="col-sm-6 text-right">
                    <h5>100%</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="row">
              <div class="col-md-12"> 
                <h4>Informasi Umum Autodebit</h4>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-5 mt-1"> 
                <label>Status Autodebit</label>
              </div>
              <div class="col-md-7"> 
                @if($record->sp_pc_status == 1)
                  <span class="badge badge-success status-span w-100">Aktif<i class="fa fa-check" style="padding-left: 5px;"></i></span>
                @else
                  <span class="badge badge-warning status-span w-100">Ditunda<i class="fa fa-close" style="padding-left: 5px;"></i></span>
                @endif
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-5 mt-1"> 
                <label>Saldo sukses terdebet</label>
              </div>
              <div class="col-md-7">
                <input type="text" class="form-control" value="{{ getRupiah($record->sp_pc_debet_total_amount) }}" readonly>
              </div>
            </div>
          </div>
        </div>
        <div class="row m-2 mt-4 justify-content-between">
          <div class="col-sm-5">
            <div class="row">
              <div class="col-md-12"> 
                <h4>Informasi Rekening Sumber</h4>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-5 mt-1"> 
                <label>Jenis Produk</label>
              </div>
              <div class="col-md-7">
                <input type="text" class="form-control" value="{{ $record->sd_p_name }}" readonly>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-5 mt-1"> 
                <label>Nomor Rekening Utama</label>
              </div>
              <div class="col-md-7">
                <input type="text" class="form-control" value="{{ $record->sd_pc_src_extacc }}" readonly>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-5 mt-1"> 
                <label>Nama Rekening Utama</label>
              </div>
              <div class="col-md-7">
                <input type="text" class="form-control" value="{{ $record->sp_pc_src_name }}" readonly>
              </div>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="row">
              <div class="col-md-12"> 
                <h4>Informasi Rekening Tujuan</h4>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-5 mt-1"> 
                <label>Nomor Rekening Tujuan</label>
              </div>
              <div class="col-md-7">
                <input type="text" class="form-control" value="{{ $record->sd_pc_dst_extacc }}" id="extaccId" readonly>
                <input type="hidden" class="form-control" value="{{ $record->sp_pc_reg_id }}" id="regId" readonly>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-5 mt-1"> 
                <label>Nama Rekening Tujuan</label>
              </div>
              <div class="col-md-7">
                <input type="text" class="form-control" value="{{ $record->sp_pc_dst_name }}" readonly>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-5 mt-1"> 
                <label>Setoran Bulanan</label>
              </div>
              <div class="col-md-7">
                <input type="text" class="form-control" value="{{ getRupiah($record->sp_pc_period_amount) }}" readonly>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-6"> 
                <div class="row">
                  <div class="col-md-6 mt-1">
                    <label>Jangka Waktu</label>
                  </div>
                  <div class="col-md-6">
                    <input type="text" class="form-control" value="{{ $record->sp_pc_period }} Bulan" readonly>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6 mt-1">
                    <label>Tanggal Debet</label>
                  </div>
                  <div class="col-md-6">
                    <input type="text" class="form-control" value="{{ $record->sp_pc_period_date }}" readonly>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row m-2 mt-4 justify-content-between">
    <div class="col-sm-6">
      <div class="row">
        <input type="hidden" id="riwayatValue">
        <div class="col-sm-5 d-flex">
          <a href="javascript:void(0)" class="btn btn-primary login-btn w-100" onclick="riwayatTransaksi('show')"><i class="mdi mdi-file-document" style="font-size: 20px;"></i>&nbsp; Riwayat Transaksi</a>
        </div>
        <div class="col-sm-5 d-flex">
          <a href="javascript:void(0)" class="btn btn-success login-btn w-100" onclick="printDiv()"><i class="mdi mdi-file-document" style="font-size: 20px;"></i>&nbsp; Print</a>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="row justify-content-end">
        @if($record->sp_pc_approval_status == 0)
          <div class="col-sm-5 d-flex">
            <a href="{{ $record->routeEdit }}" class="btn btn-info login-btn w-100">Ubah Informasi</a>
          </div>
          <div class="col-sm-5 d-flex">
            <a href="{{ $record->routeInquiry }}" class="btn btn-danger login-btn w-100">Tutup Autodebit</a>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" id="modalHeaderId">
      </div>
      <div class="modal-body d-flex justify-content-center">
        <div class="row w-100" id="modalContentId">
        </div>
      </div>
    </div>
  </div>
</div>

@push('script')
  <script type="text/javascript">
    $(document).ready(function(){
      logActivity(JSON.stringify([
        'View', 
        'Melihat konfirmasi form',
        'savdep_product_customer_mygoals', 
        'General',
        '{{ Route::current()->getName() }}'
      ]))
      riwayatTransaksi('hide')
    })

    function riwayatTransaksi(params){
      var metodePendebetan  = parseInt($('#intervalId').val())
      var jangkaWaktu       = parseInt($('#jangkaWaktuId').val())
      var setoranAwal       = parseInt($('#setoranAwalId').val())
      var setoranBerjangka  = parseInt($('#setoranBerjangkaId').val())
      var pilihanPembayaran = ''
      if($('#intervalId').val() != 1){
        pilihanPembayaran = $('#tanggalId').val() ? $('#tanggalId').val() : $('#hariId').val()
      }
      
      $('#infoModal').modal(params)

      $('#modalHeaderId').html(`
        <h4 class="modal-title request_title w-100 text-center" id="exampleModalLabel">
          <div class="skeleton-box text-skeleton w-100"></div>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      `)
      $('#modalContentId').html(`
        <div class="col-sm-12">
          <div class="row justify-content-between">
            <div class="col-sm-5">
              <div class="row">
                <div class="col-sm-5">
                  <h5>Tanggal Registrasi</h5>
                </div>
                <div class="col-sm-7" id="tglReg">
                  <div class="skeleton-box text-skeleton w-100"></div>
                </div>
              </div>
            </div>
            <div class="col-sm-5">
              <div class="row d-flex justify-content-end">
                <div class="col-sm-5 d-flex justify-content-end">
                  <h5>Jatuh Tempo</h5>
                </div>
                <div class="col-sm-5 d-flex justify-content-end" id="jatuhTempo">
                  <div class="skeleton-box text-skeleton w-100"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <table class="table w-100">
          <thead class="w-100 thead-grey">
            <tr id="tableHeader">
              <th><div class="skeleton-box text-skeleton w-100"></div></th>
              <th><div class="skeleton-box text-skeleton w-100"></div></th>
              <th><div class="skeleton-box text-skeleton w-100"></div></th>
            </tr>
          </thead>
          <tbody id="tableBody">
          </tbody>
        </table>
      `)
      
      $.ajax({
        url: '{{ $record->routeRiwayat }}',
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          sd_pc_dst_extacc: $('#extaccId').val(),
          sp_pc_reg_id: $('#regId').val(),
          type: 'aktif'
        },
        success: function(response){
          $('.request_title').html(`Riwayat Autodebit`)
          $('#tableHeader').html(`
            <th>Periode</th>
            <th>Tanggal Penarikan</th>
            <th>Nominal Autodebit</th>
          `)
          var body = ``
          if(response.status == 200){
            $('#riwayatValue').val(JSON.stringify(response.data))
            $('#tglReg').html(`
              <h5>: ${response.data.parent.sp_pc_reg_date}</h5>
            `)
            $('#jatuhTempo').html(`
              <h5>: Tanggal ${response.data.parent.sp_pc_period_date}</h5>
            `)
            $.map(response.data.transactions, function(v, k){
              body += `
                <tr>
                  <td>${v.sd_t_period}</td>
                  <td>${v.sd_t_dt}</td>
                  <td class='text-right'>Rp ${number_format(v.sd_t_amount)}</td>
                </tr>
              `
            })
          }
          $('#tableBody').html(body)
        },
        error: function(xhr, status, thrown){
          $('.request_title').html(`Simulasi Autodebet`)
          $('#tableHeader').html(`
            <th>Period</th>
            <th>Tanggal Penarikan</th>
            <th>Nominal</th>
            <th>Saldo MyGoals</th>
          `)
          console.log(xhr)
          console.log(status)
          console.log(thrown)
        }
      })
    }
    function printDiv() {
      var divToPrint = document.getElementById("contentPrintId");
      var myAppCss  = `<link rel="stylesheet" href="{{ url('app.css') }}">`
      var myMainCss = `<link rel="stylesheet" href="{{ url('main.css') }}">`
      
      var rekTujuan = $('#extaccId').val()
      var riwayatValues = JSON.parse($('#riwayatValue').val())
      
      var newWin = window.open("", "Print-Window");
      newWin.document.open();
      newWin.document.write(`
      <html>
        <head>
          <title>Print Data Rekening Tujuan: ${rekTujuan}</title>
        </head>
      `)
                // <h3>Bukti Pendaftaran Autodebit LSBU</h3>
      newWin.document.write(`
        <body class="printCss" onload='window.print()'>
          ${myAppCss}
          ${myMainCss}
          <div class="row" id="contentPrintId">
            <div class="col-sm-12">
              <div class="row justify-content-center">
                <h3>Bukti Pendaftaran Layanan Autodebet LSBU Tabungan Haji Channel Counter</h3>
              </div>
              <div class="row m-2 mt-4 justify-content-between">
                <div class="col-sm-5">
                  <div class="card border-card-lsbu-rekening">
                    <div class="card-header bg-detail-lsbu-rekening">
                      <div class="row">
                        <div class="col-sm-2 text-center">
                          <i class="mdi mdi-database" style="font-size: 40px;"></i>
                        </div>
                        <div class="col-sm-10">
                          <h4>Autodebit LSBU</h4>
                          <h5>{{ $record->sp_pc_period }} Bulan</h5>
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-12">
                          <h5>Saldo Telah Tercapai Sampai Saat ini</h5>
                          <h4>{{ getRupiah($record->sp_pc_debet_total_amount) }}</h4>
                        </div>
                      </div>
                      <div class="row mt-4">
                        <div class="col-sm-6">
                          <h5>Autodebit telah berjalan</h5>
                          <h4>{{ $record->sp_pc_current_period_sukses }} Bulan</h4>
                        </div>
                        <div class="col-sm-6 text-right">
                          <h5>Dari</h5>
                          <h4>{{ $record->sp_pc_period }} Bulan</h4>
                        </div>
                      </div>
                      <div class="row mt-2">
                        <div class="col-sm-12">
                          <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ $record->progress }}%;" aria-valuenow="{{ $record->progress }}" aria-valuemin="0" aria-valuemax="100">{{ $record->progress }} %</div>
                          </div>
                        </div>
                      </div>
                      <div class="row mt-2">
                        <div class="col-sm-6">
                          <h5>0%</h5>
                        </div>
                        <div class="col-sm-6 text-right">
                          <h5>100%</h5>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="row">
                    <div class="col-md-12"> 
                      <h4>Informasi Umum Autodebit</h4>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-5 mt-1"> 
                      <label>Status Autodebit</label>
                    </div>
                    <div class="col-md-7"> 
                      @if($record->sp_pc_status == 1)
                        Aktif
                      @else
                        Ditunda
                      @endif
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-5 mt-1"> 
                      <label>Saldo sukses terdebet</label>
                    </div>
                    <div class="col-md-7">
                      {{ getRupiah($record->sp_pc_debet_total_amount) }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="row m-2 mt-4 justify-content-between">
                <div class="col-sm-5">
                  <div class="row">
                    <div class="col-md-12"> 
                      <h4>Informasi Rekening Sumber</h4>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-5 mt-1"> 
                      <label>Jenis Produk</label>
                    </div>
                    <div class="col-md-7">
                      {{ $record->sd_p_name }}
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-5 mt-1"> 
                      <label>Nomor Rekening Utama</label>
                    </div>
                    <div class="col-md-7">
                      {{ $record->sd_pc_src_extacc }}
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-5 mt-1"> 
                      <label>Nama Rekening Utama</label>
                    </div>
                    <div class="col-md-7">
                      {{ $record->sp_pc_src_name }}
                    </div>
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="row">
                    <div class="col-md-12"> 
                      <h4>Informasi Rekening Tujuan</h4>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-5 mt-1"> 
                      <label>Nomor Rekening Tujuan</label>
                    </div>
                    <div class="col-md-7">
                      {{ $record->sd_pc_dst_extacc }}
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-5 mt-1"> 
                      <label>Nama Rekening Tujuan</label>
                    </div>
                    <div class="col-md-7">
                      {{ $record->sp_pc_dst_name }}
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-5 mt-1"> 
                      <label>Setoran Bulanan</label>
                    </div>
                    <div class="col-md-7">
                      {{ getRupiah($record->sp_pc_period_amount) }}
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-md-6"> 
                      <div class="row">
                        <div class="col-md-6 mt-1">
                          <label>Jangka Waktu</label>
                        </div>
                        <div class="col-md-6">
                          {{ $record->sp_pc_period }}
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="row">
                        <div class="col-md-6 mt-1">
                          <label>Tanggal Debet</label>
                        </div>
                        <div class="col-md-6">
                          {{ $record->sp_pc_period_date }}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        `)
      newWin.document.write(`
        <div class="col-sm-12 mt-4">
          <div class="row justify-content-between">
            <div class="col-sm-5">
              <div class="row">
                <div class="col-sm-5">
                  <h5>Tanggal Registrasi</h5>
                </div>
                <div class="col-sm-7">
                  <h5>: ${riwayatValues.parent.sp_pc_reg_date} </h5>
                </div>
              </div>
            </div>
            <div class="col-sm-5">
              <div class="row d-flex justify-content-end">
                <div class="col-sm-5 d-flex justify-content-end">
                  <h5>Jatuh Tempo</h5>
                </div>
                <div class="col-sm-5 d-flex justify-content-end" id="jatuhTempo">
                  <h5>: ${riwayatValues.parent.sp_pc_period_date} </h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      `)
      newWin.document.write(`
        <table class="table w-100">
          <thead class="w-100 thead-grey">
            <tr>
              <th>Periode</th>
              <th>Tanggal Penarikan</th>
              <th>Nominal Autodebit</th>
            </tr>
          </thead>
          <tbody>
      `)
      $.map(riwayatValues.transactions, function(v, k){
        newWin.document.write(`
          <tr>
            <td>${v.sd_t_period}</td>
            <td>${v.sd_t_dt}</td>
            <td class='text-right'>Rp ${number_format(v.sd_t_amount)}</td>
          </tr>
        `)
      })
      newWin.document.write(`
            </tbody>
          </table>
      `)
      newWin.document.write(`
        </body>
      </html>
      `)
      newWin.document.close();
    }

  </script>
@endpush

{{-- @section('style')
  <style>
    @media print {
      .cobaCss {
        background: #0984E3 !important;
        print-color-adjust: exact;
      }
    }
  </style>
@endsection --}}