<?php
namespace app\wx\controller;
use think\Controller;
class  Index extends Controller{
    public function choserule(){
        $info=db("choserule")->find();
        //print_r($info);exit;
        $this->assign('info',$info);
        return $this->fetch('./templates/choserule.html');
    }
    public function do_chose()
    {
        $teacher=input('post.teacher');
        $student=input('post.student');
        $data['teacher']=isset($teacher)?$teacher:0;
        $data['student']=isset($student)?$student:0;
        $info=db('choserule')->where('id=1')->update($data);
        if($info!==false)
        {
            $this->success('设置成功',url('index/choserule'),'',1);
        }
    }
}
?>