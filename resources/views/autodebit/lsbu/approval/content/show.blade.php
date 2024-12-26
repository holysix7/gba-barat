<div class="container-fluid">
  <input type="hidden" value="{{$role}}" id="roleRecordId">
  <div class="row">
    <div class="col-sm-12">
      <div class="m-4">
        <div class="row">
          <div class="col-sm-6">
            <h4>Informasi Rekening Sumber</h4>
          </div>
          <div class="col-sm-6">
            <h4>Informasi Autodebit</h4>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-5 mt-1">
                <label>Jenis Produk</label>
              </div>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="sd_pc_pid" value="{{ $record->sd_pc_pid }}" readonly>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-5 mt-1">
                <label>Tanggal Registrasi</label>
              </div>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="sp_pc_reg_date" value="{{ $record->sp_pc_reg_date }}" readonly>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-5 mt-1">
                <label>Nomor Rekening Sumber</label>
              </div>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="sd_pc_src_extacc" value="{{ $record->sd_pc_src_extacc }}" readonly>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-5 mt-1">
                <label>Tanggal Penutupan</label>
              </div>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="sp_pc_settle_date" value="{{ $record->statusEditApproved ? $record->dataEditApproved->sp_pc_settle_date_format : $record->sp_pc_settle_date_format }}" readonly>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-5 mt-1">
                <label>Nama Rekening Sumber</label>
              </div>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="sp_pc_src_name" value="{{ $record->sp_pc_src_name }}" readonly>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            @if($record->update_lsbu)
              <div class="row">
                <div class="col-sm-5 mt-1">
                  <label>Tanggal Debet <label style="color: red;">(Sebelum diubah)</label></label>
                </div>
                <div class="col-sm-7">
                  <input type="text" class="form-control" value="{{ $record->sp_pc_period_date }}" readonly>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-5 mt-1">
                  <label>Tanggal Debet <label style="color: red;">(Sesudah diubah)</label></label>
                </div>
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="sp_pc_period_date" value="{{ $record->update_lsbu->sp_pc_period_date }}" readonly>
                </div>
              </div>
            @else
              <div class="row">
                <div class="col-sm-5 mt-1">
                  <label>Tanggal Debet</label>
                </div>
                <div class="col-sm-7">
                  <input type="text" class="form-control" name="sp_pc_period_date" value="{{ $record->sp_pc_period_date }}" readonly>
                </div>
              </div>
            @endif
          </div>
        </div>
        <div class="row mt-4 justify-content-end">
          <div class="col-sm-6">
            @if($record->update_lsbu)
              <div class="row">
                <div class="col-sm-5 mt-1">
                  <label>Setoran Bulanan <label style="color: red;">(Sebelum diubah)</label></label>
                </div>
                <div class="col-sm-7">
                  <input type="text" class="form-control" value="{{ getRupiah($record->sp_pc_period_amount) }}" readonly>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-5 mt-1">
                  <label>Setoran Bulanan <label style="color: red;">(Sesudah diubah)</label></label>
                </div>
                <div class="col-sm-7">
                  <input type="hidden" class="form-control" name="sp_pc_period_amount" value="{{ $record->update_lsbu->sp_pc_period_amount }}" readonly>
                  <input type="text" class="form-control" value="{{ getRupiah($record->update_lsbu->sp_pc_period_amount) }}" readonly>
                </div>
              </div>
            @else
              <div class="row">
                <div class="col-sm-5 mt-1">
                  <label>Setoran Bulanan</label>
                </div>
                <div class="col-sm-7">
                  <input type="hidden" class="form-control" name="sp_pc_period_amount" value="{{ $record->sp_pc_period_amount }}" readonly>
                  <input type="text" class="form-control" value="{{ getRupiah($record->sp_pc_period_amount) }}" readonly>
                </div>
              </div>
            @endif
          </div>
        </div>
        <div class="row mt-4 justify-content-end">
          <div class="col-sm-6">
            @if($record->update_lsbu)
              <div class="row">
                <div class="col-sm-5 mt-1">
                  <label>Jangka Waktu <label style="color: red;">(Sebelum diubah)</label></label>
                </div>
                <div class="col-sm-7">
                  <input type="text" class="form-control" value="{{ $record->sp_pc_period }} Bulan" readonly>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-5 mt-1">
                  <label>Jangka Waktu <label style="color: red;">(Sesudah diubah)</label></label>
                </div>
                <div class="col-sm-7">
                  <input type="hidden" class="form-control" name="sp_pc_period" value="{{ $record->update_lsbu->sp_pc_period }}" readonly>
                  <input type="text" class="form-control" value="{{ $record->update_lsbu->sp_pc_period }} Bulan" readonly>
                </div>
              </div>
            @else
              <div class="row">
                <div class="col-sm-5 mt-1">
                  <label>Jangka Waktu</label>
                </div>
                <div class="col-sm-7">
                  <input type="hidden" class="form-control" name="sp_pc_period" value="{{ $record->sp_pc_period }}" readonly>
                  <input type="text" class="form-control" value="{{ $record->sp_pc_period }} Bulan" readonly>
                </div>
              </div>
            @endif
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-sm-6">
            <label>Informasi Rekening</label>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-5 mt-1">
                <label>No Rekening Tujuan</label>
              </div>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="sd_pc_dst_extacc" value="{{ $record->sd_pc_dst_extacc }}" readonly>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-4 mt-1">
                <label>Jenis Approval</label>
              </div>
              <div class="col-sm-7" style="margin-left: 49px;">
                <input type="text" class="form-control" style="width: 386px;" value="{{ $record->sp_pc_approval_status_desc }}" readonly>
                <input type="hidden" class="form-control" name="sp_pc_approval_status" value="{{ $record->sp_pc_approval_status }}" id="approvalStatus" readonly>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-5 mt-1">
                <label>Nama Rekening Tujuan</label>
              </div>
              <div class="col-sm-7">
                <input type="text" class="form-control" name="sp_pc_dst_name" value="{{ $record->sp_pc_dst_name }}" readonly>
                <input type="hidden" class="form-control" name="sp_pc_approval_status" value="{{ $record->sp_pc_approval_status }}" id="approvalType" readonly>
                <input type="hidden" class="form-control" name="status" id="conditionId">
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="row">
              <div class="col-sm-4 mt-1">
                <label>Catatan Perbaikan</label>
              </div>
              <div class="col-sm-7" style="margin-left: 49px;">
                <textarea class="form-control" name="sp_pc_rejected_notes" style="width: 386px;" rows="4" readonly>{{ $record->sp_pc_rejected_notes }}</textarea>
              </div>
            </div>
          </div>
        </div>
        @if($record->sp_pc_approval_status != 4)
          <div class="row mt-4 justify-content-end">
            <div class="col-sm-3">
              <a href="javascript:void(0)" class="btn btn-danger login-btn" onclick="rejectModal('{{ $record->routerejected }}', '{{ $record->sd_pc_dst_extacc }}', false)">Reject</a>
            </div>
            <div class="col-sm-3">
              <a href="javascript:void(0)" class="btn btn-primary login-btn" onclick="rejectModal('{{ $record->routeapproved }}', '{{ $record->sd_pc_dst_extacc }}', true)">Approved</a>
            </div>
          </div>
        @endif
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
    var html = `<div class="w-80 ml-4 mr-4">
      <div class="row">
        <div class="col-md-12">
          <label>Username</label>
          <input type="text" class="form-control" name="username" id="usernameId" placeholder="Username">
          <input type="hidden" class="form-control" name="sd_pc_dst_extacc" id="tujuanId" >
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <label>Password</label>
          <input type="password" class="form-control" name="password" id="passwordId" placeholder="Password">
        </div>
      </div>
      <div class="row" id="contentReject">
        <div class="col-md-12">
          <label>Catatan Perbaikan</label>
          <textarea class="form-control" id="rejectedNotes" name="sp_pc_rejected_notes"></textarea>
        </div>
      </div>
      <div class="row pt-2">
        <div class="col-md-12 d-flex justify-content-end">
          <a href="javascript:void(0)" class="btn btn-primary" id="checkingSpv">Konfirmasi</a>
        </div>
      </div>
    </div>`
    $('#contentRejected').html(html)

    $('#checkingSpv').on('click', function(){
      $.ajax({
        url: "{{ route('autodebit.lsbu.approval.checking_spv') }}",
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          id: $('#tujuanId').val(),
          username: $('#usernameId').val(),
          password: $('#passwordId').val(),
          sp_pc_rejected_notes: $('#rejectedNotes').val() ? $('#rejectedNotes').val() : null,
          approval_type: $('#approvalType').val(),
          status: $('#conditionId').val()
        },
        success: function(response){
          alert(response.message)
          window.location.replace("{{ route('autodebit.lsbu.approval') }}");
        },
        error: function(error){
          alert(error)
          console.log(error)
        }
      })
    })
  })
  function rejectModal(route, tujuanId, condition){
    $('#routeRejected').attr('action', route)
    $('#tujuanId').val(JSON.stringify([tujuanId]))
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