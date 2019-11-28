<?php
/**
 * Created by PhpStorm.
 * User: chenweihua
 * Date: 2019/11/26
 * Time: 2:11 PM
 */

namespace app\index\controller;


class Settlement extends BaseController
{
    public function settlement()
    {
        return $this->fetch();
    }
}