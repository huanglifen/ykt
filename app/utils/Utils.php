<?php namespace App\Utils;

use Illuminate\Support\Facades\Config;
use Symfony\Component\Routing\Annotation\Route;

require_once __DIR__ . "/Barcode/BCGFontFile.php";
require_once __DIR__ . "/Barcode/BCGColor.php";
require_once __DIR__ . "/Barcode/BCGDrawing.php";
require_once __DIR__ . "/phpqrcode.php";
/**
 * 助手类
 * @package App\Utils
 */
class Utils  {
    /**
     * 生成条形码
     *
     * @param $data
     * @param int $type
     */
    public static function barCreate($data, $type = 128) {
        include_once __DIR__ . "/Barcode/BCGcode" . $type . ".php";

        $font = new \BCGFontFile(__DIR__ . '/Barcode/font/Arial.ttf', 22);
        //颜色条形码
        $color_black = new \BCGColor(0, 0, 0);
        $color_white = new \BCGColor(255, 255, 255);
        $drawException = null;
        try {
            switch($type) {
                case 11 :
                    $code = new \BCGcode11();
                    break;
                case 39 :
                    $code = new \BCGcode39();
                    break;
                case 93 :
                    $code = new \BCGcode93();
                    break;
                case 128 :
                    $code = new \BCGcode128();
                    break;
            }
            $code->setScale(3);
            $code->setThickness(35); // 条形码的厚度
            $code->setForegroundColor($color_black); // 条形码颜色
            $code->setBackgroundColor($color_white); // 空白间隙颜色
            $code->setFont($font); //
            $label = substr($data, 0, 4) . ' ' . substr($data, 4, 4) . ' ' . substr($data, 8, 4) . ' ' . substr($data, 12, 6);
            $code->setLabel($label);
            $code->parse($data); // 条形码需要的数据内容
        } catch (Exception $exception) {
            $drawException = $exception;
        }
        //根据以上条件绘制条形码
        $drawing = new \BCGDrawing('', $color_white);
        if ($drawException) {
            $drawing->drawException($drawException);
        } else {
            $drawing->setBarcode($code);
            $drawing->draw();
        }
        // 生成PNG格式的图片
        header('Content-Type: image/png');
        $drawing->finish(\BCGDrawing::IMG_FORMAT_PNG);
    }

    /**
     * 生成二维码
     *
     * @param $data
     */
    public static function qrCreate($data) {
        $errorCorrectionLevel = 'L';
        $matrixPointSize      = 8;
        \QRcode::png($data, false, $errorCorrectionLevel, $matrixPointSize);
        exit;
    }

    /**
     * 生成长度为$number的随机码
     *
     * @param $number
     * @return string
     */
    public static function createRandNumberBySize($number) {
        $number = (int)$number;
        if ($number === 0) {
            return '';
        } else {
            $rankNumberString = "";
            for ($i = 0; $i < $number + 1; $i++) {
                if ($i !== 0 && $i % 2 === 0) {
                    $rankNumberString .= mt_rand(11, 99);
                }
            }
            if ($number % 2 === 0) {
                return $rankNumberString;
            } else {
                return $rankNumberString . mt_rand(1, 9);
            }
        }
    }

    /**
     * money转换 分转为元
     *
     * @param $money
     * @return int|string
     */
    public static function transMoney($money)
    {
        if ($money <= 0)
        {
            return 0;
        }
        return sprintf("%01.2f", $money / 100);
    }

    /**
     * 生成带签名的路由
     *
     * @param $openid
     * @param $uri
     * @param array $params
     * @return string
     */
    public static function createUrlBySignature($openid, $uri, $params = array()) {
        $timestamp = time();
        $signature = Utils::signature($openid, $timestamp);
        $data      = array('openid' => $openid, 'timestamp' => $timestamp, 'signature' => $signature);
        $params    = array_merge($data, $params);
        $url       = Utils::createUrl($uri, $params);
        return $url;
    }

    /**
     * 生成路由
     *
     * @param $uri
     * @param array $params
     * @return string
     */
    public static function createUrl($uri, $params = array()) {
        $url = \URL::to($uri);
        $flag = true;
        foreach($params as $key=>$param) {
            if($flag) {
                $url .="?$key=$param";
                $flag = false;
            }else{
                $url .="&$key=$param";
            }
        }
        return $url;
    }

    /**
     * 微信url生成签名
     *
     * @param $openid
     * @param $timestamp
     * @return string
     */
    public static function signature($openid, $timestamp) {
        $token  = Config::get('param.weixin.token_url');
        $tmpArr = array($token, $timestamp, $openid);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        return $tmpStr;
    }

    /**
     * 创建路径
     *
     * @param $dir
     */
    public static function createDirectoryIfNotExist($dir) {
        if (! file_exists ( $dir )) {
            mkdir ( $dir, 0777, true );
            chmod ( $dir, 0777 );
        } else if (! is_dir ( $dir )) {
            unlink ( $dir );
            mkdir ( $dir, 0777, true );
            chmod ( $dir, 0777 );
        }
    }
}