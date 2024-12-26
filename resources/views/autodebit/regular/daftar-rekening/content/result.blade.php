<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12 d-flex justify-content-center">
        <h3 class="text-muted">Data Pendaftaran Berhasil Disimpan</h3>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 d-flex justify-content-center">
        <img src="{{asset('images/check.png')}}" style="width: 200px; height: 200px;">
      </div>
    </div>
    <div class="row d-flex justify-content-center">
      <div class="col-sm-4">
        <a href="{{route('autodebit.mygoals.daftar-rekening')}}" class="btn btn-danger btn-template">Verifikasi Nanti</a>
      </div>
      <div class="col-sm-4">
        <a href="{{$routeVerifNow}}" class="btn btn-primary btn-template">Verifikasi Sekarang</a>
      </div>
    </div>
  </div>
</section>

<script type='text/javascript'>
  $(document).ready(function(){
    logActivity(JSON.stringify([
      'View', 
      'Melihat hasil inputan',
      'savdep_product_customer_mygoals', 
      'General',
      '{{ Route::current()->getName() }}'
    ]))
  })
</script>