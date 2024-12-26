<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\QueryService\Facades\QueryServiceFacades as QS;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Models\UserActivity;

if (!function_exists('getRupiah')) {
    // Penggunaan: rupiah(2500000); return: "Rp2.500.000", dengan pembulatan, tanpa desimal
    // Jika parameter $satuan bernilai true, simbol 'Rp' ditambahkan di depan $nominal
    function getRupiah($nominal, $satuan = true, $kurungNegatif = false)
    {
        if (!is_numeric($nominal)) {
            return ($satuan ? 'Rp ' : '') . '0';
        }

        if ($nominal < 0) {
            if ($kurungNegatif) {
                return '(' . ($satuan ? 'Rp ' : '') . number_format(abs(floor($nominal)), 0, ',', '.') . ')';
            }
            return ($satuan ? '-Rp ' : '-') . number_format(abs(floor($nominal)), 0, ',', '.');
        }
        return ($satuan ? 'Rp ' : '') . number_format(ceil($nominal), 0, ',', '.');
    }
}

if (!function_exists('indonesiaMonths')) {
    function indonesiaMonths()
    {
        return array(
            ['value' => 1, 'label' => 'Januari'],
            ['value' => 2, 'label' => 'Februari'],
            ['value' => 3, 'label' => 'Maret'],
            ['value' => 4, 'label' => 'April'],
            ['value' => 5, 'label' => 'Mei'],
            ['value' => 6, 'label' => 'Juni'],
            ['value' => 7, 'label' => 'Juli'],
            ['value' => 8, 'label' => 'Agustus'],
            ['value' => 9, 'label' => 'September'],
            ['value' => 10, 'label' => 'Oktober'],
            ['value' => 11, 'label' => 'November'],
            ['value' => 12, 'label' => 'Desember'],
        );
    }
}

if (!function_exists('getindonesiaMonthText')) {
    function getindonesiaMonthText($monthNumber)
    {
        $listMonth     = indonesiaMonths();
        $filteredMonth = array_reduce($listMonth, function ($carry, $item) use ($monthNumber) {
            if ($item['value'] == $monthNumber)
                $carry = $item;
            return $carry;
        }, []);
        return $filteredMonth['label'];
    }
}

if (!function_exists('storeCache')) {
    function storeCache($key, $value, $exp = '')
    {
        if ($exp != '') {
            $exp = now()->addMinutes($exp);
        } else {
            // 10 menit;
            $exp = now()->addMinutes(1440);
        }
        if (Cache::has($key)) {
            Cache::put($key, $value, $exp);
        } else {
            Cache::add($key, $value, $exp);
        }
        return Cache::get($key);
    }
}

if (!function_exists('getCache')) {
    function getCache($key)
    {
        return Cache::get($key);
    }
}

function sendAPIUim($data){
    $api        = Config::get('app.url_api_uim');
    $response   = Http::withHeaders([
        'Content-Type' => 'application/json'
    ])->post($api, $data);
    return json_decode($response);
}

function sendAPI($data, $url){
    $api        = Config::get('app.url_api') . $url;
    $response   = Http::withHeaders([
        'Content-Type' => 'application/json'
    ])->post($api, $data);
    return json_decode($response);
}

function generateRandomString($length){
    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    return strtoupper(substr(str_shuffle(str_repeat($pool, 5)), 0, $length));
}

function getRupiah($nominal, $satuan = true, $kurungNegatif = false){
    if (!is_numeric($nominal)) {
        return ($satuan ? 'Rp ' : '') . '0';
    }

    if ($nominal < 0) {
        if ($kurungNegatif) {
            return '(' . ($satuan ? 'Rp ' : '') . number_format(abs(floor($nominal)), 0, ',', '.') . ')';
        }
        return ($satuan ? '-Rp ' : '-') . number_format(abs(floor($nominal)), 0, ',', '.');
    }
    return ($satuan ? 'Rp ' : '') . number_format(ceil($nominal), 0, ',', '.');
}

function userActivities($action, $description, $table, $type, $route){
    $record = new UserActivity();
    $record->cua_id         = generateRandomString(25);
    $record->cua_act        = $action;
    $record->cua_desc       = $description . ' table ' . $table;
    $record->cua_status     = '0000';
    $record->cua_by_uid     = Session::get('user')->userId;
    $record->cua_dt         = date('Y-m-d H:i:s');
    $record->cua_session    = Session::get('_token');
    $record->cua_ip         = Request::getClientIp();
    $record->cua_user_agent = Browser::browserFamily();
    $record->cua_act_id     = $route;
    $record->cua_type       = $type;
    $record->branch_code    = Session::get('user')->kodeCabang;

    if($record->save()){
        $rc = 200;
        $message = 'Save log success...';
    }else{
        $rc = 400;
        $message = 'Save log failed...';
    }

    return response()->json([
        'rc'        => $rc,
        'message'   => $message
    ], $rc);
}

function getMonths(){
    $months = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    ];

    return $months;
}

function isUserPusat($value){
    $userPusat = [1280, 1788, 1787, 1789, 1785];
    $result = in_array($value, $userPusat);
    return $result;
}