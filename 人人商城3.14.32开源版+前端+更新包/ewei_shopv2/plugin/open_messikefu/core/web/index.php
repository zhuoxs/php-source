<?php

if (!defined("IN_IA")) {
    exit("Access Denied");
}
class Index_EweiShopV2Page extends PluginWebPage
{
    public function main()
    {
        if (pdo_tableexists("messikefu_chat")) {
            header("location: " . webUrl("open_messikefu/set"));
        } else {
            $this->message('尚未安装,点击下方按钮安装插件', 'https://item.taobao.com/item.htm?id=573353771245');
        }
    }
}

?>