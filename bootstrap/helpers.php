<?php

function get_wechat_share()
{
    $client = new \GuzzleHttp\Client();
    $res = $client->request('GET', 'http://www.fhlts.com/share?url=' . config('app.url') . request()->getRequestUri());
    if ($res->getStatusCode() == 200) {
        $jssdk = json_decode($res->getBody()->getContents());
        $jsApiList = array('onMenuShareTimeline', 'onMenuShareAppMessage');
    }
    return array('jssdk' => $jssdk, 'jsapilist' => $jsApiList);
}
