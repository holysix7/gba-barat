<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12 d-flex justify-content-center">
        <h4>Group Account : {{ $record->sd_ga_name }}</h4>
      </div>
    </div>
    <div class="row mt-4">
      <div class="card col-sm-12">
        <div class="card-body">
          <form method="POST" action="" enctype="multipart/form-data" class="w-100">
            @csrf
            <div class="row d-flex justify-content-between">
              @php $index = 1; @endphp
              @foreach($recordType as $key => $row)
                  <div class="col-sm-4 mt-4">
                    <div class="row @if($index % 3 == 0) d-flex justify-content-end @elseif($index % 3 == 2) d-flex justify-content-center @endif">
                      <div class="col-sm-1">
                        <input type="checkbox" name="statusInsert">
                      </div>
                      <div class="col-sm-9">
                        <label>{{ $row->sd_gat_aid }} - {{ $row->acc_type['sd_pat_acc_type'] }}</label>
                      </div>
                    </div>
                    <div class="row @if($index % 3 == 0) d-flex justify-content-end @elseif($index % 3 == 2) d-flex justify-content-center @endif">
                      <div class="col-sm-10">
                        <select class="form-control" name="sd_gat_type_rekening">
                          <option value="1">Sumber</option>
                          <option value="2">Tujuan</option>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <input type="radio" name="sd_gat_type">
                    </div>
                  </div>
                  @php $index++; @endphp
              @endforeach
            </div>
            <div class="row mt-4 d-flex justify-content-end">
              <div class="col-sm-4">
                <button type="submit" class="btn btn-primary login-btn" id="saveButton">Simpan </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@push('script')
<script type="text/javascript">
  $(document).ready(function() {
    logActivity(JSON.stringify([
      'View', 
      'Melihat form group account type',
      'savdep_group_accounts', 
      'General',
      '{{ Route::current()->getName() }}'
    ]))
  })
@endpush