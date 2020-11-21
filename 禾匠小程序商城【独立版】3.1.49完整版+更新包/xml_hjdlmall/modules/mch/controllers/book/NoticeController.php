<?php

/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/12/5
 * Time: 15:24
 */

namespace app\modules\mch\controllers\book;

use app\models\YySetting;
use app\modules\mch\models\book\NoticeForm;

class NoticeController extends Controller
{
    public function actionSetting()
    {
        $setting = YySetting::findOne(['store_id' => $this->store->id]);
        if (!$setting) {
            $setting = new YySetting();
        }
        if (\Yii::$app->request->isPost) {
            $model = \Yii::$app->request->post('model');
            if ($setting->isNewRecord) {
                $setting->store_id = $this->store->id;
                $setting->cat = 0;
            }
            $setting->success_notice = $model['success_notice'];
            $setting->refund_notice = $model['refund_notice'];
            if ($setting->save()) {
                return [
                    'code' => 0,
                    'msg' => '保存成功',
                ];
            } else {
                return [
                    'code' => 0,
                    'msg' => '保存失败，请重试',
                ];
            }
        }
        return $this->render('setting', [
            'setting' => $setting,
        ]);
    }
}
