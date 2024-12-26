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
      'Melihat list penutupan',
      'savdep_product_customer_lsbu', 
      'General',
      '{{ Route::current()->getName() }}'
    ]))
  })

  function loadingData(){
    var table = $('#fikri-request').DataTable({
      serverSide: true,
      ajax: {
        url: "{{ route('autodebit.lsbu.log-activity') }}",
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
      columns: [
        {
          title: "UID",
          data: 'cua_by_uid',
          width: "10%",
        },
        {
          title: "Tanggal Log",
          data: 'cua_dt',
          width: "10%",
        },
        {
          title: "Work Station",
          data: 'cua_user_agent',
          width: "10%",
        },
        {
          title: "Log",
          data: 'cua_act',
          width: "10%",
        },
        {
          title: "Deskripsi",
          data: 'cua_desc',
          width: "10%"
        },
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
