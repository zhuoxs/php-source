<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 柚子黑卡  All rights reserved.
// +----------------------------------------------------------------------
// | Author: 淡蓝海寓
// +----------------------------------------------------------------------

namespace app\admin\controller;

class BaseClass {

    public $modulename;

    public $uniacid;

    public $__define;

    public $navemenu;


    public function __construct(){
        global $_W, $_GPC;
        $this->modulename =  trim($_GPC['m']);
        $this->uniacid =  intval($_W['uniacid']);
        $this->__define =  IA_ROOT.'/addons/'.$this->modulename;
    }

    public function getMainMenu()
    {
        global  $_GPC;
        $menu = include APP_PATH.'/admin/menu.php';
        $navemenu = array();
        $do = $_GPC['do'];
        $ctrl = $_GPC['ctrl']?$_GPC['ctrl']:'';
        $color = 'color:#8d8d8d;';
        foreach ($menu as $key=> $v){
            $op = $v['op']?$v['op']:"display";
            $do = $v["action"]?$v["action"]:$do;
            $_menuData =  array(
                'title'=>'<a href="'.$this->createWebUrl($do, array('op' => $op,'ctrl'=>$v['controller'])) .'" class="panel-title wytitle" id="yframe-'.$key.'"><icon style="'.$color.'" class="fa '.$v['icon'].'"></icon>'.$v['title'].'</a>',
                'items' => array()
            );
            if($v['items']){
                foreach ($v['items'] as $item){
                    $controller = $item['controller']?$item['controller']:$v['controller'];
                    $ctrl = $ctrl?$ctrl:$controller;
                    $_menuData['items'][] =  $this->createMainMenu($item['title'], $item["action"], $controller,$_GPC['do'].$ctrl, '',$item["op"]);
                }
            }

            $navemenu[$key] = $_menuData;
        }

        return $navemenu;
    }


    /**
     * 分页
     * @param $page   第几页数
     * @param $size   每页显示数量
     * @return string
     */
    public function  getPageLimit($page,$size){
        $firstRow = ($page-1) * $size;
        $listRows = $size;
        return $firstRow.','.$listRows;
    }

    function createMainMenu($title, $do, $method,$doact, $icon = "fa-image", $color = '',$op="display"){
        $color = ' style="color:'.$color.';" ';
//        echo $do."----".$method."----".$doact."=";
        return array(
            'title' => $title,
            'url' =>  $this->createWebUrl($do, array('op' => $op,'ctrl'=>$method)) ,
            'active' => $doact == $do.$method ? ' active' : '',
            'append' => array(
                'title' => '<i '.$color.' class="fa fa-angle-right"></i>',
            )
        );
    }


    protected function createWebUrl($do, $query = array()) {
        global  $_GPC;
        $query['do'] = $do;
        $query['m'] = strtolower($this->modulename);
        $query['ctrl'] = $query['ctrl']?$query['ctrl']:$_GPC["ctrl"];
        return wurl('site/entry', $query);
    }

    protected function smallnav($data=array(),$do=''){
        $html = "";
        if(sizeof($data)>0){
            $html = '<ul class="nav nav-tabs"><span class="ygxian"></span><div class="ygdangq">当前位置:</div>';
            foreach($data as $key => $val){
                $html .= '<li class="'.($val['do']==$do?"active":"").'"><a href="'.$this->createWebUrl($val["do"],$val["urlarray"]).'">'.$val["name"].'</a></li>';
            }
            $html .= '</ul>';
        }
        return $html;
    }

    protected function template($filename) {
        global $_W;
        $name = strtolower($this->modulename);
        $defineDir = $this->__define;
        if(defined('IN_SYS')) {
            $source = IA_ROOT . "/web/themes/{$_W['template']}/{$name}/{$filename}.html";
            $compile = IA_ROOT . "/data/tpl/web/{$_W['template']}/{$name}/{$filename}.tpl.php";
            if(!is_file($source)) {
                $source = IA_ROOT . "/web/themes/default/{$name}/{$filename}.html";
            }
            if(!is_file($source)) {
                $source = $defineDir . "/template/{$filename}.html";
            }
            if(!is_file($source)) {
                $source = IA_ROOT . "/web/themes/{$_W['template']}/{$filename}.html";
            }
            if(!is_file($source)) {
                $source = IA_ROOT . "/web/themes/default/{$filename}.html";
            }
        } else {
            $source = IA_ROOT . "/app/themes/{$_W['template']}/{$name}/{$filename}.html";
            $compile = IA_ROOT . "/data/tpl/app/{$_W['template']}/{$name}/{$filename}.tpl.php";
            if(!is_file($source)) {
                $source = IA_ROOT . "/app/themes/default/{$name}/{$filename}.html";
            }
            if(!is_file($source)) {
                $source = $defineDir . "/template/mobile/{$filename}.html";
            }
            if(!is_file($source)) {
                $source = IA_ROOT . "/app/themes/{$_W['template']}/{$filename}.html";
            }
            if(!is_file($source)) {
                if (in_array($filename, array('header', 'footer', 'slide', 'toolbar', 'message'))) {
                    $source = IA_ROOT . "/app/themes/default/common/{$filename}.html";
                } else {
                    $source = IA_ROOT . "/app/themes/default/{$filename}.html";
                }
            }
        }

        if(!is_file($source)) {
            exit("Error: template source '{$filename}' is not exist!");
        }
        $paths = pathinfo($compile);
        $compile = str_replace($paths['filename'], $_W['uniacid'] . '_' . $paths['filename'], $compile);
        if (DEVELOPMENT || !is_file($compile) || filemtime($source) > filemtime($compile)) {
            template_compile($source, $compile, true);
        }
        return $compile;
    }

}