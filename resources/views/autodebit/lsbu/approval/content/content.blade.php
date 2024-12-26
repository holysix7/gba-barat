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
    <div class="row">
      <div class="col-sm-6">
        <div class="row" id="contentAction">
          <div class="col-sm-4">
            <a href="javascript:void(0)" class="btn btn-primary login-btn" onclick="updateStatus(true)">Approve Terpilih</a>
          </div>
          <div class="col-sm-4">
            <a href="javascript:void(0)" class="btn btn-danger login-btn" onclick="updateStatus(false)">Tolak Terpilih</a>
          </div>
        </div>
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

    $('#filterButton').on('click', function(){
      $('#contentAction').html(`
        <div class="col-sm-4">
          <a href="javascript:void(0)" class="btn btn-primary login-btn" onclick="updateStatus(true)">Approve Terpilih</a>
        </div>
        <div class="col-sm-4">
          <a href="javascript:void(0)" class="btn btn-danger login-btn" onclick="updateStatus(false)">Tolak Terpilih</a>
        </div>`
      )
      if($('#approvalType').val() == 4){
        $('#contentAction').html('')
      }
      $('#fikri-request').DataTable().clear().destroy()
      loadingData()
    })

    $('#buttonExport').on('click', function(){
      $.ajax({
        url: "{{ route('autodebit.lsbu.daftar-rekening.export') }}",
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

    var status = false
    var role = $('#roleRecordId').val() ? JSON.parse($('#roleRecordId').val()) : null
    if(role != null){
      status = true
    }
    
    var html = `<div class="w-80 ml-4 mr-4">
      <div class="row">
        <div class="col-md-12">
          <label>Username SPV</label>
          <input type="text" class="form-control" name="username" id="usernameId" placeholder="Username">
          <input type="hidden" class="form-control" name="sd_pc_dst_extacc" id="tujuanId">
          <input type="hidden" class="form-control" name="status" id="conditionId">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <label>Password SPV</label>
          <input type="password" class="form-control" name="password" id="passwordId" placeholder="Password">
        </div>
      </div>
      <div class="row" id="contentReject">
        <div class="col-md-12">
          <label>Catatan Perbaikan</label>
          <textarea class="form-control" id="rejectedNotes" name="sp_pc_rejected_notes"></textarea>
        </div>
      </div>
      <div class="row pt-2 justify-content-end">
        <div class="col-md-4">
          <a href="javascript:void(0)" class="btn btn-danger login-btn" data-dismiss="modal" aria-label="Close">Batal</a>
        </div>
        <div class="col-md-4">
          <a href="javascript:void(0)" class="btn btn-primary login-btn" id="checkingSpv">Konfirmasi</a>
        </div>
      </div>
    </div>`
    $('#contentRejected').html(html)

    $('#checkingSpv').on('click', function(){
      $.ajax({
        url: "{{ route('autodebit.lsbu.approval.checking_spv') }}",
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          id: $('#tujuanId').val(),
          username: $('#usernameId').val(),
          password: $('#passwordId').val(),
          sp_pc_rejected_notes: $('#rejectedNotes').val() ? $('#rejectedNotes').val() : null,
          approval_type: $('#approvalType').val(),
          status: $('#conditionId').val()
        },
        success: function(response){
          alert(response.message)
          if(response.type == 'berhasil'){
            window.location.replace("{{ route('autodebit.lsbu.approval') }}")
          }
        },
        error: function(error){
          alert(error)
          console.log(error)
        }
      })
    })

    $('#bulkId').on('click', function(){
      if($(this).prop('checked')){
        var checked = true
      }else{
        var checked = false
      }
      funcDestinationBulk(checked)
    })

    logActivity(JSON.stringify([
      'View', 
      'Melihat list approval',
      'savdep_product_customer_lsbu', 
      'General',
      '{{ Route::current()->getName() }}'
    ]))
  })

  function updateStatus(condition){
    var array = []
    $('.destination').each(function(k, v){
      if($(this).prop('checked')){
        array.push($(this).attr('dstacc'))
      }
    })
    var request = [
      condition,
      array
    ]
    if(condition){
      $('#contentReject').html('')
    }else{
      $('#contentReject').html(`<div class="col-md-12">
        <label>Catatan Perbaikan</label>
        <textarea class="form-control" id="rejectedNotes" name="sp_pc_rejected_notes"></textarea>
      </div>`)
    }
    console.log(array.length)
    if(array.length > 0){
      $('#rejectedPopUp').modal('show')
      $('#tujuanId').val(JSON.stringify(array))
      $('#conditionId').val(condition)
    }else{
      alert('Pilih salah satu data!')
    }
  }

  function funcDestinationBulk(condition){
    console.log(condition)
    $('.destination').each(function(k, v){
      if(condition){
        $(this).prop('checked', true)
      }else{
        $(this).prop('checked', false)
      }
    })
  }

  function removeBulk(){
    $('#bulkId').prop('checked', false)
  }

  function loadingData(){
    var table = $('#fikri-request').DataTable({
      serverSide: true,
      ajax: {
        url: "{{ route('autodebit.lsbu.approval') }}",
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          approval_type: $('#approvalType').val() ? $('#approvalType').val() : null,
          search: $('#keyword').val() != null ? $('#keyword').val() : null
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
          title: "<input type='checkbox' id='bulkId'>",
          data: 'sd_pc_dst_extacc',
          width: "3%",
          mRender: function(data, type, row){
            var checkbox = `<input type='checkbox' class='destination' dstacc='${row.sd_pc_dst_extacc}' onclick='removeBulk()'>`
            return checkbox
          }
        },
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
          title: "Approval Status",
          data: "sp_pc_approval_status",
          width: "10%",
          mRender: function(data, type, row) {
            let html      = "";
            if (row.sp_pc_approval_status == 1)
              html = `<a href="javascript:void(0)" class="btn btn-warning status-span" title="Approval Pendaftaran">Menunggu<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
            else if(row.sp_pc_approval_status == 2)
              html = `<a href="javascript:void(0)" class="btn btn-warning status-span" title="Approval Penutupan Permintaan Nasabah">Menunggu<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
            else if(row.sp_pc_approval_status == 3)
              html = `<a href="javascript:void(0)" class="btn btn-warning status-span" title="Approval Penutupan Kesalahan Data">Menunggu<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
            else if(row.sp_pc_approval_status == 4)
              html = `<a href="javascript:void(0)" class="btn btn-danger status-span" onclick="popUpNotes('${row.sp_pc_rejected_notes}', '${row.sd_pc_dst_extacc}', '${row.sp_pc_dst_name}')">Rejected<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
            else if(row.sp_pc_approval_status == 5)
              html = `<a href="javascript:void(0)" class="btn btn-warning status-span" title="Approval Perubahan Data">Menunggu<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
            else
              html = `<a href="javascript:void(0)" class="btn btn-success status-span">Approved<i class="fa fa-clock" style="padding-left: 5px;"></i></a>`;
            return html;
          }
        },
        {
          title: "Buka Rekening",
          data: 'sp_pc_reg_date',
          width: "13%",
        },
        {
          class: "text-center details-control",
          data: "sd_pc_dst_extacc",
          orderable: false,
          width: "12%",
          title: "Action",
          mRender: function(data, type, row) {
            var approveBtn = `<a href="javascript:void(0)" class="button-action" style='font-size: 28px; padding-left: 5px;'><i class="mdi mdi-check-circle" onclick="rejectModal('${row.routeapproved}', '${row.sd_pc_dst_extacc}', true)"></i></a>`
            var rejectBtn = `<a href="javascript:void(0)" class="button-action" style='font-size: 28px; padding-left: 5px;' onclick="rejectModal('${row.routerejected}', '${row.sd_pc_dst_extacc}', false)"><i class="mdi mdi-close-circle"></i></a>`
            var editBtn = `<a href="${row.routeedit}" class="button-action" style='font-size: 28px;'><i class="mdi mdi-table-edit"></i></a>`
            if(row.sp_pc_approval_status == 4){
              approveBtn = ''
              rejectBtn = ''
            }
            if(row.sp_pc_approval_status == 2 || row.sp_pc_approval_status == 3){
              editBtn = ''
            }
            return `
              <a href="${row.routeshow}" class="button-action" style='font-size: 28px;'><i class="mdi mdi-eye"></i></a>
              ${approveBtn}
              ${rejectBtn}
              ${editBtn}
            `
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
