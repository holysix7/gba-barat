<section class="content">
  <input type="hidden" value="{{$role}}" id="roleRecordId">
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

<div class="modal fade" id="rejectedPopUp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body" id="contentRejected">
      </div>
    </div>
  </div>
</div>

@push('script')
<script type="text/javascript">
  $(document).ready(function() {
    loadingData()

    $('#resetButton').on('click', function(){
      $('#approvalType').val("1")
      $('.cari').val('')
      $('#fikri-request').DataTable().clear().destroy()
      loadingData()
    })

    $('#filterButton').on('click', function(){
      $('#fikri-request').DataTable().clear().destroy()
      loadingData()
    })

    $('#buttonExport').on('click', function(){
      $.ajax({
        url: "{{ route('autodebit.mygoals.pendaftaran.export') }}",
        type: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          search: $('#keyword').val(),
          status_category: $('#statusCategory').val()
        },
        success: function(response){
          console.log(response)
        }
      })
    })

    $('#endDate').on('change', function(){
      $('#startDate').attr('max', $(this).val())
    })

    $('#startDate').on('change', function(){
      $('#endDate').attr('min', $(this).val())
    })

    $('#approvalType').on('change', function(){
      $('#endDate').attr('min', $(this).val())
    })
    var status = false
    var role = $('#roleRecordId').val() ? JSON.parse($('#roleRecordId').val()) : null
    if(role != null){
      status = true
    }
    
    var html = `<div class="w-80 ml-4 mr-4">
      <div class="row">
        <div class="col-md-12">
          <label>Username</label>
          <input type="text" class="form-control" name="username" id="usernameId" placeholder="Username">
          <input type="hidden" class="form-control" name="sd_pc_dst_extacc" id="myGoalsId" >
          <input type="hidden" class="form-control" name="sp_pc_jenis_lanjut" id="jenisLanjut" >
          <input type="hidden" class="form-control" name="status" id="conditionId">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <label>Password</label>
          <input type="password" class="form-control" name="password" id="passwordId" placeholder="Password">
        </div>
      </div>
      <div class="row" id="contentRejectGjd">
      </div>
      <div class="row pt-2">
        <div class="col-md-12 d-flex justify-content-end">
          <a href="javascript:void(0)" class="btn btn-primary" id="checkingSpv">Konfirmasi</a>
        </div>
      </div>
    </div>`
    
    // if(status == true){
    //   html = `<form action="" id="routeRejected" method="GET" enctype="multipart/form-data" class="w-80 ml-4 mr-4">
    //     @csrf
    //     <div class="row">
    //       <div class="col-md-12">
    //         <label>Catatan Perbaikan</label>
    //         <textarea class="form-control" id="rejectedNotes" name="sd_pc_rejected_notes"></textarea>
    //       </div>
    //     </div>
    //     <div class="row pt-2">
    //       <div class="col-md-12 d-flex justify-content-end">
    //         <button type="submit" class="btn btn-primary">Konfirmasi</button>
    //       </div>
    //     </div>
    //   </form>`
    // }
    $('#contentRejected').html(html)

    $('#checkingSpv').on('click', function(){
      $.ajax({
        url: "{{ route('autodebit.mygoals.approval.checking_spv') }}",
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          id: $('#myGoalsId').val(),
          username: $('#usernameId').val(),
          password: $('#passwordId').val(),
          sd_pc_rejected_notes: $('#rejectedNotes').val(),
          approval_type: $('#approvalType').val(),
          sp_pc_jenis_lanjut: $('#jenisLanjut').val(),
          status: $('#conditionId').val()
        },
        success: function(response){
          console.log(response)
          alert(response.message)
          window.location.replace("{{ route('autodebit.mygoals.approval') }}");
        },
        error: function(error){
          alert(error)
        }
      })
    })
  })

  function loadingData(){
    var table = $('#fikri-request').DataTable({
      serverSide: true,
      ajax: {
        url: "{{ route('autodebit.mygoals.approval') }}",
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          approval_type: $('#approvalType').val(),
          search: $('#searchKey').val() != null ? $('#searchKey').val() : null,
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
          width: "10%"
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
          title: "Approval Status",
          data: "typeApproval",
          width: "10%",
          mRender: function(data, type, row) {
            let html      = "";
            if(row.typeApproval){
              if (row.sp_pc_approval_status == 1)
                html = `<a href="javascript:void(0)" class="btn btn-warning status-span" title="Approval Pendaftaran">Menunggu<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
              else if(row.sp_pc_approval_status == 2)
                html = `<a href="javascript:void(0)" class="btn btn-warning status-span" title="Approval Perubahan Status">Menunggu<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
              else if(row.sp_pc_approval_status == 3)
                html = `<a href="javascript:void(0)" class="btn btn-warning status-span" title="Approval Penutupan">Menunggu<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
              else if(row.sp_pc_approval_status == 4)
                html = `<a href="javascript:void(0)" class="btn btn-warning status-span" title="Approval Penutupan">Menunggu<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
                // html = `<a href="javascript:void(0)" class="btn btn-danger status-span" onclick="popUpNotes('${row.sd_pc_rejected_notes}', '${row.sd_pc_dst_extacc}', '${row.sp_pc_dst_name}')">Menunggu<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
              else
                html = `<a href="javascript:void(0)" class="btn btn-success status-span">Approved<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
            }else{
              html = `<a href="javascript:void(0)" class="btn btn-warning status-span" title="Approval Pendaftaran">Menunggu<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
            }
            return html;
          }
        },
        {
          title: "Buka Rekening",
          data: 'sp_pc_reg_date',
          width: "10%",
        },
        {
          class: "text-center details-control",
          data: "sd_pc_dst_extacc",
          orderable: false,
          width: "10%",
          title: "Action",
          mRender: function(data, type, row) {
            var showBtn     = `<a href="${row.routeshow}" class="button-action" style='font-size: 28px;'><i class="mdi mdi-eye"></i></a>`
            if(row.typeApproval){
              var approveBtn  = `<a href="javascript:void(0)" class="button-action" style='font-size: 28px; padding-left: 5px;'><i class="mdi mdi-check-circle" onclick="rejectModal('${row.routeapproved}', '${row.sd_pc_dst_extacc}', true, '${row.sp_pc_jenis_lanjut}')"></i></a>`
            }else{
              var approveBtn  = `<a href="javascript:void(0)" class="button-action" style='font-size: 28px; padding-left: 5px;'><i class="mdi mdi-check-circle" onclick="rejectModal('${row.routeapproved}', '${row.sd_pc_dst_extacc}', true, '')"></i></a>`
            }
            var rejectBtn = `<a href="javascript:void(0)" class="button-action" style='font-size: 28px; padding-left: 5px;' onclick="rejectModal('${row.routerejected}', '${row.sd_pc_dst_extacc}', false)"><i class="mdi mdi-close-circle"></i></a>`
            return `
              ${showBtn}
              ${approveBtn}
              ${rejectBtn}
            `
          }
        },
      ],
    });
  }

  function rejectModal(route, sd_pc_dst_extacc, condition, sp_pc_jenis_lanjut){
    $('#routeRejected').attr('action', route)
    $('#myGoalsId').val(sd_pc_dst_extacc)
    $('#jenisLanjut').val(sp_pc_jenis_lanjut)
    $('#conditionId').val(condition)
    console.log(condition)    
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
