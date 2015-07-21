<?php

return array(
    'weixin'   => array(
        //'app_id'       => 'wxbb9470032b0bf571',
        //'app_secret'   => '0de2a4fd0d9113ed8ed0b7c6d9769a30',
        'app_id' => 'wx8505d9cd5dd397b5',
        'app_secret' => 'b399a513ad20f77505e429a8cbad9403',
        'token'        => 'suolong123',
        'token_url'    => 'cardhebeiyikatongcard',
        'pay_sign_key' => '',
        'partner_id'   => '',
        'partner_key'  => '',
        'sign_type'    => 'SHA1',
        'weixin_url' => 'https://api.weixin.qq.com/cgi-bin/'
    ),
    'merchant' => array(
        'api_url'      => 'http://192.192.219.186:9999',
        'account'      => '75900022',
        'pwd'          => '23789502',
        'platformId'   => 2,
        'work_key'     => '08fd47922a8e7bade15b6a59593bee20',
        'pos_token'    => 'a9ck80in',
        'app_token'    => 'nl98jkfth$h',
        'cardRecharge' => array(0 => 5000, 1 => 1000), //0记名卡 1非记名卡
        'errorCode'    => array('-1' => '卡校验码错误', '01' => '查询失败', '14' => '无效的卡号', '55' => '密码错误'),
    ),
    'baidu' => array(
        'map_ak'          => 'rGNbe9ttCWhnGExQHUsDWHRi',
    ),
);