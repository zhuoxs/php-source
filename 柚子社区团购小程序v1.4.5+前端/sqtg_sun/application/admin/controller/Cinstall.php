<?php
namespace app\admin\controller;

use app\base\controller\Admin;
use Think\Db;

class Cinstall extends Admin
{
    public $url='https://sc.fzh.fun/app/index.php?i=957&t=957&v=1.0.0&from=wxapp&c=entry&a=wxapp&m=install_sun&do=';
    public $do1='getinstall';
    public $do2='install';
    public $do3='updateaccode';
    public $do4='upgrade';
    public $do5='upgradeversion';
    public function install(){
        $id=input('get.id');
        $this->view->info=array('id'=>$id);
        return view('install');
    }
    public function upgrade(){
        global $_W;
        $id = input('post.ids');
        $pluginkey=Db::name('pluginkey')->where(array('plugin_id'=>$id))->find();
        if(!$pluginkey||!$pluginkey['key']){
            return array(
                'code'=>1,
                'msg'=>'请先安装插件',
            );
        }
        $version=$_W['current_module']['version'];
        $url=$this->url.$this->do4;
        $url1=$this->url.$this->do5;
        $data=array('key'=>$pluginkey['key'],'version'=>$version);
        $res=ihttp_post($url,$data);
        if($res){
            $content=json_decode($res['content'],1);
            if($content['errcode']==0){
                $dir=IA_ROOT.'/addons/sqtg_sun/plugin/'.$content['plugin'].'/';
                if (!file_exists($dir)){
                    mkdir ($dir,0777,true);
                }
                $file_name=$dir.'upgrade.php';
                file_put_contents($file_name,$content['content']);
                include $file_name;
                unlink($file_name);
                $res1=ihttp_post($url1,$data);
                return array(
                    'code'=>0,
                    'msg'=>'更新成功',
                );
            }else{
                return array(
                    'code'=>1,
                    'msg'=>$content['errmsg'],
                );
            }
        }
        return array(
            'code'=>1,
            'msg'=>'保存失败',
        );

    }
    public function save_install(){
        global $_W;
        $id = input('post.id');
        $code=input('post.code');
        $siteroot=$_W['siteroot'];
        $data=array('id'=>$id,'code'=>$code,'siteroot'=>$siteroot);
        $url=$this->url.$this->do2;
        $url1=$this->url.$this->do3;
        $res=ihttp_post($url,$data);
        if($res['errno']==1){
            return array(
                'code'=>1,
                'msg'=>$res['message'],
            );
            exit;
        }
        if($res){
            $content=json_decode($res['content'],1);
            if($content['errcode']==0){
                $dir=IA_ROOT.'/addons/sqtg_sun/plugin/'.$content['plugin'].'/';
                if (!file_exists($dir)){
                    mkdir ($dir,0777,true);
                }
                $file_name=$dir.'install.php';
                file_put_contents($file_name,$content['content']);
                include $file_name;
                unlink($file_name);
                //保存key到插件key
                $pluginkey=array(
                    'plugin_id'=>$id,
                    'key'=>$content['key'],
                    'domain'=>$siteroot,
                    'create_time'=>time(),
                    'name'=>$content['name'],
                    'value'=>$content['page'],
                );
                Db::name('pluginkey')->insert($pluginkey);
                ihttp_post($url1,$data);
                return array(
                    'code'=>0,
                    'msg'=>'激活成功',
                );
            }else{
                return array(
                    'code'=>1,
                    'msg'=>$content['errmsg'],
                );
            }
        }
        return array(
            'code'=>1,
            'msg'=>'保存失败',
        );
    }
    public function index(){
        $pluginkey=Db::name('pluginkey')->where(array('plugin_id'=>5))->find();
        if($pluginkey&&empty($pluginkey['value'])){
          $value='/sqtg_sun/pages/plugin/distribution/distributioncenter/distributioncenter';
          Db::name('pluginkey')->where(array('id'=>$pluginkey['id']))->update(array('value'=>$value));
        }
        return view();
    }
    public function get_list(){
        $data=$this->getInstallList();
        $list=json_decode($data,1);
        return [
            'code'=>0,
            'count'=>20,
            'data'=>$list,
            'msg'=>'',
        ];
    }
    private function getInstallList(){
        global $_W;
        $siteroot=$_W['siteroot'];
        $url=$this->url.$this->do1;
        $data=array('siteroot'=>$siteroot);
        $res=ihttp_post($url,$data);
        return $res['content'];
    }

    public function save(){
        $info = $this->model;
        $id = input('post.id');
        $post=input('post.');
        if ($id){
            $info = $info->get($id);
        }
        $post['start_time']=strtotime($post['start_time']);
        $post['end_time']=strtotime($post['end_time']);
        $ret = $info->allowField(true)->save($post);
        if($ret){
            return array(
                'code'=>0,
                'data'=>$info->id,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'保存失败',
            );
        }
    }
}
