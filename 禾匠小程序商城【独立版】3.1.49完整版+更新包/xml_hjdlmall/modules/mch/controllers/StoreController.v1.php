<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/6/19
 * Time: 16:43
 */

namespace app\modules\mch\controllers;


use app\extensions\FileHelper;
use app\extensions\getInfo;
use app\extensions\Sms;
use app\models\AppNavbar;
use app\models\Attr;
use app\models\AttrGroup;
use app\models\Banner;
use app\models\Cat;
use app\models\Delivery;
use app\models\District;
use app\models\Express;
use app\models\Form;
use app\models\HomeBlock;
use app\models\HomeNav;
use app\models\HomePageModule;
use app\models\MailSetting;
use app\models\Option;
use app\models\PostageRules;
use app\models\Sender;
use app\models\Shop;
use app\models\SmsSetting;
use app\models\UploadConfig;
use app\models\UploadFile;
use app\models\User;
use app\models\UserCenterMenu;
use app\models\Video;
use app\models\WechatTemplateMessage;
use app\modules\mch\models\MailForm;
use app\modules\mch\models\NavbarEditForm;
use app\modules\mch\models\AttrAddForm;
use app\modules\mch\models\AttrDeleteForm;
use app\modules\mch\models\AttrUpdateForm;
use app\modules\mch\models\BannerForm;
use app\modules\mch\models\CatForm;
use app\modules\mch\models\DeliveryForm;
use app\modules\mch\models\DistrictForm;
use app\modules\mch\models\HomeBlockEditForm;
use app\modules\mch\models\HomeNavEditForm;
use app\modules\mch\models\Model;
use app\modules\mch\models\PostageRulesEditForm;
use app\modules\mch\models\SenderForm;
use app\modules\mch\models\ShopForm;
use app\modules\mch\models\SmsForm;
use app\modules\mch\models\StoreDataForm;
use app\modules\mch\models\StoreSettingForm;
use app\modules\mch\models\StoreUploadForm;
use app\modules\mch\models\SubmitFormForm;
use app\modules\mch\models\VideoForm;
use app\modules\mch\models\WxdevToolPreviewForm;
use app\modules\mch\models\WxdevToolUploadForm;
use app\modules\mch\models\WxdevToolLoginForm;
use Comodojo\Zip\Zip;
use League\Flysystem\Filesystem;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;
use yii\helpers\VarDumper;

class StoreController extends Controller
{
    public function actionIndex()
    {
        $form = new StoreDataForm();
        $form->store_id = $this->store->id;
        $store_data = $form->search();
        return $this->render('index', [
            'store' => $this->store,
            'store_data' => $store_data,
        ]);
    }

    /**
     * 基本信息
     */
    public function actionSetting()
    {
        if (\Yii::$app->request->isPost) {
            $form = new StoreSettingForm();
            $form->attributes = \Yii::$app->request->post();
            $form->store_id = $this->store->id;
            $this->renderJson($form->save());
        } else {
            return $this->render('setting', [
                'store' => $this->store,
                'wechat_app' => $this->wechat_app,
            ]);
        }
    }

    /**
     * 首页幻灯片
     */
    public function actionSlide()
    {
        $store = $this->store->id;
        $form = new BannerForm();
        $arr = $form->getList($store);
        return $this->render('slide', [
            'list' => $arr[0],
            'pagination' => $arr[1],
        ]);
    }

    /**
     * 幻灯片添加修改
     */
    public function actionSlideEdit($id = 0)
    {
        $banner = Banner::findOne(['id' => $id]);
        if (!$banner) {
            $banner = new Banner();
        }
        $form = new BannerForm();
        if (\Yii::$app->request->isPost) {
            $model = \Yii::$app->request->post('model');
            $model['store_id'] = $this->store->id;
            $form->attributes = $model;
            $form->banner = $banner;
            return json_encode($form->save(), JSON_UNESCAPED_UNICODE);
        }
        return $this->render('slide-edit', [
            'list' => $banner
        ]);
    }

    /**
     * 幻灯片删除
     * @param int $id
     */
    public function actionSlideDel($id = 0)
    {
        $dishes = Banner::findOne(['id' => $id, 'is_delete' => 0]);
        if (!$dishes) {
            $this->renderJson([
                'code' => 1,
                'msg' => '幻灯片不存在或已经删除'
            ]);
        }
        $dishes->is_delete = 1;
        if ($dishes->save()) {
            $this->renderJson([
                'code' => 0,
                'msg' => '成功'
            ]);
        } else {
            foreach ($dishes->errors as $errors) {
                $this->renderJson([
                    'code' => 1,
                    'msg' => $errors[0],
                ]);
            }
        }
    }

    /**
     * 分类列表
     */
    public function actionCat()
    {
        $cat_list = Cat::find()->where(['store_id' => $this->store->id, 'is_delete' => 0, 'parent_id' => 0])->orderBy('sort,addtime DESC')->all();
        return $this->render('cat', [
            'cat_list' => $cat_list,
        ]);
    }

    /**
     * 分类编辑
     */
    public function actionCatEdit($id = null)
    {
        $cat = Cat::findOne(['id' => $id]);
        if (!$cat) {
            $cat = new Cat();
        }
        $form = new CatForm();
        if (\Yii::$app->request->isPost) {
            $model = \Yii::$app->request->post('model');
            $model['store_id'] = $this->store->id;
            $form->attributes = $model;
            $form->cat = $cat;
            return json_encode($form->save(), JSON_UNESCAPED_UNICODE);
        }
        $parent_list_query = Cat::find()->where([
            'store_id' => $this->store->id,
            'is_delete' => 0,
            'parent_id' => 0,
        ]);
        if (!$cat->isNewRecord && $cat->parent_id == 0) {
            $parent_list_query->andWhere([
                'id' => -1,
            ]);
        }
        $parent_list = $parent_list_query->all();
        return $this->render('cat-edit', [
            'parent_list' => $parent_list,
            'list' => $cat,
        ]);
    }

    /**
     * 分类删除
     */
    public function actionCatDel($id)
    {
        $dishes = Cat::findOne(['id' => $id, 'is_delete' => 0]);
        if (!$dishes) {
            $this->renderJson([
                'code' => 1,
                'msg' => '商品分类删除失败或已删除'
            ]);
        }
        $dishes->is_delete = 1;
        if ($dishes->save()) {
            $this->renderJson([
                'code' => 0,
                'msg' => '成功'
            ]);
        } else {
            foreach ($dishes->errors as $errors) {
                $this->renderJson([
                    'code' => 1,
                    'msg' => $errors[0],
                ]);
            }
        }
    }

    /**
     * 运费规则列表
     */
    public function actionPostageRules()
    {
        return $this->render('postage-rules', [
            'list' => PostageRules::findAll([
                'store_id' => $this->store->id,
                'is_delete' => 0,
            ]),
        ]);
    }

    /**
     * 新增、编辑运费规则
     */
    public function actionPostageRulesEdit($id = null)
    {
        $model = PostageRules::findOne([
            'id' => $id,
            'store_id' => $this->store->id,
            'is_delete' => 0,
        ]);
        if (!$model) {
            $model = new PostageRules();
            $model->store_id = $this->store->id;
        }
        if (\Yii::$app->request->isPost) {
            $form = new PostageRulesEditForm();
            $form->attributes = \Yii::$app->request->post();
            $form->postage_rules = $model;
            $this->renderJson($form->save());
        } else {
            return $this->render('postage-rules-edit', [
                'model' => $model,
                'express_list' => Express::findAll([
                    'is_delete' => 0,
                ]),
                'province_list' => District::findAll(['level' => 'province']),
            ]);
        }
    }

    /**
     * 删除运费规则
     */
    public function actionPostageRulesDelete($id)
    {
        $model = PostageRules::findOne([
            'id' => $id,
            'store_id' => $this->store->id,
            'is_delete' => 0,
        ]);
        if ($model) {
            $model->is_delete = 1;
            $model->save();
        }
        $this->renderJson([
            'code' => 0,
            'msg' => '删除成功',
        ]);
    }

    public function actionPostageRulesSetEnable($id, $type)
    {
        if ($type == 0) {
            PostageRules::updateAll(['is_enable' => 0], ['store_id' => $this->store->id, 'is_delete' => 0, 'id' => $id]);
        }
        if ($type == 1) {
            PostageRules::updateAll(['is_enable' => 0], ['store_id' => $this->store->id, 'is_delete' => 0]);
            PostageRules::updateAll(['is_enable' => 1], ['store_id' => $this->store->id, 'is_delete' => 0, 'id' => $id]);
        }
        $this->redirect(\Yii::$app->request->referrer)->send();
    }

    //规格列表
    public function actionAttr()
    {
        $attr_list = Attr::find()
            ->select('a.id,ag.attr_group_name,a.attr_name')
            ->alias('a')->leftJoin(['ag' => AttrGroup::tableName()], 'a.attr_group_id=ag.id')
            ->where(['ag.store_id' => $this->store->id, 'a.is_delete' => 0, 'ag.is_delete' => 0, 'a.is_default' => 0,])
            ->orderBy('ag.id DESC,a.id DESC')
            ->asArray()->all();
        $attr_query = Attr::find()->where(['is_delete' => 0])->groupBy('attr_group_id');
        return $this->render('attr', [
            'attr_group_list' => AttrGroup::find()->select('ag.*')->alias('ag')->leftJoin([
                'a' => $attr_query
            ], 'a.attr_group_id=ag.id')->where(['ag.is_delete' => 0, 'ag.store_id' => $this->store->id, 'a.is_delete' => 0,])->all(),
            'attr_list' => $attr_list,
        ]);
    }

    //添加规格
    public function actionAttrAdd()
    {
        if (\Yii::$app->request->isPost) {
            $form = new AttrAddForm();
            $form->attributes = \Yii::$app->request->post();
            $form->store_id = $this->store->id;
            $this->renderJson($form->save());
        }
    }

    //修改规格
    public function actionAttrUpdate()
    {
        if (\Yii::$app->request->isPost) {
            $form = new AttrUpdateForm();
            $form->attributes = \Yii::$app->request->post();
            $form->store_id = $this->store->id;
            $this->renderJson($form->save());
        }
    }

    //修改规格
    public function actionAttrDelete()
    {
        $form = new AttrDeleteForm();
        $form->attributes = \Yii::$app->request->get();
        $form->store_id = $this->store->id;
        $this->renderJson($form->save());
    }

    //小程序安装
    public function actionWxapp()
    {
        if (\Yii::$app->request->isPost) {
            $action = \Yii::$app->request->post('action');
            if ($action == 'download') {
                $this->_wxapp_write_api_file();
                $download_url = $this->_wxapp_zip_dir();
                $this->renderJson([
                    'code' => 0,
                    'msg' => 'success',
                    'data' => $download_url,
                ]);
            } elseif ($action == 'wxdev_tool_login') {
                $form = new WxdevToolLoginForm();
                $form->store_id = $this->store->id;
                $this->renderJson($form->getResult());
            } elseif ($action == 'wxdev_tool_preview') {
                $form = new WxdevToolPreviewForm();
                $form->store_id = $this->store->id;
                $form->appid = $this->wechat->appId;
                $this->renderJson($form->getResult());
            } elseif ($action == 'wxdev_tool_upload') {
                $form = new WxdevToolUploadForm();
                $form->store_id = $this->store->id;
                $form->appid = $this->wechat->appId;
                $this->renderJson($form->getResult());
            }
        } else {
            return $this->render('wxapp');
        }
    }

    //获取小程序二维码
    public function actionWxappQrcode()
    {
        if (\Yii::$app->request->isPost) {
            $save_file = md5($this->wechat->appId . $this->wechat->appSecret) . '.png';
            $save_dir = \Yii::$app->basePath . '/web/temp/' . $save_file;
            $web_dir = \Yii::$app->request->hostInfo . \Yii::$app->request->baseUrl . '/temp/' . $save_file;
            if (file_exists($save_dir)) {
                $this->renderJson([
                    'code' => 0,
                    'msg' => 'success',
                    'data' => $web_dir,
                ]);
            }
            $access_token = $this->wechat->getAccessToken();
            $api = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token={$access_token}";
            $data = json_encode([
                'scene' => '0',
                'path' => '/pages/index/index',
                'width' => 480,
            ], JSON_UNESCAPED_UNICODE);
            $this->wechat->curl->post($api, $data);
            if (in_array('Content-Type: image/jpeg', $this->wechat->curl->response_headers)) {
                FileHelper::filePutContents($save_dir, $this->wechat->curl->response);
                $this->renderJson([
                    'code' => 0,
                    'msg' => 'success',
                    'data' => $web_dir,
                ]);
            } else {
                $this->renderJson([
                    'code' => 1,
                    'msg' => '获取小程序码失败',
                ]);
            }


        } else {
            $this->renderJson([
                'code' => 1,
            ]);
        }
    }

    //1.设置api.js文件
    private function _wxapp_write_api_file()
    {
        $app_root = str_replace('\\', '/', \Yii::$app->basePath) . '/';
        $api_root = str_replace('http://', 'https://', \Yii::$app->request->hostInfo) . \Yii::$app->urlManager->scriptUrl . "?store_id={$this->store->id}&r=api/";
        $api_tpl_file = $app_root . 'wechatapp/api.tpl.js';
        $api_file_content = file_get_contents($api_tpl_file);
        $api_file_content = str_replace('{$_api_root}', $api_root, $api_file_content);
        $api_file = $app_root . 'wechatapp/api.js';
        FileHelper::filePutContents($api_file, $api_file_content);
    }

    //2.zip打包目录
    private function _wxapp_zip_dir()
    {
        $app_root = str_replace('\\', '/', \Yii::$app->basePath) . '/';
        $wxapp_root = $app_root . 'wechatapp';
        $zip_name = 'wechatapp' . date('Ymd') . rand(1000, 9999) . '.zip';
        FileHelper::mkDir($app_root . 'web/temp/');
        $zip = Zip::create($app_root . 'web/temp/' . $zip_name);
        $zip->add($wxapp_root);
        return \Yii::$app->request->hostInfo . \Yii::$app->request->baseUrl . '/temp/' . $zip_name;
    }


    //首页导航图标
    public function actionHomeNav()
    {
        $list = HomeNav::find()->where(['store_id' => $this->store->id, 'is_delete' => 0])->orderBy('sort ASC,addtime DESC')->all();
        return $this->render('home-nav', [
            'list' => $list,
        ]);
    }

    /**
     * 首页导航图标编辑
     */
    public function actionHomeNavEdit($id = null)
    {
        $model = HomeNav::findOne(['id' => $id, 'store_id' => $this->store->id]);
        if (!$model) {
            $model = new HomeNav();
        }
        if (\Yii::$app->request->isPost) {
            $form = new HomeNavEditForm();
            $form->attributes = \Yii::$app->request->post('model');
            $form->store_id = $this->store->id;
            $form->model = $model;
            $this->renderJson($form->save());
        }
        return $this->render('home-nav-edit', [
            'model' => $model,
        ]);
    }

    /**
     * 首页导航图标删除
     */
    public function actionHomeNavDel($id = null)
    {
        $model = HomeNav::findOne(['id' => $id, 'store_id' => $this->store->id]);
        if (!$model) {
            $this->renderJson([
                'code' => 1,
                'msg' => '导航图标不存在，或已删除',
            ]);
        }
        $model->is_delete = 1;
        $model->save();
        $this->renderJson([
            'code' => 0,
            'msg' => '删除成功',
        ]);
    }

    /**
     * @return string
     * 短信模板设置
     */
    public function actionSms()
    {
        $form = new SmsForm();
        $list = SmsSetting::findOne(['store_id' => $this->store->id, 'is_delete' => 0]);
        if (!$list) {
            $list = new SmsSetting();
        }
        if (\Yii::$app->request->isPost) {
            $form->store_id = $this->store->id;
            $form->sms = $list;
            $post = \Yii::$app->request->post();
            if ($post['status'] == 1) {
                $form->scenario = 'SUCCESS';
            }
            $form->attributes = $post;
            $this->renderJson($form->save());
        }
        return $this->render('sms', [
            'sms' => $list
        ]);
    }

    //首页设置
    public function actionHomePage()
    {
        if (\Yii::$app->request->isPost) {
            $this->store->home_page_module = \Yii::$app->request->post('module_list');
            if ($this->store->save()) {
                $this->renderJson([
                    'code' => 0,
                    'msg' => '保存成功',
                ]);
            } else {
                $this->renderJson([
                    'code' => 1,
                    'msg' => '保存失败',
                ]);
            }
        } else {
            $form = new HomePageModule();
            $form->store_id = $this->store->id;
            return $this->render('home-page', [
                'module_list' => $form->search(),
                'edit_list' => $form->search(1),
            ]);
        }
    }

    //首页自定义板块
    public function actionHomeBlock()
    {
        $list = HomeBlock::find()->where(['store_id' => $this->store->id, 'is_delete' => 0])->orderBy('addtime DESC')->all();
        return $this->render('home-block', [
            'list' => $list,
        ]);
    }

    //首页自定义板块编辑
    public function actionHomeBlockEdit($id = null)
    {
        $model = HomeBlock::findOne([
            'id' => $id,
            'store_id' => $this->store->id,
            'is_delete' => 0,
        ]);
        if (!$model) {
            $model = new HomeBlock();
        }
        if (\Yii::$app->request->isPost) {
            $form = new HomeBlockEditForm();
            $form->attributes = \Yii::$app->request->post();
            $form->model = $model;
            $form->store = $this->store;
            return $this->renderJson($form->save());
        } else {
            return $this->render('home-block-edit', [
                'model' => $model,
            ]);
        }
    }


    //首页自定义板块删除
    public function actionHomeBlockDelete($id = null)
    {
        $model = HomeBlock::findOne([
            'id' => $id,
            'store_id' => $this->store->id,
            'is_delete' => 0,
        ]);
        if ($model) {
            $model->is_delete = 1;
            $model->save();
        }
        $this->renderJson([
            'code' => 0,
            'msg' => '删除成功',
        ]);
    }

    //上传设置
    public function actionUpload()
    {
        $this->checkIsAdmin();
        $model = UploadConfig::findOne([
            'store_id' => 0,
            'is_delete' => 0,
        ]);
        if (!$model) {
            $model = new UploadConfig();
        }
        if (\Yii::$app->request->isPost) {
            $form = new StoreUploadForm();
            $form->attributes = \Yii::$app->request->post();
            $form->model = $model;
            $form->store_id = $this->store->id;
            $this->renderJson($form->save());
        } else {
            $model->aliyun = json_decode($model->aliyun, true);
            $model->qcloud = json_decode($model->qcloud, true);;
            $model->qiniu = json_decode($model->qiniu, true);
            return $this->render('upload', [
                'model' => $model,
            ]);
        }
    }

    public function actionUploadTest()
    {
        return $this->render('upload-test');
    }

    /**
     * @return string
     * 面单设置列表
     */
    public function actionExpress()
    {
        $form = new DeliveryForm();
        $form->store_id = $this->store->id;
        $arr = $form->getList();
        $district = new DistrictForm();
        $province_list = $district->search();
        $sender = Sender::findOne(['store_id' => $this->store->id, 'is_delete' => 0, 'delivery_id' => 0]);
        if (!$sender) {
            $sender = new Sender();
        }
        if (\Yii::$app->request->isPost) {
            $sender_form = new SenderForm();
            $sender_form->store_id = $this->store->id;
            $sender_form->delivery_id = 0;
            $sender_form->sender = $sender;
            $sender_form->attributes = \Yii::$app->request->post('model');
            $this->renderJson($sender_form->save());
        }
        return $this->render('express', [
            'list' => $arr[0],
            'pagination' => $arr[1],
            'district' => json_encode($province_list['data'], JSON_UNESCAPED_UNICODE),
            'sender' => $sender
        ]);
    }

    /**
     * @return string
     * 面单配置
     */
    public function actionExpressEdit($id = null)
    {
        $express = Express::find()->where(['is_delete' => 0])->orderBy('sort ASC')->asArray()->all();
        $list = Delivery::findOne(['id' => $id]);
        if (!$list) {
            $list = new Delivery();
        }
        $district = new DistrictForm();
        $province_list = $district->search();
        $sender = Sender::findOne(['store_id' => $this->store->id, 'is_delete' => 0, 'delivery_id' => $list['id']]);
        if (!$sender) {
            $sender = new Sender();
        }
        if (\Yii::$app->request->isPost) {
            $t = \Yii::$app->db->beginTransaction();
            $form = new DeliveryForm();
            $form->store_id = $this->store->id;
            $form->delivery = $list;
            $form->attributes = \Yii::$app->request->post('model');
            $res = $form->save();
            if ($res['code'] == 1) {
                $this->renderJson($res);
            }
            $sender_form = new SenderForm();
            $sender_form->store_id = $this->store->id;
            $sender_form->delivery_id = $form->delivery->id;
            $sender_form->sender = $sender;
            $sender_form->attributes = \Yii::$app->request->post('model');
            $res1 = $sender_form->save();
            if ($res1['code'] == 1) {
                $this->renderJson($res1);
            }
            if ($res['code'] == 0 && $res1['code'] == 0) {
                $t->commit();
                $this->renderJson($res);
            } else {
                $t->rollBack();
                $this->renderJson(['code' => 1, 'msg' => '网络异常']);
            }
            $this->renderJson($sender_form->save());
        }
        return $this->render('express-edit', [
            'express' => $express,
            'list' => $list,
            'district' => json_encode($province_list['data'], JSON_UNESCAPED_UNICODE),
            'sender' => $sender
        ]);
    }


    /**
     * @param int $id
     * @return mixed|string
     * @throws \yii\db\Exception
     * 删除
     */
    public function actionExpressDel($id = 0)
    {
        $list = Delivery::findOne(['id' => $id, 'is_delete' => 0]);
        if (!$list) {
            return json_encode([
                'code' => 1,
                'msg' => '网络异常'
            ], JSON_UNESCAPED_UNICODE);
        }
        $list->is_delete = 1;
        if ($list->save()) {
            return json_encode([
                'code' => 0,
                'msg' => '成功'
            ], JSON_UNESCAPED_UNICODE);
        } else {
            return json_encode([
                'code' => 1,
                'msg' => '网络异常'
            ], JSON_UNESCAPED_UNICODE);
        }

    }

    public function actionUploadFileList($type = 'image', $page = 1, $dataType = 'json')
    {
        $offset = ($page - 1) * 20;
        $list = UploadFile::find()
            ->where(['store_id' => $this->store->id, 'is_delete' => 0, 'type' => $type])
            ->orderBy('addtime DESC')
            ->limit(20)->offset($offset)->asArray()->select('file_url')->all();
        if ($dataType == 'json') {
            $this->renderJson([
                'code' => 0,
                'msg' => 'success',
                'data' => [
                    'list' => $list,
                ],
            ]);
        }
        if ($dataType == 'html') {
            $this->layout = false;
            return $this->render('upload-file-list', [
                'list' => $list,
            ]);
        }
    }

    public function actionVideo()
    {
        $store_id = $this->store->id;
        $form = new VideoForm();
        $arr = $form->getList($store_id);
        return $this->render('video', [
            'list' => $arr[0],
            'pagination' => $arr[1]
        ]);
    }

    public function actionVideoEdit($id = null)
    {
        $video = Video::findOne(['id' => $id]);
        if (!$video)
            $video = new Video();
        $form = new VideoForm();
        if (\Yii::$app->request->isPost) {
            $form->video = $video;
            $form->store_id = $this->store->id;
            $form->attributes = \Yii::$app->request->post('model');
            return json_encode($form->save(), JSON_UNESCAPED_UNICODE);
        }
        return $this->render('video-edit', [
            'list' => $video
        ]);
    }

    public function actionVideoDel($id = null)
    {
        $video = Video::findOne(['id' => $id, 'is_delete' => 0]);
        if (!$video) {
            $this->renderJson([
                'code' => 1,
                'msg' => '幻灯片不存在或已经删除'
            ]);
        }
        $video->is_delete = 1;
        if ($video->save()) {
            $this->renderJson([
                'code' => 0,
                'msg' => '成功'
            ]);
        } else {
            foreach ($video->errors as $errors) {
                $this->renderJson([
                    'code' => 1,
                    'msg' => $errors[0],
                ]);
            }
        }
    }

    //模板消息设置|通知设置
    public function actionTplMsg()
    {
        $model = WechatTemplateMessage::findOne(['store_id' => $this->store->id]);
        if (!$model) {
            $model = new WechatTemplateMessage();
            $model->store_id = $this->store->id;
        }
        if (\Yii::$app->request->isPost) {
            $model->attributes = \Yii::$app->request->post();
            $model->store_id = $this->store->id;
            if ($model->save()) {
                return $this->renderJson([
                    'code' => 0,
                    'msg' => '保存成功',
                ]);
            } else {
                return $this->renderJson((new Model())->getModelError($model));
            }
        } else {
            return $this->render('tpl-msg', [
                'model' => $model,
            ]);
        }
    }

    public function actionShop()
    {
        $form = new ShopForm();
        $form->store_id = $this->store->id;
        if (\Yii::$app->request->isPost) {
            $form->attributes = \Yii::$app->request->post();
            $this->renderJson($form->save());
        }
        $form->limit = 20;
        $arr = $form->getList();
        return $this->render('shop', [
            'row_count' => $arr['row_count'],
            'pagination' => $arr['pagination'],
            'list' => $arr['list'],
        ]);
    }

    public function actionShopDel($id = null)
    {
        $shop = Shop::findOne(['id' => $id, 'store_id' => $this->store->id, 'is_delete' => 0]);
        if (!$shop) {
            $this->renderJson([
                'code' => 1,
                'msg' => '网络异常'
            ]);
        }
        $user_exit = User::find()->where(['store_id' => $this->store->id, 'is_delete' => 0, 'shop_id' => $id])->exists();
        if ($user_exit) {
            $this->renderJson([
                'code' => 1,
                'msg' => '请先删除门店下的核销员'
            ]);
        }
        $shop->is_delete = 1;
        if ($shop->save()) {
            $this->renderJson([
                'code' => 0,
                'msg' => '成功'
            ]);
        } else {
            $this->renderJson([
                'code' => 1,
                'msg' => '网络异常'
            ]);
        }
    }

    public function actionShopEdit($id = null)
    {
        $shop = Shop::findOne(['id' => $id, 'store_id' => $this->store->id, 'is_delete' => 0]);
        if (!$shop) {
            $shop = new Shop();
        }
        if (\Yii::$app->request->isPost) {
            $form = new ShopForm();
            $form->store_id = $this->store->id;
            $form->shop = $shop;
            $form->attributes = \Yii::$app->request->post();
            $this->renderJson($form->save());
        }
        return $this->render('shop-edit', [
            'shop' => $shop
        ]);
    }

    //导航设置
    public function actionNavbar()
    {
        $navbar = AppNavbar::getNavbar($this->store->id);
        if (\Yii::$app->request->isPost) {
            $form = new NavbarEditForm();
            $form->attributes = \Yii::$app->request->post();
            $form->store_id = $this->store->id;
            return $this->renderJson($form->save());
        }
        if (\Yii::$app->request->isGet && \Yii::$app->request->isAjax) {
            $navigation_bar_color = Option::get('navigation_bar_color', $this->store->id, 'app', [
                'frontColor' => '#000000',
                'backgroundColor' => '#ffffff',
            ]);
            return $this->renderJson([
                'code' => 0,
                'data' => [
                    'navbar' => $navbar,
                    'navigation_bar_color' => $navigation_bar_color,
                ],
            ]);
        }
        if (\Yii::$app->request->isGet && !\Yii::$app->request->isAjax) {
            return $this->render('navbar');
        }
    }

    //导航设置-恢复默认
    public function actionNavbarReset()
    {
        Option::remove('navigation_bar_color', $this->store->id, 'app');
        Option::remove('navbar', $this->store->id, 'app');
        \Yii::$app->response->redirect(\Yii::$app->urlManager->createUrl(['mch/store/navbar']))->send();
    }

    //邮件设置
    public function actionMail()
    {
        $list = MailSetting::findOne(['store_id' => $this->store->id, 'is_delete' => 0]);
        if (!$list) {
            $list = new MailSetting();
        }
        if (\Yii::$app->request->isPost) {
            $form = new MailForm();
            $post = \Yii::$app->request->post();
            if ($post['status'] == 1) {
                $form->scenario = 'SUCCESS';
            }
            $form->store_id = $this->store->id;
            $form->list = $list;
            $form->attributes = $post;
            $this->renderJson($form->save());
        } else {
            return $this->render('mail', [
                'list' => $list
            ]);
        }
    }

    //用户中心
    public function actionUserCenter()
    {
        $model = new UserCenterMenu();
        $model->store_id = $this->store->id;
        if (\Yii::$app->request->isPost) {
            Option::set('user_center_bg', \Yii::$app->request->post('user_center_bg'), $this->store->id, 'app');
            return $this->renderJson($model->saveMenuList(\Yii::$app->request->post('model')));
        } else {
            return $this->render('user-center', [
                'menu_list' => $model->getMenuList(),
                'user_center_bg' => Option::get('user_center_bg', $this->store->id, 'app', \Yii::$app->request->baseUrl . '/statics/images/img-user-bg.png'),
            ]);
        }
    }

    public function actionForm()
    {
        $form_list = Form::find()->where([
            'is_delete' => 0, 'store_id' => $this->store->id
        ])->orderBy(['sort' => SORT_ASC])->asArray()->all();
        if (\Yii::$app->request->isPost) {
            $post = \Yii::$app->request->post();
            $form = new SubmitFormForm();
            $form->store_id = $this->store->id;
            $form->attributes = $post;
            $this->renderJson($form->save());
        }
        return $this->render('form', [
            'form_list' => json_encode($form_list, JSON_UNESCAPED_UNICODE),
            'is_form' => Option::get('is_form', $this->store->id, 'admin', 0),
            'form_name' => Option::get('form_name', $this->store->id, 'admin', '表单名称'),
        ]);
    }
}