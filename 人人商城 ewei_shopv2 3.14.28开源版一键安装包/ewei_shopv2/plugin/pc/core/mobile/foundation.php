<?php
class FoundationController extends PluginMobilePage
{
	/**
     * 图片上传方法
     * @author: Vencenty
     * @time: 2019/6/10 10:40
     */
	public function imageUpload()
	{
		return $this->model->invoke('util.uploader::upload', false);
	}
}

?>
