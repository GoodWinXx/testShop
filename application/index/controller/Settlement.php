<?php
/**
 * Created by PhpStorm.
 * User: chenweihua
 * Date: 2019/11/26
 * Time: 2:11 PM
 */

namespace app\index\controller;


use think\Db;
use app\index\model\Order;

class Settlement extends BaseController
{

    public function account($address_id,$buynow)
    {
        if (empty($address_id)) {
            return json(['code'=>0,'msg'=>'请填写收货地址']);
        }
        $model = new Order;
//        $buynow = 0;
        $order_id = $model->createOrder($address_id,$buynow);
        if ($order_id) {
            return json(['code'=>1,'data'=>['order_id'=>$order_id]]);
        } else {
            return json(['code'=>0,'msg'=>'订单创建失败']);
        }
//        $data =['status' => 1];
//        $buynow = input('buynow',0);
//        $data['buynow'] = (int)$buynow;
//        $result = Db::name('shop_cart')->where($data)->select();
//        foreach ($result as $key=>$value){
//            $obj = Db::name('product')->where('id',$value['product_id'])->find();
//            $result[$key]['describe'] = $obj['describe'];
//            $result[$key]['price'] = $obj['price'];
//            $result[$key]['common_price'] = $obj['common_price'];
//        }
//        $total = 0;
//
//        foreach ($result as $k=>$v){
//            $total = $total + $v['price'];
//        }
//        $order = [
//            'uid' => 1,
//            'trade_sn' => date('YmdHis').substr(microtime(), 2, 5) . mt_rand(10000,99999),
//            'total_price' => $total,
//            'datas' => date('Y-m-d H:i:s',time()),
//            'express_company' => '顺丰',
//            'express' => '快递',
//            'status' => 1,
//        ];
//        Db::name('order')->insert($order);
//        $order_result = Db::name('order')->where('trade_sn',$order['trade_sn'])->find();
//        $order_middle = [
//            'order_id' => $order_result['id'],
//            'trade_sn' => $order['trade_sn'],
//            'product_id' => ,
//        ];
//        $this->assign('total',$total);
//        $this->assign('result',$result);
//        file_put_contents('runtime.txt',var_export($data,true),FILE_APPEND);
//        return $this->fetch();
    }

    public function pay()
    {
        $order_id = input('order_id');
        //查询订单表 order
        $order = Db::name('order')->where('id',$order_id)->find();
        $total = Db::name('order_product')->where('order_id',$order_id)->find();
        $this->assign('total',$total['total_price']);
        return $this->fetch();
    }

}