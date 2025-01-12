<div class="row" style="padding: 0px 10px 10px 10px;">
  <a href="javascript:void(0)" id="buttonTambah" class="w-100 btn btn-primary-outline btn-template-tambah">
    <i class="fa fa-edit"></i>
    Buat Berita
  </a>
</div>

<div class="row" id="parentInfoWarga">
  <div class="col-sm-12">
    <div class="card timeline-info-warga">
      <h4 id="judulPostingan">{Judul Postingan}</h4>
      <p class="timeline-p" id="info">{created_at} - {created_by} (Jabatan)</p>
      <div id="descId">
        {postingan}
      </div>
    </div>
  </div>
</div>
<hr>
<div class="row d-flex justify-content-between">
  <div class="col-md-6">
    <div class="row">
      <div class="col-md-8">
        <label>Jumlah Data Per Halaman:</label>
      </div>
      <div class="col-md-2">
        <select class="form-control" value="10" id="optLimit">
          <option value="10" selected>10</option>
          <option value="15">15</option>
          <option value="25">25</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="row d-flex justify-content-end">
      <div class="col-md-6">
        <button class="w-100 btn btn-primary" id="prevBtn">
          Sebelumnya
        </button>
      </div>
      <div class="col-md-6">
        <button class="w-100 btn btn-primary" id="nextBtn">
          Selanjutnya
        </button>
      </div>
    </div>
  </div>
</div>