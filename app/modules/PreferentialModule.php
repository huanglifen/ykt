<?php namespace App\Module;

use App\Model\Preferential;

/**
 * 充值、消费优惠module层
 *
 * @package App\Module'
 */
class PreferentialModule extends BaseModule {

    /**
     * 按条件获取优惠记录
     *
     * @param $strategy
     * @param $preferMount
     * @param $source
     * @param $startTime
     * @param $endTime
     * @param $target
     * @param $lowest
     * @param $highest
     * @param $activityName
     * @param $tradeType
     * @param $offset
     * @param $limit
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getPreferential($strategy, $preferMount, $source, $startTime, $endTime, $target, $lowest, $highest, $activityName, $tradeType, $offset, $limit){
        $preferential = new Preferential();
        if($strategy) {
            $preferential = $preferential->where("strategy", $strategy);
        }
        if($preferMount) {
            $preferential = $preferential->where("prefer_mount", $preferMount);
        }
        if($source) {
            $preferential = $preferential->where("source", $source);
        }
        if($startTime) {
            $preferential = $preferential->where("start_time", '>=', $startTime);
        }
        if($endTime) {
            $preferential = $preferential->where("end_time", "<=", $endTime);
        }
        if($target) {
            $preferential = $preferential->where("target", $target);
        }
        if($lowest) {
            $preferential = $preferential->where("lowest_mount", $lowest);
        }
        if($highest) {
            $preferential = $preferential->where("highest_mount", $highest);
        }
        if($activityName) {
            $preferential = $preferential->where("name", 'like', "%$activityName%");
        }
        if($tradeType) {
            $preferential = $preferential->where("trade_type", $tradeType);
        }
        if($limit) {
            $preferential = $preferential->offset($offset)->limit($limit);
        }
        return $preferential->get();
    }

    /**
     * 按条件统计优惠记录
     *
     * @param $strategy
     * @param $preferMount
     * @param $source
     * @param $startTime
     * @param $endTime
     * @param $target
     * @param $lowest
     * @param $highest
     * @param $activityName
     * @param $tradeType
     * @return int
     */
    public static function countPreferential($strategy, $preferMount, $source, $startTime, $endTime, $target, $lowest, $highest, $activityName, $tradeType){
        $preferential = new Preferential();
        if($strategy) {
            $preferential = $preferential->where("strategy", $strategy);
        }
        if($preferMount) {
            $preferential = $preferential->where("prefer_mount", $preferMount);
        }
        if($source) {
            $preferential = $preferential->where("source", $source);
        }
        if($startTime) {
            $preferential = $preferential->where("start_time", '>=', $startTime);
        }
        if($endTime) {
            $preferential = $preferential->where("end_time", "<=", $endTime);
        }
        if($target) {
            $preferential = $preferential->where("target", $target);
        }
        if($lowest) {
            $preferential = $preferential->where("lowest_mount", $lowest);
        }
        if($highest) {
            $preferential = $preferential->where("highest_mount", $highest);
        }
        if($activityName) {
            $preferential = $preferential->where("name", 'like', "%$activityName%");
        }
        if($tradeType) {
            $preferential = $preferential->where("trade_type", $tradeType);
        }
        return $preferential->count();
    }
}