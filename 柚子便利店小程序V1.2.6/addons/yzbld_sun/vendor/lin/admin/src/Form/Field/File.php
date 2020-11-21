<?php

namespace Encore\Admin\Form\Field;

use Encore\Admin\Form\Field;


class File extends Field
{
    use UploadField;

   protected $options = ["data-show-preview"=>false,"initialPreviewAsData"=>true];

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

        /*
         * If has original value, means the form is in edit mode,
         * then remove required rule from rules.
         */
        if ($this->original()) {
            $this->removeRule('required');
        }

        /*
         * Make input data validatable if the column data is `null`.
         */
        if (array_has($input, $this->column) && is_null(array_get($input, $this->column))) {
            $input[$this->column] = '';
        }

        $rules = $attributes = [];

        if (!$fieldRules = $this->getRules()) {
            return false;
        }

        $rules[$this->column] = $fieldRules;
        $attributes[$this->column] = $this->label;

        return Validator::make($input, $rules, $this->validationMessages, $attributes);
    }

    /**
     * Prepare for saving.
     *
     * @param UploadedFile|array $file
     *
     * @return mixed|string
     */
    public function prepare($file)
    {

       if(isset($_REQUEST[static::FILE_DELETE_FLAG]))
        {
            $this->destroy();
            return;
        }
       //save file
        return $this->uploadAndDeleteOriginal($file);
    }

    /**
     * Upload file and delete original file.
     *
     * @param UploadedFile $file
     *
     * @return mixed
     */
    protected function uploadAndDeleteOriginal($file)
    {
        $filename = $this->generateUniqueName($file);
        $uploadFile = $this->getDirectory().$filename;
        $storage = \App\Lib\Storage::instance();

        if($storage->isEnable() && $this->isExternalStorage){
            $res = $storage->upload($file["tmp_name"],$filename);
            if($res){
                if(!empty($this->original)){
                    $storage->delete($this->original);
                }
            }else{
                exit("云存储失败,请检查配置参数");
            }


        }else{
            move_uploaded_file($file["tmp_name"],$uploadFile);
            $this->destroy();
        }

        return $filename;
    }

    /**
     * Preview html for file-upload plugin.
     *
     * @return string
     */
    protected function preview()
    {
        return $this->objectUrl($this->value);
    }

    /**
     * Initialize the caption.
     *
     * @param string $caption
     *
     * @return string
     */
    protected function initialCaption($caption)
    {
        return basename($caption);
    }

    /**
     * @return array
     */
    protected function initialPreviewConfig()
    {
        return [
            ['caption' => basename($this->value), 'key' => 0],
        ];
    }


    public function render()
    {
        $this->options(['overwriteInitial' => true,"language"=>"zh"]);
        $this->setupDefaultOptions();

        if (!empty($this->value)) {
            $this->attribute('data-initial-preview', $this->preview());
            $this->attribute('data-initial-caption', $this->initialCaption($this->value));

            $this->setupPreviewOptions();
        }

        $options = json_encode($this->options);

        $this->script = <<<EOT

$("input{$this->getElementClassSelector()}").fileinput({$options});

EOT;

        return parent::render();
    }
}
