<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="m-4">
        <form action="{{ route('autodebit.lsbu.approval.edit', Crypt::encrypt($record->sd_pc_dst_extacc)) }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-sm-6">
              <h4>Informasi Rekening Sumber</h4>
            </div>
            <div class="col-sm-6">
              <h4>Informasi Autodebit</h4>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-5 mt-1">
                  <label>Jenis Produk</label>
                </div>
                <div class="col-sm-7">
                  <input type="text" class="form-control" value="{{ $record->sd_pc_pid }}" readonly>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-5 mt-1">
                  <label>Tanggal Registrasi</label>
                </div>
                <div class="col-sm-7">
                  <input type="text" class="form-control" value="{{ $record->sp_pc_reg_date }}" readonly>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-5 mt-1">
                  <label>Nomor Rekening Sumber</label>
                </div>
                <div class="col-sm-7">
                  <input type="text" class="form-control" value="{{ $record->sd_pc_src_extacc }}" readonly>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-5 mt-1">
                  <label>Tanggal Penutupan</label>
                </div>
                <div class="col-sm-7">
                  <input type="text" class="form-control" value="{{ $record->sp_pc_settle_date_format }}" readonly>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-5 mt-1">
                  <label>Nama Rekening Sumber</label>
                </div>
                <div class="col-sm-7">
                  <input type="text" class="form-control" value="{{ $record->sp_pc_src_name }}" readonly>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-5 mt-1">
                  <label>Tanggal Debet</label>
                </div>
                <div class="col-sm-7">
                  <select class="form-control" name="sp_pc_period_date" id="tglId" required>
                    @foreach($days as $day)
                      <option value="{{ $day }}" {{ $day == $record->sp_pc_period_date ? 'selected' : '' }}>{{ $day }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-4 justify-content-end">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-5 mt-1">
                  <label>Setoran Bulanan</label>
                </div>
                <div class="col-sm-7">
                  <input type="hidden" id="minSetoranBulananId" value="{{ $recordProduct->sp_p_min_period_amount }}">
                  <input type="hidden" id="maxSetoranBulananId" value="{{ $recordProduct->sp_p_max_period_amount }}">
                  <input type="text" class="form-control uangMasking" name="sp_pc_period_amount" value="{{ $record->sp_pc_period_amount }}" onchange="validationForm('sb')" id="amountId" required>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-4 justify-content-end">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-5 mt-1">
                  <label>Jangka Waktu</label>
                </div>
                <div class="col-sm-7">
                  <input type="hidden" value="{{ $recordProduct->minimalJangkaWaktu }}" id="spMinPeriod" readonly>
                  <input type="hidden" value="{{ $recordProduct->sp_p_max_period }}" id="spMaxPeriod" readonly>
                  <input type="number" class="form-control number-only-keydown" onkeydown="validateSymbol()" name="sp_pc_period" value="{{ $record->sp_pc_period }}" id="periodId" onchange="validationForm('jw')" required>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-sm-6">
              <label>Informasi Rekening</label>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-5 mt-1">
                  <label>No Rekening Tujuan</label>
                </div>
                <div class="col-sm-7">
                  <input type="text" class="form-control" value="{{ $record->sd_pc_dst_extacc }}" readonly>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-sm-6">
              <div class="row">
                <div class="col-sm-5 mt-1">
                  <label>Nama Rekening Tujuan</label>
                </div>
                <div class="col-sm-7">
                  <input type="text" class="form-control" value="{{ $record->sp_pc_dst_name }}" readonly>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-4 justify-content-end">
            <div class="col-sm-3" id="idBtn">
              <button type="submit" class="btn btn-primary login-btn">Simpan</button>
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
    $('#idBtn').html('')
    $('#tglId').on('change', function(){
      $('#idBtn').html('<button type="submit" class="btn btn-primary login-btn">Simpan</button>')
    })
  })
  function validationForm(type){
    if(type == 'sb'){
      var amount = $(`#amountId`).val().replaceAll('.', '')
      console.log(parseInt(amount))
      if(parseInt(amount) < parseInt($('#minSetoranBulananId').val())){
        alert(`Setoran bulanan minimal Rp ${$('#minSetoranBulananId').val()}`)
        $(`#amountId`).val('')
        $('#idBtn').html('')
        return false
      }
      if(parseInt(amount) > parseInt($('#maxSetoranBulananId').val())){
        alert(`Setoran bulanan maximal Rp ${$('#maxSetoranBulananId').val()}`)
        $(`#amountId`).val('')
        $('#idBtn').html('')
        return false
      }
    }else{
      if(parseInt($(`#periodId`).val()) < parseInt($('#spMinPeriod').val())){
        alert(`Jangka waktu minimal ${$('#spMinPeriod').val()} bulan`)
        $(`#periodId`).val('')
        $('#idBtn').html('')
        return false
      }
      if(parseInt($(`#periodId`).val()) > parseInt($('#spMaxPeriod').val())){
        alert(`Jangka waktu maximal ${$('#spMaxPeriod').val()} bulan`)
        $(`#periodId`).val('')
        $('#idBtn').html('')
        return false
      }
    }
    $('#idBtn').html('<button type="submit" class="btn btn-primary login-btn">Simpan</button>')
  }
</script>
@endpush