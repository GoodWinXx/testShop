<?php
/**
 * Created by PhpStorm.
 * User: chenweihua
 * Date: 2019/10/5
 * Time: 1:33 AM
 */

namespace app\admin\controller;


use think\Controller;
use think\Db;

class Cate extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function lists(){
        $lists = Db::name('cate')->paginate(15)->toArray();
        foreach ($lists['data'] as $k => $v){
            $lists['data'][$k]['level'] = "第".$v['level']."级分类";
        } 
        return $this->listsData($lists['data'],$lists['total']);
    }

    public function listsData($data, $total)
    {
        return json(['code' => 0, 'data' => $data, 'count' => $total]);
    }

    public function Cate()
    {
        $data = Db::name('cate')->select();
        foreach ($data as $k => $v){
            $data[$k]['cate_name'] = str_repeat("  ",$v['level']).$v['cate_name'];
        }
        $this->assign("data",$data);
        return $this->fetch();
    }

    public function create()
    {
        $parents = Db::name('cate')->select();
        foreach ($parents as $k => $v){
            $parents[$k]['cate_name'] = str_repeat("--",$v['level']).$v['cate_name'];
        }
        $this->assign('parents',$parents);
        if (request()->isPost()){
            $data = [
              'cate_name' => input('cate_name'),
              'pid' => input('pid'),
            ];
            if(Db::name('cate')->insert($data)){
                $result = Db::name('cate')->where('id',$data['pid'])->find();
                $obj = Db::name('cate')->where('cate_name',$data['cate_name'])->find();
                if ($data['pid'] == 0) {
                    $path = [
                        'path' => $data['pid'].",".$obj['id'],
                        'level' => 1,
                    ];
            }else{
                    $path = [
                        'path' => $path = $result['path'].",".$obj['id'],
                        'level' => $result['level']+1,
                    ];
                }
                if (Db::name('cate')->where("id",$obj['id'])->update($path)){
                    echo '<script>alert("添加成功")</script>';
                    return $this->success('success','index');
                }else{
                    return $this->error('error','index');
                }
            }
        }
        return $this->fetch();
    }

    public function edit()
    {
        $id = input('id');
        $cate = Db::name('cate')->where('id',$id)->find();
        $this->assign('cate',$cate);
        if (request()->isPost()) {
            $data = [
                'id' => input('id'),
                'cate_name' => input('cate_name'),
                'pid' => input('pid'),
            ];
            if (Db::name('cate')->where('id',$id)->update($data)){
                return $this->success('success!','index');
            }else{
                return $this->error('error!','index');
            }
        }
        return $this->fetch();
    }
}