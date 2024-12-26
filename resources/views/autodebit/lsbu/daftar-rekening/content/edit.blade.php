@section('style')
<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="m-4">
        <form action="{{ $record->routeSubmit }}" enctype="multipart/form-data" method="post">
          @csrf
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
                      <h4>{{ $record->sp_pc_current_period }} Bulan</h4>
                    </div>
                    <div class="col-sm-6 text-right">
                      <h5>Dari</h5>
                      <h4>{{ $record->sp_pc_period }} Bulan</h4>
                    </div>
                  </div>
                  <input type="hidden" value="{{ $record->sp_p_min_period }}" id="spMinPeriod">
                  <input type="hidden" value="{{ $record->sp_p_max_period }}" id="spMaxPeriod">
                  <input type="hidden" value="{{ $record->sp_p_min_period_amount }}" id="spMinAmount">
                  <input type="hidden" value="{{ $record->sp_p_max_period_amount }}" id="spMaxAmount">
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
                  <input type="text" class="form-control uangMasking" value="{{ $record->sp_pc_period_amount }}" id="setoranBulanan" name="sp_pc_period_amount" onchange="funcValidation('sb')" placeholder="{{ number_format($record->sp_pc_period_amount) }}" required>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-md-6"> 
                  <div class="row">
                    <div class="col-md-6 mt-1">
                      <label>Jangka Waktu</label>
                    </div>
                    <div class="col-md-6">
                      <input type="number" class="form-control number-only" value="{{ $record->sp_pc_period }}" min="{{ $record->minimalJangkaWaktu }}" name="sp_pc_period" onchange="funcValidation('jw')" placeholder="{{ $record->sp_pc_period }}" id="jangkaWaktuId" required>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-6 mt-1">
                      <label>Tanggal Debet</label>
                    </div>
                    <div class="col-md-6">
                      <select class="form-control" name="sp_pc_period_date" required>
                        @foreach($days as $day)
                          <option value="{{ $day }}" {{ $day == $record->sp_pc_period_date ? 'selected' : '' }}>{{ $day }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row m-2 mt-4 justify-content-end">
            <div class="col-sm-5 d-flex justify-content-end" id="btnContent">
              <button class="btn btn-primary login-btn w-50">Simpan Data</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('script')
  <script type="text/javascript">
    $(document).ready(function(){
      var minimumAmount = '{{ $record->sp_p_min_period_amount }}'
      // alert(minimumAmount)
      $('#setoranBulanan').on('change', function(){
        var amount = $(this).val().replaceAll('.', '')
        console.log(amount)
        if(parseInt(amount) < parseInt(minimumAmount)){
          alert(`Setoran bulanan tidak boleh lebih kecil dari ${minimumAmount}`)
          $(this).val(minimumAmount)
          $('#btnContent').html('')
        }else{
          $('#btnContent').html('<button class="btn btn-primary login-btn w-50">Simpan Data</button>')
        }
      })
      logActivity(JSON.stringify([
        'View', 
        'Melihat form edit',
        'savdep_product_customer_mygoals', 
        'General',
        '{{ Route::current()->getName() }}'
      ]))
    })
    
    function funcValidation(type){
      if(type == 'jw'){
        if(parseInt($(`#jangkaWaktuId`).val()) < parseInt($('#spMinPeriod').val())){
          alert(`Jangka waktu minimal ${$('#spMinPeriod').val()} bulan`)
          $(`#jangkaWaktuId`).val('')
        }
        if(parseInt($(`#jangkaWaktuId`).val()) > parseInt($('#spMaxPeriod').val())){
          alert(`Jangka waktu maximal ${$('#spMaxPeriod').val()} bulan`)
          $(`#jangkaWaktuId`).val('')
        }
      }else{
        var amount = $(`#setoranBulanan`).val().replaceAll('.', '')
        if(parseInt(amount) < parseInt($('#spMinAmount').val())){
          alert(`Setoran bulanan minimal Rp ${$('#spMinAmount').val()}`)
          $(`#setoranBulanan`).val('')
        }
        console.log(amount)
        if(parseInt(amount) > parseInt($('#spMaxAmount').val())){
          alert(`Setoran bulanan maximal Rp ${$('#spMaxAmount').val()}`)
          $(`#setoranBulanan`).val('')
        }
      }
    }
  </script>
@endpush