<?php namespace App\Module;

use App\Model\Content;

/**
 * 内容module层
 *
 * @package App\Module
 */
class ContentModule extends BaseModule {
    const CATEGORY_HELP = 1; //帮助类型
    const CATEGORY_NEWS = 2; //新闻类型
    const COMPANY_BRIEF = 1; //公司简介类型，不能删除
    /**
     * 添加一个内容
     *
     * @param $title 标题
     * @param $brief 简介
     * @param $context 内容
     * @param $display 是否显示
     * @param $source 新闻来源
     * @param $author 编辑人
     * @param $type category为1时，对应content_type表里面的类型，category为2时，1为首页，2为旅游 3为ETC
     * @param $startTime
     * @param $endTime
     * @param $category 大分类，1为帮助， 2为新闻公告
     * @return array
     */
    public static function addContent($title, $brief, $context, $display, $source, $author, $type, $startTime, $endTime,$sort, $category) {
        $content = new Content();
        $content->title = $title;
        $content->brief = $brief;
        $content->content = $context;
        $content->display = $display;
        $content->source = $source;
        $content->author = $author;
        $content->type = $type;
        $content->start_time = $startTime;
        $content->end_time = $endTime;
        $content->category = $category;
        $content->sort = $sort;
        $content->save();
        return array('status' => true, 'id' => $content->id);
    }

    /**
     * 删除一个内容
     *
     * @param $id
     * @return array
     */
    public static function deleteContent($id) {
        $content = Content::find($id);
        if(empty($content)) {
            return array('status' => false, 'id' => 'error_id_not_exist');
        }
        Content::destroy($id);
        return array('status' => true);
    }

    /**
     * 更新一个内容
     *
     * @param $id
     * @param $title 标题
     * @param $brief 简介
     * @param $context 内容
     * @param $display 是否显示
     * @param $source 新闻来源
     * @param $author 编辑人
     * @param $type category为1时，对应content_type表里面的类型，category为2时，1为首页，2为旅游 3为ETC
     * @param $startTime
     * @param $endTime
     * @param $category 大分类，1为帮助， 2为新闻公告
     * @return array
     */
    public static function updateContent($id, $title, $brief, $context, $display, $source, $author, $type, $startTime, $endTime, $category) {
        $content = Content::find($id);
        if(empty($content)) {
            return array('status' => false, 'msg' => 'error_id_not_exist');
        }
        $content->title = $title;
        $content->brief = $brief;
        $content->content = $context;
        $content->display = $display;
        $content->source = $source;
        $content->author = $author;
        $content->type = $type;
        $content->start_time = $startTime;
        $content->end_time = $endTime;
        $content->category = $category;
        $content->save();

        return array('status' => true, 'id' => $content->id);
    }

    /**
     * 按条件获取内容
     *
     * @param $title
     * @param $type
     * @param $startTime
     * @param $endTime
     * @param $offset
     * @param $limit
     * @param int $category
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getContent($title, $type, $startTime, $endTime, $offset, $limit, $category=self::CATEGORY_HELP) {
        $content = new Content();
        if($category == self::CATEGORY_HELP) {
            $content = $content->leftJoin('content_type', 'content_type.id', '=', 'content.type');
        }
        if($title) {
            $content = $content->where('title', 'like', "%$title%");
        }
        $content = $content->where('category', $category);
        if($type) {
            $content = $content->where('type', $type);
        }
        if($startTime) {
            $content = $content->where('start_time', '>=', $startTime);
        }
        if($endTime) {
            $content = $content->where('end_time', '<=', $endTime);
        }
        if($limit > 0) {
            $content = $content->offset($offset)->limit($limit);
        }
        if($category == self::CATEGORY_HELP) {
            $content = $content->selectRaw("content.*, content_type.name as typename");
        }
        return $content->get();
    }

    /**
     * 按条件统计内容数
     *
     * @param $title
     * @param $type
     * @param $startTime
     * @param $endTime
     * @param int $category
     * @return int
     */
    public static function countContent($title, $type, $startTime, $endTime, $category=self::CATEGORY_HELP) {
        $content = new Content();
        if($title) {
            $content = $content->where('title', 'like', "%$title%");
        }
        $content = $content->where('category', $category);
        if($type) {
            $content = $content->where('type', $type)->where('category', $category);
        }
        if($startTime) {
            $content = $content->where('start_time', '>=', $startTime);
        }
        if($endTime) {
            $content = $content->where('end_time', '<=', $endTime);
        }
        $content = $content->count();
        return $content;
    }

    /**
     * 按主键查询内容
     *
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public static function getContentById($id) {
        return Content::find($id);
    }
}