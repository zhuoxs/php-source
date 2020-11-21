<?php

namespace Encore\Admin\Form\Field;


class MultipleImage extends MultipleFile
{
    use ImageField;

    /**
     * {@inheritdoc}
     */
    protected $view = 'multiplefile';

    protected $options = ["previewFileType"=>"image","data-show-preview"=>true,"initialPreviewAsData"=>true];

    protected $attributes = ["accept"=>"image/*"];

    protected $isExternalStorage = true;

    /**
     *  Validation rules.
     *
     * @var string
     */
    //protected $rules = 'image';

   /*
    protected function prepareForeach(UploadedFile $image = null)
    {
        $this->name = $this->getStoreName($image);

        $this->callInterventionMethods($image->getRealPath());

        return tap($this->upload($image), function () {
            $this->name = null;
        });
    }*/
}
