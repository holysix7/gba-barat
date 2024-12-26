
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="m-4">
        <div class="row m-2 mt-4">
          <div class="d-flex w-100">
            <form method="POST" action="{{ route('autodebit.mygoals.create') }}" enctype="multipart/form-data" class="w-100">
              @csrf
              <div class="justify-content-center">
                <div class="row">
                  <div class="col-sm-12 form-group">
                    <label class="form-label-bold">No Rekening</label>
                    <input type="number" class="form-control" name="name">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12 form-group">
                    <label class="form-label-bold">Pilih Rekening Tujuan</label>
                    <input type="text" class="form-control">
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
@section('script')
	<script type="text/javascript">
	</script>
@endsection