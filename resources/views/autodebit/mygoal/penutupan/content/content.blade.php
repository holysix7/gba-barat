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
      'Melihat list laporan penutupan',
      'savdep_product_customer_mygoals', 
      'General',
      '{{ Route::current()->getName() }}'
    ]))
  })

  function loadingData(){
    var table = $('#fikri-request').DataTable({
      serverSide: true,
      ajax: {
        url: "{{ route('autodebit.mygoals.penutupan') }}",
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
          title: "Tipe Penutupan",
          data: "sp_pc_status",
          width: "10%",
          mRender: function(data, type, row) {
            let html = "";
            if(row.sp_pc_status == 2){
              html = `Jatuh Tempo`;
            }else{
              html = `3x Gagal Debet`;
            }
            return html;
          }
        },
        {
          title: "Tanggal Penutupan",
          data: 'sp_pc_reg_date',
          width: "15%"
        }
      ],
    })
  }
</script>
@endpush
