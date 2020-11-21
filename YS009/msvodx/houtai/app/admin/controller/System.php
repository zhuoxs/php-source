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
use app\admin\model\AdminConfig as ConfigModel;
use app\admin\model\AdminModule as ModuleModel;
use app\admin\model\AdminPlugins as PluginsModel;
use think\Request;

/**
 * 系统设置控制器
 * @package app\admin\controller
 */

class System extends Admin
{

    public $tab_data = [];
    /**
     * 初始化方法
     */
    protected function _initialize()
    {
        parent::_initialize();

        $tab_data['menu'] = [
            [
                'title' => '基础设置',
                'url' => 'admin/system/index',
            ],
            [
                'title' => '视频设置',
                'url' => 'admin/system/video',
            ],
            [
                'title' => '提成设置',
                'url' => 'admin/system/commission',
            ],
            [
                'title' => '附件设置',
                'url' => 'admin/system/attachment',
            ],
            [
                'title' => '邮件设置',
                'url' => 'admin/system/email',
            ],
            [
                'title' => '短信设置',
                'url' => 'admin/system/sms',
            ],
            [
                'title' => '友情链接',
                'url' => 'admin/system/friendLink',
            ],
        ];
        $this->assign('tab_type', 1);
        $this->tab_data = $tab_data;

        //测试账号禁止修改配置
        $user = session('admin_user');
        if($this->request->isPost() && isset($user['uid']) && $user['uid']==1){
            return $this->error('为了保证测试环境的正常有序，禁止保存配置!');
        }

    }
    /**
     * 更新后台的缓存（主要是目录菜单）
     */
    public function refreshCache()
    {
        $cache_tag = '_admin_menu'.ADMIN_ID.dblang('admin');
        cache($cache_tag,null);
        
        // return $this->success('刷新缓存成功');

        die(json_encode(['statusCode' => 0, 'message' => '刷新成功!']));
    }
    /**
     * 系统基础配置
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function index($group = 'base')
    {
        $where['group'] = 'base';
        if ($this->request->isPost()) {
            $config = $this->request->post();
            $config['site_status'] = isset($config['site_status']) ? 1:0;
            $config['wap_site_status'] = isset($config['wap_site_status']) ? 1:0;
            $config['web_mode'] = isset($config['web_mode']) ? 1:0;
            $config['is_withdrawals'] = isset($config['is_withdrawals']) ? 1:0;
            $config['verification_code_on'] = isset($config['verification_code_on']) ? 1:0;
            $config['comment_on'] = isset($config['comment_on']) ? 1:0;
            $config['comment_examine_on'] = isset($config['comment_examine_on']) ? 1:0;
            $config['resource_examine_on'] = isset($config['resource_examine_on']) ? 1:0;
            $config['video_reexamination'] = isset($config['video_reexamination']) ? 1:0;
            $config['image_reexamination'] = isset($config['image_reexamination']) ? 1:0;
            $config['novel_reexamination'] = isset($config['novel_reexamination']) ? 1:0;

			


            foreach ($config as $k => $v){
                $where['name'] = $k;
                $updata['value'] = $v;
                $this->myDb->name('admin_config')->where($where)->update($updata);
            }
            return $this->success('配置成功');
        }else{
            $this->tab_data['current'] = url('admin/system/index');
            $info= $this->myDb->name('admin_config')->where($where)->field('name,value')->select();
            $config = array();
            foreach ($info as $k => $v){
                $config[$v['name']] = $v['value'];
            }
            $this->assign('config', $config);
            $this->assign('tab_data', $this->tab_data);
            return $this->fetch();
        }
    }

    /**
     * 系统基础配置
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function video()
    {
        $where['group'] = 'video';
        if ($this->request->isPost()) {
            $config = $this->request->post();
            $config['look_at_on'] = isset($config['look_at_on']) ? 1:0;
            $config['ad_on'] = isset($config['ad_on']) ? 1:0;
            $config['skip_ad_on'] = isset($config['skip_ad_on']) ? 1:0;
            foreach ($config as $k => $v){
                $where['name'] = $k;
                $updata['value'] = $v;
                $this->myDb->name('admin_config')->where($where)->update($updata);
            }
            return $this->success('配置成功');
        }else{
            $this->tab_data['current'] = url('admin/system/video');
            $info= $this->myDb->name('admin_config')->where($where)->field('name,value')->select();
            $config = array();
            foreach ($info as $k => $v){
                $config[$v['name']] = $v['value'];
            }
            $this->assign('config', $config);
            $this->assign('tab_data', $this->tab_data);
            return $this->fetch();
        }
    }

    public function advert()
    {
        return $this->fetch();
    }

    public function commission()
    {
        $where['group'] = 'commission';
        if ($this->request->isPost()) {
            $config = $this->request->post();
			$config['three_level_distributor_on'] = isset($config['three_level_distributor_on']) ? 1:0;
            foreach ($config as $k => $v){
                $where['name'] = $k;
                $updata['value'] = $v;
                $this->myDb->name('admin_config')->where($where)->update($updata);
            }
            return $this->success('配置成功');
        }else{
            $this->tab_data['current'] = url('admin/system/commission');
            $config = $this->myDb->name('admin_config')->where($where)->column('name,value');
            $this->assign('config', $config);
            $this->assign('tab_data', $this->tab_data);
            return $this->fetch();
        }
    }

    /**
     * 附件配置
     * @author XiangZhanYou ©2016
     * @return mixed
     */
    public function attachment(Request $request){
        $where['group'] = 'attachment';
        if ($this->request->isPost()) {
            $config = $request->post();
            foreach ($config as $k => $v){
                $where['name'] = $k;
                $updata['value'] = $v;
                $this->myDb->name('admin_config')->where($where)->update($updata);
            }
            return $this->success('配置成功');
        }else{
            $this->tab_data['current'] = url('admin/system/attachment');
            $info= $this->myDb->name('admin_config')->where($where)->field('name,value')->select();
            $config = array();
            foreach ($info as $k => $v){
                $config[$v['name']] = $v['value'];
            }
            $this->assign('config', $config);
            $this->assign('tab_data', $this->tab_data);

            return $this->fetch();
        }
    }

    /**
     * 邮件配置
     * @author FengRuSheng ©2016
     * @return mixed
     */
    public function email(Request $request)
    {
        $where['group'] = 'email';
        if ($this->request->isPost()) {
            $config = $request->post();
            foreach ($config as $k => $v){
                $where['name'] = $k;
                $updata['value'] = $v;
                $this->myDb->name('admin_config')->where($where)->update($updata);
            }
            return $this->success('配置成功');
        }else{
            $this->tab_data['current'] = url('admin/system/email');
            $config = $this->myDb->name('admin_config')->where($where)->column('name,value');
            $this->assign('config', $config);
            $this->assign('tab_data', $this->tab_data);
            return $this->fetch();
        }

    }

    /**
     * 短信配置
     * @author FengRuSheng ©2016
     * @return mixed
     */
    public function sms(Request $request)
    {
        $where['group'] = 'sms';
        if ($this->request->isPost()) {
            $config = $request->post();
            foreach ($config as $k => $v){
                $where['name'] = $k;
                $updata['value'] = $v;
                $this->myDb->name('admin_config')->where($where)->update($updata);
            }
            return $this->success('配置成功');
        }else{
            $this->tab_data['current'] = url('admin/system/sms');
            $config = $this->myDb->name('admin_config')->where($where)->column('name,value');
            $this->assign('config', $config);
            $this->assign('tab_data', $this->tab_data);
            return $this->fetch();
        }

    }

   /**
     * 采集配置
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function gather()
    {
        $where['group'] = 'gather';
        if ($this->request->isPost()) {
            $config = $this->request->post();
			$config['resource_gather_status'] = isset($config['resource_gather_status']) ? 1:0;
			$config['resource_gather_video_need_review'] = isset($config['resource_gather_video_need_review']) ? 1:0;
			$config['resource_gather_novel_need_review'] = isset($config['resource_gather_novel_need_review']) ? 1:0;
			$config['resource_gather_atlas_need_review'] = isset($config['resource_gather_atlas_need_review']) ? 1:0;
            foreach ($config as $k => $v){
                $where['name'] = $k;
                $updata['value'] = $v;
                $this->myDb->name('admin_config')->where($where)->update($updata);
            }
            return $this->success('配置成功');
        }else{
            $this->tab_data['current'] = url('admin/system/gather');
            $info= $this->myDb->name('admin_config')->where($where)->field('name,value')->select();
            $config = array();
            foreach ($info as $k => $v){
                $config[$v['name']] = $v['value'];
            }
            $this->assign('config', $config);
            $this->assign('tab_data', $this->tab_data);
            return $this->fetch();
        }
    }
    /**
     * 工具集
     */
    public function tools(){
        $web_server_url=$this->myDb->name('admin_config')->where("name='web_server_url'")->find();
        $web_server_url=$web_server_url?$web_server_url['value']:'';
        $this->assign('web_server_url',$web_server_url);

        $this->assign('tab_type',0);
        return $this->fetch();
    }

    /** is_withdrawals:on
     * 云转码自动转码设置
     */
    public function syncAddVideo(Request $request){
        if ($this->request->isPost()) {
            $config = $request->post();
            $config['sync_add_video_need_review']=isset($config['sync_add_video_need_review']) ? 1:0;
            foreach ($config as $k => $v){
                $where['name'] = $k;
                $updata['value'] = $v;
                $this->myDb->name('admin_config')->where($where)->update($updata);
            }
            return $this->success('配置成功');
			}else{

            $class=$this->myDb->name('class');
            $classlist=$class->where(['type'=>1,'pid'=>0])->select();
            foreach ($classlist as $k=>$v){
                $classlist[$k]['childs']=$class->where(['pid'=>$v['id']])->select();
            }
            $this->assign('classlist',$classlist);

            $this->tab_data['current'] = url('admin/system/syncAddVideo');
            $config = $this->myDb->name('admin_config')->where("`group`='video'")->column('name,value');
            $this->assign('config', $config);
            $this->assign('tab_data', $this->tab_data);
            return $this->fetch();
        }
    }

    /** 友情链接 */
    public function friendLink(Request $request){
        if($request->isPost()){
            $config = $request->post();
            foreach ($config as $k => $v){
                $where['name'] = $k;
                $updata['value'] = $v;
                $this->myDb->name('admin_config')->where($where)->update($updata);
            }
            return $this->success('配置成功');
        }

        $this->tab_data['current'] = url('admin/system/friendLink');
        $this->assign('tab_data', $this->tab_data);

        $config = $this->myDb->name('admin_config')->where("`group`='base'")->column('name,value');
        $this->assign('config', $config);

        return $this->fetch();
    }
}

