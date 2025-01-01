<?php
namespace App\Http\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Session;

trait GetListTrait 
{
  public function getParams($id){
    switch ($id) {
      case 'timeline':
        return $this->getTimeline();
        break;
      case 'profile':
        return $this->getProfile();
        break;
      case 'profile-detail':
        return $this->getProfileDetail();
        break;
      case 'data-warga':
        return $this->getDataWarga();
        break;
      case 'laporan-keuangan':
        return $this->getLaporanKeuangan();
      case 'iuran-rt':
        return $this->getIuranRt();
        break;
    }
    return null;
  }

  protected function getTimeline(){
    return (object)[
      'menu'      => 'Timeline',
      'endpoint'  => route('timeline'),
    ];
  }

  protected function getProfile(){
    $session_user = Session::Get('user');
    $user         = User::where('id', $session_user->id)
    ->with(['auth.role', 'address'])
    ->first();

    return (object)[
      'menu'      => 'Profile',
      'endpoint'  => route('profile'),
      'user'      => $user
    ];
  }

  protected function getProfileDetail(){
    $session_user = Session::Get('user');
    $user = User::where('id', $session_user->id)
    ->with(['auth.role', 'address', 'families' => function ($query) {
        $query->orderBy('tgl_lahir', 'asc');
    },])
    ->first();
    $data = [
        [
            'name' => $user->name,
            'no_telp' => $user->no_telp,
            'tgl_lahir' => $user->tgl_lahir,
            'jenis_kelamin' => $user->jenis_kelamin,
        ]
    ];
    foreach($user->families as $family){
        $row = [
            'name' => $family->name,
            'no_telp' => $family->no_telp,
            'tgl_lahir' => $family->tgl_lahir,
            'jenis_kelamin' => $family->jenis_kelamin,
        ];
        array_push($data, $row);
    }

    return (object)[
      'menu'          => 'Detail',
      'endpoint'      => route('data-warga.get-list'),
      'redirect_back' => route('profile'),
      'user'          => $user,
      'families'      => $data,
    ];
  }

  protected function getDataWarga(){
    return (object)[
      'menu'      => 'Data Warga',
      'export'    => route('laporan-keuangan.export'),
      'endpoint'  => route('data-warga.get-list'),
      'show_refresh' => true,
      'columns'   => [
          [
              "title"   => "No",
              "width"   => "5%",
              "data"    => 'no'
          ],
          [
              "title"   => "RT",
              "data"    => 'rt',
              "width"   => "10%"
          ],
          [
              "title"   => "Nomor Kartu Keluarga",
              "data"    => 'no_kk',
              "width"   => "15%"
          ],
          [
              "title"   => "Kepala Keluarga",
              "data"    => 'kepala_keluarga',
              "width"   => "10%",
          ],
          [
              "title"   => "Nama Lengkap",
              "data"    => 'name',
          ],
          [
              "title"   => "Tanggal Lahir",
              "data"    => 'tgl_lahir',
              "width"   => "8%"
          ],
          [
              "title"   => "Jenis Kelamin",
              "data"    => "jenis_kelamin",
              "width"   => "8%"
          ],
          [
              "title"   => "Alamat",
              "data"    => "address",
              "width"   => "15%"
          ],
          [
              "title"   => "Nomor Telepon (WA)",
              "data"    => 'no_telp',
              "width"   => "8%"
          ],
          [
              "title"   => "Aksi",
              "width"   => "8%",
              "data"    => 'name',
          ],
      ]
    ];
  }

  protected function getLaporanKeuangan(){
    return (object)[
      'menu'      => 'Laporan Keuangan',
      'export'    => route('laporan-keuangan.export'),
      'endpoint'  => route('laporan-keuangan.get-list'),
      'show_refresh' => true,
      'columns'   => [
          [
              "title"   => "No",
              "width"   => "5%",
              "data"    => 'no'
          ],
          [
              "title"   => "Tanggal",
              "data"    => 'tanggal',
              "width"   => "10%"
          ],
          [
              "title"   => "Deskripsi",
              "data"    => 'name',
          ],
          [
              "title"   => "Debit",
              "data"    => 'debit',
              "width"   => "15%",
              "className" => 'text-right'
          ],
          [
              "title"   => "Kredit",
              "data"    => 'kredit',
              "width"   => "15%",
              "className" => 'text-right'
            ],
            [
              "title"   => "Total",
              "data"    => 'total',
              "width"   => "15%",
              "className" => 'text-right'
          ],
      ]
    ];
  }

  protected function getIuranRt(){
    return (object)[
      'menu'      => 'Iuran RT',
      'export'    => route('iuran-rt.export'),
      'endpoint'  => route('iuran-rt.get-list'),
      'now_month' => date('m'),
      'show_refresh' => true,
      'columns'   => [
        [
            "title"   => "No",
            "width"   => "5%",
            "data"    => 'no'
        ],
        [
            "title"   => "RT",
            "data"    => 'rt',
            "width"   => "8%"
        ],
        [
            "title"   => "Ketua RT",
            "data"    => 'ketua_rt',
            "width"   => "20%",
        ],
        [
            "title"   => "Tagihan",
            "data"    => 'tagihan',
            "width"   => "10%",
            "className" => 'text-right'
          ],
        [
          "title"   => "Status Bayar",
          "data"    => 'status_bayar',
          "width"   => "10%",
        ],
      ],
      'months'  => [
        [
          'name'  => 'Januari',
          'value' => '1'
        ],
        [
          'name'  => 'Februari',
          'value' => '2'
        ],
        [
          'name'  => 'Maret',
          'value' => '3'
        ],
        [
          'name'  => 'April',
          'value' => '4'
        ],
        [
          'name'  => 'Mei',
          'value' => '5'
        ],
        [
          'name'  => 'Juni',
          'value' => '6'
        ],
        [
          'name'  => 'Juli',
          'value' => '7'
        ],
        [
          'name'  => 'Agustus',
          'value' => '8'
        ],
        [
          'name'  => 'September',
          'value' => '9'
        ],
        [
          'name'  => 'Oktober',
          'value' => '10'
        ],
        [
          'name'  => 'November',
          'value' => '11'
        ],
        [
          'name'  => 'Desember',
          'value' => '12'
        ],
      ],
      'years' => ['2025', '2026']
    ];
  }
}