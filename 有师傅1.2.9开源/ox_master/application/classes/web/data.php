<?php
if (!(defined('IN_IA')))
{
	exit('Access Denied');
}

class Web_Data extends Web_Base
{
    /**
     * 小程序数据分析
     */
    public function home()
    {
        load()->func('tpl');
        // 昨日概况
        $params = [
            'begin_date' => date('Ymd', strtotime('-1 day', $_SERVER['REQUEST_TIME'])),
            'end_date' => date('Ymd', strtotime('-1 day', $_SERVER['REQUEST_TIME']))
        ];
        //dump($params);die;
       // $dailyList = wxdata::Instance()->dailyVisitTrend($params);
        // 上周概况
        $params = [
            'begin_date' => date('Ymd', strtotime('last week Monday', $_SERVER['REQUEST_TIME'])),
            'end_date' => date('Ymd', strtotime('last week Sunday', $_SERVER['REQUEST_TIME']))
        ];
        $weekList = wxdata::Instance()->weeklyVisitTrend($params);
        // 上月概况
        $params = [
            'begin_date' => date('Ym01', strtotime('-1 month', $_SERVER['REQUEST_TIME'])),
            'end_date' => date('Ymt', strtotime('-1 month', $_SERVER['REQUEST_TIME']))
        ];
       // $monthlyList = wxdata::Instance()->monthlyRetain($params);
        // 用户画像
        $params = [
            'begin_date' => date('Ymd', strtotime('-30 day', $_SERVER['REQUEST_TIME'])),
            'end_date' => date('Ymd', strtotime('-1 day', $_SERVER['REQUEST_TIME']))
        ];
        $portraitList = wxdata::Instance()->userPortrait($params);
        // 昨日概况
        $params = [
            'begin_date' => date('Ymd', strtotime('-1 day', $_SERVER['REQUEST_TIME'])),
            'end_date' => date('Ymd', strtotime('-1 day', $_SERVER['REQUEST_TIME']))
        ];

        $visitPage = wxdata::Instance()->visitPage($params);
        //dump($portraitList['visit_uv_new ']['genders']);die;
       // dump($visitPage);die;
        include $this->template();
    }

}

?>