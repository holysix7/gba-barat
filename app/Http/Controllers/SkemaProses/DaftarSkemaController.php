<?php

namespace App\Http\Controllers\SkemaProses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class DaftarSkemaController extends Controller
{
    public function index(){
        return view('skemaproses.daftarskema.index');
    }

    public function ajax_goals(Request $request){
        if($request->search){
            $records      = [
                [
                    'rownum'            => 1,
                    'id'                => Crypt::encrypt(1),
                    'kode_skema'        => 'ABCD1234',
                    'kode_implement'    => 'ABCD',
                    'kode_abstract'     => 'A800',
                    'deskripsi_skema'   => 'Deskripsi skema proses satu (1)',
                    'type'              => 'Numeric'
                ],
                [
                    'rownum'            => 2,
                    'id'                => Crypt::encrypt(2),
                    'kode_skema'        => 'ABCD1235',
                    'kode_implement'    => 'BCDE',
                    'kode_abstract'     => 'A801',
                    'deskripsi_skema'   => 'Deskripsi skema proses dua (2)',
                    'type'              => 'Numeric'
                ],
                [
                    'rownum'            => 3,
                    'id'                => Crypt::encrypt(3),
                    'kode_skema'        => 'ABCD1236',
                    'kode_implement'    => 'CDEF',
                    'kode_abstract'     => 'A802',
                    'deskripsi_skema'   => 'Deskripsi skema proses tiga (3)',
                    'type'              => 'Numeric'
                ]
            ];
            $row = [];
            foreach($records as $record){
                if($record['id'] == Crypt::decrypt($params)){
                    $row[] = $record;
                }
            }
            $records = $row[0];
            $resCount   = count($records);
            // $query      = DB::table('sys_roles');
            // $resCount   = $query->count();
            // $query->where('name', 'ilike', '%'. $request->search .'%');
            // $records = $query->get();
        }else{
            $records      = [
                [
                    'rownum'            => 1,
                    'id'                => Crypt::encrypt(1),
                    'kode_skema'        => 'ABCD1234',
                    'kode_implement'    => 'ABCD',
                    'kode_abstract'     => 'A800',
                    'deskripsi_skema'   => 'Deskripsi skema proses satu (1)',
                    'type'              => 'Numeric'
                ],
                [
                    'rownum'            => 2,
                    'id'                => Crypt::encrypt(2),
                    'kode_skema'        => 'ABCD1235',
                    'kode_implement'    => 'BCDE',
                    'kode_abstract'     => 'A801',
                    'deskripsi_skema'   => 'Deskripsi skema proses dua (2)',
                    'type'              => 'Numeric'
                ],
                [
                    'rownum'            => 3,
                    'id'                => Crypt::encrypt(3),
                    'kode_skema'        => 'ABCD1236',
                    'kode_implement'    => 'CDEF',
                    'kode_abstract'     => 'A802',
                    'deskripsi_skema'   => 'Deskripsi skema proses tiga (3)',
                    'type'              => 'Numeric'
                ]
            ];
            $resCount   = count($records);
            // $query      = DB::table('sys_roles');
            // $resCount   = $query->count();
            // $query->skip($request->start);
            // $query->take($request->length);
            // $records = $query->get();
        }
        $no             = $request->start;
        foreach($records as $row){
            $row['rownum'] = ++$no;
        }
        $response = [
            "draw"              => $request->draw,
            "recordsTotal"      => $resCount,
            "recordsFiltered"   => $resCount,
            "data"              => $records
        ];
    
        return response()->json($response);
    }

    public function show($params, Request $request){
        $records      = [
            [
                'rownum'            => 1,
                'id'                => Crypt::encrypt(1),
                'kode_skema'        => 'ABCD1234',
                'kode_implement'    => 'ABCD',
                'kode_abstract'     => 'A800',
                'deskripsi_skema'   => 'Deskripsi skema proses satu (1)',
                'type'              => 'Numeric'
            ],
            [
                'rownum'            => 2,
                'id'                => Crypt::encrypt(2),
                'kode_skema'        => 'ABCD1235',
                'kode_implement'    => 'BCDE',
                'kode_abstract'     => 'A801',
                'deskripsi_skema'   => 'Deskripsi skema proses dua (2)',
                'type'              => 'Numeric'
            ],
            [
                'rownum'            => 3,
                'id'                => Crypt::encrypt(3),
                'kode_skema'        => 'ABCD1236',
                'kode_implement'    => 'CDEF',
                'kode_abstract'     => 'A802',
                'deskripsi_skema'   => 'Deskripsi skema proses tiga (3)',
                'type'              => 'Numeric'
            ]
        ];
        $row = [];
        foreach($records as $record){
            if($record['id'] == Crypt::decrypt($params)){
                $row[] = $record;
            }
        }
        $record = $row[0];

        return view('skemaproses.daftarskema.show', compact('record'));
    }

    public function new(){
        return view('skemaproses.daftarskema.new');
    }

    public function create(Request $request){
        dd('create');
    }

    public function update(Request $request){
        dd('update');
    }
}
