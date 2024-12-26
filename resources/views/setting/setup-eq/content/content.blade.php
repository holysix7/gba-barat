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

<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" id="modalHeaderId">
      </div>
      <div class="modal-body">
        <div class="row" id="modalContentId">
        </div>
      </div>
    </div>
  </div>
</div>

@push('script')
<script type="text/javascript">
  function modalFunction(sd_e_id, type){
    $('#infoModal').modal('show')
    var title = 'Delete Data'
    var route = '{{ route("setting.setupeq.delete") }}'
    if(type == 'edit'){
      title = 'Edit Data'
      route = '{{ route("setting.setupeq.edit") }}'
    }

    $('#modalHeaderId').html(`
      <h4 class="modal-title request_title" id="exampleModalLabel">
        <div class="skeleton-box text-skeleton" style="width:280px"></div>
      </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    `)
    $('#modalContentId').html(`
      <form method="POST" action="${route}" class="w-100">
        @csrf
        <div class="col-md-12">
          <div id="label1">
            <div class="skeleton-box text-skeleton" style="width:180px"></div>
          </div>
          <div id="input1">
            <div class="skeleton-box text-skeleton mt-2"></div>
          </div>
        </div>
        <div class="col-md-12">
          <div id="label2">
            <div class="skeleton-box text-skeleton mt-2" style="width:180px"></div>
          </div>
          <div id="input2">
            <div class="skeleton-box text-skeleton mt-2"></div>
          </div>
        </div>
        <div class="col-md-12">
          <div id="label3">
            <div class="skeleton-box text-skeleton mt-2" style="width:180px"></div>
          </div>
          <div id="input3">
            <div class="skeleton-box text-skeleton mt-2"></div>
          </div>
        </div>
        <div class="col-md-12">
          <div id="label4">
            <div class="skeleton-box text-skeleton mt-2" style="width:180px"></div>
          </div>
          <div id="input4">
            <div class="skeleton-box text-skeleton mt-2"></div>
          </div>
        </div>
        <div class="col-md-12">
          <div id="label5">
            <div class="skeleton-box text-skeleton mt-2" style="width:180px"></div>
          </div>
          <div id="input5">
            <div class="skeleton-box text-skeleton mt-2"></div>
          </div>
        </div>
        <div class="col-md-12 d-flex justify-content-end mt-4" id="buttonActionId">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div> 
      </form>
    `)
    if(type == 'delete'){
      $('#buttonActionId').html(`
        <button type="submit" class="btn btn-danger">Hapus</button>
      `)
    }
    $.ajax({
      url: "{{ route('setting.setupeq.show') }}",
      type: 'POST',
      data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        sd_e_id: sd_e_id
      },
      success: function(response){
          $('.request_title').html(title)
          $('#role_id').val(response.id)
          $('#label1').html(`<label>ID</label>`)
          $('#input1').html(`<input type="text" class="form-control" name="sd_e_id" value="${response.sd_e_id}" readonly>`)
          $('#label2').html(`<label class="mt-2">Nama</label>`)
          $('#input2').html(`<input type="text" class="form-control" name="sd_e_name" value="${response.sd_e_name}" readonly>`)
          $('#label3').html(`<label class="mt-2">Debit Code</label>`)
          $('#input3').html(`<input type="text" class="form-control" name="sd_e_debit_code" value="${response.sd_e_debit_code}" readonly>`)
          $('#label4').html(`<label class="mt-2">Credit Code</label>`)
          $('#input4').html(`<input type="text" class="form-control" name="sd_e_credit_code" value="${response.sd_e_credit_code}" readonly>`)
          $('#label5').html(`<label class="mt-2">Deskripsi</label>`)
          $('#input5').html(`<input type="text" class="form-control" name="sd_e_description" value="${response.sd_e_description}" readonly>`)
          if(type == 'edit'){
            $('#input2').html(`<input type="text" class="form-control" name="sd_e_name" value="${response.sd_e_name}">`)
            $('#input3').html(`<input type="text" class="form-control" name="sd_e_debit_code" value="${response.sd_e_debit_code}">`)
            $('#input4').html(`<input type="text" class="form-control" name="sd_e_credit_code" value="${response.sd_e_credit_code}">`)
            $('#input5').html(`<input type="text" class="form-control" name="sd_e_description" value="${response.sd_e_description}">`)
          }
      }
    })
  }

  $(document).ready(function() {
    loadingData()
    
    $('#filterButton').on('click', function(){
      $('#fikri-request').DataTable().clear().destroy()
      loadingData()
    })

    logActivity(JSON.stringify([
      'View', 
      'Melihat list',
      'savdep_eq', 
      'General',
      '{{ Route::current()->getName() }}'
    ]))
  })

  function loadingData(){
    var table = $('#fikri-request').DataTable({
      serverSide: true,
      ajax: {
        url: "{{ route('setting.setupeq') }}",
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          search: $('#keyword').val() ? $('#keyword').val() : null,
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
          title: "Nama",
          width: "5%",
          data: 'sd_e_name'
        },
        {
          title: "Kode Merchant",
          data: 'sd_e_merchant_code',
          width: "15%"
        },
        {
          title: "Kode Debit",
          data: "sd_e_debit_code",
          width: "15%"
        },
        {
          title: "Kode Kredit",
          data: "sd_e_credit_code",
          width: "15%"
        },
        {
          class: "text-center details-control",
          data: "sd_e_id",
          orderable: false,
          width: "5%",
          title: "Action",
          mRender: function(data, type, row) {
            var html
            if($('#updatePermission').val() == 'true'){
              html = `<a href="javascript:void(0)" class="button-action" style='font-size: 28px;' onclick="modalFunction('${row.encrypt_id}', 'edit')"><i class="mdi mdi-tooltip-edit"></i></a>`
            }
            if($('#deletePermission').val() == 'true'){
              `<a href="javascript:void(0)" class="button-action" style='font-size: 28px;' onclick="modalFunction('${row.encrypt_id}', 'delete')"><i class="mdi mdi-delete"></i></a>`
            }
            return html
          }
        },
      ],
    });
  }
</script>
@endpush