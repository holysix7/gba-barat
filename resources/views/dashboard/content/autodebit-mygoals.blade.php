<div class="row">
  <div class="col-sm-12">
    <div class="row">
      <div class="col-sm-3">
        <div class="card p-4" style="background: #DFF9FB">
          <div class="row">
            <div class="col-sm-12" id="terdaftarIdGoals">
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
            <div class="col-sm-12" id="pendaftaranIdGoals">
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
            <div class="col-sm-12" id="berjalanIdGoals">
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
            <div class="col-sm-12" id="selesaiIdGoals">
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
        <canvas id="myChartGoals"></canvas>
      </div>
      <div class="col-sm-2 mt-4" id="spanIdMyGoals">
      </div>
    </div>
  </div>
</div>

@push('script')
<script type="text/javascript">
  $(document).ready(function(){
    $.ajax({
      url: "{{ route('dashboard.mygoals') }}",
      type: "get",
      success: function (element) {
        $('#terdaftarIdGoals').html(`
          <h5 style="font-size: 14px;">Autodebit Terdaftar</h5>
          <h5 style="font-size: 24px;">${ element.mv_summary ? number_format(element.mv_summary.autodebit_terdaftar) : '0' } Autodebit Terdaftar</h5>
          <h5>Sampai dengan tanggal ${ element.date }</h5>
        `)
        $('#pendaftaranIdGoals').html(`
          <h5 style="font-size: 14px;">Pendafaran Bulan Ini</h5>
          <h5 style="font-size: 24px;">${ element.mv_summary ? number_format(element.mv_summary.reg_bulan_ini) : '0' } Autodebit</h5>
          <h5>${ element.mv_summary ? element.mv_summary.presentasi : '0' }% Lebih banyak dari bulan lalu</h5>
        `)
        $('#berjalanIdGoals').html(`
          <h5 style="font-size: 14px;">Autodebit Berjalan</h5>
          <h5 style="font-size: 24px;">${ element.mv_summary ? number_format(element.mv_summary.autodebit_aktif) : '0' } Autodebit Berjalan</h5>
          <h5>Sampai dengan tanggal ${ element.date }</h5>
        `)
        $('#selesaiIdGoals').html(`
          <h5 style="font-size: 14px;">Autodebit Selesai</h5>
          <h5 style="font-size: 24px;">${ element.mv_summary ? number_format(element.mv_summary.autodebit_selesai) : '0' } Autodebit Selesai</h5>
          <h5>Sampai dengan tanggal ${ element.date }</h5>
        `)
        
        var datasets  = []
        var html      = ''

        $.map(element.charts.data, function(v, k){
          html += `<div class="${k > 0 ? 'row mt-2' : 'row'}" id="contentSpanIdMyGoals${k}">
            <span class="btn btn-primary w-100" style="background: ${v.color} !important; color: white !important;">${v.label}</span>
          </div>`
            var row = {
              data: v.data,
              borderColor: v.color,
              fill: false
            }
          datasets.push(row)
        })
        $('#spanIdMyGoals').html(html)
        
        var el = {
          labels: element.months,
          datasets: datasets
        }
        getChartGoals(el)
      }
    })    
  })

  function getChartGoals(data){
    const myChartGoals = new Chart(
      document.getElementById('myChartGoals'),
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