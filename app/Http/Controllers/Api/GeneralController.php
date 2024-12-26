<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function wilayah(Request $request)
    {
        $query = DB::table('transaction.mst_province AS t1')
            ->join('transaction.mst_city AS t2', 't1.province_id', '=', 't2.province_id')
            ->join('transaction.mst_district AS t3', 't2.city_id', '=', 't3.city_id')
            ->join('transaction.mst_subdistrict AS t4', 't3.district_id', '=', 't4.district_id')
            ->select('t1.province_id', 't1.name AS province_name', 't2.city_id', 't2.name AS city_name', 't3.district_id', 't3.name AS district_name', 't4.subdistrict_id', 't4.name AS subdistrict_name')
            ->where('t1.isactive', '=', 't')
            ->where('t2.isactive', '=', 't')
            ->where('t3.isactive', '=', 't')
            ->where('t4.isactive', '=', 't');

        if ($request->provinsi != '') {
            $query->where('t1.name', 'ILIKE', '%' . $request->provinsi . '%');
        }
        if ($request->kab_kota != '') {
            $query->where('t2.name', 'ILIKE', '%' . $request->kab_kota . '%');
        }
        if ($request->kecamatan != '') {
            $query->where('t3.name', 'ILIKE', '%' . $request->kecamatan . '%');
        }
        if ($request->kelurahan != '') {
            $query->where('t4.name', 'ILIKE', '%' . $request->kelurahan . '%');
        }
        if ($request->wilayah != '') {
            $query->where('t4.name', 'ILIKE', '%' . $request->wilayah . '%')
                ->orwhere('t3.name', 'ILIKE', '%' . $request->wilayah . '%');
        }

        $res = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data'    => $res
        ], 200);
    }

    public function provinsi(Request $request)
    {
        $query = DB::table('transaction.mst_province')
            ->where('isactive', '=', 't');

        if ($request->id != '') {
            $query->where('province_id', '=', $request->id);
        }
        if ($request->name != '') {
            $query->where('name', 'ILIKE', '%' . $request->name . '%');
        }

        $res = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data'    => $res
        ], 200);
    }

    public function kabkota(Request $request)
    {
        $query = DB::table('transaction.mst_city')
            ->where('isactive', '=', 't');

        if ($request->id != '') {
            $query->where('city_id', '=', $request->id);
        }
        if ($request->name != '') {
            $query->where('name', 'ILIKE', '%' . $request->name . '%');
        }
        if ($request->provinsi_id != '') {
            $query->where('province_id', '=', $request->provinsi_id);
        }

        $res = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data'    => $res
        ], 200);
    }

    public function kecamatan(Request $request)
    {
        $query = DB::table('transaction.mst_district')
            ->where('isactive', '=', 't');

        if ($request->id != '') {
            $query->where('district_id', '=', $request->id);
        }
        if ($request->name != '') {
            $query->where('name', 'ILIKE', '%' . $request->name . '%');
        }
        if ($request->kabkota_id != '') {
            $query->where('city_id', '=', $request->kabkota_id);
        }

        $res = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data'    => $res
        ], 200);
    }

    public function kelurahan(Request $request)
    {
        $query = DB::table('transaction.mst_subdistrict')
            ->where('isactive', '=', 't');

        if ($request->id != '') {
            $query->where('subdistrict_id', '=', $request->id);
        }
        if ($request->name != '') {
            $query->where('name', 'ILIKE', '%' . $request->name . '%');
        }

        $res = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data'    => $res
        ], 200);
    }

    public function bank(Request $request)
    {
        $query = DB::table('transaction.mst_bank')
            ->where('isactive', '=', 't');

        if ($request->id != '') {
            $query->where('bank_id', '=', $request->id);
        }
        if ($request->name != '') {
            $query->where('name', 'ILIKE', '%' . $request->name . '%');
        }

        $res = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data'    => $res
        ], 200);
    }

    public function genotp(Request $request)
    {
        $resotp = genOTP();

        if ($resotp['RC'] == '0000') {
            $content['email'] = [
                "TEMPLATE_KEY" => "JMET002",
                "DESTNUM" => $request->email,
                "OTP" => $resotp['OTP']
            ];
            $res = sendEmail($content);

            if ($res['RC'] == '0000') {
                return response()->json([
                    'success' => true,
                    'message' => 'Success',
                    'data'    => ['resotp' => $resotp, 'res' => $res]
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengirim OTP ke email'
                ], 200);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal generate OTP'
            ], 200);
        }
    }

    public function getJmtoBank(Request $request){
        $query = DB::table('transaction.mst_jmto_bank_account AS t1')
            ->select('t1.jmto_bank_account_id', 't1.bank_id', 't1.bank_account_name', 't1.bank_account_number', 't1.fee_transfer', 't1.himbara_fee_transfer', 't1.non_himbara_fee_transfer', 't2.bank_type')
            ->join('transaction.mst_bank AS t2', 't1.bank_id', '=', 't2.bank_id')
            ->where('t1.isactive', '=', 't');

        if ($request->jmto_bank != '') {
            // $query->where('t1.bank_account_name', 'ILIKE', '%' . 'mandiri' . '%');
            $query->where('t1.bank_account_name', 'ILIKE', '%' . $request->jmto_bank . '%');
        }

        $res = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data'    => $res
        ], 200);
    }
}
