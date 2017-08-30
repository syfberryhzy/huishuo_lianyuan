<?php

function get_wechat_share()
{
	$client = new \GuzzleHttp\Client();
    $res = $client->request('GET', 'http://www.fhlts.com/share?url=' . config('app.url') . request()->getRequestUri());
    if ($res->getStatusCode() == 200) {
        $jssdk = $res->getBody()->getContents();
    }
    return $jssdk;
}

function get_js_api_list()
{
	return array('onMenuShareTimeline', 'onMenuShareAppMessage');
}
