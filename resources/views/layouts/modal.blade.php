
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modalTitle">
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="containerForm">
        <table id="fikri-request-detail" class="table table-bordered table-striped">
        </table>
      </div>
      @if($data->menu === 'Iuran RT')
        <div class="modal-footer">
          <form action="{{ route('iuran-rt') }}" method="POST">
            @csrf
            <input id="idParseValue" name="values" type="hidden">
            <a href="javascript:void(0)" id="btnId" class="btn btn-primary">
              Bayar
            </a>
          </form>
        </div>
      @endif
    </div>
  </div>
</div>
  
@if(data_get($data, 'update'))
<div class="modal fade" id="infoModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modalTitleForm">
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ $data->update }}" method="POST">
        <div class="modal-body" id="containerForm">
          <div class="row container-form" id="readonlyForm">
          </div>
        </div>
        <div class="modal-footer">
            @csrf
            <input id="idParseValue" name="values" type="hidden">
            <button type="submit" class="btn btn-primary">
              Ubah
            </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endif
  
@if(data_get($data, 'create'))
<div class="modal fade" id="tambahPopUp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modalTitleFormAdd">
          TAMBAH {{ request()->segment(2) ? strtoupper($data->menu) : strtoupper(request()->segment(1)) }}
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ $data->create }}" method="POST" enctype='multipart/form-data'>
        <div class="modal-body" id="containerFormAdd">
          <div class="row container-form" id="readonlyFormAdd">
            @foreach($data->create_fields as $field)
            <div class="col-md-12">
              <label>{{ $field['label'] }}</label>
              @if($field['type'] === 'select')
                <select name="{{ $field['name'] }}" class="form-control {{ $field['add_class'] }}">
                  @foreach($field['options'] as $option)
                    <option value="{{ data_get($option, 'value') }}">{{ data_get($option, 'label') }}</option>
                  @endforeach
                </select>
              @elseif($field['type'] === 'textarea')
                <textarea class="form-control" name="{{ $field['name'] }}" rows="4" placeholder="{{ $field['label'] }}"></textarea>
              @elseif($field['type'] === 'file')
                <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" class="form-control {{ $field['add_class'] }}" accept="image/png, image/jpeg">
              @else
                <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" class="form-control {{ $field['add_class'] }}" placeholder="{{ $field['label'] }}">
              @endif
              </div>
            @endforeach
          </div>
        </div>
        <div class="modal-footer">
            @csrf
            <input id="idParseValue" name="values" type="hidden">
            <button type="submit" class="btn btn-primary">
              Simpan
            </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endif