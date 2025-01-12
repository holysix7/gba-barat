<div class="row" style="flex-direction: row-reverse;">
  @if(data_get($data, 'export', false))
    <div class="col-sm-6">
      <button type="submit" class="btn btn-success btn-template-tambah" id="buttonExport" style="width: 100% !important;">
        <i class="mdi mdi-export"></i>
        EXPORT {{ $data->menu }}
      </button>
    </div>
  @endif
  @if(data_get($data, 'show_refresh', false))
    <div class="col-sm-6">
      <button id="refreshTable" class="btn btn-primary align-items-center" style="width: 100% !important; gap: 5px;">
        <i class="fa fa-recycle"></i>
        Refresh
      </button>
    </div>
  @endif
</div>


@if(data_get($data, 'export', false))
  <div class="modal fade" id="exportPopUp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="titleId">
            Export {{ $data->menu }}
          </h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ $data->export }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="row justify-content-center">
              <div class="col-sm-12">
                <input name="filter" type='hidden' id="filterExport" >
                <label>Format File</label>
                <select class="form-control" name="export_type" value="1">
                  <option value="1" selected>Excel Spreadsheet</option>
                </select>
              </div>
            </div>
            <div class="row justify-content-center mt-2">
              <div class="col-sm-12">
                <button class="btn btn-success login-btn">Export</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endif