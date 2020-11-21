<?php
/**
 * Beta_car模块订阅器
 */
defined('IN_IA') or exit('Access Denied');
class  Beta_carModuleReceiver extends WeModuleReceiver {
    public function receive() {
        global $_GPC,$_W;
        $type = json_decode($this->message['scene'],true);
        $account_api = WeAccount::create();
        switch ($type['type']){
            case 'bata_car_qr':
                //判断当前公众号是认证服务号，具有发送权限
                $car = pdo_get('beta_car_car',['sn'=>$type['sn']]);
                $message =  array(
                    'touser'=>$this->message['fromusername'],
                    'msgtype'=> 'news',
                    'news'=>array(
                        'articles'=>array(
                            array(
                                'title'=>urlencode('点击继续联系【'.$car['car'].'】车主'),
                                'description'=>urlencode('临时停靠，请多关照'),
                                'url'=> $this->beta_murl('qrcode',['sign'=>$type['sn'],'op'=>'scan']),
                                'picurl'=>$_W['siteroot'].'addons/beta_car/static/img/carmsg.png',
                            )
                        )
                    )
                );
                    $status = $account_api->sendCustomNotice($message);
                break;
            case 'bata_car_bind':
                //判断当前公众号是认证服务号，具有发送权限
                $message =  array(
                    'touser'=>$this->message['fromusername'],
                    'msgtype'=> 'news',
                    'news'=>array(
                        'articles'=>array(
                            array(
                                'title'=>urlencode('关注成功，点击继续绑定车辆'),
                                'description'=>urlencode('感谢您的关照，今天又是美好的一天！'),
                                'url'=> $this->beta_murl('bind',['sign'=>$type['sn']]),
                                'picurl'=>$_W['siteroot'].'addons/beta_car/static/img/bind.png',
                            )
                        )
                    )
                );
                $status = $account_api->sendCustomNotice($message);
                break;
            case 'bata_car_addcar':
                //判断当前公众号是认证服务号，具有发送权限
                $message =  array(
                    'touser'=>$this->message['fromusername'],
                    'msgtype'=> 'news',
                    'news'=>array(
                        'articles'=>array(
                            array(
                                'title'=>urlencode('关注成功，点击继续添加车辆'),
                                'description'=>urlencode('感谢您的关照，今天又是美好的一天！'),
                                'url'=> $this->beta_murl('addcar'),
                                'picurl'=>$_W['siteroot'].'addons/beta_car/static/img/carmsg.png',
                            )
                        )
                    )
                );
                $status = $account_api->sendCustomNotice($message);
                break;
            case 'bata_car_wxmsg':
                //判断当前公众号是认证服务号，具有发送权限
                $message =  array(
                    'touser'=>$this->message['fromusername'],
                    'msgtype'=> 'news',
                    'news'=>array(
                        'articles'=>array(
                            array(
                                'title'=>urlencode('关注成功，已帮您自动开启微信通知'),
                                'description'=>urlencode('感谢您的关照，今天又是美好的一天！'),
                                'url'=> $this->beta_murl('user'),
                                'picurl'=>$_W['siteroot'].'addons/beta_car/static/img/wxmsg.png',
                            )
                        )
                    )
                );
                $status = $account_api->sendCustomNotice($message);
                break;
        }
    }
    public function beta_murl($do = '', $query = array(), $full = true)
    {
        global $_W;

        $query = array_merge(array('do' => $do), $query);
        $query = array_merge(array('m' => 'beta_car'), $query);

        if ($full) {
            return $_W['siteroot'] . 'app/' . substr(murl('entry', $query), 2);
        }
        return murl('entry', $query);
    }
}
