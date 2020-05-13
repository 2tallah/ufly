<?php

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

function locale()
{
    return Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale();
}

function locales()
{
    $arr = [];
    foreach (LaravelLocalization::getSupportedLocales() as $key => $value) {
        $arr[$key] = __(''.$value['name']);
    }
    return $arr;
}

function languages()
{
    if (app()->getLocale() == 'en') {
        return ['ar' => 'arabic', 'en' => 'english'];
    } else {
        return ['ar' => 'العربية', 'en' => 'النجليزية'];

    }
}
function youtubeVideoId($url)
{
    $pattern =
        '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x'
    ;
    $result = preg_match($pattern, $url, $matches);
    if ($result) {
        return $matches[1];
    }
    return false;

}

function mainResponse ($status, $msg, $items, $resource, $validator, $code = 200, $pages = null)
{
    if (isset(json_decode(json_encode($items, true), true)['data'])) {
        $pagination = json_decode(json_encode($items, true), true);
        $pages = [
            "current_page" => $pagination['current_page'],
            "first_page_url" => $pagination['first_page_url'],
            "from" => $pagination['from'],
            "last_page" => $pagination['last_page'],
            "last_page_url" => $pagination['last_page_url'],
            "next_page_url" => $pagination['next_page_url'],
            "path" => $pagination['path'],
            "per_page" => $pagination['per_page'],
            "prev_page_url" => $pagination['prev_page_url'],
            "to" => $pagination['to'],
            "total" => $pagination['total'],
        ];
    } else {
        $pages = [
            "current_page" => 0,
            "first_page_url" => '',
            "from" => 0,
            "last_page" => 0,
            "last_page_url" => '',
            "next_page_url" => null,
            "path" => '',
            "per_page" => 0,
            "prev_page_url" => null,
            "to" => 0,
            "total" => 0,
        ];
    }

    $aryErrors = [];
    foreach ($validator as $key => $value) {
        $aryErrors[] = ['field_name' => $key, 'messages' => $value];
    }
    /*    $aryErrors = array_map(function ($i) {
            return $i[0];
        }, $validator);*/

    $newData = ['status' => $status, 'message' => __($msg), 'items' => $resource, 'pages' => $pages, 'errors' => $aryErrors];

    return response()->json($newData);
}

function latlng($ip = '213.6.137.2')
{
    $url = 'http://ip-api.com/json/' . $ip;
    $headers = ['Accept' => 'application/json'];
    $http = new \GuzzleHttp\Client();
    $response = $http->get($url, [
        'headers' => $headers,
        'form_params' => [],
    ]);
    $data = json_decode((string)$response->getBody(), true);
    return ['lat' => $data['lat'], 'lng' => $data['lon']];
/*    if (array_key_exists('countryCode', $data)) {
        //do your code
    }
    return 'no data';*/
}
function check_number($mobile)
{
    $persian = array('٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠');
    $num = range(9, 0);
    $mobile = str_replace(' ', '', $mobile);
    $mobile = str_replace($persian, $num, $mobile);
    $mobile = substr($mobile, -9);

    if (preg_match("/^[5][0-9]{8}$/", $mobile))
    {
        $mobile = '966' . $mobile;

        return $mobile;
    }
    else
    {
        return FALSE;
    }
}

function send_sms($mobile, $message)
{
    $mobiles = [];
    foreach ($mobile as $item){
        $mobiles[] = check_number($item);
    }
    $mobiles = implode(',', $mobiles);
    if ($mobile)
    {
        $message = urlencode($message);
//        $url = "http://www.jawalsms.net/httpSmsProvider.aspx?username=wasilcom&password=987654321&mobile=$mobiles&unicode=E&message=$message&sender=WasilCom";
        $url = "shttps://www.hisms.ws/api.php?send_sms&username=966541412144&password=As120120&numbers=$mobiles&sender=FOORSA-AD&message=$message";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_HEADER,0);
        curl_setopt($ch, CURLE_HTTP_NOT_FOUND,1);
        $LastData = curl_exec ($ch);
        curl_close ($ch);
        return $LastData;


    }
}


function fcmNotification($token, $id, $title, $content, $body, $type, $device)
{
    $msg = [
        'id' => $id,
        'title' => $title,
        'content' => $content,
        'body' => $body,
        'type' => $type,
        'icon' => 'myicon',
        'sound' => 'mySound',
    ];
    if ($device == 'ios') {
        $fields = [
            'registration_ids' => $token,
            'notification' => $msg,
        ];
    } else {
        $fields = [
            'registration_ids' => $token,
            'data' => $msg,
        ];
    }

    $headers = [
        'Authorization: key=' . 'AIzaSyDaWIADGFq8BpCb5sXV8odGIolZYH1NVfE',
        'Content-Type: application/json'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);
}



