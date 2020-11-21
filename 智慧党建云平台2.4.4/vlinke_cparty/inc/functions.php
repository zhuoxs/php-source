<?php 
if (!defined('IN_IA')) {
    exit('Access Denied');
}




// 信息提示
if (!function_exists('message_tip')) {
    function message_tip($msg, $redirect='', $type='')
    {
        if (empty($msg) && !empty($redirect)) {
            header('Location: '.$redirect);
            exit;
        }
        if($type == 'success') {
            $label = 'text-success wi-right-sign';
        }elseif($type == 'warning') {
            $label = 'text-warning wi-warning-sign';
        }elseif($type == 'info') {
            $label = 'text-info wi-info-sign';
        }else{
            $label = 'text-danger wi-error-sign';
        }
        if($redirect == 'refresh') {
            $redirect = $_W['script_name'] . '?' . $_SERVER['QUERY_STRING'];
        }
        if($redirect == 'referer') {
            $redirect = referer();
        }
        include VLINKE_CPARTY_PATH . 'template/admin/common/message.html';
        exit();
    }
}

// 随机字符串
if (!function_exists('rand_str')) {
    function rand_str($len = 6, $type = '', $addChars = '') {
        $str = '';
        switch ($type) {
            case 0 :
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . $addChars;
                break;
            case 1 :
                $chars = str_repeat('0123456789', 3);
                break;
            case 2 :
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . $addChars;
                break;
            case 3 :
                $chars = 'abcdefghijklmnopqrstuvwxyz' . $addChars;
                break;
            case 4 :
                $chars = $addChars;
                break;
            default :
                // 默认去掉了容易混淆的字符oOLl和数字01，要添加请使用addChars参数
                $chars = 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789' . $addChars;
                break;
        }
        if ($len > 10) { //位数过长重复字符串一定次数
            $chars = $type == 1 ? str_repeat($chars, $len) : str_repeat($chars, 5);
        }
        $chars = str_shuffle($chars);
        $str = substr($chars, 0, $len);
        return $str;
    }
}

// 数据导出CSV
if (!function_exists('export_excel')) {
    function export_excel($data=array(),$title=array(),$filename='report'){
        header("Content-Type: text/csv");
        header("Content-Disposition:attachment;filename=".$filename.".csv");
        if (!empty($title)){
            foreach ($title as $k => $v) {
                $title[$k]=iconv("UTF-8", "GBK",$v);
            }
            $title= implode(",", $title);
            echo "$title\n";
        }
        if (!empty($data)){
            foreach($data as $key=>$val){
                foreach ($val as $ck => $cv) {
                    $data[$key][$ck]=iconv("UTF-8", "GBK", $cv);
                }
                $data[$key]=implode(",", $data[$key]);
            }
            echo implode("\n",$data);
        }
    }
}

// 获取数组上一个元素、下一个元素
if (!function_exists('get_element')) {
    function get_element($key, $array, $who='next') {
        $arr_keys = array_keys($array);
        $arr_keys_flip = array_flip($arr_keys);
        $location = (array_key_exists($key,$arr_keys_flip))?$arr_keys_flip[$key]:die('数组中不存在此键');
        $arr_values = array_values($array);
        $info = array('prev'=>$location-1,'next'=>$location+1);
        $pos = (array_key_exists($who,$info))?$info[$who]:die('错误的参数');
        return  $arr_values[$pos];
    }
}


// 将Base64图片转换为本地图片并保存
if (!function_exists('base64_image_content')) {
    function base64_image_content($base64_image_content,$path) {
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
            $type = $result[2];
            if(!file_exists($path)){
                mkdir($path, 0700);
            }
            $new_file = $path.md5(time()).".{$type}";
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
                return '/'.$new_file;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}


// array_column 兼容低版本
if (!function_exists("array_column")) {
    function array_column(array $array, $column_key, $index_key=null) {
        $result = array();
        foreach($array as $arr) {
            if(!is_array($arr)) continue;

            if(is_null($column_key)){
                $value = $arr;
            }else{
                $value = $arr[$column_key];
            }

            if(!is_null($index_key)){
                $key = $arr[$index_key];
                $result[$key] = $value;
            }else{
                $result[] = $value;
            }
        }
        return $result; 
    }
}

?>