<?php
/**
 * Created by PhpStorm.
 * User: chenweihua
 * Date: 2019/11/13
 * Time: 1:01 AM
 */

namespace app\admin\controller;




use \org\Auth;
use think\Controller;
use think\Db;

class BaseController extends Controller
{
    public function _initialize()
    {
        $uid = session('user')['id'];
        if (empty($uid)){
            return $this->error('您还未登陆','http://c.shop.com/index.php/admin/login/login');
        }
        $Auth = new Auth();
        $url = request()->module().'/'.request()->controller().'/'.request()->action();
        $rule_result = Db::name('auth_rule')->where('name','=',$url)->find();
            if ($rule_result && !$Auth->check($url,session('user')['id'])){
                echo '<script>alert("没有权限");
                    location.href="http://c.shop.com/index.php/admin/welcome/welcome";</script>';
            }
    }
}