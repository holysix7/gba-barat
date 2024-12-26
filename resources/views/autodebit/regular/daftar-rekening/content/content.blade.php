<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="card col-sm-12">
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
    var table = $('#fikri-request').DataTable({
      serverSide: true,
      ajax: {
        url: "{{ route('autodebit.mygoals.daftar-rekening') }}",
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          search: null
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
          data: 'sd_pc_dst_extacc',
          width: "10%",
        },
        {
          title: "Nama Pemegang Rekening",
          data: 'sd_pc_dst_name',
          width: "15%",
        },
        {
          title: "Produk",
          data: 'sp_p_name',
          width: "10%",
          mRender: function(data, type, row){
            let name = null
            if(row.sp_p_name){
              name = row.sp_p_name
            }
            return name
          }
        },
        {
          title: "Tanggal Debet",
          data: 'sd_pc_period_date',
          width: "10%",
          mRender: function(data, type, row){
            return `Tanggal ${row.sd_pc_period_date}`
          }
        },
        {
          title: "Periode",
          data: 'sd_pc_period',
          width: "10%",
          mRender: function(data, type, row){
            return `${row.sd_pc_period} Bulan`
          }
        },
        {
          title: "Status Rekening",
          data: "sd_pc_status",
          width: "10%",
          mRender: function(data, type, row) {
            let html = "";
            if (row.sd_pc_status == 1)
              html = `<span class="badge badge-success status-span">Aktif<i class="fa fa-check" style="padding-left: 5px;"></i></span>`;
            else
              html = `<span class="badge badge-warning status-span">Ditunda<i class="fa fa-clock" style="padding-left: 5px;"></i></span>`;

            return html;
          }
        },
        {
          title: "Approval Status",
          data: "sd_pc_approval_status",
          width: "10%",
          mRender: function(data, type, row) {
            let html      = "";
            if (row.sd_pc_approval_status == 1)
              html = `<a href="javascript:void(0)" class="btn btn-warning status-span" title="Approval Pendaftaran">Menunggu<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
            else if(row.sd_pc_approval_status == 2)
              html = `<a href="javascript:void(0)" class="btn btn-warning status-span" title="Approval Perubahan Status">Menunggu<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
            else if(row.sd_pc_approval_status == 3)
              html = `<a href="javascript:void(0)" class="btn btn-warning status-span" title="Approval Penutupan">Menunggu<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
            else if(row.sd_pc_approval_status == 4)
              html = `<a href="javascript:void(0)" class="btn btn-danger status-span" onclick="popUpNotes('${row.sd_pc_rejected_notes}', '${row.sd_pc_dst_extacc}', '${row.sd_pc_dst_name}')">Rejected<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
            else
              html = `<a href="javascript:void(0)" class="btn btn-success status-span">Approved<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
            return html;
          }
        },
        {
          title: "Buka Rekening",
          data: 'sd_pc_reg_date',
          width: "10%",
        },
        {
          class: "text-center details-control",
          data: "id",
          orderable: false,
          width: "10%",
          title: "Action",
          mRender: function(data, type, row) {
            return `<a href="${row.routeshow}" class="button-action" style='font-size: 28px;'><i class="mdi mdi-eye"></i></a>`
            // `<a href="javascript:void(0)" class="button-action" style='font-size: 28px; padding-left: 5px;' onclick="getRequestHistory('${row.id}')"><i class="mdi mdi-tooltip-edit"></i></a>`
          }
        },
      ],
    })

    $('#resetButton').on('click', function(){
      $('#statusCategory').val("")
      $('#keyword').val("")
    })

    $('#filterButton').on('click', function(){
      table.clear().destroy()
      table = $('#fikri-request').DataTable({
        serverSide: true,
        ajax: {
          url: "{{ route('autodebit.mygoals.daftar-rekening') }}",
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
            data: 'sd_pc_dst_extacc',
            width: "10%",
          },
          {
            title: "Nama Pemegang Rekening",
            data: 'sd_pc_dst_name',
            width: "15%",
          },
          {
            title: "Produk",
            data: 'sp_p_name',
            width: "10%",
            mRender: function(data, type, row){
              let name = null
              if(row.sp_p_name){
                name = row.sp_p_name
              }
              return name
            }
          },
          {
            title: "Tanggal Debet",
            data: 'sd_pc_period_date',
            width: "10%",
            mRender: function(data, type, row){
              return `Tanggal ${row.sd_pc_period_date}`
            }
          },
          {
            title: "Periode",
            data: 'sd_pc_period',
            width: "10%",
            mRender: function(data, type, row){
              return `${row.sd_pc_period} Bulan`
            }
          },
          {
            title: "Status Rekening",
            data: "sd_pc_status",
            width: "10%",
            mRender: function(data, type, row) {
              let html = "";
              if (row.sd_pc_status == 1)
                html = `<span class="badge badge-success status-span">Aktif<i class="fa fa-check" style="padding-left: 5px;"></i></span>`;
              else
                html = `<span class="badge badge-warning status-span">Ditunda<i class="fa fa-clock" style="padding-left: 5px;"></i></span>`;

              return html;
            }
          },
          {
            title: "Approval Status",
            data: "sd_pc_approval_status",
            width: "10%",
            mRender: function(data, type, row) {
              let html      = "";
              if (row.sd_pc_approval_status == 1)
                html = `<a href="javascript:void(0)" class="btn btn-warning status-span" title="Approval Pendaftaran">Menunggu<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
              else if(row.sd_pc_approval_status == 2)
                html = `<a href="javascript:void(0)" class="btn btn-warning status-span" title="Approval Perubahan Status">Menunggu<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
              else if(row.sd_pc_approval_status == 3)
                html = `<a href="javascript:void(0)" class="btn btn-warning status-span" title="Approval Penutupan">Menunggu<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
              else if(row.sd_pc_approval_status == 4)
                html = `<a href="javascript:void(0)" class="btn btn-danger status-span" onclick="popUpNotes('${row.sd_pc_rejected_notes}', '${row.sd_pc_dst_extacc}', '${row.sd_pc_dst_name}')">Rejected<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
              else
                html = `<a href="javascript:void(0)" class="btn btn-success status-span">Approved<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
              return html;
            }
          },
          {
            title: "Buka Rekening",
            data: 'sd_pc_reg_date',
            width: "10%",
          },
          {
            class: "text-center details-control",
            data: "id",
            orderable: false,
            width: "10%",
            title: "Action",
            mRender: function(data, type, row) {
              return `<a href="${row.routeshow}" class="button-action" style='font-size: 28px;'><i class="mdi mdi-eye"></i></a>`
              // `<a href="javascript:void(0)" class="button-action" style='font-size: 28px; padding-left: 5px;' onclick="getRequestHistory('${row.id}')"><i class="mdi mdi-tooltip-edit"></i></a>`
            }
          },
        ],
      });
    })

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
    ]))
  })

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