<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/16
 * Time: 15:53
 */

namespace App\Http\Controllers;
use App\Model\Goods;
use App\Model\GoodsClass;
use App\Model\SystemInfo;
use Encore\Admin\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\ModelForm;
use Encore\Admin\Url;

abstract  class Controller
{
    use ModelForm;

    protected $header = "";
    public $admin;


    public function __construct()
    {
        $this->admin  = new Admin();
    }

    public function index()
    {
        return $this->admin->content(function (Content $content) {
            $content->header($this->header);
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    public function grid()
    {

    }

    /**
     * 新增界面.
     *
     * @return Content
     */
    public function create()
    {

        return $this->admin->content(function (Content $content) {
            $content->header($this->header);
            $content->description('新增');

            $content->body($this->form());
        });
    }

    /**
     * 编辑界面.
     *
     * @param $id
     * @return Content
     */
    public function edit()
    {
        $id = $_REQUEST["id"];
        return $this->admin->content(function (Content $content) use ($id) {
            $content->header($this->header);
            $content->description('编辑');

            $content->body($this->form($id)->edit($id));
        });
    }

    /**
     * 获取状态
     * @return array
     */
    public function getStateList()
    {
        $states = [
            'on'  => ['value' => 1, 'text' => '是'],
            'off' => ['value' => 0, 'text' => '否'],
        ];
        return $states;
    }

    public static function getActionType($action_type)
    {
        $action_type_list = ['基本', '商品',"商品分类"];
        if($action_type >=0 && $action_type <=2) {
            return $action_type_list[$action_type];
        }else{
            return "";
        }

    }

    public static function getAction($action_type,$action)
    {
        if (0 == $action_type) {
            return config('actions')[$action];
        } else if(1 == $action_type) {
            return Goods::instance()->find($action)->name;
        }
        else if(2 == $action_type)
        {
            return GoodsClass::instance()->find($action)->title;
        }
        return "无";
    }

    /** Get 或 Post 请求
     * @param $url
     * @param null $data 为null时，为post方法
     *
     * @return mixed
     */
    public function http($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);

        return $output;
    }

    protected function getAccessToken()
    {
        $sys_info = SystemInfo::instance()->first();

        if(!empty($sys_info->access_token)){
            $access_token = json_decode($sys_info->access_token,true);
            if($access_token["expired"] < time()){
                return $access_token["token"];
            }
        }

        $url = sprintf("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s",
            $sys_info->appid,$sys_info->appsecret);

        $res = $this->http($url);

        $res = json_decode($res,true);
        if($res){
            $arr["token"] = $res["access_token"];
            $arr["expired"] = time() + intval($res["expires_in"]) - 500;
            $sys_info->access_token = json_encode($arr);
            $sys_info->save();
            return $arr["token"];
        }
        return "";

    }

    public function getMsgTemplateID($id,$keyword_id_list)
    {
        $access_token = $this->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/wxopen/template/add?access_token=$access_token";
        $data = [
            "id"=>$id,
            "keyword_id_list"=>$keyword_id_list,
        ];
        $res = $this->http($url,json_encode($data));
        $res = json_decode($res,true);
        if($res["errcode"] == 0){
            return $res["template_id"];
        }
        return "";

    }


}