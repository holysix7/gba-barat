<section class="content">
  <div class="container-fluid">
    <div class="row">
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
                      <h4>{{ $record->sp_pc_misi_utama }}</h4>
                      <h5>{{ $record->sp_pc_period }} Bulan</h5>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row mt-4">
                    <div class="col-sm-6">
                      <h5>Telah Tercapai</h5>
                      <h4>{{ getRupiah($record->sp_pc_debet_total_amount) }}</h4>
                    </div>
                    <div class="col-sm-6 text-right">
                      <h5>Dari</h5>
                      <h4>{{ getRupiah($record->sp_pc_target_amount) }}</h4>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-sm-12">
                      <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: {{ number_format($record->saldo_tercapai) }}%;" aria-valuenow="{{ number_format($record->saldo_tercapai) }}" aria-valuemin="0" aria-valuemax="100">{{ number_format($record->saldo_tercapai) }} %</div>
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
              <div class="card border-card-lsbu-rekening">
                <div class="card-header bg-detail-lsbu-rekening-green" style="
                background-color: #2ECC71 !important;
                color: white !important;
                border-top-left-radius: 17px !important;
                border-top-right-radius: 17px !important;">
                  <div class="row">
                    <div class="col-sm-2 text-center">
                      <i class="mdi mdi-database" style="font-size: 40px;"></i>
                    </div>
                    <div class="col-sm-10">
                      <h4>Jangka Waktu Berjalan</h4>
                      <h5>{{ $record->sp_pc_period }} Bulan</h5>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row mt-4">
                    <div class="col-sm-6">
                      <h5>Autodebit telah berjalan</h5>
                      <h4>{{ $record->sp_pc_current_period }}</h4>
                    </div>
                    <div class="col-sm-6 text-right">
                      <h5>Dari</h5>
                      <h4>{{ $record->sp_pc_period }}</h4>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-sm-12">
                      <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: {{ $record->saldo_tercapai_goals }}%;" aria-valuenow="{{ $record->saldo_tercapai_goals }}" aria-valuemin="0" aria-valuemax="100">{{ intval($record->saldo_tercapai_goals) }}%</div>
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
          </div>
          <div class="row m-2 mt-4 justify-content-between">
            <div class="col-sm-5">
              <div class="row">
                <div class="col-sm-12">
                  <h3><ins>Informasi Umum Autodebit</ins></h3>
                  <div class="row">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>Status Autodebit</label>
                    </div>
                    <div class="col-sm-4">
                      @if($record->sp_pc_status == 1)
                        <span class="badge badge-success status-span" style="width: 100% !important; height: 39px !important; border-radius: 7px;">Aktif<i class="fa fa-check"></i></span>
                      @else
                        <span class="badge badge-warning status-span" style="width: 100% !important; height: 39px !important; border-radius: 7px;">Tunda &nbsp;<i class="fa fa-exclamation-triangle"></i></span>
                      @endif
                    </div>
                    <div class="col">
                      <a href="javascript:void(0)" class="btn btn-primary d-flex justify-content-between" style="width: 100% !important;" onclick="ubahFunction('{{$record->sd_pc_dst_extacc}}', '{{$record->sp_pc_status}}')"><i class="mdi mdi-tooltip-edit"></i> Ubah Status</a>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>Saldo Sukses Terdebet</label>
                    </div>
                    <div class="col-sm">
                      <input type="text" class="form-control" value="{{ getRupiah($record->sp_pc_debet_total_amount) }}" readonly>
                      <input type="hidden" class="form-control number-only" name="sp_pc_debet_total_amount" value="{{ $record->sp_pc_debet_total_amount }}">
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>Saldo Gagal Terdebet</label>
                    </div>
                    <div class="col-sm">
                      <input type="text" class="form-control" value="{{ getRupiah($record->saldo_fail_autodebet) }}" readonly>
                      <input type="hidden" class="form-control number-only" name="saldo_fail_autodebet" value="{{ $record->saldo_fail_autodebet }}">
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 mt-2">
                  <h3><ins>Informasi Rekening Sumber</ins></h3>
                  <div class="row">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>Jenis Produk</label>
                    </div>
                    <div class="col-sm">
                      <input type="text" class="form-control" value="{{ $record->sd_pc_pid }}" readonly>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>No Rekening Utama</label>
                    </div>
                    <div class="col-sm">
                      <input type="text" class="form-control" value="{{ $record->sd_pc_src_extacc }}" readonly>
                      <input type="hidden" class="form-control" value="{{ $record->sd_pc_src_extacc }}" readonly>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>Nama Rekening</label>
                    </div>
                    <div class="col-sm">
                      <input type="text" class="form-control" value="{{ $record->sp_pc_src_name }}" readonly>
                      <input type="hidden" class="form-control" value="{{ $record->sp_pc_src_name }}" readonly>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>CIF</label>
                    </div>
                    <div class="col-sm">
                      <input type="text" class="form-control" value="{{ $record->sp_pc_cif_sumber }}" readonly>
                      <input type="hidden" class="form-control" value="{{ $record->sp_pc_cif_sumber }}" readonly>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>Mata Uang</label>
                    </div>
                    <div class="col-sm">
                      <input type="text" class="form-control" value="{{ 'IDR - Indonesia Rupiah' }}" readonly>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 mt-2">
                  <h3><ins>Layanan Notifikasi</ins></h3>
                  <div class="row">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>Layanan Notifikasi</label>
                    </div>
                    <div class="col-sm">
                      <input type="text" class="form-control" value="{{ $record->sp_pc_notif_status_name }}" readonly>
                      <input type="hidden" class="form-control" name="sp_pc_notif_status" value="{{ $record->sp_pc_notif_status }}" readonly>
                    </div>
                  </div>
                  @if($record->sp_pc_notif_status > 0)
                    @if($record->sp_pc_notif_status == 1)
                      <div class="row mt-2">
                        <div class="col-sm-4 d-flex align-items-center">
                          <label>Nomor Ponsel</label>
                        </div>
                        <div class="col-sm">
                          <input type="text" class="form-control" name="sp_pc_notif_phone" value="{{ $record->sp_pc_notif_phone }}" readonly>
                        </div>
                      </div>
                    @endif
                    @if($record->sp_pc_notif_status == 2)
                      <div class="row mt-2">
                        <div class="col-sm-4 d-flex align-items-center">
                          <label>Email</label>
                        </div>
                        <div class="col-sm">
                          <input type="text" class="form-control" name="sp_pc_notif_status" value="{{ $record->sp_pc_notif_status }}" readonly>
                        </div>
                      </div>
                    @endif
                    @if($record->sp_pc_notif_status == 3)
                      <div class="row mt-2">
                        <div class="col-sm-4 d-flex align-items-center">
                          <label>Nomor Ponsel</label>
                        </div>
                        <div class="col-sm">
                          <input type="text" class="form-control" name="sp_pc_notif_phone" value="{{ $record->sp_pc_notif_phone }}" readonly>
                        </div>
                      </div>
                      <div class="row mt-2">
                        <div class="col-sm-4 d-flex align-items-center">
                          <label>Email</label>
                        </div>
                        <div class="col-sm">
                          <input type="text" class="form-control" name="sp_pc_notif_status" value="{{ $record->sp_pc_notif_status }}" readonly>
                        </div>
                      </div>
                    @endif
                  @endif
                </div>
              </div>
            </div>
            <div class="col-sm-5">
              <div class="row">
                <div class="col-sm-12">
                  <h3><ins>Informasi Rekening Tujuan</ins></h3>
                  <div class="row">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>No Rekening Tujuan</label>
                    </div>
                    <div class="col-sm">
                      <input type="text" class="form-control" value="{{ $record->sd_pc_dst_extacc }}" readonly>
                      <input type="hidden" class="form-control number-only" name="sd_pc_dst_extacc" value="{{ $record->sd_pc_dst_extacc }}">
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>Nama Rekening</label>
                    </div>
                    <div class="col-sm">
                      <input type="text" class="form-control" value="{{ $record->sp_pc_dst_name }}" readonly>
                      <input type="hidden" class="form-control number-only" name="sp_pc_dst_name" value="{{ $record->sp_pc_dst_name }}">
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>Jenis Kelamin</label>
                    </div>
                    <div class="col-sm">
                      <input type="text" class="form-control" value="{{ $record->sp_pc_gender }}" readonly>
                      <input type="hidden" class="form-control number-only" name="sp_pc_gender" value="{{ $record->sp_pc_gender }}">
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>CIF</label>
                    </div>
                    <div class="col-sm">
                      <input type="text" class="form-control" value="{{ $record->sp_pc_cif_sumber }}" readonly>
                      <input type="hidden" class="form-control number-only" name="sp_pc_cif_sumber" value="{{ $record->sp_pc_cif_sumber }}">
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>Account Type</label>
                    </div>
                    <div class="col-sm">
                      <input type="text" class="form-control" value="{{ 'EC' }}" readonly>
                      <input type="hidden" class="form-control number-only" name="sp_pc_acc_type" value="EC">
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>Mata Uang</label>
                    </div>
                    <div class="col-sm">
                      <input type="text" class="form-control" value="{{ 'IDR' }}" readonly>
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>MyGoals</label>
                    </div>
                    <div class="col-sm">
                      <input type="text" class="form-control" value="{{ $record->sp_pc_misi_utama }}" readonly>
                      <input type="hidden" class="form-control number-only" name="sp_pc_misi_utama" value="{{ $record->sp_pc_misi_utama }}">
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>Target Tabungan</label>
                    </div>
                    <div class="col-sm">
                      <input type="text" class="form-control" value="{{ getRupiah($record->sp_pc_target_amount) }}" readonly>
                      <input type="hidden" class="form-control number-only" name="sp_pc_target_amount" value="{{ $record->sp_pc_target_amount }}">
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>Setoran Awal</label>
                    </div>
                    <div class="col-sm">
                      <input type="text" class="form-control" value="{{ getRupiah($record->sp_pc_init_amount) }}" readonly>
                      <input type="hidden" class="form-control number-only" name="" value="">
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>Metode Pendebetan</label>
                    </div>
                    <div class="col-sm">
                      <input type="text" class="form-control" value="{{ $record->sp_pc_period_interval_name }}" readonly>
                      <input type="hidden" class="form-control number-only" name="sp_pc_period_interval" value="{{ $record->sp_pc_period_interval }}">
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>Setoran Berkala</label>
                    </div>
                    <div class="col-sm">
                      <input type="text" class="form-control" value="{{ getRupiah($record->sp_pc_period_amount) }}" readonly>
                      <input type="hidden" class="form-control number-only" name="sp_pc_period_amount" value="{{ $record->sp_pc_period_amount }}">
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>Jangka Waktu</label>
                    </div>
                    <div class="col-sm">
                      <input type="text" class="form-control" value="{{ $record->sp_pc_period }}" readonly>
                      <input type="hidden" class="form-control number-only" name="sp_pc_period" value="{{ $record->sp_pc_period }}">
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>Tanggal/Hari Debet</label>
                    </div>
                    <div class="col-sm">
                      <input type="text" class="form-control" value="{{ $record->sp_pc_period_date }}" readonly>
                      <input type="hidden" class="form-control number-only" name="sp_pc_period_date" value="{{ $record->sp_pc_period_date }}">
                    </div>
                  </div>
                  <div class="row mt-2">
                    <div class="col-sm-4 d-flex align-items-center">
                      <label>Tanggal Lahir</label>
                    </div>
                    <div class="col-sm">
                      <input type="text" class="form-control" value="{{ $record->sp_pc_dob }}" readonly>
                      <input type="hidden" class="form-control number-only" name="sp_pc_dob" value="{{ $record->sp_pc_dob }}">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row m-2 mt-4 justify-content-between">
            <div class="col-sm-5">
              <div class="row">
                <div class="col-sm-12">
                  <a href="javascript:void(0)" class="btn btn-primary login-btn w-100" onclick="riwayatTransaksi('show')"><i class="mdi mdi-file-document" style="font-size: 20px;"></i>&nbsp; Riwayat Transaksi</a>
                </div>
              </div>
            </div>
            <div class="col-sm-5">
              <div class="row">
                @if($record->sp_pc_approval_status == 0)
                  {{-- <div class="col-sm-6">
                    <a href="{{ $record->routeEdit }}" class="btn btn-info login-btn w-100">Ubah Informasi</a>
                  </div> --}}
                  <div class="col-sm">
                    <a href="{{ $record->routeInquiry }}" class="btn btn-danger login-btn w-100">Tutup Autodebit</a>
                    {{-- <a href="{{ route('autodebit.mygoals.daftar-rekening.update_tutup', [Crypt::encrypt($record->sd_pc_dst_extacc), $record->sp_pc_approval_status]) }}" class="btn btn-danger login-btn w-100">Tutup Autodebit</a> --}}
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title request_title" id="exampleModalLabel">
          <div class="skeleton-box text-skeleton" style="width:280px"></div>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('autodebit.mygoals.daftar-rekening.update', $record->sd_pc_dst_extacc) }}" enctype="multipart/form-data" class="w-100">
          @csrf
          <div class="row mb-4">
            <div class="col-md-12">
              <div class="row pt-2">
                <div class="col-sm-6" id="nomorRekeningLabelId">
                  <div class="skeleton-box text-skeleton" style="width:180px"></div>
                </div>
                <div class="col-sm-1">:</div>
                <div class="col-sm-5" id="nomorRekeningId">
                  <div class="skeleton-box text-skeleton" style="width:180px"></div>
                </div>
              </div>
              <div class="row pt-2">
                <div class="col-sm-6" id="namaNasabahLabelId">
                  <div class="skeleton-box text-skeleton" style="width:180px"></div>
                </div>
                <div class="col-sm-1">:</div>
                <div class="col-sm-5" id="namaNasabahid">
                  <div class="skeleton-box text-skeleton" style="width:180px"></div>
                </div>
              </div>
              <div class="row pt-2">
                <div class="col-sm-6" id="statusAutodebetLabelId">
                  <div class="skeleton-box text-skeleton" style="width:180px"></div>
                </div>
                <div class="col-sm-1">:</div>
                <div class="col-sm-5" id="statusAutodebetId">
                  <div class="skeleton-box text-skeleton" style="width:180px"></div>
                </div>
              </div>
              <div class="row pt-2" id="statusContentConditionId">
              </div>
              <br>
            </div>
          </div>
          <input type="hidden" name="sd_pc_dst_extacc" id="pkIntacc">
          <input type="hidden" name="condition" value="1">
          <div class="row m-2">
            <div class="col-sm-6">
              <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" style="width: 100% !important;">Batalkan</button>
            </div>
            <div class="col-sm-6">
              <button type="submit" class="btn btn-primary" style="width: 100% !important;">Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    var labels = ["Sukses Autodebet", "Gagal Autodebet"]
    var values = [$('#successValue').val(), $('#failValue').val()]
    var colors = [
      "#06AAE9",
      "#FBB03B"
    ]
    var donutChart = new Chart($('#donutChart'), {
      type: 'doughnut',
      data: {
        labels: labels,
        datasets: [{
          backgroundColor: colors,
          data: values
        }]
      },
      options: {
        title: {
          display: true,
          text: 'Monitoring Autodebet',
          fontSize: 20
        },
        tooltips: {
          callbacks: {
            labelTextColor: function(tooltipItem, data){
              return colors[tooltipItem.index]
            },
            afterLabel: function(tooltipItem, data){
              var dataset = data['datasets'][0]
              var percent = Math.round((dataset['data'][tooltipItem['index']] / dataset['_meta'][0]['total']) * 100)
              return `(${percent} %)`
            }
          },
          backgroundColor: '#FFFFFF',
          bodyFontSize: 16,
          displayColors: true
        }
      }
    })
    
    logActivity(JSON.stringify([
      'View', 
      'Melihat rincian data',
      'savdep_product_customer_mygoals', 
      'General',
      '{{ Route::current()->getName() }}'
    ]))
  })

  function ubahFunction(sd_pc_dst_extacc, req_sp_pc_status){
    $('#infoModal').modal('show')
    
    $.ajax({
      url: "{{ route('autodebit.mygoals.daftar-rekening.ajax.show_goals') }}",
      type: 'POST',
      data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        sd_pc_dst_extacc: sd_pc_dst_extacc
      },
      success: function(res) {
        if (res) {
          const {
            sd_pc_dst_extacc,
            sp_pc_dst_name,
            sp_pc_status,
          } = res
          
          $('.request_title').html(`Ubah Status Autodebet`)
          $('#nomorRekeningLabelId').html(`<label class="form-label-bold">Nomor Rekening</label>`)
          $('#nomorRekeningId').html(`<label class="form-label-bold">${sd_pc_dst_extacc}</label>`)
          $('#namaNasabahLabelId').html(`<label class="form-label-bold">Nama Nasabah</label>`)
          $('#namaNasabahid').html(`<label class="form-label-bold">${sp_pc_dst_name}</label>`)
          $('#statusAutodebetLabelId').html(`<label class="form-label-bold">Status Autodebet</label>`)
          var conditionStatus = ''
          var statusHtml = `
              <input type="text" class="form-control" value="Tunda" readonly>
              <input type="hidden" class="form-control" name="sp_pc_status" value="5">
              <input type="hidden" name="condition_lanjut" value="0">
              <input type="hidden" name="JENIS_LANJUT" value="0">
            `
          if(req_sp_pc_status == 6){
            statusHtml = `
              <input type="text" class="form-control" value="Lanjutkan (Aktif)" readonly>
              <input type="hidden" class="form-control" name="sp_pc_status" value="1">
            `
            conditionStatus = `
              <div class="col-sm-6">
                <label>Jenis Lanjutkan</label>
              </div>
              <div class="col-sm-1">:</div>
              <div class="col-sm-5">
                <select class="form-control" name="JENIS_LANJUT">
                  <option value="1">Nominal Angsuran Bertambah, Jangka Waktu Tetap</option>
                  <option value="2">Nominal Angsuran Tetap, Jangka Waktu Bertambah</option>
                </select>
                <input type="hidden" name="condition_lanjut" value="1">
              </div>
            `
          }
          $('#statusAutodebetId').html(statusHtml)
          $('#statusContentConditionId').html(conditionStatus)
          $('#pkIntacc').val(sd_pc_dst_extacc)
          $('#statusAutodebetVal').val(sp_pc_status)
        }
      }
    })
  }
</script>
@endsection