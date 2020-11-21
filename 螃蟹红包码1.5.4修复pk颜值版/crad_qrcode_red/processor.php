<?php
defined("IN_IA") or exit("Access Denied");
class Crad_qrcode_redModuleProcessor extends WeModuleProcessor
{
    public function respond()
    {
        $content = $this->message["content"];
    }
}