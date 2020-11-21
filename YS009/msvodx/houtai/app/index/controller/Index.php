<?php
namespace app\index\controller;


use think\Controller;
use think\Exception;
use UploadUtils\Uploader;

use think\Config;


class Index extends Controller
{

    public function index(){
        echo 'Hello world!';
    }

}
