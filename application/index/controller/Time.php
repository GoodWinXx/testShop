<?php
/**
 * Created by PhpStorm.
 * User: chenweihua
 * Date: 2019/12/9
 * Time: 2:44 PM
 */

namespace app\index\controller;


use think\Db;

class Time extends BaseController
{
    public function time()
    {
        $data = Db::name('product')->where('is_time=1')->where('is_on_sale=1')->select();
        $this->assign('data',$data);
        return  $this->fetch();
    }
}