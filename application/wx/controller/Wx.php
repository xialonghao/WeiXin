<?php
namespace  app\wx\controller;
use  think\Controller;

class Wx extends Controller
{
    public function setopenid(){
        $code=input('code');
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=wxc56e7545dcdc9c5e&secret=d50db597199279d323f6d666b096aa2e&js_code=".$code ."&grant_type=authorization_code";
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
            }
    public function getopenids()
    {
        //echo "123";exit;
        $code=input('code');
        // $code='021TLdwr1digjq0z70vr1hlUvr1TLdwf';
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=wxc56e7545dcdc9c5e&secret=83bfc4ea3a395a2b605460364ea9dd76&js_code=" . $code . "&grant_type=authorization_code";
        //初始化
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

    public function getopenid()
    {
        //echo "123";exit;
        $code=input('code');
        // $code='021TLdwr1digjq0z70vr1hlUvr1TLdwf';
        $id=input('id');
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=wxc56e7545dcdc9c5e&secret=83bfc4ea3a395a2b605460364ea9dd76&js_code=" . $code . "&grant_type=authorization_code";
        //初始化
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        //return $res;
        $result=json_decode($res,true);
        $data['openid']=$result['openid'];
        if($id==1)
        {
            $info=db('teacher')->insert($data);

        }
        else{
            $info=db('users')->insert($data);

        }
        if($info===true)
        {
            return $res;
        }
        else{
            return "";
        }
    }
//    public function getopenid()
//{
//    //echo "123";exit;
//    $code=input('code');
//    $id=input('id');
//    $url = "https://api.weixin.qq.com/sns/jscode2session?appid=wxc56e7545dcdc9c5e&secret=83bfc4ea3a395a2b605460364ea9dd76&js_code=" . $code . "&grant_type=authorization_code";
//    //初始化一个新的会话链接，返回一个cURL句柄，供curl_setopt(), curl_exec()和curl_close() 函数使用。
//    $ch = curl_init();
//    // 设置URL和相应的选项
//    curl_setopt($ch,CURLOPT_URL,$url);
//    //启用时会将头文件的信息作为数据流输出。
//    curl_setopt($ch,CURLOPT_HEADER,0);
//    //在启用CURLOPT_RETURNTRANSFER的时候，返回原生的（Raw）输出。
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
//    //在发起连接前等待的时间，如果设置为0，则无限等待。
//    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
//    // 抓取URL并把它传递给浏览器
//    $res = curl_exec($ch);
//// 关闭cURL资源，并且释放系统资源
//    curl_close($ch);
//    $user_obj = json_decode($res,true);
//    $data['openid']=$user_obj['openid'];
//    if($id==1){
//        $info=db('teacher')->insert($data);
//    }else{
//        $info=db('users')->insert($data);
//    }
//    if($info){
//        return $res;
//    }else{
//        return "";
//    }
//
//    //return json($res);
//}

//    public function choserule()
//    {
//        $info=db('choserule')->find();
//        return json($info);
//    }
    public function rules()
{
    $code=input('code');
    $info=db('teacher')->where("openid='".$code."'")->find();
    if(!empty($info))
    {
        $msg=[
            'flag'=>1,
        ];
    }
    else{
        $infos=db('users')->where("openid='".$code."'")->find();
        if(!empty($infos))
        {
            $msg=[
                'flag'=>2,
            ];
        }
        else{
            $msg=[
                'flag'=>0,
            ];

        }
    }
    return json($msg);
}
    public function choserule(){
        $info=db('choserule')->find();
        return json($info);
    }
    public function select(){
        $code=input('code');
        $id=input('id');
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=wxc56e7545dcdc9c5e&secret=83bfc4ea3a395a2b605460364ea9dd76&js_code=" . $code . "&grant_type=authorization_code";
        //初始化一个新的会话链接，返回一个cURL句柄，供curl_setopt(), curl_exec()和curl_close() 函数使用。
        $ch = curl_init();
        // 设置URL和相应的选项
        curl_setopt($ch,CURLOPT_URL,$url);
        //启用时会将头文件的信息作为数据流输出。
        curl_setopt($ch,CURLOPT_HEADER,0);
        //在启用CURLOPT_RETURNTRANSFER的时候，返回原生的（Raw）输出。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        //在发起连接前等待的时间，如果设置为0，则无限等待。
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        // 抓取URL并把它传递给浏览器
        $res = curl_exec($ch);
        $user_obj = json_decode($res,true);
        $openid = $user_obj['openid'];
        $info=db("teacher")->where("openid='".$openid."'")->find();
        if(!empty($info)){
            $data=[
                'msg'=>1,
            ];
        }else{
            $infos=db("users")->where("openid='".$openid."'")->find();
            if(!empty($infos)){
                $data=[
                    'msg'=>2,
                ];
            }else{
                $data=[
                    'msg'=>0,
                ];
            }
        }
        return json($data);
    }
    public function examine(){
        $openid=input('openid');
        $info=db("teacher")->where("openid='".$openid."'")->find();
        return json($info);
    }
    public function up(){
        $datas=input('datas');
        $output = json_decode($datas,true);
        $openid=input('openid');
        $info=db('teacher')->where("openid='".$openid."'")->update($output);
        return json($info);

    }
    //送老师进学生列表
    public function stulist(){
       // $openid=input('openid');
        $openid=input('openid');
        $page=input('page');
        $info=db("teacher")->where("openid='".$openid."'")->find();
        $infos=db("iclass")->where("tid='".$info['id']."'")->find();
        $num=count(db("users")->where("iclass='".$info['id']."'")->select());
        $yeshu=ceil($num/4);
        if($yeshu<$page){
            $ins=[
                'msg'=>1
            ];
        }else if($page==0){
            $ins=[
                'msg'=>2
            ];
        }else{
            $ins=db("users")->page($page,4)->where("iclass='".$info['id']."'")->select();
        }
        return json($ins);
    }

    //显示学生详细信息的
    public function dosutdent(){
        $openid=input('openid');
        $info=db("users")->where("openid='".$openid."'")->find();

        return json($info);
    }
    //修改学生信息的
    public function upstudent(){
        $datas=input('datas');
        $output = json_decode($datas,true);
        $openid=input('openid');
        $info=db('users')->where("openid='".$openid."'")->update($output);
        return json($info);
    }
    //上传图片
    public function chosephoto(){
            $data=$_FILES['photos'];
            $path='/upload';
//           !file_exists($path)?mkdir($path,0777):'';
            $info=move_uploaded_file($_FILES['photos']['tmp_name'],ROOT_PATH.'upload/tou.jpg');
//            $data['msg']=$info->get_Extension();
            return json($data);
    }
    //从老师查看学生详细些你
    public function chakan(){
       $id = input('id');
       $info=db("users")->where("id='".$id."'")->find();
       return json($info);
    }
    //学生请假
    public function leave(){
        $openid=input("openid");
        $datas=input('datas');
        $output = json_decode($datas,true);
        $info=db('users')->where("openid='".$openid."'")->find();
        $infos=db('leave')->where("sid='".$info['id']."'")->insert($output);
        return josn($infos);
    }
    //学生请假老师同
    public function teacherleave(){
        $openid=input('openid');
        $page=input('page');
        $info=db('teacher')->alias('a')
            ->join('iclass b','a.id = b.tid')
            ->join('users c','c.iclass = b.id')
            ->join('leave d','d.sid = c.id')
            ->where("a.openid='".$openid."'")
            ->select();
        $num=ceil(count($info)/2);
        if($num<$page){
            $info=[
              'msg'=>1,
            ];
        }else if($page==0){
            $info=[
              'msg'=>2
            ];
        }else{
            $info=db('teacher')->alias('a')
                ->join('iclass b','a.id = b.tid')
                ->join('users c','c.iclass = b.id')
                ->join('leave d','d.sid = c.id')
                ->page($page,2)
                ->where("a.openid='".$openid."'")
                ->select();
        }
        return json($info);
//        return json($info);
//        $openid=input('openid');//teacher
//        $info=db("teacher")->where("openid='".$openid."'")->find();
//        $infos=db("iclass")->where("tid='".$info['id']."'")->find();
//        $infost=db("users")->where("iclass='".$infos['id']."'")->find();
//        $infole=db("leave")->where("sid='".$infost['id']."'")->find();
//        return json($infole);



    }
    //周末回家提交到数据库里
    public function Weekend(){
        $openid=input('openid');
        $dataa=input('datas');
        $output = json_decode($dataa,true);
        $output['weeks']=date('W');
        $info=db('users')->where("openid='".$openid."'")->find();
        $infos=db('backhome')->where("sid='".$info['id']."'")->insert($output);
        return json($info);

    }
    public function weekpd(){
        $openid=input('openid');
        $data=date('W');
        $info=db('users')->where("openid='".$openid."'")->find();
        $nums=db('backhome')->where("sid='".$info['id']."'and weeks='".$data."'")->count();
        if($nums>0){
            $datas=[
              'flag'=>1,//有值 提交 不可点
            ];
        }else{
            $datas=[
                'flag'=>0,//无值 撤销 不可点
            ];
        }
            return json($datas);
    }
    //老师同意学生的请假
    public function tealeave(){
        $id=input('id');
        $info=db('leave')->alias('a')->join('users b','a.sid=b.id')->where("b.id='".$id."'")->find();
        return json($info);
    }
    //本班回家统计
    public function weekhome(){
       $openid=input('openid');
       $page=input('page');
        $info=db('teacher')->alias('a')
            ->join('iclass b','a.id = b.tid')
            ->join('users c','c.iclass = b.id')
            ->join('backhome d','d.sid = c.id')
            ->where("a.openid='".$openid."'")
            ->select();
        $num=ceil(count($info)/2);
            if($num<$page){
                $info=[
                    'msg'=>1
                ];
            }else if($page==0){
                $info=[
                    'msg'=>2
                ];
            }else{
                $info=db('teacher')->alias('a')
                    ->join('iclass b','a.id = b.tid')
                    ->join('users c','c.iclass = b.id')
                    ->join('backhome d','d.sid = c.id')
                    ->page($page,2)
                    ->where("a.openid='".$openid."'")
                    ->select();
            }
        return json($info);

    }
    //全部回家统计
    public function allhome(){
        //班级 姓名  出行方式
        //iclass  users  backhome
//        $infos=db("users")->alias('a')
//            ->join('iclass b','a.iclass=b.id')
//            ->join('backhome c','c.sid=a.id')
//            ->select();

//        $db=('backhome')->where("weeks='".$week."")->select();
        $week=date('W');
        $infos=db("backhome")->alias('a')
            ->join('users b','a.sid=b.id')
            ->join('iclass c','b.iclass=c.id')
            ->where("weeks='".$week."'")
            ->select();
        return json($infos);

    }
//本班留校
    public function stayschool()
    {
        $openid=input('openid');
        $info=db('teacher')->alias('a')
            ->join('iclass b','a.id=b.tid')
            ->join('users c','c.iclass=b.id')
            ->join('backhome d','d.sid=c.id','left')
            ->field('c.id,username')
            ->where('a.openid="'.$openid.'" and d.sid is null')
            ->select();
        return json($info);
    }
//全部留校名单
    public function completes()
    {
        $page=input('page');
        $num=6;
        $info=db('wx_teacher')->alias('a')
            ->join('wx_iclass b','a.id=b.tid')
            ->join('wx_users c','c.iclass=b.id')
            ->join('wx_backhome d','d.sid=c.id','left')
            ->field('b.classname,c.username')
            ->where('d.sid is null')
            ->select();
        $nums=ceil(count($info)/$num);
        if($page>0)
        {
            if($nums<$page)
            {
                $result=[
                    'flag'=>1
                ];
            }else{
                $info=db('wx_teacher')->alias('a')
                    ->join('wx_iclass b','a.id=b.tid')
                    ->join('wx_users c','c.iclass=b.id')
                    ->join('wx_backhome d','d.sid=c.id','left')
                    ->field('c.id,b.classname,c.username')
                    ->page($page,$num)
                    ->where('d.sid is null')
                    ->select();
                return json($info);
            }
        }else{
            $result=[
                'flag'=>0
            ];
        }
        return json($result);
    }

//宿舍
    public function sushe(){
        $louhao=input('louhao');
        $info=db()->query("select dorm_id,count(username) as sum,iclass as a from wx_users group by dorm_id");
        for($i=0;$i<=count($info)-1;$i++){
            $info[$i]['louhao']=substr($info[$i]['dorm_id'],0,1);
            $info[$i]['sushe']=substr($info[$i]['dorm_id'],2,3);
            $info[$i]['iclass']=db('iclass')->where("id='".$info[$i]['a']."'")->find()['classname'];
            if($louhao==$info[$i]['louhao']){
                $data[]=$info[$i];
            }
        }
        return json($data);
    }
    //回家确认列表
    public function lookdorm(){
        $openid=input('openid');
        $info=db("teacher")->alias('a')
            ->join('users b','a.id=b.tid')
            ->join('conhome c','b.id=c.contime')
            ->where("openid='".$openid."'")->find();
        return json($info);
    }
    //宿舍
//    public function sushe(){
//        $louhao=input('louhao');
//        $info=db('users')->alias('a')
//            ->join('dorm b','a.dorm_id=b.id')
//            ->join('iclass c','a.iclass=c.id')
//            ->field('b.dorm,group_concat(distinct c.classname) as iclass,count(a.id) as sum,a.dorm_id')
//            ->where("b.block='".$louhao."'")
//            ->group('a.dorm_id')
//            ->select();
//        return json($info);
//    }
//管理员菜单请假记录
    //admin请假列表
    public function admin_leavelist(){
        $page=input('page');
        $num=1;
        $info=db('teacher')->alias('a')
            ->join('iclass b','a.id = b.tid')
            ->join('users c','c.iclass = b.id')
            ->join('leave d','d.sid = c.id')
            ->select();
        $nums=ceil(count($info)/$num);
        if($page>=1){
            if($nums<$page)
            {
                $result=[
                    'flag'=>1
                ];
            }else{
                $info=db('teacher')->alias('a')
                    ->join('iclass b','a.id = b.tid')
                    ->join('users c','c.iclass = b.id')
                    ->join('leave d','d.sid = c.id')
                    ->page($page,$num)
                    ->select();

                return json($info);
            }
        }else{
            $result=[
                'flag'=>0
            ];
        }

        return json($result);
    }
    //管理员周末回家列表
    public function weekhometongji(){
        $data=date('W');
        $info=db('users')->alias('a')
            ->join('iclass c','a.iclass=c.id')
            ->join('backhome b','b.sid=a.id','left')
            //field是需要的字段
            ->field('c.id,c.classname as iclass,count(a.id) as sum')
            ->where("b.weeks='".$data."'")
            ->group('a.iclass')
            ->select();
        return json($info);
    }
    public function adminzmhj(){
        $id=input('id');
        $data=date('W');
        $info=db('users')->alias('a')
            ->join('iclass c','a.iclass=c.id')
            ->join('backhome b','b.sid=a.id','left')
            //field是需要的字段
            ->field('a.username,a.sex,b.tripmode')
            ->where("b.weeks='".$data."'")
            ->select();

        return json($info);

    }
    //周末留校列表
    public function adminlx(){
        $data=date('W');
        //$info = db()->query('select username from wx_users where id not in (select sid from wx_backhome where weeks=46 and is_remoke=0)');
        $info=db('users')->alias('a')
            ->join('iclass c','a.iclass=c.id')
            ->join('backhome b','b.sid=a.id','left')
            ->field('c.id,c.classname as iclass')
            ->where("  b.sid is null")
            ->select();
        return json($info);
    }
    //今年历史记录列表
    public function weekHistory(){
        $arr = [];
        $arr['week'] = date('W',time()).'周';
        $arr[0] = db('wx_backhome')
            ->field('weeks as weekNum')
            ->group('weeks')
            ->order('weeks desc')
            ->select();

        foreach ($arr[0] as &$v){
            $v['weekNum'] .= '周';
        }

        return json($arr);
    }


}
?>