<?php namespace App\Module;

use App\Model\Customer;

/**
 * 客户module层
 *
 * @package App\Module
 */
class CustomerModule extends  BaseModule {
    const FROM_TYPE = 0;

    /**
     * 按条件获取客户记录
     * @param int $bind 是否绑定，0 全部，1未绑定，2已绑定
     * @param int $type 类型，-1 全部，0 虚拟卡，1 实体卡
     * @param $keyword
     * @param $offset
     * @param $limit
     * @return array
     */
    public static function getCustomers($bind = 0, $type = -1, $keyword, $offset, $limit) {
        $customer = new Customer();
        $customers =  $customer->getCustomers($bind, $type, $keyword, $offset, $limit, self::FROM_TYPE);
        return self::formatCustomers($customers);
    }

    public static function countCustomers($bind = 0, $type = -1, $keyword) {
        $customer = new Customer();
        return $customer->countCustomers($bind, $type, $keyword, self::FROM_TYPE);
    }

    /**
     * 获取一个用户信息
     *
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public static function getCustomerById($id) {
        $customer = new Customer();
        $customer = $customer->where('customer.id', $id);
        $customer = $customer->leftJoin('card', 'card.id', '=', 'customer.cardid');
        $customer = $customer->selectRaw("customer.id, customer.username, customer.openid, customer.idcard, customer.mobile, customer.address, card.cardno ");
        $customer = $customer->first();
        $customer->cardno = self::encrypt($customer->cardno, "D");
        return $customer;
    }

    /**
     * 解密卡号
     *
     * @param $customers
     * @return mixed
     */
    public static function formatCustomers(&$customers) {
        foreach($customers as &$customer) {
            $customer->cardno = self::encrypt($customer->cardno, "D");
        }
        return $customers;
    }
}