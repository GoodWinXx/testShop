<?php
/**
 * Created by PhpStorm.
 * User: chenweihua
 * Date: 2019/11/4
 * Time: 5:21 PM
 */

namespace app\admin\controller;


use think\captcha\Captcha;
use think\Controller;
use think\Db;

class Login extends Controller
{

    public function login()
    {
        if (request()->isPost()) {
            $data = $this->validate(
                [
                    'admin_name' => input('admin_name'),
                ],
                'app\admin\validate\Admin');
            if (true !== $data) {
                // 验证失败 输出错误信息
                dump($data);exit;
            }else{
                $user = Db::name('admin_user')->where('admin_name','=',input('admin_name'))->find();
                if ($user['password'] == md5(input('password'))){
                    session('user',$user);
                    return $this->success('登陆成功!','admin/index');
                }elseif (md5($user['password']) != md5(input('password'))){
                    return $this->error('账号或密码错误','login');
                }
            }
        }
        return $this->fetch();
    }
}