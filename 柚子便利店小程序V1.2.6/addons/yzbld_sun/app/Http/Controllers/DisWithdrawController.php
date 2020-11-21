<?php

namespace App\Http\Controllers;

use App\Model\DisWithdraw;
use App\Model\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Url;

class DisWithdrawController extends Controller
{
    protected $header = '配送员提现';

    public function grid()
    {
        return $this->admin->grid(DisWithdraw::class, function (Grid $grid) {
            $grid->column('id', 'id');
            $grid->column('user_id', '配送员')->display(function ($user_id) {
                return User::instance()->find($user_id)->name;
            });
            $grid->column('name', '姓名');
            $grid->column('phone', '电话');
            $grid->column('amount', '提现金额');
            $grid->column('poundage', '手续费');
            $grid->column('commission', '平台抽成');
            $grid->column('true_amount', '到帐金额');
            $grid->column("status","状态")->display(function ($status){
                $status_list = [
                    0 => '申请提现',
                    1 => '审核成功',
                    2 => '审核失败',
                    3 => '提现成功',
                    4 => '提现失败',
                ];
                $label_list = [
                    0 => 'primary',
                    1 => 'success',
                    2 => 'warning',
                    3 => 'success',
                    4 => 'danger',

                ];
                return "<span class='label label-".$label_list[$status]."'>".$status_list[$status]."</span>";//$status_list[$status];

            });
            $grid->column("transaction_id","商户订单号")->display(function ($transaction_id) {
                return is_null($transaction_id) ? "" : $transaction_id;
            });
            $grid->column('remark', '备注')->display(function ($remark){
                return is_null($remark) ? "" : $remark;
            });
            $grid->column('operation', '操作')->display(function (){
                if($this->status == 0 || $this->status == 4){
                    $url =  Url::setDoAndOp('dis_withdraw','dis_from',$this->id);

                    return "<a href='$url'>审核</a>";
                }else{
                    return "";
                }
            });
            $grid->disableCreateButton();
            $grid->tools(function (Grid\Tools $tools){
                $tools->disableBatchActions();
            });

            $grid->disableActions();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->disableIdFilter();

                $status_list = [
                    0 => '申请提现',
                    1 => '审核成功',
                    2 => '审核失败',
                    3 => '提现成功',
                    4 => '提现失败',
                ];
                $filter->equal('status', '状态')->select($status_list);

            });
        });
    }


    public function dis_from_ex($id = null)
    {
        return $this->admin->form(DisWithdraw::class, function (Form $form) use ($id) {

            $form->display('name', '姓名');
            $form->display('phone', '电话');
            $form->display('amount', '提现金额');
            $form->display('poundage', '手续费');
            $form->display('commission', '平台抽成');
            $form->display('true_amount', '到帐金额');
            $form->select("status","审核状态")->options([1=>"审核成功",2=>"审核失败"]);
            $form->text("remark","备注");

            $form->setAction(Url::setDoAndOp('dis_withdraw','post_dis',$_REQUEST["id"]));
        });
    }

    /**
     * 编辑界面.
     * @return Content
     */
    public function dis_from()
    {
        $id = $_REQUEST["id"];
        return $this->admin->content(function (Content $content) use ($id) {
            $content->header("提现审核");
            $content->description('');

            $content->body($this->dis_from_ex($id)->edit($id));
        });
    }
    /**
     * @param $dis_user_id
     * @param $type 0表示进帐,1表示提现
     * @param $name
     * @param $amount
     * @param $remark
     */
    public function changeDisAmount($dis_user_id,$type,$name,$amount,$remark="")
    {
        $dis_amount_log = \App\Model\DisAmountLog::instance();
        $dis_amount_log->dis_user_id = $dis_user_id;
        $dis_amount_log->type = $type;
        $dis_amount_log->name = $name;
        $dis_amount_log->amount = $amount;
        $dis_amount_log->remark = $remark;
        $dis_amount_log->save();
        $user = User::instance()->find($dis_user_id);
        $user->dis_amount += floatval($amount);
        $user->save();
    }
    public function withdrawToWeixinwallet($openid,$amount)
    {
        require_once __DIR__."/../../../wxfirmpay.php";
        $sysinfo = \App\Model\SystemInfo::instance()->first();
        if($sysinfo){
            $mch_appid = $sysinfo->appid;
            $mchid = $sysinfo->mchid;
            $key = $sysinfo->wxkey;
            $apiclient_cert = config("upload.file").$sysinfo->cert_pem;
            $apiclient_key = config("upload.file").$sysinfo->key_pem;
            $re_user_name = "";
            $desc = "提现";
            $partner_trade_no = "300".time();
            try{
                $weixinfirmpay = new \WeixinfirmPay($mch_appid, $mchid, $key, $openid,$partner_trade_no,$re_user_name,$desc,$amount,$apiclient_cert,$apiclient_key);
                $return = $weixinfirmpay->pay();
                if($return['result_code']=='SUCCESS') {

                    return $partner_trade_no;
                }
            }catch (\Exception $e){
               return false;
            }
        }

        return false;
    }
    public function post_dis()
    {
        $id = $_REQUEST["id"];
        $remark = $_REQUEST["remark"];
        $status = $_REQUEST["status"];
        $withdraw = DisWithdraw::instance()->find($id);
        $withdraw->remark = $remark;
        $withdraw->status = $status;
        $withdraw->save();
        if($status == 2){ //审核失败,金额返回

            $this->changeDisAmount($withdraw->user_id,0,"提现失败",$withdraw->amount,"");
        }
        else{ //审核成功,企业微信支付到零钱包

            $partner_trade_no = $this->withdrawToWeixinwallet($withdraw->openid,$withdraw->true_amount);
            if($partner_trade_no === false){

                $withdraw->status = 4;
                if($withdraw->remark == ""){
                    $withdraw->remark = "微信打款失败";
                }else{
                    $withdraw->remark = $remark.";微信打款失败";
                }
            }
            else
            {
                $withdraw->transaction_id = $partner_trade_no;
                $withdraw->status = 3;
            }
            $withdraw->save();
        }

        return redirect(Url::index('dis_withdraw'));
    }

}
