<?php
namespace Home\Controller;
use Common\Controller\HomeBaseController;
use Common\Model\MemberModel;
use Think\Db;

class PostsController extends HomeBaseController{

    //产品列表
    public function index()
    {
        $cid = intval(I('get.cid'));
        $map['status'] = 1;
        if( $cid > 0 ) {
            $map['cid'] = $cid;
        }
        $t = array("产品列表","车贷产品","信贷产品");
        $title = isset($t[$cid]) ? $t[$cid] : '产品列表';

        $model = M('posts');
        $count = $model->where($map)->count();
        $page = sp_get_page_m($count,10);//分页
        $firstRow = $page->firstRow;
        $listRows = $page->listRows;
        $list = $model->where($map)->order('id desc')->limit("$firstRow , $listRows")->select();
        //echo $model->_sql();
        $this->assign("Page", $page->show());
        $this->assign("list", $list);
        $this->assign('count', $count);

        $this->assign("title", $title);
        $this->display();
    }

    /**
     * 产品展示
     */
    public function show()
    {
        $id = intval(I('get.id'));
        if( !($id > 0) ) {
            $this->error('参数错误');
        }
        $show = M('posts')->find($id);
        $this->assign('show', $show);
        //添加浏览次数
        M('posts')->where(array('id'=>$id))->setInc('view');

        if( $show['cid'] == 1 ) {
            //车贷
            $tpl = "";
        } else {
            //信贷
            $tpl = "show_xindai";
        }

        $this->display($tpl);
    }

    /**
     * 申请产品
     */
    public function apply()
    {
        if( !$this->is_login() ) {
            $this->redirect('Public/login');
        }

        $id = intval(I('get.id'));
        /*if( !($id > 0) ) {
            $this->error('参数错误');
        }
        //是否登陆
        $ret_url = U('posts/show',array('id'=>$id));
        if( !$this->is_login() ) {
            $this->redirect('Public/login',array('ret_url'=>base64_encode($ret_url)));
        }*/

        $this->assign('post_id',$id);
        $this->display();
    }



    /**
     * 申请产品 提交
     */
    public function apply_do()
    {
        if( !$this->is_login() ) {
            $this->error('请先登陆');
        }

        $post_id = intval(I('post.post_id'));
        /*if( !($post_id > 0) ) {
            $this->error('参数错误');
        }*/

        $files = I('post.files');
        $idc_z = I('post.idc_z');
        $idc_f = I('post.idc_f');
        $jiashi_z = I('post.jiashi_z');
        $jiashi_f = I('post.jiashi_f');
        $bank_z = I('post.bank_z');
        $bank_f = I('post.bank_f');
        $price = floatval(I('post.price'));
        $jkqx = I('post.jkqx');

        if( isset($files[0]) && empty($files[0]) ) {
            $this->error('请上传资料');
        }
        if( empty($idc_z) ) {
            $this->error('请上传身份正面照片');
        }
        if( empty($idc_f) ) {
            $this->error('请上传身份反面照片');
        }
        if( empty($jiashi_z) ) {
            $this->error('请上传行驶证正面照片');
        }
        if( empty($jiashi_f) ) {
            $this->error('请上传行驶证反面照片');
        }
        if( empty($bank_z) ) {
            $this->error('请上传银行卡正面照片');
        }
        if( empty($bank_f) ) {
            $this->error('请上传银行卡反面照片');
        }
        if( empty($price) ) {
            $this->error('请输入借款金额');
        }
        if( !is_numeric($price) ) {
            $this->error('借款金额必须为数字');
        }
        if( !($price > 0) ) {
            $this->error('借款金额必须大于0');
        }
        if( empty($jkqx) ) {
            $this->error('请输入借款期限');
        }

        $data['member_id'] = $this->get_member_id();
        $data['post_id'] = $post_id;
        $data['files'] = json_encode($files);
        $data['idc_z'] = $idc_z;
        $data['idc_f'] = $idc_f;
        $data['jiashi_z'] = $jiashi_z;
        $data['jiashi_f'] = $jiashi_f;
        $data['bank_z'] = $bank_z;
        $data['bank_f'] = $bank_f;

        $data['price'] = $price;
        $data['jkqx'] = $jkqx;

        $data['create_time'] = time();
        $data['status'] = 0;
        $data['remark'] = I('post.remark');;
        $result = M('posts_apply')->add($data);

        if( $result ) {
            //增加申请条数
            M('posts')->where(array('id'=>$post_id))->setInc('apply_count');
            $this->success('申请成功，等待审核', U('Member/apply'));
        } else {
            $this->error('申请提交失败');
        }
    }
}

