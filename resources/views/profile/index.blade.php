<div class="col-4">
  <div class="card card-primary card-outline">
    <div class="card-body box-profile">
      <div class="text-center">
        <img class="profile-user-img img-fluid img-circle"
             src="{{ url('images/no_file.png') }}"
             alt="User profile picture">
      </div>

      <h3 class="profile-username text-center">{{ $user->name }}</h3>

      <ul class="list-group list-group-unbordered mb-3">
        @if($user->kepala_keluarga)
          <li class="list-group-item d-flex justify-content-center">
            <span class="float-center bg-global-primary" style="border-radius: 4px; padding: 0px 8px 0px 8px;">Kepala Keluarga</span>
          </li>
        @endif
        <li class="list-group-item">
          <b>Nomor KK</b> <span class="float-right">{{ $user->no_kk }}</span>
        </li>
        <li class="list-group-item">
          <b>Username</b> <span class="float-right">{{ $user->auth->username }}</span>
        </li>
        <li class="list-group-item">
          <b>Jenis Kelamin</b> <span class="float-right">{{ $user->jenis_kelamin }}</span>
        </li>
        <li class="list-group-item">
          <b>RT</b> <span class="float-right">{{ $user->rt }}</span>
        </li>
        <li class="list-group-item">
          <b>Alamat</b> <span class="float-right">{{ $user->address->name }}</span>
        </li>
        <li class="list-group-item">
          <b>No Telp.</b> <span class="float-right">{{ $user->no_telp }}</span>
        </li>
      </ul>

      <a href="/profile/detail" class="btn btn-primary btn-block"><b>Lihat Detail</b></a>
    </div>
    <!-- /.card-body -->
  </div>
</div>