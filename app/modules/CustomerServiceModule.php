<?php namespace App\Module;

use App\Model\CustomerService;

/**
 * 客服module层
 *
 * @package App\Module
 */
class CustomerServiceModule extends BaseModule {

    /**
     * 添加一个客服
     *
     * @param $name
     * @param $qq
     * @param $cityId
     * @param $display
     * @return array
     */
    public static function addCustomerService($name, $qq, $cityId, $display) {
        $customerService = new CustomerService();
        $customerService->name = $name;
        $customerService->qq = $qq;
        $customerService->city_id = $cityId;
        $customerService->display = $display;

        $customerService->save();
        return array('status' => true, 'id' => $customerService->id);
    }

    /**
     * 删除一个客服
     *
     * @param $id
     * @return array
     */
    public static function deleteCustomerService($id) {
        $customerService = CustomerService::find($id);
        if(empty($customerService)) {
            return array('status' => true, 'msg' => 'error_id_not_exist');
        }
        CustomerService::destroy($id);
        return array('status' => true);
    }

    /**
     * 更新一个客服信息
     *
     * @param $id
     * @param $name
     * @param $qq
     * @param $cityId
     * @param $display
     * @return array
     */
    public static function updateCustomerService($id, $name, $qq, $cityId, $display) {
        $customerService = CustomerService::find($id);
        if(empty($customerService)) {
            return array('status' => false, 'msg' => 'error_id_not_exist');
        }
        $customerService->name = $name;
        $customerService->qq = $qq;
        $customerService->city_id = $cityId;
        $customerService->display = $display;

        $customerService->save();
        return array('status' => true);
    }

    /**
     * 按分页获取客服记录
     *
     * @param $name
     * @param int $offset
     * @param int $limit
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getCustomerServices($name, $offset = 0, $limit = 0) {
        $customerService = new CustomerService();
        $customerService = $customerService->leftJoin('area', 'area.id', '=', 'customer_service.city_id');
        if($name) {
            $customerService = $customerService->where('name', 'like', "%$name%");
        }
        if($limit) {
            $customerService = $customerService->offset($offset)->limit($limit);
        }
        $customerService = $customerService->selectRaw('customer_service.*, area.name as cityName');
        return $customerService->get();
    }

    /**
     * 按条件统计客服记录
     *
     * @param $name
     * @return int
     */
    public static function countCustomerServices($name) {
        $customerService = new CustomerService();
        if($name) {
            $customerService = $customerService->where('name', 'like', "%$name%");
        }
        return $customerService->count();
    }

    public static function getCustomerServiceById($id) {
        return CustomerService::find($id);
    }
}