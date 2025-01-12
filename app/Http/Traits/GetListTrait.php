<?php
namespace App\Http\Traits;

use App\Models\Rt;
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
      'create'    => route('timeline.create'),
      'endpoint'  => route('timeline'),
      'create_fields' => [
        [
          'label' => 'Judul',
          'name' => 'judul',
          'type' => 'text',
          'add_class' => ''
        ],
        [
          'label' => 'Deskripsi',
          'name' => 'deskripsi',
          'type' => 'textarea',
          'add_class' => 'uangMasking'
        ],
        [
          'label' => 'Foto',
          'name' => 'foto',
          'type' => 'file',
          'add_class' => ''
        ],
      ],
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
    }])
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
      'create'        => route('profile.detail.create'),
      'redirect_back' => route('profile'),
      'user'          => $user,
      'families'      => $data,
      'create_fields' => [
        [
          'label' => 'Nama',
          'name' => 'name',
          'type' => 'text',
          'add_class' => '',
        ],
        [
          'label' => 'No Telepon',
          'name' => 'no_telp',
          'type' => 'text',
          'add_class' => '',
        ],
        [
          'label' => 'Tanggal Lahir',
          'name' => 'tgl_lahir',
          'type' => 'date',
          'add_class' => '',
        ],
        [
          'label' => 'Jenis Kelamin',
          'name' => 'jenis_kelamin',
          'type' => 'select',
          'add_class' => '',
          'options' => getJenisKelaminValue(),
        ],
      ],
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
            "title"   => "Nomor Telepon (WA)",
            "data"    => 'no_telp',
            "width"   => "8%"
          ],
          [
              "title"   => "Alamat",
              "data"    => "address",
              "width"   => "15%"
          ],
          [
            "title"   => "Status KTP",
            "data"    => "status_ktp",
            "width"   => "10%"
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
      'update'    => route('iuran-rt.update'),
      'create'    => route('iuran-rt.create'),
      'now_month' => date('m'),
      'show_refresh' => true,
      'create_fields' => [
        [
          'label' => 'Nama Iuran',
          'name' => 'name',
          'type' => 'text',
          'add_class' => ''
        ],
        [
          'label' => 'Tagihan',
          'name' => 'nominal',
          'type' => 'text',
          'add_class' => 'uangMasking'
        ],
        [
          'label' => 'RT',
          'name' => 'rt_id',
          'type' => 'select',
          'options' => Rt::getFormatListOptions(),
          'add_class' => ''
        ],
        [
          'label' => 'Bulan',
          'name' => 'bulan',
          'type' => 'select',
          'options' => getMonthsValue(),
          'add_class' => ''
        ],
        [
          'label' => 'Tahun',
          'name' => 'tahun',
          'type' => 'select',
          'options' => getYearsValue(),
          'add_class' => ''
        ],
      ],
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
            "width"   => "15%",
        ],
        [
            "title"   => "Deskripsi",
            "data"    => 'name',
        ],
        [
            "title"   => "Tagihan",
            "data"    => 'tagihan',
            "width"   => "12%",
            "className" => 'text-right'
        ],
        [
          "title"   => "Status Bayar",
          "data"    => 'status_bayar',
          "width"   => "10%",
        ],
        [
          "title"   => "Tanggal Bayar",
          "data"    => 'tanggal_bayar',
          "width"   => "12%",
        ],
        [
            "title"   => "Aksi",
            "width"   => "5%",
            "className" => 'text-center',
            "data"    => 'rt',
        ],
      ],
      'months'  => getMonthsValue(),
      'years' => getYearsValue()
    ];
  }
}