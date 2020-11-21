<?php

namespace app\model;
use think\Db;
class Info extends Base
{
    //统计帖子量
    public function getInfoNum(){
        $data=$this->where(['is_del'=>0])->count();
        return $data;
    }
    //统计帖子浏览量
    public function getPageviewsNum(){
        $data=$this->sum('pageviews_num')+intval(Infosettings::get_curr()['post_browse']);
        return $data;
    }
    //判断用户是否能够发帖
    public function isUserPost($user_id){
        $num=$this->getTodayPostNum($user_id);
        $infosettings=Infosettings::get_curr();
        if(!$infosettings){
            return false;
        }
        if($num>=$infosettings['post_num']&&$infosettings['post_num']>0){
            return false;
        }
        return true;

    }
    //获取用户当天发帖次数
    public function getTodayPostNum($user_id){
        $today=strtotime(date('Y-m-d'));
        $num=$this->where(['user_id'=>$user_id,'create_time'=>['>=',$today]])->count();
        return $num;
    }
    public function user(){
        return $this->hasOne('User','id','user_id');
    }
    public function check_version(){
        $config=getSystemConfig()['system'];
        if(StrCode($config['version'],'DECODE')!='advanced'){
            if(StrCode($config['version'],'DECODE')=='free'){
                $this->check_store_num(intval(StrCode($config['info_num'],'DECODE')));
            }else{
                throw new \ZhyException(getErrorConfig('genuine'));
            }
        }
    }
    //获取数量
    private function check_store_num($num){
        $total_store_num=Db::name('info')->count();
        if($num>0&&$num<=100){
            if($total_store_num>=$num){
                throw new \ZhyException(getErrorConfig('info_num'));
            }
        }else if($num>100){

        }else{
            throw new \ZhyException(getErrorConfig('genuine'));
        }
    }
    //批量过滤词语
    public function replace_word_filtering($content){
        $word_filtering=Infosettings::get_curr()['word_filtering'];
        if($word_filtering){
            $search=explode(',',$word_filtering);
            $content=str_replace($search,'',$content);
        }
        return $content;
    }
}
