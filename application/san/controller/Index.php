<?php
namespace app\san\controller;

use think\Controller;

class Index extends Controller
{

    public function index()
    {
		$db=db('region');
        $parent_id['parent_id'] = 1;
        $region=$db->where($parent_id)->select();
        $this->assign('region',$region);
        return $this->fetch();
    }
    public function pro(){
        $parent_id['parent_id'] = input('post.pro_id');
        $region = db('region')->where($parent_id)->select();
        $data = '<option>--请选择市区--</option>';
        foreach($region as $key=>$v){
            $data.= "<option value='{$v['id']}'>{$v['region_name']}</option>";
        }
        return json($data);
    }
    public function area(){
        $parent_id['parent_id'] = input('post.pro_id');
        $region = db('region')->where($parent_id)->select();
        $data = '<option>--请选择市区--</option>';
        foreach($region as $key=>$v){
            $data.= "<option value='{$v['id']}'>{$v['region_name']}</option>";
        }
        return json($data);
    }
}
