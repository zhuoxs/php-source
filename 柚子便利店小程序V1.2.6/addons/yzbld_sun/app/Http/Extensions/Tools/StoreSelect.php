<?php
namespace App\Http\Extensions\Tools;
use Encore\Admin\Request;

class StoreSelect extends \Encore\Admin\Grid\Tools\AbstractTool
{

    // baseUrl
    private function getBaseUrl($uri = '')
    {
        $baseUrl = (isset($_SERVER['HTTPS']) && 'off' != $_SERVER['HTTPS']) ? 'https://' : 'http://';
        $baseUrl .= isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
        //$baseUrl .= isset($_SERVER['SCRIPT_NAME']) ? dirname($_SERVER['SCRIPT_NAME']) : dirname(getenv('SCRIPT_NAME'));
        return $baseUrl;
    }

    private function getPathInfo()
    {
        return $_SERVER['SCRIPT_NAME'];
    }
    protected function script()
    {
        $query = $_REQUEST;
        $query["store_id"] = "_store_id_";

        $question = '/' == $this->getBaseUrl().$this->getPathInfo() ? '/?' : '?';


        $url = $this->getBaseUrl().$this->getPathInfo().$question.http_build_query($query);

        $class = "store_select";
        return <<<EOT

$('.$class').select2({
        minimumResultsForSearch: -1
    }).on('change', function(){

    
    //var value = $(this).val();
    
   var url = "$url".replace('_store_id_', $(this).val());

    $.pjax({container:'#pjax-container', url: url });
  
});

EOT;
    }

    public function render()
    {
        \Encore\Admin\Admin::script($this->script());
        $options = \App\Model\Store::instance()->orderBy("id","asc")->pluck("name","id");
        $options->prepend("所有门店",0);
         $store_id = isset($_REQUEST["store_id"]) ? $_REQUEST["store_id"] : 0;
        return \Encore\Admin\Template::viewFormCustom(base_path()."/app/Http/Extensions/views","store_select",
            compact('options','store_id'));
        //return view('admin.tools.gender', compact('options'));
    }
}