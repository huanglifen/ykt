<?php namespace App\Module;

use App\Model\Dump;
use App\Utils\Utils;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DumpModule extends BaseModule {

    public static $dumpTable = array(
        'business',
        'card',
        'card_bind',
        'card_log',
        'log',
        'customer',
        'pay_code'
    );

    /**
     * 新增备份
     *
     * @param $path
     * @param $size
     * @return array
     */
    public static function addDump($path, $size) {
        $dump = new Dump();
        $dump->path = $path;
        $dump->size = $size;

        $dump->save();
        return array('status' => true, 'id' => $dump['id']);
    }

    /**
     * 获取最近一次备份
     *
     * @return \Illuminate\Database\Eloquent\Model|mixed|null|static
     */
    public static function getLastedDump() {
        $dump = Dump::orderBy('created_at', 'desc')->first();
        if(empty($dump)) {
            $dump = new Dump();
            $dump->path = '';
            $dump->size = '';
            $dump->created_at = '';
        }
        return $dump;
    }

    /**
     * 数据库备份
     *
     * @return array
     */
    public static function dumpDataBase($dumpPath) {
        $tables = self::tableToSql();

        $sqlName = date("YmdHis" . rand(10, 99), time()).".sql";
        Utils::createDirectoryIfNotExist($dumpPath);
        $target = fopen($dumpPath . "/" . $sqlName, "w");

        foreach($tables as $table) {
            if(in_array($table, self::$dumpTable)) {
                $result = self::dumpSql($table, $target);
                if(! $result) {
                    break;
                }
            };
        }
        fclose($target);
        return array('status' => $result, 'target' => $dumpPath . "/" . $sqlName, 'msg' => 'error_dump_fail');
    }

    /**
     * 执行某个sql文件
     *
     * @param $filePath
     * @return array
     */
    public static function recovery($filePath) {
        $sql = file_get_contents($filePath);
        $sql = explode("{;}\n\n", $sql);
        foreach($sql as $s) {
            $s = trim($s);
            if(! empty($s)) {
                $result = \DB::select($s);
            }
        }
        return array('status' => true, 'msg' => 'error_recovery_fail');
    }

    /**
     * 获取所有表名，存入数组
     *
     * @return array
     */
    protected static function tableToSql() {
        $result = \DB::select("SHOW TABLES");
        $database = Config::get('database.connections.mysql.database');
        $field = "Tables_in_".$database;
        $tables = array();
        foreach($result as $r) {
            $r = (array)$r;
            $tables[] = $r[$field];
        }
        return $tables;
    }

    /**
     * 生成每个表的sql语句，并写入文件
     *
     * @param $table
     * @param $target
     * @return bool
     */
    protected static function dumpSql($table, $target) {
        $tableDump = "DROP TABLE IF EXISTS $table {;}\n\n";

        $createTable = \DB::select("SHOW CREATE TABLE $table");
        $createTable = (array)$createTable[0];

        $tableDump .= $createTable["Create Table"] . "{;}\n\n";
        $queryAll = \DB::select("select * from $table");

        $result = fwrite($target, $tableDump);
        if(! $result) {
            return false;
        }
        foreach($queryAll as $all) {
            $all = (array) $all;
            $column = "";
            foreach($all as $key => $value) {
                if($column == "") {
                    $string = "" . $key ."";
                    $column = $string;
                } else {
                    $string = "," . $key ."";
                    $column .= $string;
                }
            }
            $insertSql = "insert into $table ($column) values ( ";
            $result = fwrite($target, $insertSql);
            if(! $result) {
                return false;
            }
            $flag = true;
            foreach($all as $key => $value) {
                if($flag) {
                    $string = "'" . $value . "'";
                    $result = fwrite($target, $string);
                } else {
                    $string = ",'" . $value . "'";
                    $result = fwrite($target, $string);
                }
                if(! $result) {
                    return false;
                }
                $flag = false;
            }
            $result = fwrite($target, " ) {;}\n\n");
            if(! $result) {
                return false;
            }
        }
        return true;
    }
}