<?php namespace App\Module;
use App\Model\Product;

/**
 * 产品module层
 *
 * @package App\Module
 */
class ProductModule extends BaseModule {
    /**
     * 添加一个产品介绍
     *
     * @param $name
     * @param $picture
     * @param $type
     * @param $describe
     * @return array
     */
    public static function addProduct($name, $picture, $type, $describe) {
        $product = new Product();
        $product->name = $name;
        $product->picture = $picture;
        $product->type = $type;
        $product->describe = $describe;

        $product->save();
        return array('status' => true, 'id' => $product->id);
    }

    /**
     * 删除一个产品介绍
     *
     * @param $id
     * @return array
     */
    public static function deleteProduct($id) {
        Product::destroy($id);
        return array('status' => true);
    }

    /**
     * 更新一个产品介绍
     *
     * @param $id
     * @param $name
     * @param $picture
     * @param $type
     * @param $describe
     * @return array
     */
    public static function updateProduct($id, $name, $picture, $type, $describe) {
        $product = Product::find($id);
        $product->name = $name;
        $product->picture = $picture;
        $product->type = $type;
        $product->describe = $describe;
        $product->update();

        return array('status' => true);
    }

    /**
     * 按条件获取产品介绍记录
     *
     * @param int $offset
     * @param int $limit
     * @return $this|Product|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder|static|static[]
     */
    public static function getProducts($offset = 0, $limit = 0) {
        $product = new Product();
        $product = $product->leftJoin('card_type', 'card_type.id', '=', 'product.type');
        if($limit > 0) {
            $product = $product->offset($offset)->limit($limit);
        }
        $product = $product->selectRaw('product.*, card_type.name as typeName');
        $product = $product->get();
        return $product;
    }

    /**
     * 按条件统计产品介绍
     *
     * @return Product|\Illuminate\Database\Eloquent\Builder|int|static
     */
    public static function countProducts() {
        $product = Product::count();
        return $product;
    }

    /**
     * 按主键获取产品介绍
     *
     * @param $id
     * @return \Illuminate\Support\Collection|null|static
     */
    public static function getProductById($id) {
        return Product::find($id);
    }
}