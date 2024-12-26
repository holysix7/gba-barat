@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{ url('adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<link ref="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link ref="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
<style>
  div.dataTables_filter {
    text-align: right !important;
  }
  div.dataTables_wrapper div.dataTables_length label {
    font-weight: normal;
    text-align: right;
    white-space: nowrap;
  }
</style>
@endsection

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row 2">
      <div class="col-md-6">
        <h4><b>Log </b> <label id="labelLog"></label></h4>
          <p class="text-muted"><?=$desc;?></p>    
      </div>
      <div class="col-sm-6 text-right">
        <!-- <button type="submit" class="btn btn-success mt-3 my-2" id="buttonExport" target="_blank">
          <i class="mdi mdi-export"></i>
          Export Daftar
        </button> -->
      </div>
    </div>
    <div class="row header-menu">
      <div class="col-md-12">
        <form action="{{ route('autodebit.mygoals.daftar-rekening.export') }}" enctype="multipart/form-data" method="POST">
          @csrf
          <div class="row">
            <div class="col-sm-9">
              <div class="row">
                <div class="col-sm-5">
                  <label>Kategori </label>
                </div>
                <div class="col-sm-7">
                  <label>Log/Deksripsi </label>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-9">
              <div class="row">
                <div class="col-sm-5 status">
                  <select class="form-control" name="sd_pc_status" id="statusCategory">
                    <option value="All" selected>Semua</option>
                    <option value="Create">Pendaftaran Autodebit</option>
                    <option value="Closing">Penutupan Autodebit</option>
                    <option value="Edit">Ubah Status Autodebit</option>
                    <option value="Approval">Approval Autodebit</option>
                    <option value="Export">Export Laporan</option>
                    <option value="Delete">Hapus Log Activity</option>
                  </select>
                </div>
                <div class="col-sm-7">
                  <input type="text" class="form-control" id="keyword" name="pencarian" placeholder="Masukan Keyword">
                </div>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="row text-center">
                  <button type="button" class="btn btn-primary mr-1" id="buttonLoad">
                    Tampilkan
                  </button>
                  <button type="button" class="btn btn-danger" id="buttonReset">
                    Reset
                  </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="card card-primary card-outline card-outline-tabs col-sm-12">
      <div class="row">
        <div class="card-body col-12">
      
        <section class="content">
          <div class="dataTables_wrapper dt-bootstrap4 table-responsive" id="contentLog">
             <table class="table table-striped table-bordered table-hover " id="table-log">
                <thead>
                  <tr>
                      <th>UID</th>
                      <th>Tanggal</th>
                      <th>Work Station</th>
                      <th>Log</th>
                      <th>Deskripsi</th>
                  </tr>
                </thead>
              </table>
          </div>
        </section>
        </div>
      </div>
    </div>
  </div>
  
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
          <div class="row mb-4">
            <div class="col-md-6">
              <table width="100%">
                <tr>
                  <td class="text-muted">Dibuat oleh</td>
                  <td class="text-muted">:</td>
                  <td class="font-weight-bold" id="dibuat">
                    <div class="skeleton-box text-skeleton" style="width:100px"></div>
                  </td>
                </tr>
                <tr>
                  <td class="text-muted">Nama Merchant</td>
                  <td class="text-muted">:</td>
                  <td class="font-weight-bold" id="nama_merchant">
                    <div class="skeleton-box text-skeleton" style="width:100px"></div>
                  </td>
                </tr>
                <tr>
                  <td class="text-muted">Tanggal Request</td>
                  <td class="text-muted">:</td>
                  <td class="font-weight-bold" id="tgl_req">
                    <div class="skeleton-box text-skeleton" style="width:100px"></div>
                  </td>
                </tr>
              </table>
            </div>
            <div class="col-md-6">
              <table width="100%">
                <tr>
                  <td class="text-muted">Jenis Request</td>
                  <td class="text-muted">:</td>
                  <td id="jenisRequestId">
                    <div class="skeleton-box text-skeleton" style="width:100px"></div>
                  </td>
                </tr>
                <tr>
                  <td class="text-muted">Tanggal Pencairan</td>
                  <td class="text-muted">:</td>
                  <td class="font-weight-bold" id="tanggalPencairanId">
                    <div class="skeleton-box text-skeleton" style="width:100px"></div>
                  </td>
                </tr>
                <tr>
                  <td class="text-muted">Jam Pencairan</td>
                  <td class="text-muted">:</td>
                  <td class="font-weight-bold" id="jamPencairanId">
                    <div class="skeleton-box text-skeleton" style="width:100px"></div>
                  </td>
                </tr>
                <tr>
                  <td class="text-muted">Status Klaim</td>
                  <td class="text-muted">:</td>
                  <td id="statusKlaimId">
                    <div class="skeleton-box text-skeleton" style="width:100px"></div>
                  </td>
                </tr>
                <tr>
                  <td class="text-muted">Catatan</td>
                  <td class="text-muted">:</td>
                  <td id="catatanId">
                    <div class="skeleton-box text-skeleton" style="width:100px"></div>
                  </td>
                </tr>
              </table>
              <br>
            </div>
          </div>
          <div class="row m-2">
            <div class="card col-md-12">
              <h4 style="padding-left: 3px; padding-top: 11px;" id="detailKlaim"></h4>
              <div class="item-record card-body">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="rejectedPopUp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="titleId">
            
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row mb-4">
            <div class="col-md-12">
              <label>Catatan Perbaikan</label>
              <textarea class="form-control" id="rejectedNotes" readonly></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="{{ url('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/select2/js/select2.full.min.js') }} "></script>
<script src="{{ url('js/utils.js') }} "></script>

@endsection
@push('script')
  <script type="text/javascript">
    $(document).ready(function() {
      $('#resetButton').on('click', function(){
        $('#statusCategory').val("")
        $('#keyword').val("")
      })

      loadTableLog();
      
      logActivity(JSON.stringify([
        'View', 
        'Melihat list',
        'cl_user_activities', 
        'General',
        '{{ Route::current()->getName() }}'
      ]))
    });

    function popUpNotes(notes, rekNum, rekName){
      $('#rejectedNotes').html('')
      $('#titleId').html('')
      var title = `${rekNum} - ${rekName}` 
      $('#rejectedNotes').append(notes)
      $('#titleId').append(title)
      $('#rejectedPopUp').modal('show')
    }
    
    $("#buttonLoad").click(function(){
      loadTableLog();
    });

    $("#buttonReset").click(function(){
      $("#keyword").val("");
      $("div.status select").val("All").change();
      $('#table-log').DataTable().clear().destroy()
      loadTableLog();
    });
    
    function loadTableLog(){
      $('#table-log').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('log.basicdata') }}",
          type: 'GET',
          data: 
            function (d) {
              var search_data = {
                search: $('#keyword').val() != null ? $('#keyword').val() : null,
                status_category: $('#statusCategory').val() != null ? $('#statusCategory').val() : null,
                type: '{{ $type }}',
              };
              d.search_param = search_data;
          }        
        },
        columns: [
          {
            data: 'cua_by_uid', 
            name: 'UID'
          },
          {
            data: 'cua_dt', 
            name: 'Tanggal Log', 
          },
          {
            data: 'cua_user_agent', 
            name: 'Work Station', 
            mRender: function(data, type, row){
              let kode = row.cua_user_agent;
              let ip = row.cua_ip;
              return kode + " | " + ip;
            }
          },
          {
            data: 'cua_act', 
            name: 'Log',
        },{
            data: 'cua_desc', 
            name: 'Deksripsi'
            
        }
        ],
        dom: '<"row" <"col-sm-8" i><"col-sm-4 text-center" l>>rt<"pull-right" p>'
      });
    }
  </script>
@endpush