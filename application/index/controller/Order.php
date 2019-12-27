<?php
/**
 * Created by PhpStorm.
 * User: chenweihua
 * Date: 2019/11/26
 * Time: 1:59 PM
 */

namespace app\index\controller;


use think\Db;

class Order extends BaseController
{

    public function insertCart()
    {
        //这边只负责插入购物车，返回json数据
        Db::name('shop_cart')->where('buynow=1')->delete();
        if (request()->isPost()){
            $goodsId = input('goodsId');
            $buy = [
                'uid' => '3',
                'product_id' => $goodsId,
                'number' => '1',
                'status' => '0',
                'buynow' => '1',
                'create_time' => time(),
            ];
            if (Db::name('shop_cart')->insert($buy)){
                $response = array(
                    'status' => '1',
                    'msg' => "success",
                    'data' => true,
                );
                return json_encode($response);
            }else{
                $response = array(
                    'status' => '0',
                    'msg' => "fail",
                    'data' => false,
                );
                return json_encode($response);
            }
        }
    }



    public function order()
    {
        $address = Db::name('address')->where('status=1')->find();
        $this->assign('address',$address);
        $data =['status' => 1];
        $buynow = input('buynow',0);
        $data['buynow'] = (int)$buynow;
        $result = Db::name('shop_cart')->where($data)->select();
        foreach ($result as $key=>$value){
            $obj = Db::name('product')->where('id',$value['product_id'])->find();
            $result[$key]['describe'] = $obj['describe'];
            $result[$key]['price'] = $obj['price'];
            $result[$key]['common_price'] = $obj['common_price'];
        }
        $total = 0;
        foreach ($result as $k=>$v){
            $total = $total + $v['price'];
        }
        $this->assign('total',$total);
        $this->assign('result',$result);
        return $this->fetch();
    }

    public function check()
    {
        $id = input('id');
        $status = Db::name('shop_cart')->where("product_id",$id)->find();
        if ($status['status'] == 0){
            Db::name('shop_cart')->where('product_id',$id)->update(['status' => 1]);
        }else{
            Db::name('shop_cart')->where('product_id',$id)->update(['status' => 0]);
        }
    }
}