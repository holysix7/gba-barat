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

@push('script')
<script type="text/javascript">
  $(document).ready(function() {
    loadingData()

    $('#resetButton').on('click', function(){
      $("input[type=date]").val("")
      $("input[type=date]").attr('min', '')
    })

    $('#filterButton').on('click', function(){
      $('#fikri-request').DataTable().clear().destroy()
      loadingData()
    })

    $('#endDate').on('change', function(){
      $('#startDate').attr('max', $(this).val())
    })

    $('#startDate').on('change', function(){
      $('#endDate').attr('min', $(this).val())
    })

    logActivity(JSON.stringify([
      'View', 
      'Melihat list laporan pendaftaran',
      'savdep_product_customer_mygoals', 
      'General',
      '{{ Route::current()->getName() }}'
    ]))
  })

  function loadingData(){
    var table = $('#fikri-request').DataTable({
      serverSide: true,
      ajax: {
        url: "{{ route('autodebit.mygoals.pendaftaran') }}",
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          start_date: $('#startDate').val() != null ? $('#startDate').val() : null,
          end_date: $('#endDate').val() != null ? $('#endDate').val() : null
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
          data: 'sd_pc_dst_extacc',
          width: "15%",
        },
        {
          title: "Nama Pemegang Rekening",
          data: 'sp_pc_dst_name',
          width: "10%",
        },
        {
          title: "Produk",
          data: 'sd_p_name',
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
          data: 'sp_pc_period_date',
          width: "15%",
          mRender: function(data, type, row){
            return `Tanggal ${row.sp_pc_period_date}`
          }
        },
        {
          title: "Periode",
          data: 'sp_pc_period',
          width: "15%",
          mRender: function(data, type, row){
            return `${row.sp_pc_period} Bulan`
          }
        },
        {
          title: "Status",
          data: "sp_pc_status",
          width: "10%",
          mRender: function(data, type, row) {
            let html = "";
            if(row.sp_pc_status == 1){
              html = `<span class="badge badge-success status-span">Aktif<i class="fa fa-check" style="padding-left: 5px;"></i></span>`;

            }else if(row.sp_pc_status == 5){
              html = `<span class="badge badge-warning status-span">Ditunda<i class="fa fa-clock" style="padding-left: 5px;"></i></span>`;
            }else{
              html = `<span class="badge badge-warning status-span">Aktif Migrasi<i class="fa fa-check" style="padding-left: 5px;"></i></span>`;
            }
            return html;
          }
        },
        {
          title: "Buka Rekening",
          data: 'sp_pc_reg_date',
          width: "10%",
        }
      ],
    })
  }
</script>
@endpush
