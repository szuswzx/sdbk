<?php
/*
     http://www.fangbei.org/
     CopyRight 2015 All Rights Reserved
*/
define("TOKEN", "weixin");
class Wechat_api extends CI_Controller
{
	public function __construct()
	{
	  parent::__construct();
	}

	public function index()
	{
	  if (!isset($_GET['echostr'])) {
			$this->responseMsg();
		}else{
			$this->valid();
		}

	}
	  
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }
    
	//证书验证
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

            switch ($RX_TYPE)
            {
                case "text":
                    $resultStr = $this->receiveText($postObj);
                    break;
                case "event":
                    $resultStr = $this->receiveEvent($postObj);
                    break;
                default:
                    $resultStr = "";
                    break;
            }
            echo $resultStr;
        }else {
            echo "";
            exit;
        }
    }

    private function receiveText($object)
    {
        $funcFlag = 0;
        $contentStr = "你发的 ".$object->Content." 百科君暂时识别不了呢/(ㄒoㄒ)/~~，我会加油的！";
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
    }
    
    private function receiveEvent($object)
    {
		$this->load->model('menu_model');
		$menudata = $this->menu_model->get_menu();
        $contentStr = "";
        switch ($object->Event)
        {
            case "subscribe":
                $contentStr = "欢迎关注深大百科";
            case "unsubscribe":
                break;
            case "CLICK":
			    $sum = 0;
			    foreach($menudata as $menu)
				{
					if($menu['key'] == $object->EventKey && $menu['type'] == 'click')
					{
						$contentStr[] = array("Title" =>$menu['title'], 
                        "Description" =>$menu['description'], 
                        "PicUrl" =>$menu['picurl'], 
                        "Url" =>$menu['url']);
						$sum++;
					}
				}
				if($sum == 0)
				{
					$contentStr[] = array("Title" =>"暑假开放", 
					"Description" =>"暑假事务中心也会开放哦", 
					"PicUrl" =>"http://mmbiz.qpic.cn/mmbiz_jpg/Mma54MeJfO3JLGanBab10iatMeKPpk31H62c0y8t0ytdblmJpG7nJ3xDbLSNZXia8UjgjO1iclluiaFt1ricVhxuUHg/0", 
					"Url" =>"http://mp.weixin.qq.com/s/RlciePoMey24RfmKZOWWYA");
				}
                /*switch ($object->EventKey)
                {
                    case "abc":
                        $contentStr[] = array("Title" =>"暑假开放", 
                        "Description" =>"暑假事务中心也会开放哦", 
                        "PicUrl" =>"http://mmbiz.qpic.cn/mmbiz_jpg/Mma54MeJfO3JLGanBab10iatMeKPpk31H62c0y8t0ytdblmJpG7nJ3xDbLSNZXia8UjgjO1iclluiaFt1ricVhxuUHg/0", 
                        "Url" =>"http://mp.weixin.qq.com/s/RlciePoMey24RfmKZOWWYA");
						$contentStr[] = array("Title" =>"暑假不开放", 
                        "Description" =>"你说开放就开放吗", 
                        "PicUrl" =>"http://discuz.comli.com/weixin/weather/icon/cartoon.jpg", 
                        "Url" =>"http://mp.weixin.qq.com/s/RlciePoMey24RfmKZOWWYA");
                        break;
                    default:
                        $contentStr[] = array("Title" =>"暑假开放", 
                        "Description" =>"暑假事务中心也会开放哦", 
                        "PicUrl" =>"http://mmbiz.qpic.cn/mmbiz_jpg/Mma54MeJfO3JLGanBab10iatMeKPpk31H62c0y8t0ytdblmJpG7nJ3xDbLSNZXia8UjgjO1iclluiaFt1ricVhxuUHg/0", 
                        "Url" =>"http://mp.weixin.qq.com/s/RlciePoMey24RfmKZOWWYA");
                        break;
                }*/
                break;
            default:
                break;      

        }
        if (is_array($contentStr)){
            $resultStr = $this->transmitNews($object, $contentStr);
        }else{
            $resultStr = $this->transmitText($object, $contentStr);
        }
        return $resultStr;
    }

	//回复文本
    private function transmitText($object, $content, $funcFlag = 0)
    {
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[text]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>%d</FuncFlag>
					</xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $funcFlag);
        return $resultStr;
    }

	private function transmitImage($object, $imageArray)
	{
		$itemTpl = "<Image>
					<MediaId><![CDATA[%s]]></MediaId>
					</Image>";
 
        $item_str = sprintf($itemTpl, $imageArray['MediaId']);
 
        $xmlTpl = "<xml>
				   <ToUserName><![CDATA[%s]]></ToUserName>
				   <FromUserName><![CDATA[%s]]></FromUserName>
				   <CreateTime>%s</CreateTime>
				   <MsgType><![CDATA[image]]></MsgType>
				   $item_str
				   </xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
	}
	
	//回复图文消息
    private function transmitNews($object, $arr_item, $funcFlag = 0)
    {
        //首条标题28字，其他标题39字
        if(!is_array($arr_item))
            return;

        $itemTpl = "<item>
					<Title><![CDATA[%s]]></Title>
					<Description><![CDATA[%s]]></Description>
					<PicUrl><![CDATA[%s]]></PicUrl>
					<Url><![CDATA[%s]]></Url>
					</item>
					";
        $item_str = "";
        foreach ($arr_item as $item)
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);

        $newsTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[news]]></MsgType>
					<Content><![CDATA[]]></Content>
					<ArticleCount>%s</ArticleCount>
					<Articles>
					$item_str</Articles>
					<FuncFlag>%s</FuncFlag>
					</xml>";

        $resultStr = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($arr_item), $funcFlag);
        return $resultStr;
    }
	  
  }
//end