<?php
namespace Core\vender;

class Factory {
    private static $node = [];

    /*栏目临近关系递归*/
    /*递归初始张量为0*/
    public static function array_to_tree($data,$pid = 0,$level = 0){
        foreach ($data as $k => $v){
            if($v['pid'] == $pid){
                if($pid == 0){
                    self::$node[] = $v;
                    self::array_to_tree($data,$v['id']);
                }else{
                    if($level == 0){
                        $str = '&nbsp;&nbsp;|__ ';
                    }elseif ($level == 1){
                        $str = '&nbsp;&nbsp;&nbsp;&nbsp;|__ ';
                    }
                    $v['cate_name'] = $str.$v['cate_name'];
                    self::$node[] = $v;
                    self::array_to_tree($data,$v['id'],$level+1);
                }
            }
        }
        return self::$node;
    }

    /*组装树状结构数据*/
    public static function array_to_trees($data = array(),$pid = 0){
        $temp = array();
        foreach ($data as $k => $v){
            if($v['pid'] == $pid){
                $v['sons'] = self::array_to_trees($data,$v['id']);
               array_push($temp,$v);
            }
        }
        return $temp;
    }

    public static function test(){
        echo 'test success';
    }
}