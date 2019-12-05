<?php
/**
 * Created by PhpStorm.
 * User: chenweihua
 * Date: 2019/11/26
 * Time: 2:11 PM
 */

namespace app\index\controller;


use think\Db;
use think\Session;

class Settlement extends BaseController
{
    public function settlement()
    {
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
        return $this->fetch();
    }
}