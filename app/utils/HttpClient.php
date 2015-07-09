<?php namespace App\Utils;
/**
 * Http工具
 *
 */
class HttpClient {
    /**
     * curl请求 get方式
     *
     * @param $url
     * @return mixed
     */
    public static function quickGet($url) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, 0); // 过滤HTTP头
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 显示输出结果
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //证书认证
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    /**
     * curl请求，post方式
     *
     * @param $url
     * @param $data
     * @return mixed
     */
    public static function quickPost($url, $data) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $responseText = curl_exec($curl);
        curl_close($curl);
        //$error = curl_error($curl);
        //var_dump( $error );exit;
        return $responseText;
    }
}
