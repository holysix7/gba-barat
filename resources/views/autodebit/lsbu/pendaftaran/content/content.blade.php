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
    $('#filterButton').on('click', function(){
      $('#fikri-request').DataTable().clear().destroy()
      loadingData()
    })

    logActivity(JSON.stringify([
      'View', 
      'Melihat list pendaftaran',
      'savdep_product_customer_lsbu', 
      'General',
      '{{ Route::current()->getName() }}'
    ]))
  })

  function loadingData(){
    var table = $('#fikri-request').DataTable({
      serverSide: true,
      ajax: {
        url: "{{ route('autodebit.lsbu.pendaftaran') }}",
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          start_date: $('#startDate').val() ? $('#startDate').val() : null,
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
      columns: [
        {
          title: "No Rekening",
          data: 'sd_pc_dst_extacc',
          width: "10%",
        },
        {
          title: "Nama Pemegang Rekening",
          data: 'sp_pc_dst_name',
          width: "17%",
        },
        {
          title: "Produk",
          data: 'sd_p_name',
          width: "7%",
          mRender: function(data, type, row){
            let name = null
            if(row.sd_p_name){
              name = row.sd_p_name
            }
            return name
          }
        },
        {
          title: "Tanggal Debet",
          data: 'sp_pc_period_date',
          width: "10%",
          mRender: function(data, type, row){
            return `Tanggal ${row.sp_pc_period_date}`
          }
        },
        {
          title: "Periode",
          data: 'sp_pc_period',
          width: "10%",
          mRender: function(data, type, row){
            return `${row.sp_pc_period} Bulan`
          }
        },
        {
          title: "Buka Rekening",
          data: 'sp_pc_reg_date',
          width: "13%",
        },
        {
          title: "Status",
          data: 'sp_pc_status',
          width: "10%",
          mRender: function(data, type, row){
            var text = null
            if (row.sp_pc_status == 0)
              html = `<a href="javascript:void(0)" class="btn btn-warning status-span" title="Approval Pendaftaran">Menunggu<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
            else if(row.sp_pc_status == 2)
              html = `<a href="javascript:void(0)" class="btn btn-info status-span" title="Approval Perubahan Status">Tutup Normal<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
            else if(row.sp_pc_status == 3)
              html = `<a href="javascript:void(0)" class="btn btn-warning status-span" title="Approval Penutupan">Mid Term 3x Gagal<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
            else if(row.sp_pc_status == 4)
              html = `<a href="javascript:void(0)" class="btn btn-info status-span" onclick="popUpNotes('${row.sp_pc_rejected_notes}', '${row.sd_pc_dst_extacc}', '${row.sp_pc_dst_name}')">Mid Term Manual<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
            else if(row.sp_pc_status == 5)
              html = `<a href="javascript:void(0)" class="btn btn-info status-span" onclick="popUpNotes('${row.sp_pc_rejected_notes}', '${row.sd_pc_dst_extacc}', '${row.sp_pc_dst_name}')">Mid Term Belum Terdebet<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
            else if(row.sp_pc_status == 9)
              html = `<a href="javascript:void(0)" class="btn btn-primary status-span" onclick="popUpNotes('${row.sp_pc_rejected_notes}', '${row.sd_pc_dst_extacc}', '${row.sp_pc_dst_name}')">Aktif Migrasi<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
            else
              html = `<a href="javascript:void(0)" class="btn btn-success status-span">Approved<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
            return html;
          }
        }
      ],
    });
  }
</script>
@endpush
