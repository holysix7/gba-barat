@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{ url('adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ url('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')

<section class="content">
  <div class="container-fluid">
    @include('content-header')
    @if(empty(request()->segment(4)))
      <div class="row header-menu">
        <div class="col-md-12">
          <form action="{{ route('autodebit.mygoals.pendaftaran.export') }}" enctype="multipart/form-data" method="POST">
          @csrf
            <div class="row">
              <div class="col-sm-9">
                <div class="row">
                  <div class="col-sm-4">
                    <label>Rentang Waktu </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-9">
                <div class="row">
                  <div class="col-sm-4">
                    <input type="date" class="form-control" name="start_date" value="{{ $maxDate }}" max="{{ $maxDate }}" min="" id="startDate">
                  </div>
                  <div class="col-sm-4">
                    {{-- <input type="date" class="form-control" name="end_date" max="{{$maxDate}}" min="" id="endDate"> --}}
                    <input type="date" class="form-control" name="end_date" value="{{ $maxDate }}" min="" id="endDate">
                  </div>
                  <div class="col-sm-2">
                    <a href="javascript:void(0)" class="btn btn-primary btn-template" id="filterButton">Tampilkan</a>
                  </div>
                  <div class="col-sm-2">
                    <a href="javascript:void(0)" class="btn btn-danger btn-template" id="resetButton">Reset</a>
                  </div>
                </div>
              </div>
              <div class="col-sm-3">
                @foreach(session('menus') as $menu)
                  @foreach(session('permissions') as $permission)
                    @if(count($menu) > 0)
                      @foreach($menu['childs'] as $child)
                        @if(count($child['grand_childs']) > 0)
                          @foreach($child['grand_childs'] as $grand_child)
                            @if(request()->segment(2) == $child['slug'])
                              @if(request()->segment(3) == $grand_child['slug'])
                                @if($permission['permission_id'] == 6)
                                  @if($permission['application_id'] == $grand_child['id'])
                                    @if($permission['isactive'] == true)
                                      <div class="row">
                                        <div class="col-sm-12 d-flex justify-content-end">
                                          <button class="btn btn-success btn-template-tambah" id="buttonExport" target="_blank">
                                            <i class="mdi mdi-export"></i>
                                            Export {{$grand_child['description']}}
                                          </button>
                                        </div>
                                      </div>
                                    @endif
                                  @endif
                                @endif
                              @endif
                            @endif
                          @endforeach
                        @endif
                      @endforeach
                    @endif
                  @endforeach
                @endforeach
              </div>
            </div>
          </form>
        </div>
      </div>
    @endif
    <div class="card card-primary card-outline card-outline-tabs col-sm-12">
      <div class="row">
        <div class="card-body col-12">
          @if(empty(request()->segment(4)))
            @include('autodebit.mygoal.pendaftaran.content.content')
          @else
            @if(request()->segment(4) == 'new')
              @include('autodebit.mygoal.pendaftaran.content.new')
            @else
              @include('autodebit.mygoal.pendaftaran.content.show')
            @endif
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('script')
<script src="{{ url('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/select2/js/select2.full.min.js') }} "></script>
<script src="{{ url('js/utils.js') }} "></script>
@endsection