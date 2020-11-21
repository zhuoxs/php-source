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

use app\common\controller\Common;
use app\admin\model\AdminMenu as MenuModel;
use app\admin\model\AdminRole as RoleModel;
use app\admin\model\AdminUser as UserModel;
use app\admin\model\AdminLog as LogModel;
use think\Db;
/**
 * 后台公共控制器
 * @package app\admin\controller
 */
class Admin extends Common
{
    /**
     * 初始化方法
     */
    protected function _initialize()
    {
        parent::_initialize();
        $model = new UserModel();
        // 判断登陆
        $login = $model->isLogin();
        if (!$login['uid']) {
            return $this->error('请登陆之后在操作！', ROOT_DIR.config('sys.admin_path'));
        }
       if(!defined('ADMIN_ID')) define('ADMIN_ID', $login['uid']);
        if(!defined('ADMIN_ROLE')) define('ADMIN_ROLE', $login['role_id']);
        $c_menu = MenuModel::getInfo();

        if (!$c_menu) {
            return $this->error('节点不存在或者已禁用！');
        }
        // 检查权限
        if (!RoleModel::checkAuth($c_menu['id'])) {
            $url = '';
            // 如果没有后台首页的登录权限，直接退出，避免出现死循环跳转
            if ($c_menu['url'] == 'admin/index/index') {
                $url = ROOT_DIR.config('sys.admin_path');
                model('AdminUser')->logout();
            }
            return $this->error('['.$c_menu['title'].'] 访问权限不足', $url);
        }


        // 系统日志记录
        $log = [];
        $log['uid'] = ADMIN_ID;
        $log['title'] = $c_menu['title'];
        $log['url'] = $c_menu['url'];
        $log['param'] = json_encode(input('param.'));
        $log['remark'] = '浏览数据';
        if ($this->request->isPost()) {
            $log['remark'] = '保存数据';
        }
        $log_result = LogModel::where($log)->find();
        $log['ip'] = $this->request->ip();
        if (!$log_result) {
            LogModel::create($log);
        } else {
            $log['id'] = $log_result->id;
            $log['count'] = $log_result->count+1;
            LogModel::update($log);
        }
        $verson=DB::name('version_role')->where(['id'=>$login['version']])->find();
        $login['version']=$verson['name'];
        // 如果不是ajax请求，则读取菜单
        if (!$this->request->isAjax()) {
            // 获取当前访问的节点信息
            $this->assign('_admin_menu_current', $c_menu);
            $_bread_crumbs = MenuModel::getBrandCrumbs($c_menu['id']);
            $this->assign('_bread_crumbs', $_bread_crumbs);
            // 获取当前访问的节点的顶级节点
            $this->assign('_admin_menu_parents', current($_bread_crumbs));
            // 获取导航菜单
            $this->assign('_admin_menu', MenuModel::getMainMenu());
            // 分组切换类型 0单个分组[有链接]，1分组切换[有链接]，2分组切换[无链接]，3无需分组切换，具体请看后台layout.php
            $this->assign('tab_type', 0);
            $this->assign('tab_data', '');
            // 列表页默认数据输出变量
            $this->assign('data_list', '');
            $this->assign('pages', '');
            // 编辑页默认数据输出变量
            $this->assign('data_info', '');
            $this->assign('admin_user', $login);
            $this->assign('languages', model('AdminLanguage')->lists());
        }
    }

    /**
     * 获取当前方法URL
     * @author frs whs tcl dreamer ©2016
     * @return string
     */
    protected function getActUrl() {
        $model      = request()->module();
        $controller = request()->controller();
        $action     = request()->action();
        return $model.'/'.$controller.'/'.$action;
    }

    /**
     * 通用状态设置
     * 禁用、启用都是调用这个内部方法
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function status() {
        $val   = input('param.val');
        $ids   = input('param.ids/a') ? input('param.ids/a') : input('param.id/a');
        $table = input('param.table');
        $field = input('param.field', 'status');
        if (empty($ids)) {
            return $this->error('参数传递错误[1]！');
        }
        if (empty($table)) {
            return $this->error('参数传递错误[2]！');
        }
        // 以下表操作需排除值为1的数据
        if ($table == 'admin_menu' || $table == 'admin_user' || $table == 'admin_role' || $table == 'admin_module') {
            if (in_array('1', $ids) || ($table == 'admin_menu' && in_array('2', $ids))) {
                return $this->error('系统限制操作');
            }
        }


         // 获取主键
        $pk = $this->myDb->name($table)->getPk();
        $map = [];
        $map[$pk] = ['in', $ids];
        if ($table == 'comment' ) {
            $this->myDb->name($table)->where($map)->setField('last_time', time());
        }
        if ($table == 'agent_apply'){
            $last_time = time();
            $datas[$field] = $val;
            $datas['last_time'] = $last_time;
            $user_id = $this->myDb->name($table)->where($map)->field('user_id')->select();
            $id_array = array();
            foreach ($user_id as $k => $v){
                $id_array[] = $v['user_id'];
            }
            $where['id'] = ['in', $id_array];
            $agenData = array(
                'is_agent' => ($val==1) ? $val : 0,
            );
            $user_info  = $this->myDb->name('member')->where($where)->update($agenData);
            $res = $this->myDb->name($table)->where($map)->update($datas);
        }else{
            $res = $this->myDb->name($table)->where($map)->setField($field, $val);
        }

        if ($res === false) {
            return $this->error('状态设置失败');
        }
        return $this->success('状态设置成功');
    }

    /**
     * 客户数据库通用状态设置
     * 禁用、启用都是调用这个内部方法
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function khstatus() {
        $val   = input('param.val');
        $ids   = input('param.ids/a') ? input('param.ids/a') : input('param.id/a');
        $table = input('param.table');
        $field = input('param.field', 'status');
        if (empty($ids)) {
            return $this->error('参数传递错误[1]！');
        }
        if (empty($table)) {
            return $this->error('参数传递错误[2]！');
        }
        // 以下表操作需排除值为1的数据
        if ($table == 'admin_menu' || $table == 'admin_user' || $table == 'admin_role' || $table == 'admin_module') {
            if (in_array('1', $ids) || ($table == 'admin_menu' && in_array('2', $ids))) {
                return $this->error('系统限制操作');
            }
        }
        // 获取主键
        $pk = $this->myDb->name($table)->getPk();
        $map = [];
        $map[$pk] = ['in', $ids];

        $res = $this->myDb->name($table)->where($map)->setField($field, $val);
        if ($res === false) {
            return $this->error('状态设置失败');
        }
        return $this->success('状态设置成功');
    }
    /**
     * 通用删除
     * 单纯的记录删除
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function del() {
        $ids   = input('param.ids/a') ? input('param.ids/a') : input('param.id/a');
        $table = input('param.table');
        if (empty($ids)) {
            return $this->error('无权删除(原因：可能您选择的是系统菜单)');
        }
        // 禁止以下表通过此方法操作
        if ($table == 'admin_user' || $table == 'admin_role') {
            return $this->error('非法操作');
        }

        // 以下表操作需排除值为1的数据
        if ($table == 'admin_menu' || $table == 'admin_module') {
            if ((is_array($ids) && in_array('1', $ids))) {
                return $this->error('禁止操作');
            }
        }
            
        // 获取主键
        $pk = $this->myDb->name($table)->getPk();
        $map = [];
        $map[$pk] = ['in', $ids];

        $res = $this->myDb->name($table)->where($map)->delete();
        if ($res === false) {
            return $this->error('删除失败');
        }
        return $this->success('删除成功');
    }

    /**
     * 客户数据库通用删除 whs
     * 单纯的记录删除
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function khdel($classtype='0') {

        $ids   = input('param.ids/a') ? input('param.ids/a') : input('param.id/a');
        $table = input('param.table');
        $type = input('param.type');

        if (empty($ids)) {
            return $this->error('无权删除(原因：可能您选择的是系统菜单)');
        }
        // 禁止以下表通过此方法操作
        if ($table == 'admin_user' || $table == 'admin_role') {
            return $this->error('非法操作');
        }

        // 以下表操作需排除值为1的数据
        if ($table == 'admin_menu' || $table == 'admin_module') {
            if ((is_array($ids) && in_array('1', $ids))) {
                return $this->error('禁止操作');
            }
        }

        // 获取主键
        $pk = $this->myDb->name($table)->getPk();
        $map = [];
        $map[$pk] = ['in', $ids];
        //删除图册的时候
        if($table=='atlas'){
            $where['atlas_id']=['in', $ids];
            $resu = $this->myDb->name('image')->where($where)->delete();
        }
        if($table=='advertisement_position'){
            $where['atlas_id']=['position_id', $ids];
            $resu = $this->myDb->name('advertisement')->where($where)->delete();
        }
        if($type=='gather'&&strtolower($table)=='video'){
            $pid=$this->myDb->name($table)->where($map)->field("pid")->find();
            $res = $this->myDb->name($table)->where($map)->setField("pid",0);
            //组装视频集数信息
            $dataid=$this->myDb->name($table)->where('pid',$pid['pid'])->field('id')->select();
            $insertids=null;
            foreach ($dataid as $v)
            {
                $insertids.=$v['id'].',';
            }
            $insertids=rtrim($insertids,',');
            $this->myDb->name($table)->where(['id'=>$pid['pid']])->setField("diversity_data",$insertids);

        }elseif ($type=='gathers'&&strtolower($table)=='video'){
            $pid=$this->myDb->name($table)->where($map)->field("id")->find();
            $res = $this->myDb->name($table)->where(['pid'=>$pid['id']])->setField("pid",0);
            $res = $this->myDb->name($table)->where($map)->delete();
        }elseif ($table=='class' && $classtype!='0'){//删除分类
            $where['class']=['in', $ids];
            $class_table='video';
            switch ($classtype){
                case '1':
                    $class_table='video';break;
                case '2':
                    $class_table='atlas';break;
                case '3':
                    $class_table='novel';break;
            }

           $reslut= $this->myDb->name($class_table)->where($where)->find();
           if($reslut){
               $res=false;
               return $this->error('删除失败,请删除分类下的子视频后再试');
           }else{
               $res = $this->myDb->name($table)->where($map)->delete();
               $res=true;
           }
        }else{
            $res = $this->myDb->name($table)->where($map)->delete();
        }

        if ($res === false) {
            return $this->error('删除失败');
        }
        return $this->success('删除成功');
    }

    /**
     * 通用排序
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function sort() {
        $ids   = input('param.ids/d') ? input('param.ids/d') : input('param.id/d');
        $table = input('param.table');
        $field = input('param.field/s', 'sort');
        $val   = input('param.val/d');
        // 获取主键
        $pk = $this->myDb->name($table)->getPk();
        $map = [];
        $map[$pk] = ['in', $ids];
        $res = $this->myDb->name($table)->where($map)->setField($field, $val);
        if ($res === false) {
            return $this->error('排序设置失败');
        }
        return $this->success('排序设置成功');
    }
    /**
     * 客户数据库通用排序 whs
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function khsort() {
        $ids   = input('param.ids/d') ? input('param.ids/d') : input('param.id/d');
        $table = input('param.table');
        $field = input('param.field/s', 'sort');
        $val   = input('param.val/d');
        // 获取主键
        $pk = $this->myDb->name($table)->getPk();
        $map = [];
        $map[$pk] = ['in', $ids];
        $res = $this->myDb->name($table)->where($map)->setField($field, $val);
        if ($res === false) {
            return $this->error('排序设置失败');
        }
        return $this->success('排序设置成功');
    }

    /**
     * 客户数据库通用状态设置 审核
     * 禁用、启用都是调用这个内部方法
     * @author frs whs tcl dreamer ©2016
     * @return mixed
     */
    public function check() {
        $val   = input('param.val');
        $ids   = input('param.ids/a') ? input('param.ids/a') : input('param.id/a');
        $table = input('param.table');
        $field = input('param.field', 'is_check');
        if (empty($ids)) {
            return $this->error('参数传递错误[1]！');
        }
        if (empty($table)) {
            return $this->error('参数传递错误[2]！');
        }
        // 以下表操作需排除值为1的数据
        if ($table == 'admin_menu' || $table == 'admin_user' || $table == 'admin_role' || $table == 'admin_module') {
            if (in_array('1', $ids) || ($table == 'admin_menu' && in_array('2', $ids))) {
                return $this->error('系统限制操作');
            }
        }
        // 获取主键
        $pk = $this->myDb->name($table)->getPk();
        $map = [];
        $map[$pk] = ['in', $ids];

        $res = $this->myDb->name($table)->where($map)->setField($field, $val);
        if ($res === false) {
            return $this->error('状态设置失败');
        }
        return $this->success('状态设置成功');
    }
    /**
     * 操作跳转的快捷方法
     * @access protected
     * @param mixed $msg 提示信息
     * @param string $url 跳转的URL地址要带http格式的完整网址
     * @param integer $icon 1为正确 2为错误
     * @param integer $wait 跳转等待时间
     * @param integer $type 提示完成的回调处理 1为当前界面的处理 2为子层处理，关闭子层并且刷新父层
     * @return void
     */
    function layerJump($msg = '', $icon = 1, $type = 1, $wait = 1, $url = 'null')
    {
        $script = '';
        $script .= '<script>';
        $script .= "parent.layer.msg('$msg', {icon: $icon, time: $wait*1000},function(){";
        if ($type == 2) {
            $script .= 'window.parent.location.reload();';
            $script .= 'parent.layer.close(index);';
        } elseif ($type == 1) {
            if (empty($url) || $url == 'null') {
                $script .= 'location.reload();';
            } else {
                $script .= "window.location.href='$url';";
            }
        } else {
            $script .= 'history.go(-1);';
        }
        $script .= '});';
        $script .= '</script>';
        echo $script;
    }
}
