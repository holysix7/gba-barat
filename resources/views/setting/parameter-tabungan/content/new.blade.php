<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="m-4">
          <div class="row m-2 mt-4">
            <div class="d-flex w-100">
              <form method="POST" action="{{ route('setting.parametertabungan.new') }}" enctype="multipart/form-data" class="w-100">
                @csrf
                <div class="justify-content-center" id="formId">
                  <div class="row">
                    <div class="col-sm-6 form-group">
                      <label class="form-label-bold">ID</label>
                      <input type="text" class="form-control" name="sp_p_id" placeholder="ID" style="text-transform:uppercase" maxlength="16" required>
                    </div>
                    <div class="col-sm-6 form-group">
                      <label class="form-label-bold">Skema Biaya Admin</label>
                      <select class="form-control" name="sp_p_admin" id="sdPadminId">
                        <option value="">Tidak Menggunakan Kode Skema Implementasi</option>
                        @foreach($record['productSpdefs'] as $productSpdef)
                          <option value="{{$productSpdef->sd_ps_abstract_type}}">{{$productSpdef->sd_ps_abstract_type}} - {{$productSpdef->subprocess->sd_sdc_desc}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6 form-group">
                      <label class="form-label-bold">Nama Produk</label>
                      <input type="text" class="form-control" name="sp_p_name" placeholder="Nama Produk">
                    </div>
                    <div class="col-sm-6 form-group">
                      <label class="form-label-bold">Rekening Biaya Admin</label>
                      <select class="form-control" name="sp_p_admin_acc" id="accBankId">
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6 form-group">
                      <label class="form-label-bold">Nominal Min Setoran Awal</label>
                      <input type="text" class="form-control uangMasking" name="sp_p_min_init_amount" placeholder="Minimal Setoran Awal">
                    </div>
                    <div class="col-sm-6 form-group">
                      <label class="form-label-bold">Group Account</label>
                      <select class="form-control" name="sp_p_group_account">
                        @foreach($record['groupAccounts'] as $groupAccount)
                          <option value="{{$groupAccount->sd_ga_id}}">{{$groupAccount->sd_ga_name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6 form-group">
                      <label class="form-label-bold">Nominal Min Setoran Bulanan</label>
                      <input type="text" class="form-control uangMasking" name="sp_p_min_period_amount" placeholder="Minimal Setoran Periode">
                    </div>
                    <div class="col-sm-6 form-group">
                      <label class="form-label-bold">Skema Biaya Gagal Debet</label>
                      <select class="form-control" name="sp_p_period_fail_penalty" id="gagalDebetId">
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6 form-group">
                      <label class="form-label-bold">Nominal Max Setoran Bulanan</label>
                      <input type="text" class="form-control uangMasking" name="sp_p_max_period_amount" placeholder="Maximal Setoran Periode">
                    </div>
                    <div class="col-sm-6 form-group">
                      <label class="form-label-bold">Rekening Untuk Gagal Debet</label>
                      <select class="form-control" name="sp_p_period_fail_penalty_acc" id="rekeningGagalDebetId">
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6 form-group">
                      <label class="form-label-bold">Nominal Denomisasi</label>
                      <input type="text" class="form-control uangMasking" name="sp_p_denom_period_amount" placeholder="Nominal Denomisasi">
                    </div>
                    <div class="col-sm-6 form-group">
                      <label class="form-label-bold">Skema Mid-term Penalti</label>
                      <select class="form-control" name="sp_p_mid_term_penalty" id="midTermPenaltyId">
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6 form-group">
                      <label class="form-label-bold">Min Jangka Waktu</label>
                      <input type="number" class="form-control number-only" name="sp_p_min_period" placeholder="Minimal Jangka Waktu">
                    </div>
                    <div class="col-sm-6 form-group">
                      <label class="form-label-bold">Rekening Untuk Mid-term Penalti</label>
                      <select class="form-control" name="sp_p_mid_term_penalty_acc" id="rekeningMidTermPenaltyId">
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6 form-group">
                      <label class="form-label-bold">Max Jangka Waktu</label>
                      <input type="number" class="form-control" name="sp_p_max_period" placeholder="Max Jangka Waktu">
                    </div>
                    <div class="col-sm-6 form-group">
                      <label class="form-label-bold">Skema Penutupan</label>
                      <select class="form-control" name="sp_p_closing_scheme" id="skemaPenutupanId">
                      </select>
                    </div>
                  </div>
                  <div class="row d-flex">
                    <div class="col-sm-6 form-group">
                      <label class="form-label-bold">Max Gagal Autodebet</label>
                      <input type="number" class="form-control number-only" name="sp_p_max_period_fail" placeholder="Max Gagal Autodebet">
                    </div>
                    <div class="col-sm-6 form-group">
                      <label class="form-label-bold">Mata Uang</label>
                      <input type="text" class="form-control" name="sp_p_currency" value="IDR" readonly>
                    </div>
                  </div>
                  <div class="row d-flex">
                    <div class="col-sm-6 form-group">
                      <label class="form-label-bold">Fee Admin</label>
                      <input type="text" class="form-control uangMasking" name="sp_p_external_admin" placeholder="Fee Admin">
                    </div>
                    <div class="col-sm-6 form-group">
                      <label class="form-label-bold">Status</label>
                      <select class="form-control" name="sp_p_product_status">
                        <option value="1">Aktif</option>
                        <option value="2">Nonaktif</option>
                      </select>
                    </div>
                  </div>
                  <div class="row d-flex justify-content-end">
                    <div class="col-md-3">
                      <a href="javascript:void(0)" class="btn btn-danger login-btn" id="clearButton">Reset</a>
                    </div>
                    <div class="col-md-3">
                      <button type="submit" class="btn btn-primary login-btn" id="saveButton">Simpan </button>
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
</section>

<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" id="modalHeaderId">
        <h4 class="modal-title request_title" id="exampleModalLabel"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row" id="modalContentId">
          <div class="col-md-12 d-flex justify-content-end mt-4">
            <button href="javascript:void(0)" class="btn btn-danger login-btn" id="resetButton" disabled>Reset</button>
          </div> 
        </div>
      </div>
    </div>
  </div>
</div>

@push('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('#accBankId').attr(`disabled`, 'disabled')
    $('#gagalDebetId').attr(`disabled`, 'disabled')
    $('#rekeningGagalDebetId').attr(`disabled`, 'disabled')
    $('#midTermPenaltyId').attr(`disabled`, 'disabled')
    $('#rekeningMidTermPenaltyId').attr(`disabled`, 'disabled')
    $('#skemaPenutupanId').attr(`disabled`, 'disabled')
    $('#clearButton').on('click', function(){
      $('#resetButton').prop('disabled', true)
      $('#exampleModalLabel').html(`<div class="skeleton-box text-skeleton" style="width:280px"></div>`)
      $('#infoModal').modal('show')
      setTimeout(function(){
        $('#resetButton').prop('disabled', false)
        $('#exampleModalLabel').html(`Reset data yang telah diisi?`)
      }, 2000)
    })
    $('#resetButton').on('click', function(){
      $('#formId').find('input').val('')
      alert('Seluruh input berhasil direset')
    })
    $('#sdPadminId').on('change', function(){
      if($(this).val()){
        $('#accBankId').removeAttr(`disabled`)
        $('#gagalDebetId').removeAttr(`disabled`)
        $('#rekeningGagalDebetId').removeAttr(`disabled`)
        $('#midTermPenaltyId').removeAttr(`disabled`)
        $('#rekeningMidTermPenaltyId').removeAttr(`disabled`)
        $('#skemaPenutupanId').removeAttr(`disabled`)
        $.ajax({
          type: "POST",
          url: "{{route('setting.parametertabungan.ajax.form-new')}}",
          data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            type: $(this).val()
          },
          success: function(response) {
            $('#accBankId').html(`<option value="">Pilih</option>`)
            $('#gagalDebetId').html(`<option value="">Pilih</option>`)
            $('#rekeningGagalDebetId').html(`<option value="">Pilih</option>`)
            $('#midTermPenaltyId').html(`<option value="">Pilih</option>`)
            $('#rekeningMidTermPenaltyId').html(`<option value="">Pilih</option>`)
            $('#skemaPenutupanId').html(`<option value="">Pilih</option>`)
            if(response.status == 200){
              $.map(response.data, function(v, k){
                $('#accBankId').append(`
                  <option value="${v.sd_psa_int_acc}">${v.sd_psa_int_acc}</option>
                `)
                $('#rekeningGagalDebetId').append(`
                  <option value="${v.sd_psa_int_acc}">${v.sd_psa_int_acc}</option>
                `)
                $('#rekeningMidTermPenaltyId').append(`
                  <option value="${v.sd_psa_int_acc}">${v.sd_psa_int_acc}</option>
                `)
              })
              $.map(response.productSpdefs, function(v, k){
                $('#gagalDebetId').append(`
                  <option value="${v.sd_ps_abstract_type}">${v.sd_ps_abstract_type} - ${v.subprocess ? v.subprocess.sd_sdc_desc : ''}</option>
                `)
                $('#midTermPenaltyId').append(`
                  <option value="${v.sd_ps_abstract_type}">${v.sd_ps_abstract_type} - ${v.subprocess ? v.subprocess.sd_sdc_desc : ''}</option>
                `)
                $('#skemaPenutupanId').append(`
                  <option value="${v.sd_ps_abstract_type}">${v.sd_ps_abstract_type} - ${v.subprocess ? v.subprocess.sd_sdc_desc : ''}</option>
                `)
              })
            }
          },
          error: function(response) {
            console.log(response)
          }
        })
      }
    })
  })
</script>
@endpush