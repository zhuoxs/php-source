<?php
 namespace app\api\model; class Poster extends BaseModel { public function getImageAttr($value) { return SITE_URL . $value; } }