<?php namespace App\Module;

class DumpModule extends BaseModule {

    public static function dumpDataBase() {
        $table = self::tableToSql();
    }

    /**
     * 获取所有表名，存入数组
     *
     * @return array
     */
    public static function tableToSql() {
        $result = \DB::select("show tables");
        $tables = array();
        foreach($result as $r) {
            $tables = $r['Tables_in_ykt'];
        }
        return $tables;
    }

    public static function data2sql($table)
    {
        global $db;
        $tabledump = "DROP TABLE IF EXISTS $table;\n";
        $createtable = $db->query("SHOW CREATE TABLE $table");
        $create = $db->fetch_row($createtable);
        $tabledump .= $create[1].";\n\n";
        $rows = $db->query("SELECT * FROM $table");
        $numfields = $db->num_fields($rows);
        $numrows = $db->num_rows($rows);
        while ($row = $db->fetch_row($rows))
        {
            $comma = "";
            $tabledump .= "INSERT INTO $table VALUES(";
            for($i = 0; $i < $numfields; $i++)
            {
                $tabledump .= $comma."'".MySQL_escape_string($row[$i])."'";
                $comma = ",";
            }
            $tabledump .= ");\n";
        }
        $tabledump .= "\n";
        return $tabledump;
    }
}