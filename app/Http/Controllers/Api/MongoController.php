<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\UserActivity;
use Illuminate\Http\Request;
use mongodb\mongodb;
use Browser;
use URL;
use Stevebauman\Location\Facades\Location;

class MongoController extends Controller
{
    public function mongo_activity()
    {
        $client = new mongodb\Client(
            'mongodb+srv://akhdani:w2e3r4t5@cluster0-kpsoi.gcp.mongodb.net/?retryWrites=true&w=majority'
        );

        $records = $client->test;
        return json_encode($records);
    }

    public function store_activity(Request $request)
    {
        $userActivity = new UserActivity;

        /* Default
        $userActivity->latitude = $request->lat;
        $userActivity->longitude = $request->long;
        $userActivity->user_agent = Browser::userAgent();
        */

        // Get position
        $position = Location::get();
        $currentUrl = url()->previous();

        // Init value
        $latitude       = (empty($request->lat)) ? $position->latitude : $request->lat;
        $longitude      = (empty($request->long)) ? $position->longitude : $request->long;
        $user_agent     = (empty($request->user_agent)) ? Browser::userAgent() : $request->user_agent;
        $ip_address     = (empty($request->ip_address)) ? $position->ip : $request->ip_address;
        $user_id        = $request->user_id;
        $merchant_id    = $request->merchant_id;
        $submerchant_id = $request->submerchant_id;
        $sof_id         = $request->sof_id;
        $action_path    = (empty($request->action_path)) ? $currentUrl : $request->action_path;

        // Mapping field to value
        $userActivity->latitude         = $latitude;
        $userActivity->longitude        = $longitude;
        $userActivity->user_agent       = $user_agent;
        $userActivity->ip_address       = $ip_address;
        $userActivity->user_id          = $user_id;
        $userActivity->merchant_id      = $merchant_id;
        $userActivity->submerchant_id   = $submerchant_id;
        $userActivity->sof_id           = $sof_id;
        $userActivity->action_path      = $action_path;

        $userActivity->save();

        return response()->json(['status' => '0000'], 201);
    }
}
