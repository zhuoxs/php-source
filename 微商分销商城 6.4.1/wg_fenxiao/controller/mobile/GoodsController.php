<?php
class GoodsController extends MobileBaseController {
    public function index() {


        $data['shopname'] = !empty($this->module['config']['shopname']) ? $this->module['config']['shopname'] : '分销商城';

        //1.取得商品id,
        $goods_id = intval($this->GPC['goods_id']);
        //2.查出商品
        $goods = $this->GoodsModel->getOne([
            'id' => $goods_id,
            'weid' => $this->W['uniacid']
        ]);

        if (empty($goods)) {
            message('获取商品失败,或者商品已经下架');
        }

        $attr = $this->GoodsAttributeModel->getOne([
            'goods_id' => $goods_id,
        ]);
        if($attr) {
            $goods = array_merge($goods, $attr);
        }

        if($goods['duliyongjin'] > 0) {
            if($goods['yongjin_used'] < $goods['zongyongjin']) {
                if($goods['duliyongjin'] == 1) {
                    $goods['can_get'] = $goods['yongjin1'];
                }else {
                    $goods['can_get'] = $goods['yongjin1'];
                }
            }
        }


        $type = $this->GoodsTypeModel->getList([
            'goods_id' => $goods_id,
            'del'      => 0
        ],'*','display_order asc');

        if(!$type) {
            exit;
        }else {
            $min = 0;
            $max = 0;
            foreach($type as $t) {
                $t['marketprice'] = number_format($t['marketprice'],2,'.', '');
                if($t['marketprice'] > $max) {
                    if($min == 0) {
                        $min = $t['marketprice'];
                    }
                    $max = $t['marketprice'];
                }
                if($t['marketprice'] < $min) {
                    $min = $t['marketprice'];
                }
            }
            $max = $max/100;
            $min = $min/100;
        }
        $goods['can_get'] = false;
        if($goods['duliyongjin'] > 0 && $goods['fenxiao'] && $this->module['config']['level']) {
            if($goods['yongjin_used'] < $goods['zongyongjin']) {
                if($goods['duliyongjin'] == 1) {
                    $goods['can_get'] = "佣金 ￥".$goods['yongjin1'];
                }else {
                    $min = number_format($min*$goods['yongjin1'],2,'.', '');
                    $max = number_format($max*$goods['yongjin1'],2,'.', '');
                    if($min != $max) {
                        $goods['can_get'] = "佣金 ￥$min~$max";

                    }else {
                        $goods['can_get'] = "佣金 ￥$min";
                    }
                }
            }
        }elseif($goods['fenxiao'] && $this->module['config']['level']) {
            if($goods['yongjin_used'] < $goods['zongyongjin']) {
                $min = number_format($min*$this->module['config']['yijiyongjin'],2,'.', '');
                $max = number_format($max*$this->module['config']['yijiyongjin'],2,'.', '');
                if($min != $max) {
                    $goods['can_get'] = "佣金 ￥$min~$max";

                }else {
                    $goods['can_get'] = "佣金 ￥$min";
                }

            }
        }

        //$goods['goumaiyaoqiu'] = explode(',', $goods['goumaiyaoqiu']);
        //title
        $this->data['tel']     = $this->site->configs['config']['tel'];
        $this->data['poster']  = $this->site->configs['config']['poster'] ? $this->site->configs['config']['poster'] : '我的海报';
        $this->data['service']        = $this->site->configs['config']['service'];
        $this->data['title']          = $goods['goodsname'];
        $this->data['goods']          = $goods;
        $this->data['collect']        = $this->CollectModel->getOne(['uid' => $this->uid,'goods_id' => $goods_id],'id');
        $this->data['goods_type']     = $type;
        $this->data['shopping_count'] = $this->getShoppingCartCount();

        $this->data['comment'] = $this->CommentModel->getList([
            'goods_id' => $goods_id,
            'status'   => 1
        ],['*'],['id desc'],10);
        if($this->data['comment']) {
            $uids = [];
            foreach($this->data['comment'] as $details) {
                $uids[] = $details['uid'];
            }
            $users = $this->MemberModel->getList([
                'id' => $uids,
            ],['avatar','id','nickname']);
            $users = $this->arrayIndex($users,'id');
            foreach($this->data['comment'] as &$de) {
                $de['user'] = $users[$de['uid']];
            }
        }
        $this->data['zhekou'] = $this->userInfo['zhekou'];

        //是否开启抢购
        $where = [
            'start <'  => time(),
            'end >'    => time(),
            'goods_id' => $goods_id,
            'type'     => 1,
        ];
        $this->data['qianggou']  = $this->GouModel->getOne($where);
        if($this->data['qianggou'] && $this->data['qianggou']['zhekou'] > 0) {
            $this->data['zhekou'] = $this->data['qianggou']['zhekou'];
        }

        $url = $this->W['siteroot'] .'app'. ltrim($this->createMobileUrl('goods',[
            'fromfuid' => $this->uid,
            'goods_id' => $goods_id
            ]),'.');

        $this->data['levelname'] = $this->userInfo['levelname'];
        $this->data['share']  = [
            'title'  => $this->module['config']['shopname'].'-'.$goods['goodsname'],
            'desc'   =>  '',
            'link'   => $url,
            'imgUrl' => formatArrImage($goods['thumb']),
        ];
        $this->assign($this->data);
        $this->display();
    }

    public function collect() {
        $goods_id = intval($_POST['goods_id']);
        $type     = trim($_POST['type']);

        if(!$this->uid) {
            $this->ajaxReturn(300, "请您在微信端登录");
        }
        if($type == 'collect') {
            if($this->CollectModel->getOne(['uid' => $this->uid,'goods_id' => $goods_id])) {
                $this->ajaxReturn(101,'已收藏');
            }else {
                $this->CollectModel->add([
                    'uid'         => $this->uid,
                    'goods_id'    => $goods_id,
                    'craete_time' => time()
                ]);
                $this->ajaxReturn(0,'已收藏');
            }
        } else {
            $this->CollectModel->del(['uid' => $this->uid,'goods_id' => $goods_id]);
            $this->ajaxReturn(0,'');
        }


    }
}