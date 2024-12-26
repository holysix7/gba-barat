<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="m-4">
          <div class="row m-2 mt-4">
            <div class="d-flex w-100">
              <form method="POST" action="{{ route('setting.jangkawaktu.new') }}" enctype="multipart/form-data" class="w-100">
                @csrf
                <div class="justify-content-center">
                  <div class="row">
                    <div class="col-sm-12 form-group">
                      <label class="form-label-bold">Kode Produk Period</label>
                      <input type="text" class="form-control" name="sd_pp_code" placeholder="Kode Product">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 form-group">
                      <label class="form-label-bold">Deskripsi</label>
                      <textarea type="text" class="form-control" name="sd_pp_desc" placeholder="Deskripsi" rows="4"></textarea>
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