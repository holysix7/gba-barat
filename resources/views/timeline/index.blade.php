@extends('content')

@section('info')
  <div class="row">
    <!-- Tab Navigation -->
    <ul class="nav nav-tabs tab-menu nav-merchant" id="custom-tabs-three-tab" role="tablist">
      <li class="nav-item tab-item col-md">
        <a class="nav-link tab-link active" data-toggle="pill" href="#custom-tabs-infowarga" 
          role="tab" aria-controls="custom-tabs-infowarga" aria-selected="true" style="display: flex; color: black;">
          <b>Informasi Warga <i class="fa fa-users"></i></b>
        </a>
      </li>
      <li class="nav-item tab-item col-md">
        <a class="nav-link tab-link" data-toggle="pill" href="#custom-tabs-so" 
          role="tab" aria-controls="custom-tabs-so" aria-selected="false" style="display: flex; color: black;">
          <b>Struktur Organisasi RW <i class="fa fa-building"></i></b>
        </a>
      </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content w-100">
      <div class="tab-pane fade mt-4 active show" id="custom-tabs-infowarga" 
          role="tabpanel" aria-labelledby="custom-tabs-infowarga">
        @include('timeline.content.info-warga')
      </div>
      <div class="tab-pane fade mt-4" id="custom-tabs-so" 
          role="tabpanel" aria-labelledby="custom-tabs-so">
        @include('timeline.content.struktur-organisasi')
      </div>
    </div>
  </div>

@endsection

@push('script')
  <script type="text/javascript">
    var nextRequest = 0;
    $(document).ready(function(){
      $('#judulPostingan').html('<div class="skeleton-box text-skeleton" style="width: 40%;"></div>')
      $('#info').html('<div class="skeleton-box text-skeleton" style="width: 40%;"></div>')
      $('#descId').html('<div class="skeleton-box text-skeleton w-100"></div>')
      
      setTimeout(() => {
        ajaxCall()
      }, 500);
      $('#prevBtn').on('click', function() {
        const start = $(this).data('start');
        ajaxCall(start);
      });

      $('#nextBtn').on('click', function() {
        ajaxCall(nextRequest);
      });
    })

    function ajaxCall(start = 0){
      $('#parentInfoWarga').html('')
      $('#judulPostingan').html('<div class="skeleton-box text-skeleton" style="width: 40%;"></div>')
      $('#info').html('<div class="skeleton-box text-skeleton" style="width: 40%;"></div>')
      $('#descId').html('<div class="skeleton-box text-skeleton w-100"></div>')

      $.ajax({
        url: `{{ route("info-warga") }}`,
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          start: start
        },
        success: function(response){
          html = ''
          $('#judulPostingan').html('')
          $('#info').html('')
          $('#descId').html('')
          const { data, prev, next, hasMore} = response
          nextRequest += next;
          for(let i = 0; i < data.length; i++){
            var row = data[i];
            html += `<div class="col-sm-12">
              <div class="card timeline-info-warga">
                <h4 id="judulPostingan">${row.judul}</h4>
                <p class="timeline-p" id="info">
                  (${dateFormat(row.created_at)}) - ${row.user.name}
                </p>
                <div id="descId" class="timeline-desc">
                  ${row.deskripsi}
                </div>
              </div>
            </div>`
          }
          $('#parentInfoWarga').html(html)
          if (prev === 0) {
            $('#prevBtn').attr('disabled', true);
          } else {
            $('#prevBtn').attr('disabled', false);
          }

          if (!hasMore) {
            $('#nextBtn').attr('disabled', true);
          } else {
            $('#nextBtn').attr('disabled', false);
          }
        },
        error: function(xhr, status, thrown){
          alert('Error ajax call: ', xhr, ', ', thrown)
          console.log(status)
        }
      })
    }
  </script>
@endpush