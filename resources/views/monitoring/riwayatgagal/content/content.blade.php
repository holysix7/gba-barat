<style>
  div.dataTables_filter {
    text-align: right !important;
  }
  div.dataTables_wrapper div.dataTables_length label {
    font-weight: normal;
    text-align: left;
    white-space: nowrap;
}
</style>
<section class="content">
          <div class="dataTables_wrapper dt-bootstrap4">
             <table class="table table-striped table-bordered table-hover" id="table-riwayat-sukses">
                <thead>
                  <tr>
                      <th>Action</th>
                      <th>User Name</th>
                      <th>User ID</th>
                      <th>Custcode</th>
                      <th>Email</th>
                  </tr>
                </thead>
            </table>
          </div>
        <!-- /.card-body -->
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

<div class="modal fade" id="rejectedPopUp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titleId">
          
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row mb-4">
          <div class="col-md-12">
            <label>Catatan Perbaikan</label>
            <textarea class="form-control" id="rejectedNotes" readonly></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('script')
<script type="text/javascript">
  $(document).ready(function() {
    loadingData()
    $('#resetButton').on('click', function(){
      $('#statusCategory').val("")
      $('#keyword').val("")
    })

    // $('#filterButton').on('click', function(){
    //   $('#fikri-request').DataTable().clear().destroy()
    //   loadingData()
    // })

    // $('#buttonExport').on('click', function(){
    //   $.ajax({
    //     url: "{{ route('autodebit.mygoals.daftar-rekening.export') }}",
    //     type: "POST",
    //     data: {
    //       _token: $('meta[name="csrf-token"]').attr('content'),
    //       search: $('#keyword').val(),
    //       status_category: $('#statusCategory').val()
    //     },
    //     success: function(response){
    //       console.log(response)
    //     }
    //   })
    // })
    
    logActivity(JSON.stringify([
      'View', 
      'Melihat list',
      'savdep_product_customer_mygoals', 
      'General',
      '{{ Route::current()->getName() }}'
    ]));
  });


  function loadingData(){
    var table = $('#fikri-request').DataTable({
      serverSide: true,
      ajax: {
        url: "{{ route('monitoring.transkasi.daftar-rekening') }}",
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          search: $('#keyword').val() != null ? $('#keyword').val() : null,
          status_category: $('#statusCategory').val() != null ? $('#statusCategory').val() : null
        }
      },
      paging: true,
      lengthChange: true,
      searching: false,
      ordering: false,
      info: true,
      autoWidth: false,
      responsive: true,
      dom: '<"top"fB>rt<"bottom"lip><"clear">',
      processing: true,
      buttons: [],
      oLanguage: {
        oPaginate: {
          sFirst: "Halaman Pertama",
          sPrevious: "Sebelumnya",
          sNext: "Selanjutnya",
          sLast: "Halaman Terakhir"
        }
      },
      columns: [{
          title: "No",
          width: "5%",
          data: 'rownum',
          mRender: function(data, type, row) {
            return row.rownum;
          }
        },
        {
          title: "No Rekening",
          data: 'rekening_sumber',
          width: "10%",
        },
        {
          title: "Nama Pemegang Rekening",
          data: 'rekening_sumber',
          width: "15%",
        },
        {
          title: "Produk",
          data: 'rekening_sumber',
          width: "10%",
          
        },
        {
          title: "Jumlah Terdebit",
          data: 'nominal_autodebit',
          width: "10%",
          class: 'text-right',
          mRender: function(data, type, row){
            let idr = data;
            
            return idr.toLocaleString('en-US');
          }
        },
        {
          title: "Tanggal Autodebit",
          data: 'tanggal_autodebit',
          width: "15%",
        },
      ],
    })
  }


  function popUpNotes(notes, rekNum, rekName){
    $('#rejectedNotes').html('')
    $('#titleId').html('')
    var title = `${rekNum} - ${rekName}` 
    $('#rejectedNotes').append(notes)
    $('#titleId').append(title)
    $('#rejectedPopUp').modal('show')
  }
</script>
@endpush