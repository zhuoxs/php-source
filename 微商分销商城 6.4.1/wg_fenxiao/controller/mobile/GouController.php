<?php
class GouController extends MobileBaseController{
    public $size = 10;
    public function index() {

        $data['show_list'] = true;
        $data['fast_menu'] = false;

        $data['slider'] = $this->AdvModel->getList([
            'weid'    => $this->W['uniacid'],
            'enabled' => 1,
            'type'    => 9,
        ],'*','displayorder asc');
        $this->assign($data);
        $this->display();
    }

    public function more_comment() {
        $where = [
            'uniacid' => $this->W['uniacid'],
            'status' => 1
        ];
        $page = intval($_GET['page']);
        $list = $this->CommentModel->getList($where,'*',['id desc'],[$page, 10]);

        $more = true;
        if(count($list) < 10) {
            $more = false;
        }

        if($list) {
            $uids = [];
            foreach($list as &$value) {
                $uids[] = $value['uid'];
                $value['info'] = json_decode($value['info'],true);
                $value['images'] = json_decode($value['images'],true);
                $value['images_count'] = count($value['images']);
            }
            $user = $this->MemberModel->getList([
                'id' => $uids,
            ],['id','avatar','nickname','agentlevel','isagent']);
            $user = $this->arrayIndex($user,'id');


            $levels = $this->getAllLevel('', $this->W['uniacid']);


            foreach($list as &$detail) {
                $detail['user'] = $user[$detail['uid']];
                //是否开启代理了
                if(isset($levels[$user[$detail['uid']]['agentlevel']]) && $user[$detail['uid']]['isagent'] && $this->fenxiao_open) {
                    $detail['user']['levelname'] = $levels[$this->userInfo['agentlevel']]['levelname'];
                }else {
                    $detail['user']['levelname'] = self::$LEVEL_DEFAULT['levelname'];
                }
            }

        }

        $this->ajaxReturn(0,'', [
            'list' => $list,
            'page' => $page+1,
            'more' => $more,
        ]);
    }

    public function more_article() {
        $where = [
            'weid' => $this->W['uniacid']
        ];
        $page = intval($_GET['page']);
        $list = $this->ArticleModel->getList($where,'*',['displayorder desc'],[$page, 10]);

        $more = true;
        if(count($list) < 10) {
            $more = false;
        }


        if($list) {
            foreach($list as &$value) {
                //format
                $value = $this->_formatarticle($value);
            }
        }

        $this->ajaxReturn(0,'', [
            'list' => $list,
            'page' => $page+1,
            'more' => $more,
        ]);
    }


    private function  _formatarticle($value) {
        $image = @json_decode($value['image'], true);
        $value['count'] = 0;
        $value['time']  = $this->formatTime($value['create_time']);
        if(is_array($image) && $image) {
            $value['count'] = count($image) < 3 ? 1 : 3;
            foreach($image as $key => $im) {

                $value['image_'.$key] = $this->W['attachurl'].$im['url'];
                $value['image_'.$key] = $im['url'];
            }
            if(rand(0,10) > 5) {
                $value['count'] = 4;
            }
        }
        unset($value['image']);

        $value['url'] = $value['jump'] ? $value['url'] : $this->createMobileUrl('detail',['id' => $value['id']]);
        $value['kw']  = $value['kw'] ? $value['kw'] : '';


        return $value;
    }
}
