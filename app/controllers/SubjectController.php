<?php namespace App\Controllers;
use App\Module\JoinSubjectModule;
use App\Module\SubjectModule;

/**
 * 专题活动控制器
 *
 * @package App\Controllers
 */
class SubjectController extends BaseController {
    public $langFile = 'content';

    /**
     * 显示活动专题页面
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getIndex() {
        if(! $this->isLogin()) {
            return \Redirect::to("/login");
        }
        return $this->showView('content.subject');
    }

    /**
     * 按条件获取活动专题记录
     *
     * @return string
     */
    public function getSubjects() {
        $this->outputUserNotLogin();

        $offset = $this->getParam('iDisplayStart');
        $limit = $this->getParam('iDisplayLength');
        $title = $this->getParam('title');
        $startTime = $this->getParam('startTime');
        $endTime = $this->getParam('endTime');
        $status = $this->getParam('status');

        $this->outputErrorIfExist();

        $subjects = SubjectModule::getSubjects($title, $startTime, $endTime, $status, $offset, $limit);
        $total = SubjectModule::countSubjects($title, $startTime, $endTime, $status, $offset, $limit);
        $result = array('subjects' => $subjects, 'iTotalDisplayRecords' => $total, '_iRecordsTotal' => $total, 'iDisplayStart' => $offset, 'iDisplayLength' => $limit);
        return json_encode($result);
    }

    /**
     * 显示增加活动专题页面
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getAdd() {
        if(! $this->isLogin()) {
            return \Redirect::to("/login");
        }
        return $this->showView('content.subject-add');
    }

    /**
     * 新增一个活动专题请求
     *
     * @return string
     */
    public function postAdd() {
        $this->outputUserNotLogin();

        $title = $this->getParam('title', 'required|max:100');
        $content = $this->getParam('content', 'required');
        $startTime = $this->getParam('startTime');
        $endTime = $this->getParam('endTime');
        $status = $this->getParam('status');
        $remark = $this->getParam('remark');
        $fields = $this->getParam('fields');

        $this->outputErrorIfExist();

        $result = SubjectModule::addSubject($title, $content, $startTime, $endTime, $status, $remark, $fields);
        $this->outputErrorIfFail($result);
        return $this->outputContent($result);
    }

    /**
     * 显示更新页面
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getUpdate($id = 0) {
        if(! $this->isLogin()) {
            return \Redirect::to("/login");
        }
        if(! $id) {
            return \Redirect::to("/subject/index");
        }
        $subject = SubjectModule::getSubjectById($id);
        if(empty($subject)) {
            return \Redirect::to('/subject/index');
        }

        $this->data = compact('subject');
        return $this->showView('content.subject-update');
    }

    /**
     * 更新一个活动专题请求
     *
     * @return string
     */
    public function postUpdate() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $title = $this->getParam('title', 'required|max:100');
        $content = $this->getParam('content', 'required');
        $startTime = $this->getParam('startTime');
        $endTime = $this->getParam('endTime');
        $status = $this->getParam('status');
        $remark = $this->getParam('remark');
        $fields = $this->getParam('fields');

        $this->outputErrorIfExist();

        $result = SubjectModule::updateSubject($id, $title, $content, $startTime, $endTime, $status, $remark, $fields);
        $this->outputErrorIfFail($result);
        return $this->outputContent($result);
    }

    /**
     * 删除一个活动专题
     *
     * @return string
     */
    public function postDelete() {
        $this->outputUserNotLogin();

        $id = $this->getParam('id', 'required|numeric');
        $this->outputErrorIfExist();

        $result = SubjectModule::deleteSubject($id);
        $this->outputErrorIfFail($result);
        return $this->outputContent($result);
    }

    /**
     * 获取活动的报名人员
     *
     * @param int $subjectId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getParticipator($subjectId = 0) {
        if(! $this->isLogin()) {
            return \Redirect::to("/login");
        }
        if(! $subjectId) {
            return \Redirect::to("/subject/index");
        }
        $subject = SubjectModule::getSubjectById($subjectId);
        if(empty($subject)) {
            return \Redirect::to('/subject/index');
        }
        $participators = JoinSubjectModule::getJoinSubjectsBySubjectId($subjectId);
        $this->data = compact('subject', 'participators');
        return $this->showView('content.subject-participator');
    }
}