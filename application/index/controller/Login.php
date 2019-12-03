<?php
/**
 * Created by PhpStorm.
 * User: chenweihua
 * Date: 2019/11/21
 * Time: 1:28 PM
 */

namespace app\index\controller;


use think\Controller;
use think\Db;

class Login extends Controller
{
    public function login()
    {
        if (request()->isPost()) {
                $user = Db::name('users')->where('username','=',input('username'))->find();
                if ($user['password'] == md5(input('password'))){
                    session('user',$user);
                    return $this->success('登陆成功!','index/index');
                }elseif (md5($user['password']) != md5(input('password'))){
                    return $this->error('账号或密码错误','login');
                }

        }
        return $this->fetch();
    }

    public function logout()
    {
        //销毁session
        session("user", NULL);
        //跳转页面
        $this->redirect('login/login');
    }
}