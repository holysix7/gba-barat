<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="m-4">
          <div class="row m-2 mt-4">
            <div class="d-flex w-100">
              <form method="POST" action="{{ route('setting.setuprekening.new') }}" enctype="multipart/form-data" class="w-100">
                @csrf
                <div class="justify-content-center">
                  <div class="row">
                    <div class="col-sm-12 form-group">
                      <label class="form-label-bold">ID</label>
                      <input type="text" class="form-control" name="sd_psa_type" placeholder="ID" style="text-transform:uppercase" maxlength="10">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 form-group">
                      <label class="form-label-bold">Kode Implement</label>
                      <input type="text" class="form-control" name="sd_psa_implement_type" placeholder="Kode Implement" maxlength="4" style="text-transform:uppercase">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 form-group">
                      <label class="form-label-bold">Internal Account</label>
                      <input type="number" class="form-control" name="sd_psa_int_acc" placeholder="Internal Account" maxlength="20">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 form-group">
                      <label class="form-label-bold">Status</label>
                      <input type="text" class="form-control" value="Aktif" readonly>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
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

@push('script')
<script type="text/javascript">
  $(document).ready(function(){
    logActivity(JSON.stringify([
      'View', 
      'Melihat form baru',
      'savdep_product_spdef_accbank', 
      'General',
      '{{ Route::current()->getName() }}'
    ]))
  })
</script>
@push('script')