<?php
/**
 * Created by PhpStorm.
 * User: 坤典科技
 * Date: 2018/10/12
 * Time: 16:18
 */
defined("IN_IA") or exit("Access Denied");
class Project_KundianFarmPluginFundingModel{
    protected $tableName='';
    public function __construct($tableName){
        $this->tableName=$tableName;
    }

    /**
     * 获取项目信息列表
     * @param $condition
     * @param string $pageIndex
     * @param string $pageSize
     * @param string $order_by
     * @return array
     */
    public function getProjectList($condition,$pageIndex='',$pageSize='',$order_by='rank asc'){
        if(!empty($pageIndex) && !empty($pageSize)){
            $list=pdo_getall($this->tableName,$condition,'','',$order_by,array($pageIndex,$pageSize));
        }else{
            $list=pdo_getall($this->tableName,$condition);
        }
        return $list;
    }

    public function getProjectById($id,$uniacid){
        $list=pdo_get($this->tableName,array('id'=>$id,'uniacid'=>$uniacid));
        return$list;
    }

    /**
     * 获取项目档位信息
     * @param $cond
     * @param bool $mutliple
     * @return array|bool
     */
    public function getProjectSpec($cond,$mutliple=true){
        if($mutliple){
            $list=pdo_getall('cqkundian_farm_plugin_funding_project_spec',$cond);
        }else{
            $list=pdo_get('cqkundian_farm_plugin_funding_project_spec',$cond);
        }
        return $list;
    }

    public function getLowSpec($uniacid){
        $query = load()->object('query');
        $row = $query->from('cqkundian_farm_plugin_funding_project_spec')->where('uniacid',$uniacid)->orderby('price', 'ASC')->get();
        return $row;
    }

    /**
     * 整理项目进展
     * @param $project
     * @return mixed
     */
    public function getProjectProgress($project){
        $project['fund_money']=$project['fund_money']+$project['fund_fictitious_money'];   //总共众筹金额
        $project['target_money']=$project['target_money']+$project['fund_fictitious_money'];    //总共目标金额
        $project['progress']=round($project['fund_money']/$project['target_money']*100,2);     //计算进度
        $project['fund_person_count']=$project['fund_person_count']+$project['fictitious_person'];

        //判断项目是否结束
        if($project['begin_time'] < time()) {
            if ($project['end_time'] > time()) {
                if ($project['fund_money'] >= $project['target_money']) {
                    $project['project_status'] = 3; //众筹成功
                } else {
                    $project['project_status'] = 2; //进行中
                }

            } else {
                $project['project_status'] = 1; //已结束
            }
        }else{
            $project['project_status']=0;       //未开始
        }
        //周期计算
        $time=$project['end_time'] - $project['begin_time'];
        $project['cycle']=floor($time/86400);

        $project['begin_time']=date("Y-m-d",$project['begin_time']);
        $project['end_time']=date("Y-m-d",$project['end_time']);
        $project['profit_send_time']=date("Y-m-d",$project['profit_send_time']);
        return $project;
    }

    /**
     * 获取项目详情
     * @param $id
     * @param $uniacid
     * @return bool
     */
    public function getProjectDetailById($id,$uniacid){
        $list=pdo_get($this->tableName,array('uniacid'=>$uniacid,'id'=>$id));
        return $list;
    }

    /**
     * 获取项目进度信息
     * @param $con
     * @param string $pageIndex
     * @param string $pageSize
     * @param string $order_by
     * @return array
     */
    public function getProgressList($con,$pageIndex='',$pageSize='',$order_by='pro_time desc'){
        if(!empty($pageIndex) && !empty($pageSize)){
            $list=pdo_getall('cqkundian_farm_plugin_funding_progress',$con,'','',$order_by,array($pageIndex,$pageSize));
        }else{
            $list=pdo_getall('cqkundian_farm_plugin_funding_progress',$con,'','',$order_by);
        }

        for($i=0;$i<count($list);$i++){
            $list[$i]['create_time_day']=date('m/d',$list[$i]['pro_time']);
            $list[$i]['create_time_hour']=date('H:i',$list[$i]['pro_time']);
        }
        return $list;
    }

    public function getProgress($cond){
        $query = load()->object('query');
        $row = $query->from('cqkundian_farm_plugin_funding_progress')->where($cond)->orderby('pro_time', 'DESC')->get();
        return $row;
    }

    /**
     * 更新众筹金额和众筹人数
     * @param $pid  项目id
     * @param $fund_money   众筹金额
     * @param $fund_person_count    众筹人数
     * @param $type 1 加 2 减
     * @param $uniacid  小程序唯一ID
     * @return bool
     */
    public function updateProject($pid,$fund_money,$fund_person_count,$type,$uniacid){
        if($type==1){
            $updateData=array(
                'fund_money +='=>$fund_money,
                'fund_person_count +='=>$fund_person_count,
            );
        }else{
            $updateData=array(
                'fund_money -='=>$fund_money,
                'fund_person_count -='=>$fund_person_count,
            );
        }
        $res=pdo_update($this->tableName,$updateData,array('id'=>$pid,'uniacid'=>$uniacid));
        return $res ? true : false;
    }

    public function updateProjectData($updateData,$cond){
        $res=pdo_update($this->tableName,$updateData,$cond);
        return $res ;
    }

}