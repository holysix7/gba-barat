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

@push('script')
<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#fikri-request').DataTable({
      serverSide: true,
      ajax: {
        url: "{{ route('skemaproses.daftarskema') }}",
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
            title: "Kode Skema",
            data: 'kode_skema',
            width: "10%"
          },
          {
            title: "Kode Implement",
            data: 'kode_implement',
            width: "15%"
          },
          {
            title: "Kode Abstract",
            data: 'kode_abstract',
            width: "15%"
          },
          {
            title: "Deskripsi Skema",
            data: 'deskripsi_skema'
          },
          {
            title: "Type",
            data: 'type',
            width: "10%"
          },
          {
            class: "text-center details-control",
            data: "id",
            orderable: false,
            width: "10%",
            title: "Action",
            mRender: function(data, type, row) {
              return `<a href="{{ url('my-goals/show/${row.id}') }}" class="button-action" style='font-size: 28px;' onclick="getRequestHistory('${row.id}')"><i class="mdi mdi-eye"></i></a><a href="javascript:void(0)" class="button-action" style='font-size: 28px;' onclick="getRequestHistory('${row.id}')"><i class="mdi mdi-tooltip-edit"></i></a><a href="javascript:void(0)" class="button-action" style='font-size: 28px;' onclick="getRequestHistory('${row.id}')"><i class="mdi mdi-delete"></i></a>`
            }
          },
        ],
    });

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

    }
    
    $('#filterButton').on('click', function(){
      table.clear().destroy()
      table = $('#fikri-request').DataTable({
        serverSide: true,
        ajax: {
          url: "{{ route('skemaproses.daftarskema') }}",
          type: 'POST',
          data: {
            search: $('#keyword').val(),
            _token: $('meta[name="csrf-token"]').attr('content')
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
            title: "Kode Skema",
            data: 'kode_skema',
            width: "10%"
          },
          {
            title: "Kode Implement",
            data: 'kode_implement',
            width: "15%"
          },
          {
            title: "Kode Abstract",
            data: 'kode_abstract',
            width: "15%"
          },
          {
            title: "Deskripsi Skema",
            data: 'deskripsi_skema'
          },
          {
            title: "Type",
            data: 'type',
            width: "10%"
          },
          {
            class: "text-center details-control",
            data: "id",
            orderable: false,
            width: "10%",
            title: "Action",
            mRender: function(data, type, row) {
              return `<a href="{{ url('my-goals/show/${row.id}') }}" class="button-action" style='font-size: 28px;' onclick="getRequestHistory('${row.id}')"><i class="mdi mdi-eye"></i></a><a href="javascript:void(0)" class="button-action" style='font-size: 28px;' onclick="getRequestHistory('${row.id}')"><i class="mdi mdi-tooltip-edit"></i></a><a href="javascript:void(0)" class="button-action" style='font-size: 28px;' onclick="getRequestHistory('${row.id}')"><i class="mdi mdi-delete"></i></a>`
            }
          },
        ],
      });
    })
  })
</script>
@endpush