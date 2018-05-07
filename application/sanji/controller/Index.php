<?php
    namespace app\sanji\controller;
    use think\Controller;
    use think\Db;
    class Index extends Controller{
            public function index(){
               $list=Db::connect('mysql://root:root@127.0.0.1:3306/user#utf8')->name('region')->where('parent_id=1')->select();
               //echo"<pre>";
               //print_r($list);
               $this->assign('plist',$list);
                return $this->fetch();
            }
            public function city(){
                $rid=input('post.rid');
                $list=Db::connect('mysql://root:root@127.0.0.1:3306/user#utf8')->name('region')->where('parent_id='.$rid)->select();
                return json($list);


            }
            public  function yemian(){
                return "123123";
            }
    }
?>