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
            <form method="POST" action="{{ route('autodebit.lsbu.daftar-rekening.new') }}" enctype="multipart/form-data" class="w-100">
              @csrf
              <div class="row">
                <div class="col-md-12"> 
                  <h4>Informasi Rekening Sumber</h4>
                </div>
              </div>
              <div class="row mt-2 justify-content-between">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Account Type</label>
                    </div>
                    <div class="col-md-1">
                      <label>:</label>
                    </div>
                    <div class="col-md-5">
                      <input type="hidden" name="sd_pc_src_intacc" value="{{ $record['data_sumber']->sd_pc_src_intacc }}">
                      <input type="hidden" name="accsrc_type" value="{{ $record['data_sumber']->accsrc_type }}">
                      <input type="hidden" name="sd_pc_src_branch" value="{{ $record['data_sumber']->sd_pc_src_branch }}">
                      <label>{{ $record['data_sumber']->accsrc_type }}</label>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-4">
                      <label>CIF</label>
                    </div>
                    <div class="col-md-1">
                      <label>:</label>
                    </div>
                    <div class="col-md-5">
                      <input type="hidden" name="accsrc_cif" value="{{ $record['data_sumber']->accsrc_cif }}">
                      <label>{{ $record['data_sumber']->accsrc_cif }}</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row justify-content-between">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Jenis Rekening</label>
                    </div>
                    <div class="col-md-1">
                      <label>:</label>
                    </div>
                    <div class="col-md-5">
                      <input type="hidden" name="accsrc_type_name" value="{{ $record['data_sumber']->accsrc_type_name }}">
                      <label>{{ $record['data_sumber']->accsrc_type_name }}</label>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Nama Pemilik Rekening</label>
                    </div>
                    <div class="col-md-1">
                      <label>:</label>
                    </div>
                    <div class="col-md-5">
                      <input type="hidden" name="sd_pc_src_name" value="{{ $record['data_sumber']->sd_pc_src_name }}">
                      <label>{{ $record['data_sumber']->sd_pc_src_name }}</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row justify-content-between">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Nomor Rekening</label>
                    </div>
                    <div class="col-md-1">
                      <label>:</label>
                    </div>
                    <div class="col-md-5">
                      <input type="hidden" name="sd_pc_src_extacc" value="{{ $record['data_sumber']->sd_pc_src_extacc }}">
                      <label>{{ $record['data_sumber']->sd_pc_src_extacc }}</label>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Mata Uang</label>
                    </div>
                    <div class="col-md-1">
                      <label>:</label>
                    </div>
                    <div class="col-md-5">
                      <input type="hidden" name="accsrc_currency" value="{{ $record['data_sumber']->accsrc_currency }}">
                      <label>{{ $record['data_sumber']->accsrc_currency }}</label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row mt-4">
                <div class="col-md-12"> 
                  <h4>Informasi Autodebit dan Rekening Tujuan</h4>
                  <input type="hidden" name="data_tujuan" value="{{ json_encode($record['data_tujuan']) }}">
                </div>
              </div>
              <table class="table table-stripped mt-2">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>No Rekening Tujuan</th>
                    <th>Nama Nasabah</th>
                    <th>Jangka Waktu (Bulan)</th>
                    <th>Setoran Bulanan</th>
                    <th>Tanggal Debet</th>
                    <th>Tanggal Registrasi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($record['data_tujuan'] as $row)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $row->sd_pc_dst_extacc }}</td>
                      <td>{{ $row->sp_pc_dst_name }}</td>
                      <td>{{ $row->sp_pc_period }} Bulan</td>
                      <td>{{ getRupiah(str_replace('.', '', $row->sp_pc_period_amount)) }}</td>
                      <td>Tanggal {{ $row->sp_pc_period_date }}</td>
                      <td>{{ $record['today'] }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              
              <div class="row d-flex justify-content-end">
                <div class="col-md-6 d-flex justify-content-between" id="btnSubmitId">
                  <a href="{{ route('autodebit.lsbu.daftar-rekening') }}" class="btn btn-danger login-btn" style="width: 48% !important;">Batalkan</a>
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
    })
  </script>
@endpush