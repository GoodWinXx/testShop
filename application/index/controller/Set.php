<?php
/**
 * Created by PhpStorm.
 * User: chenweihua
 * Date: 2019/11/26
 * Time: 2:26 PM
 */

namespace app\index\controller;


class Set extends BaseController
{
    public function set()
    {
        return $this->fetch();
    }
}