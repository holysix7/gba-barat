<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="m-4">
          <div class="row m-2 mt-4">
            <div class="d-flex w-100">
              <form method="POST" action="{{ route('autodebit.mygoals.create', $record['id']) }}" enctype="multipart/form-data" class="w-100">
                @csrf
                <div class="justify-content-center">
                  <div class="row">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Jenis Produk</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Jenis Produk" readonly required>
                    </div>
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">No Rekening Berjangka</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="No Rekening Berjangka" readonly required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Nomor Rekening Utama</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="No Rekening Utama" readonly required>
                    </div>
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Nama Pemilik Rekening Berjangka</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Nama Pemilik Rekening Berjangka" readonly required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Nama Pemilik Rekening Utama</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Nama Pemilik Rekening Utama" readonly required>
                    </div>
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Jenis Kelamin</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Jenis Kelamin" readonly required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">CIF Source</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="CIF Source" readonly required>
                    </div>
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">CIF Destination</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="CIF Destination" readonly required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Account Type</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Account Type" readonly required>
                    </div>
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Account Type</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Account Type" readonly required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Currency</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Currency" readonly required>
                    </div>
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Currency</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Currency" readonly required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Status Auto Debet</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Status Auto Debet" readonly required>
                    </div>
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Setoran Awal</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Setoran Awal" readonly required>
                    </div>
                  </div>
                  <div class="row" style="height: 55px !important;">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Autodebet Berjalan <br> <p style="color: red; font-style: italic;">*/Bulan</p></label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Bulan Berjalan Autodebet" readonly required>
                    </div>
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Setoran Bulanan</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Setoran Bulanan" readonly required>
                    </div>
                  </div>
                  <div class="row" style="height: 55px !important;">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Gagal Autodebet</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Gagal Auto Debet" readonly required>
                    </div>
                    <div class="col-sm-6">
                      <div class="row">
                        <div class="col-sm-3 form-group pt-1">
                          <label class="form-label-bold">Tanggal Debet</label>
                        </div>
                        <div class="col-sm-3 form-group">
                          <input type="text" class="form-control" placeholder="Tanggal Debet" readonly required>
                        </div>
                        <div class="col-sm-3 form-group pt-1">
                          <label class="form-label-bold">Jangka Waktu <br> <p style="color: red; font-style: italic;">*Itungan Bulan</p></label>
                        </div>
                        <div class="col-sm-3 form-group">
                          <input type="text" class="form-control" placeholder="Jangka Waktu" readonly required>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row d-flex justify-content-end">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Tanggal Lahir</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="date" class="form-control" max="{{date('Y-m-d')}}" readonly required>
                    </div>
                  </div>
                  <div class="row d-flex justify-content-end">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Ahli Waris</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Ahli Waris" readonly required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 d-flex justify-content-end">
                      <button type="submit" class="btn btn-danger" id="saveButton">Tutup Rekening </button>
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
@section('script')
	<script type="text/javascript">
	</script>
@endsection