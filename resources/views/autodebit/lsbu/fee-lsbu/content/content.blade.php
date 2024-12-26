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
      'Melihat list fee lsbu',
      'savdep_product_customer_lsbu', 
      'General',
      '{{ Route::current()->getName() }}'
    ]))
  })

  function loadingData(){
    var table = $('#fikri-request').DataTable({
      serverSide: true,
      ajax: {
        url: "{{ route('autodebit.lsbu.fee-lsbu') }}",
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
          title: "No",
          data: 'rownum',
          width: "5%",
        },
        {
          title: "Tanggal dan Waktu",
          data: 'tanggal',
          width: "10%",
        },
        {
          title: "Autodebit Berhasil",
          data: 't_sukses',
          width: "10%",
          mRender: function(data, type, row){
            return `${row.t_sukses} Autodebit`
          }
        },
        {
          title: "Autodebit Gagal",
          data: 't_gagal',
          width: "10%",
          mRender: function(data, type, row){
            return `${row.t_gagal} Autodebit`
          }
        },
        {
          title: "Fee",
          data: 'fee_lsbu',
          width: "10%",
          mRender: function(data, type, row){
            return `Rp ${number_format(row.fee_lsbu)}`
          }
        }
      ],
    });
  }

  function rejectModal(route, sd_pc_dst_extacc, condition){
    $('#routeRejected').attr('action', route)
    $('#tujuanId').val(JSON.stringify([sd_pc_dst_extacc]))
    $('#conditionId').val(condition)
    if(condition){
      $('#contentReject').html('')
    }else{
      $('#contentReject').html(`<div class="col-md-12">
        <label>Catatan Perbaikan</label>
        <textarea class="form-control" id="rejectedNotes" name="sp_pc_rejected_notes"></textarea>
      </div>`)
    }
    $('#rejectedPopUp').modal('show')
  }
</script>
@endpush
