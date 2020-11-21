<?php
 namespace app\api\model; class Join extends BaseModel { public function getThumbAttr($value) { return SITE_URL . $value; } public function getImageAttr($value) { return SITE_URL . $value; } }