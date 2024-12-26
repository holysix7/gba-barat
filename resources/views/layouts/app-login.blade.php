<!DOCTYPE html>
<html lang="en">

@include('layouts.app-heading')

<body>
  <section class="d-flex align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 order-1 order-lg-2 hero-img card justify-content-center" style="border-radius: 25px;">
          <div class="card-body login-card-body">
            @include('layouts.flash-message')
            <div class="d-flex justify-content-center">
              <div class="row">
                {{-- <img src="{{asset('images/LogoLogin.png')}}"> --}}
              </div>
            </div>
            <div class="column d-flex justify-content-center" style="padding-top: 10px; padding-bottom: 20px;">
              <div class="row">
                <h3 class="text-center login-text" style="width: 100%; font-size: 17px; color: #1B517E;">Gunakan username dan password Anda untuk masuk kedalam sistem</h3>
                @if($errors->any())
                  @foreach($errors->all() as $error)
                  <p class="text-center" style="color: red">{{$error}}</p>
                  @endforeach
                @endif
              </div>
            </div>

            <form action="{{ route('login.check') }}" method="post">
              @csrf
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="username" id="username" style="height: 40px; border-radius: 25px" placeholder="Username">
              </div>
              <div class="input-group mb-3">
                <input type="password" class="form-control" name="password" id="password" style="height: 40px; border-radius: 25px" placeholder="Password">
              </div>
              <button type="submit" class="btn btn-primary login-btn" style="border-radius: 25px !important;">
                Login
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>