<?php
namespace dingtalk;

class MsgText{
    protected $msgtype = 'text';
    protected $content = '';
    protected $atMobiles = [];
    protected $isAtAll = false;
    function __construct($content, $at= false)
    {
        $this->content = $content;
        if ($at){
            if (strtoupper($at) == "ALL"){//@全部
                $this->isAtAll = true;
            }else if (is_array($at)){//@多个手机号码
                $this->atMobiles = $at;
            }else if(is_string($at)){//@单个手机号码
                $this->atMobiles = [$at];
            }
        }
    }
    function __toString()
    {
        $data = [];
        $data['msgtype'] = $this->msgtype;
        $data['text'] = ['content'=>$this->content];
        $data['at'] = ['atMobiles'=>$this->atMobiles,'isAtAll'=>$this->isAtAll];
        return json_encode($data);
    }
}



















