<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="m-4">
          <div class="row m-2 mt-4 justify-content-center">
            <div class="d-flex w-50">
              <form method="POST" action="{{ route('setting.setupeq.new') }}" enctype="multipart/form-data" class="w-100">
                @csrf
                <div class="justify-content-center" id="formId">
                  <div class="row">
                    <div class="col-sm-12 form-group">
                      <label class="form-label-bold">ID EQ</label>
                      <input type="number" class="form-control" name="sd_e_id" placeholder="ID EQ">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 form-group">
                      <label class="form-label-bold">EQ Name</label>
                      <input type="text" class="form-control" name="sd_e_name" placeholder="EQ Name" required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 form-group">
                      <label class="form-label-bold">Merchant Code</label>
                      <input type="text" class="form-control" name="sd_e_merchant_code" placeholder="Merchant Code" required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6 form-group">
                      <label class="form-label-bold">Debit Code</label>
                      <input type="text" class="form-control" name="sd_e_debit_code" placeholder="Debit Code" required>
                    </div>
                    <div class="col-sm-6 form-group">
                      <label class="form-label-bold">Credit Code</label>
                      <input type="text" class="form-control" name="sd_e_credit_code" placeholder="Credit Code" required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 form-group">
                      <label class="form-label-bold">Pilih Audit</label>
                      <select class="form-control" name="sd_e_audit" required>
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 form-group">
                      <label class="form-label-bold">Pilih Branch</label>
                      <select class="form-control" name="sd_e_branch_code" required>
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 form-group">
                      <label class="form-label-bold">Pilih Supervisor</label>
                      <select class="form-control" name="sd_e_supervisor" required>
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 form-group">
                      <label class="form-label-bold">Supervisor Password</label>
                      <input type="text" class="form-control" name="sd_e_supervisor_password" placeholder="Supervisor Password" required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 form-group">
                      <label class="form-label-bold">Authority User</label>
                      <input type="text" class="form-control" name="sd_e_authority_user" placeholder="Authority User" required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 form-group">
                      <label class="form-label-bold">Description</label>
                      <textarea class="form-control" name="sd_e_description" placeholder="Authority User" rows="4" required></textarea>
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
      $('#formId').find('textarea').val('')
      alert('Seluruh input berhasil direset')
    })

    logActivity(JSON.stringify([
      'View', 
      'Melihat form tambah',
      'savdep_eq', 
      'General',
      '{{ Route::current()->getName() }}'
    ]))
  })
</script>
@endpush