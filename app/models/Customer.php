<?php namespace App\Model;

/**
 * 客户model层
 * @package App\Model
 */
class Customer extends  \Eloquent {
    public $table = "customer";
    protected $cardTable = "card";

    /**
     * 按条件获取客户信息
     *
     * @param int $bind
     * @param int $type
     * @param $keyword
     * @param int $offset
     * @param int $limit
     * @param int $from_type
     * @return array
     */
    public function getCustomers($bind = 0, $type = -1, $keyword = '', $offset = 0, $limit = 0, $from_type = 0) {
        $sql = "select a.*,b.type as typec,b.cardno as cardno from $this->table a";
        $sql .= " left join card b on b.id = a.cardid ";
        $where = "where a.from_type = $from_type ";
        switch($bind) {
            case 1 :
                $where .= "and a.cardid = 0 or a.cardid is null ";
                break;
            case 2 :
                $where .= "and a.cardid > 0 ";
                break;
        }
        switch($type) {
            case 0 :
            case 1 :
                $where .="and b.type = $type ";
                break;
        }
        if($keyword) {
            $where .="and ( username like '%$keyword%' or openid like '%$keyword%' or mobile like '%$keyword%' or idcard like '%$keyword%') ";
        }

        $sql .= $where;
        if($limit > 0) {
            $sql .= " limit $offset, $limit";
        }
        return \DB::select($sql);
    }

    /**
     * 统计客户积累
     *
     * @param int $bind
     * @param int $type
     * @param string $keyword
     * @param int $from_type
     * @return mixed
     */
    public function countCustomers($bind = 0, $type = -1, $keyword = '', $from_type = 0) {
        $sql = "select count(1) as total from $this->table a ";
        $sql .= " left join card b on b.id = a.cardid ";
        $where = "where a.from_type = $from_type ";
        switch($bind) {
            case 1 :
                $where .= "and a.cardid = 0 or a.cardid is null ";
                break;
            case 2 :
                $where .= "and a.cardid > 0 ";
                break;
        }
        switch($type ) {
            case 0 :
            case 1 :
                $where .="and b.type = $type ";
                break;
        }
        if($keyword) {
            $where .="and ( username like '%$keyword%' or openid like '%$keyword%' or mobile like '%$keyword%' or idcard like '%$keyword%' ) ";
        }
        $sql .= $where;
        $result =  \DB::select($sql);
        $total = $result[0]->total;
        return $total;
    }
}