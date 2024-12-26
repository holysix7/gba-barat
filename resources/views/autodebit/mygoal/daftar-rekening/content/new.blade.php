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
            <input type="hidden" value="{{ $daysName }}" id="daysNameId">
            <form method="POST" action="{{ route('autodebit.mygoals.daftar-rekening.confirm') }}" enctype="multipart/form-data" class="w-100">
              @csrf
              <input type="hidden" value="0" id="count">
              <div class="justify-content-center">
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <h3>Informasi Rekening Sumber</h3>
                  </div>
                  <div class="col-sm-6 form-group">
                    <h3>Informasi Rekening Tujuan</h3>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <label class="form-label-bold">Jenis Produk</label>
                      </div>
                      <div class="col-sm">
                        <input type="text" class="form-control" name="sd_pc_pid" value="MYGOALS" id="productId" readonly required>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <label class="form-label-bold">Nama Pemilik Rekening Tujuan</label>
                      </div>
                      <div class="col-sm" id='contentDstName'>
                        <input type="text" class="form-control" name="sd_pc_dst_name" id="dstNameId" required readonly>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <label class="form-label-bold">Nomor Rekening Utama</label>
                      </div>
                      <div class="col-sm">
                        <input type="number" class="form-control number-only" name="sd_pc_src_extacc" id="noRekUtama">
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <label class="form-label-bold">Jenis Kelamin</label>
                      </div>
                      <div class="col-sm" id="contentGenderId"> 
                        <input type="text" class="form-control" name="sd_pc_gender" readonly id="genderId">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <label class="form-label-bold">Nama Pemilik Rekening Utama</label>
                      </div>
                      <div class="col-sm" id='contentSrcName'>
                        <input type="text" class="form-control" name="sd_pc_src_name" id="srcNameId" required readonly>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <label class="form-label-bold">Tanggal Lahir</label>
                      </div>
                      <div class="col-sm" id="contentTanggalLahir">
                        <input type="text" class="form-control" name="sd_pc_dob" readonly required>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <label class="form-label-bold">CIF</label>
                      </div>
                      <div class="col-sm" id='contentSrcCif'>
                        <input type="text" class="form-control" name="sd_pc_cif_src" id="srcCifId" required readonly>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <label class="form-label-bold">CIF</label>
                      </div>
                      <div class="col-sm" id='contentDstCif'>
                        <input type="text" class="form-control" name="sd_pc_cif_dst" id="dstCifId" required readonly>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <label class="form-label-bold">Account Type</label>
                      </div>
                      <div class="col-sm" id="contentSrcAcc">
                        <input type="text" class="form-control" name="account_type_src" id="srcAccountType" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <label class="form-label-bold">Account Type</label>
                      </div>
                      <div class="col-sm" id="contentDstAcc">
                        <input type="text" class="form-control" id="dstAccountType" readonly>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <label class="form-label-bold">Mata Uang</label>
                      </div>
                      <div class="col-sm" id="contentSrcUang">
                        <input type="text" class="form-control" id="currencyId" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <label class="form-label-bold">Mata Uang</label>
                      </div>
                      <div class="col-sm" id="contentDstUang">
                        <input type="text" class="form-control" readonly>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12 form-group">
                    <h3>Informasi Autodebet</h3>
                    <t id="sisaSlot">Slot pendaftaran tersisa: &nbsp;<t style="color: red">0 Rekening</t></t>
                    <input type="hidden" value="0" id="sisaSlotId">
                    <input type="hidden" value="0" id="jumlahDataValId">
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12 form-group">
                    <table class="table table-responsive text-nowrap" id="rekeningTujuan">
                      <thead>
                        <tr>
                          <th class="text-center" style="width: 200px !important;">Aksi</th>
                          <th class="text-center" style="width: 200px !important;">MyGoals</th>
                          <th class="text-center" style="width: 200px !important;">Nama Ahli Waris</th>
                          <th class="text-center" style="width: 200px !important;">Target Tabungan</th>
                          <th class="text-center" style="width: 200px !important;">Misi Utama</th>
                          <th class="text-center" style="width: 200px !important;">Setoran Awal</th>
                          <th class="text-center" style="width: 200px !important;">Metode Pendebetan</th>
                          <th class="text-center" style="width: 200px !important;">Pilihan Target</th>
                          <th class="text-center" style="width: 200px !important;">Waktu Pendebetan</th>
                          <th class="text-center" style="width: 200px !important;">Angsuran Berkala</th>
                          <th class="text-center" style="width: 200px !important;">Jangka Waktu</th>
                          <th class="text-center" style="width: 200px !important;">Sisa Angsuran</th>
                          <th class="text-center" style="width: 200px !important;">Jenis Notifikasi</th>
                          <th class="text-center" style="width: 200px !important;">Nomor Ponsel</th>
                          <th class="text-center" style="width: 200px !important;">Email</th>
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
                  <div class="col-md-6 d-flex justify-content-end" id="btnSubmitId">
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

<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" id="modalHeaderId">
      </div>
      <div class="modal-body d-flex justify-content-center">
        <div class="row w-100" id="modalContentId">
        </div>
      </div>
    </div>
  </div>
</div>

@push('script')
	<script type="text/javascript">
    $(document).ready(function(){
      $('#noRekUtama').on('change', function(){
        if($(this).val().length > 0){
          return validasiRekening('sumber', $(this).val(), null)
        }
        $('#contentTanggalLahir').html(`
          <input type="text" class="form-control" name="sd_pc_dob" readonly required>
        `)
        $('#contentSrcName').html(`
          <input type="text" class="form-control" name="sd_pc_src_name" id="srcNameId" required readonly>
        `)
        $('#contentSrcCif').html(`
          <input type="text" class="form-control" name="sd_pc_cif_src" id="srcCifId" required readonly>
        `)
        $('#contentDstCif').html(`
          <input type="text" class="form-control" name="sd_pc_cif_dst" id="dstCifId" required readonly>
        `)
        $('#contentSrcAcc').html(`
          <input type="text" class="form-control" id="srcAccountType" readonly>
        `)
        $('#contentDstAcc').html(`
          <input type="text" class="form-control" id="dstAccountType" readonly>
        `)
        $('#contentSrcUang').html(`
          <input type="text" class="form-control" value="IDR" id="currencyId" readonly>
        `)
        $('#contentDstUang').html(`
          <input type="text" class="form-control" value="IDR" readonly>
        `)
        $('#contentDstName').html(`
          <input type="text" class="form-control" name="sd_pc_dst_name" id="dstNameId" required readonly>
        `)
        $('#contentGenderId').html(`
          <input type="text" class="form-control" name="sd_pc_gender" readonly id="genderId">
        `)
        $('#noRekUtama').val('')
        alert('Harap nomor rekening sumber diisi')
      })

      logActivity(JSON.stringify([
        'View', 
        'Melihat form baru',
        'savdep_product_customer_mygoals', 
        'General',
        '{{ Route::current()->getName() }}'
      ]))

      // new script
      
      var html = ''
      
      if($('#sisaSlotId').val() > 0){
        html = `
          <tr id="rowAddBtn">
            <td class="text-start" colspan="6"><a href="javascript:void(0)" class="ml-2" onclick="addRow()"><i class="mdi mdi-plus"></i></a></td>
          </tr>
        `
      }
      $('#contentTujuanId').html(html)
    })

    function simulasiPopUp(key){
      var metodePendebetan  = parseInt($(`#intervalId${key}`).val())
      var jangkaWaktu       = parseInt($(`#jangkaWaktuId${key}`).val().replaceAll('.', ''))
      var setoranAwal       = parseInt($(`#setoranAwal${key}`).val().replaceAll('.', ''))
      var setoranBerjangka  = parseInt($(`#setoranBerjangkaId${key}`).val().replaceAll('.', ''))
      var noRekTujuan       = $(`#noRekTujuan${key}`).val()
      var productId         = $('#productId').val()
      var tglMingguId       = $(`#tglMingguId${key}`).val()
      var pilihanPembayaran = ''
      if($('#intervalId').val() != 1){
        pilihanPembayaran = $('#tanggalId').val() ? $('#tanggalId').val() : $('#hariId').val()
      }
      
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
        <table class="table w-100">
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
        </table>
      `)
      
      $.ajax({
        url: '{{ route("get.simulasi_autodebit") }}',
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          product: 'mygoals',
          setoran_berjangka: setoranBerjangka,
          jangka_waktu: jangkaWaktu,
          metode_pendebetan: metodePendebetan,
          setoran_awal: setoranAwal,
          pilihan_pembayaran: jangkaWaktu,
          product_id: productId,
          tgl_minggu_id: tglMingguId
        },
        success: function(response){
          $('.request_title').html(`Simulasi Autodebet LSBU: ${noRekTujuan}`)
          $('#tableHeader').html(`
            <th>Period</th>
            <th>Tanggal Penarikan</th>
            <th>Nominal</th>
            <th>Interest</th>
            <th>Pajak</th>
            <th>Saldo MyGoals</th>
          `)
          var body = ``
          body += `
            <tr>
              <td>${response.setoran_awal.period}</td>
              <td>${response.setoran_awal.setoran_pertama}</td>
              <td class='text-right'>Rp ${number_format(response.setoran_awal.setoran_awal)}</td>
              <td class='text-right'>Rp ${number_format(response.setoran_awal.interest, 2)}</td>
              <td class='text-right'>Rp ${number_format(response.setoran_awal.pajak, 2)}</td>
              <td class='text-right'>Rp ${number_format(response.setoran_awal.saldo_my_goals, 2)}</td>
            </tr>
          `
          $.map(response.interval, function(v, k){
            body += `
              <tr>
                <td>${v.period}</td>
                <td>${v.setoran_pertama}</td>
                <td class='text-right'>Rp ${number_format(v.nominal)}</td>
                <td class='text-right'>Rp ${number_format(v.interest, 2)}</td>
                <td class='text-right'>Rp ${number_format(v.pajak, 2)}</td>
                <td class='text-right'>Rp ${number_format(v.saldo_my_goals, 2)}</td>
              </tr>
            `
          })
          $('#tableBody').html(body)
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

    function validasiRekening(params, value, key){
      if(params == 'sumber'){
        $('#contentTanggalLahir').html('<div class="skeleton-box text-skeleton w-100"></div>')
        $('#contentSrcName').html('<div class="skeleton-box text-skeleton w-100"></div>')
        $('#contentSrcCif').html('<div class="skeleton-box text-skeleton w-100"></div>')
        $('#contentDstCif').html('<div class="skeleton-box text-skeleton w-100"></div>')
        $('#contentSrcAcc').html('<div class="skeleton-box text-skeleton w-100"></div>')
        $('#contentDstAcc').html('<div class="skeleton-box text-skeleton w-100"></div>')
        $('#contentSrcUang').html('<div class="skeleton-box text-skeleton w-100"></div>')
        $('#contentDstUang').html('<div class="skeleton-box text-skeleton w-100"></div>')
        $('#contentDstName').html('<div class="skeleton-box text-skeleton w-100"></div>')
        $('#contentGenderId').html('<div class="skeleton-box text-skeleton w-100"></div>')
      }
      $.ajax({
        url: `{{ url("autodebit/my-goals/daftar-rekening/validasi-norekening/`+ params +`") }}`,
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          noRek: value
        },
        success: function(response){
          if(response.RC == '0000'){
            if(response.MT == '2110'){
              if(response.MP.ACC_EQ.length > 0){
                $('#contentSrcName').html(`
                  <input type="text" class="form-control" name="sd_pc_src_name" id="srcNameId" value="${response.MP ? response.MP.ACCSRC_NAME : ''}" required readonly>
                  <input type="hidden" class="form-control" name="sd_pc_src_intacc" id="srcIntacc" value="${response.MP ? response.MP.ACCINTSRC : ''}" required readonly>
                  <input type="hidden" class="form-control" name="sd_pc_src_branch" id="srcBranch" value="${response.MP ? response.MP.ACCSRC_BRANCH : ''}" required readonly>
                  <input type="hidden" class="form-control" name="sd_pc_src_extacc" id="extSrc" value="${response.MP ? response.MP.ACCEXTSRC : ''}" required readonly>
                `)
                
                $('#contentSrcCif').html(`
                  <input type="text" class="form-control" name="sd_pc_cif_src" id="srcCifId" value="${response.MP ? response.MP.ACCSRC_CIF : ''}" required readonly>
                `)
                $('#contentSrcAcc').html(`
                  <input type="text" class="form-control" name="account_type_src" id="srcAccountType" value="${response.MP ? response.MP.ACCSRC_TYPE : ''}" readonly>
                `)
                $('#contentDstAcc').html(`
                  <input type="text" class="form-control" id="dstAccountType" value="EQ" readonly>
                `)
                $('#contentSrcUang').html(`
                  <input type="text" class="form-control" value="IDR" id="currencyId" readonly>
                `)
                $('#contentDstUang').html(`
                  <input type="text" class="form-control" value="IDR" readonly>
                `)
                $('#contentDstName').html(`
                  <input type="text" class="form-control" name="sd_pc_dst_name" value="${response.MP ? response.MP.ACCSRC_NAME : ''}" id="dstNameId" required readonly>
                `)
                // $('#contentGenderId').html(`
                //   <input type="text" class="form-control" name="sd_pc_gender" value="BELUM ADA DI RESPONSE" readonly id="genderId">
                // `)
                $('#contentGenderId').html(`
                  <input type="text" class="form-control" name="sd_pc_gender" value="L" readonly id="genderId">
                `)
                $('#contentDstCif').html(`
                  <input type="text" class="form-control" name="sd_pc_cif_dst" id="dstCifId" value="${response.MP ? response.MP.ACCSRC_CIF : ''}" required readonly>
                `)
                // $('#contentTanggalLahir').html(`
                //   <input type="text" class="form-control" name="sd_pc_dob" value="BELUM ADA DI RESPONSE" readonly required>
                // `)
                $('#contentTanggalLahir').html(`
                  <input type="text" class="form-control" name="sd_pc_dob" value="1998-05-20" readonly required>
                  <input type="hidden" class="form-control" name="acc_eq" id="eqId" readonly required>
                `)
                $('#jumlahDataValId').val(response.jumlah_data)
                $('#jumlahDataId').html(`<t class="font-weight-bold">${response.jumlah_data} Data</t>`)
                $('#sisaSlotId').val(response.sisa_slot)
                $('#sisaSlot').html(`Slot pendaftaran tersisa: &nbsp;<t style="color: red">${response.sisa_slot} Rekening</t>`)
                console.log(response.MP.ACC_EQ)
                $('#eqId').val(JSON.stringify(response.MP.ACC_EQ))

                var html = ''
                if(response.sisa_slot > 0){
                  html = `
                    <tr id="rowAddBtn">
                      <td class="text-start" colspan="12"><a href="javascript:void(0)" class="ml-2" onclick="addRow()"><i class="mdi mdi-plus"></i></a></td>
                    </tr>
                  `
                }
              }else{
                $('#contentSrcName').html(`
                  <input type="text" class="form-control" name="sd_pc_src_name" id="srcNameId" value="" required readonly>
                  <input type="hidden" class="form-control" name="sd_pc_src_intacc" id="srcIntacc" value="" required readonly>
                  <input type="hidden" class="form-control" name="sd_pc_src_branch" id="srcBranch" value="" required readonly>
                  <input type="hidden" class="form-control" name="sd_pc_src_extacc" id="extSrc" value="" required readonly>
                `)
                
                $('#contentSrcCif').html(`
                  <input type="text" class="form-control" name="sd_pc_cif_src" id="srcCifId" value="" required readonly>
                `)
                $('#contentSrcAcc').html(`
                  <input type="text" class="form-control" name="account_type_src" id="srcAccountType" value="" readonly>
                `)
                $('#contentDstAcc').html(`
                  <input type="text" class="form-control" id="dstAccountType" value="" readonly>
                `)
                $('#contentSrcUang').html(`
                  <input type="text" class="form-control" value="" id="currencyId" readonly>
                `)
                $('#contentDstUang').html(`
                  <input type="text" class="form-control" value="" readonly>
                `)
                $('#contentDstName').html(`
                  <input type="text" class="form-control" name="sd_pc_dst_name" value="" id="dstNameId" required readonly>
                `)
                // $('#contentGenderId').html(`
                //   <input type="text" class="form-control" name="sd_pc_gender" value="BELUM ADA DI RESPONSE" readonly id="genderId">
                // `)
                $('#contentGenderId').html(`
                  <input type="text" class="form-control" name="sd_pc_gender" value="" readonly id="genderId">
                `)
                $('#contentDstCif').html(`
                  <input type="text" class="form-control" name="sd_pc_cif_dst" id="dstCifId" value="" required readonly>
                `)
                // $('#contentTanggalLahir').html(`
                //   <input type="text" class="form-control" name="sd_pc_dob" value="BELUM ADA DI RESPONSE" readonly required>
                // `)
                $('#contentTanggalLahir').html(`
                  <input type="text" class="form-control" name="sd_pc_dob" value="" readonly required>
                `)
                $('#jumlahDataValId').val(0)
                $('#jumlahDataId').html(`<t class="font-weight-bold">0 Data</t>`)
                $('#sisaSlotId').val(5)
                $('#sisaSlot').html(`Slot pendaftaran tersisa: &nbsp;<t style="color: red">5 Rekening</t>`)
                $('#noRekUtama').val('')
                alert('Rekening tersebut tidak terdaftar Rekening EQ!')
              }
              $('#contentTujuanId').html(html)
            }else{
              // $('#contentDstName').html(`
              //   <input type="text" class="form-control" name="sd_pc_dst_name" id="dstNameId" value="${response.MP.ACCDST_NAME}" required readonly>
              //   <input type="hidden" class="form-control" name="sd_pc_dst_intacc" id="dstIntacc" value="${response.MP.ACCINTDST}" required readonly>
              //   <input type="hidden" class="form-control" name="sd_pc_dst_branch" id="srcBranch" value="${response.MP.ACCDST_BRANCH}" required readonly>
              // `)
              // $('#contentDstCif').html(`
              //   <input type="text" class="form-control" name="sd_pc_cif_dst" id="dstCifId" value="${response.MP.ACCDST_CIF}" required readonly>
              // `)
              $(`#contentDst${key}`).html(`
                <input type="hidden" name="ACCINTDST[]" value="${response.MP.ACCINTDST}">
                <input type="hidden" name="ACCDST_TYPE[]" value="${response.MP.ACCDST_TYPE}">
                <input type="hidden" name="ACCDST_CIF[]" value="${response.MP.ACCDST_CIF}">
                <input type="hidden" name="ACCDST_NAME[]" value="${response.MP.ACCDST_NAME}">
                <input type="hidden" name="ACCDST_BRANCH[]" value="${response.MP.ACCDST_BRANCH}">
                <input type="hidden" name="ACCEXTDST[]" value="${response.MP.ACCEXTDST}">
                <input type="hidden" name="ACCDST_CURRENCY[]" value="${response.MP.ACCDST_CURRENCY}">
              `)
              alert('OK')
            } 
          }else{
            if(response.MT == '2110'){
              $('#contentSrcName').html(`
              <input type="text" class="form-control" name="sd_pc_src_name" id="srcNameId" required readonly>
              `)
              $('#contentSrcCif').html(`
              <input type="text" class="form-control" name="sd_pc_cif_src" id="srcCifId" required readonly>
              `)
              $('#noRekUtama').val('')
            }else{
              // $('#contentDstName').html(`
              //   <input type="text" class="form-control" name="sd_pc_dst_name" id="dstNameId" required readonly>
              // `)
              // $('#contentDstCif').html(`
              //   <input type="text" class="form-control" name="sd_pc_cif_dst" id="dstCifId" required readonly>
              // `)
              $(`#noRekTujuan${key}`).val('')
            }
            alert(response.RC_DESC)
          }
        },
        error: function(xhr, status, thrown){
          alert('Error ajax call: ', xhr, ', ', thrown)
          console.log(status)
          $('#contentSrcName').html(`
          <input type="text" class="form-control" name="sd_pc_src_name" id="srcNameId" required readonly>
          `)
          $('#contentSrcCif').html(`
          <input type="text" class="form-control" name="sd_pc_cif_src" id="srcCifId" required readonly>
          `)
          $('#noRekUtama').val('')
          $('#contentDstName').html(`
            <input type="text" class="form-control" name="sd_pc_dst_name" id="dstNameId" required readonly>
          `)
          $('#contentDstCif').html(`
            <input type="text" class="form-control" name="sd_pc_cif_dst" id="dstCifId" required readonly>
          `)
        }
      })
    }

    // New Script
    
    function addRow(){
      var index = parseInt($('#sisaSlotId').val()) - 1
      var eqs   = JSON.parse($('#eqId').val())
      $('#sisaSlotId').val(index)
      $('#sisaSlot').html(`Slot pendaftaran tersisa: &nbsp;<t style="color: red">${index} Rekening</t>`)
      var indexJumlah = parseInt($('#jumlahDataValId').val()) + 1
      $('#jumlahDataValId').val(indexJumlah)
      $('#jumlahDataId').html(`<t class="font-weight-bold">${indexJumlah} Data</t>`)
      var days = JSON.parse("{{ $days }}")
      var value = parseInt($('#count').val()) + 1
      
      // <td>
      //   <input type="text" class="form-control norekClass" name="sd_pc_dst_extacc[]" onchange="validasiRekening('tujuan', this.value, ${value})" id="noRekTujuan${value}" placeholder="No Rekening Tujuan" style="width: 200px;" required>
      //   <div id="contentDst${value}">
      //   </div>
      // </td>
      var html = `<tr id="row${value}">
        <td class="row d-flex justify-content-center" style="width: 200px;">
          <a href="javascript:void(0)" class="btn btn-primary" onclick="simulasiPopUp(${value})" style="width: 45% !important; height: 40px !important;">Simulasi</a>
          <a href="javascript:void(0)" class="btn btn-danger" onclick="removeRow(${value})" style="width: 45% !important; height: 40px !important;"><i class="mdi mdi-delete"></i></a>
        </td>
        <td>
          <select type="text" class="form-control norekClass" name="sd_pc_dst_extacc[]" onchange="validasiRekening('tujuan', this.value, ${value})" id="noRekTujuan${value}" style="width: 200px;" required>
        `

      eqs.map(function(v, k){
        html += `<option value="${v}">${v}</option>`
      })

      html += `
          </select>
          <div id="contentDst${value}">
          </div>
        </td>
        <td>
          <input type="text" class="form-control" name="sp_pc_aim[]" placeholder="Nama Ahli Waris" style="width: 200px;">
        </td>
        <td>
          <input type="text" class="form-control uangMasking" name="sp_pc_target_amount[]" placeholder="Target Tabungan" style="width: 200px;" id="targetTabungan${value}">
        </td>
        <td>
          <input type="text" class="form-control" name="sp_pc_misi_utama[]" style="width: 200px;" placeholder="Misi Utama">
        </td>
        <td>
          <input type="text" class="form-control uangMasking" name="sp_pc_init_amount[]" placeholder="Setoran Awal" style="width: 200px;" id="setoranAwal${value}">
        </td>
        <td>
          <select class="form-control" name="sp_pc_jenis_period[]" onChange="functionInterval(this.value, ${value})" style="width: 200px;" id="intervalId${value}">
            <option value="">Pilih</option>
            <option value="3">Bulanan</option>
            <option value="1">Harian</option>
            <option value="2">Mingguan</option>
          </select>
        </td>
        <td id="penarikanDebet${value}">
          <input class="form-control" placeholder="Waktu Pendebetan" style="width: 200px;" readonly>
        `

        

        html += `</td>
        <td>
          <select class="form-control" onChange="functionTarget(this.value, ${value})" style="width: 200px;">
            <option value="2">Angsuran Berkala</option>
            <option value="1">Jangka Waktu</option>
          </select>
        </td>
        <td>
          <input type="text" class="form-control uangMasking" name="sd_pc_period_amount[]" id="setoranBerjangkaId${value}" style="width: 200px;" placeholder="Angsuran" onChange="functionAngsuran(this.value, ${value})" required>
        </td>
        <td>
          <input type="number" class="form-control number-only" name="sd_pc_period[]" id="jangkaWaktuId${value}" style="width: 200px;" placeholder="Jangka Waktu" onChange="functionJangkaWaktu(this.value, ${value})" readonly required>
        </td>
        <td>
          <input type="text" class="form-control uangMasking" name="sd_pc_period_amount_last[]" id="sisaAngsuran${value}" style="width: 200px;" placeholder="Sisa Angsuran" readonly required>
        </td>
        <td>
          <select class="form-control" onChange="functionNotif(this.value, ${value})" name="sd_pc_notif_flag[]" style="width: 200px;">
            <option value="0">Tidak Aktif</option>
            <option value="1">SMS</option>
            <option value="3">Email</option>
            <option value="4">SMS dan Email</option>
          </select>
        </td>
        <td>
          <input type="text" class="form-control" name="sd_pc_notif_phone[]" style="width: 200px;" placeholder="No Telepon" id="phoneId${value}" readonly>
        </td>
        <td>
          <input type="email" class="form-control" name="sd_pc_notif_email[]" style="width: 200px;" placeholder="Alamat Email" id="emailId${value}" readonly>
        </td>
      </tr>
      `
      $("#contentTujuanId").prepend(html)
      $('#count').val(value)

      btnPlusCheck()
      maskingInput()
      validateSymbol()
    }

    let arrayTujuan = []
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

    function functionInterval(value, key){
      var html      = `<input class="form-control" style="width: 200px;" placeholder="Waktu Pendebetan" readonly>`
      var days      = JSON.parse("{{ $days }}")
      var daysName  = JSON.parse($('#daysNameId').val())
      if(value != ''){
        if(value == '3'){
          html = `
            <select class="form-control" name="sp_pc_period_date[]" style="width: 200px;" id="tglMingguId${key}">
          `
          days.map(function(v, k){
            html += `<option value="${v}">${v}</option>`
          })
          html += `
            </select>
          `
        }
        if(value == '1'){
          html = `
            <select class="form-control" name="sp_pc_period_date[]" style="width: 200px;" id="tglMingguId${key}">
          `
          daysName.map(function(v, k){
            html += `<option value="${v.id}">${v.name}</option>`
          })
          html += `
            </select>
          `
        }
        return $(`#penarikanDebet${key}`).html(html)
      }
      $(`#penarikanDebet${key}`).html(html)
    }

    function functionTarget(value, key){
      if(value == '1'){
        $(`#setoranBerjangkaId${key}`).prop('readonly', true)
        $(`#jangkaWaktuId${key}`).prop('readonly', false)
      }else{
        $(`#setoranBerjangkaId${key}`).prop('readonly', false)
        $(`#jangkaWaktuId${key}`).prop('readonly', true)
      }
    }

    function functionAngsuran(value, key){
      var targetTabungan  = parseInt($(`#targetTabungan${key}`).val().replaceAll('.', ''))
      var angsuran        = parseInt(value.replaceAll('.', ''))
      var setoranAwal     = parseInt($(`#setoranAwal${key}`).val().replaceAll('.', ''))
      var hasil           = (targetTabungan - setoranAwal) / angsuran
      var sisa            = (targetTabungan - setoranAwal) % angsuran

      var btn             =  `<button type="submit" class="btn btn-primary login-btn" style="width: 48% !important;">Simpan</button>`
      $('#btnSubmitId').html(btn)

      hasil += 1;
      sisa  = sisa > 0 ? sisa : 0
      $(`#jangkaWaktuId${key}`).val(Math.floor(hasil))
      $(`#sisaAngsuran${key}`).val(number_format(sisa))
    }

    function functionJangkaWaktu(value, key){
      var jangkaWaktu     = parseInt(value)
      var targetTabungan  = parseInt($(`#targetTabungan${key}`).val().replaceAll('.', ''))
      var setoranAwal     = parseInt($(`#setoranAwal${key}`).val().replaceAll('.', ''))

      // var hasil           = targetTabungan / jangkaWaktu
      var hasil           = (targetTabungan - setoranAwal) / (jangkaWaktu - 1)
      var sisa            = 0
      var count           = hasil
      
      var btn             =  `<button type="submit" class="btn btn-primary login-btn" style="width: 48% !important;">Simpan</button>`
      $('#btnSubmitId').html(btn)

      sisa  = sisa > 0 ? sisa : 0
      $(`#setoranBerjangkaId${key}`).val(number_format(hasil))
      $(`#sisaAngsuran${key}`).val(sisa)
    }

    function functionNotif(value, key){
      $(`#phoneId${key}`).prop('readonly', true)
      $(`#emailId${key}`).prop('readonly', true)
      if(value == '1'){
        $(`#phoneId${key}`).prop('readonly', false)
        $(`#emailId${key}`).prop('readonly', true)
      }
      if(value == '3'){
        $(`#phoneId${key}`).prop('readonly', true)
        $(`#emailId${key}`).prop('readonly', false)
      }
      if(value == '4'){
        $(`#phoneId${key}`).prop('readonly', false)
        $(`#emailId${key}`).prop('readonly', false)
      }
    }
	</script>
@endpush