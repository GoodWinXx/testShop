<?php
/**
 * Created by PhpStorm.
 * User: chenweihua
 * Date: 2019/12/9
 * Time: 4:43 PM
 */

namespace app\index\controller;


class MyOrder extends BaseController
{
    public function myOrder()
    {
        return $this->fetch();
    }
}