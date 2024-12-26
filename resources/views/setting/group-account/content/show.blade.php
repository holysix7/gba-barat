<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12 d-flex justify-content-center">
        <h4>Group Account : {{ $record->sd_ga_name }}</h4>
      </div>
    </div>
    <div class="row mt-4">
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

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Ubah Data</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <form method="POST" action="{{ route('setting.groupaccount.update-type', $record->sd_ga_id) }}" class="w-100">
            @csrf
            <input type="hidden" value="{{ $record->sd_ga_id }}" name="sd_gat_gaid">
            <div class="col-md-12">
              <div id="labelEdit1">
                <label>ID</label>
              </div>
              <div id="inputEdit1">
              </div>
            </div>
            <div class="col-md-12">
              <div id="labelEdit2">
                <label>Status</label>
              </div>
              <div id="inputEdit2">
              </div>
            </div>
            <div class="col-md-12">
              <div id="labelEdit3">
                <label>Tipe Rekening</label>
              </div>
              <div id="inputEdit3">
              </div>
            </div>
            <div class="col-md-12 d-flex justify-content-end mt-4" id="buttonActionId">
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
      'Melihat list detail group account type',
      'savdep_group_accounts', 
      'General',
      '{{ Route::current()->getName() }}'
    ]))
  })
  
  function editModalFunc(sd_gat_type, sd_gat_aid, sd_gat_type_rekening, sd_pat_acc_type){
    $('#editModal').modal('show')
    var sblmnya = `${sd_gat_aid} - ${sd_pat_acc_type}`
    $('#idSebelumnya').val(sblmnya)
    var input1 = `<select class="form-control" name="sd_gat_aid">
      @foreach($filtered as $row)
        <option value="{{ $row->sd_pat_pid }}">{{ $row->sd_pat_pid }} - {{ $row->sd_pat_acc_type }}</option>
      @endforeach
    </select>`
    // $('#inputEdit1').html(input1)
    $('#inputEdit1').html(`<input type="text" class="form-control" value="${sblmnya}" name="sd_gat_aid" readonly>`)
    $('#inputEdit2').html(`<select class="form-control" name="sd_gat_type">
      <option value="1" ${sd_gat_type == 1 ? 'selected' : ''}>Diizinkan</option>
      <option value="0" ${sd_gat_type == 0 ? 'selected' : ''}>Ditolak</option>
    </select>`)
    $('#inputEdit3').html(`<select class="form-control" name="sd_gat_type_rekening">
      <option value="1" ${sd_gat_type_rekening == 1 ? 'selected' : ''}>Sumber</option>
      <option value="2" ${sd_gat_type_rekening == 2 ? 'selected' : ''}>Tujuan</option>
    </select>`)
  }

  function modalFunction(sd_gat_type, sd_gat_aid, type){
    $('#infoModal').modal('show')
    
    var title = `Apakah Anda yakin ingin menghapus data: ${sd_gat_aid}`
    var route = '{{ route("setting.groupaccount.delete-type", $record->sd_ga_id) }}'
    $('#modalHeaderId').html(`<h4>Apakah Anda yakin ingin menghapus data ${sd_gat_aid}?</h4>`)
    $('#aId').val(sd_gat_aid)

    if(type == 'tambah'){
      title = 'Tambah Data'
      route = '{{ route("setting.groupaccount.create-type", $record->sd_ga_id) }}'
    }
    
    $('#modalHeaderId').html(`
      <h4 class="modal-title request_title" id="exampleModalLabel">
        <div class="skeleton-box text-skeleton" style="width:280px"></div>
      </h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    `)
    var content = ''
      if(type == 'delete'){
        content += `<form method="POST" action="${route}" class="w-100">
          @csrf
          <div id="hiddenId">
          </div>
          <div class="col-md-12 d-flex justify-content-end mt-4" id="buttonActionId">
          </div> 
        </form>`
      }else if(type == 'tambah'){
        content += `
        <form method="POST" action="${route}" class="w-100">
          @csrf
          <input type="hidden" value="{{ $record->sd_ga_id }}" name="sd_gat_gaid">
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
          <div class="col-md-12 d-flex justify-content-end mt-4" id="buttonActionId">
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div> 
        </form>`
      }
    
    $('#modalContentId').html(content)
    if(type == 'delete'){
      $('#buttonActionId').html(`
        <button type="submit" class="btn btn-danger">Hapus</button>
      `)
    }
    $.ajax({
      url: "{{ route('setting.groupaccount.shows-type', $record->sd_ga_id) }}",
      type: 'POST',
      data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        sd_ga_id: '{{ $record->sd_ga_id }}'
      },
      success: function(response){
        $('.request_title').html(title)
        $('#hiddenId').html(`<input type="hidden" value="${sd_gat_aid}" name="sd_gat_aid">`)
        if(type != 'delete'){
          $('#label1').html(`<label>ID</label>`)
          var input1 = `<select class="form-control" name="sd_gat_aid">`
            response.filtered.map(function(v, k){
              input1 += `<option value="${v.sd_pat_pid}">${v.sd_pat_pid} - ${v.sd_pat_acc_type}</option>`
            })
          input1 += `</select>`
          $('#input1').html(input1)
          $('#label2').html(`<label class="mt-2">Status</label>`)
          $('#input2').html(`<select class="form-control" name="sd_gat_type">
            <option value="1">Diizinkan</option>
            <option value="0">Ditolak</option>
          </select>`)
          $('#label3').html(`<label class="mt-2">Tipe Rekening</label>`)
          $('#input3').html(`<select class="form-control" name="sd_gat_type_rekening">
            <option value="1">Sumber</option>
            <option value="2">Tujuan</option>
          </select>`)
        }
      }
    })
  }

  function loadingData(){
    var table = $('#fikri-request').DataTable({
      serverSide: true,
      ajax: {
        url: "{{ $record->ajaxRoute }}",
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content')
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
          title: "ID",
          data: "sd_gat_aid",
          width: "7%"
        },
        {
          title: "Keterangan",
          data: "sd_pat_acc_type",
          width: "20%"
        },
        {
          title: "Status",
          data: "sd_gat_type",
          width: "15%",
          mRender: function(data, type, row){
            var html = 'Diizinkan'
            if(row.sd_gat_type == 0){
              html = 'Ditolak'
            }
            return html
          }
        },
        {
          title: "Tipe Rekening",
          data: "sd_gat_type_rekening",
          width: "15%",
          mRender: function(data, type, row){
            var html = 'Tujuan'
            if(row.sd_gat_type_rekening == '1'){
              html = 'Sumber'
            }
            return html
          }
        },
        {
          class: "text-center details-control",
          data: "sd_gat_gaid",
          orderable: false,
          width: "5%",
          title: "Action",
          mRender: function(data, type, row) {
            var html = ''
            if($('#updatePermission').val() == 'true'){
              html  += `<a href="javascript:void(0)" class="button-action" style='font-size: 28px;' onclick="editModalFunc('${row.sd_gat_type}', '${row.sd_gat_aid}', '${row.sd_gat_type_rekening}', '${row.sd_pat_acc_type}')"><i class="mdi mdi-tooltip-edit"></i></a>`
            }
            if($('#deletePermission').val() == 'true'){
              html  += `<a href="javascript:void(0)" class="button-action" style='font-size: 28px;' onclick="modalFunction('${row.sd_gat_type}', '${row.sd_gat_aid}', 'delete')"><i class="mdi mdi-delete"></i></a>`
            }
            return html
          }
        },
      ],
    });
  }
</script>
@endpush