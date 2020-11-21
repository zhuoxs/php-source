<?php

namespace Encore\Admin\Form\Field;

class Image extends File
{
    use ImageField;

    /**
     * {@inheritdoc}
     */
    protected $view = 'file';

    protected $options = ["previewFileType"=>"image","data-show-preview"=>true,"initialPreviewAsData"=>true];

    protected $attributes = ["accept"=>"image/*"];

    protected $isExternalStorage = true;

    /**
     *  Validation rules.
     *
     * @var string
     */
    //protected $rules = 'image';

    /**
     * @param array|UploadedFile $image
     *
     * @return string
     */
    public function prepare($image)
    {
      /*  if (request()->has(static::FILE_DELETE_FLAG)) {
            return $this->destroy();
        }

        $this->name = $this->getStoreName($image);

        $this->callInterventionMethods($image->getRealPath());

        return $this->uploadAndDeleteOriginal($image);*/


        if(isset($_REQUEST[static::FILE_DELETE_FLAG]))
        {
            $this->destroy();
            return;
        }
        //save file
        return $this->uploadAndDeleteOriginal($image);
    }
}
