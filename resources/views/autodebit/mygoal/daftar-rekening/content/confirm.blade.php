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
              <input type="hidden" class="form-control" name="sd_pc_pid" value="{{ $record['sd_pc_pid'] }}" id="productId" readonly required>
              <input type="hidden" class="form-control" name="sd_pc_dst_name" value="{{ $record['sd_pc_dst_name'] }}" id="dstNameId" required readonly>
              <input type="hidden" class="form-control" name="sd_pc_src_extacc" value="{{ $record['sd_pc_src_extacc'] }}" id="noRekUtama">
              <input type="hidden" class="form-control" name="sd_pc_gender" value="{{ $record['sd_pc_gender'] }}" readonly id="genderId">
              <input type="hidden" class="form-control" name="sd_pc_src_name" value="{{ $record['sd_pc_src_name'] }}" id="srcNameId" required readonly>
              <input type="hidden" class="form-control" name="sd_pc_src_intacc" value="{{ $record['sd_pc_src_intacc'] }}" id="srcNameId" required readonly>
              <input type="hidden" class="form-control" name="sd_pc_src_branch" value="{{ $record['sd_pc_src_branch'] }}" id="dstCifId" required readonly>
              <input type="hidden" class="form-control" name="sd_pc_dob" value="{{ $record['sd_pc_dob'] }}" readonly required>
              <input type="hidden" class="form-control" name="sd_pc_cif_src" value="{{ $record['sd_pc_cif_src'] }}" id="srcCifId" required readonly>
              <input type="hidden" class="form-control" name="sd_pc_cif_dst" value="{{ $record['sd_pc_cif_dst'] }}" id="dstCifId" required readonly>
              <input type="hidden" class="form-control" name="account_type_src" value="{{ $record['account_type_src'] }}" id="dstCifId" required readonly>
              <input type="hidden" class="form-control" name="ACCSRC_TYPE" value="{{ $record['account_type_src'] }}" id="dstCifId" required readonly>
              <input type="hidden" class="form-control" name="ACCDST_TYPE" value="EQ" id="dstCifId" required readonly>
              <input type="hidden" class="form-control" name="mygoals" value="{{ $record['mygoals'] }}" id="dstCifId" required readonly>

              <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                  <h2>Form Konfirmasi</h2>
                </div>
              </div>
              <div class="row d-flex justify-content-between">
                <div class="col-sm-4 form-group">
                  <h3>Informasi Rekening Sumber</h3>
                </div>
                <div class="col-sm-4 form-group">
                  <h3>Informasi Rekening Tujuan</h3>
                </div>
              </div>
              <div class="row d-flex justify-content-between">
                <div class="col-sm-4 form-group">
                  <div class="row">
                    <div class="col-sm-6">
                      <label class="form-label-bold">Jenis Produk</label>
                    </div>
                    <div class="col-sm">
                      <label class="form-label-bold">: MYGOALS</label>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4 form-group">
                  <div class="row">
                    <div class="col-sm-6">
                      <label class="form-label-bold">Nama Pemilik Rekening Tujuan</label>
                    </div>
                    <div class="col-sm" id='contentDstName'>
                      <label class="form-label-bold">: {{ $record['sd_pc_dst_name'] }}</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row d-flex justify-content-between">
                <div class="col-sm-4 form-group">
                  <div class="row">
                    <div class="col-sm-6">
                      <label class="form-label-bold">Nomor Rekening Utama</label>
                    </div>
                    <div class="col-sm">
                      <label class="form-label-bold">: {{ $record['sd_pc_src_extacc'] }}</label>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4 form-group">
                  <div class="row">
                    <div class="col-sm-6">
                      <label class="form-label-bold">Jenis Kelamin</label>
                    </div>
                    <div class="col-sm" id="contentGenderId"> 
                      <label class="form-label-bold">: {{ $record['sd_pc_gender'] }}</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row d-flex justify-content-between">
                <div class="col-sm-4 form-group">
                  <div class="row">
                    <div class="col-sm-6">
                      <label class="form-label-bold">Nama Pemilik Rekening Utama</label>
                    </div>
                    <div class="col-sm" id='contentSrcName'>
                      <label class="form-label-bold">: {{ $record['sd_pc_src_name'] }}</label>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4 form-group">
                  <div class="row">
                    <div class="col-sm-6">
                      <label class="form-label-bold">Tanggal Lahir</label>
                    </div>
                    <div class="col-sm" id="contentTanggalLahir">
                      <label class="form-label-bold">: {{ $record['sd_pc_dob'] }}</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row d-flex justify-content-between">
                <div class="col-sm-4 form-group">
                  <div class="row">
                    <div class="col-sm-6">
                      <label class="form-label-bold">CIF</label>
                    </div>
                    <div class="col-sm" id='contentSrcCif'>
                      <label class="form-label-bold">: {{ $record['sd_pc_cif_src'] }}</label>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4 form-group">
                  <div class="row">
                    <div class="col-sm-6">
                      <label class="form-label-bold">CIF</label>
                    </div>
                    <div class="col-sm" id='contentDstCif'>
                      <label class="form-label-bold">: {{ $record['sd_pc_cif_dst'] }}</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row d-flex justify-content-between">
                <div class="col-sm-4 form-group">
                  <div class="row">
                    <div class="col-sm-6">
                      <label class="form-label-bold">Account Type</label>
                    </div>
                    <div class="col-sm" id="contentSrcAcc">
                      <label class="form-label-bold">: {{ $record['account_type_src'] }}</label>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4 form-group">
                  <div class="row">
                    <div class="col-sm-6">
                      <label class="form-label-bold">Account Type</label>
                    </div>
                    <div class="col-sm" id="contentDstAcc">
                      <label class="form-label-bold">: EQ</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row d-flex justify-content-between">
                <div class="col-sm-4 form-group">
                  <div class="row">
                    <div class="col-sm-6">
                      <label class="form-label-bold">Mata Uang</label>
                    </div>
                    <div class="col-sm" id="contentSrcUang">
                      <label class="form-label-bold">: IDR</label>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4 form-group">
                  <div class="row">
                    <div class="col-sm-6">
                      <label class="form-label-bold">Mata Uang</label>
                    </div>
                    <div class="col-sm" id="contentDstUang">
                      <label class="form-label-bold">: IDR</label>
                    </div>
                  </div>
                </div>
              </div>
              <hr>

              <div class="row">
                <div class="col-sm-12 form-group">
                  <table class="table table-responsive text-nowrap" id="rekeningTujuan">
                    <thead>
                      <tr>
                        <th class="text-center" style="width: 200px !important;">MyGoals</th>
                        <th class="text-center" style="width: 200px !important;">Nama Ahli Waris</th>
                        <th class="text-center" style="width: 200px !important;">Target Tabungan</th>
                        <th class="text-center" style="width: 200px !important;">Setoran Awal</th>
                        <th class="text-center" style="width: 200px !important;">Metode Pendebetan</th>
                        <th class="text-center" style="width: 200px !important;">Waktu Pendebetan</th>
                        <th class="text-center" style="width: 200px !important;">Angsuran Berkala</th>
                        <th class="text-center" style="width: 200px !important;">Jangka Waktu</th>
                        <th class="text-center" style="width: 200px !important;">Sisa Angsuran</th>
                        <th class="text-center" style="width: 200px !important;">Jenis Notifikasi</th>
                        <th class="text-center" style="width: 200px !important;">Nomor Ponsel</th>
                        <th class="text-center" style="width: 200px !important;">Email</th>
                      </tr>
                    </thead>
                    <tbody id="contentTujuanId">
                      @foreach(json_decode($record['mygoals'], true) as $mygoals)
                        <tr>
                          <th class="text-center" style="width: 200px !important;">{{ $mygoals['sd_pc_dst_extacc'] }}</th>
                          <th class="text-center" style="width: 200px !important;">{{ $mygoals['sp_pc_aim'] }}</th>
                          <th class="text-center" style="width: 200px !important;">{{ $mygoals['sp_pc_target_amount'] }}</th>
                          <th class="text-center" style="width: 200px !important;">{{ $mygoals['sp_pc_init_amount'] }}</th>
                          <th class="text-center" style="width: 200px !important;">{{ $mygoals['sp_pc_jenis_period_nama'] }}</th>
                          <th class="text-center" style="width: 200px !important;">{{ $mygoals['sp_pc_period_date_nama'] }}</th>
                          <th class="text-center" style="width: 200px !important;">{{ $mygoals['sd_pc_period_amount'] }}</th>
                          <th class="text-center" style="width: 200px !important;">{{ $mygoals['sd_pc_period'] }}</th>
                          <th class="text-center" style="width: 200px !important;">{{ $mygoals['sd_pc_period_amount_last'] }}</th>
                          <th class="text-center" style="width: 200px !important;">{{ $mygoals['sd_pc_notif_flag_nama'] }}</th>
                          <th class="text-center" style="width: 200px !important;">{{ $mygoals['sd_pc_notif_phone'] ? $mygoals['sd_pc_notif_phone'] : '-' }}</th>
                          <th class="text-center" style="width: 200px !important;">{{ $mygoals['sd_pc_notif_email'] ? $mygoals['sd_pc_notif_email'] : '-' }}</th>
                        </tr>
                      @endforeach
                    <tbody>
                  </table>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 d-flex justify-content-center" id="btnSubmitId">
                  <button type="submit" class="btn btn-primary login-btn" style="width: 48% !important;">Simpan</button>
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