<?php
/**
 * Created by PhpStorm.
 * User: eeatem
 * Date: 2019-05-10
 * Time: 02:03
 */

namespace app\models;

use core\base\Model;

class CartModel extends Model
{
    // 选择购物车表
    protected $table = 't_cart';

    // 将商品添加到购物车
    public function addGoodToCart($userNameSession,$goodId){
        // 获取用户id
        $userId=(new userFunc())->gainUserId($userNameSession);
        // 判断购物车表中是否有同一用户同一商品，若无则插入数据，若有则更新数量
        $row=(new CartModel())->where(["user_id = '$userId' AND ", "good_id = '$goodId'"])->fetch();
        if($row==false){
            $data['user_id']=$userId;
            $data['good_id']=$goodId;
            $data['good_number']=1;
            $addResult=(new CartModel())->add($data);
        }else{
            $data['good_number']=$row['good_number']+1;
            $addResult=(new CartModel())->where()->update($data);
        }

        return $addResult;
    }

    // 购物车中商品数量加1
    public function increaseGoodNumber($cartId){
        $row=(new CartModel())->where(["id = '$cartId'"])->fetch();
        $number=$row['good_number'];
        $data['good_number']=$number+1;
        $increaseResult=(new CartModel())->where(["id = '$cartId'"])->update($data);

        return $increaseResult;
    }

    // 购物车中商品数量减1
    public function decreaseGoodNumber($cartId){
        $row=(new CartModel())->where(["id = '$cartId'"])->fetch();
        $number=$row['good_number'];
        if($number=='1'){
            $decreaseResult=(new CartModel())->delete($cartId);
        }else {
            $data['good_number'] = $number - 1;
            $decreaseResult      = (new CartModel())->where(["id = '$cartId'"])->update($data);
        }

        return $decreaseResult;
    }
}