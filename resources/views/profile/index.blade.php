@extends('content')

@section('info')
  <div class="row d-flex justify-content-center">
    @if(request()->segment(1) === 'profile' && !request()->segment(2))
      @include('profile.profile')
    @endif
  </div>
@endsection

@section('table')
  @if(request()->segment(2))
    @include('profile.detail')
  @endif
@endsection