<?php
if (!(defined('IN_IA')))
{
	exit('Access Denied');
}

class Web_App extends Web_Base
{
    /**
     * 短信设置
     */
    public function seting()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        $result=pdo_fetch("SELECT * FROM ".tablename('ox_master_code')." where `uniacid`={$_W['uniacid']} limit 1");
        if($_W['ispost']){
            $data=array();
            $data['appid']=$_GPC['appid'];
            $data['uniacid']=$_W['uniacid'];
            $data['appkey']=$_GPC['appkey'];
            $data['sign']=$_GPC['sign'];
            $data['status']=$_GPC['status'];
            if(!empty($result)){
                $res=pdo_update('ox_master_code',$data,array('uniacid'=>$uniacid));
            }else{
                $res=pdo_insert('ox_master_code',$data);
            }
            return $this->result(0,'保存成功','');
        }
        $tmp = pdo_get('ox_master_code_config',['uniacid'=> $_W['uniacid'],'type' => 1]);
        $result = [
            'detail' => $result,
            'templateId' => $tmp['templateId']
        ];
        return $this->result(0,'',$result);
    }
    /**
     * 短信设置
     */
    public function seting1()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        $result=pdo_get('ox_master_code_config',['uniacid'=> $_W['uniacid'],'type' => 1]);;
        $data = [
            'uniacid' => $_W['uniacid'],
            'type' => 1,
            'templateId' => $_GPC['templateId']
        ];
        if(!empty($result)){
            $res=pdo_update('ox_master_code_config',['templateId' => $_GPC['templateId']],array('uniacid'=>$uniacid,'type' => 1));
        }else{
            $res=pdo_insert('ox_master_code_config',$data);
        }
        return $this->result(0,'',$result);
    }

    /**
     * 推送设置
     */
    public function unipush()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        $result=pdo_fetch("SELECT * FROM ".tablename('ox_master_unipush')." where `uniacid`={$_W['uniacid']} limit 1");
        if($_W['ispost']){
            $data=array();
            $data['appid']=$_GPC['appid'];
            $data['uniacid']=$_W['uniacid'];
            $data['appkey']=$_GPC['appkey'];
            $data['mastersecret']=$_GPC['mastersecret'];
            $data['appsecret']=$_GPC['appsecret'];
            if(!empty($result)){
                $res=pdo_update('ox_master_unipush',$data,array('uniacid'=>$uniacid));
            }else{
                $res=pdo_insert('ox_master_unipush',$data);
            }
            return $this->result(0,'保存成功','');
        }
        return $this->result(0,'',$result);
    }
    /**
     * 推送
     */
    public function push(){
       // echo Oxcode::Instance()->phpqrcode('sdfs');
        echo Oxcode::Instance()->getwxacodeunlimit();
        die;
        Unipush::Instance()->pushMessageToApp();//(['name' => '王士杰','cid' => '230ffaebe5a4bc912d6ccc61c7646076']);
    }
    public function templateList(){
        global $_GPC, $_W;
        $pageSize = $_GPC['limit'] ?: 20;
        $pageCur = $_GPC['page'] ?: 1;
        $query = '';
        $basis = new Basis();
        $basis->initSmsTemplate();
        $list=pdo_fetchall("select * from ".tablename('ox_master_sms_template')."  where `uniacid`= {$_W['uniacid']}  {$query} order by template_id desc LIMIT " . ($pageCur - 1) * $pageSize . ",{$pageSize}");
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_master_sms_template')."  where `uniacid`= {$_W['uniacid']} {$query}  ");

        $total = intval($total);

        $result = [
            'list' => $list,
            'total' => $total,
        ];
        return $this->result('0','sufcc',$result);
    }

    /**
     * 保存模板
     */
    public function editTemplate(){
        global $_GPC, $_W;
        if(!isset($_GPC['template_id'])){
            return $this->result('1',  '系统错误', '');
        }
        $data=[];
        if(isset($_GPC['template_title'])&&$_GPC['template_title']){
            $data['template_title'] = $_GPC['template_title'];
        }
        if(!empty($data)){
            $res =pdo_update('ox_master_sms_template',$data,['template_id'=>$_GPC['template_id']]);
            if($res){
                return $this->result('0',  '操作成功', $res);
            }else{
                return $this->result('1',  '操作失败', $res);
            }
        }else{
            return $this->result('1',  '操作失败', '');
        }
    }
    /**
     * 公众号模板详情
     */
    public function uniformDetail(){
        global $_GPC, $_W;
        $detail = pdo_get('ox_master_uniform',['uniacid' => $_W['uniacid']]);
        $template = pdo_get('ox_master_uniform_template',['uniacid' => $_W['uniacid']]);
        $result = [
            'detail' => $detail,
            'template' => $template
        ];
        return $this->result('1',  '', $result);
    }
    /**
     * 公众号模板设置
     */
    public function uniformSet(){
        global $_GPC, $_W;
        $detail = pdo_get('ox_master_uniform',['uniacid' => $_W['uniacid']]);
        $template = pdo_get('ox_master_uniform_template',['uniacid' => $_W['uniacid']]);
        if($detail){
            pdo_update('ox_master_uniform',['appid' => $_GPC['appid'],'status' => $_GPC['status']],['uniacid' => $_W['uniacid']]);
        }else{
            pdo_insert('ox_master_uniform',['appid' => $_GPC['appid'],'status' => $_GPC['status'],'uniacid' => $_W['uniacid']]);
        }
        if($template){
            pdo_update('ox_master_uniform_template',['appid' => $_GPC['wxappid'],'first' => $_GPC['first'],'remark' => $_GPC['remark'],'template_id' => $_GPC['template_id']],['uniacid' => $_W['uniacid']]);
        }else{
            pdo_insert('ox_master_uniform_template',['appid' => $_GPC['wxappid'],'first' => $_GPC['first'],'remark' => $_GPC['remark'],'uniacid' => $_W['uniacid'],'template_id' => $_GPC['template_id']]);
        }
        return $this->result('1',  '保存成功', '');
    }

}

?>