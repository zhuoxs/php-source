<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$system=pdo_get('yzmdwsc_sun_system',array('uniacid'=>$_W['uniacid']));
function getContent($name){
	 $content = false;
        switch ($name) {
            case 'banner': {
                $content ='<div class="home-block"><div class="block-content"><div class="block-name">轮播图</div></div><img class="block-img" src="/addons/yzmdwsc_sun/static/statics/indexlayout/banner.png"></div>';
                break;
            }
            case 'notice': {
                $content ='<div class="home-block"><div class="block-content"><div class="block-name">公告</div></div><img class="block-img" src="/addons/yzmdwsc_sun/static/statics/indexlayout/notice.png"></div>';
                break;
            }
            case 'icons': {
                $content ='<div class="home-block"><div class="block-content"><div class="block-name">导航图标</div></div><img class="block-img" src="/addons/yzmdwsc_sun/static/statics/indexlayout/icons.png"></div>';
                break;
            }
            case 'shopmsg': {
                $content ='<div class="home-block"><div class="block-content"><div class="block-name">欢迎语客服</div></div><img class="block-img" src="/addons/yzmdwsc_sun/static/statics/indexlayout/shopmsg.png"></div>';
                break;
            }
            case 'coupon': {
                $content ='<div class="home-block"><div class="block-content"><div class="block-name">优惠券</div></div><img class="block-img" src="/addons/yzmdwsc_sun/static/statics/indexlayout/coupon.png"></div>';
                break;
            }
            case 'yuyue': {
                $content ='<div class="home-block"><div class="block-content"><div class="block-name">预约</div></div><img class="block-img" src="/addons/yzmdwsc_sun/static/statics/indexlayout/yuyue.png"></div>';
                break;
            }
            case 'haowu': {
                $content ='<div class="home-block"><div class="block-content"><div class="block-name">好物</div></div><img class="block-img" src="/addons/yzmdwsc_sun/static/statics/indexlayout/haowu.png"></div>';
                break;
            }
            case 'groups': {
                $content ='<div class="home-block"><div class="block-content"><div class="block-name">拼团</div></div><img class="block-img" src="/addons/yzmdwsc_sun/static/statics/indexlayout/groups.png"></div>';
                break;
            }
            case 'bargain': {
                $content ='<div class="home-block"><div class="block-content"><div class="block-name">砍价</div></div><img class="block-img" src="/addons/yzmdwsc_sun/static/statics/indexlayout/bargain.png"></div>';
                break;
            }
            case 'xianshigou': {
                $content ='<div class="home-block"><div class="block-content"><div class="block-name">限时购</div></div><img class="block-img" src="/addons/yzmdwsc_sun/static/statics/indexlayout/xianshigou.png"></div>';
                break;
            }
            case 'share': {
                $content ='<div class="home-block"><div class="block-content"><div class="block-name">分享</div></div><img class="block-img" src="/addons/yzmdwsc_sun/static/statics/indexlayout/share.png"></div>';
                break;
            }
           case 'xinpin': {
                $content ='<div class="home-block"><div class="block-content"><div class="block-name">新品推荐</div></div><img class="block-img" src="/addons/yzmdwsc_sun/static/statics/indexlayout/xinpin.png"></div>';
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
            'name' => 'shopmsg',
            'display_name' => '欢迎语客服',
        ],
 		[
            'name' => 'coupon',
            'display_name' => '优惠券',
        ],
  		[
            'name' => 'yuyue',
            'display_name' => '预约',
        ],
 		[
            'name' => 'haowu',
            'display_name' => '好物',
        ],
  		[
            'name' => 'groups',
            'display_name' => '拼团',
        ],
  		[
            'name' => 'bargain',
            'display_name' => '砍价',
        ],
  		[
            'name' => 'xianshigou',
            'display_name' => '限时购',
        ],
 	 	[
            'name' => 'share',
            'display_name' => '分享',
        ],
  		[
            'name' => 'xinpin',
            'display_name' => '新品推荐',
        ],
];
foreach ($module_list as $i => $item) {
     $content =getContent($item['name']);
     $module_list[$i]['content'] = $content ? $content : '<div style="padding: 1rem;text-align: center;color: #888">无内容</div>';
}
 $module_list=json_encode($module_list); 


$index_layout=pdo_getcolumn('yzmdwsc_sun_system', array('uniacid' => $_W['uniacid']), 'index_layout',1);
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
           	 pdo_update('yzmdwsc_sun_system', $data, array('id' => $system['id']));
           }else{
			 pdo_insert('yzmdwsc_sun_system',$data);
           }
           $msg=array(
             'code' => 0,
             'msg' => '保存成功',
           );
           echo json_encode($msg);
           exit;
        /*    if($_GPC['id']==''){                
                $res=pdo_insert('yzmdwsc_sun_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('settings',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('yzmdwsc_sun_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('settings',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }*/
        }
include $this->template('web/indexlayout');