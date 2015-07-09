<?php namespace App\Module;
use App\Model\Activity;

/**
 * 活动module层
 *
 * @package App\Module
 */
class ActivityModule extends BaseModule {

    /**
     * 增加一个活动
     *
     * @param $businessId
     * @param $title
     * @param $startTime
     * @param $endTime
     * @param $content
     * @param $status
     * @return array
     */
    public static function addActivity($businessId, $title, $startTime, $endTime, $content, $status) {
        $activity = new Activity();
        $activity->business_id = $businessId;
        $activity->title = $title;
        $activity->start_time = $startTime;
        $activity->end_time = $endTime;
        $activity->content = $content;
        $activity->status = $status;

        $activity->save();
        return array('status' => true);
    }

    /**
     * 删除一个活动
     *
     * @param $id
     * @return array
     */
    public static function deleteActivity($id) {
        Activity::destroy($id);
        return array('status' => true);
    }

    /**
     * 更新活动
     *
     * @param $id
     * @param $businessId 该参数先留着，优化时可能会用到
     * @param $title
     * @param $startTime
     * @param $endTime
     * @param $content
     * @param $status
     * @return array
     */
    public static function updateActivity($id, $businessId, $title, $startTime, $endTime, $content, $status) {
        $activity = Activity::find($id);
        if(empty($activity)) {
            return array('status' => true, 'msg' => 'coupon_not_exist');
        }
        $activity->title = $title;
        $activity->start_time = $startTime;
        $activity->end_time = $endTime;
        $activity->content = $content;
        $activity->status = $status;

        $activity->update();
        return array('status' => true);
    }

    /**
     * 获取活动记录
     *
     * @param $businessId
     * @param $keyword
     * @param int $offset
     * @param int $limit
     * @return Activity|\Illuminate\Database\Eloquent\Builder|static
     */
    public static function getActivity($businessId, $keyword, $offset = 0, $limit = 0) {
        $activity = new Activity();
        $activity = $activity->where('business_id', $businessId);
        if($keyword) {
            $activity = $activity->where('title', 'like', "%$keyword%");
        }
        if($limit > 0) {
            $activity = $activity->offset($offset)->limit($limit);
        }
        return $activity->get();
    }

    /**
     * 统计活动
     *
     * @param $businessId
     * @param $keyword
     * @return int
     */
    public static function countActivity($businessId, $keyword) {
        $activity = new Activity();
        $activity = $activity->where('business_id', $businessId);
        if($keyword) {
            $activity = $activity->where('title', 'like', "%$keyword%");
        }
        return $activity->count();
    }

    /**
     * 按主键获取活动
     *
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public static function getActivityById($id) {
        return Activity::find($id);
    }
}