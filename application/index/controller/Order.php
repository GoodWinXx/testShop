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
        $data = Db::name('product')->where('id',$id)->find();
        $this->assign('data',$data);
        return $this->fetch();
    }
}