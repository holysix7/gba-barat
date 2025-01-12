@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{ url('adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <h4>
            <b>
              @if(request()->segment(2))
                {{ strtoupper(request()->segment(1)) }} > {{$data->menu}}
              @else
                {{ strtoupper(request()->segment(1)) }}
              @endif
            </b>
          </h4>
        </div>
        @if(request()->segment(2) === 'detail')
          <div class="col-md-6">
            <div class="row" style="flex-direction: row-reverse;">
              <div class="col-md-4">
                <a href="{{ data_get($data, 'redirect_back', 'javascript:void(0)') }}" class="link-new align-items-center" style="text-align: right;">
                  <h4>
                    <i class="fa fa-backward"></i>
                    Kembali
                  </h4>
                </a>
              </div>
            </div>
          </div>
        @endif
      </div>
      <div class="card card-primary card-outline card-outline-tabs col-sm-12">
        <div class="row">
          <div class="card-body col-12">
            <section class="content">
              <div class="container-fluid">
                <div class="row d-flex justify-content-end" style="padding-top: 10px;">
                  @if(request()->segment(2) === 'iuran-rt' || request()->segment(2) === 'detail')
                    <div class="col-sm-6">
                      <a href="javascript:void(0)" id="buttonTambah" class="btn btn-primary-outline btn-template-tambah">
                        <i class="fa fa-plus"></i>
                        TAMBAH {{ request()->segment(2) ? strtoupper($data->menu) : strtoupper(request()->segment(1)) }}
                      </a>
                    </div>
                  @endif
                  <div class="col-sm-6">
                    @include('content-header', compact('data'))
                  </div>
                </div>
                <div class="row d-flex justify-content-center">
                  <div class="col-12">
                    <hr>
                    @yield('info')
                    @yield('table')
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </section>
    
  @include('layouts.modal')  

@endsection

@push('script')
  <script type="text/javascript">
    var valueBayar = [];
    $(document).ready(function() {
      loadingData()
      
      var table = $('#fikri-request-noremote').DataTable({
        ordering: false 
      });

      $('#buttonExport').on('click', function(){
        $('#exportPopUp').modal('show')
      })

      $('#buttonTambah').on('click', function(){
        $('#tambahPopUp').modal('show')
      })

      $('#btnId').on('click', function(e){
        e.preventDefault();
        const isConfirmed = confirm('Apakah Anda yakin?');
        if (isConfirmed) {
            $(this).closest('form').submit();
        }
      }) 
      $('#refreshTable').on('click', function () {
        $('#fikri-request').DataTable().clear().destroy()
        loadingData()
      });
    })

    function openDetailForm(row){
      row = JSON.parse(decodeURIComponent(row)); 
      $('#infoModalForm').modal('show');
      $('#modalTitleForm').html(`Edit`);
      $('#readonlyForm').html('');
      const keys = Object.keys(row);
      var html = '';
      const newTagihan = row.tagihan.replaceAll('Rp ', '');
      console.log(newTagihan)
      for(let i = 0; i < keys.length; i++){
        if(keys[i] === 'rt_id' || keys[i] === 'tagihan'){
          const test = keys.splice(i, 1);
        }
        html += `<div class="col-md-12 d-flex justify-content-between form-border">
          <label style="font-weight: bold;">${keys[i].replaceAll('_', ' ').toUpperCase()}</label>
          <label>${row[keys[i]]}</label>
        </div>`
      }
      if(row.tagihan){
        html += `<div class="col-md-12 d-flex justify-content-between align-items-center form-border">
          <label style="font-weight: bold;">Tagihan</label>
          <div>
            <input type="hidden" name="id" value="${row.id}" class="form-control">
            <input name="tagihan" value="${newTagihan}" class="form-control uangMasking" required>
          </div>
        </div>`
      }
      $('#readonlyForm').html(html);
      maskingInput()
    }

    function openDetail(rows){
      rows = JSON.parse(decodeURIComponent(rows)); 
      $('#infoModal').modal('show');
      valueBayar = JSON.stringify(rows);
      $('#idParseValue').val(valueBayar);
      $('#modalTitle').html(`Detail`);
      var table = $('#fikri-request-detail').DataTable({
        destroy: true, // Membolehkan inisialisasi ulang
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        responsive: true,
        // scrollX: true,
        oLanguage: {
          oPaginate: {
            sFirst: "Halaman Pertama",
            sPrevious: "Sebelumnya",
            sNext: "Selanjutnya",
            sLast: "Halaman Terakhir"
          }
        },
        columns: @if(data_get($data, 'columns'))
        [
          @foreach ($data->columns as $column)
            @if (!in_array($column['title'], ['Kepala Keluarga', 'Aksi', ]))
              {
                  title: "{{ $column['title'] }}",
                  data: "{{ $column['data'] }}",
                  @if (isset($column['width']))
                    width: "{{ $column['width'] }}",
                  @endif
              },
            @endif
          @endforeach
        ]
        @else
        []
        @endif
      });
      // Hapus data lama dan tambahkan data baru ke DataTable
      table.clear(); // Hapus data lama
      table.rows.add(rows); // Tambahkan data baru
      table.draw(); // Render ulang tabel
    }

    function loadingData(){
      var table = $('#fikri-request').DataTable({
        serverSide: true,
        ajax: {
          url: "{{ $data->endpoint }}",
          type: 'POST',
          data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            rt: "{{ request()->segment(1) }}",
            filter: $('#filter').val()
          }
        },
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
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
        columns: @if(data_get($data, 'columns')) 
        [
          @foreach ($data->columns as $column)
            {
                title: "{{ $column['title'] }}",
                data: "{{ $column['data'] }}",
                @if (isset($column['className']))
                  className: "{{ $column['className'] }}",
                @endif
                @if (isset($column['width']))
                  width: "{{ $column['width'] }}",
                @endif
                @if ($column['title'] === 'Kepala Keluarga')
                    mRender: function(data, type, row) {
                        var html = `<span class="bg-danger-status">False</span>`;
                        if (row.kepala_keluarga) {
                            html = `<span class="bg-success-status">True</span>`;
                        }
                        return html;
                    }
                @endif
                @if ($column['title'] === 'Status Bayar')
                    mRender: function(data, type, row) {
                      if(row.status_bayar === 'Sudah Bayar'){
                        return `<span class="button-action" title='Lihat Detail' style="cursor: pointer;" onclick=""><span class="bg-success-status" onclick="alert('${row.rt} sudah melakukan pembayaran!')">Sudah Bayar</span><i class="fa fa-check" style="padding-left: 10px; color: green;"></i></span>`;
                      }else{
                        return `<span class="button-action" title='Lihat Detail' style="cursor: pointer;" onclick="openDetail('${encodeURIComponent(JSON.stringify([row]))}')"><span class="bg-warning-status">Belum Bayar</span><i class="fa fa-exclamation" style="padding-left: 10px; color: orange;"></i></span>`;
                      }
                    }
                @endif
                @if ($column['title'] === 'Aksi')
                    mRender: function(data, type, row) {
                      if(row.families){
                        return `<a href="javascript:void(0)" class="button-action" style='font-size: 20px;' title='Lihat Detail' onclick="openDetail('${encodeURIComponent(JSON.stringify(row.families))}')"><i class="mdi mdi-eye"></i></a>`;
                      }else{
                        let eventClick = `openDetailForm('${encodeURIComponent(JSON.stringify(row))}')`;
                        if(row.status_bayar === 'Sudah Bayar'){
                          eventClick = `alert('${row.rt} sudah melakukan transaksi, tidak dapat merubah data!')`;
                        }
                        return `<a href="javascript:void(0)" class="button-action" style='font-size: 20px;' title='Lihat Detail' onclick="${eventClick}"><i class="fa fa-edit"></i></a>`;
                      }
                    }
                @endif
            },
          @endforeach
        ]
        @else
        []
        @endif
      })
    }
  </script>
@endpush