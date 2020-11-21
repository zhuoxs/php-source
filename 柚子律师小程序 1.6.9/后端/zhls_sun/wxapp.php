<?php

/**

 * 律师小程序模块小程序接口定义

 *


 * @url http://www.lanrenzhijia.com/

 */

defined('IN_IA') or exit('Access Denied');



class zhls_sunModuleWxapp extends WeModuleWxapp {
    //主分类
public function  doPageType(){
  global $_GPC, $_W;
  $res=pdo_getall('zhls_sun_type',array('uniacid'=>$_W['uniacid'],'state'=>1),array(),'','num asc');
  echo json_encode($res);
}
    //子分类
public function  doPageType2(){
  global $_GPC, $_W;
  $res=pdo_getall('zhls_sun_type2',array('type_id'=>$_GPC['id']),array(),'','num asc');
  echo json_encode($res);
}
    //发帖
public function doPagePosting(){
  global $_GPC, $_W;
  $system=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
        $data['details']=$_GPC['details'];//帖子内容
        $data['img']=$_GPC['img'];//帖子图片
        $data['user_id']=$_GPC['user_id'];//用户id
        $data['user_name']=$_GPC['user_name'];//姓名
        $data['user_tel']=$_GPC['user_tel'];//电话
        $data['type2_id']=$_GPC['type2_id'];//子分类id
        $data['type_id']=$_GPC['type_id'];//主分类id
        $data['money']=$_GPC['money'];//价格
        $data['top_type']=$_GPC['type'];//置顶类型
        $data['address']=$_GPC['address'];//帖子地址
         $data['store_id']=$_GPC['store_id'];
          $data['cityname']=$_GPC['cityname'];
        if($_GPC['type']){
         $data['top']=1;
       }else{
        $data['top']=2;
       }
       $data['time']=time();
       $data['uniacid']=$_W['uniacid'];
       if($system['tz_audit']==2){
        $data['sh_time']=time();
        $data['state']=2;
      }else{
        $data['state']=1;
      }
      $data['hb_money']=$_GPC['hb_money'];//红包金额
      $data['hb_num']=$_GPC['hb_num'];//红包个数
      $data['hb_type']=$_GPC['hb_type'];//红包类型1.普通 2.口令 
      $data['hb_keyword']=$_GPC['hb_keyword'];//红包口令
      $data['hb_random']=$_GPC['hb_random'];//随机1.是 2否
if($_GPC['hb_random']==1){
	function sendRandBonus($total=0, $count=3){

    $input     = range(0.01, $total, 0.01);
    if($count>1){
      $rand_keys = (array) array_rand($input, $count-1);
      $last    = 0;
      foreach($rand_keys as $i=>$key){
        $current  = $input[$key]-$last;
        $items[]  = $current;
        $last    = $input[$key];
      }
    }
    $items[]    = $total-array_sum($items);
  return $items;
}
    $hong=json_encode(sendRandBonus($_GPC['hb_money'],$_GPC['hb_num']));
    $data['hong']= $hong;
}

      $res=pdo_insert('zhls_sun_information',$data);
       $tz_id=pdo_insertid();
      $post_id=pdo_insertid();
      $a=json_decode(html_entity_decode($_GPC['sz']));
      $sz=json_decode(json_encode($a),true);
     // print_r($sz);die;
      if($res){
       for($i=0;$i<count($sz);$i++){
        $data2['label_id']=$sz[$i]['label_id'];
        $data2['information_id']=$post_id ;
        $res2=pdo_insert('zhls_sun_mylabel',$data2);
      }
      //echo '1';
      echo  $tz_id;
    }else{
      echo '2';
    }
  }

      //修改帖子
public function doPageUpdPost(){
        global $_GPC, $_W;
        $system=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
        $data['details']=$_GPC['details'];//帖子内容
        $data['img']=$_GPC['img'];//帖子图片
        $data['user_id']=$_GPC['user_id'];//用户id
        $data['user_name']=$_GPC['user_name'];//姓名
        $data['user_tel']=$_GPC['user_tel'];//电话
        $data['type2_id']=$_GPC['type2_id'];//子分类id
        $data['type_id']=$_GPC['type_id'];//主分类id
        $data['money']=$_GPC['money'];//价格
        $data['address']=$_GPC['address'];//帖子地址
        $data['store_id']=$_GPC['store_id'];
        $data['top_type']=$_GPC['top_type'];
        if($_GPC['top_type']){
            $data['top']=1;
        }
      
       $data['cityname']=$_GPC['cityname'];
       $data['time']=time();
       $data['uniacid']=$_W['uniacid'];
       if($system['tz_audit']==2){
        $data['sh_time']=time();
        $data['state']=2;
      }else{
        $data['state']=1;
      }
      $res=pdo_update('zhls_sun_information',$data,array('id'=>$_GPC['id']));
      pdo_delete('zhls_sun_mylabel',array('information_id'=>$_GPC['id']));
      $a=json_decode(html_entity_decode($_GPC['sz']));
      $sz=json_decode(json_encode($a),true);
     // print_r($sz);die;
      if($res){
         for($i=0;$i<count($sz);$i++){
          $data2['label_id']=$sz[$i]['label_id'];
          $data2['information_id']=$post_id ;
          $res2=pdo_insert('zhls_sun_mylabel',$data2);
        }
        echo '1';
      }else{
        echo '2';
      }
  }
//删除帖子
    public function doPageDelPost(){
        global $_GPC, $_W;
        $res=pdo_update('zhls_sun_information',array('del'=>1),array('id'=>$_GPC['id']));
        if($res){
            echo '1';
        }else{
            echo '2';
        }
    }






  //帖子点赞
  public function doPageLike(){
    global $_GPC, $_W;
    $data['information_id']=$_GPC['information_id'];
    $data['user_id']=$_GPC['user_id'];
    $res=pdo_get('zhls_sun_like',$data);
    if($res){
     echo  '不能重复点赞!';
   }else{
    pdo_insert('zhls_sun_like',$data);
    pdo_update('zhls_sun_information',array('givelike +='=>1),array('id'=>$_GPC['information_id']));
    echo '1';
  }

}
 //资讯点赞
  public function doPageZxLike(){
    global $_GPC, $_W;
    $data['zx_id']=$_GPC['zx_id'];
    $data['user_id']=$_GPC['user_id'];
    $res=pdo_get('zhls_sun_like',$data);
    if($res){
     echo  '不能重复点赞!';
   }else{
   $res2= pdo_insert('zhls_sun_like',$data);
    if($res2){
    	echo '1';
    }else{
    	echo  '2';
    }

  }

}
//资讯点赞头像
    public function doPageZxLikeImg(){
        global $_GPC, $_W;
        $zxid = $_GPC['zxid'];
        $sql = 'SELECT * FROM ' . tablename('zhls_sun_like') . ' l ' . ' JOIN ' .tablename('zhls_sun_user'). ' u '. ' ON ' . 'l.user_id=u.id' . ' WHERE ' . 'l.zx_id=' . $zxid  . ' LIMIT 0, 5';
        $zxImg = pdo_fetchall($sql);
        echo json_encode($zxImg);
    }

//资讯点赞人数
public function doPageZxLikeLength(){
    global $_GPC, $_W;
    $zxid = $_GPC['zxid'];
    $length = pdo_getall('zhls_sun_like',['zx_id'=>$zxid]);
    echo json_encode($length);
}
//资讯点赞列表
  public function doPageZxLikeList(){
    global $_GPC, $_W;
    $sql="select a.*,b.img as user_img ,b.name as user_name from " . tablename("zhls_sun_like") . " a"  . " left join " . tablename("zhls_sun_user") . " b on b.id=a.user_id  WHERE a.zx_id=:zx_id  ORDER BY a.id DESC";
  $res=pdo_fetchall($sql,array(':zx_id'=>$_GPC['zx_id']));
  echo json_encode($res);

}


    //查看我的帖子
public function doPageMyPost(){
  global $_GPC, $_W;
   $pageindex = max(1, intval($_GPC['page']));
  $pagesize=10;
  $sql="select a.*,b.type_name,c.name as type2_name from " . tablename("zhls_sun_information") . " a"  . " left join " . tablename("zhls_sun_type") . " b on b.id=a.type_id  " . " left join " . tablename("zhls_sun_type2") . " c on a.type2_id=c.id   WHERE a.user_id=:user_id and a.del=2 ORDER BY a.id DESC";
  $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
  $res = pdo_fetchall($select_sql,array(':user_id'=>$_GPC['user_id']));
 
  echo json_encode($res);
}
//查看商家的帖子
  public function doPageStorePost(){
      global $_GPC, $_W;
      $res=pdo_getall('zhls_sun_information',array('store_id'=>$_GPC['store_id'],'del'=>2));
      echo json_encode($res);
  }
  //查看商家帖子列表
  public function doPageStorePostList(){
      global $_GPC, $_W;
      $sql="select a.*,b.logo from " . tablename("zhls_sun_information") . " a"  . " left join " . tablename("zhls_sun_store") . " b on b.id=a.store_id  WHERE a.uniacid=:uniacid and a.store_id!='' and a.del=2 ORDER BY a.id DESC";
     $res=pdo_fetchall($sql,array(':uniacid'=>$_W['uniacid']));
    //  $res=pdo_getall('zhls_sun_information',array('uniacid'=>$_W['uniacid'],'store_id !='=>''));
      echo json_encode($res);
  }
    //查看帖子详情
public function doPagePostInfo(){
  global $_GPC, $_W;
  pdo_update('zhls_sun_information',array('views +='=>1),array('id'=>$_GPC['id']));
  $sql="select a.*,b.type_name,c.name as type2_name,d.img as user_img,e.logo,e.coordinates from " . tablename("zhls_sun_information") . " a"  . " left join " . tablename("zhls_sun_type") . " b on b.id=a.type_id  " . " left join " . tablename("zhls_sun_type2") . " c on a.type2_id=c.id " . " left join " . tablename("zhls_sun_user") . " d on a.user_id=d.id". " left join " . tablename("zhls_sun_store") . " e on a.store_id=e.id  WHERE a.id=:id  ORDER BY a.id DESC";
  $res=pdo_fetch($sql,array(':id'=>$_GPC['id']));

  $sql2="select a.*,b.img as user_img from " . tablename("zhls_sun_like") . " a"  . " left join " . tablename("zhls_sun_user") . " b on b.id=a.user_id  WHERE a.information_id=:id  ORDER BY a.id DESC";
  $res2=pdo_fetchall($sql2,array(':id'=>$_GPC['id']));
  $sql3="select a.*,b.img as user_img,b.name from " . tablename("zhls_sun_comments") . " a"  . " left join " . tablename("zhls_sun_user") . " b on b.id=a.user_id  WHERE a.information_id=:id  ORDER BY a.id DESC";
  $res3=pdo_fetchall($sql3,array(':id'=>$_GPC['id']));
  $sql4="select a.*,b.label_name from " . tablename("zhls_sun_mylabel") . " a"  . " left join " . tablename("zhls_sun_label") . " b on b.id=a.label_id  WHERE a.information_id=:id  ORDER BY a.id DESC";
  $res4=pdo_fetchall($sql4,array(':id'=>$_GPC['id']));
  $data['tz']=$res;
  $data['dz']=$res2;
  $data['pl']=$res3;
  $data['label']=$res4;
  echo json_encode($data);
}
    //查看二级分类下的帖子
public function doPagePostList(){
   global $_GPC, $_W;

   $time=time()-24*60*60;//一天
   $time2=time()-24*7*60*60;//一周
   $time3=time()-24*30*60*60;//一个月
   pdo_update('zhls_sun_information',array('top'=>2),array('sh_time <='=>$time,'top_type'=>1,'state'=>2));
   pdo_update('zhls_sun_information',array('top'=>2),array('sh_time <='=>$time2,'top_type'=>2,'state'=>2));
   pdo_update('zhls_sun_information',array('top'=>2),array('sh_time <='=>$time3,'top_type'=>3,'state'=>2));
   $list=pdo_getall('zhls_sun_information',array('uniacid'=>$_W['uniacid'],'state'=>2));
   for($j=0;$j<count($list);$j++){
        if($list[$j]['top_type']==1){
            pdo_update('zhls_sun_information',array('dq_time'=>$list[$j]['sh_time']+24*60*60),array('id'=>$list[$j]['id']));
        }elseif($list[$j]['top_type']==2){
          pdo_update('zhls_sun_information',array('dq_time'=>$list[$j]['sh_time']+24*60*60*7),array('id'=>$list[$j]['id']));
        }elseif($list[$j]['top_type']==3){
          pdo_update('zhls_sun_information',array('dq_time'=>$list[$j]['sh_time']+24*60*60*60),array('id'=>$list[$j]['id']));
        }
   }
   $where=" WHERE a.type2_id=:type2_id and a.state=:state and a.del=2";
   $data[':type2_id']=$_GPC['type2_id'];
   $data[':state']=2;

    if($_GPC['cityname']){
          $where.=" and a.cityname LIKE  concat('%', :name,'%') ";  
          $data[':name']=$_GPC['cityname'];
        }
  $pageindex = max(1, intval($_GPC['page']));
  $pagesize=10;
   $sql="select a.*,b.img as user_img,c.logo from " . tablename("zhls_sun_information") . " a"  . " left join " . tablename("zhls_sun_user") . " b on b.id=a.user_id". " left join " . tablename("zhls_sun_store") . " c on c.id=a.store_id".$where." ORDER BY a.top asc,a.id DESC";
   $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
  $res = pdo_fetchall($select_sql,$data);

  $sql2="select a.*,b.label_name from " . tablename("zhls_sun_mylabel") . " a"  . " left join " . tablename("zhls_sun_label") . " b on b.id=a.label_id";
   $res2=pdo_fetchall($sql2);

  // $res2=pdo_getall('zhls_sun_label',array('uniacid'=>$_W['uniacid']));
    $data2=array();
  
   for($i=0;$i<count($res);$i++){
     $data=array();
      for($k=0;$k<count($res2);$k++){
          if($res[$i]['id']==$res2[$k]['information_id']){
            $data[]=array(
            'label_name'=>$res2[$k]['label_name']
            );
          }  
      }
      $data2[]=array(
      'tz'=>$res[$i],
      'label'=>$data
      );
    }
  

   echo json_encode($data2);
 }

    //大分类帖子列表
 public function doPageList(){
   global $_GPC, $_W;
         $time=time()-24*60*60;//一天
         $time2=time()-24*7*60*60;//一周
         $time3=time()-24*30*60*60;//一个月
         $pageindex = max(1, intval($_GPC['page']));
         $pagesize=10;
         pdo_update('zhls_sun_information',array('top'=>2),array('sh_time <='=>$time,'top_type'=>1,'state'=>2));
         pdo_update('zhls_sun_information',array('top'=>2),array('sh_time <='=>$time2,'top_type'=>2,'state'=>2));
         pdo_update('zhls_sun_information',array('top'=>2),array('sh_time <='=>$time3,'top_type'=>3,'state'=>2));
         $where=" where a.type_id=:type_id and a.state=:state and a.del=2 ";
         $list=pdo_getall('zhls_sun_information',array('uniacid'=>$_W['uniacid'],'state'=>2));
         for($j=0;$j<count($list);$j++){
          if($list[$j]['top_type']==1){
            pdo_update('zhls_sun_information',array('dq_time'=>$list[$j]['sh_time']+24*60*60),array('id'=>$list[$j]['id']));
          }elseif($list[$j]['top_type']==2){
            pdo_update('zhls_sun_information',array('dq_time'=>$list[$j]['sh_time']+24*60*60*7),array('id'=>$list[$j]['id']));
          }elseif($list[$j]['top_type']==3){
            pdo_update('zhls_sun_information',array('dq_time'=>$list[$j]['sh_time']+24*60*60*60),array('id'=>$list[$j]['id']));
          }
        }
        $data[':type_id']=$_GPC['type_id'];
        $data[':state']=2;
        if($_GPC['cityname']){
          $where.=" and a.cityname LIKE  concat('%', :name,'%') ";  
          $data[':name']=$_GPC['cityname'];
        }
        $sql="select a.*,b.img as user_img,c.logo from " . tablename("zhls_sun_information") . " a"  . " left join " . tablename("zhls_sun_user") . " b on b.id=a.user_id". " left join " . tablename("zhls_sun_store") . " c on c.id=a.store_id".$where." ORDER BY a.top asc,a.id DESC";
        $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
        $res = pdo_fetchall($select_sql,$data);
       //  $res=pdo_fetchall($sql,array(':type_id'=>$_GPC['type_id'],':state'=>2));
        $sql2="select a.*,b.label_name from " . tablename("zhls_sun_mylabel") . " a"  . " left join " . tablename("zhls_sun_label") . " b on b.id=a.label_id";
        $res2=pdo_fetchall($sql2);

        // $res2=pdo_getall('zhls_sun_label',array('uniacid'=>$_W['uniacid']));
        $data2=array();
        for($i=0;$i<count($res);$i++){
         $data=array();
         for($k=0;$k<count($res2);$k++){
          if($res[$i]['id']==$res2[$k]['information_id']){
            $data[]=array(
              'label_name'=>$res2[$k]['label_name']
              );
          }  
        }
        $data2[]=array(
          'tz'=>$res[$i],
          'label'=>$data
          );
      }

      echo json_encode($data2);
    }
//所有帖子列表
public function doPageList2(){
global $_GPC, $_W;
$time=time()-24*60*60;//一天
$time2=time()-24*7*60*60;//一周
$time3=time()-24*30*60*60;//一个月
pdo_update('zhls_sun_information',array('top'=>2),array('sh_time <='=>$time,'top_type'=>1,'state'=>2));
pdo_update('zhls_sun_information',array('top'=>2),array('sh_time <='=>$time2,'top_type'=>2,'state'=>2));
pdo_update('zhls_sun_information',array('top'=>2),array('sh_time <='=>$time3,'top_type'=>3,'state'=>2));
$list=pdo_getall('zhls_sun_information',array('uniacid'=>$_W['uniacid'],'state'=>2));
   for($j=0;$j<count($list);$j++){
        if($list[$j]['top_type']==1){
            pdo_update('zhls_sun_information',array('dq_time'=>$list[$j]['sh_time']+24*60*60),array('id'=>$list[$j]['id']));
        }elseif($list[$j]['top_type']==2){
          pdo_update('zhls_sun_information',array('dq_time'=>$list[$j]['sh_time']+24*60*60*7),array('id'=>$list[$j]['id']));
        }elseif($list[$j]['top_type']==3){
          pdo_update('zhls_sun_information',array('dq_time'=>$list[$j]['sh_time']+24*60*60*60),array('id'=>$list[$j]['id']));
        }
   }
$where=" WHERE a.state=:state and a.del=2  and a.user_id != 0 and a.uniacid=:uniacid";
$data[':state']=2;
$data[':uniacid']=$_W['uniacid'];
if($_GPC['keywords']){
$where.=" and a.details LIKE  concat('%', :name,'%') ";  
$data[':name']=$_GPC['keywords'];
}
if($_GPC['type_id']){
$where.=" and  a.type_id=:type_id ";  
 $data[':type_id']=$_GPC['type_id'];
}
if($_GPC['cityname']){
$where.=" and a.cityname LIKE  concat('%', :name,'%') ";  
$data[':name']=$_GPC['cityname'];
}
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$sql="select a.*,b.img as user_img,c.type_name,d.name as type2_name  from" . tablename("zhls_sun_information") . " a"  . " left join " . tablename("zhls_sun_user") . " b on b.id=a.user_id " . " left join " . tablename("zhls_sun_type") . " c on a.type_id=c.id " . " left join " . tablename("zhls_sun_type2") . " d on a.type2_id=d.id ".$where." ORDER BY a.top asc,a.id DESC";
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$res = pdo_fetchall($select_sql,$data);
$sql2="select a.*,b.label_name from " . tablename("zhls_sun_mylabel") . " a"  . " left join " . tablename("zhls_sun_label") . " b on b.id=a.label_id";
$res2=pdo_fetchall($sql2);
// $res2=pdo_getall('zhls_sun_label',array('uniacid'=>$_W['uniacid']));
$data2=array();
for($i=0;$i<count($res);$i++){
 $data=array();
  for($k=0;$k<count($res2);$k++){
      if($res[$i]['id']==$res2[$k]['information_id']){
        $data[]=array(
        'label_name'=>$res2[$k]['label_name']
        );
      }  
  }
  $data2[]=array(
  'tz'=>$res[$i],
  'label'=>$data
  );
}
echo json_encode($data2);
}
    //查看二级分类下的标签
       public function doPageLabel(){
        global $_GPC, $_W;
        $res=pdo_getall('zhls_sun_label',array('type2_id'=>$_GPC['type2_id']));
        echo json_encode($res);
      }
    //帖子评论
      public function doPageComments(){
       global $_GPC, $_W;
       $data['information_id']=$_GPC['information_id'];
       $data['user_id']=$_GPC['user_id'];
       $data['details']=$_GPC['details'];
       $data['time']=time();
       $res=pdo_insert('zhls_sun_comments',$data);
       $assess_id=pdo_insertid();
       if($res){
         echo $assess_id;
       }else{
         echo 'error';
       }
     }
     //商家评分
      public function doPageStoreComments(){
       global $_GPC, $_W;
        
       $data['store_id']=$_GPC['store_id'];
       $data['user_id']=$_GPC['user_id'];
       $data['details']=$_GPC['details'];
       $data['score']=$_GPC['score'];
       $data['time']=time();
       $res=pdo_insert('zhls_sun_comments',$data);
        $assess_id=pdo_insertid();
       if($res){
        $total=pdo_get('zhls_sun_comments', array('store_id'=>$_GPC['store_id']), array('sum(score) as total'));
        $count=pdo_get('zhls_sun_comments', array('store_id'=>$_GPC['store_id']), array('count(id) as count'));
        if($total['total']>0 and $count['count']>0){
            $pf=($total['total']/$count['count']);
        }else{
             $pf=0;
        }
        pdo_update('zhls_sun_store',array('score'=>$pf),array('id'=>$_GPC['store_id']));
         echo $assess_id;
       }else{
         echo '2';
       }
     }
    //回复
     public function doPageReply(){
       global $_GPC, $_W;
       $data['reply']=$_GPC['reply'];
       $data['hf_time']=time();
       $res=pdo_update('zhls_sun_comments',$data,array('id'=>$_GPC['id']));
       if($res){
         echo '1';
       }else{
         echo '2';
       }
     }
    //总浏览量
     public function doPageViews(){
      global $_W, $_GPC;
      $sql = "select sum(views) as num from " . tablename("zhls_sun_information")." WHERE uniacid=".$_W['uniacid'];
      $total = pdo_fetch($sql);
      pdo_update('zhls_sun_system',array('total_num +='=>1),array('uniacid'=>$_W['uniacid']));
      $system=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));

      echo ($total['num']+$system['total_num']);
    }
   //帖子总量
    public function doPageNum(){
      global $_W, $_GPC;
      $res=pdo_getall('zhls_sun_information',array('uniacid'=>$_W['uniacid']));
      $total=count($res);
      $res2=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
      echo count($res)+$res2['tz_num'];
      
    }

   //置顶
    public function doPageTop(){
      global $_W, $_GPC;
      $res=pdo_getall('zhls_sun_top',array('uniacid'=>$_W['uniacid']),array(),'','num asc');
      echo json_encode($res);
    }

    //支付
    public function doPagePay(){
      global $_W, $_GPC;
      include IA_ROOT.'/addons/zhls_sun/wxpay.php';
      $res=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
      $appid=$res['appid'];
        $openid=$_GPC['openid'];//oQKgL0ZKHwzAY-KhiyEEAsakW5Zg
        $mch_id=$res['mchid'];
        $key=$res['wxkey'];
        $out_trade_no = $mch_id. time();
        $total_fee =$_GPC['money'];
            if(empty($total_fee)) //押金
            {
              $body = "订单付款";
              $total_fee = floatval(99*100);
            }else{
             $body = "订单付款";
             $total_fee = floatval($total_fee*100);
           }
           if($_GPC['order_id']){
           		pdo_update('zhls_sun_order',array('out_trade_no'=>$out_trade_no),array('id'=>$_GPC['order_id']));
           }
           $weixinpay = new WeixinPay($appid,$openid,$mch_id,$key,$out_trade_no,$body,$total_fee);
           $return=$weixinpay->pay();
           echo json_encode($return);
         }
   //商家入驻
         public function doPageStore(){
           global $_W, $_GPC;
           $system=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
         		$data['user_id']=$_GPC['user_id'];//用户id
         		$data['store_name']=$_GPC['store_name'];//商家名称
         		$data['address']=$_GPC['address'];//地址
         		$data['announcement']=$_GPC['announcement'];//公告
         		$data['storetype_id']=$_GPC['storetype_id'];//行业分类id
         		$data['storetype2_id']=$_GPC['storetype2_id'];//之行业分类id
         		$data['area_id']=$_GPC['area_id'];//区域id
         		$data['start_time']=$_GPC['start_time'];//营业时间
         		$data['end_time']=$_GPC['end_time'];//营业时间
         		$data['keyword']=$_GPC['keyword'];//关键字
         		$data['skzf']=$_GPC['skzf'];//刷卡支付
         		$data['wifi']=$_GPC['wifi'];//wifi
         		$data['mftc']=$_GPC['mftc'];//免费停车
         		$data['jzxy']=$_GPC['jzxy'];//禁止吸烟
         		$data['tgbj']=$_GPC['tgbj'];//提供包间
         		$data['sfxx']=$_GPC['sfxx'];//沙发休闲
         		$data['tel']=$_GPC['tel'];//电话
         		$data['logo']=$_GPC['logo'];//商家logo
            $data['vr_link']=$_GPC['vr_link'];//vr
         		$data['weixin_logo']=$_GPC['weixin_logo'];//老板微信
         		$data['ad']=$_GPC['ad'];//轮播图
            $data['img']=$_GPC['img'];//商家图片
            $data['start_time']=$_GPC['start_time'];
             $data['end_time']=$_GPC['end_time'];
              $data['cityname']=$_GPC['cityname'];
            if($system['sj_audit']==2){
              $data['sh_time']=time();
              $data['state']=2;
            }else{
              $data['state']=1;
            }
            if($_GPC['type']){
            	$data['type']=$_GPC['type'];//入驻类型
            	$data['time_over']=2;
            }
            $data['time']=date('Y-m-d H:i:s',time());
         		$data['money']=$_GPC['money'];//付款价格
         		$data['details']=$_GPC['details'];//商家简介
            $data['coordinates']=$_GPC['coordinates'];//坐标
            $data['uniacid']=$_W['uniacid'];
            $res=pdo_insert('zhls_sun_store',$data);
            $store_id=pdo_insertid();
            if($res){
              //echo '1';
              echo $store_id;
            }else{
              echo '2';
            }

          }
          //修改入驻
         public function doPageUpdStore(){
           global $_W, $_GPC;
           $system=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
            //$data['user_id']=$_GPC['user_id'];//用户id
            $data['store_name']=$_GPC['store_name'];//商家名称
            $data['address']=$_GPC['address'];//地址
            $data['announcement']=$_GPC['announcement'];//公告
            $data['storetype_id']=$_GPC['storetype_id'];//行业分类id
            $data['storetype2_id']=$_GPC['storetype2_id'];//之行业分类id
            $data['area_id']=$_GPC['area_id'];//区域id
            $data['start_time']=$_GPC['start_time'];//营业时间
         	  $data['end_time']=$_GPC['end_time'];//营业时间
            $data['keyword']=$_GPC['keyword'];//关键字
            $data['skzf']=$_GPC['skzf'];//刷卡支付
            $data['wifi']=$_GPC['wifi'];//wifi
            $data['mftc']=$_GPC['mftc'];//免费停车
            $data['jzxy']=$_GPC['jzxy'];//禁止吸烟
            $data['tgbj']=$_GPC['tgbj'];//提供包间
            $data['sfxx']=$_GPC['sfxx'];//沙发休闲
            $data['tel']=$_GPC['tel'];//电话
            $data['logo']=$_GPC['logo'];//商家logo
            $data['vr_link']=$_GPC['vr_link'];//vr
            $data['weixin_logo']=$_GPC['weixin_logo'];//老板微信
            $data['ad']=$_GPC['ad'];//轮播图
            $data['img']=$_GPC['img'];//商家图片
            if($system['sj_audit']==2){
              //$data['sh_time']=time();
              $data['state']=2;
            }else{
              $data['state']=1;
            }
            if($_GPC['type']){
            	$data['type']=$_GPC['type'];//入驻类型
            	$data['time_over']=2;
              
            }
            
            $data['money']=$_GPC['money'];//付款价格
            $data['details']=$_GPC['details'];//商家简介
            $data['coordinates']=$_GPC['coordinates'];//坐标
            $data['uniacid']=$_W['uniacid'];
            $res=pdo_update('zhls_sun_store',$data,array('id'=>$_GPC['id']));
            if($res){
              echo '1';
            }else{
              echo '2';
            }

          }
   //商家列表
          public function doPageStoreList(){
            global $_W, $_GPC;
           $time=time()-24*60*60*7;//一周
           $time2=time()-24*182*60*60;//半年
           $time3=time()-24*365*60*60;//一年
           pdo_update('zhls_sun_store',array('time_over'=>1),array('sh_time <='=>$time,'type'=>1,'state'=>2));
           pdo_update('zhls_sun_store',array('time_over'=>1),array('sh_time <='=>$time2,'type'=>2,'state'=>2));
           pdo_update('zhls_sun_store',array('time_over'=>1),array('sh_time <='=>$time3,'type'=>3,'state'=>2));
           $list=pdo_getall('zhls_sun_store',array('uniacid'=>$_W['uniacid'],'state'=>2));
           for($i=0;$i<count($list);$i++){
                if($list[$i]['type']==1){
                    pdo_update('zhls_sun_store',array('dq_time'=>$list[$i]['sh_time']+24*60*60*7),array('id'=>$list[$i]['id']));
                }elseif($list[$i]['type']==2){
                  pdo_update('zhls_sun_store',array('dq_time'=>$list[$i]['sh_time']+24*60*60*182),array('id'=>$list[$i]['id']));
                }elseif($list[$i]['type']==3){
                  pdo_update('zhls_sun_store',array('dq_time'=>$list[$i]['sh_time']+24*60*60*365),array('id'=>$list[$i]['id']));
                }
           }
           $where=" where uniacid=:uniacid and time_over !=1 and state=2";
           $data[':uniacid']=$_W['uniacid'];
          if($_GPC['keywords']){
          $where.=" and (store_name LIKE  concat('%', :name,'%') or keyword LIKE  concat('%', :name,'%'))";  
          $data[':name']=$_GPC['keywords'];
         }
         if($_GPC['cityname']){
          $where.=" and cityname LIKE  concat('%', :name,'%') ";  
          $data[':name']=$_GPC['cityname'];
         }
         $pageindex = max(1, intval($_GPC['page']));
         $pagesize=10;
           $sql= "select * from".tablename('zhls_sun_store').$where." order by is_top,sh_time DESC";
           $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
     $res = pdo_fetchall($select_sql,$data);
           
          // $res=pdo_getall('zhls_sun_store',array('uniacid'=>$_W['uniacid'],'time_over !='=>1),array(),'','num asc');
           echo json_encode($res);
          }
    //分类下商家列表
      public function doPageTypeStoreList(){
           global $_W, $_GPC;
           $time=time()-24*60*60*7;//一周
           $time2=time()-24*182*60*60;//半年
           $time3=time()-24*365*60*60;//一年
           pdo_update('zhls_sun_store',array('time_over'=>1),array('sh_time <='=>$time,'type'=>1,'state'=>2));
           pdo_update('zhls_sun_store',array('time_over'=>1),array('sh_time <='=>$time2,'type'=>2,'state'=>2));
           pdo_update('zhls_sun_store',array('time_over'=>1),array('sh_time <='=>$time3,'type'=>3,'state'=>2));
           $list=pdo_getall('zhls_sun_store',array('uniacid'=>$_W['uniacid'],'state'=>2));
           for($i=0;$i<count($list);$i++){
                if($list[$i]['type']==1){
                    pdo_update('zhls_sun_store',array('dq_time'=>$list[$i]['sh_time']+24*60*60*7),array('id'=>$list[$i]['id']));
                }elseif($list[$i]['type']==2){
                  pdo_update('zhls_sun_store',array('dq_time'=>$list[$i]['sh_time']+24*60*60*182),array('id'=>$list[$i]['id']));
                }elseif($list[$i]['type']==3){
                  pdo_update('zhls_sun_store',array('dq_time'=>$list[$i]['sh_time']+24*60*60*365),array('id'=>$list[$i]['id']));
                }
           }
           $res=pdo_getall('zhls_sun_store',array('uniacid'=>$_W['uniacid'],'time_over !='=>1,'storetype_id'=>$_GPC['storetype_id'],'state'=>2),array(),'','num asc');
           echo json_encode($res);
          }
   //查看我的商家信息
          public function doPageMyStore(){
            global $_W, $_GPC;
            $sql="select a.*,b.type_name,c.name as type2_name from " . tablename("zhls_sun_store") . " a"  . " left join " . tablename("zhls_sun_storetype") . " b on b.id=a.storetype_id  " . " left join " . tablename("zhls_sun_storetype2") . " c on a.storetype2_id=c.id  WHERE a.id=:store_id  ORDER BY a.id DESC";
            $res=pdo_fetch($sql,array(':store_id'=>$_GPC['user_id']));
            echo json_encode($res);
          }

          public function doPageSjdLogin(){
            global $_W, $_GPC;
            $sql="select a.*,b.type_name,c.name as type2_name from " . tablename("zhls_sun_store") . " a"  . " left join " . tablename("zhls_sun_storetype") . " b on b.id=a.storetype_id  " . " left join " . tablename("zhls_sun_storetype2") . " c on a.storetype2_id=c.id  WHERE a.user_id=:user_id  ORDER BY a.id DESC";
            $res=pdo_fetch($sql,array(':user_id'=>$_GPC['user_id']));
            echo json_encode($res);
          }
   //商家详情
          public function doPageStoreInfo(){
            global $_W, $_GPC;
            pdo_update('zhls_sun_store',array('views +='=>1),array('id'=>$_GPC['id']));
            $res=pdo_getall('zhls_sun_store',array('id'=>$_GPC['id']));
            $sql2="select a.*,b.img as user_img,b.name from " . tablename("zhls_sun_comments") . " a"  . " left join " . tablename("zhls_sun_user") . " b on b.id=a.user_id  WHERE a.store_id=:id  ORDER BY a.id DESC";
            $res2=pdo_fetchall($sql2,array(':id'=>$_GPC['id']));
            $data['store']=$res;
            $data['pl']=$res2;
            echo json_encode($data);
          }

   //区域信息
          public function doPageArea(){
           global $_W, $_GPC;
           $res=pdo_getall('zhls_sun_area',array('uniacid'=>$_W['uniacid']));
           echo json_encode($res);
         }
   //行业分类
         public function doPageStoreType(){
           global $_W, $_GPC;
           $res=pdo_getall('zhls_sun_storetype',array('uniacid'=>$_W['uniacid'],'state'=>1),array(),'','num asc');
           echo json_encode($res);
         }
   //二级行业分类
         public function doPageStoreType2(){
           global $_W, $_GPC;
           $res=pdo_getall('zhls_sun_storetype2',array('type_id'=>$_GPC['type_id']));
           echo json_encode($res);
         }

   //地图
         public function doPageMap() {
          global $_GPC, $_W;
          $op=$_GPC['op'];
          $res=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
          $url="https://apis.map.qq.com/ws/geocoder/v1/?location=".$op."&key=".$res['mapkey']."&get_poi=0&coord_type=1";
          $html = file_get_contents($url);
          echo  $html;
        }
    //系统设置
        public function doPageSystem(){
          global $_W, $_GPC;
          $res=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
          echo json_encode($res);
        }
//公告列表
        public function doPageNews(){
         global $_GPC, $_W;
         $where=" where uniacid=:uniacid and state=1";
         if($_GPC['cityname']){
          $where.=" and cityname LIKE  concat('%', :name,'%')";  
          $data[':name']=$_GPC['cityname'];
        }
        $data[':uniacid']=$_W['uniacid'];
        $sql="select * from ".tablename('zhls_sun_news').$where." order by num asc";
        $res=pdo_fetchall($sql,$data);
        echo json_encode($res);
      }
    //公告详情
        public function doPageNewsInfo(){
          global $_W, $_GPC;
          $res=pdo_get('zhls_sun_news',array('id'=>$_GPC['id']));
          echo json_encode($res);
        }

//收藏
    public function doPageCollection(){
          global $_W, $_GPC;
          if($_GPC['information_id']){
            $data['information_id']=$_GPC['information_id'];
          }
          if($_GPC['store_id']){
             $data['store_id']=$_GPC['store_id'];
          }
          $data['user_id']=$_GPC['user_id'];
          $list=pdo_get('zhls_sun_share',$data);
          if($list){
              pdo_delete('zhls_sun_share',$data);
          }else{
                $res=pdo_insert('zhls_sun_share',$data);
              if($res){
                echo '1';
              }else{
                echo '2';
              }
          } 
    }
  //查看是否收藏
  public function doPageIsCollection(){
      global $_W, $_GPC;
      if($_GPC['information_id']){
            $data['information_id']=$_GPC['information_id'];
        }
      if($_GPC['store_id']){
             $data['store_id']=$_GPC['store_id'];
      }
      $data['user_id']=$_GPC['user_id'];
      $list=pdo_get('zhls_sun_share',$data);
      if($list){
        echo '1';
      }else{
        echo '2';
      }
  }
    //我的收藏
    public function doPageMyCollection(){
          global $_W, $_GPC;
         $sql="select a.*,b.img,b.details,b.time,b.top,c.type_name,d.name as type2_name,e.img as user_img,e.name as user_name from" . tablename("zhls_sun_share") . " a"  . " left join " . tablename("zhls_sun_information") . " b on b.id=a.information_id " . " left join " . tablename("zhls_sun_type") . " c on b.type_id=c.id " . " left join " . tablename("zhls_sun_type2") . " d on b.type2_id=d.id " . " left join " . tablename("zhls_sun_user") . " e on b.user_id=e.id WHERE a.user_id=:user_id  ORDER BY b.top DESC,b.id DESC";
         $res=pdo_fetchall($sql,array(':user_id'=>$_GPC['user_id']));
         echo json_encode($res);
    }
    //我的商家收藏
    public function doPageMyStoreCollection(){
          global $_W, $_GPC;
         $sql="select a.*,b.store_name,b.address,b.tel,b.logo,b.score,b.views,b.coordinates from" . tablename("zhls_sun_share") . " a"  . " left join " . tablename("zhls_sun_store") . " b on b.id=a.store_id  WHERE a.user_id=:user_id  ORDER BY a.id DESC";
         $res=pdo_fetchall($sql,array(':user_id'=>$_GPC['user_id']));
         echo json_encode($res);
    }
  //   //商家收藏
  //   public function doPageStoreCollection(){
  //         global $_W, $_GPC;
  //         $data['store_id']=$_GPC['store_id'];
  //         $data['user_id']=$_GPC['user_id'];
  //         $list=pdo_get('zhls_sun_share',$data);
  //         if($list){
  //             pdo_delete('zhls_sun_share',$data);
  //         }else{
  //               $res=pdo_insert('zhls_sun_share',$data);
  //             if($res){
  //               echo '1';
  //             }else{
  //               echo '2';
  //             }
  //         } 
  //   }
  //   //查看是否收藏商家
  // public function doPageIsStoreCollection(){
  //     global $_W, $_GPC;
  //     $data['store_id']=$_GPC['store_id'];
  //     $data['user_id']=$_GPC['user_id'];
  //     $list=pdo_get('zhls_sun_share',$data);
  //     if($list){
  //       echo '1';
  //     }else{
  //       echo '2';
  //     }
  // }

//入驻费用
  public function doPageInMoney(){
      global $_W, $_GPC;
      $res=pdo_getall('zhls_sun_in',array('uniacid'=>$_W['uniacid']),array(),'','num asc');
       echo json_encode($res);
  }

//帮助中心
public function doPageGetHelp(){
   global $_W, $_GPC;
   $res= pdo_getall('zhls_sun_help',array('uniacid'=>$_W['uniacid']),array() , '' , 'sort ASC');
    echo json_encode($res);
}

  public function doPageSms(){
     global $_W, $_GPC;
     $res=pdo_get('zhls_sun_sms',array('uniacid'=>$_W['uniacid']));
     $tpl_id=$res['tpl_id'];
     $tel=$_GPC['tel'];
     $code=$_GPC['code'];
     $key=$res['appkey'];
     $url = "http://v.juhe.cn/sms/send?mobile=".$tel."&tpl_id=".$tpl_id."&tpl_value=%23code%23%3D".$code."&key=".$key;
     $data=file_get_contents($url);
     print_r($data);
  }

//我的分享码
 public function doPageHxCode(){
        global $_W, $_GPC;
        load()->func('tpl');
        function  getCoade($user_id){
          function getaccess_token(){
            global $_W, $_GPC;
            $res=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
            $appid= $res['appid'];
            $secret=$res['appsecret'];
            /*$appid='wx80fa1d36c435231a';
            $secret='41d8f6e7fad1a13cfa2e6de8acf14280';*/
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret."";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
            $data = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($data,true);
            return $data['access_token'];
          }

          function set_msg($user_id){
           $access_token = getaccess_token();
           $data2=array(
            "scene"=>$user_id,
            "width"=>100
            );
           $data2 = json_encode($data2);
        //$url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$access_token."";
           $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$access_token."";
           $ch = curl_init();
           curl_setopt($ch, CURLOPT_URL,$url);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
           curl_setopt($ch, CURLOPT_POST,1);
           curl_setopt($ch, CURLOPT_POSTFIELDS,$data2);
           $data = curl_exec($ch);
           curl_close($ch);
           return $data;
         }
         $img=set_msg($user_id);
          
         $img=base64_encode($img);
        return $img;

       }
       echo getCoade($_GPC['user_id']);

     }
//扫码进来
  public function  doPageCodeIn(){
      global $_W, $_GPC;
      $user=pdo_get('zhls_sun_user',array('opneid'=>$_GPC['openid']));
      if(!$user){
         $res=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
          $date['user_id']=$_GPC['user_id'];
          $date['zf_user_id']=$_GPC['zf_user_id'];
          $date['money']=$res['fx_money'];
          $date['uniacid']=$_W['uniacid'];
          $list=pdo_get('zhls_sun_fx',$data);
      if(!$list){
        $date['time']=time();
        $res2=pdo_insert('zhls_sun_fx',$data);
        pdo_update('zhls_sun_user',array('money +='=>$date['money']),array('id'=>$_GPC['user_id']));
      }
      }  
  }
  //领取红包
  public function doPageGetHong(){
  		global $_W, $_GPC;
  		$res=pdo_get('zhls_sun_information',array('id'=>$_GPC['id']));//查找帖子
      //判断红包个数
      $count=pdo_get('zhls_sun_hblq', array('tz_id'=>$_GPC['id']), array('count(id) as total'));
      if($res['hb_num']>$count['total']){
  		if($res['hb_random']==1){
  			$hong=json_decode($res['hong']);
  		$list=pdo_getall('zhls_sun_hblq',array('tz_id'=>$_GPC['id'],'user_id'=>$_GPC['user_id']));
  		$user=pdo_getall('zhls_sun_hblq',array('tz_id'=>$_GPC['id']));
  		if(!$list and count($user)<$res['hb_num']){
  			$num=count($user);
  			$money=$hong[$num];
  			$data['user_id']=$_GPC['user_id'];
  			$data['tz_id']=$_GPC['id'];
  			$data['money']=$money;
  			$data['time']=time();
  			$data['uniacid']=$_W['uniacid'];
  			$get=pdo_insert('zhls_sun_hblq',$data);
  			if($get){
  				pdo_update('zhls_sun_user',array('money +='=>$hong[$num]),array('id'=>$_GPC['user_id']));
  				echo $hong[$num];
  			}
  		}
  	}else if($res['hb_random']==2){
  		$data['user_id']=$_GPC['user_id'];
  		$data['tz_id']=$_GPC['id'];
  		$data['money']=$res['hb_money'];
  		$data['time']=time();
  		$data['uniacid']=$_W['uniacid'];
  		$get=pdo_insert('zhls_sun_hblq',$data);
  		if($get){
  			pdo_update('zhls_sun_user',array('money +='=>$data['money']),array('id'=>$_GPC['user_id']));
  			echo  $data['money'];
  		}
  	}
  }else{
    echo 'error';
  }
  		
  		
  }
  //领取列表
  public function doPageHongList(){
  		global $_W, $_GPC;
 		$sql="select a.*,b.img,b.name from" . tablename("zhls_sun_hblq") . " a"  . " left join " . tablename("zhls_sun_user") . " b on b.id=a.user_id  WHERE a.tz_id=:tz_id  ORDER BY a.id DESC";
        $list=pdo_fetchall($sql,array(':tz_id'=>$_GPC['id']));
  		echo json_encode($list);
  }
//红包
public function doPageHong(){
    global $_W, $_GPC;
     function hongbao($money,$number,$ratio = 1){
        $res = array(); //结果数组
        $min = 0.01;   //最小值
        $max = ($money / $number) * (1 + $ratio);//最大值
        /*--- 第一步：分配低保 ---*/
        for($i=0;$i<$number;$i++){
            $res[$i] = $min;
        }
        $money = $money - $min * $number;
        /*--- 第二步：随机分配 ---*/
        $randRatio = 100;
        $randMax = ($max - $min) * $randRatio;
        for($i=0;$i<$number;$i++){
            //随机分钱
            $randRes = mt_rand(0,$randMax);
            $randRes = $randRes / $randRatio;
            if($money >= $randRes){ //余额充足
                $res[$i]    += $randRes;
                $money      -= $randRes;
            }
            elseif($money > 0){     //余额不足
                $res[$i]    += $money;
                $money      -= $money;
            }
            else{                   //没有余额
                break;
            }
        }
        /*--- 第三步：平均分配上一步剩余 ---*/
        if($money > 0){
            $avg = $money / $number;
            for($i=0;$i<$number;$i++){
                $res[$i] += $avg;
            }
            $money = 0;
        }
        /*--- 第四步：打乱顺序 ---*/
        shuffle($res);
        /*--- 第五步：格式化金额(可选) ---*/
        foreach($res as $k=>$v){
            //两位小数，不四舍五入
            preg_match('/^\d+(\.\d{1,2})?/',$v,$match);
            $match[0]   = number_format($match[0],2);
            $res[$k]    = $match[0];
        }

        return $res;
    }

    print_r(hongbao(1,5));
}


//提现
  public function doPageTiXian(){
      global $_W, $_GPC;
      $data['name']=$_GPC['name'];//真实姓名
      $data['username']=$_GPC['username'];//账号
      $data['type']=$_GPC['type'];//type(1支付宝 2.微信 3.银行)
      $data['']=$_GPC['tx_cost'];//提现金额
      $data['sj_tx_costcost']=$_GPC['sj_cost'];//实际到账金额
      $data['user_id']=$_GPC['user_id'];//用户id
      $data['store_id']=$_GPC['store_id'];//商家id
      $data['method']=$_GPC['method'];//1.红包  2.商家
      $data['time']=time();
      $data['state']=1;
      $data['uniacid']=$_W['uniacid'];
      $res=pdo_insert('zhls_sun_withdrawal',$data);
      $txsh_id=pdo_insertid();
      if($res){
      	if($_GPC['method']==1){
      		pdo_update('zhls_sun_user',array('money -='=>$_GPC['tx_cost']),array('id'=>$_GPC['user_id']));
      	}elseif($_GPC['method']==2){
      		pdo_update('zhls_sun_store',array('wallet -='=>$_GPC['tx_cost']),array('id'=>$_GPC['store_id']));
      	}
       // echo  '1';
       echo $txsh_id;
      }else{
        echo  '2';
      }
  }
  //我的提现
  public function doPageMyTiXian(){
    global $_W, $_GPC;
      $res=pdo_getall('zhls_sun_withdrawal',array('user_id'=>$_GPC['user_id']));
      echo json_encode($res);
  }
  //商家的提现
  public function doPageStoreTiXian(){
    global $_W, $_GPC;
      $res=pdo_getall('zhls_sun_withdrawal',array('store_id'=>$_GPC['store_id']));
      echo json_encode($res);
  }
//红包明细
  public function doPageHbmx(){
      global $_W, $_GPC;
      $res=pdo_getall('zhls_sun_hblq',array('user_id'=>$_GPC['user_id']),array(),'','time DESC');
      echo json_encode($res);
  }
//短信信息
public function doPageIsSms(){
    global $_W, $_GPC;
      $res=pdo_get('zhls_sun_sms',array('uniacid'=>$_W['uniacid']));
      echo $res['is_open'];
}

//解密
  public function doPageJiemi(){
    global $_W, $_GPC;
     $res=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
     include_once IA_ROOT.'/addons/zhls_sun/wxBizDataCrypt.php';
      $appid = $res['appid'];
      $sessionKey = $_GPC['sessionKey'];

      $encryptedData=$_GPC['data'];

      $iv = $_GPC['iv'];

      $pc = new WXBizDataCrypt($appid, $sessionKey);
      $errCode = $pc->decryptData($encryptedData, $iv, $data );


      if ($errCode == 0) {
        //echo json_encode($data);
          print($data . "\n");
      } else {
          print($errCode . "\n");
      }
  }
  //资讯分类
  public function doPageZxType(){
      global $_W, $_GPC;
      $res=pdo_getall('zhls_sun_zx_type',array('uniacid'=>$_W['uniacid']),array(),'','sort asc');
      echo json_encode($res);
  }
  //资讯
  public function doPageZx(){
      global $_W, $_GPC;
      $data['type_id']=$_GPC['type_id'];//分类id
      $data['type']=1;//1前台发布
      $data['user_id']=$_GPC['user_id'];//发布人id
      $data['title']=$_GPC['title'];//标题
      $data['content']=$_GPC['content'];//内容
      $data['imgs']=$_GPC['imgs'];//图片
      $data['time']=date('Y-m-d H:i:s');//发布时间
      $data['cityname']=$_GPC['cityname'];
      $system=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
      if($system['is_zx']==1){
          $data['state']=1;
      }else{
          $data['state']=2;
      }
      $data['uniacid']=$_W['uniacid'];
      $res=pdo_insert('zhls_sun_zx',$data);
      if($res){
        echo  '1';
      }else{
        echo  '2';
      }
  }
  //资讯列表
  public function doPageZxList(){
    global $_W, $_GPC;
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    $where=" where a.uniacid=:uniacid and  a.state=2";
    $data[':uniacid']=$_W['uniacid'];
    if($_GPC['type_id']){
      $where.=" and  a.type_id=:type_id";  
      $data[':type_id']=$_GPC['type_id'];
    }
    if($_GPC['cityname']){
      $where.=" and a.cityname LIKE  concat('%', :name,'%') ";  
      $data[':name']=$_GPC['cityname'];
         }
    $sql="select a.*,b.img,b.name,c.type_name from" . tablename("zhls_sun_zx") . " a"  . " left join " . tablename("zhls_sun_user") . " b on b.id=a.user_id " . " left join " . tablename("zhls_sun_zx_type") . " c on a.type_id=c.id".$where."  ORDER BY a.id DESC";
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $res = pdo_fetchall($select_sql,$data);

    echo json_encode($res);
  }
  //资讯详情
  public function doPageZxInfo(){
      global $_W, $_GPC;
      pdo_update('zhls_sun_zx',array('yd_num +='=>1),array('id'=>$_GPC['id']));
      $sql="select a.*,b.img,b.name,c.type_name from" . tablename("zhls_sun_zx") . " a"  . " left join " . tablename("zhls_sun_user") . " b on b.id=a.user_id " . " left join " . tablename("zhls_sun_zx_type") . " c on a.type_id=c.id WHERE a.id=:id  ORDER BY a.id DESC";
        $res=pdo_fetch($sql,array(':id'=>$_GPC['id']));
        //查看是否点赞
        $dz=pdo_get('zhls_sun_like',array('zx_id'=>$_GPC['id'],'user_id'=>$_GPC['user_id']));
        if($dz){
          $res['dz']=1;
        }else{
          $res['dz']=2;
        }
      echo json_encode($res);
  }

//资讯评论
  public function doPageZxPl(){
      global $_W, $_GPC;
      $data['zx_id']=$_GPC['zx_id'];//资讯id
      $data['content']=$_GPC['content'];//回复内容
      $data['cerated_time']=date("Y-m-d H:i:s");
      $data['user_id']=$_GPC['user_id'];//用户id
      $data['status']=2;
      $data['uniacid']=$_W['uniacid'];
      $res=pdo_insert('zhls_sun_zx_assess',$data);
      if($res){
        echo '1';
      }else{
        echo '2';
      }

  }
  //回复
  public function doPageZxHf(){
      global $_W, $_GPC;
      $data['reply']=$_GPC['reply'];//回复内容
       $data['status']=1;
      $data['reply_time']=date("Y-m-d H:i:s");
      $res=pdo_update('zhls_sun_zx_assess',$data,array('id'=>$_GPC['id']));
      if($res){
        echo '1';
      }else{
        echo '2';
      }
  }
  //评论列表
  public function doPageZxPlList(){
      global $_W, $_GPC;
      $sql="select a.*,b.img as user_img,b.name from " . tablename("zhls_sun_zx_assess") . " a"  . " left join " . tablename("zhls_sun_user") . " b on b.id=a.user_id  WHERE a.zx_id=:zx_id  ORDER BY a.id DESC";
      $res=pdo_fetchall($sql,array(':zx_id'=>$_GPC['zx_id']));
      echo json_encode($res);
  }
  //足迹
  public function doPageFootprint(){
      global $_W, $_GPC;
      $data['user_id']=$_GPC['user_id'];
      $data['zx_id']=$_GPC['zx_id'];
      $data['uniacid']=$_W['uniacid'];
      $data['time']=time();
      $list=pdo_get('zhls_sun_zx_zj',array('user_id'=>$_GPC['user_id'],'zx_id'=>$_GPC['zx_id']));
      if($list){
        $res=pdo_update('zhls_sun_zx_zj',array('time'=>time()),array('id'=>$list['id']));
        if($res){
          echo '1';
        }else{
          echo '2';
        }
      }else{
        $res=pdo_insert('zhls_sun_zx_zj',$data);
        if($res){
          echo '1';
        }else{
          echo '2';
        }
      }
      
  }
//我的足迹
  public function doPageMyFootprint(){
      global $_W, $_GPC;
      $sql="select a.*,b.title,b.imgs,b.time as zx_time,c.type_name,d.name as user_name,d.img as user_img from " . tablename("zhls_sun_zx_zj") . " a"  . " left join " . tablename("zhls_sun_zx") . " b on b.id=a.zx_id " . " left join " . tablename("zhls_sun_zx_type") . " c on b.type_id=c.id  " . " left join " . tablename("zhls_sun_user") . " d on b.user_id=d.id WHERE a.user_id=:user_id  ORDER BY a.time DESC";
      $res=pdo_fetchall($sql,array(':user_id'=>$_GPC['user_id']));
      echo json_encode($res); 
  }

//商家二维码
  public function doPageStoreCode(){
      global $_W, $_GPC;
       function  getCoade($storeid){
          function getaccess_token(){
            global $_W, $_GPC;
               $res=pdo_get('zhls_sun_system',array('uniacid' => $_W['uniacid']));
               $appid=$res['appid'];
               $secret=$res['appsecret'];
              // print_r($res);die;
             $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret."";
             $ch = curl_init();
             curl_setopt($ch, CURLOPT_URL,$url);
             curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
             $data = curl_exec($ch);
             curl_close($ch);
             $data = json_decode($data,true);
             return $data['access_token'];
      }
     function set_msg($storeid){
       $access_token = getaccess_token();
        $data2=array(
        "scene"=>$storeid,
        "page"=>"zhls_sun/pages/sellerinfo/sellerinfo",
        "width"=>400
               );
    $data2 = json_encode($data2);
        $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$access_token."";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data2);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
         }

        $img=set_msg($storeid);
        $img=base64_encode($img);
  return $img;
  }
  $base64= getCoade($_GPC['store_id']);
  $base64_image_content="data:image/jpeg;base64,".$base64;
  $ename='tcsj'.$_GPC['store_id'];
  if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
$type = $result[2];
$new_file = IA_ROOT ."/addons/zhls_sun/inc/upload/";
if(!file_exists($new_file))
{
//检查是否有该文件夹，如果没有就创建，并给予最高权限
mkdir($new_file, 0777);
}
$wname=$ename.".{$type}";
//$wname="1511.jpeg";
$new_file = $new_file.$wname;
//$new_file = $new_file.$ename;
if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){

//echo  $new_file;
}else{
echo '新文件保存失败';
}
}
echo $_W['siteroot']."addons/zhls_sun/inc/upload/tcsj{$_GPC['store_id']}.jpeg";

}
//查看标签
  public function doPageCarTag(){
      global $_W, $_GPC;
      $res=pdo_getall('zhls_sun_car_tag',array('typename'=>$_GPC['typename']));
      echo json_encode($res);
  }
//发布拼车
  public function doPageCar(){
      global $_W, $_GPC;
      $system=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
      $data['user_id']=$_GPC['user_id'];
      $data['start_place']=$_GPC['start_place'];
      $data['end_place']=$_GPC['end_place'];
      $data['start_time']=$_GPC['start_time'];
      $data['start_time2']=strtotime($_GPC['start_time']);
      $data['num']=$_GPC['num'];
      $data['link_name']=$_GPC['link_name'];
      $data['link_tel']=$_GPC['link_tel'];
      $data['typename']=$_GPC['typename'];
      $data['other']=$_GPC['other'];
      $data['tj_place']=$_GPC['tj_place'];
      $data['hw_wet']=$_GPC['hw_wet'];
      $data['star_lat']=$_GPC['star_lat'];
      $data['star_lng']=$_GPC['star_lng'];
      $data['end_lat']=$_GPC['end_lat'];
      $data['end_lng']=$_GPC['end_lng'];
      $data['cityname']=$_GPC['cityname'];
      $data['is_open']=1;
      $data['time']=time();
      $data['uniacid']=$_W['uniacid'];
      if($system['is_car']==1){
         $data['state']=1;
      }else{
         $data['state']=2;
         $data['sh_time']=time();
      }
      $res=pdo_insert('zhls_sun_car',$data);
      $post_id=pdo_insertid();
      $a=json_decode(html_entity_decode($_GPC['sz']));
      $sz=json_decode(json_encode($a),true);
     // print_r($sz);die;
      if($res){
       for($i=0;$i<count($sz);$i++){
        $data2['tag_id']=$sz[$i]['tag_id'];
        $data2['car_id']=$post_id ;
        $res2=pdo_insert('zhls_sun_car_my_tag',$data2);
      }
       echo $post_id;
    }else{
        echo '2';
    }

  }

//我的拼车
  public function doPageMyCar(){
      global $_W, $_GPC;
      $res=pdo_getall('zhls_sun_car',array('user_id'=>$_GPC['user_id']));
      echo json_encode($res);
  }
  //拼车列表
  public function doPageCarList(){
         global $_W, $_GPC;
         //UNIX_TIMESTAMP
         $time=time();
         pdo_update('zhls_sun_car',array('is_open'=>2),array('start_time2 <='=>$time));
           $pageindex = max(1, intval($_GPC['page']));
           $pagesize=10;
         $where=" where uniacid=:uniacid";
         $data[':uniacid']=$_W['uniacid'];
          if($_GPC['cityname']){
          $where.=" and cityname LIKE  concat('%', :name,'%') ";  
          $data[':name']=$_GPC['cityname'];
         }
         $sql=" select * from ".tablename('zhls_sun_car').$where." order by id DESC";
         $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
         $res=pdo_fetchall($select_sql,$data);
         //$res=pdo_getall('zhls_sun_car',array('uniacid'=>$_W['uniacid'],'state'=>2),array(),'','id DESC');
         $sql2="select a.*,b.tagname from " . tablename("zhls_sun_car_my_tag") . " a"  . " left join " . tablename("zhls_sun_car_tag") . " b on b.id=a.car_id";
         $res2=pdo_fetchall($sql2);
        // $res2=pdo_getall('zhls_sun_label',array('uniacid'=>$_W['uniacid']));
          $data2=array();
         for($i=0;$i<count($res);$i++){
           $data=array();
            for($k=0;$k<count($res2);$k++){
                if($res[$i]['id']==$res2[$k]['car_id']){
                  $data[]=array(
                  'tagname'=>$res2[$k]['tagname']
                  );
                }  
            }
            $data2[]=array(
            'tz'=>$res[$i],
            'label'=>$data
            );
          }


         echo json_encode($data2);
  }
  //分类拼车列表
  public function doPageTypeCarList(){
      global $_W, $_GPC;
         $res=pdo_getall('zhls_sun_car',array('uniacid'=>$_W['uniacid'],'typename'=>$_GPC['typename'],'state'=>2),array(),'','id DESC');
         $sql2="select a.*,b.tagname from " . tablename("zhls_sun_car_my_tag") . " a"  . " left join " . tablename("zhls_sun_car_tag") . " b on b.id=a.tag_id";
         $res2=pdo_fetchall($sql2);
        // $res2=pdo_getall('zhls_sun_label',array('uniacid'=>$_W['uniacid']));
          $data2=array();
         for($i=0;$i<count($res);$i++){
           $data=array();
            for($k=0;$k<count($res2);$k++){
                if($res[$i]['id']==$res2[$k]['car_id']){
                  $data[]=array(
                  'tagname'=>$res2[$k]['tagname']
                  );
                }  
            }
            $data2[]=array(
            'tz'=>$res[$i],
            'label'=>$data
            );
          }

         echo json_encode($data2);
  }
  //拼车详情
  public function doPageCarInfo(){
      global $_W, $_GPC;
      $sql="select a.*,b.name as user_name,b.img as user_img from " . tablename("zhls_sun_car") . " a"  . " left join " . tablename("zhls_sun_user") . " b on b.id=a.user_id where a.id =:id";
      $res=pdo_fetch($sql,array(':id'=>$_GPC['id']));
      $sql2="select a.*,b.tagname from " . tablename("zhls_sun_car_my_tag") . " a"  . " left join " . tablename("zhls_sun_car_tag") . " b on b.id=a.tag_id where a.
      car_id=:car_id";
      $res2=pdo_fetchall($sql2,array(':car_id'=>$_GPC['id']));
     // $res=pdo_getall('zhls_sun_car',array('id'=>$_GPC['id']));
     $data['pc']=$res;
     $data['tag']=$res2;
      echo json_encode($data);
  }
//关闭
  public function doPageCarShut(){
      global $_W, $_GPC;
      $res=pdo_update('zhls_sun_car',array('is_open'=>2),array('id'=>$_GPC['id']));
      if($res){
        echo  '1';
      }else{
        echo '2';
      }
  }
  //规格分类
  public function doPageSpec(){
      global $_W, $_GPC;
      $res=pdo_getall('zhls_sun_goods_spec',array('uniacid'=>$_W['uniacid']));
      echo json_encode($res);
  }

//主营业务
  public function doPageGoodList(){
    	global $_W, $_GPC;
    	$res=pdo_getall('zhls_sun_goods',array('uniacid'=>$_W['uniacid']),array(),'','id DESC');
    	return $this->result(0,'',$res);
  }
//商家商品列表
  public function doPageStoreGoodList(){
  		global $_W, $_GPC;
		$res=pdo_getall('zhls_sun_goods',array('store_id'=>$_GPC['store_id'],'state'=>2),array(),'','id DESC');
		echo json_encode($res);
  }
  //商家商品列表
  public function doPageStoreGoodList2(){
      global $_W, $_GPC;
    $res=pdo_getall('zhls_sun_goods',array('store_id'=>$_GPC['store_id'],'state'=>2,'is_show'=>1),array(),'','id DESC');
    echo json_encode($res);
  }
  //商品详情
  public function doPageGoodInfo(){
  		global $_W, $_GPC;
  		$res=pdo_get('zhls_sun_goods',array('id'=>$_GPC['id']));
  		$sql="select a.*,b.spec_name from " . tablename("zhls_sun_spec_value") . " a"  . " left join " . tablename("zhls_sun_goods_spec") . " b on b.id=a.spec_id  WHERE a.goods_id=:goods_id";
    	$res2=pdo_fetchall($sql,array(':goods_id'=>$_GPC['id']));
    	$data['good']=$res;
    	$data['spec']=$res2;
    	echo json_encode($data);
  }
 //下订单
 	public function doPageAddOrder(){
		  global $_W, $_GPC;
		  $data['user_id']=$_GPC['user_id'];//用户id
	      $data['store_id']=$_GPC['store_id'];//商家id
	      $data['money']=$_GPC['money'];//订单金额
	      $data['user_name']=$_GPC['user_name'];//用户名称
	      $data['address']=$_GPC['address'];//地址
	      $data['tel']=$_GPC['tel'];//电话
	      $data['good_id']=$_GPC['good_id'];//商品id
	      $data['good_name']=$_GPC['good_name'];//商品名称
	      $data['good_img']=$_GPC['good_img'];//商品图片
	      $data['good_money']=$_GPC['good_money'];//商品金额
	      $data['good_spec']=$_GPC['good_spec'];//商品规格
	      $data['freight']=$_GPC['freight'];//运费
        $data['note']=$_GPC['note'];//备注
        $data['good_num']=$_GPC['good_num'];//商品数量
	      $data['uniacid']=$_W['uniacid'];
	      $data['time']=time();//下单时间
	      $data['order_num']=date("YmdHis").rand(1111,9999);//订单号
	      $data['state']=1;//状态待付款
	      $data['del']=2;
	      $data['del2']=2;
	      $res=pdo_insert('zhls_sun_order',$data);
	      $post_id=pdo_insertid();
      if($res){
       /* pdo_update('zhls_sun_goods',array('goods_num -='=>$_GPC['good_num']),array('id'=>$_GPC['good_id']));
        pdo_update('zhls_sun_goods',array('sales +='=>$_GPC['good_num']),array('id'=>$_GPC['good_id']));*/
        echo  $post_id;
      }else{
        echo  '下单失败';
      }
 	}
//付款改变订单状态
  public function doPagePayOrder(){
      global $_W, $_GPC;
      //获取订单信息
      $orderinfo=pdo_get('zhls_sun_order',array('id'=>$_GPC['order_id']));
      pdo_update('zhls_sun_goods',array('goods_num -='=>$orderinfo['good_num'],'sales +='=>$orderinfo['good_num']),array('id'=>$orderinfo['good_id']));
      $res=pdo_update('zhls_sun_order',array('state'=>2,'pay_time'=>time()),array('id'=>$_GPC['order_id']));
      if($res){
        echo  '1';
      }else{
        echo  '2';
      }
  }
  //发货
  public function doPageDeliveryOrder(){
      global $_W, $_GPC;
       $res=pdo_update('zhls_sun_order',array('state'=>3,'fh_time'=>time()),array('id'=>$_GPC['order_id']));
       if($res){
        echo '1';
       }else{
        echo '2';
       }
  }
//确认收货
  public function doPageCompleteOrder(){
      global $_W, $_GPC;
      $order=pdo_get('zhls_sun_order',array('id'=>$_GPC['order_id']));
      $res=pdo_update('zhls_sun_order',array('state'=>4,'complete_time'=>time()),array('id'=>$_GPC['order_id']));
      if($res){
      	pdo_update('zhls_sun_store',array('wallet +='=>$order['money']));
      	$data['store_id']=$order['store_id'];
      	$data['money']=$order['money'];
      	$data['note']='商品订单';
      	$data['type']=1;
        $data['time']=date("Y-m-d H:i:s");
        pdo_insert('zhls_sun_store_wallet',$data);

/////////////////分销/////////////////

        $set=pdo_get('zhls_sun_fxset',array('uniacid'=>$_W['uniacid']));
        $order=pdo_get('zhls_sun_order',array('id'=>$_GPC['order_id']));
        if($set['is_open']==1){
            if($set['is_ej']==2){//不开启二级分销
       $user=pdo_get('zhls_sun_fxuser',array('fx_user'=>$order['user_id']));
       if($user){
            $userid=$user['user_id'];//上线id
            $money=$order['money']*($set['commission']/100);//一级佣金
            pdo_update('zhls_sun_user',array('commission +='=>$money),array('id'=>$userid));
            $data6['user_id']=$userid;//上线id
            $data6['son_id']=$order['user_id'];//下线id
            $data6['money']=$money;//金额
            $data6['time']=time();//时间
            $data6['uniacid']=$_W['uniacid'];
            pdo_insert('zhls_sun_earnings',$data6);
          }
      }else{//开启二级
       $user=pdo_get('zhls_sun_fxuser',array('fx_user'=>$order['user_id']));
          $user2=pdo_get('zhls_sun_fxuser',array('fx_user'=>$user['user_id']));//上线的上线
          if($user){
            $userid=$user['user_id'];//上线id
            $money=$order['money']*($set['commission']/100);//一级佣金
            pdo_update('zhls_sun_user',array('commission +='=>$money),array('id'=>$userid));
            $data6['user_id']=$userid;//上线id
            $data6['son_id']=$order['user_id'];//下线id
            $data6['money']=$money;//金额
            $data6['time']=time();//时间
            $data6['uniacid']=$_W['uniacid'];
            pdo_insert('zhls_sun_earnings',$data6);
          }
          if($user2){
            $userid2=$user2['user_id'];//上线的上线id
            $money=$order['money']*($set['commission2']/100);//二级佣金
            pdo_update('zhls_sun_user',array('commission +='=>$money),array('id'=>$userid2));
            $data7['user_id']=$userid2;//上线id
            $data7['son_id']=$order['user_id'];//下线id
            $data7['money']=$money;//金额
            $data7['time']=time();//时间
            $data7['uniacid']=$_W['uniacid'];
            pdo_insert('zhls_sun_earnings',$data7);
          }
        }
   }
      
/////////////////分销/////////////////




        echo  '1';
      }else{
        echo  '2';
      }
  }
  //查看商家余额明细
  public function doPageStoreWallet(){
      global $_W, $_GPC;
      $res=pdo_getall('zhls_sun_store_wallet',array('store_id'=>$_GPC['store_id']));
      echo json_encode($res);
  }
//查看我的订单
  public function doPageMyOrder(){
      global $_W, $_GPC;
      $pageindex = max(1, intval($_GPC['page']));
      $pagesize=10;
      $sql="select a.*,b.store_name from " . tablename("zhls_sun_order") . " a"  . " left join " . tablename("zhls_sun_store") . " b on b.id=a.store_id  WHERE a.user_id=:user_id and a.del=2";
      $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
  $res = pdo_fetchall($select_sql,array(':user_id'=>$_GPC['user_id']));
    	
    //  $res=pdo_getall('zhls_sun_order',array('user_id'=>$_GPC['user_id'],'del'=>2));
      echo json_encode($res);
  }
  //查看订单详情
  public function doPageOrderInfo(){
      global $_W, $_GPC;
     $sql="select a.*,b.store_name from " . tablename("zhls_sun_order") . " a"  . " left join " . tablename("zhls_sun_store") . " b on b.id=a.store_id  WHERE a.id=:id ";
    	$res=pdo_fetch($sql,array(':id'=>$_GPC['order_id']));
      echo json_encode($res);
  }
//更新用户地址信息
public function doPageUpdAdd(){
  global $_W, $_GPC;
  $data['user_name']=$_GPC['user_name'];
  $data['user_tel']=$_GPC['user_tel'];
  $data['user_address']=$_GPC['user_address'];
  $res=pdo_update('zhls_sun_user',$data,array('id'=>$_GPC['user_id']));
  if($res){
    echo '1';
  }else{
    echo '2';
  }
}
//用户删除订单
  public function doPageDelOrder(){
      global $_W, $_GPC;
      $res=pdo_update('zhls_sun_order',array('del'=>1),array('id'=>$_GPC['order_id']));
      if($res){
        echo  '1';
      }else{
        echo  '2';
      }
  }
//商家删除订单
  public function doPageDelOrder2(){
      global $_W, $_GPC;
      $res=pdo_update('zhls_sun_order',array('del2'=>1),array('id'=>$_GPC['order_id']));
      if($res){
        echo  '1';
      }else{
        echo  '2';
      }
  }
 //商家订单列表
 public function doPageStoreOrder(){
    global $_W, $_GPC;
    $sql="select a.*,b.name,b.img from " . tablename("zhls_sun_order") . " a"  . " left join " . tablename("zhls_sun_user") . " b on b.id=a.user_id  WHERE a.store_id=:store_id and a.del2=2";
    $res=pdo_fetchall($sql,array(':store_id'=>$_GPC['store_id']));
    echo json_encode($res);
 }
 //商家订单详情
 public function doPageStoreOrderInfo(){
    global $_W, $_GPC;
    $sql="select a.*,b.name,b.img from " . tablename("zhls_sun_order") . " a"  . " left join " . tablename("zhls_sun_user") . " b on b.id=a.user_id  WHERE a.id=:order_id and a.del2=2";
    $res=pdo_fetch($sql,array(':order_id'=>$_GPC['order_id']));
    echo json_encode($res);
 }
//申请退款
 public function doPageTuOrder(){
 	global $_W, $_GPC;
 	$res=pdo_update('zhls_sun_order',array('state'=>5),array('id'=>$_GPC['order_id']));
      if($res){
        echo  '1';
      }else{
        echo  '2';
      }
 }

 //申请分销商
  public function doPageDistribution(){
    global $_W, $_GPC;
    pdo_delete('zhls_sun_distribution',array('user_id'=>$_GPC['user_id']));
    $data['user_id']=$_GPC['user_id'];
    $data['user_name']=$_GPC['user_name'];
    $data['user_tel']=$_GPC['user_tel'];
    $data['time']=time();
    $data['state']=1;
    $data['uniacid']=$_W['uniacid'];
    $res=pdo_insert('zhls_sun_distribution',$data);
    if($res){
      echo  '1';
    }else{
      echo '2';
    }
  }
//查看我的申请
  public function doPageMyDistribution(){
    global $_W, $_GPC;
    $res=pdo_get('zhls_sun_distribution',array('user_id'=>$_GPC['user_id']));
    echo json_encode($res);
  }
//分销设置
  public function doPageFxSet(){
    global $_W, $_GPC;
    $res=pdo_get('zhls_sun_fxset',array('uniacid'=>$_W['uniacid']));
    echo json_encode($res);
  }
  //查看我的上线
  public function doPageMySx(){
    global $_W, $_GPC;
    $sql="select a.* ,b.name from " . tablename("zhls_sun_fxuser") . " a"  . " left join " . tablename("zhls_sun_user") . " b on b.id=a.user_id   WHERE a.fx_user=:fx_user ";
    $res=pdo_fetch($sql,array(':fx_user'=>$_GPC['user_id']));
    echo json_encode($res);
  }
   //查看我的佣金收益
  public function doPageEarnings(){
    global $_W, $_GPC;
    $sql="select a.* ,b.name,b.img from " . tablename("zhls_sun_earnings") . " a"  . " left join " . tablename("zhls_sun_user") . " b on b.id=a.son_id   WHERE a.user_id=:user_id order by id DESC";
    $res=pdo_fetchall($sql,array(':user_id'=>$_GPC['user_id']));
    echo json_encode($res);
  }
//我的二维码
  public function doPageMyCode(){
   global $_W, $_GPC;
   function  getCoade($storeid){
    function getaccess_token(){
      global $_W, $_GPC;
      $res=pdo_get('zhls_sun_system',array('uniacid' => $_W['uniacid']));
      $appid=$res['appid'];
      $secret=$res['appsecret'];
              // print_r($res);die;
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret."";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
      $data = curl_exec($ch);
      curl_close($ch);
      $data = json_decode($data,true);
      return $data['access_token'];
    }
    function set_msg($storeid){
     $access_token = getaccess_token();
     $data2=array(
      "scene"=>$storeid,
          // /"page"=>"zh_dianc/pages/info/info",
      "width"=>400
      );
     $data2 = json_encode($data2);
     $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=".$access_token."";
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL,$url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
     curl_setopt($ch, CURLOPT_POST,1);
     curl_setopt($ch, CURLOPT_POSTFIELDS,$data2);
     $data = curl_exec($ch);
     curl_close($ch);
     return $data;
   }
   $img=set_msg($storeid);
   $img=base64_encode($img);
   return $img;
 }
 echo getCoade($_GPC['user_id']);

}
//佣金提现
public function doPageYjtx(){
 global $_W, $_GPC;
 $data['user_id']=$_GPC['user_id'];
     $data['type']=$_GPC['type'];//类型
     $data['user_name']=$_GPC['user_name'];//姓名
     $data['account']=$_GPC['account'];//账号
     $data['tx_cost']=$_GPC['tx_cost'];//提现金额
     $data['sj_cost']=$_GPC['sj_cost'];//实际到账金额
     $data['state']=1;
     $data['time']=time();
     $data['uniacid']=$_W['uniacid'];
     $res=pdo_insert('zhls_sun_commission_withdrawal',$data);
     if($res){
      pdo_update('zhls_sun_user',array('commission -='=>$_GPC['tx_cost']),array('id'=>$_GPC['user_id']));
      echo '1';
    }else{
      echo '2';
    }
  }
//提现明细
  public function doPageYjtxList(){
   global $_W, $_GPC;
   $res=pdo_getall('zhls_sun_commission_withdrawal',array('user_id'=>$_GPC['user_id']),array(),'','id DESC');
   echo json_encode($res);
 }

//绑定分销商
 public function doPageBinding(){
  global $_W, $_GPC;
  $set=pdo_get('zhls_sun_fxset',array('uniacid'=>$_W['uniacid']));
  $res=pdo_get('zhls_sun_fxuser',array('fx_user'=>$_GPC['fx_user']));
  $res2=pdo_get('zhls_sun_fxuser',array('user_id'=>$_GPC['fx_user'],'fx_user'=>$_GPC['user_id']));
  if($set['is_open']==1){
    if($_GPC['user_id']==$_GPC['fx_user']){
   echo '自己不能绑定自己';
 }elseif($res || $res2){
   echo '不能重复绑定';
 }else{
   $res3=pdo_insert('zhls_sun_fxuser',array('user_id'=>$_GPC['user_id'],'fx_user'=>$_GPC['fx_user'],'time'=>time()));
   if($res3){
    echo  '1';
  }else{
    echo  '2';
  }
}
  }
  

}

//查看我的团队
public function doPageMyTeam(){
 global $_W, $_GPC;
 $sql="select a.* ,b.name,b.img from " . tablename("zhls_sun_fxuser") . " a"  . " left join " . tablename("zhls_sun_user") . " b on b.id=a.fx_user   WHERE a.user_id=:user_id order by id DESC";
 $res=pdo_fetchall($sql,array(':user_id'=>$_GPC['user_id']));
 $res2=array();
 for($i=0;$i<count($res);$i++){
  $sql2="select a.* ,b.name,b.img from " . tablename("zhls_sun_fxuser") . " a"  . " left join " . tablename("zhls_sun_user") . " b on b.id=a.fx_user   WHERE a.user_id=:user_id order by id DESC";
  $res3=pdo_fetchall($sql2,array(':user_id'=>$res[$i]['fx_user']));
  $res2[]=$res3;

}

$res4=array();
for($k=0;$k<count($res2);$k++){
  for($j=0;$j<count($res2[$k]);$j++){
    $res4[]=$res2[$k][$j]; 
  }

}
$data['one']=$res;
$data['two']=$res4;
  // print_r($data);die;
echo json_encode($data);
}

//查看佣金
public function doPageMyCommission(){
  global $_W, $_GPC;
    $system=pdo_get('zhls_sun_fxset',array('uniacid'=>$_W['uniacid']));//tx_money
    $user=pdo_get('zhls_sun_user',array('id'=>$_GPC['user_id']));
    if($user['commission']<$system['tx_money']){
      $ke=0.00;
    }else{
      $ke=$user['commission'];
    }
    $sq = "select sum(tx_cost) as tx_cost from " . tablename("zhls_sun_commission_withdrawal")." WHERE  user_id=".$_GPC['user_id'];
    $sq = pdo_fetch($sq);
    $sq= $sq['tx_cost'];

    $cg = "select sum(tx_cost) as tx_cost from " . tablename("zhls_sun_commission_withdrawal")." WHERE  state=2 and user_id=".$_GPC['user_id'];
    $cg = pdo_fetch($cg);
    $cg= $cg['tx_cost'];
  
    $lei = "select sum(money) as tx_cost from " . tablename("zhls_sun_earnings")." WHERE  user_id=".$_GPC['user_id'];
    $lei = pdo_fetch($lei);
    $lei= $lei['tx_cost'];

    $data['ke']=$ke;
    $data['sq']=$sq;
    $data['cg']=$cg;
    $data['lei']=$lei;
    echo json_encode($data);
}


//添加佣金
  public function doPageFx(){
    global $_W, $_GPC;
      $set=pdo_get('zhls_sun_fxset',array('uniacid'=>$_W['uniacid']));
        if($set['is_open']==1){
            if($set['is_ej']==2){//不开启二级分销
       $user=pdo_get('zhls_sun_fxuser',array('fx_user'=>$_GPC['user_id']));
       if($user){
            $userid=$user['user_id'];//上线id
            $money=$_GPC['money']*($set['commission']/100);//一级佣金
            pdo_update('zhls_sun_user',array('commission +='=>$money),array('id'=>$userid));
            $data6['user_id']=$userid;//上线id
            $data6['son_id']=$_GPC['user_id'];//下线id
            $data6['money']=$money;//金额
            $data6['time']=time();//时间
            $data6['uniacid']=$_W['uniacid'];
            pdo_insert('zhls_sun_earnings',$data6);
          }
      }else{//开启二级
       $user=pdo_get('zhls_sun_fxuser',array('fx_user'=>$_GPC['user_id']));
          $user2=pdo_get('zhls_sun_fxuser',array('fx_user'=>$user['user_id']));//上线的上线
          if($user){
            $userid=$user['user_id'];//上线id
            $money=$_GPC['money']*($set['commission']/100);//一级佣金
            pdo_update('zhls_sun_user',array('commission +='=>$money),array('id'=>$userid));
            $data6['user_id']=$userid;//上线id
            $data6['son_id']=$_GPC['user_id'];//下线id
            $data6['money']=$money;//金额
            $data6['time']=time();//时间
            $data6['uniacid']=$_W['uniacid'];
            pdo_insert('zhls_sun_earnings',$data6);
          }
          if($user2){
            $userid2=$user2['user_id'];//上线的上线id
            $money=$_GPC['money']*($set['commission2']/100);//二级佣金
            pdo_update('zhls_sun_user',array('commission +='=>$money),array('id'=>$userid2));
            $data7['user_id']=$userid2;//上线id
            $data7['son_id']=$_GPC['user_id'];//下线id
            $data7['money']=$money;//金额
            $data7['time']=time();//时间
            $data7['uniacid']=$_W['uniacid'];
            pdo_insert('zhls_sun_earnings',$data7);
          }
        }
        }
  }

//入驻黄页
  public function doPageYellowPage(){
      global $_W, $_GPC;
      $system=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
      $data['user_id']=$_GPC['user_id'];
      $data['logo']=$_GPC['logo'];
      $data['company_name']=$_GPC['company_name'];
      $data['company_address']=$_GPC['company_address'];
      $data['type_id']=$_GPC['type_id'];
      $data['link_tel']=$_GPC['link_tel'];
      $data['rz_type']=$_GPC['rz_type'];
      $data['coordinates']=$_GPC['coordinates'];
      $data['content']=$_GPC['content'];
      $data['imgs']=$_GPC['imgs'];
      $data['tel2']=$_GPC['tel2'];
      $data['cityname']=$_GPC['cityname'];
      $data['uniacid']=$_W['uniacid'];
      $data['time_over']=2;
      if($system['is_hyset']==1){
          $data['state']=1;
      }else{
        $data['state']=2;
        $data['sh_time']=time();
      }

      $res=pdo_insert('zhls_sun_yellowstore',$data);
      $hy_id=pdo_insertid();
      if($res){
        echo  $hy_id;
      }else{
        echo  '2';
      }
  }
  //查看我入驻的黄页
  public function doPageMyYellowPage(){
      global $_W, $_GPC;
      $sql="select a.* ,b.type_name from " . tablename("zhls_sun_yellowstore") . " a"  . " left join " . tablename("zhls_sun_storetype") . " b on b.id=a.type_id   WHERE a.user_id=:user_id order by a.id desc ";
      $res=pdo_fetchall($sql,array(':user_id'=>$_GPC['user_id']));

      echo json_encode($res);
  }
  //查看黄页列表
  public function doPageYellowPageList(){
    global $_W, $_GPC;
    //修改以前的数据

    $list=pdo_getall('zhls_sun_yellowstore',array('uniacid'=>$_W['uniacid'],'state'=>2));
    foreach($list as $v){
      $set=pdo_get('zhls_sun_yellowset',array('id'=> $v['rz_type']));
      pdo_update('zhls_sun_yellowstore',array('dq_time'=> $v['sh_time']+$set['days']*24*60*60),array('id'=>$v['id']));
    }
    $rst=pdo_update('zhls_sun_yellowstore',array('time_over'=>1),array('dq_time <='=>time(),'state'=>2));
    $pageindex = max(1, intval($_GPC['page']));
    $pagesize=10;
    $where=" WHERE a.uniacid=:uniacid and a.state=2 and a.time_over=2 ";
    if($_GPC['cityname']){
        $where.=" and a.cityname LIKE  concat('%', :name,'%') ";  
        $data[':name']=$_GPC['cityname'];
    }
     if($_GPC['keywords']){
        $where.=" and a.company_name LIKE  concat('%', :name,'%') ";  
        $data[':name']=$_GPC['keywords'];
    }
    $data[':uniacid']=$_W['uniacid'];
    $sql="select a.* ,b.type_name from " . tablename("zhls_sun_yellowstore") . " a"  . " left join " . tablename("zhls_sun_storetype") . " b on b.id=a.type_id ".$where." order by id DESC";
   // $res=pdo_fetch($sql,array(':uniacid'=>$_W['uniacid']));
    $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
    $res = pdo_fetchall($select_sql,$data);
    echo json_encode($res);
  }
  //查看黄页详情
  public function doPageYellowPageInfo(){
      global $_W, $_GPC;
      pdo_update('zhls_sun_yellowstore',array('views +='=>1),array('id'=>$_GPC['id']));
      $sql="select a.* ,b.type_name from " . tablename("zhls_sun_yellowstore") . " a"  . " left join " . tablename("zhls_sun_storetype") . " b on b.id=a.type_id   WHERE a.id=:id";
      $res=pdo_fetch($sql,array(':id'=>$_GPC['id']));

      echo json_encode($res);
  }
//查看黄页入驻设置
  public function doPageYellowSet(){
      global $_W, $_GPC;
      $res=pdo_getall('zhls_sun_yellowset',array('uniacid'=>$_W['uniacid']),array(),'','num asc');
      echo json_encode($res);
  }

//登录
  public function doPageStoreLogin(){
  		global $_W, $_GPC;
  		$res=pdo_get('zhls_sun_store',array('user_name'=>$_GPC['user_name']));
  		$res2=pdo_get('zhls_sun_store',array('user_name'=>$_GPC['user_name'],'pwd'=>md5($_GPC['pwd'])));
  		if(!$res){
  			echo '账号不存在!';
  		}elseif(!$res2){
  			echo '密码不正确!';
  		}elseif($res2){
  			echo json_encode($res2);
  		}
  		
  }










    //上传图片
  public function doPageUpload(){
          $uptypes=array(  
            'image/jpg',  
            'image/jpeg',  
            'image/png',  
            'image/pjpeg',  
            'image/gif',  
            'image/bmp',  
            'image/x-png'  
            );  
    $max_file_size=2000000;     //上传文件大小限制, 单位BYTE  
    $destination_folder="../attachment/"; //上传文件路径  
    $watermark=2;      //是否附加水印(1为加水印,其他为不加水印);  
    $watertype=1;      //水印类型(1为文字,2为图片)  
    $waterposition=1;     //水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中);  
    $waterstring="666666";  //水印字符串  
    // $waterimg="xplore.gif";    //水印图片  
    $imgpreview=1;      //是否生成预览图(1为生成,其他为不生成);  
    $imgpreviewsize=1/2;    //缩略图比例 
    if (!is_uploaded_file($_FILES["upfile"]['tmp_name']))  
    //是否存在文件  
    {  
     echo "图片不存在!";  
     exit;  
   }
   $file = $_FILES["upfile"];
   if($max_file_size < $file["size"])
    //检查文件大小  
   {
    echo "文件太大!";
    exit;
  }
  if(!in_array($file["type"], $uptypes))  
    //检查文件类型
  {
    echo "文件类型不符!".$file["type"];
    exit;
  }
  if(!file_exists($destination_folder))
  {
    mkdir($destination_folder);
  }  
  $filename=$file["tmp_name"];  
  $image_size = getimagesize($filename);  
  $pinfo=pathinfo($file["name"]);  
  $ftype=$pinfo['extension'];  
  $destination = $destination_folder.str_shuffle(time().rand(111111,999999)).".".$ftype;  
  if (file_exists($destination) && $overwrite != true)  
  {  
    echo "同名文件已经存在了";  
    exit;  
  }  
  if(!move_uploaded_file ($filename, $destination))  
  {  
    echo "移动文件出错";  
    exit;
  }
  $pinfo=pathinfo($destination);  
  $fname=$pinfo['basename'];  
    // echo " <font color=red>已经成功上传</font><br>文件名:  <font color=blue>".$destination_folder.$fname."</font><br>";  
    // echo " 宽度:".$image_size[0];  
    // echo " 长度:".$image_size[1];  
    // echo "<br> 大小:".$file["size"]." bytes";  
  if($watermark==1)  
  {  
    $iinfo=getimagesize($destination,$iinfo);  
    $nimage=imagecreatetruecolor($image_size[0],$image_size[1]);
    $white=imagecolorallocate($nimage,255,255,255);
    $black=imagecolorallocate($nimage,0,0,0);
    $red=imagecolorallocate($nimage,255,0,0);
    imagefill($nimage,0,0,$white);
    switch ($iinfo[2])
    {  
      case 1:
      $simage =imagecreatefromgif($destination);
      break;
      case 2:
      $simage =imagecreatefromjpeg($destination);
      break;
      case 3:
      $simage =imagecreatefrompng($destination);
      break;
      case 6:
      $simage =imagecreatefromwbmp($destination);
      break;
      default:
      die("不支持的文件类型");
      exit;
    }
    imagecopy($nimage,$simage,0,0,0,0,$image_size[0],$image_size[1]);
    imagefilledrectangle($nimage,1,$image_size[1]-15,80,$image_size[1],$white);
    switch($watertype)  
    {
            case 1:   //加水印字符串
            imagestring($nimage,2,3,$image_size[1]-15,$waterstring,$black);
            break;
            case 2:   //加水印图片
            $simage1 =imagecreatefromgif("xplore.gif");
            imagecopy($nimage,$simage1,0,0,0,0,85,15);
            imagedestroy($simage1);
            break;
          }
          switch ($iinfo[2])
          {
            case 1:
            //imagegif($nimage, $destination);
            imagejpeg($nimage, $destination);
            break;
            case 2:
            imagejpeg($nimage, $destination);
            break;
            case 3:
            imagepng($nimage, $destination);
            break;
            case 6:
            imagewbmp($nimage, $destination);
            //imagejpeg($nimage, $destination);
            break;
          }
        //覆盖原上传文件
          imagedestroy($nimage);
          imagedestroy($simage);
        }
    // if($imgpreview==1)  
    // {  
    // echo "<br>图片预览:<br>";  
    // echo "<img src=\"".$destination."\" width=".($image_size[0]*$imgpreviewsize)." height=".($image_size[1]*$imgpreviewsize);  
    // echo " alt=\"图片预览:\r文件名:".$destination."\r上传时间:\">";  
    // } 
        echo $fname;
        @require_once (IA_ROOT . '/framework/function/file.func.php');
        @$filename=$fname;
        @file_remote_upload($filename); 
      }
/////////////////////////////////////////



   // 咨询成功通知
public function doPagePaysuccess(){
    global $_W, $_GPC;
   function getaccess_token($_W){
     $res=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
     $appid=$res['appid'];
     $secret=$res['appsecret'];
     $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret."";
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL,$url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
     $data = curl_exec($ch);
     curl_close($ch);
     $data = json_decode($data,true);
     return $data['access_token'];
   }
      //设置与发送模板信息

 function set_msg($_W, $_GPC){
   $access_token = getaccess_token($_W);
   $res=pdo_get('zhls_sun_sms',array('uniacid'=>$_W['uniacid']));
     $prepay_id = trim($_GPC['prepay_id'],'prepay_id=');
    // 咨询数据
     $data = pdo_get('zhls_sun_fproblem',array('uniacid'=>$_W['uniacid'],'fid'=>$_GPC['fid']));
     $data['money'] = pdo_getcolumn('zhls_sun_lawyer',array('uniacid'=>$_W['uniacid'],'id'=>$data['ls_id']),'appmoney');
     $data['name'] = pdo_getcolumn('zhls_sun_lawyer',array('uniacid'=>$_W['uniacid'],'id'=>$data['ls_id']),'lawyers');
     $data['type_name'] = pdo_getcolumn('zhls_sun_type',array('uniacid'=>$_W['uniacid'],'id'=>$data['an_id']),'type_name');
   $formwork ='{
     "touser": "'.$_GET["openid"].'",
     "template_id": "'.$res["tid1"].'",
     "page":"zhls_sun/pages/shouye/index",
     "form_id":"'.$prepay_id.'",
     "data": {
       "keyword1": {
         "value": "'.$data['name'].'",
         "color": "#173177"
       },
       "keyword2": {
         "value":"'.$data['user_name'].'",
         "color": "#173177"
       },
       "keyword3": {
         "value": "'.$data['type_name'].'",
         "color": "#173177"
       },
       "keyword4": {
         "value": "'.$data['money'].'",
         "color": "#173177"
       },
       "keyword5": {
         "value":  "'. $data['problem'] .'",
         "color": "#173177"
       }
     }   
   }';
             // $formwork=$data;
   $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$access_token."";
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL,$url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
   curl_setopt($ch, CURLOPT_POST,1);
   curl_setopt($ch, CURLOPT_POSTFIELDS,$formwork);
   $data = curl_exec($ch);
   curl_close($ch);
   return $data;
 }
 echo set_msg($_W,$_GPC);
}


 //商家入驻模板消息
public function doPageRzMessage(){
    global $_W, $_GPC;
   function getaccess_token($_W){
     $res=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
     $appid=$res['appid'];
     $secret=$res['appsecret'];
     $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret."";
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL,$url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
     $data = curl_exec($ch);
     curl_close($ch);
     $data = json_decode($data,true);
     return $data['access_token'];
   }
      //设置与发送模板信息

 function set_msg($_W, $_GPC){
   $access_token = getaccess_token($_W);
   $res2=pdo_get('zhls_sun_sms',array('uniacid'=>$_W['uniacid']));
 $sql="select a.store_name,a.time,a.state,b.name as user_name from " . tablename("zhls_sun_store") . " a"  . " left join " . tablename("zhls_sun_user") . " b on b.id=a.user_id  WHERE a.id=:store_id";
  $res=pdo_fetch($sql,array(':store_id'=>$_GPC['store_id']));
  $type="待审核";
  $note="1-3日完成审核";
   $formwork ='{
     "touser": "'.$_GET["openid"].'",
     "template_id": "'.$res2["tid1"].'",
     "page":"zhls_sun/pages/index/index",
     "form_id":"'.$_GET['form_id'].'",
     "data": {
       "keyword1": {
         "value": "'.$res['store_name'].'",
         "color": "#173177"
       },
       "keyword2": {
         "value":"'.$res['user_name'].'",
         "color": "#173177"
       },
       "keyword3": {
         "value": "'.$res['time'].'",
         "color": "#173177"
       },
       "keyword4": {
         "value": "'.$type.'",
         "color": "#173177"
       },
       "keyword5": {
         "value":  "'. $note.'",
         "color": "#173177"
       }
     }   
   }';
             // $formwork=$data;
   $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$access_token."";
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL,$url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
   curl_setopt($ch, CURLOPT_POST,1);
   curl_setopt($ch, CURLOPT_POSTFIELDS,$formwork);
   $data = curl_exec($ch);
   curl_close($ch);
   return $data;
 }
 echo set_msg($_W,$_GPC);
}


//保存商家支付记录
  public function doPageSaveStorePayLog(){
    global $_W, $_GPC;
    $data['store_id']=$_GPC['store_id'];
    $data['money']=$_GPC['money'];
    $data['time']=date('Y-m-d H:i:s');
    $data['uniacid']=$_W['uniacid'];
    $res=pdo_insert('zhls_sun_storepaylog',$data);
    if($res){
      echo  '1';
    }else{
      echo  '2';
    }
  }

  //保存帖子支付记录
  public function doPageSaveTzPayLog(){
    global $_W, $_GPC;
    $data['tz_id']=$_GPC['tz_id'];
    $data['money']=$_GPC['money'];
    $data['time']=date('Y-m-d H:i:s');
    $data['uniacid']=$_W['uniacid'];
    $res=pdo_insert('zhls_sun_tzpaylog',$data);
    if($res){
      echo  '1';
    }else{
      echo  '2';
    }
  }

    //保存拼车支付记录
  public function doPageSaveCarPayLog(){
    global $_W, $_GPC;
    $data['car_id']=$_GPC['car_id'];
    $data['money']=$_GPC['money'];
    $data['time']=date('Y-m-d H:i:s');
    $data['uniacid']=$_W['uniacid'];
    $res=pdo_insert('zhls_sun_carpaylog',$data);
    if($res){
      echo  '1';
    }else{
      echo  '2';
    }
  }

//保存黄页支付记录
  public function doPageSaveHyPayLog(){
    global $_W, $_GPC;
    $data['hy_id']=$_GPC['hy_id'];
    $data['money']=$_GPC['money'];
    $data['time']=date('Y-m-d H:i:s');
    $data['uniacid']=$_W['uniacid'];
    $res=pdo_insert('zhls_sun_yellowpaylog',$data);
    if($res){
      echo  '1';
    }else{
      echo  '2';
    }
  }
//保存定位城市

public function doPageSaveHotCity(){
   global $_W, $_GPC;
  $rst=pdo_get('zhls_sun_hotcity',array('cityname'=>$_GPC['cityname'],'uniacid'=>$_W['uniacid'],'user_id'=>$_GPC['user_id']));
   if(empty($rst)){
    $data['user_id']=$_GPC['user_id'];
     $data['cityname']=$_GPC['cityname'];
    $data['time']=time();
    $data['uniacid']=$_W['uniacid'];
    $res=pdo_insert('zhls_sun_hotcity',$data);
    if($res){
      echo  '1';
    }else{
      echo  '2';
    }
}

}



//红包
 public function doPageRedPaperList(){
      global $_GPC, $_W;
      $sql="select a.*,b.logo,c.img as user_img from " . tablename("zhls_sun_information") . " a"  . " left join " . tablename("zhls_sun_store") . " b on b.id=a.store_id"  . " left join " . tablename("zhls_sun_user") . " c on c.id=a.user_id  WHERE a.uniacid=:uniacid and a.hb_num>0 and a.del=2 and a.state=2 ORDER BY a.id DESC";
     $res=pdo_fetchall($sql,array(':uniacid'=>$_W['uniacid']));
      echo json_encode($res);
  }

//获取城市

public function doPageGetCity(){
	global $_W, $_GPC;
  $res=pdo_getall('zhls_sun_hotcity',array('uniacid'=>$_W['uniacid'],'user_id'=>$_GPC['user_id']));
  echo json_encode($res);
}


//保存formid
  public function doPageSaveFormid(){
    global $_W, $_GPC;
    $data['user_id']=$_GPC['user_id'];
    $data['form_id']=$_GPC['form_id'];
    $data['openid']=$_GPC['openid']; 
    $data['time']=date('Y-m-d H:i:s');
    $data['uniacid']=$_W['uniacid'];
    $res=pdo_insert('zhls_sun_userformid',$data);
    if($res){
      echo  '1';
    }else{
      echo  '2';
    }
  }


 //帖子评论成功模板消息
public function doPageTzhfMessage(){
    global $_W, $_GPC;
   function getaccess_token($_W){
     $res=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
     $appid=$res['appid'];
     $secret=$res['appsecret'];
     $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret."";
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL,$url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
     $data = curl_exec($ch);
     curl_close($ch);
     $data = json_decode($data,true);
     return $data['access_token'];
   }
      //设置与发送模板信息

 function set_msg($_W, $_GPC){
   $access_token = getaccess_token($_W);
   $res2=pdo_get('zhls_sun_sms',array('uniacid'=>$_W['uniacid']));
 $sql="select a.details,a.information_id,a.time,b.name as user_name from " . tablename("zhls_sun_comments") . " a"  . " left join " . tablename("zhls_sun_user") . " b on b.id=a.user_id  WHERE a.id=:id ";
  $res=pdo_fetch($sql,array(':id'=>$_GPC['pl_id']));
  $time=date("Y-m-d H:i:s",$res['time']);
   $formwork ='{
     "touser": "'.$_GET["openid"].'",
     "template_id": "'.$res2["tid3"].'",
     "page":"zhls_sun/pages/infodetial/infodetial?id='.$res['information_id'].'",
     "form_id":"'.$_GET['form_id'].'",
     "data": {
       "keyword1": {
         "value": "'.$res['details'].'",
         "color": "#173177"
       },
       "keyword2": {
         "value":"'.$res['user_name'].'",
         "color": "#173177"
       },
       "keyword3": {
         "value": "'.$time.'",
         "color": "#173177"
       }
      
     }   
   }';
             // $formwork=$data;
   $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$access_token."";
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL,$url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
   curl_setopt($ch, CURLOPT_POST,1);
   curl_setopt($ch, CURLOPT_POSTFIELDS,$formwork);
   $data = curl_exec($ch);
   curl_close($ch);
   return $data;
 }
 echo set_msg($_W,$_GPC);
}


//帖子评论成功模板消息
public function doPageStorehfMessage(){
    global $_W, $_GPC;
   function getaccess_token($_W){
     $res=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
     $appid=$res['appid'];
     $secret=$res['appsecret'];
     $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret."";
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL,$url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
     $data = curl_exec($ch);
     curl_close($ch);
     $data = json_decode($data,true);
     return $data['access_token'];
   }
      //设置与发送模板信息

 function set_msg($_W, $_GPC){
   $access_token = getaccess_token($_W);
   $res2=pdo_get('zhls_sun_sms',array('uniacid'=>$_W['uniacid']));
 $sql="select a.details,a.store_id,a.time,b.name as user_name from " . tablename("zhls_sun_comments") . " a"  . " left join " . tablename("zhls_sun_user") . " b on b.id=a.user_id  WHERE a.id=:id ";
  $res=pdo_fetch($sql,array(':id'=>$_GPC['pl_id']));
  $time=date("Y-m-d H:i:s",$res['time']);
   $formwork ='{
     "touser": "'.$_GET["openid"].'",
     "template_id": "'.$res2["tid3"].'",
     "page":"zhls_sun/pages/sellerinfo/sellerinfo?id='.$res['store_id'].'",
     "form_id":"'.$_GET['form_id'].'",
     "data": {
       "keyword1": {
         "value": "'.$res['details'].'",
         "color": "#173177"
       },
       "keyword2": {
         "value":"'.$res['user_name'].'",
         "color": "#173177"
       },
       "keyword3": {
         "value": "'.$time.'",
         "color": "#173177"
       }
      
     }   
   }';
             // $formwork=$data;
   $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$access_token."";
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL,$url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
   curl_setopt($ch, CURLOPT_POST,1);
   curl_setopt($ch, CURLOPT_POSTFIELDS,$formwork);
   $data = curl_exec($ch);
   curl_close($ch);
   return $data;
 }
 echo set_msg($_W,$_GPC);
}


    //商家福利
public function doPageMyPost2(){
  global $_GPC, $_W;
   $pageindex = max(1, intval($_GPC['page']));
  $pagesize=10;
  $sql="select a.*,b.type_name,c.name as type2_name from " . tablename("zhls_sun_information") . " a"  . " left join " . tablename("zhls_sun_type") . " b on b.id=a.type_id  " . " left join " . tablename("zhls_sun_type2") . " c on a.type2_id=c.id   WHERE a.store_id=:store_id and a.del=2   ORDER BY a.id DESC";
  $select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
  $res = pdo_fetchall($select_sql,array(':store_id'=>$_GPC['user_id']));
 
  echo json_encode($res);
}

//红包分享

public function doPageHbFx(){
  global $_GPC, $_W;
  $res=pdo_update('zhls_sun_information',array('hbfx_num +='=>1),array('id'=>$_GPC['information_id']));
  if($res){
    echo 1;
  }else{
    echo 2;
  }
}




    /************************************************首页*****************************************************/
    //获取openid
    public function doPageOpenid(){
        global $_W, $_GPC;
        $res=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
        $code=$_GPC['code'];
        $appid=$res['appid'];
        $secret=$res['appsecret'];
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=".$appid."&secret=".$secret."&js_code=".$code."&grant_type=authorization_code";
        function httpRequest($url,$data = null){
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            if (!empty($data)){
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($curl);
            curl_close($curl);
            return $output;
        }
        $re=httpRequest($url);
        print_r($re);
    }

    //登录用户信息
    public function doPageLogin(){
        global $_GPC, $_W;
        $openid=$_GPC['openid'];
        $res=pdo_get('zhls_sun_user',array('openid'=>$openid,'uniacid'=>$_W['uniacid']));
        if($openid and $openid!='undefined'){
            if($res){
				if($res['rtime']==null || $res['rtime']==0){
					$data['rtime'] = time();
				}
                $user_id=$res['id'];
                $data['openid']=$_GPC['openid'];
                $data['img']=$_GPC['img'];
                $data['name']=$_GPC['name'];
                $data['time']=date('Y-m-d H:i:s',time());
                $res = pdo_update('zhls_sun_user', $data, array('id' =>$user_id));
                $user=pdo_get('zhls_sun_user',array('openid'=>$openid,'uniacid'=>$_W['uniacid']));
                echo json_encode($user);
            }else{
                $data['openid']=$_GPC['openid'];
                $data['img']=$_GPC['img'];
                $data['name']=$_GPC['name'];
                $data['uniacid']=$_W['uniacid'];
                $data['time']=date('Y-m-d H:i:s',time());
				$data['rtime']=time();
                $res2=pdo_insert('zhls_sun_user',$data);
                $user=pdo_get('zhls_sun_user',array('openid'=>$openid,'uniacid'=>$_W['uniacid']));
                echo json_encode($user);
            }
        }
    }

    // 进入首页添加用户
    public function doPageAddopen(){
        global $_W,$_GPC;
        $openid = $_GPC['openid'];
        $data = [
            'name'=>$_GPC['nickName'],
            'openid'=>$openid,
            'uniacid'=>$_W['uniacid'],
            'img'=>$_GPC['avatarUrl'],
            'time'=>date('Y-m-d H:i:s',time()),
        ];
        $result = pdo_get('zhls_sun_user',['uniacid'=>$_W['uniacid'],'openid'=>$openid]);
		if($result['rtime']==null || $result['rtime']==0){
			$data['rtime'] = time();
		}
        
		$oldData = pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
        $num = $oldData['service_num'] + 1;
        pdo_update('zhls_sun_system',array('service_num'=>$num),array('uniacid'=>$_W['uniacid']));
        if(!$result){
            $res = pdo_insert('zhls_sun_user',$data);
        }else{
            $res = pdo_update('zhls_sun_user',$data,['openid'=>$openid,'uniacid'=>$_W['uniacid']]);
        }
        echo json_encode($res);
    }

    // 用户数据展示
    public function doPageuserData(){
        global $_GPC,$_W;
        $data = pdo_getall('zhls_sun_user',array('uniacid'=>$_W['uniacid']),'','','time DESC','4');
        echo json_encode($data);
    }

    // 用户充值
    public function doPagechongqian(){
        global $_W,$_GPC;
        $uid = $_GPC['uid'];
        $price = $_GPC['price'];
        $data = pdo_get('zhls_sun_user',['uniacid'=>$_W['uniacid'],'openid'=>$uid]);
        $price = $data['money'] + $price;
        $res = pdo_update('zhls_sun_user',['money'=>$price],['uniacid'=>$_W['uniacid'],'openid'=>$uid]);
        return $this->result(0,'',$res);
    }

    // 用户数据
    public function doPageMoneyData(){
        global $_W,$_GPC;
        $uid = $_GPC['uid'];
        $data = pdo_get('zhls_sun_user',['openid'=>$uid,'uniacid'=>$_W['uniacid']]);
        return $this->result(0,'',$data);
    }



    //获取企业简介
    public function doPagebrief(){
        global $_W;
        $data = pdo_get('zhls_sun_family',array('uniacid'=>$_W['uniacid']));
        $address = pdo_getcolumn('zhls_sun_system',array('uniacid'=>$_W['uniacid']),'address');
        $data['address'] = $address;
        echo json_encode($data);
    }


//获取首页轮播图
public function doPageBanner(){
    global $_GPC, $_W;
    $banner=pdo_get('zhls_sun_banner',['uniacid'=>$_W['uniacid']]);
    $banner['lb_imgs'] = explode(',',$banner['lb_imgs']);
//    foreach ($banner['lb_imgs'] as $k=>$v){
//        $banner['lb_imgs'][$k] = $_W['attachurl'].$v;
//    }
    return $this->result(0,',',$banner);
}

// 获取业务id数据
public function doPagebusinessData(){
        global $_GPC,$_W;
        $id = $_GPC['id'];
        $data = pdo_get('zhls_sun_goods',array('uniacid'=>$_W['uniacid'],'id'=>$id));
        echo json_encode($data);
}

// 获取预约数最多的6位发型师数据
public function doPagelawyers(){
    global $_GPC, $_W;
    $lat = $_GPC['latitude'];
    $lng = $_GPC['longitude'];
    $sql = ' SELECT * FROM ' . tablename('zhls_sun_lawtype') . ' lt ' . ' JOIN ' . tablename('zhls_sun_lawyer') .' l ' . ' ON ' . ' l.cate=lt.id' . ' WHERE ' . ' l.uniacid=' . $_W['uniacid'] . ' and l.state=1 ORDER BY ' .  ' l.id DESC';
    $data = pdo_fetchall($sql);
//    $hair = pdo_getall('zhls_sun_lawyer',['uniacid'=>$_W['uniacid']],'','','id DESC','6');
    foreach ($data as $k=>$v){
        $data[$k]['logo'] = $_W['attachurl'].$v['logo'];
    }
    $hair = $this->Start($data);
    $dis = array();
    foreach ($hair as $k=>$v){
        $hair[$k]['distance'] = round(($this->getdistance($lat,$lng,$v['lat'],$v['lng']))/1000,2);
    }
    foreach ($hair as $k=>$v){
        $dis[$k] = $v['distance'];
    }
    array_multisort($dis,SORT_ASC,$hair);

    return $this->result(0,',',$hair);
}


    /**
     * 求两个已知经纬度之间的距离,单位为米
     *
     * @param lng1 $ ,lng2 经度
     * @param lat1 $ ,lat2 纬度
     * @return float 距离，单位米
     */
    function getdistance($lng1, $lat1, $lng2, $lat2) {
        // 将角度转为弧度
        $radLat1 = deg2rad($lat1); //deg2rad()函数将角度转换为弧度
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;
        return $s;
    }


// 所有律师shuju
public function doPageAlllawyers(){
    global $_GPC, $_W;
    $lat = $_GPC['latitude'];
    $lng = $_GPC['longitude'];

    $datas = pdo_getall('zhls_sun_lawyer',array('uniacid'=>$_W['uniacid'],"state"=>1));
    $dis = array();
    foreach ($datas as $k=>$v){
        $datas[$k]['distance'] = round(($this->getdistance($lat,$lng,$v['lat'],$v['lng']))/1000,2);
    }
    foreach ($datas as $k=>$v){
        $dis[$k] = $v['distance'];
    }
    array_multisort($dis,SORT_ASC,$datas);
     // 就近城市
    $address = pdo_get('zhls_sun_city',array('id'=>$datas[0]['city_id']));
    // 获取律师数据
    $sql = ' SELECT * FROM ' . tablename('zhls_sun_lawtype') . ' lt ' . ' JOIN ' . tablename('zhls_sun_lawyer') .' l ' . ' ON ' . ' l.cate=lt.id' . ' WHERE ' . ' l.uniacid=' . $_W['uniacid'] . ' AND ' . ' l.city_id=' . $datas[0]['city_id'] . ' and l.state=1';
    $data = pdo_fetchall($sql);
    foreach ($data as $k=>$v){
        $data[$k]['logo'] = $_W['attachurl'].$v['logo'];
    }
    $hair = $this->Start($data);
    $diss = array();
    foreach ($hair as $k=>$v){
        $hair[$k]['distance'] = round(($this->getdistance($lat,$lng,$v['lat'],$v['lng']))/1000,2);
    }
    foreach ($hair as $k=>$v){
        $diss[$k] = $v['distance'];
    }
    array_multisort($diss,SORT_ASC,$hair);
     // 获取所有城市
    $lawyer = pdo_getall('zhls_sun_lawyer',array('uniacid'=>$_W['uniacid'],'state'=>1));
    $city = array();
    foreach ($lawyer as $k=>$v){
        $city[$v['city_id']][] = $v['city_id'];
    }
    $city_id = array();
    foreach ($city as $k=>$v){
        $city_id[] = $k;
    }
    $citys = pdo_getall('zhls_sun_city',array('id in'=>$city_id));
    foreach ($citys as $k=>$v){
        if($v['id']==$address['id']){
            $index = $k;
            $city_ids = $v['id'];
        }
    }
    $newData = array(
        'index'=>$index,
        'hair'=>$hair,
        'city'=>$citys,
        'city_id'=>$city_ids
    );
    return $this->result(0,',',$newData);
}

// 获取律师分类
public function doPageLawtypeData(){
        global $_W;
        $type = pdo_getall('zhls_sun_lawtype',array('uniacid'=>$_W['uniacid'],'state'=>1));
        echo json_encode($type);
}

// 根据对应的分类id获取律师数据
    public function doPageTypeIdData(){
        global $_GPC,$_W;
        $id = $_GPC['id'];
        $lat = $_GPC['latitude'];
        $lng = $_GPC['longitude'];
        $city_id = $_GPC['city_id'];
        if($city_id==0){
            if($id == 0){
                $sql = ' SELECT * FROM ' . tablename('zhls_sun_lawtype') . ' lt ' . ' JOIN ' . tablename('zhls_sun_lawyer') .' l ' . ' ON ' . ' l.cate=lt.id' . ' WHERE ' . ' l.uniacid=' . $_W['uniacid'] . ' and l.state=1';
            }else{
                $sql = ' SELECT * FROM ' . tablename('zhls_sun_lawtype') . ' lt ' . ' JOIN ' . tablename('zhls_sun_lawyer') .' l ' . ' ON ' . ' l.cate=lt.id' . ' WHERE ' . ' l.uniacid=' . $_W['uniacid'] . ' AND ' . ' l.cate='.$id.' and l.state=1';
            }
        }else{
            if($id == 0){
                $sql = ' SELECT * FROM ' . tablename('zhls_sun_lawtype') . ' lt ' . ' JOIN ' . tablename('zhls_sun_lawyer') .' l ' . ' ON ' . ' l.cate=lt.id' . ' WHERE ' . ' l.uniacid=' . $_W['uniacid'] . ' AND l.city_id=' . $city_id . ' and l.state=1';
            }else{
                $sql = ' SELECT * FROM ' . tablename('zhls_sun_lawtype') . ' lt ' . ' JOIN ' . tablename('zhls_sun_lawyer') .' l ' . ' ON ' . ' l.cate=lt.id' . ' WHERE ' . ' l.uniacid=' . $_W['uniacid'] . ' AND ' . ' l.cate='.$id . ' AND l.city_id=' . $city_id . ' and l.state=1';
            }

        }
        $data = pdo_fetchall($sql);
        foreach ($data as $k=>$v){
            $data[$k]['logo'] = $_W['attachurl'].$v['logo'];
        }
        $hair = $this->Start($data);

        $dis = array();
        foreach ($hair as $k=>$v){
            $hair[$k]['distance'] = round(($this->getdistance($lat,$lng,$v['lat'],$v['lng']))/1000,2);
        }
        foreach ($hair as $k=>$v){
            $dis[$k] = $v['distance'];
        }
        array_multisort($dis,SORT_ASC,$hair);
        echo json_encode($hair);
    }

    /**
     * 获取星级
     *
     */
    public function Start($hair)
    {
        $star = [];
        for ($j=0;$j<count($hair);$j++){
            for ($i=0;$i<$hair[$j]['star'];$i++){
                $star[$j][$i] = 1;
            }
        }
        foreach ($hair as $k=>$v){
            foreach ($star as $kk=>$vv){
                if($k==$kk){
                    $hair[$k]['star'] = $vv;
                    $hair[$k]['kong'] = 5-count($vv);
                }
            }
        }
        $kong = [];
        for ($j=0;$j<count($hair);$j++){
            for ($i=0;$i<$hair[$j]['kong'];$i++){
                $kong[$j][$i] = 1;
            }
        }
        foreach ($hair as $k=>$v){
            foreach ($kong as $kk=>$vv){
                if($k==$kk){
                    $hair[$k]['kong'] = $vv;
                }
            }
        }
        return $hair;
    }


// 获取案例
public function doPageanliData(){
        global $_GPC,$_W;
        $anliData = pdo_getall('zhls_sun_type',['uniacid'=>$_W['uniacid']]);
        echo json_encode($anliData);
}
// 获取案例单一字段名
public function doPageanliType(){
        global $_GPC,$_W;
        $anliData = pdo_getall('zhls_sun_type',['uniacid'=>$_W['uniacid']]);
        $anli = [];
        foreach ($anliData as $k=>$v){
            $anli[] = $v['type_name'];
        }
        echo json_encode($anli);
}
// 获取案例对应的数据
public function doPageanliIdData(){
        global $_GPC,$_W;
        $id = $_GPC['id'];
        $sql = ' SELECT * FROM ' . tablename('zhls_sun_problem') . ' p ' . ' JOIN ' . tablename('zhls_sun_type') . ' t ' . ' ON ' . ' p.an_id=t.id' . ' WHERE ' . 'p.uniacid='. $_W['uniacid'] .' AND ' . ' t.id=' . $id . ' ORDER BY ' . ' p.time desc';
        $well = pdo_fetchall($sql);
        echo json_encode($well);
}
//public function doPageanliIdDatamian(){
//        global $_GPC,$_W;
//        $id = $_GPC['id'];
//        $sql = ' SELECT * FROM ' . tablename('zhls_sun_mproblem') . ' m ' . ' JOIN ' . tablename('zhls_sun_type') . ' t ' . ' ON ' . ' m.an_id=t.id' . ' WHERE ' . 'm.uniacid='. $_W['uniacid'] .' AND ' . ' t.id=' . $id . ' AND ' . ' m.evaluate !=0' . ' ORDER BY ' . ' m.time desc';
//        $well = pdo_fetchall($sql);
//        foreach ($well as $k=>$v){
//            $well[$k]['time'] = date('Y-m-d H:i:s',time());
//        }
//        echo json_encode($well);
//}
public function doPageanlipayData(){
        global $_W,$_GPC;
        $id = $_GPC['id'];
        $sql = ' SELECT * FROM ' . tablename('zhls_sun_fproblem') . ' f ' . ' JOIN ' . tablename('zhls_sun_type') . ' t ' . ' ON ' . ' f.an_id=t.id' . ' WHERE ' . 'f.uniacid='. $_W['uniacid'] .' AND ' . ' t.id=' . $id . ' AND ' . ' f.evaluate !=0' . ' ORDER BY ' . ' f.time desc';
        $well = pdo_fetchall($sql);
        foreach ($well as $k=>$v){
            $well[$k]['time'] = date('Y-m-d H:i:s',time());
        }
        echo json_encode($well);
}

// 获取律师数据
    public function doPagelawType(){
        global $_GPC,$_W;
        $sql = ' SELECT * FROM ' . tablename('zhls_sun_lawtype') . ' lt ' . ' JOIN ' . tablename('zhls_sun_lawyer') .' l ' . ' ON ' . ' l.cate=lt.id' . ' WHERE ' . ' l.uniacid=' . $_W['uniacid'] . ' ORDER BY ' .  ' l.id DESC';
        $lawData = pdo_fetchall($sql);
//        $lawData = pdo_getall('zhls_sun_lawyer',['uniacid'=>$_W['uniacid']]);
        foreach ($lawData as $k=>$v){
            $lawData[$k]['lawyers'] = $v['lawyers'] . '('.$v['lawtype_name'].')';
        }
        echo json_encode($lawData);
    }

// 获取律师对应id的数据
public function doPagelawData(){
        global $_W,$_GPC;
        $id = $_GPC['id'];
        $lawData = pdo_get('zhls_sun_lawyer',array('uniacid'=>$_W['uniacid'],'id'=>$id));
        echo json_encode($lawData);
}

    // 获取解答（后台上传）
    public function doPageWellanswer(){
        global $_GPC,$_W;
        $sql = ' SELECT * FROM ' . tablename('zhls_sun_problem') . ' p ' . ' JOIN ' . tablename('zhls_sun_type') . ' t ' . ' ON ' . ' p.an_id=t.id' . ' WHERE ' . 'p.uniacid='. $_W['uniacid'] . ' ORDER BY ' . ' p.time desc';
        $well = pdo_fetchall($sql);
        echo json_encode($well);
    }

    // 获取解答（付费）
    public function doPageWellpay(){
        global $_W,$_GPC;
        $sql = ' SELECT * FROM ' . tablename('zhls_sun_fproblem') . ' p ' . ' JOIN ' . tablename('zhls_sun_type') . ' t ' . ' ON ' . ' p.an_id=t.id' . ' WHERE ' . 'p.uniacid='. $_W['uniacid'] . ' AND ' . ' p.evaluate !=0' . ' ORDER BY ' . ' p.time desc';
        $well = pdo_fetchall($sql);
        foreach ($well as $k=>$v){
            $well[$k]['time'] = date('Y-m-d H:i:s',$v['time']);
        }
        echo json_encode($well);
    }

    /**
     * 关键字搜索案例或问题
     *
     */
    public function doPagekeywordData()
    {
        global $_GPC,$_W;
        $keyword = $_GPC['keyword']; // 关键字
        $where = " and (p.problem LIKE  concat('%', :order_no,'%') or t.type_name LIKE  concat('%', :order_no,'%'))";
        $data[':order_no']=$keyword;
        // 后台添加
        $sql = ' SELECT * FROM ' . tablename('zhls_sun_problem') . ' p ' . ' JOIN ' . tablename('zhls_sun_type') . ' t ' . ' ON ' . ' p.an_id=t.id' . ' WHERE ' . 'p.uniacid='. $_W['uniacid'] . $where . ' ORDER BY ' . ' p.time desc';
        $well = pdo_fetchall($sql,$data);
        // 付费咨询
        $sql = ' SELECT * FROM ' . tablename('zhls_sun_fproblem') . ' p ' . ' JOIN ' . tablename('zhls_sun_type') . ' t ' . ' ON ' . ' p.an_id=t.id' . ' WHERE ' . 'p.uniacid='. $_W['uniacid'] . ' AND ' . ' p.evaluate !=0' . $where . ' ORDER BY ' . ' p.time desc';
        $paywell = pdo_fetchall($sql,$data);
        foreach ($paywell as $k=>$v){
            $paywell[$k]['time'] = date('Y-m-d H:i:s',$v['time']);
        }
        $newData = array(
            'well'=>$well,
            'paywell'=>$paywell
        );
        echo json_encode($newData);
    }

    // 解答对应的数据
    public function doPageansData(){
        global $_GPC,$_W;
        if($_GPC['pid']!='undefined'){
            $answer = pdo_getall('zhls_sun_answer',['uniacid'=>$_W['uniacid'],'pro_id'=>$_GPC['pid']],'','','huifutime DESC');
        }

        if($_GPC['mid']!='undefined'){
            $answer = pdo_getall('zhls_sun_manswer',['uniacid'=>$_W['uniacid'],'mpro_id'=>$_GPC['mid']],'','','huifutime DESC');
        }

        if($_GPC['fid']!='undefined'){
            $answer = pdo_getall('zhls_sun_fanswer',['uniacid'=>$_W['uniacid'],'fpro_id'=>$_GPC['fid']],'','','huifutime DESC');
        }

        echo json_encode($answer);
    }
// 问题和律师信息
public function doPagequeslawyer(){
    global $_GPC,$_W;
    if($_GPC['pid']!='undefined'){
        $sql = ' SELECT * FROM ' . tablename('zhls_sun_problem') . ' p ' . ' JOIN ' . tablename('zhls_sun_lawyer') . ' l ' . ' ON ' . ' p.ls_id=l.id' . ' WHERE ' . ' p.pid='.$_GPC['pid'];
        $qulawyer = pdo_fetch($sql);
        $lawtype = pdo_getcolumn('zhls_sun_lawtype',array('uniacid'=>$_W['uniacid'],'id'=>$qulawyer['cate']),'lawtype_name');
        $qulawyer['cate'] = $lawtype;
    }
    if($_GPC['mid']!='undefined'){
        $sql = ' SELECT * FROM ' . tablename('zhls_sun_mproblem') . ' m ' . ' JOIN ' . tablename('zhls_sun_lawyer') . ' l ' . ' ON ' . ' m.ls_id=l.id' . ' WHERE ' . ' m.mid='.$_GPC['mid'];
        $qulawyer = pdo_fetch($sql);
        $lawtype = pdo_getcolumn('zhls_sun_lawtype',array('uniacid'=>$_W['uniacid'],'id'=>$qulawyer['cate']),'lawtype_name');
        $qulawyer['cate'] = $lawtype;
    }

    if($_GPC['fid']!='undefined'){

        $sql = ' SELECT * FROM ' . tablename('zhls_sun_fproblem') . ' f ' . ' JOIN ' . tablename('zhls_sun_lawyer') . ' l ' . ' ON ' . ' f.ls_id=l.id' . ' WHERE ' . ' f.fid='.$_GPC['fid'];
        $qulawyer = pdo_fetch($sql);
        $lawtype = pdo_getcolumn('zhls_sun_lawtype',array('uniacid'=>$_W['uniacid'],'id'=>$qulawyer['cate']),'lawtype_name');
        $qulawyer['cate'] = $lawtype;
    }
    $star = [];
    for ($i=0;$i<$qulawyer['star'];$i++){
        $star[$i] = 1;
    }
    $qulawyer['star'] = $star;
    $qulawyer['kong'] = 5-count($star);
    $kong = [];
    for ($i=0;$i<$qulawyer['kong'];$i++){
        $kong[$i] = 1;
    }
    $qulawyer['kong'] = $kong;


    echo json_encode($qulawyer);
}


// 保存在线预约数据
public function doPageAppointment(){
        global $_W,$_GPC;
        $openid = $_GPC['openid'];
        $content = $_GPC['content'];
        $phone = $_GPC['phone'];
        $time = $_GPC['time'];
        $gender = $_GPC['gender'];
        $data = [
            'uniacid'=>$_W['uniacid'],
            'apptime'=>$time,
            'mobile'=>$phone,
            'user_name'=>$gender,
            'lawcontent'=>$content,
            'openid'=>$openid,
            'subtime'=>time()
        ];
        $res = pdo_insert('zhls_sun_appointment',$data);
        echo json_encode($res);
}
// 我的预约数据
public function doPageAppointmentData(){
        global $_W,$_GPC;
        $openid = $_GPC['openid'];
        $data = pdo_getall('zhls_sun_appointment',array('uniacid'=>$_W['uniacid'],'openid'=>$openid),'','','subtime DESC');
        foreach ($data as $k=>$v){
            $data[$k]['apptime'] = explode(' ',$v['apptime']);
            $data[$k]['subtime'] = date('Y-m-d H:i:s',$v['subtime']);
        }
        echo json_encode($data);
}
// 取消预约
public function doPageCancel(){
        global $_W,$_GPC;
        $question = $_GPC['question'];
        $id = $_GPC['id'];
        $res = pdo_update('zhls_sun_appointment',array('cancel'=>$question,'status'=>2),array('uniacid'=>$_W['uniacid'],'id'=>$id));
        echo json_encode($res);
}

// 保存免费咨询数据
public function doPageConsultation(){
        global $_GPC,$_W;
        $openid = $_GPC['openid'];
        $content = $_GPC['content'];
        $phone = $_GPC['phone'];
        $linkMan = $_GPC['linkMan'];
        $type = $_GPC['leixing'];
        $an_id = pdo_getcolumn('zhls_sun_type',array('uniacid'=>$_W['uniacid'],'type_name'=>$type),'id');
        $data = [
            'problem'=>$content,
            'uniacid'=>$_W['uniacid'],
            'user_name'=>$linkMan,
            'mobile'=>$phone,
            'openid'=>$openid,
            'an_id'=>$an_id,
            'time'=>time()
        ];
        $res = pdo_insert('zhls_sun_mproblem',$data);
        echo json_encode($res);
}

// 个人免费咨询记录
public function doPageUsermian(){
        global  $_GPC,$_W;
        $openid = $_GPC['openid'];
        $info = pdo_getall('zhls_sun_mproblem',array('openid'=>$openid),'','','time DESC');
        foreach ($info as $k=>$v){
            $info[$k]['time'] = date('Y-m-d H:i:s',$v['time']);
        }
        echo json_encode($info);
}
// 个人免费咨询用户问题解答
public function doPageUsermiananswer(){
        global  $_GPC,$_W;
        $openid = $_GPC['openid'];
        $fid = $_GPC['fid'];
        if($fid!='undefined'){
            $sql = ' SELECT * FROM ' .tablename('zhls_sun_fproblem') . ' fp ' . ' JOIN ' . tablename('zhls_sun_lawyer') . ' l ' . ' ON ' . ' fp.ls_id=l.id' . ' WHERE ' . ' fp.fid=' . $fid . ' AND ' . ' fp.openid=' . "'$openid'";
            $info = pdo_fetch($sql);
        }

        $info['time'] = date('Y-m-d H:i:s',$info['time']);
        echo json_encode($info);
}

// 个人免费咨询用追问题解答
public function doPageUsermianAsk(){
        global $_GPC,$_W;
        $openid = $_GPC['openid'];
        $fid = $_GPC['fid'];

        if($fid){
            $sql = ' SELECT * FROM ' . tablename('zhls_sun_fproblem') . ' fp ' . ' JOIN ' . tablename('zhls_sun_fanswer') . ' fa ' . ' ON ' . ' fp.fid=fa.fpro_id' . ' WHERE' . ' fp.fid=' . $fid . ' AND ' . ' fp.openid=' . "'$openid'" . ' ORDER BY ' . ' fa.huifutime DESC';
        }

        $info = pdo_fetchall($sql);

        echo json_encode($info);
}


// 提交追问数据(免费)
public function doPageMAskData(){
        global $_GPC,$_W;
        $mid = $_GPC['mid'];
        $content = $_GPC['content'];
        $data = [
            'question'=>$content,
            'mpro_id'=>$mid,
            'huifutime'=>date('Y-m-d H:i:s',time()),
            'uniacid'=>$_W['uniacid']
        ];
        $res = pdo_insert('zhls_sun_manswer',$data);
        echo json_encode($res);
}
// 提交评论（付费）
public function doPageMevaluate(){
        global $_GPC,$_W;
        $openid = $_GPC['openid'];
        $mid = $_GPC['mid'];
        $star = $_GPC['star'];
        $res = pdo_update('zhls_sun_mproblem',array('evaluate'=>$star),array('uniacid'=>$_W['uniacid'],'mid'=>$mid,'openid'=>$openid));
        echo json_encode($res);
}

// 保存付费咨询数据
public function doPagePayconsultation(){
        global $_W,$_GPC;
        $openid = $_GPC['openid'];
        $content = $_GPC['contents'];
        $phone = $_GPC['phone'];
        $id = $_GPC['id'];
        $linkMan = $_GPC['linkMan'];
        $type = $_GPC['leixing'];
        $an_id = pdo_getcolumn('zhls_sun_type',array('uniacid'=>$_W['uniacid'],'type_name'=>$type),'id');
        $data = [
            'problem'=>$content,
            'uniacid'=>$_W['uniacid'],
            'user_name'=>$linkMan,
            'mobile'=>$phone,
            'openid'=>$openid,
            'an_id'=>$an_id,
            'ls_id'=>$id,
            'time'=>time(),
            'amount'=>$_GPC['money']
        ];
        $res = pdo_insert('zhls_sun_fproblem',$data);
		$fid=pdo_insertid();
        
		if($res){
            $law = pdo_get('zhls_sun_lawmoney',array('uniacid'=>$_W['uniacid'],'ls_id'=>$id));
            $lawData = array(
                'ls_id'=>$id,
                'money'=>$_GPC['money'],
                'uniacid'=>$_W['uniacid']
            );
            if($law){
                pdo_update('zhls_sun_lawmoney',array('money'=>$law['money']+$_GPC['money']),array('uniacid'=>$_W['uniacid'],'ls_id'=>$id));
            }else{
                pdo_insert('zhls_sun_lawmoney',$lawData);
            }

            // 调用短信接口
            $sms = pdo_get('zhls_sun_sms',array('uniacid'=>$_W['uniacid']));
            // 个人号码
            $mobile = pdo_getcolumn('zhls_sun_lawyer',array('uniacid'=>$_W['uniacid'],'id'=>$id),'mobile');

			if($mobile){
				$this->SendSms($id,0,$fid);
			}

        }
        echo json_encode($fid);
}


    //本页面调用发送短信
    public function SendSms($bid=0,$smstype=0,$ordernum=0){
        global $_W, $_GPC;
        $bid = $bid;
        $uniacid = $_W['uniacid'];
        $smstype = $smstype;//0订单短信，1退款订单短信
        $res=pdo_get('zhls_sun_lawyer',array('uniacid'=>$uniacid,'id'=>$bid),array("mobile"));
        $phone = $res["mobile"]?$res["mobile"]:0;

        $sms=pdo_get('zhls_sun_sms',array('uniacid'=>$uniacid));
        if($sms){
            if($sms["is_open"]==1){
                if($sms["smstype"]==1){//253
                    $msg = $smstype==1?$sms["ytx_orderrefund"]:$sms["ytx_order"];
                    if($msg!=''){
                        $params = $phone.",".$ordernum;
                        $this->SendYtxSms($msg,$sms,$phone);
                    }
                }elseif($sms["smstype"]==2){//聚合
                    $sendid = $smstype==1?$sms["order_refund_tplid"]:$sms["order_tplid"];
                    if($sendid<=0){
                        echo "短信模板id为空，不发送";
                    }else{
                        $this->SendJuheSms($phone,$sendid,$sms);
                    }
                }elseif($sms["smstype"]==3){//阿里大鱼
                    include_once IA_ROOT . '/addons/zhls_sun/api/aliyun-dysms/sendSms.php';
                    set_time_limit(0);
                    header('Content-Type: text/plain; charset=utf-8');
                    $sendid = $smstype==1?$sms["aly_orderrefund"]:$sms["aly_order"];
                    if($sendid!=""){
                        $return = sendSms($sms["aly_accesskeyid"], $sms["aly_accesskeysecret"],$phone, $sms["aly_sign"],$sendid);
                        echo json_encode($return);
                    }
                }
            }
        }else{
            echo "短信发送没开";
        }
    }

	//253云通信
    public function SendYtxSms($sendid='',$sms=array(),$mobile=''){
        global $_W, $_GPC;
        $postArr = array (
            'account'  => $sms["ytx_apiaccount"],
            'password' => $sms["ytx_apipass"],
            'msg' => $sendid,
            'phone' => $mobile,
            'report' => 'true'
        );
        $url = "http://smssh1.253.com/msg/send/json";
        $result = $this->curlPost($url, $postArr);
        //echo $result;
    }

	private function curlPost($url,$postFields){
        $postFields = json_encode($postFields);
        
        $ch = curl_init ();
        curl_setopt( $ch, CURLOPT_URL, $url ); 
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8'   //json版本需要填写  Content-Type: application/json;
            )
        );
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4); 
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt( $ch, CURLOPT_TIMEOUT,60); 
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0);
        $ret = curl_exec ( $ch );
        if (false == $ret) {
            $result = curl_error($ch);
        } else {
            $rsp = curl_getinfo( $ch, CURLINFO_HTTP_CODE);
            if (200 != $rsp) {
                $result = "请求状态 ". $rsp . " " . curl_error($ch);
            } else {
                $result = $ret;
            }
        }
        curl_close ( $ch );
        return $result;
    }

	//聚合短信
    public function SendJuheSms($phone=0,$sendid=0,$sms=array()){
        global $_W, $_GPC;
        header('content-type:text/html;charset=utf-8');
        $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL
        $smsConf = array(
            'key'   => $sms["appkey"], //您申请的APPKEY
            'mobile'    => $phone, //接受短信的用户手机号码
            'tpl_id'    => $sendid, //您申请的短信模板ID，根据实际情况修改
            'tpl_value' =>'#code#=1234&#company#=聚合数据' //您设置的模板变量，根据实际情况修改
        );
        $content = $this->juhecurl($sendUrl,$smsConf,1); //请求发送短信
        if($content){
            $result = json_decode($content,true);
            $error_code = $result['error_code'];
            if($error_code == 0){
                //状态为0，说明短信发送成功
                echo "短信发送成功,短信ID：".$result['result']['sid'];
            }else{
                //状态非0，说明失败
                $msg = $result['reason'];
                echo "短信发送失败(".$error_code.")：".$msg;
            }
        }else{
            //返回内容异常，以下可根据业务逻辑自行修改
            echo "请求发送短信失败";
        }
    }

	/**
	 * 请求接口返回内容
	 * @param  string $url [请求的URL地址]
	 * @param  string $params [请求的参数]
	 * @param  int $ipost [是否采用POST形式]
	 * @return  string
	 */
    function juhecurl($url,$params=false,$ispost=0){
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        if( $ispost ){
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
            curl_setopt( $ch , CURLOPT_URL , $url );
        }
        else
        {
            if($params){
                curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
            }else{
                curl_setopt( $ch , CURLOPT_URL , $url);
            }
        }
        $response = curl_exec( $ch );
        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
        $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
        curl_close( $ch );
        return $response;
    }

	// 短信通知
    /*function Shortmessage($mobile)
    {
        global $_GPC,$_W;
        header('content-type:text/html;charset=utf-8');

        $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL
        // 获取短信模板数据
        $sms = pdo_get('zhls_sun_sms',array('uniacid'=>$_W['uniacid']));

        $smsConf = array(
            'key'   => $sms['appkey'], //您申请的APPKEY
            'mobile'    => $mobile, //接受短信的用户手机号码
            'tpl_id'    => $sms['tpl_id'], //您申请的短信模板ID，根据实际情况修改
            'tpl_value' =>'#code#=1234&#company#=聚合数据' //您设置的模板变量，根据实际情况修改
        );

        $content = $this->juhecurl($sendUrl,$smsConf,1); //请求发送短信

        if($content){
            $result = json_decode($content,true);
            $error_code = $result['error_code'];
            if($error_code == 0){
                //状态为0，说明短信发送成功
                echo "短信发送成功,短信ID：".$result['result']['sid'];
            }else{
                //状态非0，说明失败
                $msg = $result['reason'];
                echo "短信发送失败(".$error_code.")：".$msg;
            }
        }else{
            //返回内容异常，以下可根据业务逻辑自行修改
            echo "请求发送短信失败";
        }
    }*/

    /**
     * 请求接口返回内容
     * @param  string $url [请求的URL地址]
     * @param  string $params [请求的参数]
     * @param  int $ipost [是否采用POST形式]
     * @return  string
     */
    /*function juhecurl($url,$params=false,$ispost=0){
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
        curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
        curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
        if( $ispost )
        {
            curl_setopt( $ch , CURLOPT_POST , true );
            curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
            curl_setopt( $ch , CURLOPT_URL , $url );
        }
        else
        {
            if($params){
                curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
            }else{
                curl_setopt( $ch , CURLOPT_URL , $url);
            }
        }
        $response = curl_exec( $ch );
        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
        $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
        curl_close( $ch );
        return $response;
    }*/

// 个人付费咨询数据
public function doPageUserpay(){
        global $_GPC,$_W;
        $openid = $_GPC['openid'];
        $sql = ' SELECT * FROM ' . tablename('zhls_sun_fproblem') . ' f ' . ' JOIN ' . tablename('zhls_sun_lawyer') . ' l ' . ' ON ' . ' f.ls_id=l.id' . ' WHERE ' . ' f.uniacid=' . $_W['uniacid'] . ' AND ' . ' f.openid=' . "'$openid'" . ' ORDER BY ' . ' f.time DESC';
        $info = pdo_fetchall($sql);
        foreach ($info as $k=>$v){
            $info[$k]['time'] = date('Y-m-d H:i:s',$v['time']);
        }
        echo json_encode($info);
}
// 个人付费追问数据
public function doPagePAskData(){
        global $_GPC,$_W;
        $fid = $_GPC['fid'];
        $content = $_GPC['content'];
        $data = [
            'question'=>$content,
            'fpro_id'=>$fid,
            'huifutime'=>date('Y-m-d H:i:s',time()),
            'uniacid'=>$_W['uniacid']
        ];
        $res = pdo_insert('zhls_sun_fanswer',$data);
        echo json_encode($res);
}
// 提交评论（付费）
public function doPageFevaluate(){
        global $_GPC,$_W;
        $openid = $_GPC['openid'];
        $fid = $_GPC['fid'];
        $star = $_GPC['star'];
        $res = pdo_update('zhls_sun_fproblem',array('evaluate'=>$star),array('uniacid'=>$_W['uniacid'],'fid'=>$fid,'openid'=>$openid));
        echo json_encode($res);
}


// 查找文章分类
public function doPageCategory(){
        global  $_GPC,$_W;
        $cate = pdo_getall('zhls_sun_category',array('uniacid'=>$_W['uniacid']),'','','cid ASC');
        echo json_encode($cate);
}
// 文章默认数据
public function doPageMoData(){
        global $_W,$_GPC;
        $cate = pdo_get('zhls_sun_category',['uniacid'=>$_W['uniacid']]);
        $moData = pdo_getall('zhls_sun_dynamics',array('uniacid'=>$_W['uniacid'],'cid'=>$cate['cid']),'','','selftime DESC');
        foreach ($moData as $k=>$v){
            $moData[$k]['selftime'] = date('Y-m-d H:i:s',$v['selftime']);
        }
        echo json_encode($moData);
}

// 获取cid文章分类对应的数据
public function doPageCateData(){
        global $_W,$_GPC;
        $cid = $_GPC['cid'];
        $cateData = pdo_getall('zhls_sun_dynamics',array('uniacid'=>$_W['uniacid'],'cid'=>$cid),'','','selftime DESC');
        foreach ($cateData as $k=>$v){
            $cateData[$k]['selftime'] = date('Y-m-d H:i:s',$v['selftime']);
        }
        echo json_encode($cateData);
}
// 对应文章id的数据
public function doPageDynamicsDate(){
        global $_W,$_GPC;
        $id = $_GPC['id'];
        $data = pdo_get('zhls_sun_dynamics',array('uniacid'=>$_W['uniacid'],'id'=>$id));
        $data['selftime'] = date('Y-m-d H:i:s',$data['selftime']);
        echo json_encode($data);
}

// 商家数据
public function doPageShop(){
      global $_W;
    $shopData = pdo_get('zhls_sun_system',['uniacid'=>$_W['uniacid']]);
    return $this->result(0,'',$shopData);
}

// 自定义首页图标
public function doPageIndexpic(){
    global $_W;
    $shopData = pdo_get('zhls_sun_system',['uniacid'=>$_W['uniacid']]);
    $shopData['service_num'] = $shopData['service_num'] + 1;
    return $this->result(0,'',$shopData);
}

// 商家后台登录
public function doPageLoginShop(){
        global $_W,$_GPC;
        $account = $_GPC['account'];
        $password = $_GPC['password'];
        $acData = pdo_get('zhls_sun_lawyer',array('uniacid'=>$_W['uniacid'],'lawyer_login'=>$account));
        $paData = pdo_get('zhls_sun_lawyer',array('uniacid'=>$_W['uniacid'],'lawyer_login'=>$account,'lawyer_password'=>$password));
        if(!$acData){
            $res = [
                'erron'=>2,
                'id'=>0
            ];
        }else{
            if(!$paData){
                $res = [
                    'erron'=>3,
                    'id'=>0
                ];;
            }else{
                $res = [
                    'erron'=>1,
                    'id'=>$paData['id']
                ];;
            }
        }
        echo json_encode($res);
}

// 登录律师的对应数据——待回复
public function doPageLoginLawyer(){
        global $_GPC,$_W;
        $id = $_GPC['id'];
        $sql = ' SELECT *FROM '. tablename('zhls_sun_lawyer'). ' l ' . ' JOIN ' .tablename('zhls_sun_fproblem') .' f ' . ' ON ' . ' f.ls_id=l.id' . ' WHERE ' . ' f.ls_id='.$id .' AND '.' f.uniacid=' . $_W['uniacid'] . ' AND ' . ' f.is_answer=0' . ' ORDER BY ' . ' f.time DESC';
        $data = pdo_fetchall($sql);
        foreach ($data as $k=>$v){
            $data[$k]['time'] = date('Y-m-d H:i:s',$v['time']);
        }
        echo json_encode($data);
}

// 登录律师的对应数据——待评价
public function doPageTobeevaluated(){
        global $_GPC,$_W;
        $id = $_GPC['id'];
        $sql = ' SELECT *FROM '. tablename('zhls_sun_lawyer'). ' l ' . ' JOIN ' .tablename('zhls_sun_fproblem') .' f ' . ' ON ' . ' f.ls_id=l.id' . ' WHERE ' . ' f.ls_id='.$id .' AND '.' f.uniacid=' . $_W['uniacid'] . ' AND ' . ' f.evaluate=0 AND f.is_answer=1' . ' ORDER BY ' . ' f.time DESC';
        $data = pdo_fetchall($sql);
        foreach ($data as $k=>$v){
            $data[$k]['time'] = date('Y-m-d H:i:s',$v['time']);
        }
        echo json_encode($data);
}

// 登录律师的对应数据——已完成
public function doPageCompleted(){
        global $_GPC,$_W;
        $id = $_GPC['id'];
        $sql = ' SELECT *FROM '. tablename('zhls_sun_lawyer'). ' l ' . ' JOIN ' .tablename('zhls_sun_fproblem') .' f ' . ' ON ' . ' f.ls_id=l.id' . ' WHERE ' . ' f.ls_id='.$id .' AND '.' f.uniacid=' . $_W['uniacid'] . ' AND ' . ' f.evaluate!=0 AND f.is_answer=1' . ' ORDER BY ' . ' f.time DESC';
        $data = pdo_fetchall($sql);
        foreach ($data as $k=>$v){
            $data[$k]['time'] = date('Y-m-d H:i:s',$v['time']);
        }
        echo json_encode($data);
}

// 律师对应解答数据
    public function doPagelawyeranswer(){
        global  $_GPC,$_W;
        $openid = $_GPC['openid'];
        $fid = $_GPC['fid'];
        if($fid!='undefined'){
            $sql = ' SELECT * FROM ' .tablename('zhls_sun_fproblem') . ' fp ' . ' JOIN ' . tablename('zhls_sun_lawyer') . ' l ' . ' ON ' . ' fp.ls_id=l.id' . ' WHERE ' . ' fp.fid=' . $fid;
            $info = pdo_fetch($sql);
        }

        $info['time'] = date('Y-m-d H:i:s',$info['time']);
        echo json_encode($info);
    }
// 律师提交解答
public function doPageLawtianswer(){
        global $_GPC,$_W;
        $fid = $_GPC['fid'];
        $content = $_GPC['content'];
        $oldData = pdo_get('zhls_sun_fproblem',array('uniacid'=>$_W['uniacid'],'fid'=>$fid));
        if($oldData['answer']=='null' || !$oldData['answer']){
            $res = pdo_update('zhls_sun_fproblem',array('answer'=>$content,'is_answer'=>1),array('uniacid'=>$_W['uniacid'],'fid'=>$fid));
        }else{
            $data = [
                'fpro_id'=>$fid,
                'answers'=>$content,
                'uniacid'=>$_W['uniacid'],
                'huifutime'=>date('Y-m-d H:i:s',time())
            ];
            $res = pdo_insert('zhls_sun_fanswer',$data);
        }

        echo json_encode($res);
}
// 追问
    public function doPagelawyerAsk(){
        global $_GPC,$_W;
        $fid = $_GPC['fid'];

        if($fid){
            $sql = ' SELECT * FROM ' . tablename('zhls_sun_fproblem') . ' fp ' . ' JOIN ' . tablename('zhls_sun_fanswer') . ' fa ' . ' ON ' . ' fp.fid=fa.fpro_id' . ' WHERE' . ' fp.fid=' . $fid . ' AND ' . ' fp.uniacid=' . $_W['uniacid'] . ' ORDER BY ' . ' fa.huifutime DESC';
        }

        $info = pdo_fetchall($sql);

        echo json_encode($info);
    }

// 今日预约数
public function doPageTodayappion(){
        global $_W,$_GPC;
        $visitor = pdo_getall('zhls_sun_appointment',['uniacid'=>$_W['uniacid']]);
        $visis = [];
        foreach ($visitor as $k=>$v){
            if(date('Y-m-d',$v['subtime'])==date('Y-m-d')){
                $visis[] = $v;
            }
        }
        $visi = count($visis);
        echo json_encode($visi);
}

// 今日咨询数
public function doPageTodayConsultation(){
        global $_W,$_GPC;
		$ls_id = $_GPC['ls_id'];

        $consult = pdo_getall('zhls_sun_fproblem',array('uniacid'=>$_W['uniacid'],'ls_id'=>$ls_id));
        $coun = [];
        foreach ($consult as $k=>$v){
            if(date('Y-m-d',$v['time'])==date('Y-m-d')){
                $coun[] = $v;
            }
        }
        $count = count($coun);
        echo json_encode($count);
}

// 日访问量
public function doPageTodayFang(){
        global $_GPC,$_W;
        $fang = pdo_getall('zhls_sun_user',array('uniacid'=>$_W['uniacid']));
        foreach ($fang as $k=>$v){
            $fang[$k]['time'] = strtotime($v['time']);
        }
        $fa = [];
        foreach ($fang as $k=>$v){
            if(date('Y-m-d',$v['time'])==date('Y-m-d')){
                $fa[] = $v;
            }
        }
        $num = count($fa);
        echo json_encode($num);
}

// 获取底部tab
public function doPagetab(){
        global $_W;
        $data = pdo_get('zhls_sun_tab',array('uniacid'=>$_W['uniacid']));
        echo json_encode($data);
}

    // 获取当前律师数据
    public function doPageNowlawyer()
    {
        global $_GPC,$_W;
        $id = $_GPC['id'];
        $data = pdo_get('zhls_sun_lawyer',array('uniacid'=>$_W['uniacid'],'id'=>$id));
        $data['cate'] = pdo_getcolumn('zhls_sun_lawtype',array('uniacid'=>$_W['uniacid'],'id'=>$data['cate']),'lawtype_name');
        $star = [];
        for ($i=0;$i<$data['star'];$i++){
            $star[$i] = 1;
        }
        $data['star'] = $star;
        $data['kong'] = 5-count($star);
        $kong = [];
        for ($i=0;$i<$data['kong'];$i++){
            $kong[$i] = 1;
        }

		//获取评价
		$pjnum = pdo_fetchcolumn("select count(fid) as num from ".tablename('zhls_sun_fproblem')." where ls_id=".$id." and  uniacid='".$_W['uniacid']."' and evaluate!=0");

		//获取虚拟评价数量
		$fcoment = pdo_get('zhls_sun_lawyer',array('uniacid'=>$_W['uniacid'],'id'=>$id));

		$data['pjnum'] = $pjnum['num']+$fcoment['comment'];

        $data['kong'] = $kong;
        echo json_encode($data);
    }



// 拼接图片路径
public function doPageUrl(){
      global $_GPC, $_W;
      echo $_W['attachurl'];
  }
//url
public function doPageUrl2(){
      global $_W, $_GPC;
      echo $_W['siteroot'];
  }


    /*
       * 获取微信支付的数据
       *
       */
    public function doPageOrderarr() {
        global $_GPC,$_W;
        $openid = $_GPC['openid'];
        $appData = pdo_get('zhls_sun_system', array('uniacid' => $_W['uniacid']));
        $appid = $appData['appid'];
        $mch_id = $appData['mchid'];
        $keys = $appData['wxkey'];
        $price = $_GPC['price'];

        include IA_ROOT . '/addons/zhls_sun/wxpay.php';
        //$res = pdo_get('zhls_sun_system', array('uniacid' => $_W['uniacid']));
        $key = $keys;
        $total_fee = $price;
//        $total_fee = 0.01;
        $out_trade_no = $mch_id . time().rand(1000,9999);
        if (empty($total_fee)) {//货款为0时
            $total_fee = floatval(99 * 100);
        } else {
            $total_fee = floatval($total_fee * 100);
        }
        $body = "商品";

        $weixinpay = new WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee);
        $return = $weixinpay->pay();
        echo json_encode($return);

    }

    function createPaySign($result)
    {
        global $_W;
        $appData = pdo_get('zhls_sun_system',['uniacid'=>$_W['uniacid']]);
        $keys = $appData['wxkey'];
        $data = array(
            'appId' => $result['appid'],
            'timeStamp' => (string)time(),
            'nonceStr' => $result['nonce_str'],
            'package' => 'prepay_id=' . $result['prepay_id'],
            'signType' => 'MD5'
        );
        ksort($data, SORT_ASC);
        $stringA = '';
        foreach ($data as $key => $val) {
            $stringA .= "{$key}={$val}&";
        }
        $signTempStr = $stringA . 'key='.$keys;
        $signValue = strtoupper(md5($signTempStr));
        $data['paySign'] = $signValue;
        return $data;
    }

    function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }


    // 首页弹窗
    public function doPageindexTan()
    {
        global $_W;
        $data = pdo_get('zhls_sun_winindex',array('uniacid'=>$_W['uniacid']));
        $data['lb_img'] = [
            0=>[
              'img'=>$data['img1'],
              'path'=>$data['path1']
            ],
            1=>[
                'img'=>$data['img2'],
                'path'=>$data['path2']
            ],
            2=>[
                'img'=>$data['img3'],
                'path'=>$data['path3']
            ],
        ];
        foreach ($data['lb_img'] as $k=>$v){
            if(empty($v['img']) || $v['img']=='' || $v['img']==null){
                unset($data['lb_img'][$k]);
            }
        }
        echo json_encode($data);
    }

    /**
     * 获取城市对应的律师信息
     *
     */
    public function dopageCityLawyers()
    {
        global $_GPC,$_W;
        $city_id = $_GPC['city_id']; // 城市id
        $lat = $_GPC['latitude'];
        $lng = $_GPC['longitude'];
        $sql = ' SELECT * FROM ' . tablename('zhls_sun_lawtype') . ' lt ' . ' JOIN ' . tablename('zhls_sun_lawyer') .' l ' . ' ON ' . ' l.cate=lt.id' . ' WHERE ' . ' l.uniacid=' . $_W['uniacid'] . ' AND l.city_id=' . $city_id . ' and l.state=1 ORDER BY ' .  ' l.id DESC';
        $hair = pdo_fetchall($sql);
        foreach ($hair as $k=>$v){
            $hair[$k]['logo'] = $_W['attachurl'].$v['logo'];
        }
        $star = [];
        for ($j=0;$j<count($hair);$j++){
            for ($i=0;$i<$hair[$j]['star'];$i++){
                $star[$j][$i] = 1;
            }
        }
        foreach ($hair as $k=>$v){
            foreach ($star as $kk=>$vv){
                if($k==$kk){
                    $hair[$k]['star'] = $vv;
                    $hair[$k]['kong'] = 5-count($vv);
                }
            }
        }
        $kong = [];
        for ($j=0;$j<count($hair);$j++){
            for ($i=0;$i<$hair[$j]['kong'];$i++){
                $kong[$j][$i] = 1;
            }
        }
        foreach ($hair as $k=>$v){
            foreach ($kong as $kk=>$vv){
                if($k==$kk){
                    $hair[$k]['kong'] = $vv;
                }
            }
        }
        $dis = array();
        foreach ($hair as $k=>$v){
            $hair[$k]['distance'] = round(($this->getdistance($lat,$lng,$v['lat'],$v['lng']))/1000,2);
        }
        foreach ($hair as $k=>$v){
            $dis[$k] = $v['distance'];
        }
        array_multisort($dis,SORT_ASC,$hair);
        echo json_encode($hair);
    }


    /**
     * 获取我的财务
     *
     */
    public function doPageMyFinances()
    {
        global $_GPC,$_W;
        $ls_id = $_GPC['id']; // 律师id
        $data = pdo_getall('zhls_sun_fproblem',array('uniacid'=>$_W['uniacid'],'ls_id'=>$ls_id));
        $today = date('Y-m-d',time());
        $yesterday = date("Y-m-d",strtotime("-1 day"));
        $todaymoney = 0;
        $yesterdaymoney = 0;
        $all = 0;
        $Putforward = pdo_getcolumn('zhls_sun_lawmoney',array('uniacid'=>$_W['uniacid'],'ls_id'=>$ls_id),'money'); // 提现
        foreach ($data as $k=>$v){
            if($today == date('Y-m-d',$v['time'])){
                $todaymoney += $v['amount'];
            }
            if($yesterday == date('Y-m-d',$v['time'])){
                $yesterdaymoney += $v['amount'];
            }
            $all += $v['amount'];
        }
        if(!$Putforward){
            $Putforward = 0;
        }
        $newData = array(
            'today'=>$todaymoney,
            'yesterday'=>$yesterdaymoney,
            'all'=>$all,
            'Putforward'=>$Putforward
        );
        echo json_encode($newData);
    }

    /**
     * 获取可提现金额
     *
     */
    public function doPageCanPresented()
    {
        global $_W,$_GPC;
        $ls_id = $_GPC['ls_id']; // 律师id
        $Putforward = pdo_getcolumn('zhls_sun_lawmoney',array('uniacid'=>$_W['uniacid'],'ls_id'=>$ls_id),'money'); // 提现
        if(!$Putforward){
            $Putforward = 0;
        }
        echo json_encode($Putforward);
    }

    //提现操作
    public function doPageInputStoreMoney(){
        global $_GPC,$_W;
        $ls_id = $_GPC['ls_id']; // 律师id
        $system = pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
        $person = $system['tx_sxf']*0.01;//手续费
        $openid = $_GPC['openid'];
        $accountnumber = $_GPC['accountnumber'];
        $comaccountnumber = $_GPC['comaccountnumber'];
        $putmoney = $_GPC['putmoney'];
        $username = $_GPC['username'];
        $canbeInput = $_GPC['canbeInput'];
        if(!$accountnumber||!$comaccountnumber || !$putmoney || !$username){
            return $this->result(1,'请填写完整信息！','');
        }
        if($accountnumber!=$comaccountnumber){
            return $this->result(1,'输入的微信号不一致！','');
        }
        //先查找用户D
        $userid = pdo_getcolumn('zhls_sun_user',array('uniacid'=>$_W['uniacid'],'openid'=>$openid),'id');

        $data = array(
            'name' => $username,
            'username'=> $accountnumber,
            'type' => 2,
            'time' => time(),
            'state' => 1,
            'tx_cost' => $putmoney,
            'sj_cost' => $putmoney - ($putmoney * $person),
            'user_id' => $userid,
            'uniacid' => $_W['uniacid'],
            'ls_id'=>$ls_id,
            'method' => 2,
        );
        if($canbeInput>=$putmoney){
            $res = pdo_insert('zhls_sun_withdrawal',$data);
            if($res){
                pdo_update('zhls_sun_lawmoney',array('money'=>$canbeInput-$putmoney),array('uniacid'=>$_W['uniacid'],'ls_id'=>$ls_id));
            }
            return $this->result(0,'',$res);
        }else{
            return $this->result(0,'可提现金额不足！','');
        }
    }


}/////////////////////////////////////////////