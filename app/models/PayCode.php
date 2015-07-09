<?php namespace App\Model;

class PayCode extends  \Eloquent {
    protected $table = "pay_code";
    protected $customer = "customer";
    protected $card = "card";
    public $timestamps = false;

    public function getPayCodes($keyword, $cardno, $offset, $limit) {
        $sql = "select a.*,ifnull(b.username,'无') as username,ifnull(c.cardno, ' ') as cardno from $this->table a ";
        $sql .= " left join $this->customer b on b.id = a.uid ";
        $sql .=" left join $this->card c on c.id = a.cardid ";
        if($keyword) {
            $sql .= " where b.username like '%$keyword%' or a.uid like '%$keyword%'  or c.cardno = '$cardno' ";
        }
        $sql .= "order by id desc ";
        if($limit > 0) {
            $sql .= " limit $offset, $limit ";
        }

        $result = \DB::select($sql);
        return $result;
    }

    public function countPayCodes($keyword, $cardno) {
        $sql = "select count(*) as total from $this->table a ";
        $sql .= " left join $this->customer b on b.id = a.uid ";
        $sql .=" left join $this->card c on c.id = a.cardid ";
        if($keyword) {
            $sql .= " where b.username like '%$keyword%' or a.uid like '%$keyword%' or c.cardno = '$cardno' ";
        }

        $result = \DB::select($sql);
        $total = $result[0]->total;
        return $total;
    }
}