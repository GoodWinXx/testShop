<?php
/**
 * Created by PhpStorm.
 * User: chenweihua
 * Date: 2019/12/18
 * Time: 5:22 PM
 */

namespace app\index\controller;


use think\Controller;

class Test extends Controller
{
    public function test()
    {
        return $this->fetch();
    }

    public function test1()
    {
        return $this->fetch();
    }

    public function test2()
    {
        return $this->fetch();
    }

    public function test3()
    {
        return $this->fetch();
    }
}