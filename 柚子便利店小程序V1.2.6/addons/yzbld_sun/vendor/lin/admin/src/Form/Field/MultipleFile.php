<?php

namespace Encore\Admin\Form\Field;

use Encore\Admin\Form\Field;

class MultipleFile extends Field
{
    use UploadField;

    protected $options = ["data-show-preview"=>true];


    protected $isExternalStorage = false;

    //protected $attributes = ["accept"=>"text/plain"];

    /**
     * Css.
     *
     * @var array
     */
    protected static $css = [
        '/vendor/laravel-admin/bootstrap-fileinput/css/fileinput.min.css?v=4.3.7',
    ];

    /**
     * Js.
     *
     * @var array
     */
    protected static $js = [
        '/vendor/laravel-admin/bootstrap-fileinput/js/plugins/canvas-to-blob.min.js?v=4.3.7',
        '/vendor/laravel-admin/bootstrap-fileinput/js/fileinput.min.js?v=4.3.7',
        '/vendor/laravel-admin/bootstrap-fileinput/js/locales/zh.js?v=4.3.7',
    ];

    /**
     * Create a new File instance.
     *
     * @param string $column
     * @param array  $arguments
     */
    public function __construct($column, $arguments = [])
    {
        //$this->initStorage();

        parent::__construct($column, $arguments);
    }

    /**
     * Default directory for file to upload.
     *
     * @return mixed
     */
    public function defaultDirectory()
    {
        return config("upload.file");
    }

    /**
     * {@inheritdoc}
     */
    public function getValidator(array $input)
    {
        if (request()->has(static::FILE_DELETE_FLAG)) {
            return false;
        }

        if ($this->validator) {
            return $this->validator->call($this, $input);
        }

        $attributes = [];

        if (!$fieldRules = $this->getRules()) {
            return false;
        }

        $attributes[$this->column] = $this->label;

        list($rules, $input) = $this->hydrateFiles(array_get($input, $this->column, []));

        return Validator::make($input, $rules, $this->validationMessages, $attributes);
    }

    /**
     * Hydrate the files array.
     *
     * @param array $value
     *
     * @return array
     */
    protected function hydrateFiles(array $value)
    {
        if (empty($value)) {
            return [[$this->column => $this->getRules()], []];
        }

        $rules = $input = [];

        foreach ($value as $key => $file) {
            $rules[$this->column.$key] = $this->getRules();
            $input[$this->column.$key] = $file;
        }

        return [$rules, $input];
    }

    /**
     * Prepare for saving.
     *
     * @param UploadedFile|array $files
     *
     * @return mixed|string
     */
    public function prepare($files)
    {

        if(isset($_REQUEST[static::FILE_DELETE_FLAG]))
        {
            $key = $_REQUEST[static::FILE_DELETE_FLAG];
            $value = $this->destroy($key);
            return $value;
        }

        $targets= [];
        foreach ($files["name"] as $i => $name) {
            $targets[] = $this->upload($name,$files["tmp_name"][$i]);
        }
        $value = array_merge($this->original(), $targets);

        return $value;
    }



    protected function upload($name,$tmpFile)
    {
        $pos = strrpos($name,".");
        $filename =md5(uniqid()).'.'.substr($name,$pos + 1);
        $uploadFile = $this->getDirectory().$filename;
        $storage = \App\Lib\Storage::instance();
        if($storage->isEnable() && $this->isExternalStorage){
            $res = $storage->upload($tmpFile,$filename);
            if(!$res){
                exit("云存储失败,请检查配置参数");
            }

        }else{
            move_uploaded_file($tmpFile,$uploadFile);
        }

        return $filename;
    }
    /**
     * @return array|mixed
     */
    public function original()
    {
        if (empty($this->original)) {
            return [];
        }

        return json_decode($this->original,true);
    }

    /**
     * Prepare for each file.
     *
     * @param UploadedFile $file
     *
     * @return mixed|string
     */
    protected function prepareForeach(UploadedFile $file = null)
    {
        $this->name = $this->getStoreName($file);

        return tap($this->upload($file), function () {
            $this->name = null;
        });
    }

    /**
     * Preview html for file-upload plugin.
     *
     * @return array
     */
    protected function preview()
    {
        $files = $this->value ?: [];

        return array_map([$this, 'objectUrl'], json_decode($files,true));
    }

    /**
     * Initialize the caption.
     *
     * @param array $caption
     *
     * @return string
     */
    protected function initialCaption($caption)
    {
        if (empty($caption)) {
            return '';
        }

        $caption = array_map('basename', $caption);

        return implode(',', $caption);
    }

    /**
     * @return array
     */
    protected function initialPreviewConfig()
    {
        $files = $this->value ?: [];
        $files  =json_decode($files,true);

        $config = [];


        foreach ($files as $index => $file) {
            $config[] = [
                'caption' => basename($file),
                'key'     => $index,
            ];
        }

        return $config;
    }

    public function render()
    {
        $this->attribute('multiple', true);

        $this->setupDefaultOptions();

        if (!empty($this->value)) {
            $this->options(['initialPreview' => $this->preview()]);
            $this->setupPreviewOptions();
        }

        $options = json_encode($this->options);

        $this->script = <<<EOT
$("input{$this->getElementClassSelector()}").fileinput({$options});
EOT;

        return parent::render();
    }


    public function destroy($key)
    {
        $files = $this->original();
        $file = array_get($files, $key);
        if(!is_null($file)){
            $storage = \App\Lib\Storage::instance();

            if($storage->isEnable() && $this->isExternalStorage){
                $storage->delete($file);
            }else{
                $file = $this->getDirectory().$file;
                if(file_exists($file)){
                    unlink($file);
                }
            }

        }
        unset($files[$key]);

        return array_values($files);
    }
}
