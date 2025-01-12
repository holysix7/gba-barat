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

  <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imageModalLabel">Preview Gambar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <img id="modalImage" src="" alt="Preview" class="img-fluid" />
        </div>
      </div>
    </div>
  </div>

@endsection

@push('script')
  <script type="text/javascript">
    var currentPage = 0;
    var totalPages = 0;
    var limit = $('#optLimit').val();
    $(document).ready(function(){
      $('#judulPostingan').html('<div class="skeleton-box text-skeleton" style="width: 40%;"></div>')
      $('#info').html('<div class="skeleton-box text-skeleton" style="width: 40%;"></div>')
      $('#descId').html('<div class="skeleton-box text-skeleton w-100"></div>')
      
      setTimeout(() => {
        ajaxCall()
      }, 500);
      
      $('#prevBtn').on('click', function () {
        currentPage--;
        ajaxCall(currentPage);
      });

      $('#nextBtn').on('click', function () {
        if (currentPage < totalPages - 1) {
          currentPage++;
          ajaxCall(currentPage);
        }
      });
      
      $('#optLimit').on('change', function () {
        limit = $('#optLimit').val();
        ajaxCall()
      })
    })

    function ajaxCall(page){
      $('#parentInfoWarga').html('')
      $('#judulPostingan').html('<div class="skeleton-box text-skeleton" style="width: 40%;"></div>')
      $('#info').html('<div class="skeleton-box text-skeleton" style="width: 40%;"></div>')
      $('#descId').html('<div class="skeleton-box text-skeleton w-100"></div>')

      $.ajax({
        url: `{{ route("info-warga") }}`,
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          start: page * limit,
          limit: limit,
        },
        success: function(response){
          html = ''
          $('#judulPostingan').html('')
          $('#info').html('')
          $('#descId').html('')
          const { data, counted} = response
          totalPages = Math.ceil(counted / limit);

          for(let i = 0; i < data.length; i++){
            var row = data[i];
            html += `<div class="col-sm-12">
              <div class="card timeline-info-warga">
                <h4 id="judulPostingan">${row.judul}</h4>
                <p class="timeline-p" id="info" data-toggle="tooltip" title="Dibuat Oleh: ${row.user.name}\r\n Pada Tanggal: ${dateTimeFormat(row.created_at)}">
                  (${dateTimeFormat(row.created_at)}) - ${row.user.name}
                </p>
                ${row.foto ? `
                  <div class="container-timeline-photo">
                    <img src="${row.foto}" alt="${row.judul}" class="timeline-photo img-fluid" id="${row.id}+${row.foto}" />
                  </div>
                  ` : ''
                }
                <div id="descId" class="timeline-desc">
                  ${row.deskripsi}
                </div>
              </div>
            </div>`
          }
          $('#parentInfoWarga').html(html)
          $('#prevBtn').attr('disabled', currentPage <= 0);
          $('#nextBtn').attr('disabled', currentPage >= totalPages - 1);
          $('.timeline-photo').on('click', function () {
            const imageSrc = $(this).attr('src');
            const imageAlt = $(this).attr('alt');
            $('#modalImage').attr('src', imageSrc);
            $('#imageModalLabel').text(imageAlt);
            $('#imageModal').modal('show');
          });
        },
        error: function(xhr, status, thrown){
          alert('Error ajax call: ', xhr, ', ', thrown)
          console.log(status)
        }
      })
    }
  </script>
@endpush