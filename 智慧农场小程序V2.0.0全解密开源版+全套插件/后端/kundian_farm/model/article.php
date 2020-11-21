<?php
/**
 * Created by Sublime Text
 * User: 坤典科技
 * Date: 2018/10/10
 * Time: 10:47
 */
defined('IN_IA') or exit('Access Denied');
class Article_KundianFarmModel{
	public $tableName='cqkundian_farm_article';
	public $article_type='cqkundian_farm_article_type';

	public function __construct($tableName=''){
	    if(!empty($tableName)){
            $this->tableName=$tableName;
        }
	}

	public function addArticleType($data){
	    global $_W;
        $updateData=array(
            'type_name'=>$data['type_name'],
            'rank'=>$data['rank'],
            'is_default'=>$data['is_default'],
            'uniacid'=>$_W['uniacid'],
        );
        if(!empty($data['id'])){
            return pdo_update($this->article_type,$updateData,['id'=>$data['id'],'uniacid'=>$_W['uniacid']]);
        }
        return pdo_insert($this->article_type,$updateData);
    }

    public function getArticleAndTypeList($cond=[],$pageIndex='',$pageSize=''){
	    $query=load()->object('query');
        return $query->from($this->tableName, 'a')
            ->leftjoin($this->article_type, 'b')->on('a.type_id', 'b.id')
            ->select('a.*','b.type_name')
            ->where($cond)->orderby('rank asc')->page($pageIndex,$pageSize)->getall();
    }

    public function addArticle($data){
	    global $_W;
        $updateData=array(
            'title'=>$data['title'],
            'type_id'=>$data['type_id'],
            'cover'=>tomedia($data['cover']),
            'content'=>$data['content'],
            'uniacid'=>$_W['uniacid'],
            'rank'=>$data['rank'],
            'create_time'=>time(),
            'view_count'=>$data['view_count'],
            'is_video'=>$data['is_video'],
            'video_src'=>$data['video_src'],
            'mode'=>$data['mode'],
        );
        if(!empty($data['id'])){
            return pdo_update($this->tableName,$updateData,['id'=>$data['id'],'uniacid'=>$_W['uniacid']]);
        }
        return pdo_insert($this->tableName,$updateData);
    }
}

