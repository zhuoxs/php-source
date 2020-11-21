<?php
defined('YII_ENV') or exit('Access Denied');
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/6/19
 * Time: 16:52
 */
$urlManager = Yii::$app->urlManager;
$this->title = '安装应用';
$this->params['active_nav_group'] = 10;
?>
<style>
body > .main .main-body {
    padding: 0;
}

.my-frame {
    width: 100%;
    border: none;
    height: calc(100vh - 51px);
    display: block;
}
</style>
<iframe id="myFrame" class="my-frame" src="<?= Yii::$app->urlManager->createUrl(['cloud/plugin/index']) ?>"></iframe>
