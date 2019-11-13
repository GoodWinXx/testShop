<?php
/**
 * Created by PhpStorm.
 * User: chenweihua
 * Date: 2019/11/6
 * Time: 5:39 PM
 */

namespace app\admin\controller;

use think\auth;
use think\Controller;
use think\Db;

class User extends BaseController
{
    public function initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
    }

    public function lists(){
        $lists = Db::name('auth_rule')->paginate(15)->toArray();
        $this->assign('lists',$lists);
        return $this->listsData($lists['data'],$lists['total']);
    }

    public function auth_group_lists(){
        $lists = Db::name('auth_group')->paginate(15)->toArray();
        $this->assign('lists',$lists);
        return $this->listsData($lists['data'],$lists['total']);
    }

    public function listsData($data, $total)
    {
        return json(['code' => 0, 'data' => $data, 'count' => $total]);
    }

    public function auth_rule()
    {
        return $this->fetch();
    }

    public function create_auth_rule()
    {
        if (request()->isPost()){
            $data = [
                'name' => input('name'),
                'title' => input('title'),
            ];
            if (Db::name('auth_rule')->insert($data)){
                return $this->success('Success!','auth_rule');
            }else{
                return $this->error('Error!','auth_rule');
            }
        }
        return $this->fetch();
    }

    public function del()
    {
        $id = input('id');
        Db::name('auth_rule')->where('id',$id)->delete();
    }

    public function auth_group()
    {
        return $this->fetch();
    }

    public function create_auth_group()
    {
        $data = Db::name('auth_rule')->select();
//        dump($data);exit;
        $this->assign('data',$data);
        if (request()->isPost()){
            $result =[
                'title' => input('title'),
                'rules' => input('like'),
            ];
            if (Db::name('auth_group')->insert($result)){
                return $this->success('Success!','auth_group');
            }else{
                return $this->error('Error!','auth_group');
            }
        }
        return $this->fetch();
    }

    public function del_auth_group()
    {
        $id = input('id');
        Db::name('auth_group')->where('id',$id)->delete();
    }
}