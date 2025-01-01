<div class="row">
  <div class="col-sm-12">
    <div class="row m-2">
      <div class="col-sm-12">
        <div class="row bg-warning rounded">
          <h5 class="ml-2 mt-2" style="font-size: 20px;">Masih tahap pengembangan...</h5>
        </div>
      </div>
      {{-- <div class="col-sm-3">
        <div class="card p-4" style="background: #DFF9FB">
          <div class="row">
            <div class="col-sm-12" id="terdaftarIdRegular">
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
            <div class="col-sm-12" id="pendaftaranIdRegular">
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
            <div class="col-sm-12" id="berjalanIdRegular">
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
            <div class="col-sm-12" id="selesaiIdRegular">
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
      </div> --}}
    </div>
    {{-- <div class="row mt-4">
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
    </div> --}}
  </div>
</div>

@push('script')
<script type="text/javascript">
  // $(document).ready(function(){
  //   $.ajax({
  //     url: "{{ route('dashboard.lsbu') }}",
  //     type: "get",
  //     success: function (element) {
  //       $('#terdaftarIdRegular').html(`
  //         <h5 style="font-size: 14px;">Autodebit Terdaftar</h5>
  //         <h5 style="font-size: 24px;">${ number_format(element.mv_summary.autodebit_terdaftar) } Autodebit Terdaftar</h5>
  //         <h5>Sampai dengan tanggal ${ element.date }</h5>
  //       `)
  //       $('#pendaftaranIdRegular').html(`
  //         <h5 style="font-size: 14px;">Pendafaran Bulan Ini</h5>
  //         <h5 style="font-size: 24px;">${ number_format(element.mv_summary.reg_bulan_ini) } Autodebit</h5>
  //         <h5>${element.mv_summary.persentasi}% Lebih banyak dari bulan lalu</h5>
  //       `)
  //       $('#berjalanIdRegular').html(`
  //         <h5 style="font-size: 14px;">Autodebit Berjalan</h5>
  //         <h5 style="font-size: 24px;">${ number_format(element.mv_summary.autodebit_aktif) } Autodebit Berjalan</h5>
  //         <h5>Sampai dengan tanggal ${ element.date }</h5>
  //       `)
  //       $('#selesaiIdRegular').html(`
  //         <h5 style="font-size: 14px;">Autodebit Selesai</h5>
  //         <h5 style="font-size: 24px;">${ number_format(element.mv_summary.autodebit_selesai) } Autodebit Selesai</h5>
  //         <h5>Sampai dengan tanggal ${ element.date }</h5>
  //       `)
        
  //       var datasets  = []
  //       var html      = ''

  //       $.map(element.charts.data, function(v, k){
  //         html += `<div class="${k > 0 ? 'row mt-2' : 'row'}" id="contentSpanIdLsbu${k}">
  //           <span class="btn btn-primary w-100" style="background: ${v.color} !important; color: white !important;">${v.label}</span>
  //         </div>`
  //           var row = {
  //             data: v.data,
  //             borderColor: v.color,
  //             fill: false
  //           }
  //           datasets.push(row)
  //       })
  //       $('#spanIdLsbu').html(html)
        
  //       var el = {
  //         labels: element.months,
  //         datasets: datasets
  //       }
  //       console.log(el)
  //       getChartLsbu(el)
  //     }
  //   })    
  // })

  // function getChartLsbu(data){
  //   const myChartLsbu = new Chart(
  //     document.getElementById('myChartLsbu'),
  //     config = {
  //       type: 'line',
  //       data: data,
  //       options: {
  //         legend: {
  //           display: false
  //         }
  //       }
  //     }
  //   )
  // }
</script>
@endpush