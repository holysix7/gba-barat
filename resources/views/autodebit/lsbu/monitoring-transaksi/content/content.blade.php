<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="card col-sm-12">
        <input type="hidden" value="0" id="contentIdVal">
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
      if($('#contentIdVal').val() > 0){
        $('#fikri-request').DataTable().clear().destroy()
      }
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
    $('#contentIdVal').val(1)
    var table = $('#fikri-request').DataTable({
      serverSide: true,
      ajax: {
        url: "{{ route('autodebit.lsbu.monitoring-transaksi') }}",
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          search: $('#keyword').val() ? $('#keyword').val() : null,
          start_date: $('#startDate').val() ? $('#startDate').val() : null,
          end_date: $('#endDate').val() ? $('#endDate').val() : null,
          status_category: $('#statusCategory').val() ? $('#statusCategory').val() : null
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
          title: "Nomor Rekening",
          data: 'nomor_rekening',
          width: "10%",
        },
        {
          title: "Nama Pemegang Rekening",
          data: 'nama_nasabah',
          width: "10%",
        },
        {
          title: "Produk",
          data: 'produk',
          width: "10%",
        },
        {
          title: "Jumlah Terdebit",
          data: 'jumlah_debet',
          width: "10%",
          mRender: function(data, type, row){
            var result = `Rp ${number_format(row.jumlah_debet)}`
            return result
          }
        },
        {
          title: "Tanggal Autodebit",
          data: 'tanggal',
          width: "10%"
        },
        {
          title: "Keterangan",
          data: 'keterangan',
          width: "10%",
          mRender: function(data, type, row){
            var result
            if(row.status_transaksi == 'Gagal'){
              switch(row.keterangan){
                case 'KSM5363':
                  result = 'Akun tidak aktif'
                  break;

                case 'KSM0125':
                  result = 'Akun sudah diblok'
                  break;

                case 'KSM5362':
                  result = 'Akun sudah ditutup'
                  break;

                case 'KSM5417':
                  result = 'Saldo tidak cukup'
                  break;

                default:
                  result = 'Error tidak diketahui'
              }
            }else{
              result = row.keterangan
            }
            return result
          }
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
