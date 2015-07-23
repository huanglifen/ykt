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
     * @param $areaId
     * @param $startTime
     * @param $endTime
     * @param $tel
     * @param string $picture
     * @param string $remark
     * @return array
     */
    public static function addSite($type, $number, $name, $contact, $address, $areaId, $startTime, $endTime, $tel = '', $picture = '', $remark = '') {
        $site = new Site();
        $site->type = $type;
        $site->number = $number;
        $site->name = $name;
        $site->contactor = $contact;
        $site->address = $address;
        $site->area_id = $areaId;
        $site->start_time = $startTime;
        $site->end_time = $endTime;
        $site->tel = $tel;
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
        return array('status' => true);
    }

    /**
     * 更新一个网点
     *
     * @param $id
     * @param $type
     * @param $number
     * @param $name
     * @param $contact
     * @param $address
     * @param $areaId
     * @param $startTime
     * @param $endTime
     * @param $tel
     * @param string $picture
     * @param string $remark
     * @return array
     */
    public static function updateSite($id, $type, $number, $name, $contact, $address, $areaId, $startTime, $endTime, $tel = '', $picture = '', $remark = '') {
        $site = Site::find($id);
        if(empty($site)) {
            return array('status' => false, 'msg' => 'error_id_not_exist');
        }
        $site->type = $type;
        $site->number = $number;
        $site->name = $name;
        $site->contactor = $contact;
        $site->address = $address;
        $site->area_id = $areaId;
        $site->start_time = $startTime;
        $site->end_time = $endTime;
        $site->tel = $tel;
        $site->picture = $picture;
        $site->remark = $remark;

        $site->update();
        return array('status' => true, 'id' => $site->id);
    }

    /**
     * 按条件获取网点记录
     *
     * @param $type
     * @param $name
     * @param $contact
     * @param $tel
     * @param int $offset
     * @param int $limit
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getSites($type, $name, $contact, $tel, $offset = 0, $limit = 0) {
        $site = new Site();
        if($type) {
            $site = $site->where('type', $type);
        }
        if($name) {
            $site = $site->where('name', 'like', "%$name%");
        }
        if($contact) {
            $site = $site->where('contactor', 'like', "%$contact%");
        }
        if($tel) {
            $site = $site->where('tel', 'like', "%$tel%");
        }
        if($limit > 0) {
            $site = $site->offset($offset)->limit($limit);
        }
        return $site->get();
    }

    /**
     * 按条件统计网点记录
     *
     * @param $type
     * @param $name
     * @param $contact
     * @param $tel
     * @return int
     */
    public static function countSites($type, $name, $contact, $tel) {
        $site = new Site();
        if($type) {
            $site = $site->where('type', $type);
        }
        if($name) {
            $site = $site->where('name', 'like', "%$name%");
        }
        if($contact) {
            $site = $site->where('contactor', 'like', "%$contact%");
        }
        if($tel) {
            $site = $site->where('tel', 'like', "%$tel%");
        }
        return $site->count();
    }

    /**
     * 按主键获取网点
     *
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public static function getSiteById($id) {
        return Site::find($id);
    }
}