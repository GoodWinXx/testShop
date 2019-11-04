<?php
/**
 * Created by PhpStorm.
 * User: chenweihua
 * Date: 2019/10/6
 * Time: 1:03 AM
 */

namespace app\admin\controller;


use think\Controller;
use think\Db;

class Product extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function lists(){
        $lists = Db::name('product')->paginate(15)->toArray();
        $this->assign('lists',$lists);
        return $this->listsData($lists['data'],$lists['total']);
    }

    public function listsData($data, $total)
    {
        return json(['code' => 0, 'data' => $data, 'count' => $total]);
    }

    public function product()
    {
        $result = Db::name('cate')->select();
        foreach ($result as $k => $v){
            $result[$k]['cate_name'] = str_repeat("-",$v['level']).$v['cate_name'];
        }
        //var_dump($result);exit;
        $this->assign("result",$result);
        if (request()->isPost()){
            $data = [
                'product_name' => input("product_name"),
                'Sn' => input("Sn"),
                'amount' => input("amount"),
                'common_price' => input("common_price"),
                'price' => input('price'),
                'describe' => input('describe'),
                'putaway_time' => strtotime(input('putaway_time')),
                'is_hot' => input('is_hot'),
                'cate_id' => input('cate_id'),
                'is_on_sale' => input('is_on_sale'),
            ];
            if (Db::name('product')->insert($data)){
                return $this->success('success','index');
            }else{
                return $this->error('error','index');
            }
        }
        return $this->fetch();
    }

    public function edit()
    {
        $result = Db::name('category')->select();
        foreach ($result as $k => $v){
            $result[$k]['name'] = str_repeat("-",$v['level']).$v['name'];
        }
        $this->assign("result",$result);
        $id = input('id');
        $goods = Db::name('goods')->where('id',$id)->find();
        $this->assign('goods',$goods);
        if (request()->isPost()){
            $data = [
                'id' => $id,
                'goods_name' => input("goods_name"),
                'cat_id' => input("cat_id"),
                'stock' => input("stock"),
                'addtime' => strtotime(input("addtime")),
                'price' => input('price'),
                'goods_desc' => input('goods_desc'),
                'is_on_sale' => input('is_on_sale'),
            ];
            //var_dump($data);exit;
            if (Db::name('goods')->update($data)){
                return $this->success('success','index');
            }else{
                return $this->error('error','index');
            }
        }
        return $this->fetch();
    }
}