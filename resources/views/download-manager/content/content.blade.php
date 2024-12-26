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

<div class="modal fade" id="deleteRecord" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form action="{{ route('download-manager.delete') }}" enctype="multipart/form-data" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header" id="headerDelete">
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12" id="contentDelete">
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-12 d-flex justify-content-end">
              <button type="submit" class="btn btn-danger btn-login w-100">Hapus</button>
            </div>
          </div>
        </div>
      </div>
    </form>
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
      'savdep_download_manager', 
      'General',
      '{{ Route::current()->getName() }}'
    ]))
  })

  function loadingData(){
    var table = $('#fikri-request').DataTable({
      serverSide: true,
      ajax: {
        url: "{{ route('download-manager') }}",
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          produk_id: $('#produkId').val(),
          kategori_id: $('#kategoriId').val()
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
          data: 'rownum'
        },
        {
          title: "Kode Cabang",
          data: 'branch_code',
          width: "15%"
        },
        {
          title: "Jumlah Data",
          data: "counted_record",
          width: "15%"
        },
        {
          title: "Jenis Dokumen",
          data: "document_type",
          width: "15%"
        },
        {
          title: "Nama File",
          data: "filename",
          width: "15%"
        },
        {
          title: "Ekstensi File",
          data: "extension_file",
          width: "15%"
        },
        {
          class: "text-center details-control",
          data: "id",
          orderable: false,
          width: "5%",
          title: "Action",
          mRender: function(data, type, row) {
            var html = `<a href="${row.route}" class="button-action" style='font-size: 28px;'><i class="mdi mdi-download"></i></a>`
            if($('#deletePermission').val() == 'true'){
              html  += `<a href="javascript:void(0)" class="button-action" style='font-size: 28px;' onclick="modalFunction('${row.id}', '${row.filename}')"><i class="mdi mdi-delete"></i></a>`
            }
            return html
          }
        },
      ],
    });
  }
  function modalFunction(id, filename){
    $('#deleteRecord').modal('show')
    $('#headerDelete').html(`<h4>Hapus ${filename}</h4>`)
    $('#contentDelete').html(`
      <h5 style="font-size: 20px;">Apakah Anda yakin ingin menghapus dokumen ini?</h5>
      <input type="hidden" value="${id}" name="id">
    `)
  }
</script>
@endpush