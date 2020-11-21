<?php
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Config;

class Ctask extends Admin
{
//    获取列表页数据
    public function get_list(){
        $model = $this->model;

        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('type|memo|value','like',"%$key%");
            }
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->where($query)->order('id desc ')->select();

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
//    列表页
    public function index()
    {
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $config = Config::get(['key'=>'autotask','uniacid'=>$_W['uniacid']]);
        if(!$config){
            $config = new Config();
            $config->key = 'autotask';
            $config->value = 0;
            $config->save();
        }
        $this->view->taskconfig = $config;
        return view();
    }
//    开启自动执行任务
    public function starttask(){
//        调用任务执行事件
        startTask();
        return array(
            'code'=>0,
        );
    }
//    关闭自动执行任务
    public function closetask(){
        global $_W;
        $config = Config::get(['key'=>'autotask','uniacid'=>$_W['uniacid']]);
        if(!$config){
            $config = new Config();
            $config->key = 'autotask';
        }
        $config->value = 0;
        $ret = $config->save();
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'关闭失败',
            );
        }
    }

    //手动执行任务
    public function exec(){
        $id = input('request.ids');
        $task =  $this->model->get($id);

        $ret = false;
        $ctaskApi = new \app\api\controller\Ctask();
        try{
//            Log::record(json_encode($task),'task-log');
            echo $task->type;
            switch ($task->type){
                case "dingtalk":
                    $ret = $ctaskApi->sendDingtalk($task->value);
                    break;
                case "template":
                    $ret=$ctaskApi->setTem($task->value);
                    break;
                case "seckillorder":
                    $ret=$ctaskApi->cancelSeckillorder($task->value);
                    break;
                case "pinpay";
                    $pin=new Pinorder();
                    $ret=$pin->payOverdue($task->value);
                    break;
                case "pinopen";
                    $pin=new Pinorder();
                    $ret=$pin->openOverdue($task->value);
                    break;
                case "sendOrderPayTemplate":
                    $ret=$ctaskApi->sendOrderPayTemplate($task->value);
                    break;
                case "sendOrdergoodsReceiveTemplate":
                    $ret=$ctaskApi->sendOrdergoodsReceiveTemplate($task->value);
                    break;
                case "sendOrdergoodsRefundTemplate":
                    $ret=$ctaskApi->sendOrdergoodsRefundTemplate($task->value);
                    break;
                case "sendOrdergoodsRefundTemplate2":
                    $ret=$ctaskApi->sendOrdergoodsRefundTemplate2($task->value);
                    break;
                case "distribution_convert_money":
                    $ret=$ctaskApi->distributionConvertMoney($task->value);
                    break;
                case "sendPinorderPayTemplate":
                    $ret=$ctaskApi->sendPinorderPayTemplate($task->value);
                    break;
                case "sendPinorderReceiveTemplate":
                    $ret=$ctaskApi->sendPinorderReceiveTemplate($task->value);
            }
        }catch (\Exception $e){
            $memo = [
                'msg'=>$e->getMessage(),
                'trace'=>$e->getTrace(),
            ];
            $task->memo = json_encode($memo);
            $ret = false;
        }
        $task->execute_times = $task->execute_times + 1;
        $task->execute_time = time()+($task->execute_times*$task->execute_times*10);
        $task->save();
        if ($ret === true){
            $task->state = 1;
            $task->save();
        }
    }
}
