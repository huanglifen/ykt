<?php namespace App\Module;

use App\Model\ContentType;

/**
 * 内容类型module层
 *
 * @package App\Module
 */
class ContentTypeModule extends BaseModule {

    /**
     * 新增一个内容类型
     *
     * @param $number
     * @param $name
     * @param $sort
     * @return array
     */
    public static function addContentType($number, $name, $sort) {
        $contentType = new ContentType();
        $contentType->number = $number;
        $contentType->name = $name;
        $contentType->sort = $sort;
        $contentType->save();
        return array('status' => true, 'id' => $contentType->id);
    }

    /**
     *  删除一个内容类型
     *
     * @param $id
     * @return array
     */
    public static function deleteContentType($id) {
        $result = array('status' => false, 'name' => '');
        $contentType = self::getContentTypeById($id);
        if(! empty($contentType)) {
            $result = array('status' => true, 'name' => $contentType->name);
        }

        ContentType::destroy($id);
        return $result;
    }

    /**
     * 更新一个内容类型
     *
     * @param $id
     * @param $number
     * @param $name
     * @param $sort
     * @return array
     */
    public static function updateContentType($id, $number, $name, $sort) {
        $contentType = ContentType::find($id);
        if(empty($contentType)) {
            return array('status' => true, 'msg' => 'error_id_not_exist');
        }

        $contentType->number = $number;
        $contentType->name = $name;
        $contentType->sort = $sort;
        $contentType->update();

        return array('status' =>true);
    }

    /**
     * 按条件获取内容类型记录
     *
     * @param string $keyword
     * @param int $limit
     * @param int $offset
     * @param bool $asc
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getContentTypes($keyword = '', $limit = 0, $offset = 0, $asc = true) {
        $contentType = new ContentType();
        if($keyword) {
            $contentType = $contentType->where('name', 'like', "%$keyword%")->orwhere('number', 'like', "%$keyword%");
        }
        if($limit > 0) {
            $contentType = $contentType->limit($limit)->offset($offset);
        }
        if($asc) {
            $contentType = $contentType->orderBy('sort');
        }
        return $contentType->get();
    }

    /**
     * 按条件统计内容类型
     *
     * @param string $keyword
     * @return int
     */
    public static function countContentTypes($keyword = '') {
        $contentType = new ContentType();
        if($keyword) {
            $contentType = $contentType->where('name', 'like', "%$keyword%");
        }
        return $contentType->count();
    }

    /**
     * 按主键获取内容类型
     *
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public static function getContentTypeById($id) {
        return ContentType::find($id);
    }
}