<?php
namespace app\wxylp\controller;
use think\Controller;
// define('Token','robots');
class Index extends Controller
{

    public function robot(){
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        libxml_disable_entity_loader(true);
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $ToUserName=$postObj->ToUserName;
        $FromUserName=$postObj->FromUserName;
   
        $MsgId=$postObj->MsgId;     $content=$postObj->Content;
        $MsgType=$postObj->MsgType;
        $Format=$postObj->Format;
        $MediaId=$postObj->MediaId;
        $event=$postObj->Event;

        $url="http://www.tuling123.com/openapi/api?key=07f078623a99489ba5ebb1bfd1b12b32&info=".$content;
        $replay=file_get_contents($url);
        $recontent=json_decode($replay);
        $nowtime=time();

        switch ($MsgType) {
            case 'event':
           
            if($event=='subscribe'){
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
               
                 
                $resultStr = sprintf($xmltpl,$FromUserName,$ToUserName,$nowtime,'text','Welcome to the PHPhero');
                echo $resultStr;
                    break;
            }else{
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
               
                 
                $resultStr = sprintf($xmltpl,$FromUserName,$ToUserName,$nowtime,'text','Welcome to the PHPhero');
                echo $resultStr;
                    break;
            }
            
            case 'text':

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
            $repaycontent=$recontent->text;
             
            $resultStr = sprintf($xmltpl,$FromUserName,$ToUserName,$nowtime,'text',$repaycontent);
            echo $resultStr;
            $data['content']=$content;
            $data['inputtime']=$nowtime;
            $data['type']=$MsgType;
            $data['openid']=$FromUserName;
            $data['reply']=$repaycontent;
            $info=db('ylp')->insert($data);
                break;

            case 'image':

            $imagetpl="
            <xml> 
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[image]]></MsgType> 
            <Image>  
                <MediaId><![CDATA[%s]]></MediaId>  
            </Image>  
            <MsgId>%s</MsgId> 
            </xml>
                ";
            
            $resultStr = sprintf($imagetpl,$FromUserName,$ToUserName,$nowtime,'bXMW6efflItn-4Q2gn0X5vSooMZvM2K2lxQyz-xk0VghFNS11URujWvHTmuhTLXZ',$MsgId);
            echo $resultStr;
                    $data['inputtime']=$nowtime;
                    $data['openid']=$FromUserName;
                    $data['type']=$MsgType;
                    $data['image']=$postObj->PicUrl;
                     $data['reply']=$ToUserName;
                    $data=db('ylp')->insert($data);
                break;
            case 'voice':

            $voicetpl="
            <xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[voice]]></MsgType>
            <Voice>
                <MediaId><![CDATA[%s]]></MediaId>
            </Voice>

            </xml>
                ";
            $resultStr = sprintf($voicetpl, $FromUserName, $ToUserName, $nowtime, $MediaId);
            echo $resultStr;

                break;
            case 'video':
            $xmltpl="
            <xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[video]]></MsgType>
                <Video>
                    <MediaId><![CDATA[%s]]></MediaId>
                </Video> 
            </xml>
             
        ";
        
            $resultStr = sprintf($xmltpl,$FromUserName,$ToUserName,$nowtime,'uNL4zuz5qzPLGIGkAUJljAGAIXRdhBtui4U4eoDaZvn10b0YMzKyd-lC7UsMuV9N');
            echo $resultStr;
                break;
            default:
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
            $repaycontent=$recontent->text;
             
            $resultStr = sprintf($xmltpl,$FromUserName,$ToUserName,$nowtime,'text','你发的是什么，我不知道哦');
            echo $resultStr;
                break;
        }
        
        //}
        





     //    $signature=$_GET["signature"];
        // $timestamp=$_GET["timestamp"];
        // $nonce=$_GET["nonce"];
        // $echostr=$_GET['echostr'];
        // $array=array(Token,$timestamp,$nonce);
        // sort($array,SORT_STRING);
        // $str=implode('',$array);
        // $str=sha1($str);
        // if($str==$signature)
        // {
        //  echo $echostr;
        // }
        // else
        // {
        //  return false;
        // }

    }
    public function robots()
    { 
      $db=db('ylp');
      $info=$db->select();
      $this->assign('info',$info);
      return $this->fetch();
    }
  public function  jiekou(){
           
   $appid='wx194d62041f149141';
   $appsecret='1cf7b14724f443e3388d458d750bd9e4';
   $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret.'';  
  //初始化一个新的会话
   $ch = curl_init();     
  curl_setopt($ch, CURLOPT_URL,$url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $output = json_decode(curl_exec($ch),true);
        //print_r($output);exit;
      
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
                      "url":"http://www.opjpg.com/TP3/index.php/ylp/index/index" 
                    },  
                    {  
                       "type":"view",
                       "name":"就业喜报",  
                      "url":"http://www.opjpg.com/TP3/index.php/ylp/index/index"  
                    },  
                    {  
                       "type":"view",  
                       "name":"精彩活动",  
                       "url":"http://www.weibo.com/"  
                    },
                    {  
                       "type":"view",  
                       "name":"扩展训练",  
                       "url":"http://www.kuangzhan.com/"  
                    }
                    ]
              },  
              {  
                   "name":"走进大智",  
                   "sub_button":[  
                   {      
                       "type":"view",  
                       "name":"行业动态",  
                       "url":"http://www.dazhi.com/"  
                    },  
                    {  
                       "type":"view",  
                       "name":"校园新闻",  
                       "url":"https://www.jd.com/"  
                    },  
                    {  
                       "type":"view",  
                       "name":"学习资料",  
                       "url":"http://www.tm.com/"  
                    },
                    {  
                       "type":"view",  
                       "name":"大智课程",  
                       "url":"https://mp.weixin.qq.com"  
                    }
                   ]
              },  
             {  
                   "name":"在线咨询",  
                   "sub_button":[  
                   {      
                       "type":"view",  
                       "name":"官方微博",  
                       "url":"http://www.soso.com/"  
                    },  
                    {  
                       "type":"click",  
                       "name":"微信咨询",  
                       "key":"V1001_CONSULT"
                    },  
                    {  
                       "type":"view",  
                       "name":"立即报名",  
                       "url":"http://www.alroy.cn/"  
                    }]  
               }]  
         }';

         $url ="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token;
            //print_r($url);exit;
            //设置一个新的会话也是url
            $ch = curl_init();
            // currl_setopt设置一个cURL传输选项。
            //  CURLOPT_URL需要获取的URL地址，也可以在curl_init()函数中设置。
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
            //  在启用CURLOPT_RETURNTRANSFER的时候，返回原生的（Raw）输出。
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //将curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
            $tmpInfo = curl_exec($ch);
            if (curl_errno($ch)) {
                echo curl_error($ch);
            }
            curl_close($ch);
            echo $tmpInfo;

        }
     }
