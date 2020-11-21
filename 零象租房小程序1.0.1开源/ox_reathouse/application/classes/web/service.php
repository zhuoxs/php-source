<?php
if (!(defined('IN_IA')))
{
    exit('Access Denied');
}

class Web_Service extends Web_Base
{

    public function type()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        $pindex = $_GPC['page'] ?: 1;
        $psize = $_GPC['limit'] ?: 20;
        $list=pdo_fetchall("select * from ".tablename('ox_reathouse_reath_type')." where `uniacid`='$uniacid'   order by sort desc LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_reathouse_reath_type')." where `uniacid`='$uniacid'  ");
        foreach ($list as $k => $v){
            $list[$k]['path'] = tomedia($v['icon']);
            $list[$k]['content'] = htmlspecialchars_decode($v['content']);
        }
        $result = [
            'list' => $list,
            'total' => intval($total)
        ];
        return $this->result('0','sufcc',$result);
    }




    public function type_add()
    {
        global $_W,$_GPC;
        $data=[
            'name' => $_GPC['name'],
            'sort' => $_GPC['sort'],
            'uniacid' => $_W['uniacid'],
            'icon' => $_GPC['icon'],
        ];
        if($_GPC['radio'] == 1){
            $data['href'] = $_GPC['href'];
            $data['content'] = '';
        }elseif($_GPC['radio'] == 2){
            $data['href'] = '';
            $data['content'] = $_GPC['content'];
        }
        if($_GPC['id']){
            pdo_update('ox_reathouse_reath_type',$data,['id' =>$_GPC['id']]);
        }else{
            $data['create_time'] = $_SERVER['REQUEST_TIME'];
            $res=pdo_insert('ox_reathouse_reath_type',$data);
        }

        return $this->result('0','sufcc',$_GPC);
    }

    /*
    * 删除分类
     */
    public function type_del()
    {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        if($_GPC['id']){
            $id=$_GPC['id'];
            $data=pdo_delete('ox_reathouse_reath_type',array('id'=>$id,'uniacid'=>$uniacid));
            if ($data) {
                return $this->result('0','删除成功',$_GPC);
            }else
            {
                return $this->result('23','删除失败',$_GPC);
            }
        }
    }
    /**
     * 导航详情
     */
    public function getNavDetail(){
        global $_W,$_GPC;
        if($_GPC['id']){
            $data=pdo_get('ox_reathouse_reath_type',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
            if($data && $data['href']){
                $data['radio'] = '1';
            }elseif($data && $data['content']){
                $data['radio'] = '2';
            }
            if($data && $data['icon']){
                $data['imgList'][] = ['name' =>$data['icon'],'url' => tomedia($data['icon']) ];
                $data['content'] = htmlspecialchars_decode($data['content']);
            }
            return $this->result('0','删除成功',$data);
        }
    }

}

?>