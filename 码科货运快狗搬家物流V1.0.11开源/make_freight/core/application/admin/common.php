<?php

use app\common\model\Category;
use fast\Form;
use fast\Tree;
use think\Db;
/**
 *计算某个经纬度的周围某段距离的正方形的四个点
 *@param lng float 经度
 *@param lat float 纬度
 *@param distince int 距离（千米）
 *@return array
 */
if(!function_exists('SquarePoint')){
    function SquarePoint($lng, $lat,$distance = 10){
        $earthRadius = 6371;
        $dlng = 2 * asin(sin($distance / (2 * $earthRadius)) / cos(deg2rad($lat)));
        $dlng = rad2deg($dlng);

        $dlat = $distance/$earthRadius;
        $dlat = rad2deg($dlat);
//        $right_bottom_lat   = $point['right_bottom']['lat'];//右下纬度
//        $left_top_lat       = $point['left_top']['lat'];//左上纬度
//        $left_top_lng       = $point['left_top']['lng'];  //左上经度
//        $right_bottom_lng   = $point['right_bottom']['lng']; //右下经度
        return array(
//            'left_top'=>array('lat'=>$lat + $dlat,'lng'=>$lng-$dlng),
//            'right_top'=>array('lat'=>$lat + $dlat, 'lng'=>$lng + $dlng),
//            'left_bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng - $dlng),
//            'right_bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng + $dlng),
            'minlat'  => $lat - $dlat,
            'maxlat'  => $lat + $dlat,
            'minlng'  => $lng - $dlng,
            'maxlng'  => $lng + $dlng,
        );

    }

}

/********************************************************************/

/**
 * 微信退款
 *
 * @param string $order_code, 需退款的支付订单号
 * @param float  $amount, 需退款金额(不能到大余支付订单的金额)
 *
 * @return mixed
 */
function weixinRefund($order_code, $amount, $user_id=0){

    global $_W;

    if(empty($order_code))
        return array(1, '订单号错误！请稍后重试');

    if(empty($amount))
        return array(1, '请选择输入退款金额后重试！');

    $refund_uniontid = date('YmdHis') . 000000 . random(8,1);

    //支付记录
    $paylog = Db::table($_W['config']['db']['tablepre'].'core_paylog')
        ->where(array('uniacid'=>$GLOBALS['fuid'],'module'=>'make_freight','tid'=>$order_code))
        ->find();

    if(empty($paylog))
        return array(1, '此支付订单不存在');


    if ($paylog['status'] != 1)
        return array(1, '此订单还未支付成功不可退款');

    $certPath = ROOT_PATH . '/public/uploads/' . $user_id. '_euermi4lbzd3qsm1mzhy.pem';
    $keyPath  = ROOT_PATH . '/public/uploads/' . $user_id. '_bomvnjzyzdmzbthd.pem' ;

    //微信支付信息
    $res = Db::table($_W['config']['db']['tablepre'].'uni_settings')->where('uniacid',$GLOBALS['fuid'])->column('payment');


    $mcd = array();
    !empty($res[0]) && !empty($res[0]) && $mcd = unserialize($res[0]);

    if(empty($mcd) || empty($mcd['wechat']['mchid']) || empty($mcd['wechat']['signkey']))
        return array(1, '未配置微信支付！');

    if( empty($mcd['wechat_refund']['cert']) || empty($mcd['wechat_refund']['key']))
        return array(1, '请开启微信退款,并配置上传证书！');


    //小程序appid
    $wxapp = Db::table($_W['config']['db']['tablepre'].'account_wxapp')
        ->where(array('uniacid'=>$GLOBALS['fuid']))
        ->find();

    if(empty($wxapp) || empty($wxapp['key']))
        return array(1, '未找到小程序！');


    if(!empty($certPath) && !empty($keyPath)) {
        file_put_contents($certPath, authcode($mcd['wechat_refund']['cert'], 'DECODE'));
        file_put_contents($keyPath, authcode($mcd['wechat_refund']['key'], 'DECODE'));
    }

    $data = array(
        "appid"         =>  $wxapp['key'],
        "mch_id"        =>  $mcd['wechat']['mchid'],
        "out_trade_no"  =>  $paylog['uniontid'],
        "out_refund_no" =>  $refund_uniontid,
        "total_fee"     =>  $amount*100,
        "refund_fee"    =>  $amount*100,
        "nonce_str"     =>  random(8),
        "refund_desc"   =>  "取消订单退款",
    );



    $data['sign']  = generateDataSign($data, 'md5', $mcd['wechat']['signkey']);


    if(empty($data['sign']))
        return array(1, '数字签名生成失败！');

    $data = setXMLData($data);
    $url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';

    $result = setRequest($url, $data, true, $certPath, $keyPath);

    is_file($certPath) && unlink($certPath);
    is_file($keyPath)  && unlink($keyPath);

    $result = getXMLData($result);

    if(empty($result) || strtolower($result['return_code']) !=='success'){
        return array(1, !empty($result['return_msg']) ? $result['return_msg'] : '');
    }
    if( isset($result['result_code']) && strtolower($result['result_code'])!=='success' )
        return array(1, !empty($result['err_code_des']) ? $result['err_code_des'] : '');

    return array(0,'');
}


/********************************************************************/

/**
 * 生成数字签名
 * @param array		$data,	去要签名的数据
 * @param string	$type,	签名类型，目前支持两种：MD5|HMAC-SHA256
 *
 * @return mixed
 */
function generateDataSign($data, $type='md5', $signkey=''){

    $sign = array();
    $type = strtoupper($type);

    ksort($data);

    foreach($data as $k => $v){
        if($v === '' || $v === false || $v === null)
            continue;

        $sign[] = $k.'='.$v;
    }

    $sign[] = 'key='.$signkey;//$mcd['wechat']['signkey'];

    $sign = implode('&', $sign);
    $sign = ($type == 'MD5') ? md5($sign) : hash_hmac('sha256', $sign, $signkey);
    $sign = strtoupper($sign);

    return $sign;
}

/********************************************************************/

/**
 * 通过CURL请求远程数据
 *
 * @access	protected
 * @since	1.0.0
 *
 * @param string	$url,	远程url
 * @param mixed		$post,	是否为POST方式，默认为GET，提供键值对的数组形式可以传递需要POST的数据
 * @param string	$ssl,	是否启用ssl协议
 * @param string	$certPath,	证书路径
 * @param string	$keyPath,	ssl私钥路径
 *
 * @return mixed
 */
function setRequest($url, $post=false, $ssl=true, $certPath='', $keyPath=''){
    $result = '';

    if(!function_exists('curl_init'))
        return '';

    $ch	= curl_init();

    // CURL配置参数
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

    // POST方式
    if($post){
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }

    // SSL协议
    if($ssl){
        // 商户证书
        if(is_file( $certPath )){
            curl_setopt($ch, CURLOPT_SSLCERT, $certPath);
        }

        // SSL私钥
        if(is_file($keyPath )){
            curl_setopt($ch, CURLOPT_SSLKEY, $keyPath);
        }
    }

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

function setXMLData($data){
    if(!is_array($data))
        return '';

    $result = '<xml>';

    foreach($data as $k => $v){
        $result .= '<'.$k.'><![CDATA['.$v.']]></'.$k.'>';
    }

    $result .= '</xml>';

    return $result;
}

/********************************************************************/

/**
 * 解析XML数据，可用于解析微信服务器推送的XML数据
 *
 * @access	public
 * @since	1.0.0
 *
 * @param string $xml, 原始XML数据
 *
 * @return array
 */
function getXMLData($xml){
    if(!function_exists('simplexml_load_string'))
        return array();

    $data = simplexml_load_string($xml);

    if($data === false)
        return array();

    $results = array();

    foreach($data as $k => $v){
        $results[$k] = (string)$v;
    }

    return $results;
}

/**
 * 获取微信使用凭证
 */
function get_access_token($uniacid=0){

    global $_W;
    $uniacid = !empty($uniacid) ? intval($uniacid) : $GLOBALS['fuid'];

    $tablepre = !empty($_W['config']['db']['tablepre']) ? $_W['config']['db']['tablepre'] : 'ims_';

    //用户端appid
    $uni = Db::table($tablepre.'account_wxapp')->where(array('uniacid'=>$uniacid))->field('key,secret')->find();

    if(empty($uni))
        return false;

    $tokenUrl   = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$uni['key']."&secret=".$uni['secret'];
    $html       = file_get_contents($tokenUrl);
    $arr        = json_decode($html,true);
    return !empty($arr['access_token']) ? $arr['access_token'] : $arr;
}

if (!function_exists('build_select')) {

    /**
     * 生成下拉列表
     * @param string $name
     * @param mixed $options
     * @param mixed $selected
     * @param mixed $attr
     * @return string
     */
    function build_select($name, $options, $selected = [], $attr = [])
    {
        $options = is_array($options) ? $options : explode(',', $options);
        $selected = is_array($selected) ? $selected : explode(',', $selected);
        return Form::select($name, $options, $selected, $attr);
    }
}

if (!function_exists('build_radios')) {

    /**
     * 生成单选按钮组
     * @param string $name
     * @param array $list
     * @param mixed $selected
     * @return string
     */
    function build_radios($name, $list = [], $selected = null)
    {
        $html = [];
        $selected = is_null($selected) ? key($list) : $selected;
        $selected = is_array($selected) ? $selected : explode(',', $selected);
        foreach ($list as $k => $v) {
            $html[] = sprintf(Form::label("{$name}-{$k}", "%s {$v}"), Form::radio($name, $k, in_array($k, $selected), ['id' => "{$name}-{$k}"]));
        }
        return '<div class="radio">' . implode(' ', $html) . '</div>';
    }
}

if (!function_exists('build_checkboxs')) {

    /**
     * 生成复选按钮组
     * @param string $name
     * @param array $list
     * @param mixed $selected
     * @return string
     */
    function build_checkboxs($name, $list = [], $selected = null)
    {
        $html = [];
        $selected = is_null($selected) ? [] : $selected;
        $selected = is_array($selected) ? $selected : explode(',', $selected);
        foreach ($list as $k => $v) {
            $html[] = sprintf(Form::label("{$name}-{$k}", "%s {$v}"), Form::checkbox($name, $k, in_array($k, $selected), ['id' => "{$name}-{$k}"]));
        }
        return '<div class="checkbox">' . implode(' ', $html) . '</div>';
    }
}


if (!function_exists('build_category_select')) {

    /**
     * 生成分类下拉列表框
     * @param string $name
     * @param string $type
     * @param mixed $selected
     * @param array $attr
     * @param array $header
     * @return string
     */
    function build_category_select($name, $type, $selected = null, $attr = [], $header = [])
    {
        $tree = Tree::instance();
        $tree->init(Category::getCategoryArray($type), 'pid');
        $categorylist = $tree->getTreeList($tree->getTreeArray(0), 'name');
        $categorydata = $header ? $header : [];
        foreach ($categorylist as $k => $v) {
            $categorydata[$v['id']] = $v['name'];
        }
        $attr = array_merge(['id' => "c-{$name}", 'class' => 'form-control selectpicker'], $attr);
        return build_select($name, $categorydata, $selected, $attr);
    }
}

if (!function_exists('build_toolbar')) {

    /**
     * 生成表格操作按钮栏
     * @param array $btns 按钮组
     * @param array $attr 按钮属性值
     * @return string
     */
    function build_toolbar($btns = null, $attr = [])
    {
        $auth = \app\admin\library\Auth::instance();
        $controller = str_replace('.', '/', strtolower(think\Request::instance()->controller()));
        $btns = $btns ? $btns : ['refresh', 'add', 'edit', 'del', 'import'];
        $btns = is_array($btns) ? $btns : explode(',', $btns);
        $index = array_search('delete', $btns);
        if ($index !== false) {
            $btns[$index] = 'del';
        }
        $btnAttr = [
            'refresh' => ['javascript:;', 'btn btn-primary btn-refresh', 'fa fa-refresh', '', __('Refresh')],
            'add'     => ['javascript:;', 'btn btn-success btn-add', 'fa fa-plus', __('Add'), __('Add')],
            'edit'    => ['javascript:;', 'btn btn-success btn-edit btn-disabled disabled', 'fa fa-pencil', __('Edit'), __('Edit')],
            'del'     => ['javascript:;', 'btn btn-danger btn-del btn-disabled disabled', 'fa fa-trash', __('Delete'), __('Delete')],
            'import'  => ['javascript:;', 'btn btn-info btn-import', 'fa fa-upload', __('Import'), __('Import')],
        ];
        $btnAttr = array_merge($btnAttr, $attr);
        $html = [];
        foreach ($btns as $k => $v) {
            //如果未定义或没有权限
            if (!isset($btnAttr[$v]) || ($v !== 'refresh' && !$auth->check("{$controller}/{$v}"))) {
                continue;
            }
            list($href, $class, $icon, $text, $title) = $btnAttr[$v];
            //$extend = $v == 'import' ? 'id="btn-import-file" data-url="ajax/upload" data-mimetype="csv,xls,xlsx" data-multiple="false"' : '';
            //$html[] = '<a href="' . $href . '" class="' . $class . '" title="' . $title . '" ' . $extend . '><i class="' . $icon . '"></i> ' . $text . '</a>';
            if ($v == 'import') {
                $template = str_replace('/', '_', $controller);
                $download = '';
                if (file_exists("./template/{$template}.xlsx")) {
                    $download .= "<li><a href=\"/template/{$template}.xlsx\" target=\"_blank\">XLSX模版</a></li>";
                }
                if (file_exists("./template/{$template}.xls")) {
                    $download .= "<li><a href=\"/template/{$template}.xls\" target=\"_blank\">XLS模版</a></li>";
                }
                if (file_exists("./template/{$template}.csv")) {
                    $download .= empty($download) ? '' : "<li class=\"divider\"></li>";
                    $download .= "<li><a href=\"/template/{$template}.csv\" target=\"_blank\">CSV模版</a></li>";
                }
                $download .= empty($download) ? '' : "\n                            ";
                if (!empty($download)) {
                    $html[] = <<<EOT
                        <div class="btn-group">
                            <button type="button" href="{$href}" class="btn btn-info btn-import" title="{$title}" id="btn-import-file" data-url="ajax/upload" data-mimetype="csv,xls,xlsx" data-multiple="false"><i class="{$icon}"></i> {$text}</button>
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" title="下载批量导入模版">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">{$download}</ul>
                        </div>
EOT;
                } else {
                    $html[] = '<a href="' . $href . '" class="' . $class . '" title="' . $title . '" id="btn-import-file" data-url="ajax/upload" data-mimetype="csv,xls,xlsx" data-multiple="false"><i class="' . $icon . '"></i> ' . $text . '</a>';
                }
            } else {
                $html[] = '<a href="' . $href . '" class="' . $class . '" title="' . $title . '"><i class="' . $icon . '"></i> ' . $text . '</a>';
            }
        }
        return implode(' ', $html);
    }
}

if (!function_exists('build_heading')) {

    /**
     * 生成页面Heading
     *
     * @param string $path 指定的path
     * @return string
     */
    function build_heading($path = null, $container = true)
    {
        $title = $content = '';
        if (is_null($path)) {
            $action = request()->action();
            $controller = str_replace('.', '/', request()->controller());
            $path = strtolower($controller . ($action && $action != 'index' ? '/' . $action : ''));
        }
        // 根据当前的URI自动匹配父节点的标题和备注
        $data = Db::name('auth_rule')->where('name', $path)->field('title,remark')->find();
        if ($data) {
            $title = __($data['title']);
            $content = __($data['remark']);
        }
        if (!$content) {
            return '';
        }
        $result = '<div class="panel-lead"><em>' . $title . '</em>' . $content . '</div>';
        if ($container) {
            $result = '<div class="panel-heading">' . $result . '</div>';
        }
        return $result;
    }
}

if(!function_exists('getRandChar')){
    function getRandChar($length){
        $str = null;
        $strPol = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $max = strlen($strPol) - 1;

        for($i = 0;$i < $length; $i++){
            $str .= $strPol[rand(0,$max)];
        }

        return $str;
    }
}
