<?php

namespace App\Models;

use App\Http\Libraries\Security;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isEmpty;

class IuranRt extends Model
{
    protected $table = 'iuran_rt';
    protected $primaryKey   = 'id';
    use HasFactory;

    public function rt(){
        return $this->hasOne(Rt::class, 'id', 'rt_id');
    }

    public static function getExport($request){
        $filter     = !is_null(data_get($request, 'filter')) ? json_decode(data_get($request, 'filter')) : null;
        $iuran      = Self::with(['rt']);
        $month  = null;
        $year   = null;
        if(!is_null(data_get($filter, 'month')) && !is_null(data_get($filter, 'year'))){
            $month = intval(data_get($filter, 'month'));
            $year = intval(data_get($filter, 'year'));
            $iuran = $iuran->where('bulan', $month)
            ->where('tahun', $year);
        }
        $iuran  = $iuran->get();
        $data   = [];
        $no     = 1;
        foreach($iuran as $row){
            $data[] = [
                'no'            => $no,
                'bulan'         => $month,
                'tahun'         => $year,
                'rt'            => data_get($row, 'rt.name'),
                'ketua_rt'      => data_get($row, 'rt.getKetuaRt.name'),
                'name'          => $row->name,
                'tagihan'       => getRupiah($row->nominal),
                'status_bayar'  => $row->status_bayar ? 'Sudah Bayar' : 'Belum Bayar',
                'tanggal_bayar' => $row->tanggal,
            ];
            $no++;
        }
        return $data;
    }

    public static function ajax($request){
        $rt      = data_get($request, 'rt');
        if(!is_null($rt) || !isEmpty($rt)){
            $rt = str_replace('rt', '', $rt);
        }

        $data = self::getIuran($request);

        $result = (object)[
            'resCount'  => data_get($data, 'resCount', 0),
            'records'   => data_get($data, 'records', [])
        ];
        return $result;
    }

    public static function getIuran($request){
        $pencarian  = data_get($request, 'search.value');
        $start      = data_get($request, 'start');
        $take       = data_get($request, 'length');
        $filter     = !is_null(data_get($request, 'filter')) ? json_decode(data_get($request, 'filter')) : null;
        $iuran      = Self::with(['rt']);
        $month      = null;
        $year       = null;
        if(!is_null(data_get($filter, 'month')) && !is_null(data_get($filter, 'year'))){
            $month = intval(data_get($filter, 'month'));
            $year = intval(data_get($filter, 'year'));
            $iuran = $iuran->where('bulan', $month)
            ->where('tahun', $year);
        }
        if(!is_null($pencarian) || !isEmpty($pencarian)){
            $iuran = $iuran->where(function ($query) use ($pencarian) {
                $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($pencarian) . '%'])
                    ->orWhereHas('rt', function ($q2) use ($pencarian) {
                        $q2->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($pencarian) . '%']);
                    });
            });
        }
        $counted_rows = $iuran->count();
        if(!is_null($start) && !is_null($take)){
            $iuran = $iuran->skip($start)->take($take);
        }

        $no     = 1;
        $data   = [];
        $iuran  = $iuran->get();
        foreach($iuran as $row){
            $data[] = [
                'no'            => $no,
                'id'            => Security::encryptId($row->id),
                'name'          => $row->name,
                'tanggal_bayar' => $row->tanggal,
                'bulan'         => $month,
                'tahun'         => $year,
                'rt_id'         => Security::encryptId($row->rt->id),
                'rt'            => data_get($row, 'rt.name'),
                'ketua_rt'      => data_get($row, 'rt.getKetuaRt.name'),
                'tagihan'       => getRupiah($row->nominal),
                'status_bayar'  => $row->status_bayar ? 'Sudah Bayar' : 'Belum Bayar',
            ];
            $no++;
        }

        return [
            'resCount' => $counted_rows,
            'records' => $data,
        ];
    }

    public static function getRow($request){
        $id     = Security::decryptId($request[0]->id);
        return self::find($id);
    }

    public static function updateById($request){
        $enc_id     = data_get($request, 'id');
        $tagihan    = data_get($request, 'tagihan');
        $id = Security::decryptId($enc_id);
        $iuran = self::where('id', $id)
            ->with(['rt'])
            ->first();
        if(!is_null($iuran)){
            $iuran->updated_by = getUserLoginId();
            $iuran->nominal = formatStringToNominal($tagihan);
            $iuran->save();
            return $iuran;
        }else{
            return null;
        }
    }

    public static function bayarRow($values){
        try {
            DB::beginTransaction();

            $iuran = self::getRow($values);
            if (!$iuran) {
                throw new \Exception("Data Iuran tidak ditemukan.");
            }

            $iuran->updated_by = getUserLoginId();
            $iuran->tanggal = date('Y-m-d');
            $iuran->status_bayar = true;
            $iuran->save();

            $laporan_keuangan = RwTransaction::transaction($iuran, 'debit');
            if (!$laporan_keuangan) {
                throw new \Exception("Gagal memperbarui laporan keuangan.");
            }

            DB::commit();

            return $iuran;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public static function createRow($request){
        try {
            DB::beginTransaction();
            $iuran = new IuranRt();
            $iuran->created_by = getUserLoginId();
            $iuran->name = $request->name;
            $iuran->nominal = formatStringToNominal($request->nominal);
            $iuran->rt_id = $request->rt_id;
            $iuran->bulan = $request->bulan;
            $iuran->tahun = $request->tahun;
            // dd($iuran);
            $iuran->save();
            DB::commit();
            return $iuran;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}