@extends('layouts.app-view')

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
        <h4><b>Monitoring </b> <label id="labelAutodebit"></label></h4>
          <p class="text-muted">{{ $desc }}</p>    
      </div>
      <div class="col-sm-6 text-right">
        <button type="button" class="btn btn-success mt-3 my-2" id="buttonExport" target="_blank">
          <i class="mdi mdi-export"></i>
          Export Daftar
        </button>
      </div>
    </div>
      <div class="row header-menu">
        <div class="col-md-12">
          <form action="{{ route('autodebit.mygoals.daftar-rekening.export') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="row">
              <div class="col-sm-9">
                <div class="row">
                  <div class="col-sm-3">
                    <label>Kategori </label>
                  </div>
                  <div class="col-sm-5">
                    <label>Nama Pemegang / Nomor Rekening </label>
                  </div>
                  <div class="col-sm-4">
                    <label> Rentang Waktu </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-9">
                <div class="row">
                  <div class="col-sm-3">
                    <select class="form-control" name="sd_pc_status" id="statusCategory">
                      <option value="" selected> - Pilih -</option>
                      <option value="Sukses">Autodebit Sukses</option>
                      <option value="Gagal">Autodebit Gagal</option>
                    </select>
                  </div>
                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="keyword" name="pencarian" placeholder="Masuk Keyword">
                  </div>
                  <div class="col-sm-2">
                    <input type="date" class="form-control" id="date-start">
                  </div>
                  <div class="col-sm-2">
                    <input type="date" class="form-control" id="date-end">
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
          <div class="dataTables_wrapper dt-bootstrap4" id="contentSukses">
             <table class="table table-striped table-bordered table-hover" id="table-riwayat-sukses">
                <thead>
                  <tr>
                      <th>No Rekening</th>
                      <th>Nama Pemegang Rekening</th>
                      <th>Produk</th>
                      <th>Jumlah Terdebit</th>
                      <th>Tanggal Autodebit</th>
                  </tr>
                </thead>
              </table>
          </div>
          <div class="dataTables_wrapper dt-bootstrap4" id="contentGagal">
              <table class="table table-striped table-bordered table-hover" id="table-riwayat-gagal">
                <thead>
                  <tr>
                      <th>No Rekening</th>
                      <th>Nama Pemegang Rekening</th>
                      <th>Bulan Gagal Debit</th>
                      <th>Tanggal Gagal Autodebit</th>
                      <th>Jumlah</th>
                  </tr>
                </thead>
              </table>
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

@push('script')
<script type="text/javascript">
  $(document).ready(function() {
    loadingData()
    $('#resetButton').on('click', function(){
      $('#statusCategory').val("")
      $('#keyword').val("")
    })
    $("#contentSukses").hide();
    $("#contentGagal").hide();

    // $('#filterButton').on('click', function(){
    //   $('#fikri-request').DataTable().clear().destroy()
    //   loadingData()
    // })
    
    // $('#buttonExport').on('click', function(){
    //   $.ajax({
    //     url: "{{ route('monitoring.transaksi.export')  }}",
    //     type: "GET",
    //     data: {
    //       _token: $('meta[name="csrf-token"]').attr('content'),
    //       search: $('#keyword').val(),
    //       status_category: $('#statusCategory').val()
    //     },
    //     success: function(response){
    //       console.log(response)
    //     }
    //   })
    // })
    
    // logActivity(JSON.stringify([
    //   'View', 
    //   'Melihat list',
    //   'savdep_product_customer_mygoals', 
    //   'General',
    //   '{{ Route::current()->getName() }}'
    // ]));
  });


  function loadingData(){
    var table = $('#fikri-request').DataTable({
      serverSide: true,
      ajax: {
        url: "{{ route('monitoring.transkasi.daftar-rekening') }}",
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          search: $('#keyword').val() != null ? $('#keyword').val() : null,
          status_category: $('#statusCategory').val() != null ? $('#statusCategory').val() : null,
          type: '{{ $type }}'
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
          data: 'rekening_sumber',
          width: "10%",
        },
        {
          title: "Nama Pemegang Rekening",
          data: 'rekening_sumber',
          width: "15%",
        },
        {
          title: "Produk",
          data: 'rekening_sumber',
          width: "10%",
          
        },
        {
          title: "Jumlah Terdebit",
          data: 'nominal_autodebit',
          width: "10%",
          class: 'text-right',
          mRender: function(data, type, row){
            let idr = data;
            
            return idr.toLocaleString('en-US');
          }
        },
        {
          title: "Tanggal Autodebit",
          data: 'tanggal_autodebit',
          width: "15%",
        },
      ],
    })
  }


  function popUpNotes(notes, rekNum, rekName){
    $('#rejectedNotes').html('')
    $('#titleId').html('')
    var title = `${rekNum} - ${rekName}` 
    $('#rejectedNotes').append(notes)
    $('#titleId').append(title)
    $('#rejectedPopUp').modal('show')
  }
  
  $("#buttonLoad").click(function(){
    let status = $("#statusCategory").val();
    if(status == "Sukses"){
      $("#contentSukses").show();
      $("#contentGagal").hide();
      loadTableSukses();
      $("#labelAutodebit").html(" - Sukses Autodebit");
    } else if(status == "Gagal") {
      $("#contentGagal").show();
      $("#contentSukses").hide();
      loadTableGagal();
      $("#labelAutodebit").html(" - Gagal Autodebit");
    } else {
      $("#contentSukses").hide();
      $("#contentGagal").hide();
      $("#labelAutodebit").html("");
    }
  });

  $("#buttonReset").click(function(){
    $("#date-start").val("");
    $("#date-end").val("");
    $("#keyword").val("");
    $("#buttonLoad").click();
  });
  
  $('#buttonExport').on('click', function(){
    let status = $('#statusCategory');
    if(status.val() === ""){
      alert("Silahkan pilih kategori terlebih dahulu!");
      status.focus();
      return false;
    }
    let url = "{{ route('monitoring.transaksi.export') }}";
    let type = '{{ $type }}';
    url += '?search=' + $('#keyword').val() + "&status_category=" + status.val() + "&type=" + type;
    url += '&start_date=' + $('#date-start').val() + "&end_date=" + $("#date-end").val();
    window.open( url , '_blank');
  });

  
    function loadTableSukses(){
    if ( $.fn.DataTable.isDataTable( '#table-riwayat-sukses' ) ) {
          $('#table-riwayat-sukses').DataTable().ajax.reload();
    } else {
          $('#table-riwayat-sukses').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
              url: "{{ route('monitoring.basicdata') }}",
              type: 'GET',
              data: 
                function (d) {
                  var search_data = {
                    search: $('#keyword').val() != null ? $('#keyword').val() : null,
                    status_category: $('#statusCategory').val() != null ? $('#statusCategory').val() : null,
                    date: $('#date-start').val() + "|" + $('#date-end').val(),
                    type: '{{ $type }}'
                  };
                  d.search_param = search_data;
              }        
            },
            columns: [
              {
                data: 'sd_t_dep_acc', 
                name: 'No Rekening'
              },
              {
                data: 'sp_pc_dst_name', 
                name: 'Nama Pemegang Rekening'
              },
              {
                data: 'sd_t_pid', 
                name: 'Produk',
              },
              {
                data: 'sd_t_amount', 
                name: 'Jumlah Terdebit', 
                class: 'text-right',
                mRender: function(data, type, row){
                  let idr = data;
                  return idr.toLocaleString('en-US');
                }
              },
              {
                data: 'sd_t_dt', 
                name: 'Tanggal Autodebit',
                mRender: function(data){
                    if(data !== ""){
                        let y = data.substr(0,4);
                        let m = data.substr(5,2);
                        let d = data.substr(8,2);
                        return d + "-" + m + "-" + y;
                    } else {
                        return "";
                    }
                }
            }
            ],
            dom: '<"row" <"col-sm-8" i><"col-sm-4 text-center" l>>rt<"pull-right" p>'
          });
        }
      }
        
  
  function loadTableGagal(){
    if ( $.fn.DataTable.isDataTable( '#table-riwayat-gagal' ) ) {
          $('#table-riwayat-gagal').DataTable().ajax.reload();

    } else {
      var tblgagal = $('#table-riwayat-gagal').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('monitoring.basicdata') }}",
          type: 'GET',
          data: 
                function (d) {
                  var search_data = {
                    search: $('#keyword').val() != null ? $('#keyword').val() : null,
                    status_category: $('#statusCategory').val() != null ? $('#statusCategory').val() : null,
                    date: $('#date-start').val() + "|" + $('#date-end').val(),
                    type: '{{ $type }}'
                  };
                  d.search_param = search_data;
              }        
        },
        columns: [
          {
            data: 'sd_t_src_acc', 
            name: 'No Rekening'
          },
          {
            data: 'sp_pc_dst_name', 
            name: 'Nama Pemegang Rekening'
          },
          {
            data: 'sd_t_period', 
            name: 'Produk', 
            mRender: function(data, type, row){
              return 'Bulan ke-' + data;
            }
          },
          {
            data: 'sd_t_dt', 
            name: 'Tanggal Autodebit'
          },
          {
            data: 'sd_t_amount', 
            name: 'Jumlah Terdebit', 
            class: 'text-right',
            mRender: function(data, type, row){
              let idr = data;
              return idr.toLocaleString('en-US');
            }},
          ],
          
          dom: '<"row" <"col-sm-8" i><"col-sm-4 text-center" l>>rt<"pull-right" p>'
        });
    }
  }
  </script>
@endpush
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('script')
<!-- <script src="{{ url('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
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
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="http://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script> -->
<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"> -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
@endsection