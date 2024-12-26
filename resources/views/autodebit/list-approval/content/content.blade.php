<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="card col-sm-12">
        <div class="row d-flex justify-content-end" style="margin-top: 10px; margin-right: 5px;">
          <div class="col-md-4">
            <a href="javascript:void(0)" class="btn btn-primary-outline" style="width: 100%;" onclick="filterFunction()"><i class="mdi mdi-filter-outline"></i> filter</a>
          </div>
          <div class="col-md-4">
            {{-- <a href="{{route('crm.submerchant.klaim.new')}}" class="btn btn-primary" style="width: 100% !important; height: 100% !important;"><i class="mdi mdi-plus"></i> Buat Request Klaim</a> --}}
          </div>
        </div>
        <div class="card-body">
          <table id="fikri-request" class="table table-bordered table-striped"></table>
        </div>
        <!-- /.card-body -->
      </div>
    </div>
  </div>
</section>

<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title request_title" id="exampleModalLabel">
          <div class="skeleton-box text-skeleton" style="width:280px"></div>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row mb-4">
          <div class="col-md-6">
            <table width="100%">
              <tr>
                <td class="text-muted">Dibuat oleh</td>
                <td class="text-muted">:</td>
                <td class="font-weight-bold" id="dibuat">
                  <div class="skeleton-box text-skeleton" style="width:100px"></div>
                </td>
              </tr>
              <tr>
                <td class="text-muted">Nama Merchant</td>
                <td class="text-muted">:</td>
                <td class="font-weight-bold" id="nama_merchant">
                  <div class="skeleton-box text-skeleton" style="width:100px"></div>
                </td>
              </tr>
              <tr>
                <td class="text-muted">Tanggal Request</td>
                <td class="text-muted">:</td>
                <td class="font-weight-bold" id="tgl_req">
                  <div class="skeleton-box text-skeleton" style="width:100px"></div>
                </td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <table width="100%">
              <tr>
                <td class="text-muted">Jenis Request</td>
                <td class="text-muted">:</td>
                <td id="jenisRequestId">
                  <div class="skeleton-box text-skeleton" style="width:100px"></div>
                </td>
              </tr>
              <tr>
                <td class="text-muted">Tanggal Pencairan</td>
                <td class="text-muted">:</td>
                <td class="font-weight-bold" id="tanggalPencairanId">
                  <div class="skeleton-box text-skeleton" style="width:100px"></div>
                </td>
              </tr>
              <tr>
                <td class="text-muted">Jam Pencairan</td>
                <td class="text-muted">:</td>
                <td class="font-weight-bold" id="jamPencairanId">
                  <div class="skeleton-box text-skeleton" style="width:100px"></div>
                </td>
              </tr>
              <tr>
                <td class="text-muted">Status Klaim</td>
                <td class="text-muted">:</td>
                <td id="statusKlaimId">
                  <div class="skeleton-box text-skeleton" style="width:100px"></div>
                </td>
              </tr>
              <tr>
                <td class="text-muted">Catatan</td>
                <td class="text-muted">:</td>
                <td id="catatanId">
                  <div class="skeleton-box text-skeleton" style="width:100px"></div>
                </td>
              </tr>
            </table>
            <br>
          </div>
        </div>
        <div class="row m-2">
          <div class="card col-md-12">
            <h4 style="padding-left: 3px; padding-top: 11px;" id="detailKlaim"></h4>
            <div class="item-record card-body">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="filterPopup" tabindex="-1" role="dialog" aria-labelledby="filterPopupLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="title_modal">Filter Request Klaim Submerchant</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Search </label>
          <input type="text" name="search" id="searchRequestKlaimMerchant" class="form-control">
        </div>
        <hr>
        <div class="float-right">
          <button type="submit" class="btn btn-primary" id="find">Cari</button>
        </div>
      </div>
    </div>
  </div>
</div>

@push('script')
<script type="text/javascript">
  function filterFunction(params) {
    $('#filterPopup').modal('show')
  }

  function getRequestHistory(requestId) {
    let data = {
      _token: $('meta[name="csrf-token"]').attr('content'),
      search: null
    };
    $('#infoModal').modal('show');

    $('.request_title').html(`<div class="skeleton-box text-skeleton" style="width:200px"></div>`);
    $('#dibuat').html(`<div class="skeleton-box text-skeleton" style="width:100px"></div>`);
    $('#nama_merchant').html(`<div class="skeleton-box text-skeleton" style="width:120px"></div>`);
    $('#tgl_req').html(`<div class="skeleton-box text-skeleton" style="width:150px"></div>`);
    $('#detailKlaim').html(`<div class="skeleton-box text-skeleton" style="width:150px"></div>`);

    $('.item-record').html(`
      <div>
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <h5 class="text-muted">Nominal Pencairan</h5>
            </div>
            <div class="row">
              <h4 style="color: #259D40; font-size: 40px;" id="nominalId"><div class="skeleton-box text-skeleton" style="width:100px"></div></h4>
            </div>
          </div>
        </div>
        <div class="row">
          <table class="w-100 text-muted">
            <tr>
              <td>Biaya Transfer</td>
              <td>:</td>
              <td style="width: 55%"><div id="biayaTransfer"><div class="skeleton-box text-skeleton" style="width:100px"></div></div></td>
            </tr>
            <tr>
              <td>Biaya Lain-lain</td>
              <td>:</td>
              <td style="width: 55%"><div id="biayaLainLain"><div class="skeleton-box text-skeleton" style="width:100px"></div></div></td>
            </tr>
            <tr>
              <td>Tujuan Bank</td>
              <td>:</td>
              <td style="width: 55%"><div id="tujuanBank"><div class="skeleton-box text-skeleton" style="width:100px"></div></div></td>
            </tr>
            <tr>
              <td>Nomor Rekening Tujuan</td>
              <td>:</td>
              <td style="width: 55%"><div id="noRekTujuan"><div class="skeleton-box text-skeleton" style="width:100px"></div></div></td>
            </tr>
            <tr>
              <td>Nama Rekening Tujuan</td>
              <td>:</td>
              <td style="width: 55%"><div id="namaRekTujuan"><div class="skeleton-box text-skeleton" style="width:100px"></div></div></td>
            </tr>
          </table>
        </div>
      </div>`
    );

    
  }

  $(document).ready(function() {
    let data = {
      _token: $('meta[name="csrf-token"]').attr('content'),
      search: null
    };
  })
</script>

@endpush