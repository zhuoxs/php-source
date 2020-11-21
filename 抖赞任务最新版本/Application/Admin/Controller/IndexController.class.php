<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
use Think\Model;

/**
 * 后台首页控制器
 */
class IndexController extends AdminBaseController{
	/**
	 * 首页
	 */
	public function index(){
		// 分配菜单数据
		$nav_data=D('AdminNav')->getTreeData('level','order_number,id');
		$assign=array(
			'data'=>$nav_data
			);
		$this->assign($assign);

        if( session('user.username') == 'admin' ) {
            $this->assign('default_url', U('tongji'));
        } else {
            $this->assign('default_url', U('welcome'));
        }

		$this->display();
	}
	/**
	 * elements
	 */
	public function elements(){

		$this->display();
	}


    public function welcome(){
        if (function_exists('gd_info')) {
            $gd = gd_info();
            $gd = $gd['GD Version'];
        } else {
            $gd = "不支持";
        }
        $info = array(
            '操作系统' => PHP_OS,
            '主机名IP端口' => $_SERVER['SERVER_NAME'] . ' (' . $_SERVER['SERVER_ADDR'] . ':' . $_SERVER['SERVER_PORT'] . ')',
            '运行环境' => $_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式' => php_sapi_name(),
            'MYSQL版本' => function_exists("mysql_close") ? mysql_get_client_info() : '不支持',
            'GD库版本' => $gd,
            //'MYSQL版本' => mysql_get_server_info(),
            '上传附件限制' => ini_get('upload_max_filesize'),
            '执行时间限制' => ini_get('max_execution_time') . "秒",
            '剩余空间' => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
            '服务器时间' => date("Y年n月j日 H:i:s"),
            '北京时间' => gmdate("Y年n月j日 H:i:s", time() + 8 * 3600),
            '采集函数检测' => ini_get('allow_url_fopen') ? '支持' : '不支持',
            //'register_globals' => get_cfg_var("register_globals") == "1" ? "ON" : "OFF",
            'magic_quotes_gpc' => (1 === get_magic_quotes_gpc()) ? 'YES' : 'NO',
            'magic_quotes_runtime' => (1 === get_magic_quotes_runtime()) ? 'YES' : 'NO',
        );
        $this->assign('server_info', $info);

        $this->display();
    }

	/**
	 * welcome
	 */
	public function tongji(){
        //待审核数据
        $total_sh['task_apply'] = M('task_apply') ->where(array('status'=>1))->count();
        $total_sh['tixian'] = M('member_tixian') ->where(array('status'=>0))->count();
        $this->assign('total_sh',$total_sh);

        //统计数据
        $total_num['member'] = M('member')->count();
        $total_num['task'] = M('task')->count();
        $total_num['task_apply'] = M('task_apply')->where(array('status'=>2))->count();
        $total_num['pay'] = M('pay')->sum('price');
        $total_num['tixian'] = M('member_tixian')->where(array('status'=>1))->sum('price');
        $total_num['member_price'] = M('member')->sum('price');
        $this->assign('total_num',$total_num);

        //近期收入
        $total_price['price_1'] = $this->get_total(date("Y-m-d",strtotime("-1 day")),date('Y-m-d'));
        $total_price['price_2'] = $this->get_total(date("Y-m-d",strtotime("-7 day")),date('Y-m-d'));
        $total_price['price_3'] = $this->get_total(date("Y-m-d",strtotime("-30 day")),date('Y-m-d'));
        $total_price['avg_1'] = sprintf("%.2f", $total_price['price_1']);
        $total_price['avg_2'] = sprintf("%.2f", $total_price['price_2']/7);
        $total_price['avg_3'] = sprintf("%.2f", $total_price['price_3']/30);
        $this->assign('total_price',$total_price);

        //近期完成任务
        $total_task['num_1'] = $this->get_task_apply_num(date("Y-m-d",strtotime("-1 day")),date('Y-m-d'));
        $total_task['num_2'] = $this->get_task_apply_num(date("Y-m-d",strtotime("-7 day")),date('Y-m-d'));
        $total_task['num_3'] = $this->get_task_apply_num(date("Y-m-d",strtotime("-30 day")),date('Y-m-d'));
        $total_task['avg_1'] = $total_task['num_1'];
        $total_task['avg_2'] = intval($total_task['num_2']/7);
        $total_task['avg_3'] = intval($total_task['num_3']/30);
        $this->assign('total_task',$total_task);

        //一段日期内的销售情况 曲线数据
        $start_date = I('get.start_date',date("Y-m-d",strtotime("-30 day")));
        $end_date = I('get.end_date',date("Y-m-d"));
        $days_sale = $this->get_days_sale($start_date, $end_date);
        $this->assign('days_sale',$days_sale);
        $this->assign('start_date',$start_date);
        $this->assign('end_date',$end_date);

	    $this->display();
	}

    /**
     * 一段日期内的销售情况  曲线数据
     */
    private function get_days_sale($start_date,$end_date)
    {
        //GROUP BY FROM_UNIXTIME(record_datetime, '%Y%m%d' )
        $days = sp_date_list($start_date, $end_date);

        //构造数组
        $dates = array();
        foreach($days as $val) {
            $dates[$val] = array(
                'sub_total_price' =>0,
                'sub_number'=>0,
                'date'=> date('m-d',strtotime($val))
            );
        }

        $where = "1";
        if( !empty($start_date) && !empty($end_date) ) {
            $start_date = strtotime($start_date);
            $end_date = strtotime($end_date . "23:59:59");
            $where .= " and ( create_time >= {$start_date} and create_time < {$end_date} )";
        }

        $dao = new Model();
        $sql = "select sum(price) as sub_total_price, count(id) as sub_number, FROM_UNIXTIME(create_time, '%Y-%m-%d' ) as `date` from dt_pay where {$where} GROUP BY FROM_UNIXTIME(create_time, '%Y%m%d' )";
        $result = $dao->query($sql);
        foreach( $result as $val ) {
            $dates[$val['date']] = $val;
            $dates[$val['date']]['date'] = date('m-d',strtotime($val['date']));
        }

        $ret = array();
        foreach( $dates as $val ) {
            $ret['price_str'][] = $val['sub_total_price'];
            $ret['number_str'][] = $val['sub_number'];
            $ret['date_str'][] = $val['date'];
        }

        $max_price = max($ret['price_str']); //最大价格
        $max_number = max($ret['number_str']); //最大单数

        $ret['price_str'] = json_encode($ret['price_str']);
        $ret['number_str'] = json_encode($ret['number_str']);
        $ret['max_price'] = $max_price;
        $ret['max_number'] = $max_number;
        $ret['date_str'] = json_encode($ret['date_str']);
        return $ret;
    }

    /**
     * 价格总计
     * @param $start_date
     * @param $end_date
     * @return int
     */
    private function get_total($start_date,$end_date) {
        //今日收入
        $map = array();
        if( !empty($start_date) && !empty($end_date) ) {
            $start_date = strtotime($start_date);
            $end_date = strtotime($end_date);
            $map['_string'] = "( create_time >= {$start_date} and create_time < {$end_date} )";
        }

        $data = M('pay')->where($map)->sum('price');
        $data = sprintf("%.2f", $data);
        return $data;
    }

    private function get_task_apply_num($start_date,$end_date) {
        //今日收入
        $map['status'] = 2;
        if( !empty($start_date) && !empty($end_date) ) {
            $start_date = strtotime($start_date);
            $end_date = strtotime($end_date);
            $map['_string'] = "( create_time >= {$start_date} and create_time < {$end_date} )";
        }

        $data = M('task_apply')->where($map)->count();
        $data = intval($data);
        return $data;
    }

    private function get_avg_price($start_date,$end_date)
    {
        $map['pay_status'] = 1;
        if( !empty($start_date) && !empty($end_date) ) {
            $start_date = strtotime($start_date . "00:00:00");
            $end_date = strtotime($end_date . "23:59:59");
            $map['_string'] = "( create_time >= {$start_date} and create_time < {$end_date} )";
        }

        $data = M('orders')->where($map)->avg('total_price');
        $data = sprintf("%.2f", $data);
        return $data;
    }
}
