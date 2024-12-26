<div class="row">
  <div class="col-sm-12">
    @if(Session::get('user')->kodeKanwil == '0000')
      <div class="row mb-4">
        <div class="col-sm-12">
          <label>Pilih Kantor Wilayah</label>
          <select class="form-control select2" id="filterKanwilId">
            <option value="ALL">Semua Wilayah</option>
            @foreach($wilayah as $row)
              <option value="{{ $row->kode_wilayah }}">{{ $row->kode_wilayah }} | {{ $row->nama_wilayah }}</option>
            @endforeach
          </select>
        </div>
      </div>
    @endif
    <div class="row">
      <div class="col-sm-3">
        <div class="card p-4" style="background: #DFF9FB">
          <div class="row">
            <div class="col-sm-12" id="terdaftarIdLsbu">
              <div class="row">
                <div class="skeleton-box text-skeleton w-100"></div>
              </div>
              <div class="row">
                <div class="skeleton-box text-skeleton w-100 mt-2"></div>
              </div>
              <div class="row">
                <div class="skeleton-box text-skeleton w-100 mt-2"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="card p-4" style="background: #ffe6a1">
          <div class="row">
            <div class="col-sm-12" id="pendaftaranIdLsbu">
              <div class="row">
                <div class="skeleton-box text-skeleton w-100"></div>
              </div>
              <div class="row">
                <div class="skeleton-box text-skeleton w-100 mt-2"></div>
              </div>
              <div class="row">
                <div class="skeleton-box text-skeleton w-100 mt-2"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="card p-4" style="background: #ffbdbd">
          <div class="row">
            <div class="col-sm-12" id="berjalanIdLsbu">
              <div class="row">
                <div class="skeleton-box text-skeleton w-100"></div>
              </div>
              <div class="row">
                <div class="skeleton-box text-skeleton w-100 mt-2"></div>
              </div>
              <div class="row">
                <div class="skeleton-box text-skeleton w-100 mt-2"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="card p-4" style="background: #b8ffc6">
          <div class="row">
            <div class="col-sm-12" id="selesaiIdLsbu">
              <div class="row">
                <div class="skeleton-box text-skeleton w-100"></div>
              </div>
              <div class="row">
                <div class="skeleton-box text-skeleton w-100 mt-2"></div>
              </div>
              <div class="row">
                <div class="skeleton-box text-skeleton w-100 mt-2"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-sm-12">
        <h4>Chart Autodebit</h4>
      </div>
    </div>
    <div class="row mt-2 justify-content-center">
      <div class="col-sm-9">
        <canvas id="myChartLsbu"></canvas>
      </div>
      <div class="col-sm-2 mt-4" id="spanIdLsbu">
      </div>
    </div>
  </div>
</div>

@push('script')
<script type="text/javascript">
  $(document).ready(function(){
    loadLsbu()
    $('#filterKanwilId').on('change', function(){
      loadLsbu()
    })
    $('.select2').select2()
  })

  function loadLsbu(){
    $.ajax({
      url: "{{ route('dashboard.lsbu') }}",
      type: "post",
      data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        kanwil: $('#filterKanwilId').val()
      },
      success: function (element) {
        $('#terdaftarIdLsbu').html(`
          <h5 style="font-size: 14px;">Autodebit Terdaftar</h5>
          <h5 style="font-size: 24px;">${ element.mv_summary ? number_format(element.mv_summary.autodebit_terdaftar) : 'Rp 0' } Autodebit Terdaftar</h5>
          <h5>Sampai dengan tanggal ${ element.date }</h5>
        `)
        $('#pendaftaranIdLsbu').html(`
          <h5 style="font-size: 14px;">Pendafaran Bulan Ini</h5>
          <h5 style="font-size: 24px;">${ element.mv_summary ? number_format(element.mv_summary.reg_bulan_ini) : '0' } Autodebit</h5>
          <h5>${ element.mv_summary ? element.mv_summary.presentasi : '0' }% Lebih banyak dari bulan lalu</h5>
        `)
        $('#berjalanIdLsbu').html(`
          <h5 style="font-size: 14px;">Autodebit Berjalan</h5>
          <h5 style="font-size: 24px;">${ element.mv_summary ? number_format(element.mv_summary.autodebit_aktif) : '0' } Autodebit Berjalan</h5>
          <h5>Sampai dengan tanggal ${ element.date }</h5>
        `)
        $('#selesaiIdLsbu').html(`
          <h5 style="font-size: 14px;">Autodebit Selesai</h5>
          <h5 style="font-size: 24px;">${ element.mv_summary ? number_format(element.mv_summary.autodebit_selesai) : '0' } Autodebit Selesai</h5>
          <h5>Sampai dengan tanggal ${ element.date }</h5>
        `)
        
        var datasets  = []
        var html      = ''

        $.map(element.charts.data, function(v, k){
          html += `<div class="${k > 0 ? 'row mt-2' : 'row'}" id="contentSpanIdLsbu${k}">
            <span class="btn btn-primary w-100" style="background: ${v.color} !important; color: white !important;">${v.label}</span>
          </div>`
            var row = {
              data: v.data,
              borderColor: v.color,
              fill: false
            }
            datasets.push(row)
        })
        $('#spanIdLsbu').html(html)
        
        var el = {
          labels: element.months,
          datasets: datasets
        }
        console.log(el)
        getChartLsbu(el)
      }
    })    
  }

  function getChartLsbu(data){
    const myChartLsbu = new Chart(
      document.getElementById('myChartLsbu'),
      config = {
        type: 'line',
        data: data,
        options: {
          legend: {
            display: false
          }
        }
      }
    )
  }
</script>
@endpush