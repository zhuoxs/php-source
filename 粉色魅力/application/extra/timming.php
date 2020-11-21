<?php
return array (
  'aa' => 
  array (
    'id' => 'aa',
    'status' => '0',
    'name' => 'aa',
    'des' => '采集今日数据',
    'file' => 'collect',
    'param' => 'ac=cjday&xt=1&ct=&rday=24&cjflag=tv6_com&cjurl=http://cj2.tv6.com/mox/inc/youku.php',
    'weeks' => '1,2,3,4,5,6,0',
    'hours' => '00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23',
  ),
  'bb' => 
  array (
    'status' => '0',
    'name' => 'bb',
    'des' => '生成首页',
    'file' => 'make',
    'param' => 'ac=index',
    'weeks' => '1,2,3,4,5,6,0',
    'hours' => '00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23',
    'id' => 'bb',
    'runtime' => 1543675583,
  ),
  'cc' => 
  array (
    'id' => 'cc',
    'status' => '0',
    'name' => 'cc',
    'des' => '采集规则测试',
    'file' => 'cj',
    'param' => 'id=3',
    'weeks' => '1,2,3,4,5,6,0',
    'hours' => '00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23',
  ),
  'dd' => 
  array (
    'id' => 'dd',
    'status' => '0',
    'name' => 'dd',
    'des' => '清理缓存',
    'file' => 'cache',
    'param' => '',
    'weeks' => '1,2,3,4,5,6,0',
    'hours' => '00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23',
    'runtime' => 1539653972,
  ),
  'ee' => 
  array (
    'id' => 'ee',
    'status' => '0',
    'name' => 'ee',
    'des' => '生成今日分类',
    'file' => 'make',
    'param' => 'ac=type&tab=vod&ac2=day',
    'weeks' => '1,2,3,4,5,6,0',
    'hours' => '00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23',
    'runtime' => 1539655254,
  ),
  'ff' => 
  array (
    'status' => '0',
    'name' => 'ff',
    'des' => '定时百度主动推送',
    'file' => 'urlsend',
    'param' => 'ac=baidu_push&ac2=today&mid=1',
    'weeks' => '1,2,3,4,5,6,0',
    'hours' => '00,01,02,03,04,05,06,07,08,09,10,11,12,13,14,15,16,17,18,19,20,21,22,23',
    'runtime' => 1546331378,
  ),
);