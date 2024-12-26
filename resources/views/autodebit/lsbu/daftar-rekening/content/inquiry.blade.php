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
            <form method="POST" action="{{ $record->formSubmit }}" enctype="multipart/form-data" class="w-100">
              @csrf
              <div class="row">
                <div class="col-md-6"> 
                  <h4>Rekening Sumber</h4>
                </div>
                <div class="col-md-6"> 
                  <h4>Informasi Autodebit</h4>
                </div>
              </div>
              <div class="row justify-content-between">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Jenis Produk</label>
                    </div>
                    <div class="col-md-1">
                      <label>:</label>
                    </div>
                    <div class="col-md-5">
                      <input type="hidden" value="{{ $record->sd_p_name }}">
                      <label>{{ $record->sd_p_name }}</label>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Tanggal Registrasi</label>
                    </div>
                    <div class="col-md-1">
                      <label>:</label>
                    </div>
                    <div class="col-md-5">
                      <input type="hidden" value="{{ $record->sp_pc_reg_date }}">
                      <label>{{ $record->tglReg }}</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row justify-content-between">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Nama Pemilik Rekening</label>
                    </div>
                    <div class="col-md-1">
                      <label>:</label>
                    </div>
                    <div class="col-md-5">
                      <input type="hidden" value="{{ $record->sp_pc_src_name }}">
                      <label>{{ $record->sp_pc_src_name }}</label>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Tanggal Mulai Autodebit</label>
                    </div>
                    <div class="col-md-1">
                      <label>:</label>
                    </div>
                    <div class="col-md-5">
                      <input type="hidden" value="{{ $record->sd_t_dt }}">
                      <label>{{ $record->tglMulai ? $record->tglMulai : '-' }}</label>
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
                      <input type="hidden" value="{{ $record->sd_pc_src_extacc }}">
                      <label>{{ $record->sd_pc_src_extacc }}</label>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Tanggal Debet</label>
                    </div>
                    <div class="col-md-1">
                      <label>:</label>
                    </div>
                    <div class="col-md-5">
                      <input type="hidden" value="{{ $record->sp_pc_period_date }}">
                      <label>{{ $record->sp_pc_period_date }}</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row justify-content-end">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Jangka Waktu</label>
                    </div>
                    <div class="col-md-1">
                      <label>:</label>
                    </div>
                    <div class="col-md-5">
                      <input type="hidden" value="{{ $record->sp_pc_period }}">
                      <label>{{ $record->transactionDone }} dari {{ $record->sp_pc_period }} Bulan</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row justify-content-end">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Setoran Bulanan</label>
                    </div>
                    <div class="col-md-1">
                      <label>:</label>
                    </div>
                    <div class="col-md-5">
                      <input type="hidden" value="{{ $record->sp_pc_period_amount }}">
                      <label>{{ getRupiah($record->sp_pc_period_amount) }}</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row justify-content-end">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Saldo Tercapai</label>
                    </div>
                    <div class="col-md-1">
                      <label>:</label>
                    </div>
                    <div class="col-md-5">
                      <label>{{ getRupiah($record->saldoTercapai) }}</label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row mt-4">
                <div class="col-md-6"> 
                  <h4>Rekening Tujuan</h4>
                </div>
                @if(!$record->tglMulai)
                  <div class="col-md-6"> 
                    <h4>Alasan Penutupan</h4>
                  </div>
                @endif
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
                      <input type="hidden" name="sd_pc_dst_extacc" value="{{ $record->sd_pc_dst_extacc }}">
                      <label>{{ $record->sd_pc_dst_extacc }}</label>
                    </div>
                  </div>
                </div>
                <input type="hidden" value="{{ $record->tglMulai ? 1 : 0 }}" name="condition_autodebit">
                @if(!$record->tglMulai)
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-md-4">
                        <label>Jenis Penutupan</label>
                      </div>
                      <div class="col-md-1">
                        <label>:</label>
                      </div>
                      <div class="col-md-5">
                        <select class="form-control" name="sp_pc_approval_status" required>
                          <option value="">Pilih</option>
                          <option value="3">Kesalahan Data</option>
                          <option value="2">Permintaan Nasabah</option>
                        </select>
                      </div>
                    </div>
                  </div>
                @endif
              </div>
              
              <div class="row justify-content-between">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-4">
                      <label>Nama Rekening</label>
                    </div>
                    <div class="col-md-1">
                      <label>:</label>
                    </div>
                    <div class="col-md-5">
                      <input type="hidden" value="{{ $record->sp_pc_dst_name }}">
                      <label>{{ $record->sp_pc_dst_name }}</label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row d-flex justify-content-end">
                <div class="col-md-6 d-flex justify-content-between" id="btnSubmitId">
                  <a href="{{ $record->routeshow }}" class="btn btn-danger login-btn" style="width: 48% !important;">Batalkan</a>
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