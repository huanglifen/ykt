<?php namespace App\Module;

use App\Model\JoinSubject;

/**
 * 报名参加活动
 *
 * @package App\Module
 */
class JoinSubjectModule extends BaseModule {

    /**
     * 按活动获取报名用户信息
     *
     * @param $subjectId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getJoinSubjectsBySubjectId($subjectId) {
        return JoinSubject::where('subject_id', $subjectId)->get();
    }
}