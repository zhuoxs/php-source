<?php

namespace app\common\model;

use think\Request;

/**
 * 封面记录表模型
 * Class Cover
 * @package app\common\model
 */
class Cover extends BaseModel
{
    protected $name = 'cover';
    protected $root_url;

    private $uplodPath;

    /**
     * 模型初始化
     */
    public function initialize()
    {
        parent::initialize();
        $this->root_url = $this->rootUrl();
    }

    /**
     * 获取默认封面
     */
    public function getCoverDefault()
    {
        return $this->rootUrl() . DS . 'assets/cover_default.jpg';
    }

    /**
     * 处理图片url
     * @param $value
     * @return mixed
     */
    public function getImageAttr($value)
    {
        return $this->root_url . DS . $value;
    }

    /**
     * 关联封面分类模型
     * @return \think\model\relation\BelongsTo
     */
    public function CoverClass()
    {
        return $this->belongsTo('CoverClass', 'class_id');
    }

    /**
     * 获取封面列表
     * @param $wxapp_id
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($wxapp_id)
    {
        $request = Request::instance();
        $filter = ['wxapp_id' => $wxapp_id];
        ($class_id = $request->get('class_id')) > 1 && $filter['class_id'] = $class_id;
        return $this->with(['CoverClass'])
            ->where($filter)
            ->order(['sort' => 'asc', 'cover_id' => 'desc'])
            ->paginate(15, false, ['query' => $request->request()]);
    }

    /**
     * 添加封面
     * @param $wxapp_id
     * @return bool
     */
    public function add($wxapp_id)
    {
        // 封面数据
        $request = Request::instance();
        $coverData = $request->post('Cover/a');
        $coverData['wxapp_id'] = $wxapp_id;
        // 上传封面图片
        $file = $request->file('uploadFile');
        if (empty($file)) {
            return $this->error('请上传封面图片');
        }
        if (!$this->upload($file, $wxapp_id)) {
            return false;
        }
        $coverData['image'] = $this->uplodPath;
        return $this->save($coverData) !== false ? true : false;
    }

    /**
     * 编辑封面
     * @param $wxapp_id
     * @return bool
     */
    public function edit($wxapp_id)
    {
        // 封面数据
        $request = Request::instance();
        $coverData = $request->post('Cover/a');
        // 上传封面图片
        if ($file = $request->file('uploadFile')) {
            if (!$this->upload($file, $wxapp_id)) return false;
            $coverData['image'] = $this->uplodPath;
            $this->removeImageFile();   // 删除旧图片文件
        }
        return $this->save($coverData) !== false ? true : false;
    }

    /**
     * 删除封面
     * @return int
     */
    public function remove()
    {
        $this->removeImageFile();
        return $this->delete();
    }

    /**
     * 删除图片文件
     * @param string $image
     * @return bool
     */
    private function removeImageFile($image = '')
    {
        $image = $image ?: $this->image;
        return file_exists($image) ? unlink($image) : false;
    }

    /**
     * 上传封面图片
     * @param $file \think\File
     * @param $wxapp_id
     * @return bool
     */
    private function upload($file, $wxapp_id)
    {
        // 移动至upload目录
        $rootPath = ROOT_PATH . 'web' . DS;
        $uplodPath = 'uploads' . DS . $wxapp_id;
        $info = $file->validate(['size' => 2097152, 'ext' => 'jpg,jpeg,png,gif'])
            ->move($rootPath . $uplodPath);
        if (empty($info)) {
            return $this->error($file->getError());
        }
        $this->uplodPath = $uplodPath . DS . $info->getSaveName();
        return true;
    }

}