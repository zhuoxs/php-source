<?php
// +----------------------------------------------------------------------
// | msvodx[TP5内核]
// +----------------------------------------------------------------------
// | Copyright © 2019-QQ97250974
// +----------------------------------------------------------------------
// | 专业二开仿站定制修改,做最专业的视频点播系统
// +----------------------------------------------------------------------
// | Author: cherish ©2018
// +----------------------------------------------------------------------
namespace app\admin\controller;

/**
 * 会员管理控制器
 * @package app\admin\controller
 */
class Member extends Admin
{

    /**
     * 会员列表
     * @author frs
     * @return mixed
     */
    public function index()
    {
        $tab_data['menu'] = [
            [
                'title' => '会员列表',
                'url' => 'admin/member/index?types=member',
            ],
            [
                'title' => '代理商列表',
                'url' => 'admin/member/index?types=agent',
            ],
        ];
        $this->tab_data = $tab_data;
        $types = $this->request->param('types/s','member');
        $member_type = $this->request->param('member_type/d','0');
        //var_dump($this->request->param('types/s','member'));
        //var_dump($types);
        $this->tab_data['current'] = url('admin/member/index',array('types'=>$types));
        $this->assign('tab_data', $this->tab_data);
        $this->assign('tab_type', 1);
        $where = '1=1';
        if($types == 'agent'){
            $where .= ' and is_agent = 1';
        }
        switch ($member_type)
        {
            case 1:
                $where .= ' and out_time < '.time().' and is_permanent <>1';
                 break;
            case 2:
                $where .= ' and (out_time > '.time().' or is_permanent = 1)';
                  break;
            case 3:
                $where .= ' and out_time > '.time().' and is_permanent <>1';
                break;
            case 4:
                $where .= ' and is_permanent = 1';
                break;
            default:

        }
        $key=$this->request->get('key/s');
        $keyword=$this->request->get('keyword/s');
        if(!empty($keyword)){
            $where .= " and $key like '%{$keyword}%' ";
        }
        $data_list =  $this->myDb->name('member')->where($where)->order('id desc')->field('id,gid,nickname,status,headimgurl,tel,email,money,add_time,last_time,is_agent,is_permanent,out_time,username')->paginate(20,false,['query'=>$this->request->get()]);
        // 分页
        $pages = $data_list->render();
        $this->assign('keys', $key);
        $this->assign('keyword', $keyword);
        $this->assign('member_type', $member_type);
        $this->assign('data_list', $data_list);
        $this->assign('pages', $pages);
        return $this->fetch();

    }

    /**
     * 添加会员
     * @author frs
     * @return mixed
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $data['out_time'] = !empty($data['out_time'])? strtotime($data['out_time']) : 0;
           $result = $this->validate($data, 'AdminMember.add');
            if($result !== true) {
                return $this->error($result);
            }
            $data['add_time'] = time();
            unset($data['id']);
            $data['password'] = encode_member_password($data['password']);
            if (! $this->myDb->name('member')->insert($data)) {
                return $this->error('添加失败！');
            }
            return $this->success('添加成功。',url('member/index'));
        }
        //$group_option = $this->getGroupOption();
        //$this->assign('group_option', $group_option);
        return $this->fetch('form');
    }

    /**
     * 修改会员
     * @author frs
     * @return mixed
     */
    public function edit($id = 0)
    {
        $id=$this->request->param('id');
        $where['id'] = $id;
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $data['out_time'] = strtotime($data['out_time']) > 0 ? strtotime($data['out_time']) : 0;
            // 验证
            $result = $this->validate($data, 'AdminMember.edit');
            if(empty($data['password'])){
                unset($data['password']);
            }else{
                $data['password'] = encode_member_password($data['password']);
            }
            if($result !== true) {
                return $this->error($result);
            }
            $this->myDb->name('member')->where($where)->update($data);
            /*
            if (!MemberModel::update($data)) {
                return $this->error('修改失败！');
            }*/
            return $this->success('修改成功',url('member/index'));
        }else{
            $info = $this->myDb->name('member')->where($where)->field('id,username,gid,nickname,email,tel,status,is_permanent,out_time,is_agent,money')->find();
            //$group_option = $this->getGroupOption($info['gid']);
            //$this->assign('group_option', $group_option);
            $this->assign('info', $info);
            return $this->fetch();
        }


    }


    /**
     * 代理商申请记录
     * @author frs
     * @return mixed
     */
    public function agentApply()
    {
        $data_list = $this->myDb->name('agent_apply')->alias('a')->join('ms_member m','a.user_id = m.id')->order('a.last_time desc')->field('a.id,a.status,apply_time,a.last_time,headimgurl,nickname,tel,email')->paginate(20);
        $pages = $data_list->render();
        $this->assign('data_list', $data_list);
        $this->assign('pages', $pages);
        return $this->fetch();
    }

     /**
     * 代理商域名申请记录
     * @author frs
     * @return mixed
     */
    public function domainname()
    {
        $data_list = $this->myDb->name('domain_cname_binding')->alias('a')->join('ms_member m','a.uid = m.id')->order('a.last_time desc')->field('a.id,a.status,a.add_time,a.last_time,a.webhost,headimgurl,nickname,tel,email')->paginate(20);
        $pages = $data_list->render();
        $this->assign('data_list', $data_list);
        $this->assign('pages', $pages);
        return $this->fetch();
    }

    /**
     * 修改代理商状态
     * @author frs
     * @return mixed
     */
    public function isAgent()
    {
        $id=$this->request->param('ids');
        $is_agent = $this->request->param('val');
        $this->myDb->name('member')->where(array('id'=>$id))->update(array('is_agent'=>$is_agent));
        $data = array(
            'code' => 1,
            'msg' => "状态设置成功",
        );
        return $data;
    }

    /**
     * 会员列表弹窗
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function pop() {
        $q = input('param.q/s');
        $callback = input('param.callback/s');
        if (!$callback) {
            echo '<br><br>callback为必传参数！';
            exit;
        }

        $map = [];
        if ($q) {
            if (preg_match("/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/", $q)) {// 邮箱
                $map['email'] = $q;
            } elseif (preg_match("/^1\d{10}$/", $q)) {// 手机号
                $map['mobile'] = $q;
            } else {// 用户名、昵称
                $map['username'] = ['like', '%'.$q.'%'];
            }
        }
        
        $data_list = MemberModel::where($map)->paginate(10, true);
        // 分页
        $pages = $data_list->render();
        $this->assign('data_list', $data_list);
        $this->assign('pages', $pages);
        $this->assign('callback', $callback);
        $this->view->engine->layout(false);
        return $this->fetch();
    }

    // +----------------------------------------------------------------------
    // | 会员组
    // +----------------------------------------------------------------------

    /**
     * 会员组
     * @author frs ©2016
     * @return mixed
     */
    public function group_x()
    {
        $data_list =  $this->myDb->name('member_group')->order('sort desc')->field('id,name,sort,status,intro')->paginate(20);
        // 分页
        $pages = $data_list->render();
        $this->assign('data_list', $data_list);
        $this->assign('pages', $pages);
        return $this->fetch();
    }

    /**
     * 获取会员组，以组id为数组下标
     * @author frs
     * @return mixed
     */
    public function getGroup($parameter = 'name')
    {
        $parameter  = 'id,'.$parameter;
        $list = $this->myDb->name('member_group')->where(array('status'=>1))->field($parameter)->select();
        $data = array();
        if(!empty($list)){
            foreach ($list  as $k =>$v) {
                $data[$v['id']] = $v;
            }
        }
        return $data;
    }

    /**
    * 获取会员组，以组id为数组下标
    * @author frs
    * @return mixed
    */
    public function getGroupOption($id=0)
    {
        $rows = $this->myDb->name('member_group')->column('id,name');
        $str = '';
        foreach ($rows as $k => $v) {
            if ($id == $k) {
                $str .= '<option value="'.$k.'" selected>'.$v.'</option>';
            } else {
                $str .= '<option value="'.$k.'">'.$v.'</option>';
            }
        }
        return $str;
    }
    /**
     * 添加会员组
     * @author frs
     * @return mixed
     */
    public function addGroup_x()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $db=$this->myDb->name('member_group');
            //验证视频信息
            $rule =[
                'name|名称'=>'require',
            ];
            $message=[
                'title.require'=>"名称不能为空",
            ];
            $result=$this->validate($data,$rule,$message);
            if($result !== true) {
                return $this->error($result);
            }
            if($db->insert($data)){
                return $this->success('添加成功',url('member/group'));
            }
            return $this->error('哎呀，出错了！');
        }else{
            return $this->fetch();
        }
    }

    /**
     * 编辑会员组
     * @author frs
     * @return mixed
     */
    public function editGroup_x()
    {
        $db=$this->myDb->name('member_group');
        $id=$this->request->param('id');
        $where['id'] = $id;
        if ($this->request->isPost()) {
            $data = $this->request->post();
            //验证视频信息
            $rule =[
                'name|名称'=>'require',
            ];
            $message=[
                'title.require'=>"名称不能为空",
            ];
            $result=$this->validate($data,$rule,$message);
            if($result !== true) {
                return $this->error($result);
            }
            $info = $db->where($where)->update($data);

            if($info){
                return $this->success('修改成功',url('member/group'));
            }
            return $this->error('哎呀，出错了！');
        }else{
            $info = $db->where($where)->field('id,name,sort,intro')->find();
            $this->assign('info', $info);
            return $this->fetch();
        }
    }

    // +----------------------------------------------------------------------
    // | 会员等级
    // +----------------------------------------------------------------------

    /**
     * 会员等级列表
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function level()
    {
        $data_list = LevelModel::field('id,name,intro,discount,min_exper,max_exper,ctime,default,status')->paginate();
        // 分页
        $pages = $data_list->render();
        $this->assign('data_list', $data_list);
        $this->assign('pages', $pages);
        return $this->fetch();
    }

    /**
     * 添加会员等级
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function addLevel()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            // 验证
            $result = $this->validate($data, 'AdminMemberLevel');
            if($result !== true) {
                return $this->error($result);
            }
            unset($data['id']);
            if (!LevelModel::create($data)) {
                return $this->error('添加失败！');
            }
            // 更新缓存
            cache('system_member_level', LevelModel::getAll());
            return $this->success('添加成功。');
        }

        return $this->fetch('levelform');
    }

    /**
     * 修改会员等级
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function editLevel($id = 0)
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            // 验证
            $result = $this->validate($data, 'AdminMemberLevel');
            if($result !== true) {
                return $this->error($result);
            }
            if (!LevelModel::update($data)) {
                return $this->error('修改失败！');
            }
            // 更新缓存
            cache('system_member_level', LevelModel::getAll());
            return $this->success('修改成功。');
        }
        $row = LevelModel::where('id', $id)->find()->toArray();

        $this->assign('data_info', $row);
        return $this->fetch('levelform');
    }

    /**
     * 删除会员等级
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function delLevel()
    {
        $ids = input('param.ids/a');
        $model = new LevelModel;
        if (!$model->del($ids)) {
            return $this->error($model->getError());
        }
        return $this->success('删除成功');
    }

    /**
     * 设置默认等级
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function setDefault($id = 0)
    {
        LevelModel::update(['default' => 0], ['id' => ['neq', $id]]);
        if (LevelModel::where('id', $id)->setField('default', 1) === false) {
            return $this->error('设置失败！');
        }
        return $this->success('设置成功。');
    }
}
