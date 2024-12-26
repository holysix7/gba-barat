@section('style')
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
            <form method="POST" action="{{ route('autodebit.mygoals.daftar-rekening.new') }}" enctype="multipart/form-data" class="w-100">
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
                    <input type="hidden" class="form-control" name="sd_pc_id" value="{{$record['sd_pc_id']}}">
                  </div>
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">No Rekening Berjangka</label>
                    <input type="number" class="form-control number-only" name="sd_pc_dst_extacc" value="{{$record['sd_pc_dst_extacc']}}" readonly>
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
                    <input type="text" class="form-control" name="sd_pc_dst_name" value="{{$record['sd_pc_dst_name']}}" readonly>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Nomor Rekening Utama</label>
                    <input type="number" class="form-control number-only" name="sd_pc_src_intacc" value="{{$record['sd_pc_src_intacc']}}" readonly>
                  </div>
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Jenis Kelamin</label>
                    @if($record['sd_pc_gender'])
                      @if($record['sd_pc_gender'] == 'L')
                        <input type="text" class="form-control" name="sd_pc_gender" value="Laki-laki" readonly>
                      @else
                        <input type="text" class="form-control" name="sd_pc_gender" value="Perempuan" readonly>
                      @endif
                    @endif
                    <input type="hidden" class="form-control" name="sd_pc_gender" value="{{$record['sd_pc_gender']}}">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Nama Pemilik Rekening Utama</label>
                    <input type="text" class="form-control" name="sd_pc_src_name" value="{{$record['sd_pc_src_name']}}" readonly>
                  </div>
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="sd_pc_dob" value="{{$record['sd_pc_dob']}}" readonly>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">CIF Source</label>
                    <input type="text" class="form-control" name="sd_pc_cif_src" value="{{$record['sd_pc_cif_src']}}" readonly>
                  </div>
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">CIF Destination</label>
                    <input type="text" class="form-control" name="sd_pc_cif_dst" value="{{$record['sd_pc_cif_dst']}}" readonly>
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
                    <input type="text" class="form-control" name="sd_pc_misi_utama" value="{{$record['sd_pc_misi_utama']}}" readonly>
                  </div>
                </div>
                <div class="row d-flex justify-content-end">
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Target Tabungan</label>
                    <input type="number" class="form-control number-only currency-format" name="sd_pc_goals_amount" id="targetTabunganId" value="{{$record['sd_pc_goals_amount']}}" readonly>
                  </div>
                </div>
                <div class="row d-flex justify-content-end">
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Setoran Awal</label>
                    <input type="number" class="form-control number-only currency-format" name="sd_pc_init_amount" id="setoranAwalId" value="{{$record['sd_pc_init_amount']}}" readonly>
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
                      @if($record['sd_pc_period_interval'] != null)
                        @if($record['sd_pc_period_interval'] == 0)
                          <input type="text" class="form-control" value="Bulanan" readonly>
                        @elseif($record['sd_pc_period_interval'] == 1)
                          <input type="text" class="form-control" value="Harian" readonly>
                        @else
                          <input type="text" class="form-control" value="Mingguan" readonly>
                        @endif
                      @endif
                    <input type="hidden" name="sd_pc_period_interval" value="{{$record['sd_pc_period_interval']}}" readonly>
                  </div>
                </div>
                <div class="row d-flex justify-content-end">
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Tanggal Debet</label>
                    @if($record['sd_pc_period_interval'] == 0)
                      <input class="form-control" name="sd_pc_period_date" value="{{$record['sd_pc_period_date']}}" readonly>
                    @elseif($record['sd_pc_period_interval'] == 2)
                      <input type="hidden" class="form-control" name="sd_pc_period_date" value="{{$record['sd_pc_period_date']}}" readonly>
                      @if($record['sd_pc_period_date'] == '01')
                        <input type="text" class="form-control" value="Senin" readonly>
                      @elseif($record['sd_pc_period_date'] == '02')
                        <input type="text" class="form-control" value="Selasa" readonly>
                      @elseif($record['sd_pc_period_date'] == '03')
                        <input type="text" class="form-control" value="Rabu" readonly>
                      @elseif($record['sd_pc_period_date'] == '04')
                        <input type="text" class="form-control" value="Kamis" readonly>
                      @elseif($record['sd_pc_period_date'] == '05')
                        <input type="text" class="form-control" value="Jumat" readonly>
                      @elseif($record['sd_pc_period_date'] == '06')
                        <input type="text" class="form-control" value="Sabtu" readonly>
                      @else
                        <input type="text" class="form-control" value="Minggu" readonly>
                      @endif
                    @endif
                  </div>
                </div>
                <div class="row d-flex justify-content-end">
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Jangka Waktu</label>
                    <input type="number" class="form-control number-only" name="sd_pc_period" id="jangkaWaktuId" value="{{$record['sd_pc_period']}}" readonly>
                  </div>
                </div>
                <div class="row d-flex justify-content-end">
                  <div class="col-sm-6 form-group">
                    <label class="form-label-bold">Setoran Berjangka</label>
                    <input type="number" class="form-control number-only currency-format" name="sd_pc_period_amount" id="setoranBerjangkaId" value="{{$record['sd_pc_period_amount']}}" readonly>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12" id="btnSubmitId">
                    <button type="submit" class="btn btn-primary login-btn">Simpan </button>
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
  <script type="text/javascript">
    $(document).ready(function(){
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
        'Melihat konfirmasi form',
        'savdep_product_customer_mygoals', 
        'General',
        '{{ Route::current()->getName() }}'
      ]))
    })
  </script>
@endsection