<?php
if (!(defined('IN_IA')))
{
	exit('Access Denied');
}

class Web_Baseset extends Web_Base
{
    /**
     * 小程序设置
     */
    public function seting()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        $result=pdo_fetch("SELECT * FROM ".tablename('ox_master')." where `uniacid`={$_W['uniacid']} limit 1");
        if($_W['ispost']){
            $data=array();
            $data['name']=$_GPC['name'];
            $data['uniacid']=$_W['uniacid'];
            $data['logo']=$_GPC['logo'];
            $data['phone']=$_GPC['phone'];
            $data['price']=$_GPC['price'];
            $data['covers_img']=$_GPC['covers_img'];
            $data['service_name']=$_GPC['service_name'];
            $data['enter_title']=$_GPC['enter_title'];
            $data['enter_status']=$_GPC['enter_status'] == 'true' ? 1 : 0;
            $data['auto_status']=$_GPC['auto_status'] == 'true' ? 1 : 0;
            $data['points']=$_GPC['points'];
            $data['full_num']=$_GPC['full_num'];
            $data['type_num']=$_GPC['type_num'];
            $data['tip']=$_GPC['tip'];
            $data['qq_map_key']=$_GPC['qq_map_key'];
            $data['min_cash']=$_GPC['min_cash'];
            $data['notify_rule']=$_GPC['notify_rule'];
            $data['distance']=$_GPC['distance'];
            if(!empty($result)){
                $res=pdo_update('ox_master',$data,array('uniacid'=>$uniacid));
            }else{
                $res=pdo_insert('ox_master',$data);
            }
            return $this->result(0,'保存成功','');

        }
        if($result){
            $result['logo_path'] = tomedia($result['logo']);
            $result['enter_status'] = $result['enter_status'] == 1 ? true : false;
            $result['auto_status'] = $result['auto_status'] == 1 ? true : false;
        }
        return $this->result(0,'',$result);
    }

    /**
     * 消息模板设置
     */
    public function message() {
        global $_W, $_GPC;
        $arr = pdo_getall('ox_master_message', array('uniacid'=>$_W['uniacid']), array(), 'type');
        if ($_W['ispost']) {
            for ($i=1;$i<8;$i++){
                if($_GPC['message'.$i]){
                    if( isset($arr[$i])) {
                        $res = pdo_update('ox_master_message', ['content' => $_GPC['message'.$i]], array('uniacid'=>$_W['uniacid'], 'type'=>$i));
                    }else{
                        $data = array(
                            'uniacid' => $_W['uniacid'],
                            'content' => $_GPC['message'.$i],
                            'type' => $i,
                        );
                        $res = pdo_insert('ox_master_message', $data);
                    }
                }
            }
            return $this->result(0,'保存成功','');
        }
        return $this->result(0,'',$arr);
    }
    /**
     * 封面列表
     */
    public function banner(){
        global $_W;
        $list = pdo_getall('ox_master_banner', array('uniacid'=>$_W['uniacid']));
        foreach ($list as $k => $v){
            $list[$k]['path'] = tomedia($v['img']);
        }
        $result = [
            'list' => $list,
        ];
        return $this->result('0','sufcc',$result);
    }

    /**
     * 添加更改封面
     */
    public function editBanner(){
        global $_W, $_GPC;
        $params = [
            'img' => $_GPC['img'],
            'sort' => $_GPC['sort'],
            'uniacid' => $_W['uniacid'],
        ];
        if($_GPC['id']){
            $res = pdo_update('ox_master_banner', $params, array( 'id'=>$_GPC['id']));
            return $this->result('0','修改成功',$res);
        }else{
            $res = pdo_insert('ox_master_banner', $params);
            return $this->result('0','添加成功',$res);
        }

    }
    /**
     * 删除封面
     */
    public function deleteBanner(){
        global $_W, $_GPC;
        if($_GPC['id']){
            $id=$_GPC['id'];
            $data=pdo_delete('ox_master_banner',array('id'=>$id,'uniacid'=>$_W['uniacid']));
            if ($data) {
                return $this->result('0','删除成功',$_GPC);
            }else
            {
                return $this->result('23','删除失败',$_GPC);
            }
        }
    }

    /**
     * 反馈意见
     */
    public function suggest(){
        global $_W,$_GPC;
        $pindex = $_GPC['page'] ?: 1;
        $psize = $_GPC['limit'] ?: 20;
        $query = '';
        if($_GPC['date']){
            $begin = $_GPC['date'][0] / 1000;
            $end = $_GPC['date'][1] / 1000;
            $query .= " and create_time >{$begin} and create_time < {$end} ";
        }
        $list=pdo_fetchall("select * from ".tablename('ox_master_suggest')."  where `uniacid`= {$_W['uniacid']} {$query} order by id desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_master_suggest')."  where `uniacid`= {$_W['uniacid']} {$query}  ");
        $result = [
            'list' => $list,
            'total' => intval($total),
        ];
        return $this->result('0','sufcc',$result);
    }

    /**
     * 删除反馈意见
     */
    public function suggestDelete(){
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        if($_GPC['id']){
            $id=$_GPC['id'];
            $data=pdo_delete('ox_master_suggest',array('id'=>$id,'uniacid'=>$uniacid));
            if ($data) {
                return $this->result('0','删除成功',$_GPC);
            }else
            {
                return $this->result('23','删除失败',$_GPC);
            }
        }
    }

    /**
     * 批量删除
     */
    public function suggestDeleteAll(){
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        if($_GPC['ids']){
            $ids=explode(',',$_GPC['ids']);
            $data=pdo_delete('ox_master_suggest',array('id'=>$ids,'uniacid'=>$uniacid));
            if ($data) {
                return $this->result('0','删除成功',$_GPC);
            }else
            {
                return $this->result('23','删除失败',$_GPC);
            }
        }
    }
    /**
     * webview
     */
    public function webView(){
        global $_W, $_GPC;

        $params = [
            'uniacid' => $_W['uniacid'],
            'type' => $_GPC['type']
        ];
        $detail = pdo_get('ox_master_view',$params);
        if($_W['ispost']){
            if($detail){
                $result =  pdo_update('ox_master_view',['content' => $_GPC['content']],$params);
                return $this->result('0','保存成功',$result);
            }else{
                $params['content'] =  $_GPC['content'];
                $params['create_time'] =  $_SERVER['REQUEST_TIME'];
                $result =  pdo_insert('ox_master_view',$params);
                return $this->result('0','保存成功',$result);
            }

        }
        if($detail){
            $detail['content'] = htmlspecialchars_decode($detail['content']);
        }
        return $this->result('0','保存成功',$detail);
    }
    /**
     * 添加说明
     */
    public function addAbout(){
        global $_W, $_GPC;
        $params = [
            'uniacid' => $_W['uniacid'],
            'type' => 1,
            'id' => $_GPC['id']
        ];
        $data = [
            'uniacid' => $_W['uniacid'],
            'type' => 1,
            'content' =>  $_GPC['content'],
            'title'=>  $_GPC['title'],
            'sort' =>  $_GPC['sort'],
        ];
        $detail = pdo_get('ox_master_view',$params);
        if($_W['ispost']){
            if($detail){
                $result =  pdo_update('ox_master_view',$data,$params);
                return $this->result('0','保存成功',$result);
            }else{
                $data['create_time'] =  $_SERVER['REQUEST_TIME'];
                $result =  pdo_insert('ox_master_view',$data);
                return $this->result('0','保存成功',$result);
            }
        }
        if($detail){
            $detail['content'] = htmlspecialchars_decode($detail['content']);
        }
        return $this->result('0','保存成功',$detail);
    }

    /**
     * 关于我们列表
     */
    public function getAboutList(){
        global $_GPC, $_W;
        $list = pdo_getall('ox_master_view',['uniacid'=>$_W['uniacid'],'type'=>1],['id','title','content','sort'],'',['sort desc']);
        foreach ($list as $k => $v){
            $list[$k]['content'] = htmlspecialchars_decode($v['content']);
        }
        return $this->result(0, '', $list);
    }
    /***
     * 删除关于我们
     */
    public function deleteAbout(){
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        if($_GPC['id']){
            $id=$_GPC['id'];
            $data=pdo_delete('ox_master_view',array('id'=>$id,'uniacid'=>$uniacid));
            if ($data) {
                return $this->result('0','删除成功',$_GPC);
            }else
            {
                return $this->result('23','删除失败',$_GPC);
            }
        }
    }

}

?>