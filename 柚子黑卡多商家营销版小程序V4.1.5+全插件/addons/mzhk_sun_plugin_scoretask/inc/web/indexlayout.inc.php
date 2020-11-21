<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$system=pdo_get('mzhk_sun_system',array('uniacid'=>$_W['uniacid']));
function getContent($name){
	 $content = false;
        switch ($name) {
            case 'qzcard': {
                $content ='<div class="home-block"><div class="block-content"><div class="block-name">亲子卡</div></div><img class="block-img" src="/addons/mzhk_sun/static/statics/indexlayout/qzk.png"></div>';
                break;
            }
            case 'banner': {
                $content ='<div class="home-block"><div class="block-content"><div class="block-name">轮播图</div></div><img class="block-img" src="/addons/mzhk_sun/static/statics/indexlayout/banner.png"></div>';
                break;
            }
            case 'notice': {
                $content ='<div class="home-block"><div class="block-content"><div class="block-name">公告</div></div><img class="block-img" src="/addons/mzhk_sun/static/statics/indexlayout/notice.png"></div>';
                break;
            }
            case 'icons': {
                $content ='<div class="home-block"><div class="block-content"><div class="block-name">导航图标</div></div><img class="block-img" src="/addons/mzhk_sun/static/statics/indexlayout/icons.png"></div>';
                break;
            }
            case 'wyfee': {
                $content ='<div class="home-block"><div class="block-content"><div class="block-name">我要续费</div></div><img class="block-img" src="/addons/mzhk_sun/static/statics/indexlayout/wyfee.png"></div>';
                break;
            }

            case 'storyst': {
                $content ='<div class="home-block"><div class="block-content"><div class="block-name">试听故事会</div></div><img class="block-img" src="/addons/mzhk_sun/static/statics/indexlayout/storyst.png"></div>';
                break;
            }
            case 'storyzs': {
                $content ='<div class="home-block"><div class="block-content"><div class="block-name">专属故事库</div></div><img class="block-img" src="/addons/mzhk_sun/static/statics/indexlayout/storyzs.png"></div>';
                break;
            }
            case 'recommend': {
                $content ='<div class="home-block"><div class="block-content"><div class="block-name">推荐精选</div></div><img class="block-img" src="/addons/mzhk_sun/static/statics/indexlayout/recommend.png"></div>';
                break;
            }

            default: {
              $content=false;
              break;
            }
        }
       return $content;             
}
$module_list=[
        [
            'name' => 'qzcard',
            'display_name' => '亲子卡',
        ],
        [
            'name' => 'banner',
            'display_name' => '轮播图',
        ],
  		[
            'name' => 'notice', 
            'display_name' => '公告',
        ],
  		[
            'name' => 'icons',
            'display_name' => '导航图标',
        ],
        [
            'name' => 'wyfee',
            'display_name' => '我要续费',
        ],
        [
            'name' => 'storyst',
            'display_name' => '试听故事会',
        ],

        [
            'name' => 'recommend',
            'display_name' => '精选推荐',
        ],



];
foreach ($module_list as $i => $item) {
     $content =getContent($item['name']);
     $module_list[$i]['content'] = $content ? $content : '<div style="padding: 1rem;text-align: center;color: #888">无内容</div>';
}
 $module_list=json_encode($module_list); 


$index_layout=pdo_getcolumn('mzhk_sun_system', array('uniacid' => $_W['uniacid']), 'index_layout',1);
$edit_list=[];
if($index_layout){
	 $edit_list = json_decode($index_layout, true);
     $edit_list = $edit_list ? $edit_list:[];
}
foreach ($edit_list as $i => $item) {
     $content =getContent($item['name']);
     $edit_list[$i]['content'] = $content ? $content : '<div style="padding: 1rem;text-align: center;color: #888">无内容</div>';
}
$edit_list=json_encode($edit_list);

    if($_SERVER['REQUEST_METHOD']=='POST'){      
           $data['uniacid']=$_W['uniacid']; 
           $data['index_layout']=htmlspecialchars_decode($_GPC['module_list']);
           if($system){
           	 pdo_update('mzhk_sun_system', $data, array('id' => $system['id']));
           }else{
			 pdo_insert('mzhk_sun_system',$data);
           }
           $msg=array(
             'code' => 0,
             'msg' => '保存成功',
           );
           echo json_encode($msg);
           exit;
        /*    if($_GPC['id']==''){                
                $res=pdo_insert('mzhk_sun_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('settings',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('mzhk_sun_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('settings',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }*/
        }
include $this->template('web/indexlayout');