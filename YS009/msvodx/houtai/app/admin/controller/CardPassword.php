<?php
// +----------------------------------------------------------------------
// | msvodx[TP5内核]
// +----------------------------------------------------------------------
// | Copyright © 2019-QQ97250974
// +----------------------------------------------------------------------
// | 专业二开仿站定制修改,做最专业的视频点播系统
// +----------------------------------------------------------------------
// | Author: cherish ©2018
// +----------------------------------------------------------------------
namespace app\admin\controller;
use think\Request;

/**
 * 充值管理控制器
 * @package app\admin\controller
 */
class CardPassword extends Admin
{
    /**
     * 充值记录
     * @author frs
     * @return mixed
     */
    public function index(Request $request)
    {
        $card_type = $request->get('card_type/d',0);
        $status = $request->get('status/d',0);
        $order = $request->get('order/s','');
        switch ($order)
        {
            case 'price_asc':
                $orderBy = 'price asc';
                break;
            case 'price_desc':
                $orderBy = 'price desc';
                break;
            case 'out_time_asc':
                $orderBy = 'out_time asc';
                break;
            case 'out_time_desc':
                $orderBy = 'out_time desc';
                break;
            case 'add_time_asc':
                $orderBy = 'add_time asc';
                break;
            case 'add_time_desc':
                $orderBy = 'add_time desc';
                break;
            default:
                $orderBy = 'id desc';
        }
        $where = ' 1 = 1 ';
        if(!empty($card_type)){
            $where .= ' and card_type = '.$card_type;
        }
        if(!empty($status)){
            if($status == 2) $status = 0;
            $where .= ' and status = '.$status;
        }
        $list=$this->myDb->view('card_password','*')
            ->order($orderBy)
            ->where($where)
            ->paginate(15,false,['query'=>$request->get()]);
        $pages = $list->render();
        $this->assign('card_type', $card_type);
        $this->assign('order', $order);
        $this->assign('status', $status);
        $this->assign('list', $list);
        $this->assign('pages', $pages);
        $this->assign('where',$where);
        return $this->fetch();
    }


    /**
     * 添加卡密
     * @author frs
     * @return mixed
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if($data['card_type'] == 1){
                $data['vip_time'] = !empty($data['permanent'] ) ? 999999999 :  $data['vip_time'];
                if(empty($data['vip_time'] ))  return $this->error('会员天数不能为空！');
            }else{
                if(empty($data['gold'] ))  return $this->error('金币数量不能为空！');
            }
            if($data['number'] > 1000){
                return $this->error('最多一次只能开1000张卡密！');
            }
            $out_time = time()+$data['out_day']*3600*24;
            $list = '';
            for ($i = 1;$i<= $data['number'];$i++){
                $datas = array(
                    'card_number' => $this->createCardNumber($data['card_type'],$data['price']),
                    'card_type' => $data['card_type'],
                    'price' => $data['price'],
                    'add_time' => time(),
                    'out_time' => $out_time,
                );
                if($data['card_type'] == 1){
                    $datas['vip_time'] = $data['vip_time'];
                }else{
                    $datas['gold'] = $data['gold'];
                }
                $list[] = $datas;
            }
           $this->myDb->name('card_password')->insertAll($list);
            return $this->success('添加成功',url('card_password/index'));
        }else{
            return $this->fetch();
        }
    }

    /**
     * 生成卡号
     * @author frs
     * @return mixed
     */
    public function createCardNumber($card_type = 1,$price = '0')
    {
        if($price < 10){
            $price =  '00'.$price;
        }elseif($price < 100){
            $price =  '0'.$price;
        }
        $title_str = ($card_type == 1) ? 'MV'  :  'MG';
        $number = strtoupper($title_str.$price.substr(MD5($title_str.$price.time().rand(111111,999999)),0,11));
        return $number;
    }

    /**
     * 编辑卡密
     * @author frs
     * @return mixed
     */
    public function editPackage()
    {
        $id=$this->request->param('id');
        $where['id'] = $id;
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $data['permanent'] = !empty($data['permanent'] ) ? 1 : 0;
            $result = $this->validate($data, 'RechargePackage');
            if($result !== true) {
                return $this->error($result);
            }
            $this->myDb->name('recharge_package')->where($where)->update($data);
            return $this->success('编辑成功');
        }else{
            $info =  $this->myDb->name('recharge_package')->where($where)->field('id,name,sort,price,days,permanent,status,info')->find();
            $this->assign('info', $info);
            return $this->fetch();
        }
    }


    /**
     * 导出excel
     * $dreamer
     * 2018/02/02
     */
    public function export(Request $request){
        $where=$request->param('condition/s');
        $where=urldecode($where);

        if(empty($where)) $where='';
        $data=null;
        try{
            $data=$this->myDb->name('card_password')->where($where)->select();
        }catch (\Exception $d){
            return $this->error('您的导出数据条件存在问题！');
        }

        set_time_limit(0);

        $phpexcelObj=new \PHPExcel();
        $phpexcelObj->getActiveSheet()
                    ->setCellValue('A1','ID')
                    ->setCellValue('B1','卡号')
                    ->setCellValue('C1','卡类型')
                    ->setCellValue('D1','有效截止日期')
                    ->setCellValue('E1','生成日期')
                    ->setCellValue('F1','使用状态')
                    ->setCellValue('G1','面额')
                    ->setCellValue('H1','金币')
                    ->setCellValue('I1','VIP时长')
                    ->setCellValue('J1','使用时间');
        $phpexcelObj->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $phpexcelObj->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $phpexcelObj->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $phpexcelObj->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $phpexcelObj->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $phpexcelObj->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $phpexcelObj->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $phpexcelObj->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $phpexcelObj->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $phpexcelObj->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);

        foreach ($data as $k=> $card){
            $index=$k+2;
            $phpexcelObj->getActiveSheet()->setCellValue("A{$index}",$card['id']);
            $phpexcelObj->getActiveSheet()->setCellValue("B{$index}",$card['card_number']);
            $phpexcelObj->getActiveSheet()->setCellValue("C{$index}",$card['card_type']==1?'vip卡':'金币卡');
            $phpexcelObj->getActiveSheet()->setCellValue("D{$index}",date('Y/m/d H:i:s',$card['out_time']));
            $phpexcelObj->getActiveSheet()->setCellValue("E{$index}",date('Y/m/d H:i:s',$card['add_time']));
            $phpexcelObj->getActiveSheet()->setCellValue("F{$index}",$card['status']==1?'已使用':'未使用');
            $phpexcelObj->getActiveSheet()->setCellValue("G{$index}",$card['price']);
            $phpexcelObj->getActiveSheet()->setCellValue("H{$index}",$card['gold']);
            $phpexcelObj->getActiveSheet()->setCellValue("I{$index}",$card['vip_time']);
            $phpexcelObj->getActiveSheet()->setCellValue("J{$index}",!empty($card['use_time'])?date('Y/m/d H:i:s',$card['use_time']):'');
        }

        $filename = date('YmdHis').'-卡密清单';
        ob_end_clean();//清除缓冲区,避免乱码
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = new \PHPExcel_Writer_Excel5($phpexcelObj);
        $objWriter->save('php://output');



    }
}
