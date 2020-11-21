<?php
class DetailController extends MobileBaseController{
    public function index() {
        $id          = intval($_REQUEST['id']);
        $flag = true;
        $data['article']     = $this->ArticleModel->getOne(['id' => $id]);
        $this->ArticleModel->update(['id' => $id],['read_times +='=>'1']);
        if($data['article']['type'] == 3) {
            $video = json_decode($data['article']['content'], true);
            $data['article']['video_type'] = $video['video_type'];
            $data['article']['video_url']  = $video['video_url'];
            $data['article']['image']      = json_decode($data['article']['image'], true)[0]['url'];
            $data['article']['content']    = $video['content'];
        } else {
            if ($data['article']['data_type'] == 1) {
                $content = '';
                $c = json_decode($data['article']['content'], true)['content'];
                foreach ($c as $value) {
                    if ($value['type'] == 'image') {
                        $data['slider'][] = $value['data']['original'];
                        $content .= '<p><img src="' . $value['data']['original']['url'] . '"/></p>';
                    } elseif ($value['type'] == 'text') {
                        $content .= '<p>' . $value['data'] . '<p/>';
                    }
                }

                $data['article']['content'] = $content;
            }
            if (!$data['article']) {
                $flag = false;
            }
        }
        //share

        global $_W;
        $s_images = @json_decode($data['article']['image'], true);
        if(is_array($s_images) && $s_images) {
            $s_image = formatArrImage($s_images[0])['url'];
        }

        if(strpos($s_image,'http') === false) {
            $s_image = $_W['siteroot'].$s_image;
        }
        $data['share'] = [
            'title' => $data['config']['name'].'-'.$data['article']['title'],
            'desc' => $data['article']['text'] ? $data['article']['text'] : '',
            'link' => $_W['siteroot'].$_SERVER['REQUEST_URI'],
            'imgUrl' => $s_image,
        ];


        $data['list'] = $this->ArticleModel->getList(['weid' => $this->W['uniacid']],['id','title','url','jump'],['id desc'],5);


        $this->assign($data);

        if(!$flag) {
            $this->display('detail/error');
        }
        if($data['article']['type'] == 2) {
            $this->display('detail/image');
            exit;
        }
        $this->display('detail/pay');
    }

    public function praisearticle() {
        $id = intval($_REQUEST['id']);
        $key = 'wg_sales_praise_article_'.$id;
        if($_COOKIE[$key]) {
            echo json_encode(['code' => 1,'msg' => '']);exit;
        }
        $this->ArticleModel->update(['id' => $id],['praise +='=>'1']);
        setcookie($key, 1, time()+3600*24,'/');
        echo json_encode(['code' => 0,'msg' => '']);exit;
    }
}