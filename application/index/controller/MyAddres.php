<?php
/**
 * Created by PhpStorm.
 * User: chenweihua
 * Date: 2019/12/9
 * Time: 5:13 PM
 */

namespace app\index\controller;


use think\Db;

class MyAddres extends BaseController
{
    public function myAddres()
    {
        $data = Db::name('address')->select();
        foreach ($data as $key=>$value){
            if ($data[$key]['status'] == 1){
                $data[$key]['first'] = "默认地址";
            }else{
                $data[$key]['first'] = "";
            }
        }
        $this->assign('data',$data);
        return $this->fetch();
    }

    public function myEditAddress()
    {
        if (request()->isPost()){
            $data = [
                'name' => input('name'),
                'phone' => input('phone'),
                'province' => input('province'),
                'address' => input('address'),
            ];
            Db::name('address')->insert($data);
        }
        return $this->fetch();
    }
}