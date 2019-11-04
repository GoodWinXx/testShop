<?php
/**
 * Created by PhpStorm.
 * User: chenweihua
 * Date: 2019/10/30
 * Time: 12:53 AM
 */

namespace app\admin\controller;


use think\Controller;
use think\Db;

class Admin extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function lists(){
        $lists = Db::name('admin')->paginate(15)->toArray();
        $this->assign('lists',$lists);
        return $this->listsData($lists['data'],$lists['total']);
    }

    public function listsData($data, $total)
    {
        return json(['code' => 0, 'data' => $data, 'count' => $total]);
    }

    public function create()
    {
        if (request()->isPost()) {
            $data = [
                'username' => input('username'),
                'password' => md5(input('password')),
                'email' => input('email'),
            ];
//            dump($data);exit;
            if (Db::name('admin')->insert($data)) {
                return $this->success('success!', 'index');
            } else {
                return $this->error('error!', 'index');
            }
            return $this->fetch();
        }
        return $this->fetch();
    }

    public function edit()
    {
        $id = input('id');
        $admin = Db::name('admin')->where('id',$id)->find();
        $this->assign('admin',$admin);
        if (request()->isPost()){
            $data = [
                'id' => $id,
                'username' => input('username'),
                'password' => md5(input('password')),
                'email' => input('email'),
            ];
            if (Db::name('admin')->where('id',$id)->update($data)){
                return $this->success('success!','index');
            }else{
                return $this->error('error!','index');
            }
        }
        return $this->fetch();
    }

    public function del()
    {
        $id = input('id');
        Db::name('admin')->where('id',$id)->delete();
    }
}