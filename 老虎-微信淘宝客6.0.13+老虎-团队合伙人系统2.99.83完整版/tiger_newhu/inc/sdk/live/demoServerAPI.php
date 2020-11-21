<?php
/**
 * 网易云信server API 接口使用示例 1.6
 * @author  hzchensheng15@corp.netease.com
 * @date    2015-10-28  10:30
 * 
***/

//使用示例
require('./ServerAPI.php');

$AppKey = '80....d753....d68....ba7e0......';
$AppSecret = '............';
// $p = new ServerAPI($AppKey,$AppSecret,'fsockopen');		//fsockopen伪造请求
$p = new ServerAPI($AppKey,$AppSecret,'curl');		//php curl库

//创建云信Id
// print_r( $p->createUserId('Sulayman') ) ;
//更新云信Id
//print_r( $p->updateUserId('user1') ) ;
//更新并获取新token
//print_r( $p->updateUserToken('user1') ) ;
//封禁云信ID
// print_r( $p->blockUserId('user1') ) ;
//解禁云信ID
// print_r( $p->unblockUserId('user1') ) ;
//更新用户名片
// print_r( $p->updateUinfo('user1') ) ;
// 获取用户名片
//print_r( $p->getUinfos( array('user1','user2') ) ) ;
// 好友关系-加好友
//print_r( $p->addFriend('user1','user2','1','请求的话') );
// 好友关系-更新好友关系
//print_r( $p->updateFriend('user1','user2','备注') );
// 好友关系-获取好友关系
//print_r( $p->getFriend('user1') );
// 好友关系-删除好友信息
//print_r( $p->deleteFriend('user1','user2') );
// 好友关系-设置黑名单
//print_r( $p->specializeFriend('user1','user2','1','0') );
// 好友关系-查看黑名单
// print_r( $p->listBlackFriend('user1') );
//消息功能-发送普通消息
//print_r( $p->sendMsg('user1','0','user2','0',array('msg'=>'hello'),array("push"=>false,"roam"=>true,"history"=>true,"sendersync"=>true, "route"=>false) ) );
//消息功能-发送自定义系统消息
//print_r( $p->sendAttachMsg('user1','0','user2','helloworld') );
//消息功能-文件上传
//print_r( $p->uploadMsg(base64_encode('gwettwgsgssgs323f'),'0') );
//消息功能-文件上传（multipart方式）
//print_r( $p->uploadMultiMsg( base64_encode('gwettwgsgssgs323f') ) );

//群组功能（高级群）-创建群
//print_r( $p->createGroup('groupname','user1',array('user1','user2'),'','','invite','0','0','') );
//群组功能（高级群）-拉人入群
//print_r( $p->addIntoGroup('teamid','user1',array('user1','user2'),'0','请您入伙') );
//群组功能（高级群）-踢人出群
//print_r( $p->kickFromGroup('teamid','user1','user2' ) );
//群组功能（高级群）-踢人出群
//print_r( $p->removeGroup('teamid','user1' ) );
//群组功能（高级群）-更新群资料
//print_r( $p->updateGroup('teamid','user1','groupname') );
//群组功能（高级群）-群信息与成员列表查询
//print_r( $p->queryGroup(array('teamid1','teamid2') ) );
//群组功能（高级群）-移交群主
//print_r( $p->changeGroupOwner('teamid','user1','user1','2' ) );
//群组功能（高级群）-任命管理员
//print_r( $p->addGroupManager('teamid','user1',array('user2') ) );
//群组功能（高级群）-移除管理员
//print_r( $p->removeGroupManager('teamid','user1',array('user2') ) );
//群组功能（高级群）-获取某用户所加入的群信息
//print_r( $p->joinTeams('user1') );
//群组功能（高级群）-修改群昵称
//print_r( $p->updateGroupNick('teamid','user1','user1','xxx' ) );

//历史记录-单聊
//print_r( $p->querySessionMsg('user1','user2',(string)(time()*1000-2000000),(string)(time()*1000),'100','2' ) );
//历史记录-群聊
//print_r( $p->queryGroupMsg('teamid','user1',(string)(time()*1000-2000000),(string)(time()*1000),'100','2' ) );

//发送短信验证码
//print_r( $p->sendSmsCode('phonenum1','') );
//校验验证码
//print_r( $p->verifycode('phonenum1','验证码') );
//发送模板短信
//print_r( $p->sendSMSTemplate('templateid',array('phonenum1') ) );
//查询模板短信发送状态
//print_r( $p->querySMSStatus('templateid') );

//发起单人专线电话
// print_r( $p->startcall('Sulayman','13095088501','18085997799',90) );
//发起专线会议电话
//print_r( $p->startconf('user1','phonenum1',array('phonenum2','phonenum3'),60) );
//查询单通专线电话或会议的详情
//print_r( $p->queryCallsBySession('user1',sessionid) );

//获取语音视频安全认证签名
// print_r( $p->getUserSignature(1234) );

//创建一个直播频道
// print_r( $p->channelCreate('test_channel', 1) );
//修改直播频道信息
// print_r( $p->channelUpdate('test_channel', 'a918fdaf85a4458688e8f2789904ba6f', 1) );
//删除一个直播频道
// print_r( $p->channelDelete('a918fdaf85a4458688e8f2789904ba6f') );
//获取一个直播频道的信息
// print_r( $p->channelStats('a918fdaf85a4458688e8f2789904ba6f') );
//获取用户直播频道列表
// print_r( $p->channelList() );
//重新获取推流地址
// print_r( $p->channelRefreshAddr('a918fdaf85a4458688e8f2789904ba6f') );

?>