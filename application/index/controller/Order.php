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
    public function order()
    {
        $id = input('id');
        if (isset($id)){
            Db::name('shop_cart')->where('buynow=1')->delete();
            $buy = [
                'uid' => 1,
                'product_id' => $id,
                'number' => 1,
                'status' => 1,
                'buynow' => 1,
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
            $data = Db::name('shop_cart')->where('buynow=1')->find();
            $this->assign('data',$data);
        }else{
            $data = Db::name('shop_cart')->where('status=1')->select();
            foreach ($data as $key=>$value){
                $obj = Db::name('product')->where('id',$value['product_id'])->find();
                $data[$key]['product_name'] = $obj['product_name'];
                $data[$key]['price'] = $obj['price'];
                $data[$key]['common_price'] = $obj['common_price'];
            }
            $total = 0;
            foreach ($data as $k=>$v){
                $total = $total + $v['price'];
            }
            $this->assign('total',$total);
            $this->assign('data',$data);
        }
        return $this->fetch();
    }
}