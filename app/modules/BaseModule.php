<?php namespace App\Module;

abstract class BaseModule {
    const NUM_PER_PAGE = 10; //每页显示行数
    const STATUS_OPEN= 1;
    const STATUS_CLOSE = 2;

    /**
     * 哈希
     *
     * @param $string
     * @return string
     */
    protected static function hash($string) {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $salt = substr ( str_shuffle ( str_repeat ( $pool, 5 ) ), 0, 16 );
        return $salt . hash ( 'sha256', $salt . $string );
    }

    /**
     * 检查哈希
     *
     * @param $string
     * @param $hashedString
     * @return bool
     */
    protected static function checkHash($string, $hashedString) {
        $salt = substr ( $hashedString, 0, 16 );

        return ($salt . hash ( 'sha256', $salt . $string )) === $hashedString;
    }

    /**
     * 获取当前url
     *
     * @return string
     */
    protected static function current_url() {
        $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
        $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
        $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self . (isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : $path_info);
        return $sys_protocal . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '') . $relate_url;
    }

    /**
     * 加/解密
     * @param $string
     * @param $operation "D"为解密，"E"为加密
     * @param string $key
     * @return mixed|string
     */
    public static function encrypt($string, $operation, $key = '') {
        $key = md5($key);
        $key_length = strlen($key);
        $string = $operation == "D" ? base64_decode($string) : substr(md5($string.$key),0, 8).$string;
        $string_length = strlen($string);

        $rndkey = $box=array();
        $result = '';
        for($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($key[$i%$key_length]);
            $box[$i] = $i;
        }

        for($j=$i=0; $i<256; $i++) {
            $j=($j+$box[$i]+$rndkey[$i])%256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for($a=$j=$i=0; $i < $string_length; $i++) {
            $a= ($a+1)%256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i])^($box[($box[$a] + $box[$j])%256]));
        }

        if($operation == "D") {
            if(substr($result,0, 8) == substr(md5(substr($result, 8) . $key), 0, 8)){
                return substr($result, 8);
            }else {
                return '';
            }
        }else {
            return str_replace('=', '', base64_encode(($result)));
        }
    }

}