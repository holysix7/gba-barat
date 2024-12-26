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
      <div class="modal-header">
        <h4 class="modal-title request_title" id="exampleModalLabel">
          <div class="skeleton-box text-skeleton" style="width:280px"></div>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <form method="POST" action="{{ route('setting.rolemanagement.update') }}" class="w-100">
            @csrf
            <input type="hidden" id="role_id" name="id">
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
            <div class="col-md-12 d-flex justify-content-end mt-4">
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

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
      'Melihat list',
      'sys_roles', 
      'General',
      '{{ Route::current()->getName() }}'
    ]))
  })

  function loadingData(){
    var table = $('#fikri-request').DataTable({
      serverSide: true,
      ajax: {
        url: "{{ route('setting.rolemanagement.ajax_roles') }}",
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
      columns: [{
          title: "No",
          width: "5%",
          data: 'rownum',
          mRender: function(data, type, row) {
            return row.rownum;
          }
        },
        {
          title: "Nama Role",
          data: 'name',
          width: "15%"
        },
        {
          title: "Status",
          data: "isactive",
          width: "15%",
          mRender: function(data, type, row) {
            let html = "";
            if (row.isactive === true)
              html = `<span class="badge badge-success status-span">Aktif<i class="fa fa-check"></i></span>`;
            else
              html = `<span class="badge badge-danger status-span">Nonaktif<i class="fa fa-clock"></i></span>`;

            return html
          }
        },
        {
          class: "text-center details-control",
          data: "id",
          orderable: false,
          width: "5%",
          title: "Action",
          mRender: function(data, type, row) {
            var html
            if($('#updatePermission').val() == 'true'){
              html = `<a href="{{url('/setting/role-management/access/${row.id}')}}" class="button-action" style='font-size: 28px;'><i class="mdi mdi-magnify"></i></a>`
            }
            if($('#deletePermission').val() == 'true'){
              html  += `<a href="javascript:void(0)" class="button-action" style='font-size: 28px;' onclick="modalEdit('${row.id}')"><i class="mdi mdi-tooltip-edit"></i></a>`
            }
            return html
          }
        },
      ],
    });
  }
  
  function modalEdit(id){
    $('#infoModal').modal('show');
    $.ajax({
      url: "{{ route('setting.rolemanagement.show') }}",
      type: 'POST',
      data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        id: id
      },
      success: function(response){
        $('.request_title').html(`Edit Data`)
        $('#role_id').val(response.id)
        $('#label1').html(`<label>Nama</label>`)
        $('#input1').html(`<input class="form-control" name="name" value="${response.name}">`)
        $('#label2').html(`<label class="mt-2">Status</label>`)
        $('#input2').html(`<select class="form-control" name="isactive" value="${response.isactive}">
          <option value="1" ${response.isactive == true ? 'selected' : ''}>Aktif</option>
          <option value="0" ${response.isactive == false ? 'selected' : ''}>Nonaktif</option>
          </select>`)
        $('#type').val('1')
      }
    })
  }
</script>
@endpush