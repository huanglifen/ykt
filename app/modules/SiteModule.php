<?php namespace App\Module;

use App\Model\Site;

class SiteModule extends BaseModule {
    const TYPE_DIRECT = 1; //直营网点
    const TYPE_Agent = 2; //代理网点
    const TYPE_Cooperate = 3; //合作网点

    /**
     * 新增一个网点
     *
     * @param $type
     * @param $number
     * @param $name
     * @param $contact
     * @param $address
     * @param $startTime
     * @param $endTime
     * @param string $picture
     * @param string $remark
     * @return array
     */
    public static function addSite($type, $number, $name, $contact, $address, $startTime, $endTime, $picture = '', $remark = '') {
        $site = new Site();
        $site->type = $type;
        $site->number = $number;
        $site->name = $name;
        $site->contactor = $contact;
        $site->address = $address;
        $site->start_time = $startTime;
        $site->end_time = $endTime;
        $site->picture = $picture;
        $site->remark = $remark;

        $site->save();
        return array('status' => true, 'id' => $site->id);
    }

    /**
     * 删除一个网点
     *
     * @param $id
     * @return array
     */
    public static function deleteSite($id) {
        $site = Site::find($id);
        if(empty($site)) {
            return array('status' => false, 'msg' => 'error_id_not_exist');
        }
        Site::destroy($id);
    }

    public static function updateSite($id, $type, $number, $name, $contact, $address, $startTime, $endTime, $picture = '', $remark = '') {
            $site = new Site();
            $site->type = $type;
            $site->number = $number;
            $site->name = $name;
            $site->contactor = $contact;
            $site->address = $address;
            $site->start_time = $startTime;
            $site->end_time = $endTime;
            $site->picture = $picture;
            $site->remark = $remark;

            $site->save();
            return array('status' => true, 'id' => $site->id);
    }
}