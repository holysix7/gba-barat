<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="m-4">
          <div class="row m-2 mt-4">
            <div class="d-flex w-100">
              <form method="POST" action="{{ route('setting.rolemanagement.insert') }}" enctype="multipart/form-data" class="w-100">
                @csrf
                <div class="justify-content-center">
                  <div class="row">
                    <div class="col-sm-12 form-group">
                      <label class="form-label-bold">Nama Role</label>
                      <input type="text" class="form-control" name="name" placeholder="Nama Role">
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
      'sys_roles', 
      'General',
      '{{ Route::current()->getName() }}'
    ]))
  })
</script>
@endpush