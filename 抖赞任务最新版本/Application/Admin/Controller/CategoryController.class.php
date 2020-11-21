<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 后台分类管理
 */
class CategoryController extends AdminBaseController{
	/**
	 * 分类列表
	 */
	public function index(){
		$data=D('Category')->getTreeData('tree','order_number,id');
		$assign=array(
			'data'=>$data
			);
		$this->assign($assign);
		$this->display();
	}

	/**
	 * 添加分类
	 */
	public function add(){
		$data=I('post.');
		unset($data['id']);
		$result=D('Category')->addData($data);
		if ($result) {
			$this->success('添加成功',U('Admin/Category/index'));
		}else{
			$this->error('添加失败');
		}
	}

	/**
	 * 修改分类
	 */
	public function edit(){
		$data=I('post.');
		$map=array(
			'id'=>$data['id']
			);
		$result=D('Category')->editData($map,$data);
		if ($result) {
			$this->success('修改成功',U('Admin/Category/index'));
		}else{
			$this->error('修改失败');
		}
	}

	/**
	 * 删除分类
	 */
	public function delete(){
		$id=I('get.id');
		$map=array(
			'id'=>$id
			);
		$result=D('Category')->deleteData($map);
		if($result){
			$this->success('删除成功',U('Admin/Category/index'));
		}else{
			$this->error('请先删除子分类');
		}
	}

	/**
	 * 分类排序
	 */
	public function order(){
		$data=I('post.');
		$result=D('Category')->orderData($data);
		if ($result) {
			$this->success('排序成功',U('Admin/Category/index'));
		}else{
			$this->error('排序失败');
		}
	}


}
