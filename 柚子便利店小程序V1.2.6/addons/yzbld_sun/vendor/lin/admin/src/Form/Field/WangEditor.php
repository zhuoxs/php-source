<?php

namespace Encore\Admin\Form\Field;
use Encore\Admin\Form\Field;
use Encore\Admin\Url;

class WangEditor extends Field
{
    protected $view = 'wang-editor';

    protected static $css = [
        '/vendor/wangEditor-3.1.1/release/wangEditor.min.css',
    ];

    protected static $js = [
        '/vendor/wangEditor-3.1.1/release/wangEditor.min.js',
    ];

    public function render()
    {
        $name = $this->formatName($this->column);

        $upload = Url::generate("index","upload");
        $this->script = <<<EOT

var E = window.wangEditor
var editor = new E('#{$this->id}');
editor.customConfig.zIndex = 0
//editor.customConfig.uploadImgShowBase64 = true
editor.customConfig.debug =0
 editor.customConfig.uploadImgServer = '$upload'
editor.customConfig.onchange = function (html) {
    $('input[name=\'$name\']').val(html);
}
editor.create()

EOT;
        return parent::render();
    }
}