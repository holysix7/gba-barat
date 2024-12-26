@section('style')
<link rel="stylesheet" href="{{ url('adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="m-4">
        <div class="row m-2 mt-4">
          <div class="d-flex w-100">
            <form method="POST" action="{{ route('autodebit.mygoals.daftar-rekening.confirm') }}" enctype="multipart/form-data" class="w-100">
              @csrf
              <div class="justify-content-center">
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <h3>Informasi Rekening Sumber</h3>
                  </div>
                  <div class="col-sm-6 form-group">
                    <h3>Informasi Rekening Berjangka</h3>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Jenis Produk</label>
                    <input type="text" class="form-control" value="MyGoals" readonly>
                    <input type="hidden" class="form-control" name="sd_pc_id" value="MyGoals">
                  </div>
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">No Rekening Berjangka</label>
                    <input type="number" class="form-control number-only" name="sd_pc_dst_extacc">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Jenis Tabungan</label>
                    <select class="form-control" name="">
                      <option value="Giro">Giro</option>
                    </select>
                  </div>
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Nama Pemilik Rekening Berjangka</label>
                    <input type="text" class="form-control" name="sd_pc_dst_name">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Nomor Rekening Utama</label>
                    <input type="number" class="form-control number-only" name="sd_pc_src_intacc">
                  </div>
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Jenis Kelamin</label>
                    <select class="form-control" name="sd_pc_gender">
                      <option>Pilih</option>
                      <option value="L">Laki-laki</option>
                      <option value="P">Perempuan</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Nama Pemilik Rekening Utama</label>
                    <input type="text" class="form-control" name="sd_pc_src_name">
                  </div>
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="sd_pc_dob">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">CIF Source</label>
                    <input type="text" class="form-control" name="sd_pc_cif_src">
                  </div>
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">CIF Destination</label>
                    <input type="text" class="form-control" name="sd_pc_cif_dst">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Currency</label>
                    <input type="text" class="form-control" value="IDR" id="currencyId" readonly>
                  </div>
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Currency</label>
                    <input type="text" class="form-control" value="IDR" readonly>
                  </div>
                </div>
                <div class="row d-flex justify-content-end">
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Misi Utama</label>
                    <input type="text" class="form-control" name="sd_pc_misi_utama">
                  </div>
                </div>
                <div class="row d-flex justify-content-end">
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Target Tabungan</label>
                    <input type="number" class="form-control number-only currency-format" name="sd_pc_goals_amount" id="targetTabunganId">
                  </div>
                </div>
                <div class="row d-flex justify-content-end">
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Setoran Awal</label>
                    <input type="number" class="form-control number-only currency-format" name="sd_pc_init_amount" id="setoranAwalId">
                  </div>
                </div>
                <div class="row d-flex justify-content-end">
                  <div class="col-sm-6 form-group">
                    <h3>Jangka Waktu Tabungan Berjangka</h3>
                  </div>
                </div>
                <div class="row d-flex justify-content-end">
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Interval Jatuh Tempo</label>
                    <select class="form-control" name="sd_pc_period_interval" id="intervalId">
                      <option>Pilih</option>
                      <option value="0">Bulanan</option>
                      <option value="1">Harian</option>
                      <option value="2">Mingguan</option>
                    </select>
                  </div>
                </div>
                <div class="row d-flex justify-content-end" id="contentIntervalId">
                </div>
                <div class="row d-flex justify-content-end">
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Pilih Target</label>
                    <select class="form-control" id="targetId">
                      <option>Pilih</option>
                      <option value="1">Jangka Waktu</option>
                      <option value="2">Nominal Setoran</option>
                    </select>
                  </div>
                </div>
                <div class="row d-flex justify-content-end">
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Jangka Waktu</label>
                    <input type="number" class="form-control number-only" name="sd_pc_period" id="jangkaWaktuId" readonly>
                  </div>
                </div>
                <div class="row d-flex justify-content-end">
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Setoran Berjangka</label>
                    <input type="number" class="form-control number-only currency-format" name="sd_pc_period_amount" id="setoranBerjangkaId" readonly>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12" id="btnSubmitId">
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@section('script')
  <script src="{{ url('adminlte/plugins/select2/js/select2.full.min.js') }} "></script>
	<script type="text/javascript">
    $(document).ready(function(){
      $('.select2').select2()

      $('#sdPcId').on('change', function(){
        if($(this).val()){
          $.ajax({
            url: "{{ route('get.savdep_product') }}",
            type: 'POST',
            data: {
              _token: $('meta[name="csrf-token"]').attr('content'),
              sp_p_id: $(this).val()
            },
            success: function(response){
              $('#currencyId').val(response.sp_p_currency)
            },
            error: function(error){
              alert(error)
            }
          })
        }
      })
      
      $('#targetId').on('change', function(){
        if(parseInt($(this).val()) > 0){
          if(parseInt($(this).val()) == 1){
            $('#setoranBerjangkaId').attr('readonly', true)
            $('#jangkaWaktuId').attr('readonly', false)
          }else{
            $('#jangkaWaktuId').attr('readonly', true)
            $('#setoranBerjangkaId').attr('readonly', false)
          }
        }
      })

      $('#setoranBerjangkaId').on('change', function(){
        var nominalSetoran  = parseInt($(this).val())
        var targetTabungan  = parseInt($('#targetTabunganId').val()) ? parseInt($('#targetTabunganId').val()) : 0
        var setoranAwal     = parseInt($('#setoranAwalId').val()) ? parseInt($('#setoranAwalId').val()) : 0
        var hasil           = (targetTabungan - setoranAwal) / nominalSetoran
        if(nominalSetoran % 50000 == 0){
          $('#btnSubmitId').html(`<button type="submit" class="btn btn-primary login-btn">Simpan </button>`)
        }else{
          $('#btnSubmitId').html(`<a href="javascript:void()" class="btn btn-primary login-btn" onclick="alert('Setoran Berjangka Harus Kelipatan 50.000')">Simpan </a>`)
        }
        $('#jangkaWaktuId').val(hasil)
      })

      $('#jangkaWaktuId').on('change', function(){
        var jangkaWaktu     = parseInt($(this).val())
        var targetTabungan  = parseInt($('#targetTabunganId').val()) ? parseInt($('#targetTabunganId').val()) : 0
        var setoranAwal     = parseInt($('#setoranAwalId').val()) ? parseInt($('#setoranAwalId').val()) : 0
        var hasil           = (targetTabungan - setoranAwal) / jangkaWaktu
        $('#setoranBerjangkaId').val(hasil)
      })

      $('#intervalId').on('change', function(){
        var valueInt = parseInt($(this).val())
        console.log(valueInt)
        var html
        if(valueInt == 0){
          html = `<div class="col-sm-6 form-group">
            <label class="form-label-bold">Tanggal Debet</label>
            <select class="form-control" name="sd_pc_period_date">
              <option>Pilih</option>
              @foreach($days as $day)
                <option value="{{$day}}">{{$day}}</option>
              @endforeach
            </select>
          </div>`
        }else if(valueInt == 1){
          html = ``
        }else{
          html = `<div class="col-sm-6 form-group">
            <label class="form-label-bold">Hari Debet</label>
            <select class="form-control" name="sd_pc_period_date">
              <option>Pilih</option>
              @foreach($daysName as $dayName)
                @if($dayName == '01'){
                  <option value="{{$dayName}}">Senin</option>
                @elseif($dayName == '02')
                  <option value="{{$dayName}}">Selasa</option>
                @elseif($dayName == '03')
                  <option value="{{$dayName}}">Rabu</option>
                @elseif($dayName == '04')
                  <option value="{{$dayName}}">Kamis</option>
                @elseif($dayName == '05')
                  <option value="{{$dayName}}">Jumat</option>
                @elseif($dayName == '06')
                  <option value="{{$dayName}}">Sabtu</option>
                @else
                  <option value="{{$dayName}}">Minggu</option>
                @endif
              @endforeach
            </select>
          </div>`
        }
        $('#contentIntervalId').html(html)
      })

      logActivity(JSON.stringify([
        'View', 
        'Melihat form baru',
        'savdep_product_customer_mygoals', 
        'General',
        '{{ Route::current()->getName() }}'
      ]))
    })
	</script>
@endsection