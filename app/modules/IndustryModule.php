<?php namespace App\Module;

use App\Model\Industry;

/**
 * 行业module层
 *
 * @package App\Module
 */
class IndustryModule extends BaseModule {
    const DEFAULT_PARENT = 0;
    const MAX_CHILD = 999;

    /**
     * 添加一个行业
     *
     * @param $name
     * @param int $parentId
     * @return array
     */
    public static function addIndustry($name, $parentId = 0) {
        $has = self::checkDuplicate($name, $parentId);
        if($has) {
            return array('status' => false, 'msg' => 'error_industry_has_exist');
        }
        $result = self::generateNumberByParentId($parentId);
        if(! $result['status']) {
            return $result;
        }
        $number = $result['number'];
        $industry = new Industry();
        $industry->name = $name;
        $industry->number = $number;
        $industry->parent_id = $parentId;
        $industry->save();

        return array('status' => true, 'id' => $industry->id);
    }

    /**
     * 删除一个行业
     *
     * @param $id
     * @return array
     */
    public static function deleteIndustry($id) {
        $hasChild = self::checkChild($id);
        if($hasChild) {
            return array('status' => false, 'msg' => 'error_has_child');
        }
        Industry::destroy($id);
        return array('status' => true);
    }

    /**
     * 更新行业
     *
     * @param $id
     * @param $name
     * @param $parentId
     * @return array
     */
    public static function updateIndustryById($id, $name, $parentId = 0) {
        $industry = Industry::find($id);
        if(empty($industry)) {
            return array('status' => false, 'msg' => 'error_industry_not_exist');
        }
        $has = self::checkDuplicate($name, $parentId, $id);
        if($has) {
            return array('status' => false, 'msg' => 'error_industry_has_exist');
        }
        if($parentId != $industry->parent_id) {
            $has = self::checkChild($id);
            if($has) {
                return array('status' => false, 'msg' => 'error_has_child_cannot_change_parentId');
            }
            $result = self::generateNumberByParentId($parentId);
            if(! $result['status']) {
                return $result;
            }
            $industry->parent_id = $parentId;
            $industry->number = $result['number'];
        }
        $industry->name = $name;
        $industry->save();
        return array('status' => true);
    }

    /**
     * 按条件获取行业记录
     *
     * @param string $keyword
     * @param int $parentId
     * @param $offset
     * @param $limit
     *
     * @return Industry|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getIndustries($keyword = '', $parentId = 0, $offset = 0, $limit = 500) {
        $industry = new Industry();
        if($keyword){
            $industry = $industry->where('name', 'like', "%$keyword%");
        }
        if($parentId > 0 ) {
            $industry = $industry->where('parent_id', $parentId);
        } elseif ($parentId == 0) {
            $industry = $industry->where('parent_id', $parentId)->orwhere('parent_id', 'is', 'null');
        }
        if($limit > 0) {
            $industry = $industry->limit($limit)->offset($offset);
        }
        $industry = $industry->orderBy('number');
        $industry = $industry->get();
        return $industry;
    }

    /**
     * 按条件统计行业记录
     *
     * @param string $keyword
     * @param int $parentId
     * @return int
     */
    public static function countIndustries($keyword = '', $parentId = 0) {
        $industry = new Industry();
        if($keyword){
            $industry->where('name', 'like', "%$keyword%");
        }
        if($parentId > 0 ) {
            $industry->where('parent_id', $parentId);
        } elseif ($parentId == 0) {
            $industry->where('parent_id', $parentId)->orwhere('parent_id', 'is', 'null');
        }
        $count = $industry->count();
        return $count;
    }

    /**
     * 按主键获取一个行业
     *
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public static function getIndustryById($id) {
        return Industry::find($id);
    }

    /**
     * 根据父行业id生成行业编号
     *
     * @param $parentId
     * @return array
     */
    protected static function generateNumberByParentId($parentId) {
        if($parentId) {
            $parent = Industry::find($parentId);
            if(empty($parent)) {
                return array('status' => false, 'msg' => 'error_parent_not_exist');
            }
            $parentNo = $parent->number;
        }else{
            $parentId = 0;
            $parentNo = '';
        }
        $number = self::generateNumber($parentId, $parentNo);
        if(! $number) {
            return array('status' => false, 'msg' => 'error_industry_over_max');
        }
        return array('status' => true, 'number' => $number);
    }

    /**
     * 检查是否含子行业
     *
     * @param $id
     * @return bool
     */
    public static function checkChild($id) {
        $industry = new Industry();
        $count = $industry->where('parent_id', $id)->count();
        return $count ? true : false;
    }

    /**
     * 检查行业是否已存在
     *
     * @param $name
     * @param $parentId
     * @param int $id
     * @return bool
     */
    protected static function checkDuplicate($name, $parentId, $id = 0) {
        $count = Industry::where('name', $name)->where('parent_id', $parentId);
        if($id) {
            $count = $count->where('id', '!=', $id);
        }
        $count = $count->count();
        return $count ? true : false;
    }

    /**
     * 生成行业编号
     *
     * @param $parentId
     * @param $parentNo
     * @return bool|string
     */
    private static function generateNumber($parentId, $parentNo) {
        $last = Industry::where('parent_id', $parentId)->orderBy('created_at', 'desc')->first();

        if($last) {
            $last = intval(substr($last->number, -1, 2));
            if($last >= self::MAX_CHILD) {
                return false;
            }
            $no = str_pad($last + 1, 3, '0', STR_PAD_LEFT);
        }else {
            $no = '001';
        }
        $number = $parentNo . $no;
        return $number;
    }
}