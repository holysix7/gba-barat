<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="m-4">
          <div class="row m-2 mt-4">
            <div class="d-flex w-100">
              <form method="POST" action="{{ route('autodebit.mygoals.daftar-rekening.update', $record->id) }}" enctype="multipart/form-data" class="w-100">
                @csrf
                <div class="justify-content-center">
                  <div class="row d-flex justify-content-between">
                    <div class="col-sm-6 form-group pt-1">
                      <canvas id="donutChart" style="width: 100%; height: 250px"></canvas>
                    </div>
                    <div class="col-sm-5 form-group pt-1 mt-4">
                      <div class="row mt-4">
                        <div class="col-sm-4">
                          <label class="form-label-bold">Jenis Produk</label>
                        </div>
                        <div class="col-sm-4">
                          @if($record->sd_pc_status == 1)
                            <span class="badge badge-success status-span" style="width: 100% !important; height: 39px !important; border-radius: 7px;">Aktif<i class="fa fa-check"></i></span>
                          @elseif($record->sd_pc_status == 2)
                            <span class="badge badge-danger status-span" style="width: 100% !important; height: 39px !important; border-radius: 7px;">Tutup Normal<i class="fa fa-check"></i></span>
                          @elseif($record->sd_pc_status == 3)
                            <span class="badge badge-primary status-span" style="width: 100% !important; height: 39px !important; border-radius: 7px;">Mid-Term<i class="fa fa-check"></i></span>
                          @elseif($record->sd_pc_status == 4)
                            <span class="badge badge-primary status-span" style="width: 100% !important; height: 39px !important; border-radius: 7px;">Mid-Term Manual (via User)<i class="fa fa-check"></i></span>
                          @elseif($record->sd_pc_status == 5)
                            <span class="badge badge-warning status-span" style="width: 100% !important; height: 39px !important; border-radius: 7px;">Tunda<i class="fa fa-check"></i></span>
                          @else
                            <span class="badge badge-success status-span" style="width: 100% !important; height: 39px !important; border-radius: 7px;">Aktif Migrasi<i class="fa fa-check"></i></span>
                          @endif
                        </div>
                        <div class="col-sm-4">
                          <a href="javascript:void(0)" class="btn btn-primary d-flex justify-content-between" style="width: 100% !important;" onclick="ubahFunction({{$record->id}})"><i class="mdi mdi-tooltip-edit"></i> Ubah Status</a>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-7">
                          <label class="form-label-bold">Jangka waktu autodebet berjalan</label>
                        </div>
                        <div class="col-sm-1">
                          <label class="form-label-bold">:</label>
                        </div>
                        <div class="col-sm-4">
                          <label class="form-label-bold">{{$record->counted_success}}</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-7">
                          <label class="form-label-bold">Jumlah saldo pada rekening berjangka</label>
                        </div>
                        <div class="col-sm-1">
                          <label class="form-label-bold">:</label>
                        </div>
                        <div class="col-sm-4">
                          <label class="form-label-bold">{{getRupiah($record->saldo_berjangka)}}</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-7">
                          <label class="form-label-bold">Jumlah saldo sukses autodebet</label>
                        </div>
                        <div class="col-sm-1">
                          <label class="form-label-bold">:</label>
                        </div>
                        <div class="col-sm-4">
                          <label class="form-label-bold">{{getRupiah($record->saldo_success_autodebet)}}</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-7">
                          <label class="form-label-bold">Jumlah saldo gagal autodebet</label>
                        </div>
                        <div class="col-sm-1">
                          <label class="form-label-bold">:</label>
                        </div>
                        <div class="col-sm-4">
                          <label class="form-label-bold">{{getRupiah($record->saldo_fail_autodebet)}}</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Jenis Produk</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Jenis Produk" value="{{$record->product ? $record->product->sp_p_name : null}}" readonly required>
                    </div>
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">No Rekening Berjangka</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="No Rekening Berjangka" value="{{$record->sd_pc_dst_extacc}}" readonly required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Nomor Rekening Utama</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="No Rekening Utama" value="{{$record->sd_pc_src_intacc}}" readonly required>
                    </div>
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Nama Pemilik Rekening Berjangka</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Nama Pemilik Rekening Berjangka" value="{{$record->sd_pc_dst_name}}" readonly required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Nama Pemilik Rekening Utama</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Nama Pemilik Rekening Utama" value="{{$record->sd_pc_src_name}}" readonly required>
                    </div>
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Jenis Kelamin</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Jenis Kelamin" value="{{$record->sd_pc_gender}}" readonly required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">CIF Source</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="CIF Source" value="{{$record->sd_pc_cif_src}}" readonly required>
                    </div>
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">CIF Destination</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="CIF Destination" value="{{$record->sd_pc_cif_dst}}" readonly required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Account Type</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Account Type" value="di lewat dulu" readonly required>
                    </div>
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Account Type</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Account Type" value="di lewat dulu" readonly required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Currency</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Currency" value="{{$record->product ? $record->product->sp_p_currency : null}}" readonly required>
                    </div>
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Currency</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Currency" value="{{$record->product ? $record->product->sp_p_currency : null}}" readonly required>
                    </div>
                  </div>
                  <div class="row d-flex justify-content-end">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Misi Utama</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Setoran Awal" value="{{$record->sd_pc_misi_utama}}" readonly required>
                    </div>
                  </div>
                  <div class="row d-flex justify-content-end">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Target Tabungan</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Setoran Awal" value="{{$record->sd_pc_goals_amount}}" readonly required>
                    </div>
                  </div>
                  <div class="row d-flex justify-content-end">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Setoran Awal</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Setoran Awal" value="{{$record->sd_pc_init_amount}}" readonly required>
                    </div>
                  </div>
                  <div class="row d-flex justify-content-end">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Setoran Berjangka</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Setoran Berjangka" value="{{$record->sd_pc_period_amount}}" readonly required>
                    </div>
                  </div>
                  <div class="row d-flex justify-content-end">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Interval Jatuh Tempo</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="text" class="form-control" placeholder="Setoran Berjangka" value="{{$record->sd_pc_period_interval_text}}" readonly required>
                    </div>
                  </div>
                  <div class="row d-flex justify-content-end" style="height: 55px !important;">
                    <div class="col-sm-6">
                      <div class="row">
                        <div class="col-sm-3 form-group pt-1">
                          <label class="form-label-bold">Jangka Waktu <br> <p style="color: red; font-style: italic;">*Itungan Bulan</p></label>
                        </div>
                        <div class="col-sm-3 form-group">
                          <input type="text" class="form-control" placeholder="Jangka Waktu" value="{{$record->sd_pc_period}}" readonly required>
                        </div>
                        <div class="col-sm-3 form-group pt-1">
                          <label class="form-label-bold">Tanggal Debet</label>
                        </div>
                        <div class="col-sm-3 form-group">
                          <input type="text" class="form-control" placeholder="Tanggal Debet" value="{{$record->sd_pc_period_date}}" readonly required>
                          <input type="hidden" value="{{$record->counted_success}}" id="successValue" readonly required>
                          <input type="hidden" value="{{$record->counted_fail}}" id="failValue" readonly required>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row d-flex justify-content-end">
                    <div class="col-sm-2 form-group pt-1">
                      <label class="form-label-bold">Tanggal Lahir</label>
                    </div>
                    <div class="col-sm-4 form-group">
                      <input type="date" class="form-control" value="{{$record->sd_pc_dob}}" readonly required>
                      <input type="hidden" class="form-control" value="4" readonly required>
                    </div>
                  </div>

                  <input type="hidden" name="id" value="{{$record->id}}">
                  <input type="hidden" name="condition" value="0">
                  <div class="row">
                    <div class="col-md-12 d-flex justify-content-end">
                      <button type="submit" class="btn btn-danger" id="saveButton">Tutup Rekening </button>
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
</section>

<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
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
        <form method="POST" action="{{ route('autodebit.mygoals.daftar-rekening.update', $record->id) }}" enctype="multipart/form-data" class="w-100">
          @csrf
          <div class="row mb-4">
            <div class="col-md-12">
              <div class="row pt-2">
                <div class="col-sm-6" id="nomorRekeningLabelId">
                  <div class="skeleton-box text-skeleton" style="width:180px"></div>
                </div>
                <div class="col-sm-1">:</div>
                <div class="col-sm-5" id="nomorRekeningId">
                  <div class="skeleton-box text-skeleton" style="width:180px"></div>
                </div>
              </div>
              <div class="row pt-2">
                <div class="col-sm-6" id="namaNasabahLabelId">
                  <div class="skeleton-box text-skeleton" style="width:180px"></div>
                </div>
                <div class="col-sm-1">:</div>
                <div class="col-sm-5" id="namaNasabahid">
                  <div class="skeleton-box text-skeleton" style="width:180px"></div>
                </div>
              </div>
              <div class="row pt-2">
                <div class="col-sm-6" id="statusAutodebetLabelId">
                  <div class="skeleton-box text-skeleton" style="width:180px"></div>
                </div>
                <div class="col-sm-1">:</div>
                <div class="col-sm-5" id="statusAutodebetId">
                  <div class="skeleton-box text-skeleton" style="width:180px"></div>
                </div>
              </div>
              <br>
              <div class="col-sm-5" id="idGoals">
                <div class="skeleton-box text-skeleton" style="width:180px"></div>
              </div>
            </div>
          </div>
          <input type="hidden" name="condition" value="1">
          <div class="row m-2">
            <div class="col-sm-6">
              <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close" style="width: 100% !important;">Batalkan</button>
            </div>
            <div class="col-sm-6">
              <button type="submit" class="btn btn-primary" style="width: 100% !important;">Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    var labels = ["Sukses Autodebet", "Gagal Autodebet"]
    var values = [$('#successValue').val(), $('#failValue').val()]
    var colors = [
      "#06AAE9",
      "#FBB03B"
    ]
    var donutChart = new Chart($('#donutChart'), {
      type: 'doughnut',
      data: {
        labels: labels,
        datasets: [{
          backgroundColor: colors,
          data: values
        }]
      },
      options: {
        title: {
          display: true,
          text: 'Monitoring Autodebet',
          fontSize: 20
        },
        tooltips: {
          callbacks: {
            labelTextColor: function(tooltipItem, data){
              return colors[tooltipItem.index]
            },
            afterLabel: function(tooltipItem, data){
              var dataset = data['datasets'][0]
              var percent = Math.round((dataset['data'][tooltipItem['index']] / dataset['_meta'][0]['total']) * 100)
              return `(${percent} %)`
            }
          },
          backgroundColor: '#FFFFFF',
          bodyFontSize: 16,
          displayColors: true
        }
      }
    })
    
    logActivity(JSON.stringify([
      'View', 
      'Melihat rincian data',
      'savdep_product_customer_mygoals', 
      'General',
      '{{ Route::current()->getName() }}'
    ]))
  })

  function ubahFunction(id){
    $('#infoModal').modal('show')
    
    $.ajax({
      url: "{{ route('autodebit.mygoals.daftar-rekening.ajax.show_goals') }}",
      type: 'POST',
      data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        id: id
      },
      success: function(res) {
        if (res) {
          const {
            id,
            sd_pc_src_intacc,
            sd_pc_src_name,
            sd_pc_status,
          } = res
          
          $('.request_title').html(`Ubah Status Autoebet`)
          $('#nomorRekeningLabelId').html(`<label class="form-label-bold">Nomor Rekening</label>`)
          $('#nomorRekeningId').html(`<label class="form-label-bold">${sd_pc_src_intacc}</label>`)
          $('#namaNasabahLabelId').html(`<label class="form-label-bold">Nama Nasabah</label>`)
          $('#namaNasabahid').html(`<label class="form-label-bold">${sd_pc_src_name}</label>`)
          $('#statusAutodebetLabelId').html(`<label class="form-label-bold">Status Autodebet</label>`)
          $('#statusAutodebetId').html(`
            <select class="form-control" id="statusAutodebetVal" name="sd_pc_status">
              <option value="1">Lanjutkan (Aktif)</option>
              <option value="5">Tunda</option>
            </select>
          `)
          $('#statusAutodebetVal').val(sd_pc_status)
          $('#idGoals').html(`<input type="hidden" name="id" value="${id}">`)
        }
      }
    })
  }
</script>
@endsection