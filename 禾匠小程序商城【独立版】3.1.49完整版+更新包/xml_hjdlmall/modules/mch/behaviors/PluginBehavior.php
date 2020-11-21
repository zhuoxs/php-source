<?php


namespace app\modules\mch\behaviors;

/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/10/11
 * Time: 9:44
 */

use yii\base\Behavior;
use yii\web\Controller;

class PluginBehavior extends Behavior
{
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }

    public function beforeAction($e)
    {

    }
}