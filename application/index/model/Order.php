<?php
/**
 * Created by PhpStorm.
 * User: chenweihua
 * Date: 2019/12/22
 * Time: 5:15 PM
 */

namespace app\index\model;

use think\Model;
use think\Db;

class Order  extends Model
{

    public  function  createOrder($address_id,$buynow)
    {
        //查询购物车里面status=1,buynow=$buynow  => $products
        $data = ['status' => 1];
        $data['buynow'] = $buynow;
        $products = Db::name('shop_cart')->where($data)->select();
//        dump($products);
        $total_price = 0;
        foreach ($products as $key=>$val) {
            $total_price += $val['price']*$val['number'];
        }
//        dump($productId);
        //根据address_id 获取用户收货地址
//        $address = Db::name('address')->where('id',$address_id)->find();
//        dump($address);
        //插入订单主表，返回订单id
        $order = [
            'uid' => 1,
            'trade_sn' => date('YmdHis').substr(microtime(), 2, 5) . mt_rand(10000,99999),
            'total_price' => $total_price,
            'create_time' => date('Y-m-d H:i:s'),
            'express_company' => '顺丰',
            'express' => '快递',
            'address_id' => $address_id,
            'pay_status' => 0,
            'status' => 1,
        ];
        if (Db::name('order')->insert($order)){
            $order_result = Db::name('order')->where('trade_sn',$order['trade_sn'])->find();
            $order_id=$order_result['id'];
            //插入订单商品表，商品名称，单价，数量，订单id，用户id
            foreach ($products as $key=>$val){
                $orderProduct = [
                    'order_id' => $order_id,
                    'product_id' => $val['product_id'],
                    'uid' => 1,
                    'status' =>1,
                    'total_price' => $total_price,
                    'number' => $val['number'],
                ];
                Db::name('order_product')->insert($orderProduct);
            }
            //插入订单操作日志表，订单创建成功
            $orderLog = [
                'order_id' => $order_id,
                'order_status' => 0,
            ];
            Db::name('order_log')->insert($orderLog);
        }else{
            return json(['code'=>0,'msg'=>'订单创建失败']);
        }

        return $order_id;
    }
}