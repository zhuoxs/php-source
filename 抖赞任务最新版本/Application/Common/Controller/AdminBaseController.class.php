<?php
namespace Common\Controller;
use Common\Controller\BaseController;
/**
 * admin 基类控制器
 */
class AdminBaseController extends BaseController{

	/**
	 * 初始化方法
	 */
	public function _initialize(){
		parent::_initialize();
		$auth=new \Think\Auth();
		$rule_name=MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
		$result=$auth->check($rule_name,$_SESSION['user']['id']);
		if(!$result){
			$this->error('您没有权限访问', U('Public/login'));
		}
	}


    /*---------------------------- CURD 通用方法--------------------------------------*/

    /**
     * 列表
     */
    public function index() {
        $map = $this->_search();
        $model = M(CONTROLLER_NAME);
        if (! empty ( $model )) {
            $this->_list ( CONTROLLER_NAME, $map );
        }
        $this->display();
    }

    /**
     * 添加、编辑操作
     */
    public function handle() {
        $model = M ( CONTROLLER_NAME );
        if( IS_POST ) {
            $data = I('post.');
            foreach($data as $key=>$val){
                if(is_array($val)){
                    $data[$key] = implode(',', $val);
                }
            }

            $id = $data[$model->getPk ()];
            if( isset($data['content']) ) $data['content'] = I('content','',false);
            if( !($id > 0) ) {
                $data['create_time'] = time();
                if ( $model->add ($data) ) {
                    $this->success ('新增成功!');
                } else {
                    $this->error ('新增失败!');
                }
            } else {
                if ($model->save ($data) !== false) {
                    $this->success ('编辑成功!');
                } else {
                    $this->error ('编辑失败!');
                }
            }
        } else {
            $data = I('get.');
            $id = intval($data[$model->getPk()]);
            if( $id > 0) {
                $info = $model->find ( $id );
                $this->assign ( 'info', $info );
            }
            $this->display ();
        }
    }

    /**
     * 删除
     */
    public function delete() {
        $model = M ( CONTROLLER_NAME );
        $data = I('get.');
        $pk = $model->getPk();
        $id = intval($data[$pk]);
        $map[$pk] = array ('eq', $id );
        $result = $model->where($map)->delete();
        if( $result ) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }


    /**
     * 构造搜索条件map
     * @return mixed
     */
    protected function _search(){
        //模糊搜索
        $keytype = I('keytype');
        $keywords = I('keywords');
        if($keywords){
            $keytype = explode(',', $keytype);
            foreach($keytype as $type){
                $map_search[trim($type)] = array('like', "%".$keywords."%");
            }
            $map_search['_logic'] = 'or';

            $map['_complex'] = $map_search;
        }
        return $map;
    }

    /**
     * 分页列表
     * @param mixed|string $modelName 模型名称
     * @param array $map 查询条件
     * @param string $fields 查询字段
     * @param string $sortBy 排序
     * @param int $pageRows 默认分页条数
     * @return mixed
     */
    public function _list($modelName = CONTROLLER_NAME, $map = array(), $fields ='', $sortBy = '', $pageRows = 20) {
        $model = M($modelName);
        if( $sortBy == '' ) $sortBy = $model->getPk().' desc';
        $count = $model->where($map)->count();
        $page = sp_get_page($count,$pageRows);//分页
        $firstRow = $page->firstRow;
        $listRows = $page->listRows;
        if( isset($fields) || $fields != '' ){
            $list = $model->field($fields)->where($map)->order($sortBy)->limit("$firstRow , $listRows")->select();
        } else {
            $list = $model->where($map)->order($sortBy)->limit("$firstRow , $listRows")->select();
        }
        $this->assign("Page", $page->show());
        $this->assign("list", $list);
        $this->assign('count', $count);
        return $list; //返回数据方便数据重组
    }

}

