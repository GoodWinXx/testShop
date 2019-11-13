<?php
/**
 * Created by PhpStorm.
 * User: chenweihua
 * Date: 2019/11/6
 * Time: 1:39 AM
 */

namespace app\admin\validate;


use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        'admin_name'  =>  'require|max:25',
//        'email' =>  'email',
    ];

    protected $message  =   [
        'admin_name.require' => '用户名必须',
        'admin_name.max'     => '用户名最多不能超过25个字符',
//        'email'        => '邮箱格式错误',
    ];
}