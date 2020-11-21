<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}
class Index_EweiShopV2Page extends PluginWebPage
{
    public function main()
    {
        global $_W;
        global $_GPC;
        $pindex = max(1, intval($_GPC["page"]));
        $psize = 8;
        $condition = "";
        if ($_GPC["cate"] != "") {
            $condition .= " and cate=" . intval($_GPC["cate"]) . " ";
        }
        if (!empty($_GPC["type"])) {
            $condition .= " and type=" . intval($_GPC["type"]) . " ";
        }
        if (!empty($_GPC["keyword"])) {
            $keyword = "%" . trim($_GPC["keyword"]) . "%";
            $condition .= " and name like '" . $keyword . "' ";
        }
        $this->fix_commission_img();
        $condition .= " and (merch=" . intval($_W["merchid"]) . " or uniacid=0)";
        $list = pdo_fetchall("select id, name, type, preview, uniacid from " . tablename("ewei_shop_diypage_template") . " where (uniacid=:uniacid or uniacid=0) and deleted=0 " . $condition . " order by uniacid asc, type desc, id desc limit " . ($pindex - 1) * $psize . "," . $psize, array(":uniacid" => $_W["uniacid"]));
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename("ewei_shop_diypage_template") . " where deleted=0 and (uniacid=:uniacid or uniacid=0) " . $condition, array(":uniacid" => $_W["uniacid"]));
        $pager = pagination2($total, $pindex, $psize);
        $allpagetype = $this->model->getPageType();
        $category = pdo_fetchall("SELECT id, name FROM " . tablename("ewei_shop_diypage_template_category") . " WHERE merch=:merch and uniacid=:uniacid order by id desc ", array(":merch" => intval($_W["merchid"]), ":uniacid" => $_W["uniacid"]));
        include $this->template();
    }
    public function import()
    {
        global $_W;
        global $_GPC;
    }
    public function delete()
    {
        global $_W;
        global $_GPC;
        if ($_W["ispost"]) {
            $tid = intval($_GPC["id"]);
            if (empty($tid)) {
                show_json(1, "参数错误，请刷新重试！");
            }
            $item = pdo_fetch("SELECT id, name, uniacid FROM " . tablename("ewei_shop_diypage_template") . " WHERE id=:id and (uniacid=:uniacid or uniacid=0) and (merch=:merch or uniacid=0)", array(":merch" => intval($_W["merchid"]), ":uniacid" => $_W["uniacid"], ":id" => $tid));
            if (!empty($item)) {
                if (empty($item["uniacid"])) {
                    if (!$_W["isfounder"]) {
                        show_json(1, "您无权删除系统模板！");
                    }
                    pdo_update("ewei_shop_diypage_template", array("deleted" => 1), array("id" => $tid, "merch" => intval($_W["merchid"])));
                } else {
                    pdo_delete("ewei_shop_diypage_template", array("id" => $tid));
                }
                plog("diypage.temp.delete", "删除模板 名称:" . $item["name"]);
            }
            show_json(0);
        }
    }
    /**
     * 修复 新分销中心预览图不存在的问题
     * author 洋葱
     */
    private function fix_commission_img()
    {
        $img_url = "../addons/ewei_shopv2/plugin/diypage/static/template/commission/preview.png";
        $condition = "uniacid=:uniacid AND type=:type AND tplid=:tplid";
        $params = array(":uniacid" => 0, ":type" => 4, ":tplid" => 15);
        $sql = "select id,preview from " . tablename("ewei_shop_diypage_template") . " where " . $condition . " limit 1";
        $data = pdo_fetch($sql, $params);
        if ($data && empty($data["preview"])) {
            pdo_update("ewei_shop_diypage_template", array("preview" => $img_url), array("id" => $data["id"]));
        }
    }
}

?>