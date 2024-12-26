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
      <div class="modal-header" id="modalHeaderId">
      </div>
      <div class="modal-body">
        <div class="row" id="modalContentId">
        </div>
      </div>
    </div>
  </div>
</div>

@push('script')
<script type="text/javascript">
  $(document).ready(function() {
    loadingData()
    
    $('#filterButton').on('click', function(){
      $('#fikri-request').DataTable().clear().destroy()
      loadingData()
    })

    logActivity(JSON.stringify([
      'View', 
      'Melihat list',
      'savdep_products', 
      'General',
      '{{ Route::current()->getName() }}'
    ]))
  })

  function loadingData(){
    var table = $('#fikri-request').DataTable({
      serverSide: true,
      ajax: {
        url: "{{ route('setting.parametertabungan') }}",
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          search: $('#keyword').val() ? $('#keyword').val() : null
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
          title: "ID",
          width: "5%",
          data: 'sd_p_id'
        },
        {
          title: "Nama Produk",
          data: 'sd_p_name',
          width: "15%"
        },
        {
          title: "Min Setoran Awal",
          data: "sp_p_min_init_amount",
          width: "15%",
          mRender: function(data, type, row){
            return `Rp ${number_format(row.sp_p_min_init_amount)}`
          }
        },
        {
          title: "Min Setoran Bulan",
          data: "sp_p_min_period_amount",
          width: "15%",
          mRender: function(data, type, row){
            return `Rp ${number_format(row.sp_p_min_period_amount)}`
          }
        },
        {
          title: "Min Periode",
          data: "sp_p_min_period",
          width: "5%"
        },
        {
          title: "Max Periode",
          data: "sp_p_max_period",
          width: "5%"
        },
        {
          title: "Fee Admin",
          data: "sp_p_external_admin",
          width: "7%",
          mRender: function(data, type, row){
            var html = "Rp 0"
            if(row.sp_p_external_admin > 0){
              html = `Rp ${number_format(row.sp_p_external_admin)}`
            }
            return html
          }
        },
        {
          title: "Status",
          data: "sp_p_product_status",
          width: "5%",
          mRender: function(data, type, row){
            var html
            if(row.sp_p_product_status == 1){
              html = '<span class="badge badge-success status-span">Aktif<i class="fa fa-check"></i></span>'
            }else{
              html = `<span class="badge badge-danger status-span">Nonaktif<i class="fa fa-clock"></i></span>`;
            }
            return html
          }
        },
        {
          class: "text-center details-control",
          data: "id",
          orderable: false,
          width: "5%",
          title: "Action",
          mRender: function(data, type, row) {
            var html
            if($('#updatePermission').val() == 'true'){
              html = `<a href="${row.route}" class="button-action" style='font-size: 28px;'><i class="mdi mdi-tooltip-edit"></i></a>`
            }
            if($('#deletePermission').val() == 'true'){
              if(row.sp_p_product_status == 1){
                html  += `<a href="javascript:void(0)" class="button-action" style='font-size: 28px;' onclick="modalFunction('${row.id}', 'delete')"><i class="mdi mdi-delete"></i></a>`
              }
            }
            return html
          }
        },
      ],
    });
  }
  
  function modalFunction(id, type){
    $('#infoModal').modal('show')
    var route = '{{ route("setting.parametertabungan.delete") }}'

    $('#modalHeaderId').html(`
      <h4 class="modal-title request_title" id="exampleModalLabel">
        <div class="skeleton-box text-skeleton" style="width:280px"></div>
      </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    `)
    $('#modalContentId').html(`
      <form method="POST" action="${route}" class="w-100">
        @csrf
        <div id="input1">
        </div>
        <div class="col-md-12 d-flex justify-content-end mt-4" id="buttonActionId">
          <button type="submit" class="btn btn-danger">Hapus</button>
        </div> 
      </form>
    `)
    $.ajax({
      url: "{{ route('setting.parametertabungan.show') }}",
      type: 'POST',
      data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        id: id
      },
      success: function(response){
        $('.request_title').html(`Apakah Anda yakin ingin menghapus data ${response.sd_p_name} ?`)
        $('#input1').html(`<input type="hidden" class="form-control" name="id" value="${response.sd_p_id}" readonly>`)
      }
    })
  }

</script>
@endpush