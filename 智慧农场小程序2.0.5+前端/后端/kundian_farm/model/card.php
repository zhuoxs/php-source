<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/26
 * Time: 15:27
 * 兑换卡模型
 */
defined("IN_IA")or exit("Access Denied");
class Card_KundianFarmModel{
    public $card='cqkundian_farm_card';
    public $user='cqkundian_farm_user';
    protected $uniacid='';

    public function __construct($uniacid=''){
        global $_W;
        if($uniacid){
            $this->uniacid=$uniacid;
        }else{
            $this->uniacid=$_W['uniacid'];
        }
    }

    /**
     * 查询兑换卡列表信息
     * @param array $cond       查询条件
     * @param string $keywords  模糊查询关键字
     * @param string $pageIndex 页数
     * @param $pageSize         每页显示条数
     * @return array
     */
    public function selectCard($cond=[],$keywords='',$pageIndex='',$pageSize){
        $query = load()->object('query');
        if(!empty($keywords)){
            $where['uniacid']=$this->uniacid;
            $sql="SELECT a.*,b.nickname FROM ".tablename($this->card)." as a LEFT JOIN ". tablename($this->user)." as b ON a.uid=b.uid 
                WHERE a.uniacid=:uniacid AND a.card_num LIKE :card_num OR  b.nickname LIKE :nickname  ORDER BY a.id DESC";

            $list=pdo_fetchall($sql, array(':card_num' => '%'.$keywords.'%',':nickname' => '%'.$keywords.'%',':uniacid'=>$this->uniacid));
            return $list;
        }
        $cond['uniacid']=$this->uniacid;
        $list = $query->from($this->card, 'a')->leftjoin($this->user, 'b')->on('a.uid', 'b.uid')
            ->select(array('a.*', 'b.nickname'))->where($cond)->orderby('a.id', 'DESC')
            ->page($pageIndex, $pageSize)->getall();

        for ($i=0;$i<count($list);$i++){
            $list[$i]['import_time']=date("Y-m-d H:i:s",$list[$i]['import_time']);
            $list[$i]['use_time']=$list[$i]['use_time']? date("Y-m-d H:i:s",$list[$i]['use_time']) : '--:--';
            $list[$i]['expire_time']=$list[$i]['expire_time'] ? date("Y-m-d H:i:s",$list[$i]['expire_time']) : '--:--';
        }
        return $list;
    }
}