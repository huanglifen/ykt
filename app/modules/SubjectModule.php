<?php namespace App\Module;

use App\Model\Subject;

/**
 * 专题活动module层
 *
 * @package App\Module
 */
class SubjectModule extends BaseModule {

    /**
     * 新增一个活动主题
     *
     * @param $title
     * @param $content
     * @param $startTime
     * @param $endTime
     * @param $status
     * @param $remark
     * @param $field 申请报名时需要填的字段，以逗号","分隔
     * @return array
     */
    public static function addSubject($title, $content, $startTime, $endTime, $status, $remark, $field) {
        $subject = new Subject();
        $subject->title = $title;
        $subject->content = $content;
        $subject->start_time = $startTime;
        $subject->end_time = $endTime;
        $subject->status = $status;
        $subject->remark = $remark;
        $subject->field = $field;

        $subject->save();
        return array('status' => true, 'id' => $subject->id);
    }

    /**
     * 按主键删除一个活动主题
     *
     * @param $id
     * @return array
     */
    public static function deleteSubject($id) {
        $subject = Subject::find($id);
        if(empty($subject)) {
            return array('status' => false, 'id' => 'error_id_not_exist');
        }
        Subject::destroy($id);
        return array('status' => true);
    }

    /**
     * 按主键更新一个活动主题
     *
     * @param $id
     * @param $title
     * @param $content
     * @param $startTime
     * @param $endTime
     * @param $status
     * @param $remark
     * @param $field
     * @return array
     */
    public static function updateSubject($id, $title, $content, $startTime, $endTime, $status, $remark, $field) {
        $subject = Subject::find($id);
        if(empty($subject)) {
            return array('status' => false, 'msg' => 'error_id_not_exist');
        }
        $subject->title = $title;
        $subject->content = $content;
        $subject->start_time = $startTime;
        $subject->end_time = $endTime;
        $subject->status = $status;
        $subject->remark = $remark;
        $subject->field = $field;

        $subject->save();
        return array('status' => true, 'id' => $subject->id);
    }

    /**
     * 按主键获取活动专题
     *
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public static function getSubjectById($id) {
        return Subject::find($id);
    }

    /**
     * 按条件获取活动专题
     *
     * @param $title
     * @param $startTime
     * @param $endTime
     * @param $status
     * @param $offset
     * @param $limit
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getSubjects($title, $startTime, $endTime, $status, $offset, $limit) {
        $subject = new Subject();
        if($title) {
            $subject = $subject->where('title', 'like', "%$title%");
        }
        if($startTime) {
            $subject = $subject->where('start_time', '>=', $startTime);
        }
        if($endTime) {
            $subject = $subject->where('end_time', '<=', $endTime);
        }
        if($status) {
            $subject = $subject->where('status', $status);
        }
        if($limit) {
            $subject = $subject->offset($offset)->limit($limit);
        }
        return $subject->get();
    }

    public static function countSubjects($title, $startTime, $endTime, $status, $offset, $limit) {
        $subject = new Subject();
        if($title) {
            $subject = $subject->where('title', 'like', "%$title%");
        }
        if($startTime) {
            $subject = $subject->where('start_time', '>=', $startTime);
        }
        if($endTime) {
            $subject = $subject->where('end_time', '<=', $endTime);
        }
        if($status) {
            $subject = $subject->where('status', $status);
        }
        if($limit) {
            $subject = $subject->offset($offset)->limit($limit);
        }
        return $subject->count();
    }
}