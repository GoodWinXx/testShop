<?php
/**
 * Created by PhpStorm.
 * User: chenweihua
 * Date: 2019/11/21
 * Time: 2:22 PM
 */

namespace app\index\controller;


use think\Controller;
use think\Db;

class Commodity extends BaseController
{
    public function initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
    }

    public function commodity()
    {
        $data = Db::name('product')->where('is_on_sale=1')->select();
//        dump($data);exit;
        $this->assign('data',$data);
        return $this->fetch();
    }
}