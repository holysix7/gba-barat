<div class="container-fluid">
  <input type="hidden" value="{{$role}}" id="roleRecordId">
  <div class="row">
    <div class="col-sm-12">
      <div class="m-4">
        <div class="row m-2 mt-4">
          <div class="d-flex w-100">
            <div class="justify-content-center w-100">
              <div class="row">
                <div class="col-sm-6 form-group">
                  <h3>Informasi Rekening Sumber</h3>
                </div>
                <div class="col-sm-6 form-group">
                  <h3>Informasi Rekening Berjangka</h3>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6 form-group">
                  <label class="form-label-bold">Jenis Produk</label>
                  <input type="text" class="form-control" name="sd_pc_pid" value="{{$record->sd_pc_pid}}" readonly>
                </div>
                <div class="col-sm-6 form-group">
                  <label class="form-label-bold">No Rekening Berjangka</label>
                  <input type="number" class="form-control number-only" name="sd_pc_dst_extacc" value="{{$record->sd_pc_dst_extacc}}" readonly>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6 form-group">
                  <label class="form-label-bold">Jenis Tabungan</label>
                  <input type="text" class="form-control" value="Giro" readonly>
                </div>
                <div class="col-sm-6 form-group">
                  <label class="form-label-bold">Nama Pemilik Rekening Berjangka</label>
                  <input type="text" class="form-control" name="sp_pc_dst_name" value="{{$record->sp_pc_dst_name}}" readonly>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6 form-group">
                  <label class="form-label-bold">Nomor Rekening Utama</label>
                  <input type="number" class="form-control number-only" name="sd_pc_src_extacc" value="{{$record->sd_pc_src_extacc}}" readonly>
                </div>
                <div class="col-sm-6 form-group">
                  <label class="form-label-bold">Jenis Kelamin</label>
                  <input type="text" class="form-control" name="sp_pc_gender" value="{{$record->sp_pc_gender}}" readonly>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6 form-group">
                  <label class="form-label-bold">Nama Pemilik Rekening Utama</label>
                  <input type="text" class="form-control" name="sp_pc_src_name" value="{{$record->sp_pc_src_name}}" readonly>
                </div>
                <div class="col-sm-6 form-group">
                  <label class="form-label-bold">Tanggal Lahir</label>
                  <input type="date" class="form-control" name="sp_pc_dob" value="{{$record->sp_pc_dob}}" readonly>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6 form-group">
                  <label class="form-label-bold">CIF Source</label>
                  <input type="text" class="form-control" name="sp_pc_cif_sumber" value="{{$record->sp_pc_cif_sumber}}" readonly>
                </div>
                <div class="col-sm-6 form-group">
                  <label class="form-label-bold">CIF Destination</label>
                  <input type="text" class="form-control" name="sp_pc_cif_sumber" value="{{$record->sp_pc_cif_sumber}}" readonly>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6 form-group">
                  <label class="form-label-bold">Currency</label>
                  <input type="text" class="form-control" value="IDR" id="currencyId" readonly>
                </div>
                <div class="col-sm-6 form-group">
                  <label class="form-label-bold">Currency</label>
                  <input type="text" class="form-control" value="IDR" readonly>
                </div>
              </div>
              
              <div class="row d-flex justify-content-start">
                <div class="col-sm-6 form-group d-flex align-items-center">
                  <h3>Notifikasi</h3>
                </div>
                {{-- <div class="col-sm-6 form-group">
                  <label class="form-label-bold">Mygoals</label>
                  <input type="text" class="form-control" name="sd_pc_misi_utama">
                </div> --}}
              </div>
              <div class="row d-flex justify-content-end">
                <div class="col-sm-6 form-group">
                  <label class="form-label-bold">Layanan Notifikasi</label>
                  <input type="text" class="form-control" value="{{ $record->sp_pc_notif_flag_name }}" readonly required>
                  <input type="hidden" class="form-control" name="sp_pc_notif_flag" value="{{ $record->sp_pc_notif_flag }}" readonly required>
                </div>
                <div class="col-sm-6 form-group">
                  <label class="form-label-bold">Target Tabungan</label>
                  <input type="text" class="form-control" value="{{ getRupiah($record->sp_pc_target_amount) }}" readonly>
                  <input type="hidden" class="form-control" name="sp_pc_target_amount" value="{{ $record->sp_pc_target_amount }}">
                </div>
              </div>
              <div class="row d-flex justify-content-end">
                <div class="col-sm-6 form-group" id="flagIdSatu">
                  @if($record->sp_pc_notif_flag > 0)
                    @if($record->sp_pc_notif_flag == 3)
                      <label class="form-label-bold">Alamat Email</label>
                      <input type="text" class="form-control" name="sp_pc_notif_email" value="{{ $record->sp_pc_notif_email }}" readonly>
                    @else
                      <label class="form-label-bold">Nomor Telepon</label>
                      <input type="text" class="form-control" name="sp_pc_notif_phone" value="{{ $record->sp_pc_notif_phone }}" readonly>
                    @endif
                  @endif
                </div>
                <div class="col-sm-6 form-group">
                  <label class="form-label-bold">Setoran Awal</label>
                  <input type="text" class="form-control" value="{{ getRupiah($record->sp_pc_init_amount) }}" readonly>
                  <input type="hidden" class="form-control" name="sp_pc_init_amount" value="{{ $record->sp_pc_init_amount }}">
                </div>
              </div>
              <div class="row d-flex justify-content-end">
                <div class="col-sm-6 form-group" id="flagIdDua">
                  @if($record->sp_pc_notif_flag > 0)
                    @if($record->sp_pc_notif_flag == 3)
                      <label class="form-label-bold">Alamat Email</label>
                      <input type="text" class="form-control" name="sp_pc_notif_email" value="{{ $record->sp_pc_notif_email }}" readonly>
                    @endif
                  @endif
                </div>
                <div class="col-sm-6 form-group d-flex align-items-end">
                  <h3>Jangka Waktu Tabungan Berjangka</h3>
                </div>
              </div>
              <div class="row d-flex justify-content-end">
                <div class="col-sm-6 form-group">
                  <label class="form-label-bold">Metode Pendebetan</label>
                  <input type="text" class="form-control" value="{{ $record->sp_pc_jenis_period_name }}" readonly>
                  <input type="hidden" class="form-control" name="sp_pc_jenis_period" value="{{ $record->sp_pc_jenis_period }}" readonly>
                </div>
              </div>
              <div class="row d-flex justify-content-end" id="contentIntervalId">
              </div>
              <div class="row d-flex justify-content-end">
                <div class="col-sm-6 form-group">
                  <label class="form-label-bold">Jangka Waktu</label>
                  <input type="number" class="form-control number-only" name="sp_pc_period" value="{{ $record->sp_pc_period }}" readonly>
                </div>
              </div>
              <div class="row d-flex justify-content-end">
                <div class="col-sm-6 form-group">
                  <label class="form-label-bold">Setoran Berjangka</label>
                  <input type="text" class="form-control" value="{{ getRupiah($record->sp_pc_period_amount) }}" readonly>
                  <input type="hidden" class="form-control number-only currency-format" name="sp_pc_period_amount" value="{{ $record->sp_pc_period_amount }}" readonly>
                  <input type="hidden" class="form-control" name="sp_pc_jenis_lanjut" value="{{ $record->sp_pc_jenis_lanjut }}" id="jenisLanjut" >
                </div>
              </div>
              <div class="row d-flex justify-content-end" id="spAmountLastId">
              </div>
              <hr>
              <div class="row d-flex justify-content-end">
                <div class="col-sm-6 d-flex justify-content-end">
                  <div class="row w-75">
                    <div class="col-sm-6">
                      <a href="javascript:void(0)" class="btn btn-danger w-100" onclick="rejectModal('{{$record->routerejected}}', '{{request()->segment(5)}}')">Reject</a>
                    </div>
                    <div class="col-sm-6">
                      @if($record->typeApproval)
                        <a href="javascript:void(0)" class="btn btn-primary w-100" onclick="rejectModal('{{ $record->routeapproved }}', '{{ $record->sd_pc_dst_extacc }}', true, '{{ $record->sp_pc_jenis_lanjut }}')">Approve</a>
                      @else
                        <a href="javascript:void(0)" class="btn btn-primary w-100" onclick="rejectModal('{{$record->routeapproved}}', '{{$record->sd_pc_dst_extacc}}', true, '')">Approve</a>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
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
      <div class="modal-body" id="contentRejected">
      </div>
    </div>
  </div>
</div>

@push('script')
<script type="text/javascript">
  $(document).ready(function(){
    var status = false
    var role = $('#roleRecordId').val() ? JSON.parse($('#roleRecordId').val()) : null
    if(role != null){
      status = true
    }
    
    var html = `<div class="w-80 ml-4 mr-4">
      <div class="row">
        <div class="col-md-12">
          <label>Username</label>
          <input type="text" class="form-control" name="username" id="usernameId" placeholder="Username">
          <input type="hidden" class="form-control" name="sd_pc_dst_extacc" id="myGoalsId" >
          <input type="hidden" class="form-control" name="status" id="conditionId">
          <input type="hidden" class="form-control" name="approval_type" value="{{ $record->approval_type }}" id="approvalType">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <label>Password</label>
          <input type="password" class="form-control" name="password" id="passwordId" placeholder="Password">
        </div>
      </div>
      <div class="row" id="contentRejectGjd">
      </div>
      <div class="row pt-2">
        <div class="col-md-12 d-flex justify-content-end">
          <a href="javascript:void(0)" class="btn btn-primary" id="checkingSpv">Konfirmasi</a>
        </div>
      </div>
    </div>`
    
    // if(status == true){
    //   html = `<form action="" id="routeRejected" method="GET" enctype="multipart/form-data" class="w-80 ml-4 mr-4">
    //     @csrf
    //     <div class="row">
    //       <div class="col-md-12">
    //         <label>Catatan Perbaikan</label>
    //         <textarea class="form-control" id="rejectedNotes" name="sd_pc_rejected_notes"></textarea>
    //       </div>
    //     </div>
    //     <div class="row pt-2">
    //       <div class="col-md-12 d-flex justify-content-end">
    //         <button type="submit" class="btn btn-primary">Konfirmasi</button>
    //       </div>
    //     </div>
    //   </form>`
    // }
    $('#contentRejected').html(html)

    $('#checkingSpv').on('click', function(){
      $.ajax({
        url: "{{ route('autodebit.mygoals.approval.checking_spv') }}",
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          id: $('#myGoalsId').val(),
          username: $('#usernameId').val(),
          password: $('#passwordId').val(),
          sd_pc_rejected_notes: $('#rejectedNotes').val(),
          approval_type: $('#approvalType').val(),
          sp_pc_jenis_lanjut: $('#jenisLanjut').val(),
          status: $('#conditionId').val()
        },
        success: function(response){
          console.log(response)
          alert(response.message)
          window.location.replace("{{ route('autodebit.mygoals.approval') }}");
        },
        error: function(error){
          alert(error)
        }
      })
    })
  })
  
  function rejectModal(route, sd_pc_dst_extacc, condition, sp_pc_jenis_lanjut){
    $('#routeRejected').attr('action', route)
    $('#myGoalsId').val(sd_pc_dst_extacc)
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