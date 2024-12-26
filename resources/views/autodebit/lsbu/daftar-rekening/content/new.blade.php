@section('style')
<link rel="stylesheet" href="{{ url('adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="m-4">
        <div class="row m-2 mt-4">
          <div class="d-flex w-100">
            <form method="POST" action="{{ route('autodebit.lsbu.daftar-rekening.confirm') }}" enctype="multipart/form-data" class="w-100">
              @csrf
              <input type="hidden" value="0" id="count">
              <div class="justify-content-center">
                <div class="row">
                  <div class="col-sm-12 form-group">
                    <h3>Informasi Rekening Sumber</h3>
                  </div>
                </div>
                <div class="row justify-content-between">
                  <div class="col-sm-5 form-group">
                    <div class="row">
                      <div class="col-sm-4 mt-1">
                        <label>No. Rekening Sumber</label>
                      </div>
                      <div class="col-sm-8">
                        <input type="number" class="form-control number-only" name="sd_pc_src_extacc" id="noRekUtama" required>
                        {{-- <input type="text" class="form-control uangMasking" required> --}}
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-5 form-group">
                    <div class="row">
                      <div class="col-sm-4 mt-1">
                        <label>Nama Nasabah</label>
                      </div>
                      <div class="col-sm-8" id="contentSrcName">
                        <input type="text" class="form-control" name="sp_pc_src_name" id="namaUtama" readonly required>
                      </div>
                    </div>
                    {{-- <div class="row mt-4">
                      <div class="col-sm-4 mt-1">
                        <label>CIF</label>
                      </div>
                      <div class="col-sm-8" id="contentSrcCif">
                        <input type="text" class="form-control" name="cif" id="cifUtama" readonly>
                      </div>
                    </div> --}}
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <h3>Informasi Rekening Tujuan</h3>
                    <t id="sisaSlot">Slot pendaftaran tersisa: &nbsp;<t style="color: red">0 Rekening</t></t>
                    <input type="hidden" value="0" id="sisaSlotId">
                    <input type="hidden" value="0" id="jumlahDataValId">
                    <input type="hidden" value="{{ $product->sp_p_min_period }}" id="spMinPeriod">
                    <input type="hidden" value="{{ $product->sp_p_max_period }}" id="spMaxPeriod">
                    <input type="hidden" value="{{ $product->sp_p_min_period_amount }}" id="spMinAmount">
                    <input type="hidden" value="{{ $product->sp_p_max_period_amount }}" id="spMaxAmount">
                  </div>
                  <div class="col-sm-6 form-group">
                    <div class="row d-flex justify-content-end">
                      <div class="col-sm-6" id="btnRiwayatPendaftaran">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row justify-content-between">
                  <div class="col-sm-12 form-group">
                    <table class="table table-stripped" id="rekeningTujuan">
                      <thead>
                        <tr>
                          <th class="text-center">Aksi</th>
                          <th style="width: 14%;">No Rekening Tujuan</th>
                          <th style="width: 17%;">Nama Nasabah</th>
                          <th style="width: 19%;">Jenis Rekening</th>
                          <th style="width: 15%;">Jangka Waktu (Bulan)</th>
                          <th style="width: 15%;">Setoran Bulanan</th>
                          <th style="width: 7%;">Tanggal Debet</th>
                        </tr>
                      </thead>
                      <tbody id="contentTujuanId">
                        <tr id="rowAddBtn">
                          <td class="text-start" colspan="6"><a href="javascript:void(0)" class="ml-2" onclick="addRow()"><i class="mdi mdi-plus"></i></a></td>
                        </tr>
                      <tbody>
                    </table>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-3 form-group">
                    <div class="row">
                      <div class="col-sm-5">
                        <t class="font-weight-bold">Jumlah Data</t>
                      </div>
                      <div class="col-sm-1">
                        <t class="font-weight-bold">:</t>
                      </div>
                      <div class="col-sm-5" id="jumlahDataId">
                        <t class="font-weight-bold">0 Data</t>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row d-flex justify-content-end">
                  <div class="col-md-6 d-flex justify-content-between" id="btnSubmitId">
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="infoRiwayatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header" id="modalHeaderRiwayatId">
      </div>
      <div class="modal-body d-flex justify-content-center">
        <div class="row w-100 d-flex justify-content-center" id="modalContentRiwayatId">
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" id="modalHeaderId">
      </div>
      <div class="modal-body d-flex justify-content-center">
        <div class="row w-100 d-flex justify-content-center" id="modalContentId">
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="batalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h5 style="font-size: 20px;">Apakah Anda yakin akan membatalkan pendaftaran?</h5>
      </div>
      <div class="modal-body d-flex justify-content-center">
        <div class="row w-100">
          <div class="col-sm-12">
            <a href="{{ route('autodebit.lsbu.daftar-rekening') }}" class="btn btn-danger">Batalkan</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('script')
  <script src="{{ url('adminlte/plugins/select2/js/select2.full.min.js') }} "></script>
	<script type="text/javascript">
    $(document).ready(function(){
      var html = ''
      
      if($('#sisaSlotId').val() > 0){
        html = `
          <tr id="rowAddBtn">
            <td class="text-start" colspan="6"><a href="javascript:void(0)" class="ml-2" onclick="addRow()"><i class="mdi mdi-plus"></i></a></td>
          </tr>
        `
      }
      $('#contentTujuanId').html(html)
      $('#noRekUtama').on('change', function(){
        if($(this).val().length < 13){
          alert('No rekening yang diinputkan kurang dari 13 digit')
        }else{
          validasiRekening('sumber', $(this).val(), null)
        }
      })

      logActivity(JSON.stringify([
        'View', 
        'Melihat form baru',
        'savdep_product_customer_lsbu', 
        'General',
        '{{ Route::current()->getName() }}'
      ]))
    })
    let arrayTujuan = []

    function validasiRekening(params, value, rowId){
      let runAjax = true
      var status = false
      console.log(value)
      if(params == 'sumber'){
        $('#contentSrcName').html('<div class="skeleton-box text-skeleton w-100"></div>')
        $('#contentSrcCif').html('<div class="skeleton-box text-skeleton w-100"></div>')
      }else{
        if(value.length < 13){
          alert('No rekening yang diinputkan kurang dari 13 digit')
          runAjax = false
        }else{
          arrayTujuan = arrayTujuan.filter(function(v){
            return v.rek_tujuan !== value
          })
          $('#contentDstName').html('<div class="skeleton-box text-skeleton w-100"></div>')
          $('#contentDstCif').html('<div class="skeleton-box text-skeleton w-100"></div>')
        }
      }
      if(params == 'tujuan'){
        if(arrayTujuan.length > 0){
          arrayTujuan.map(function(v, k){
            if(v.rek_tujuan == $('.norekClass').val()){
              $(`#noRekTujuan${rowId}`).val('')
              runAjax = false
              status = true
              arrayTujuan = arrayTujuan.filter(function(v){
                return v.rek_tujuan !== $(`#noRekTujuan${rowId}`).val()
              })
            }
          })
          if(status){
            alert('data tersebut sudah ditambahkan')
            arrayTujuan = arrayTujuan.filter(function(v){
              return v.rek_tujuan !== $(`#noRekTujuan${rowId}`).val()
            })
          }
        }
        alertFuncValidation(rowId)
      }
      if(runAjax){
        $.ajax({
          url: `{{ url("autodebit/lsbu/daftar-rekening/validasi-norekening/`+ params +`") }}`,
          type: 'POST',
          data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            noRek: value
          },
          success: function(response){
            var html = ''
            if(response.RC == '0000'){
              if(response.MT == '2110'){
                if(response.sisa_slot < 10){
                  $('#btnRiwayatPendaftaran').html(`<a href="javascript:void(0)" class="btn btn-primary login-btn" onclick="funcRiwayatPendaftaran()">Riwayat Pendaftaran</a>`)
                }else{
                  $('#btnRiwayatPendaftaran').html('')
                }
                $('#jumlahDataValId').val(response.jumlah_data)
                $('#jumlahDataId').html(`<t class="font-weight-bold">${response.jumlah_data} Data</t>`)
                $('#sisaSlotId').val(response.sisa_slot)
                $('#sisaSlot').html(`Slot pendaftaran tersisa: &nbsp;<t style="color: red">${response.sisa_slot} Rekening</t>`)
                $('#contentSrcName').html(`
                  <input type="text" class="form-control" name="sd_pc_src_name" id="srcNameId" value="${response.MP.ACCSRC_NAME}" required readonly>
                  <input type="hidden" class="form-control" name="sd_pc_src_intacc" id="srcIntacc" value="${response.MP.ACCINTSRC}" required readonly>
                  <input type="hidden" class="form-control" name="sd_pc_src_branch" id="srcBranch" value="${response.MP.ACCSRC_BRANCH}" required readonly>
                  <input type="hidden" class="form-control" name="accsrc_type_name" id="srcBranch" value="${response.MP.ACCSRC_TYPE_NAME}" required readonly>
                  <input type="hidden" class="form-control" name="accsrc_currency" id="srcBranch" value="${response.MP.ACCSRC_CURRENCY}" required readonly>
                  <input type="hidden" class="form-control" name="accsrc_cif" id="srcBranch" value="${response.MP.ACCSRC_CIF}" required readonly>
                  <input type="hidden" class="form-control" name="accsrc_type" id="srcBranch" value="${response.MP.ACCSRC_TYPE}" required readonly>
                `)
                $('#contentSrcCif').html(`
                  <input type="text" class="form-control" name="sd_pc_cif_src" id="srcCifId" value="${response.MP.ACCSRC_CIF}" required readonly>
                `)
                if($('#sisaSlotId').val() > 0){
                  html = `
                    <tr id="rowAddBtn">
                      <td class="text-start" colspan="6"><a href="javascript:void(0)" class="ml-2" onclick="addRow()"><i class="mdi mdi-plus"></i></a></td>
                    </tr>
                  `
                }
                $('#contentTujuanId').html(html)
              }else{
                $(`#rekeningTujuan${rowId}`).val(response.MP.ACCDST_NAME)
                $(`#accintdst${rowId}`).val(response.MP.ACCINTDST)
                $(`#accdst_type${rowId}`).val(response.MP.ACCDST_TYPE)
                $(`#accdst_type_name${rowId}`).val(response.MP.ACCDST_TYPE_NAME)
                $('#btnSubmitId').html(`
                  <a href="javascript:void(0)" class="btn btn-danger login-btn" style="width: 48% !important;" onclick="funcBatal()">Batalkan</a>
                  <button type="submit" class="btn btn-primary login-btn" style="width: 48% !important;">Daftar</button>
                `)
              } 
            }else{
              if(params == 'sumber'){
                if(response.MT == '2100'){
                  $('#noRekUtama').val('')
                  $('#contentSrcName').html(`<div>
                    <input type="text" class="form-control" name="sp_pc_src_name" id="namaUtama" readonly>
                  </div>`)
                  $('#contentSrcCif').html(`<div>
                    <input type="text" class="form-control" name="cif" id="cifUtama" readonly>
                  </div>`)
                }else{
                  $('#noRekUtama').val('')
                  $('#contentSrcName').html(`<div>
                    <input type="text" class="form-control" name="sp_pc_src_name" id="namaUtama" readonly>
                  </div>`)
                  $('#contentSrcCif').html(`<div>
                    <input type="text" class="form-control" name="cif" id="cifUtama" readonly>
                  </div>`)
                }
                $('#contentTujuanId').html(html)
              }else{
                if(response.MT == '2100'){
                  $(`#noRekTujuan${rowId}`).val('')
                  $(`#rekeningTujuan${rowId}`).val('')
                  $(`#accintdst${rowId}`).val('')
                  $(`#accdst_type${rowId}`).val('')
                  $(`#accdst_type_name${rowId}`).val('')
                  $('#contentDstName').html(`<div>
                    <input type="text" class="form-control" name="sp_pc_src_name" id="namaTujuan" readonly>
                  </div>`)
                  $('#contentDstCif').html(`<div>
                    <input type="text" class="form-control" name="cif" id="cifTujuan" readonly>
                  </div>`)
                }else{
                  $(`#noRekTujuan${rowId}`).val('')
                  $(`#rekeningTujuan${rowId}`).val('')
                  $(`#accintdst${rowId}`).val('')
                  $(`#accdst_type${rowId}`).val('')
                  $(`#accdst_type_name${rowId}`).val('')
                  $('#contentDstName').html(`<div>
                    <input type="text" class="form-control" name="sp_pc_src_name" id="namaTujuan" readonly>
                  </div>`)
                  $('#contentDstCif').html(`<div>
                    <input type="text" class="form-control" name="cif" id="cifTujuan" readonly>
                  </div>`)
                }
              }
              alert(`${response.RC_DESC}`)
              $('#btnSubmitId').html('')
            }
          },
          error: function(xhr, status, thrown){
            alert('Error ajax call: ', xhr, ', ', thrown)
            console.log(status)
            if(params == 'sumber'){
              $('#contentSrcName').html(`<div>
                <input type="text" class="form-control" name="sp_pc_src_name" id="namaUtama" readonly>
              </div>`)
              $('#contentSrcCif').html(`<div>
                <input type="text" class="form-control" name="cif" id="cifUtama" readonly>
              </div>`)
            }else{
              $('#contentDstName').html(`<div>
                <input type="text" class="form-control" name="sp_pc_src_name" id="namaTujuan" readonly>
              </div>`)
              $('#contentDstCif').html(`<div>
                <input type="text" class="form-control" name="cif" id="cifTujuan" readonly>
              </div>`)
            }
            $('#btnSubmitId').html('')
          }
        })
      }
    }

    function addRow(){
      var index = parseInt($('#sisaSlotId').val()) - 1

      $('#sisaSlotId').val(index)
      $('#sisaSlot').html(`Slot pendaftaran tersisa: &nbsp;<t style="color: red">${index} Rekening</t>`)
      var indexJumlah = parseInt($('#jumlahDataValId').val()) + 1
      $('#jumlahDataValId').val(indexJumlah)
      $('#jumlahDataId').html(`<t class="font-weight-bold">${indexJumlah} Data</t>`)
      var days = JSON.parse("{{ $days }}")
      var value = parseInt($('#count').val()) + 1
      var html = `<tr id="row${value}">
        <td class="row">
          <a href="javascript:void(0)" class="btn btn-danger" onclick="removeRow(${value})" style="width: 45% !important; height: 40px !important;"><i class="mdi mdi-delete"></i></a>
          <a href="javascript:void(0)" class="btn btn-primary" onclick="simulasiPopUp(${value})" style="width: 45% !important; height: 40px !important;">Simulasi</a>
        </td>
        <td><input type="text" class="form-control norekClass" name="sd_pc_dst_extacc[]" onchange="validasiRekening('tujuan', this.value, ${value})" id="noRekTujuan${value}" placeholder="No Rekening Tujuan" required></td>
        <td>
          <input type="text" class="form-control" name="sp_pc_dst_name[]" id="rekeningTujuan${value}" placeholder="Nama Rekening Tujuan" readonly>
          <input type="hidden" class="form-control" name="accintdst[]" id="accintdst${value}" placeholder="Nama Rekening Tujuan" readonly>
          <input type="hidden" class="form-control" name="accdst_type[]" id="accdst_type${value}" placeholder="Nama Rekening Tujuan" readonly>
        </td>
        <td><input type="text" class="form-control" name="accdst_type_name[]" id="accdst_type_name${value}" readonly></td>
        <td>
          <input type="number" class="form-control number-only-keydown" onkeydown="validateSymbol()" name="sp_pc_period[]" placeholder="Jangka Waktu (Min. {{ $product->sp_p_min_period }}, Max. {{ $product->sp_p_max_period }})" min="{{ $product->sp_p_min_period }}" max="{{ $product->sp_p_max_period }}" onChange="validationForm('jw', ${value})" id="period${value}" required>
        </td>
        <td>
          <input type="text" class="form-control uangMasking" name="sp_pc_period_amount[]" placeholder="Setoran Bulanan (Min. {{ number_format($product->sp_p_min_period_amount) }}, Max {{ number_format($product->sp_p_max_period_amount) }})" onChange="validationForm('sb', ${value})" id="periodAmount${value}" min="{{ $product->sp_p_min_period_amount }}" max="{{ $product->sp_p_max_period_amount }}" required>
        </td>
        <td>
          <select class="form-control" name="sp_pc_period_date[]" id="dateId">
      `
      days.map(function(v, k){
        html += `<option value="${v}">${v}</option>`
      })
      html += `
          </select>
        </td>
      </tr>
      `
      $("#contentTujuanId").prepend(html)
      $('#count').val(value)

      btnPlusCheck()
      maskingInput()
      validateSymbol()
    }

    function removeRow(element){
      arrayTujuan = arrayTujuan.filter(function(v){
        return v.rek_tujuan !== $(`#noRekTujuan${element}`).val()
      })
      var index = parseInt($('#sisaSlotId').val()) + 1
      $('#sisaSlotId').val(index)
      $('#sisaSlot').html(`Slot pendaftaran tersisa: &nbsp;<t style="color: red">${index} Rekening</t>`)
      var indexJumlah = parseInt($('#jumlahDataValId').val()) - 1
      $('#jumlahDataValId').val(indexJumlah)
      $('#jumlahDataId').html(`<t class="font-weight-bold">${indexJumlah} Data</t>`)
      $(`#row${element}`).remove()
      // $('#count').val(element - 1)
      btnPlusCheck()
    }

    function btnPlusCheck(){
      if(parseInt($('#sisaSlotId').val()) > 0){
        $('#rowAddBtn').html(`<td class="text-start" colspan="6">
          <a href="javascript:void(0)" class="ml-2" onclick="addRow()">
            <i class="mdi mdi-plus"></i>
          </a>
        </td>`)
      }else{
        $('#rowAddBtn').html('')
      }

    }

    function validationForm(type, value){
      if(type == 'jw'){
        if(parseInt($(`#period${value}`).val()) < parseInt($('#spMinPeriod').val())){
          alert(`Jangka waktu minimal ${$('#spMinPeriod').val()} bulan`)
          $(`#period${value}`).val('')
        }
        if(parseInt($(`#period${value}`).val()) > parseInt($('#spMaxPeriod').val())){
          alert(`Jangka waktu maximal ${$('#spMaxPeriod').val()} bulan`)
          $(`#period${value}`).val('')
        }
      }else{
        var amount = $(`#periodAmount${value}`).val().replaceAll('.', '')
        if(parseInt(amount) < parseInt($('#spMinAmount').val())){
          alert(`Setoran bulanan minimal Rp ${$('#spMinAmount').val()}`)
          $(`#periodAmount${value}`).val('')
        }
        if(parseInt(amount) > parseInt($('#spMaxAmount').val())){
          alert(`Setoran bulanan maximal Rp ${$('#spMaxAmount').val()}`)
          $(`#periodAmount${value}`).val('')
        }
      }
    }

    function funcBatal(){
      $('#batalModal').modal('show')
    }

    function alertFuncValidation(rowId){
      $('.norekClass').map(function(v, k){
        arrayTujuan.push({
          id: rowId,
          rek_tujuan: $(this).val()
        })
      })
    }
    
    function simulasiPopUp(value){
      var noRekTujuan       = $(`#noRekTujuan${value}`).val()
      var jangkaWaktu       = parseInt($(`#period${value}`).val())
      var setoranBerjangka  = parseInt($(`#periodAmount${value}`).val().replaceAll('.', ''))
      var productId         = $('#productId').val()
      var tanggal           = $('#dateId').val()
      
      $('#infoModal').modal('show')

      $('#modalHeaderId').html(`
        <h4 class="modal-title request_title w-100 text-center" id="exampleModalLabel">
          <div class="skeleton-box text-skeleton w-100"></div>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      `)
      $('#modalContentId').html(`
        <table class="table w-100" id="printContent">
          <thead class="w-100 thead-grey">
            <tr id="tableHeader">
              <th><div class="skeleton-box text-skeleton w-100"></div></th>
              <th><div class="skeleton-box text-skeleton w-100"></div></th>
              <th><div class="skeleton-box text-skeleton w-100"></div></th>
              <th><div class="skeleton-box text-skeleton w-100"></div></th>
              <th><div class="skeleton-box text-skeleton w-100"></div></th>
            </tr>
          </thead>
          <tbody id="tableBody">
          </tbody>
          <input type="hidden" id="recordsAppend">
        </table>
        <div class="col-sm-10" id="printId">
        </div>
      `)
      
      $.ajax({
        url: '{{ route("autodebit.lsbu.daftar-rekening.simulasi") }}',
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          product: 'lsbu',
          setoran_berjangka: setoranBerjangka,
          jangka_waktu: jangkaWaktu,
          rek_tujuan: noRekTujuan,
          tanggal: tanggal,
          pilihan_pembayaran: jangkaWaktu,
        },
        success: function(response){
          $('.request_title').html(`Simulasi Autodebet LSBU: ${noRekTujuan}`)
          $('#tableHeader').html(`
            <th>Period</th>
            <th>Tanggal Penarikan</th>
            <th>Nominal</th>
            <th>Interest</th>
            <th>Saldo Lsbu</th>
          `)
          var body = ``
          var arrData = []
          $.map(response.interval, function(v, k){
            body += `
              <tr>
                <td>${v.period}</td>  
                <td>${v.setoran_pertama}</td>
                <td class='text-right'>Rp ${number_format(v.nominal)}</td>
                <td class='text-right'>Rp ${number_format(v.interest)}</td>
                <td class='text-right'>Rp ${number_format(v.saldo_my_goals)}</td>
              </tr>
            `
          })
          $('#tableBody').html(body)
          
          if(response.interval.length > 0){
            $('#recordsAppend').val(JSON.stringify(response.interval))
            var btnPrint = `<a href="javascript:void(0)" class="btn btn-success login-btn w-100" onclick="printDiv(${value})"><i class="mdi mdi-file-document" style="font-size: 20px;"></i>&nbsp; Print</a>`
            $('#printId').html(btnPrint)
          }
        },
        error: function(xhr, status, thrown){
          $('.request_title').html(`Simulasi Autodebet`)
          $('#tableHeader').html(`
            <th>Period</th>
            <th>Tanggal Penarikan</th>
            <th>Nominal</th>
            <th>Saldo MyGoals</th>
          `)
          console.log(xhr)
          console.log(status)
          console.log(thrown)
        }
      })
    }

    function funcRiwayatPendaftaran(){
      $('#infoRiwayatModal').modal('show')

      $('#modalHeaderRiwayatId').html(`
        <h4 class="modal-title request_title w-100 text-center" id="exampleModalLabel">
          <div class="skeleton-box text-skeleton w-100"></div>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      `)
      $('#modalContentRiwayatId').html(`
        <table class="table w-100" id="printContentRiwayat">
          <thead class="w-100 thead-grey">
            <tr id="tableHeaderRiwayat">
              <th><div class="skeleton-box text-skeleton w-100"></div></th>
              <th><div class="skeleton-box text-skeleton w-100"></div></th>
              <th><div class="skeleton-box text-skeleton w-100"></div></th>
              <th><div class="skeleton-box text-skeleton w-100"></div></th>
              <th><div class="skeleton-box text-skeleton w-100"></div></th>
            </tr>
          </thead>
          <tbody id="tableBodyRiwayat">
          </tbody>
          <input type="hidden" id="recordsAppendIdRiwayat">
        </table>
        <div class="col-sm-10" id="printIdRiwayat">
        </div>
      `) 
      
      $.ajax({
        url: '{{ route("autodebit.lsbu.daftar-rekening.riwayat") }}',
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          rekSumber: $('#noRekUtama').val(),
        },
        success: function(response){
          $('.request_title').html(`Riwayat Pendaftaran Sumber: ${$('#noRekUtama').val()}`)
          $('#tableHeaderRiwayat').html(`
            <th>No</th>
            <th>Tanggal Registrasi</th>
            <th>Cabang</th>
            <th>Nomor Rekening</th>
            <th>Nama Rekening</th>
            <th>Periode Sukses</th>
            <th>Nominal</th>
          `)
          var body = ``
          var arrData = []
          $.map(response, function(v, k){
            body += `
              <tr>
                <td>${v.rownum}</td>  
                <td>${v.sp_pc_reg_date}</td>
                <td>${v.sp_pc_branch_reg}</td>
                <td>${v.sd_pc_dst_extacc}</td>
                <td>${v.sp_pc_dst_name}</td>
                <td>${v.sp_pc_current_period_sukses}/${v.sp_pc_period}</td>
                <td class='text-right'>Rp ${number_format(v.sp_pc_period_amount)}</td>
              </tr>
            `
          })
          $('#tableBodyRiwayat').html(body)
          
          $('#recordsAppendIdRiwayat').val(JSON.stringify(response))
          var btnPrint = `<a href="javascript:void(0)" class="btn btn-success login-btn w-100" onclick="printDivRiwayat()"><i class="mdi mdi-file-document" style="font-size: 20px;"></i>&nbsp; Print</a>`
          $('#printIdRiwayat').html(btnPrint)
        },
        error: function(xhr, status, thrown){
          $('.request_title').html(`Simulasi Autodebet`)
          $('#tableHeaderRiwayat').html(`
            <th>No</th>
            <th>Tanggal Registrasi</th>
            <th>Cabang</th>
            <th>Nomor Rekening</th>
            <th>Nama Rekening</th>
            <th>Periode Sukses</th>
            <th>Nominal</th>
          `)
          console.log(xhr)
          console.log(status)
          console.log(thrown)
        }
      })
    }
    
    function printDiv(id){
      var records   = JSON.parse($('#recordsAppend').val())
      var myAppCss  = `<link rel="stylesheet" href="{{ url('app.css') }}">`
      var myMainCss = `<link rel="stylesheet" href="{{ url('main.css') }}">`
      var noRekTujuan = $(`#noRekTujuan${id}`).val()
      var newWin = window.open("", "Print-Window");
      newWin.document.open()
      newWin.document.write(`
        <html>
          <head>
            <title>Print Data Rekening Tujuan: </title>
          </head>
          <body onload='window.print()'>
            ${myAppCss}
            ${myMainCss}
            <div class="container-fluid">
              <div class="row d-flex justify-content-center w-100">
                <div class="col-sm-12">
                  <div class="row w-100 d-flex justify-content-center">
                    <h3>Simulasi LSBU ${noRekTujuan}</h3>
                  </div>
                  <div class="row w-100 d-flex justify-content-center">
                    <table class="table w-100">
                      <thead class="w-100 thead-grey">
                        <tr>
                          <th>Period</th>
                          <th>Tanggal Penarikan</th>
                          <th>Nominal</th>
                          <th>Interest</th>
                          <th>Saldo Lsbu</th>
                        </tr>
                      </thead>
                      <tbody>`)
      records.map(function(v, k){
        newWin.document.write(`
          <tr>
            <td>${v.period}</td>  
            <td>${v.setoran_pertama}</td>
            <td class='text-right'>Rp ${number_format(v.nominal)}</td>
            <td class='text-right'>Rp ${number_format(v.interest)}</td>
            <td class='text-right'>Rp ${number_format(v.saldo_my_goals)}</td>
          </tr>
        `)
      })
      newWin.document.write(`
                      </tbody>
                      <input type="hidden">
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </body>
        </html>
      `)
      newWin.document.close()
    }
    
    function printDivRiwayat(){
      var records   = JSON.parse($('#recordsAppendIdRiwayat').val())
      var myAppCss  = `<link rel="stylesheet" href="{{ url('app.css') }}">`
      var myMainCss = `<link rel="stylesheet" href="{{ url('main.css') }}">`
      var newWin = window.open("", "Print-Window");
      newWin.document.open()
      newWin.document.write(`
        <html>
          <head>
            <title>Print Data Rekening Tujuan: </title>
          </head>
          <body onload='window.print()'>
            ${myAppCss}
            ${myMainCss}
            <div class="container-fluid">
              <div class="row d-flex justify-content-center w-100">
                <div class="col-sm-12">
                  <div class="row d-flex justify-content-center">
                    <h3>Riwayat Pendaftaran Sumber: ${ $('#noRekUtama').val() }</h3>
                  </div>
                  <div class="row d-flex justify-content-center">
                    <table class="table w-100">
                      <thead class="w-100 thead-grey">
                        <tr>
                          <th>No</th>
                          <th>Tanggal Registrasi</th>
                          <th>Cabang</th>
                          <th>Nomor Rekening</th>
                          <th>Nama Rekening</th>
                          <th>period</th>
                          <th>Nominal</th>
                        </tr>
                      </thead>
                      <tbody>`)
      records.map(function(v, k){
        newWin.document.write(`
          <tr>
            <td>${v.rownum}</td>  
            <td>${v.sp_pc_reg_date}</td>
            <td>${v.sp_pc_branch_reg}</td>
            <td>${v.sd_pc_dst_extacc}</td>
            <td>${v.sp_pc_dst_name}</td>
            <td>${v.sp_pc_period}</td>
            <td class='text-right'>Rp ${number_format(v.sp_pc_period_amount)}</td>
          </tr>
        `)
      })
      newWin.document.write(`
                      </tbody>
                      <input type="hidden">
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </body>
        </html>
      `)
      newWin.document.close()
    }
	</script>
@endpush