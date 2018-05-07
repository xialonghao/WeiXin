<?php
    namespace app\wxdy\controller;
    use think\Controller;
    define('Token','dys');
    class Index extends Controller{
        public function robots() {
                //当普通微信用户向公众账号发送消息时，微信服务器将POST消息的XML数据包到开发者填写的URL上，因此消息是以XML格式的数据包发送的。
                $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
                //这个语句直接百度的时候，查到的信息是做安全防御用的：对于PHP，由于simplexml_load_string 函数的XML解析问题出现在libxml库上，所以加载实体前可以调用这样一个函数，所以这一句也应该是考虑到了安全问题。
                libxml_disable_entity_loader(true);
                //3）得到了数据之后，然后我们就是要解析微信服务器发送过来的xml数据包了，这里执行的是：
               //SimpleXMLElement返回xml对象如果调用失败反回false值。
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $ToUserName=$postObj->ToUserName;
                $FromUserName=$postObj->FromUserName;
                $content=$postObj->Content;
                $nowtime=time();
                $MsgType=$postObj->MsgType;
                 $MsgEvent=$postObj->Event;
                $xmltpl="
                    <xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>
              	";

            switch ($MsgType)
            {
                case 'event':
                    $tupian="
                    <xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Image>
                        <MediaId><![CDATA[%s]]></MediaId>
                    </Image>
                    </xml>
              	";
                    if($MsgEvent=='subscribe'){
                        $resultStr = sprintf($xmltpl,$FromUserName,$ToUserName,$nowtime,'text','关注是你有魅力');
                    }elseif($MsgEvent=='CLICK'){
                        $key=$postObj->EventKey;
                        switch ($key){
                            case 'V1001_CONSULT':
                         $resultStr = sprintf($tupian,$FromUserName,$ToUserName,$nowtime,'image','QsMEuy_DGSFbJniD_zj_jZCrIh_7OoC8eYhFdNMbKMg_Ft-4cjmg5nnldlqTEAfQ');
                        }
                    }
                    echo $resultStr;
                    break;
                case 'image':
                    $tupian="
                    <xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Image>
                        <MediaId><![CDATA[%s]]></MediaId>
                    </Image>
                    </xml>
              	";
                    $resultStr = sprintf($tupian,$FromUserName,$ToUserName,$nowtime,'image','hE6hc_zDeNwJwUUMOQZVtIsNDm842HBje3CRJVvejaDyNf-03rKGqFn-hTDPWTMr');
                    echo $resultStr;
                    $data['time']=$nowtime;
                    $data['opid']=$FromUserName;
                    $data['image']=$postObj->PicUrl;
                    $data=db('dy')->insert($data);
                    break;

                case 'voice':

                    $yuyin="
                    <xml><ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Voice><MediaId><![CDATA[%s]]></MediaId></Voice>
                    </xml>
              	";
                    $resultStr = sprintf($yuyin,$FromUserName,$ToUserName,$nowtime,'voice','-yT_tS_IJuR7mq7l6ghLk0K-h5NeSoNOwPUn7tjD3qY1zPyGMMeM0DVCl_1SHpHk');
                    echo $resultStr;
                    $data['voicer']=$postObj->MediaId;
                    $data=db('dy')->insert($data);
                    break;
                case 'video':

                    $shiping="
                    <xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Video>
                          <MediaId><![CDATA[%s]]></MediaId>
                        </Video>
                    </xml>

              	";
                    $resultStr = sprintf($shiping,$FromUserName,$ToUserName,$nowtime,'video','MCOqHuRTrUFRZP2GRZ54cB-Kl09jRNCOYu-JaiVUQbzO0IBLwwWpp16DgwYFA2aI');
                    echo $resultStr;
                    break;
                case 'location':
                    $resultStr = sprintf($xmltpl,$FromUserName,$ToUserName,$nowtime,'text','我不是一个地理位置');
                    echo $resultStr;
                    break;
                case 'link':
                    $resultStr = sprintf($xmltpl,$FromUserName,$ToUserName,$nowtime,'text','我不是一个url地址');
                    echo $resultStr;
                    break;
                case 'text':
                    //智能能给回话
                    $url="http://www.tuling123.com/openapi/api?key=8d79d9ac962346fc8eaadf77c6c67ff4&info=".$content;
                    //把整个文件读入一个字符串中。
                    $replay=file_get_contents($url);
                    //转化位json值
                    $recontent=json_decode($replay);
                    //当前时间
                    $repaycontent=$recontent->text;
                    //sprintf()输出%s
                    $resultStr = sprintf($xmltpl,$FromUserName,$ToUserName,$nowtime,'text',$repaycontent);
                    echo $resultStr;
                    $data['text']=$content;//内容
                    $data['time']=date("Y-m-d H:i",$nowtime);
                    $data['opid']=$FromUserName;//
                    $data['response']=$repaycontent;//回复内
                    $data=db('dy')->insert($data);
                    break;


            }
//            $signature=$_GET["signature"];
//            $timestamp=$_GET["timestamp"];
//            $nonce=$_GET["nonce"];
//            $echostr=$_GET['echostr'];
//            $array=array(Token,$timestamp,$nonce);
//            sort($array,SORT_STRING);
//            $str=implode('',$array);
//            $str=sha1($str);
//            if($str==$signature)
//            {
//                echo $echostr;
//            }
//            else
//            {
//                return false;
//            }


        }
        public function  jiekou(){
            $appid='wx2dcb70b67b8b1b96';
            $appsecret='d807059be1e1b6f9fb7750f1d415a0f2';
            $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret.'';
            //初始化一个新的会话
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = json_decode(curl_exec($ch),true);
            // curl_exec抓取URL并把它传递给浏览器;
            //curl_close($ch)关闭cURL资源，并且释放系统资源
            curl_close($ch);
            $token=$output['access_token'];
            return $token;
        }
        public function shilie(){
            $token = $this->jiekou();
            $data = '{
             "button":[ 
             {      
                  "name":"精彩大智",  
                  "sub_button":[  
                   {      
                       "type":"view",  
                       "name":"荣登榜",
                       "url":"http://www.opjpg.com/TP3/index.php/xlh/index/dz?catid=9"  
                    },  
                    {  
                       "type":"view",
                       "name":"就业喜报",  
                       "url":"http://www.opjpg.com/TP3/index.php/xlh/Index"  
                    },  
                    {  
                       "type":"view",  
                       "name":"精彩活动",  
                       "url":"http://www.opjpg.com/TP3/index.php/xlh/Index"  
                    },
                    {  
                       "type":"view",  
                       "name":"扩展训练",  
                       "url":"http://www.opjpg.com/TP3/index.php/xlh/Index/"  
                    }
                    ]
              },  
              {  
                   "name":"走进大智",  
                   "sub_button":[  
                   {      
                       "type":"view",  
                       "name":"行业动态",  
                       "url":"http://www.opjpg.com/TP3/index.php/xlh/Index"  
                    },  
                    {  
                       "type":"view",  
                       "name":"校园新闻",  
                       "url":"http://www.opjpg.com/TP3/index.php/xlh/Index"  
                    },  
                    {  
                       "type":"view",  
                       "name":"学习资料",  
                       "url":"http://www.opjpg.com/TP3/index.php/xlh/Index"  
                    },
                    {  
                       "type":"view",  
                       "name":"砍价",  
                       "url":"http://www.opjpg.com/TP3/index.php/xlh/rush/index"  
                    }
                   ]
              },  
              {  
                   "name":"在线咨询",  
                   "sub_button":[  
                   {      
                       "type":"view",  
                       "name":"官方微博",  
                       "url":"http://www.weibo.com/"  
                    },  
                    {  
                       "type":"click",  
                       "name":"微信咨询",  
                       "key":"V1001_CONSULT"
                    },  
                    {  
                       "type":"view",  
                       "name":"立即报名",  
                       "url":"http://www.opjpg.com/TP3/index.php/xlh/Index/add"  
                    }]  
               }]  
         }';
            $url ="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token;
            //设置一个新的会话也是url
            $ch = curl_init();
            // currl_setopt设置一个cURL传输选项。
            // 	CURLOPT_URL需要获取的URL地址，也可以在curl_init()函数中设置。
            curl_setopt($ch, CURLOPT_URL,$url);
            //CURLOPT_CUSTOMREQUEST请求方式
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            //验证url的设置false就行
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            //CURLOPT_SSL_VERIFYHOST检查服务器SSL证书中是否存在一个公用名
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            //CURLOPT_USERAGENT在HTTP请求中包含一个"User-Agent: "头的字符串。
            curl_setopt($ch, CURLOPT_USERAGENT, 'xialonghao');
            //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            //CURLOPT_AUTOREFERER当根据Location:重定向时，自动设置header中的Referer:信息。
            curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
            //接受全部数据使用HTTP协议中的"POST"操作来发送
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            // 	在启用CURLOPT_RETURNTRANSFER的时候，返回原生的（Raw）输出。
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //将curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
            $tmpInfo = curl_exec($ch);
            if (curl_errno($ch)) {
                echo curl_error($ch);
            }
            curl_close($ch);
            echo $tmpInfo;

        }
        public function content(){
            return $this->fetch();
        }
        public function new_list(){
            return $this->fetch();
        }
//        public function Index(){
//                $info=db('dy')->select();
//                $this->assign('info',$info);
//                return $this->fetch();
//        }
////        public function sj(){
////            $sj=time();
////            $ss=date("Y-m-d H:i",$sj);
////            print_r($ss);exit;
////        }

    }
?>