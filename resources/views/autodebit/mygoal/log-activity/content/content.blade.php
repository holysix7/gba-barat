<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="card col-sm-12">
        <div class="card-body">
          <table id="mygoals-table" class="table table-bordered table-striped"></table>
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
      $('#mygoals-table').DataTable().clear().destroy()
      loadingData()
    })

    logActivity(JSON.stringify([
      'View', 
      'Melihat list penutupan my goals',
      'cl_user_activities', 
      'General',
      '{{ Route::current()->getName() }}'
    ]))
  })

  function loadingData(){
    var table = $('#mygoals-table').DataTable({
      serverSide: true,
      ajax: {
        url: "{{ route('autodebit.mygoals.log-activity') }}",
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          branch_code: $('#branch_code').val(),
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
</script>
@endpush
