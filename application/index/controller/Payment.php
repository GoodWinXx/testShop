<?php
/**
 * Created by PhpStorm.
 * User: chenweihua
 * Date: 2019/12/25
 * Time: 3:17 PM
 */

namespace app\index\controller;


use think\Db;

class Payment extends BaseController
{
    public function payment()
    {
        $order = Db::name('order')->where('pay_status','=',0)->column('id');
        $product_id = Db::name('order_product')->where('order_id','in',$order)->column('product_id');
//        dump($product_id);exit;
        $product = Db::name('product')->where('id','in',$product_id)->select();
        $this->assign('product',$product);
        return $this->fetch();
    }
}