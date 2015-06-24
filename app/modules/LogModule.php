<?php  namespace App\Module;

use App\Model\Log;
use Illuminate\Support\Facades\Session;

/**
 * 日志module层
 *
 * Class MenuModule
 * @package App\Module
 */
class LogModule extends BaseModule{
    const RESULT_SUCCESS = 1;
    const RESULT_FAIL = 2;
    const TYPE_ADD = 1;
    const TYPE_DEL = 2;
    const TYPE_UPDATE = 3;
    const TYPE_GET = 4;

    /**
     * 获取日志
     *
     * @param string $userId
     * @param string $begin
     * @param string $end
     * @param int $offset
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getLogs($userId = '', $begin = '', $end = '', $offset = 0, $limit = self::NUM_PER_PAGE) {
        $logs = new Log();
        $logs = $logs->getLogs($userId, $begin, $end, $offset, $limit);
        return $logs;
    }

    /**
     * 统计日志
     *
     * @param string $userId
     * @param string $begin
     * @param string $end
     * @return int
     */
    public static function countLogs($userId = '', $begin = '', $end = '') {
        $logs = new Log();
        if($userId) {
            $logs->where('user_id', $userId);
        }
        if($begin) {
            $logs->where('time', '<=', $begin);
        }
        if($end) {
            $logs->where('time', '>=', $end);
        }
        return $logs->count();
    }

    /**
     * 添加日志
     *
     * @param $content
     * @param $type
     * @param $result
     * @return bool
     */
    public static function log($content = '', $type = self::TYPE_GET, $result = self::RESULT_SUCCESS) {
        $userId = Session::get("user_id");
        $ip = self::current_url();

        $log = new Log();
        $log->user_id = $userId;
        $log->ip = $ip;
        $log->content = $content;
        $log->type = $type;
        $log->time = date("Y-m-d H:i:s", time());
        $log->result = $result;
        $log->save();
        return true;
    }


}