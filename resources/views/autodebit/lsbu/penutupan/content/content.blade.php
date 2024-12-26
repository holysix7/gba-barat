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
        url: "{{ route('autodebit.lsbu.penutupan') }}",
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
          title: "Tipe Penutupan",
          data: 'sd_ct_type',
          width: "10%",
          mRender: function(data, type, row){
            let html = null
            if(row.sd_ct_type == '2'){
              html = `Tutup Normal`
            }else if(row.sd_ct_type == '3'){
              html = `Mid Term Otomatis`
            }else if(row.sd_ct_type == '4'){
              html = `Mid Term Permintaan Nasabah`
            }else if(row.sd_ct_type == '5'){
              html = `Kesalahan Data`
            }
            return html
          }
        },
        {
          title: "Tanggal Penutupan",
          data: 'sd_ct_dt',
          width: "10%"
        },
        {
          class: "text-center details-control",
          data: "sd_pc_dst_extacc",
          orderable: false,
          width: "10%",
          title: "Action",
          mRender: function(data, type, row) {
              return `<a href="${row.routeshow}" class="button-action" style='font-size: 28px;' title='Lihat Detail'><i class="mdi mdi-eye"></i></a>`
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
