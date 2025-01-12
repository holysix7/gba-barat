@extends('content')

@section('table')
  <?php 
    $months     = data_get($data, 'months', []);
    $years      = data_get($data, 'years', []);
    $now_month  = data_get($data, 'now_month');
    $filter     = [
      'month' => $months[0]['value'],
      'year'  => $years[0]['value']
    ];
  ?>
  <div class="row" style="padding-bottom: 10px;">
    <h3>Filter</h3>
    <input id="filter" type="hidden" class="form-control" value="{{ json_encode($filter) }}">
    <div class="col-md-2">
      <select id="monthId" class="form-control">
        @foreach($months as $month)
          <option value="{{ $month['value'] }}" {{$month['value'] === $now_month ? 'selected' : ''}}>{{ $month['label'] }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2">
      <select id="yearId" class="form-control">
        @foreach($years as $year)
          <option value="{{ $year['value'] }}">{{ $year['label'] }}</option>
        @endforeach
      </select>
    </div>
  </div>
  <hr>
  <table id="fikri-request" class="table table-bordered table-striped">
  </table>
@endsection

@push('script')
<script type="text/javascript">
  var filter = {
    month: '{{$months[0]["value"]}}',
    year: '{{$years[0]["value"]}}'
  }
  const filterString = JSON.stringify(filter);
  $('#filterExport').val(filterString)
  $(document).ready(function() {
    $('#monthId').on('change', function(){
      filter.month = $('#monthId').val();
      resetTable();
    })
    $('#yearId').on('change', function(){
      filter.year = $('#yearId').val();
      resetTable();
    })
  })

  function resetTable(){
    const filterString = JSON.stringify(filter);
    $('#filter').val(filterString); // Set nilai filter di input hidden atau form
    $('#filterExport').val(filterString)
    $('#fikri-request').DataTable().clear().destroy()
    loadingData()
  }
</script>
@endpush
