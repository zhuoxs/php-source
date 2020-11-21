<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/9/26
 * Time: 18:50
 */

namespace app\modules\mch\controllers;


class PatchController extends Controller
{
    public function actionIndex()
    {
        $this->checkIsAdmin();
        if (\Yii::$app->request->isPost) {
            $res = [
                'code' => 1,
                'msg' => '没做任何操作',
            ];
            if (\Yii::$app->request->post('action') == 'wdcp-patch') {
                $res = $this->wdcpPatch();
            }
            return $res;
        } else {
            $wdcp_patch_file = \Yii::$app->basePath . '/patch/wdcp.json';
            $wdcp_patch = false;
            if (file_exists($wdcp_patch_file)) {
                $wdcp_patch = file_get_contents($wdcp_patch_file);
                if ($wdcp_patch)
                    $wdcp_patch = json_decode($wdcp_patch, true);
            }

            return $this->render('index', [
                'wdcp_patch' => $wdcp_patch,
            ]);
        }
    }

    private function wdcpPatch()
    {
        $status = \Yii::$app->request->post('status');
        if (!$status)
            return [
                'code' => 1,
                'msg' => '没做任何操作',
            ];
        $wdcp_patch_file = \Yii::$app->basePath . '/patch/wdcp.json';
        if ($status == 'open') {
            $hosts = \Yii::$app->request->post('hosts');
            $hosts = str_replace('，', ',', $hosts);
            $hosts = explode(',', $hosts);
            $host_list = [];
            foreach ($hosts as $host)
                if ($host)
                    $host_list[] = $host;
            if (empty($host_list))
                return [
                    'code' => 1,
                    'msg' => '域名不能为空',
                ];
            file_put_contents($wdcp_patch_file, \Yii::$app->serializer->encode($host_list));
            return [
                'code' => 0,
                'msg' => '已开启wdcp补丁',
            ];
        } else {
            unlink($wdcp_patch_file);
            return [
                'code' => 0,
                'msg' => '已关闭wdcp补丁',
            ];
        }
    }
}