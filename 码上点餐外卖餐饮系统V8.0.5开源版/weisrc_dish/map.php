<?php
defined('IN_IA') or exit('Access Denied');
/*
	*** 配置文件（表示区域的三维数组）其内的点，必须按顺时针方向依次给出！
	*** 确定一点是否在一区域（多边形）内：
		1：过这一点(x0, y0)，画一水平线(y=y0)，与多边形的所有边进行交点判断。
		2：获取交点集（其中不含多边形的顶点）
		3：若该点（x0, y0）的左侧和右侧交点个数均为奇数个，则该点在区域（多边形）内。否则：不在。
	*** 返回结果：
		return === false : 点不在区域内
		return 0, 1, 2, 3 ... 点所在的区域编号（配置文件中的区域编号。）
*/
class Area{
    // 一个表示区域的三维数组
    protected $config = null;

    // 包含每个区域的四边形
    protected $rectangles = null;

    // 每个区域（多边形）的所有边
    protected $lines = null;

    // 要判断的点的x, y坐标
    protected $_x = null;
    protected $_y = null;

    public function __construct($config){
        $this->config = $config;
        $this->initRectangles();
        $this->initLines();
    }

    /*
        获取包含每个配送区域的四边形
    */
    private function initRectangles(){
        foreach ($this->config as $k => $v) {
            $this->rectangles[$k]['minX'] = $this->getMinXInEachConfig($k);
            $this->rectangles[$k]['minY'] = $this->getMinYInEachConfig($k);
            $this->rectangles[$k]['maxX'] = $this->getMaxXInEachConfig($k);
            $this->rectangles[$k]['maxY'] = $this->getMaxYInEachConfig($k);
        }
    }

    /*
        初始化每个区域（多边形）的边（线段：直线的一部分【限制x或者y坐标范围】）
        n 个顶点构成的多边形，有 n-1 条边
    */
    private function initLines(){
        foreach ($this->config as $k => $v) {
            $pointNum = count($v);		// 区域的顶点个数
            $lineNum = $pointNum - 1; 	// 区域的边条数
            for($i=0; $i<$lineNum; $i++){
                // y=kx+b : k
                if($this->config[$k][$i]['x'] - $this->config[$k][$i+1]['x'] == 0) $this->lines[$k][$i]['k'] = 0;
                else $this->lines[$k][$i]['k'] =
                    ($this->config[$k][$i]['y'] - $this->config[$k][$i+1]['y'])/($this->config[$k][$i]['x'] - $this->config[$k][$i+1]['x']);
                // y=kx+b : b
                $this->lines[$k][$i]['b'] = $this->config[$k][$i+1]['y'] - $this->lines[$k][$i]['k'] * $this->config[$k][$i+1]['x'];
                $this->lines[$k][$i]['lx'] = min($this->config[$k][$i]['x'], $this->config[$k][$i+1]['x']);
                $this->lines[$k][$i]['rx'] = max($this->config[$k][$i]['x'], $this->config[$k][$i+1]['x']);
            }
            $pointNum-=1;
            if($this->config[$k][$pointNum]['x'] - $this->config[$k][0]['x'] == 0) $this->lines[$k][$pointNum]['k'] = 0;
            else $this->lines[$k][$pointNum]['k'] =
                ($this->config[$k][$pointNum]['y'] - $this->config[$k][0]['y'])/($this->config[$k][$pointNum]['x'] - $this->config[$k][0]['x']);
            // y=kx+b : b
            $this->lines[$k][$pointNum]['b'] = $this->config[$k][0]['y'] - $this->lines[$k][$pointNum]['k'] * $this->config[$k][0]['x'];
            $this->lines[$k][$pointNum]['lx'] = min($this->config[$k][$pointNum]['x'], $this->config[$k][0]['x']);
            $this->lines[$k][$pointNum]['rx'] = max($this->config[$k][$pointNum]['x'], $this->config[$k][0]['x']);
        }
    }

    /*
        获取一组坐标中，x坐标最小值
    */
    private function getMinXInEachConfig($index){
        $minX = 200;
        foreach ($this->config[$index] as $k => $v) {
            if($v['x'] < $minX){
                $minX = $v['x'];
            }
        }
        return $minX;
    }

    /*
        获取一组坐标中，y坐标最小值
    */
    private function getMinYInEachConfig($index){
        $minY = 200;
        foreach ($this->config[$index] as $k => $v) {
            if($v['y'] < $minY){
                $minY = $v['y'];
            }
        }
        return $minY;
    }

    /*
        获取一组坐标中，x坐标最大值
    */
    public function getMaxXInEachConfig($index){
        $maxX = 0;
        foreach ($this->config[$index] as $k => $v) {
            if($v['x'] > $maxX){
                $maxX = $v['x'];
            }
        }
        return $maxX;
    }

    /*
        获取一组坐标中，y坐标最大值
    */
    public function getMaxYInEachConfig($index){
        $maxY = 0;
        foreach ($this->config[$index] as $k => $v) {
            if($v['y'] > $maxY){
                $maxY = $v['y'];
            }
        }
        return $maxY;
    }

    /*
        获取 y=y0 与特定区域的所有边的交点，并去除和顶点重复的，再将交点分为左和右两部分
    */
    private function getCrossPointInCertainConfig($index){
        $crossPoint = null;
        foreach ($this->lines[$index] as $k => $v) {
            if($v['k'] == 0) return true;
            $x0 = ($this->_y - $v['b']) / $v['k'];	// 交点x坐标
            if($x0 == $this->_x) return true;		// 点在边上
            if($x0 > $v['lx'] && $x0 < $v['rx']){
                if($x0 < $this->_x) $crossPoint['left'][] = $x0;
                if($x0 > $this->_x) $crossPoint['right'][] = $x0;
            }
        }
        return $crossPoint;
    }

    /*
        检测一个点，是否在区域内
        返回结果：
            return === false : 点不在区域内
            return 0, 1, 2, 3 ... 点所在的区域编号（配置文件中的区域编号。）
    */
    public function checkPoint($x, $y){
        $this->_x = $x;
        $this->_y = $y;
        $contain = null;
        foreach ($this->rectangles as $k => $v) {
            if($x > $v['maxX'] || $x < $v['minX'] || $y > $v['maxY'] || $y < $v['minY']){
                continue;
            }else{
                $contain = $k;
                break;
            }
        }
        if($contain === null) return false;
        $crossPoint = $this->getCrossPointInCertainConfig($contain);
        if($crossPoint === true) return $contain;
        if(count($crossPoint['left'])%2 == 1 && count($crossPoint['right'])%2 == 1) return $contain;
        return false;
    }
}