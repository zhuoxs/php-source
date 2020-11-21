<?php
 namespace app\boguan\model; class Poster extends BaseModel { public function getImageAttr($value) { return BG_URL . $value; } }