<?php
global $_W,$_GPC;
define("ASSETSS",MODULE_URL."template/diy/");
$opt = $_GPC['opt'];
$ops = array('display', 'copy', 'delete', 'delsys');
$opt = in_array($opt, $ops) ? $opt : 'display';
$uniacid = $_W['uniacid'];

if($opt == 'display'){
	$is = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_diypagetpl')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));

	//将原有页面放到一个模板中
	if(!$is){
	    $pages = pdo_fetchall("SELECT id FROM ".tablename('sudu8_page_diypage')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));

	    if($pages){
	        $pageids = '';
	        foreach ($pages as $key => $value) {
	            $pageids .= ','.$value['id'];
	        }
	        $pageids = substr($pageids,1);
	        $data = array(
	                'pageid' => $pageids,
	                'uniacid' => $uniacid,
	                'template_name' => '原有页面模板',
	                'thumb' => "",
	                'status' => 1,
	                'create_time' => time()
	                );
	        $res = pdo_insert('sudu8_page_diypagetpl', $data);
	    }
	}
	$moban = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_diypagetpl')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
	$moban_sys = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_diypagetpl_sys'));
	return include self::template("diy/moban");
}else if($opt == 'copy'){
	$id = $_GPC["id"];
	$tpls = pdo_fetchAll('SELECT * FROM '.tablename('sudu8_page_diypagetpl')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
	
    if($tpls){
        foreach ($tpls as $k => $v) {
        	pdo_update("sudu8_page_diypagetpl", array('status' => 2), array('uniacid' => $uniacid));
        }
    }

    //判断系统模板是否为空白模板
    if($id == 'm_shops'){
        $page1 = [];
        $page1['uniacid'] = $uniacid;
        $page1['index'] = 1;
        $item1 = 'a:11:{s:14:"M1543281981683";a:4:{s:4:"icon";s:22:"iconfont2 icon-sousuo1";s:6:"params";a:7:{s:5:"value";s:0:"";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:12:{s:9:"textalign";s:4:"left";s:10:"background";s:7:"#ff3420";s:2:"bg";s:4:"#fff";s:12:"borderradius";s:1:"5";s:6:"boxpdh";s:2:"10";s:6:"boxpdz";s:2:"15";s:7:"padding";s:1:"5";s:8:"fontsize";s:2:"13";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:5:"color";s:7:"#c0c0c0";}s:2:"id";s:3:"ssk";}s:14:"M1543281975902";a:5:{s:4:"icon";s:28:"iconfont2 icon-tuoyuankaobei";s:6:"params";a:10:{s:5:"totle";s:1:"2";s:8:"navstyle";s:1:"0";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:9:"navstyle2";s:1:"0";s:4:"imgh";s:3:"134";}s:5:"style";a:18:{s:8:"dotstyle";s:5:"round";s:8:"dotalign";s:4:"left";s:10:"paddingtop";s:1:"0";s:11:"paddingleft";s:1:"0";s:10:"background";s:7:"#ffffff";s:13:"backgroundall";s:7:"#ffffff";s:9:"leftright";s:1:"5";s:6:"bottom";s:2:"10";s:7:"opacity";s:3:"0.8";s:10:"text_color";s:4:"#fff";s:2:"bg";s:7:"#000000";s:9:"jsq_color";s:3:"red";s:3:"pdh";s:1:"0";s:3:"pdw";s:1:"0";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:5:"speed";s:1:"5";}s:4:"data";a:2:{s:14:"C1543281975902";a:5:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_shop/index/banner1.png";s:7:"linkurl";s:0:"";s:6:"single";s:1:"1";s:4:"text";s:12:"文字描述";s:8:"linktype";s:4:"page";}s:14:"C1543281975903";a:5:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_shop/index/banner1.png";s:7:"linkurl";s:0:"";s:6:"single";s:1:"2";s:4:"text";s:12:"文字描述";s:8:"linktype";s:4:"page";}}s:2:"id";s:6:"banner";}s:14:"M1543282017516";a:5:{s:4:"icon";s:22:"iconfont2 icon-anniuzu";s:6:"params";a:8:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:7:"picicon";s:1:"1";s:8:"textshow";s:1:"1";}s:5:"style";a:14:{s:8:"navstyle";s:0:"";s:10:"background";s:7:"#ffffff";s:6:"rownum";s:1:"4";s:8:"showtype";s:1:"0";s:7:"pagenum";s:1:"8";s:7:"showdot";s:1:"1";s:7:"padding";s:1:"0";s:11:"paddingleft";s:2:"10";s:2:"mt";s:2:"10";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:6:"iconfz";s:2:"14";s:9:"iconcolor";s:7:"#434343";s:8:"imgwidth";s:2:"30";}s:4:"data";a:8:{s:14:"C1543282017516";a:6:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/menu1.png";s:7:"linkurl";s:0:"";s:4:"text";s:12:"美妆护肤";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";s:8:"linktype";s:4:"page";}s:14:"C1543282017517";a:6:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/menu2.png";s:7:"linkurl";s:0:"";s:4:"text";s:12:"家具家纺";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";s:8:"linktype";s:4:"page";}s:14:"C1543282017518";a:6:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/menu3.png";s:7:"linkurl";s:0:"";s:4:"text";s:12:"母婴用品";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";s:8:"linktype";s:4:"page";}s:14:"C1543282017519";a:6:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/menu4.png";s:7:"linkurl";s:0:"";s:4:"text";s:12:"生活美食";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";s:8:"linktype";s:4:"page";}s:14:"M1543282019893";a:6:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/menu5.png";s:7:"linkurl";s:0:"";s:4:"text";s:12:"图书音像";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";s:8:"linktype";s:4:"page";}s:14:"M1543282021620";a:6:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/menu6.png";s:7:"linkurl";s:0:"";s:4:"text";s:12:"数码家电";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";s:8:"linktype";s:4:"page";}s:14:"M1543282022851";a:6:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/menu7.png";s:7:"linkurl";s:0:"";s:4:"text";s:12:"衣帽服饰";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";s:8:"linktype";s:4:"page";}s:14:"M1543282024044";a:6:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/menu8.png";s:7:"linkurl";s:0:"";s:4:"text";s:12:"查看更多";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";s:8:"linktype";s:4:"page";}}s:2:"id";s:4:"menu";}s:14:"M1543282028006";a:5:{s:4:"icon";s:19:"iconfont icon-c-pdf";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:6:{s:10:"background";s:7:"#ffffff";s:3:"pdw";s:1:"0";s:3:"pdh";s:1:"0";s:2:"mt";s:2:"10";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";}s:4:"data";a:4:{s:14:"C1543282028006";a:7:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_shop/index/classfit1.png";s:5:"title";s:12:"新品预约";s:4:"text";s:6:"More >";s:3:"bg1";s:7:"#ffffff";s:3:"bg2";s:7:"#ffffff";s:7:"linkurl";s:0:"";s:8:"linktype";s:4:"page";}s:14:"C1543282028007";a:7:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_shop/index/classfit2.png";s:5:"title";s:12:"特惠秒杀";s:4:"text";s:6:"More >";s:3:"bg1";s:7:"#ffffff";s:3:"bg2";s:7:"#ffffff";s:7:"linkurl";s:0:"";s:8:"linktype";s:4:"page";}s:14:"C1543282028008";a:7:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_shop/index/classfit3.png";s:5:"title";s:12:"人气爆款";s:4:"text";s:6:"More >";s:3:"bg1";s:7:"#ffffff";s:3:"bg2";s:7:"#ffffff";s:7:"linkurl";s:0:"";s:8:"linktype";s:4:"page";}s:14:"C1543282028009";a:7:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_shop/index/classfit4.png";s:5:"title";s:9:"拼团购";s:4:"text";s:6:"More >";s:3:"bg1";s:7:"#ffffff";s:3:"bg2";s:7:"#ffffff";s:7:"linkurl";s:0:"";s:8:"linktype";s:4:"page";}}s:2:"id";s:8:"classfit";}s:14:"M1543282043688";a:6:{s:4:"icon";s:28:"iconfont2 icon-tuoyuankaobei";s:6:"params";a:10:{s:5:"totle";s:1:"2";s:8:"navstyle";s:1:"0";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:9:"navstyle2";s:1:"0";s:4:"imgh";s:2:"80";}s:5:"style";a:18:{s:8:"dotstyle";s:5:"round";s:8:"dotalign";s:4:"left";s:10:"paddingtop";s:2:"15";s:11:"paddingleft";s:2:"10";s:10:"background";s:7:"#f1f1f1";s:13:"backgroundall";s:7:"#ffffff";s:9:"leftright";s:1:"5";s:6:"bottom";s:1:"5";s:7:"opacity";s:3:"0.8";s:10:"text_color";s:4:"#fff";s:2:"bg";s:7:"#000000";s:9:"jsq_color";s:3:"red";s:3:"pdh";s:1:"0";s:3:"pdw";s:1:"0";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:5:"speed";s:1:"5";}s:4:"data";a:2:{s:14:"C1543282043688";a:5:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_shop/index/banner2.png";s:7:"linkurl";s:0:"";s:6:"single";s:1:"1";s:4:"text";s:12:"文字描述";s:8:"linktype";s:4:"page";}s:14:"C1543282043689";a:5:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_shop/index/banner2.png";s:7:"linkurl";s:0:"";s:6:"single";s:1:"2";s:4:"text";s:12:"文字描述";s:8:"linktype";s:4:"page";}}s:2:"id";s:6:"banner";s:5:"index";s:3:"NaN";}s:14:"M1543282557409";a:4:{s:4:"icon";s:32:"iconfont2 icon-liebiao_biaotilan";s:6:"params";a:9:{s:5:"title";s:12:"热销推荐";s:6:"title2";s:0:"";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:5:"style";s:1:"1";}s:5:"style";a:11:{s:10:"background";s:7:"#ffffff";s:6:"colorz";s:7:"#434343";s:6:"colorf";s:7:"#838383";s:9:"linecolor";s:7:"#000000";s:9:"fontsizez";s:2:"18";s:9:"fontsizef";s:2:"12";s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:2:"mt";s:1:"2";}s:2:"id";s:6:"title2";}s:14:"M1543282585056";a:5:{s:4:"icon";s:22:"iconfont2 icon-chanpin";s:6:"params";a:31:{s:11:"goodsscroll";s:1:"0";s:9:"showtitle";s:1:"1";s:9:"showprice";s:1:"1";s:7:"showtag";s:1:"0";s:9:"goodsdata";s:1:"1";s:6:"cateid";s:0:"";s:8:"catename";s:0:"";s:7:"groupid";s:0:"";s:9:"groupname";s:0:"";s:9:"goodssort";s:1:"0";s:8:"goodsnum";s:1:"4";s:8:"showicon";s:1:"0";s:12:"iconposition";s:8:"left top";s:12:"productprice";s:1:"1";s:16:"showproductprice";s:1:"0";s:9:"showsales";s:1:"1";s:16:"productpricetext";s:6:"原价";s:9:"salestext";s:6:"销量";s:16:"productpriceline";s:1:"0";s:7:"saleout";s:1:"0";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:7:"imgh_is";s:1:"1";s:4:"imgh";s:3:"100";s:7:"con_key";s:1:"2";s:8:"con_type";s:1:"4";s:8:"sourceid";s:0:"";}s:5:"style";a:20:{s:10:"background";s:7:"#ffffff";s:9:"liststyle";s:5:"block";s:8:"buystyle";s:0:"";s:9:"goodsicon";s:9:"recommand";s:9:"iconstyle";s:8:"triangle";s:10:"pricecolor";s:7:"#ff5555";s:17:"productpricecolor";s:7:"#999999";s:14:"iconpaddingtop";s:1:"0";s:15:"iconpaddingleft";s:1:"0";s:11:"buybtncolor";s:7:"#ff5555";s:8:"iconzoom";s:2:"50";s:10:"titlecolor";s:7:"#000000";s:13:"tagbackground";s:7:"#fe5455";s:10:"salescolor";s:7:"#999999";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:8:"showtype";s:1:"0";}s:4:"data";a:4:{s:14:"C1543282585056";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"title";s:21:"这里是产品标题";s:5:"sales";s:1:"5";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"1";s:3:"des";s:21:"这里是产品描述";}s:14:"C1543282585057";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"title";s:21:"这里是产品标题";s:5:"sales";s:1:"5";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"1";s:4:"desc";s:21:"这里是产品描述";}s:14:"C1543282585058";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"sales";s:1:"5";s:5:"title";s:21:"这里是产品标题";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"0";s:4:"desc";s:21:"这里是产品描述";}s:14:"C1543282585059";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"sales";s:1:"5";s:5:"title";s:21:"这里是产品标题";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"0";s:4:"desc";s:21:"这里是产品描述";}}s:2:"id";s:5:"goods";}s:14:"M1543282618278";a:4:{s:4:"icon";s:32:"iconfont2 icon-liebiao_biaotilan";s:6:"params";a:9:{s:5:"title";s:12:"当季新品";s:6:"title2";s:0:"";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:5:"style";s:1:"1";}s:5:"style";a:11:{s:10:"background";s:7:"#ffffff";s:6:"colorz";s:7:"#434343";s:6:"colorf";s:7:"#838383";s:9:"linecolor";s:7:"#000000";s:9:"fontsizez";s:2:"18";s:9:"fontsizef";s:2:"12";s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:2:"mt";s:2:"10";}s:2:"id";s:6:"title2";}s:14:"M1544057042087";a:6:{s:4:"icon";s:21:"iconfont2 icon-tupian";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:7:{s:10:"paddingtop";s:1:"8";s:11:"paddingleft";s:2:"10";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"background";s:7:"#ffffff";s:12:"borderradius";s:1:"0";}s:4:"data";a:1:{s:14:"C1544057042087";a:5:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_shop/index/bigimg1.png";s:7:"linkurl";s:0:"";s:5:"title";s:0:"";s:4:"text";s:0:"";s:8:"linktype";s:4:"page";}}s:2:"id";s:6:"bigimg";s:5:"index";s:3:"NaN";}s:14:"M1544057043069";a:6:{s:4:"icon";s:21:"iconfont2 icon-tupian";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:7:{s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"background";s:7:"#ffffff";s:12:"borderradius";s:1:"0";}s:4:"data";a:1:{s:14:"C1544057043069";a:5:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_shop/index/bigimg2.png";s:7:"linkurl";s:0:"";s:5:"title";s:0:"";s:4:"text";s:0:"";s:8:"linktype";s:4:"page";}}s:2:"id";s:6:"bigimg";s:5:"index";s:3:"NaN";}s:14:"M1544150483801";a:7:{s:4:"icon";s:21:"iconfont2 icon-caidan";s:6:"isfoot";s:1:"1";s:3:"max";s:1:"1";s:6:"params";a:8:{s:8:"navstyle";s:1:"0";s:8:"textshow";s:1:"1";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:20:{s:11:"pagebgcolor";s:7:"#f9f9f9";s:7:"bgcolor";s:7:"#ffffff";s:9:"bgcoloron";s:7:"#ffffff";s:9:"iconcolor";s:7:"#000000";s:11:"iconcoloron";s:7:"#ff3420";s:9:"textcolor";s:7:"#666666";s:11:"textcoloron";s:7:"#ff3420";s:11:"bordercolor";s:7:"#cccccc";s:13:"bordercoloron";s:7:"#ffffff";s:14:"childtextcolor";s:7:"#666666";s:12:"childbgcolor";s:7:"#f4f4f4";s:16:"childbordercolor";s:7:"#eeeeee";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:11:"paddingleft";s:1:"0";s:10:"paddingtop";s:1:"0";s:8:"iconfont";s:2:"20";s:8:"textfont";s:2:"10";s:3:"bdr";s:1:"0";s:8:"bdrcolor";s:7:"#cccccc";}s:4:"data";a:5:{s:14:"C1544150483801";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot1.png";s:7:"linkurl";s:23:"/sudu8_page/index/index";s:9:"iconclass";s:14:"icon-x-shouye1";s:4:"text";s:6:"首页";s:8:"linktype";s:4:"page";}s:14:"C1544150483802";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot2.png";s:7:"linkurl";s:36:"/sudu8_page_plugin_forum/index/index";s:9:"iconclass";s:11:"icon-c-xin1";s:4:"text";s:12:"好物种草";s:8:"linktype";s:4:"page";}s:14:"C1544150483803";a:4:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot3.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:14:"icon-x-caidan4";s:4:"text";s:12:"全部商品";}s:14:"C1544150483804";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot4.png";s:7:"linkurl";s:19:"/sudu8_page/gwc/gwc";s:9:"iconclass";s:11:"icon-x-gwc1";s:4:"text";s:9:"购物车";s:8:"linktype";s:4:"page";}s:14:"M1544150517467";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot5.png";s:7:"linkurl";s:33:"/sudu8_page/usercenter/usercenter";s:9:"iconclass";s:13:"icon-x-geren1";s:4:"text";s:6:"我的";s:8:"linktype";s:4:"page";}}s:2:"id";s:8:"footmenu";}}';
        $item1 = unserialize($item1);
        foreach($item1 as $k => &$v){
            if($v['data']){
                foreach($v['data'] as $kk => &$vv){
                    if($vv['imgurl'] && strpos($vv['imgurl'],'https://duli.nttrip.cn/') !== false){
                        $vv['imgurl'] = ASSETSS.explode('https://duli.nttrip.cn/', $vv['imgurl'])[1];
                    }
                    if($vv['thumb'] && strpos($vv['thumb'],'/diypage/resource/images/diypage/default/2.jpg') !== false){
                        $vv['thumb'] = ASSETSS."resource/images/diypage/default/2.jpg";
                    }
                }
            }
        }
        $page1['items'] = serialize($item1);
        $page1['page'] = 'a:7:{s:10:"background";s:7:"#f1f1f1";s:13:"topbackground";s:7:"#ff3420";s:8:"topcolor";s:1:"2";s:9:"styledata";s:1:"0";s:5:"title";s:6:"商城";s:4:"name";s:6:"首页";s:10:"visitlevel";a:2:{s:6:"member";s:0:"";s:10:"commission";s:0:"";}}';
        $page1['tpl_name'] = "首页";

        $page2 = [];
        $page2['uniacid'] = $uniacid;
        $page2['index'] = 0;
        $item2 = 'a:4:{s:14:"M1543283129002";a:5:{s:4:"icon";s:19:"iconfont2 icon-zutu";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:6:{s:10:"paddingtop";s:1:"0";s:11:"paddingleft";s:1:"0";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"background";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1543283129002";a:2:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_shop/page/picture2.png";s:7:"linkurl";s:0:"";}}s:2:"id";s:7:"picture";}s:14:"M1543283143522";a:5:{s:4:"icon";s:22:"iconfont2 icon-chanpin";s:6:"params";a:31:{s:11:"goodsscroll";s:1:"0";s:9:"showtitle";s:1:"1";s:9:"showprice";s:1:"1";s:7:"showtag";s:1:"0";s:9:"goodsdata";s:1:"1";s:6:"cateid";s:0:"";s:8:"catename";s:0:"";s:7:"groupid";s:0:"";s:9:"groupname";s:0:"";s:9:"goodssort";s:1:"0";s:8:"goodsnum";s:1:"2";s:8:"showicon";s:1:"0";s:12:"iconposition";s:8:"left top";s:12:"productprice";s:1:"1";s:16:"showproductprice";s:1:"0";s:9:"showsales";s:1:"1";s:16:"productpricetext";s:6:"原价";s:9:"salestext";s:6:"销量";s:16:"productpriceline";s:1:"0";s:7:"saleout";s:1:"0";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:7:"imgh_is";s:1:"1";s:4:"imgh";s:3:"100";s:7:"con_key";s:1:"2";s:8:"con_type";s:1:"4";s:8:"sourceid";s:0:"";}s:5:"style";a:20:{s:10:"background";s:7:"#f3f3f3";s:9:"liststyle";s:5:"block";s:8:"buystyle";s:0:"";s:9:"goodsicon";s:7:"hotsale";s:9:"iconstyle";s:7:"echelon";s:10:"pricecolor";s:7:"#ff5555";s:17:"productpricecolor";s:7:"#999999";s:14:"iconpaddingtop";s:1:"0";s:15:"iconpaddingleft";s:1:"0";s:11:"buybtncolor";s:7:"#ff5555";s:8:"iconzoom";s:2:"50";s:10:"titlecolor";s:7:"#000000";s:13:"tagbackground";s:7:"#fe5455";s:10:"salescolor";s:7:"#999999";s:2:"mt";s:1:"7";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"paddingtop";s:1:"0";s:11:"paddingleft";s:1:"4";s:8:"showtype";s:1:"0";}s:4:"data";a:4:{s:14:"C1543283143523";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"title";s:21:"这里是产品标题";s:5:"sales";s:1:"5";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"1";s:3:"des";s:21:"这里是产品描述";}s:14:"C1543283143524";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"title";s:21:"这里是产品标题";s:5:"sales";s:1:"5";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"1";s:4:"desc";s:21:"这里是产品描述";}s:14:"C1543283143525";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"sales";s:1:"5";s:5:"title";s:21:"这里是产品标题";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"0";s:4:"desc";s:21:"这里是产品描述";}s:14:"C1543283143526";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"sales";s:1:"5";s:5:"title";s:21:"这里是产品标题";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"0";s:4:"desc";s:21:"这里是产品描述";}}s:2:"id";s:5:"goods";}s:14:"M1544152252605";a:5:{s:4:"icon";s:22:"iconfont2 icon-chanpin";s:6:"params";a:31:{s:11:"goodsscroll";s:1:"0";s:9:"showtitle";s:1:"1";s:9:"showprice";s:1:"1";s:7:"showtag";s:1:"0";s:9:"goodsdata";s:1:"1";s:6:"cateid";s:0:"";s:8:"catename";s:0:"";s:7:"groupid";s:0:"";s:9:"groupname";s:0:"";s:9:"goodssort";s:1:"0";s:8:"goodsnum";s:1:"2";s:8:"showicon";s:1:"0";s:12:"iconposition";s:8:"left top";s:12:"productprice";s:1:"1";s:16:"showproductprice";s:1:"0";s:9:"showsales";s:1:"1";s:16:"productpricetext";s:6:"原价";s:9:"salestext";s:6:"销量";s:16:"productpriceline";s:1:"0";s:7:"saleout";s:1:"0";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:7:"imgh_is";s:1:"1";s:4:"imgh";s:3:"100";s:7:"con_key";s:1:"1";s:8:"con_type";s:1:"1";s:8:"sourceid";s:0:"";}s:5:"style";a:20:{s:10:"background";s:7:"#f3f3f3";s:9:"liststyle";s:5:"block";s:8:"buystyle";s:0:"";s:9:"goodsicon";s:7:"hotsale";s:9:"iconstyle";s:7:"echelon";s:10:"pricecolor";s:7:"#ff5555";s:17:"productpricecolor";s:7:"#999999";s:14:"iconpaddingtop";s:1:"0";s:15:"iconpaddingleft";s:1:"0";s:11:"buybtncolor";s:7:"#ff5555";s:8:"iconzoom";s:2:"50";s:10:"titlecolor";s:7:"#000000";s:13:"tagbackground";s:7:"#fe5455";s:10:"salescolor";s:7:"#999999";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"paddingtop";s:1:"0";s:11:"paddingleft";s:1:"4";s:8:"showtype";s:1:"0";}s:4:"data";a:4:{s:14:"C1544152252605";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"title";s:21:"这里是产品标题";s:5:"sales";s:1:"5";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"1";s:3:"des";s:21:"这里是产品描述";}s:14:"C1544152252606";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"title";s:21:"这里是产品标题";s:5:"sales";s:1:"5";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"1";s:4:"desc";s:21:"这里是产品描述";}s:14:"C1544152252607";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"sales";s:1:"5";s:5:"title";s:21:"这里是产品标题";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"0";s:4:"desc";s:21:"这里是产品描述";}s:14:"C1544152252608";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"sales";s:1:"5";s:5:"title";s:21:"这里是产品标题";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"0";s:4:"desc";s:21:"这里是产品描述";}}s:2:"id";s:5:"goods";}s:14:"M1544152189629";a:7:{s:4:"icon";s:21:"iconfont2 icon-caidan";s:6:"isfoot";s:1:"1";s:3:"max";s:1:"1";s:6:"params";a:8:{s:8:"navstyle";s:1:"0";s:8:"textshow";s:1:"1";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:20:{s:11:"pagebgcolor";s:7:"#f9f9f9";s:7:"bgcolor";s:7:"#ffffff";s:9:"bgcoloron";s:7:"#ffffff";s:9:"iconcolor";s:7:"#000000";s:11:"iconcoloron";s:7:"#ff3420";s:9:"textcolor";s:7:"#666666";s:11:"textcoloron";s:7:"#ff3420";s:11:"bordercolor";s:7:"#cccccc";s:13:"bordercoloron";s:7:"#ffffff";s:14:"childtextcolor";s:7:"#666666";s:12:"childbgcolor";s:7:"#f4f4f4";s:16:"childbordercolor";s:7:"#eeeeee";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:11:"paddingleft";s:1:"0";s:10:"paddingtop";s:1:"0";s:8:"iconfont";s:2:"20";s:8:"textfont";s:2:"10";s:3:"bdr";s:1:"0";s:8:"bdrcolor";s:7:"#cccccc";}s:4:"data";a:5:{s:14:"C1544152189629";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot1.png";s:7:"linkurl";s:23:"/sudu8_page/index/index";s:9:"iconclass";s:14:"icon-x-shouye1";s:4:"text";s:6:"首页";s:8:"linktype";s:4:"page";}s:14:"C1544152189630";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot2.png";s:7:"linkurl";s:36:"/sudu8_page_plugin_forum/index/index";s:9:"iconclass";s:11:"icon-c-xin1";s:4:"text";s:12:"好物种草";s:8:"linktype";s:4:"page";}s:14:"C1544152189631";a:4:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot3.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:14:"icon-x-caidan4";s:4:"text";s:12:"全部商品";}s:14:"C1544152189632";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot4.png";s:7:"linkurl";s:19:"/sudu8_page/gwc/gwc";s:9:"iconclass";s:11:"icon-x-gwc1";s:4:"text";s:9:"购物车";s:8:"linktype";s:4:"page";}s:14:"M1544152242392";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot5.png";s:7:"linkurl";s:33:"/sudu8_page/usercenter/usercenter";s:9:"iconclass";s:13:"icon-x-geren1";s:4:"text";s:6:"我的";s:8:"linktype";s:4:"page";}}s:2:"id";s:8:"footmenu";}}';
        $item2 = unserialize($item2);
        foreach($item2 as &$vi){
            if($vi['data']){
                foreach($vi['data'] as &$vvi){
                    if($vvi['imgurl'] && strpos($vvi['imgurl'],'https://duli.nttrip.cn/') !== false){
                        $vvi['imgurl'] = ASSETSS.explode('https://duli.nttrip.cn/', $vvi['imgurl'])[1];
                    }
                    if($vvi['thumb'] && strpos($vvi['thumb'],'/diypage/resource/images/diypage/default/2.jpg') !== false){
                        $vvi['thumb'] = ASSETSS."resource/images/diypage/default/2.jpg";
                    }
                }
            }
        }
        $page2['items'] = serialize($item2);
        $page2['page'] = 'a:7:{s:10:"background";s:7:"#f1f1f1";s:13:"topbackground";s:7:"#ff3420";s:8:"topcolor";s:1:"2";s:9:"styledata";s:1:"0";s:5:"title";s:12:"人气爆款";s:4:"name";s:12:"人气爆款";s:10:"visitlevel";a:2:{s:6:"member";s:0:"";s:10:"commission";s:0:"";}}';
        $page2['tpl_name'] = "人气爆款";

        $page3 = [];
        $page3['uniacid'] = $uniacid;
        $page3['index'] = 0;
        $item3 = 'a:3:{s:14:"M1543283208353";a:5:{s:4:"icon";s:19:"iconfont2 icon-zutu";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:6:{s:10:"paddingtop";s:1:"0";s:11:"paddingleft";s:1:"0";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"background";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1543283208353";a:2:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_shop/page/picture1.png";s:7:"linkurl";s:0:"";}}s:2:"id";s:7:"picture";}s:14:"M1543992326902";a:5:{s:4:"icon";s:34:"iconfont2 icon-pintuanweixuanzhong";s:6:"params";a:11:{s:8:"navstyle";s:1:"1";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:8:"goodsnum";s:1:"2";s:7:"con_key";s:1:"1";s:8:"con_type";s:1:"1";s:8:"sourceid";s:0:"";}s:5:"style";a:8:{s:10:"background";s:7:"#ffffff";s:3:"pdw";s:2:"10";s:3:"pdh";s:2:"10";s:2:"mb";s:2:"10";s:2:"mt";s:1:"1";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:4:"pich";s:1:"1";}s:4:"data";a:3:{s:14:"C1543992326902";a:11:{s:6:"imgurl";s:47:"/diypage/resource/images/diypage/default/11.jpg";s:5:"title";s:18:"拼团商品标题";s:11:"description";s:18:"拼团商品简介";s:5:"count";s:3:"927";s:5:"price";s:2:"21";s:6:"person";s:1:"2";s:2:"tz";s:2:"92";s:3:"tgr";s:3:"427";s:3:"tgj";s:5:"17.20";s:7:"linkurl";s:0:"";s:8:"linktype";s:0:"";}s:14:"C1543992326903";a:11:{s:6:"imgurl";s:47:"/diypage/resource/images/diypage/default/11.jpg";s:5:"title";s:18:"拼团商品标题";s:11:"description";s:18:"拼团商品简介";s:5:"count";s:3:"927";s:5:"price";s:2:"21";s:6:"person";s:1:"2";s:2:"tz";s:2:"92";s:3:"tgr";s:3:"427";s:3:"tgj";s:4:"17.2";s:7:"linkurl";s:0:"";s:8:"linktype";s:0:"";}s:14:"C1543992326904";a:11:{s:6:"imgurl";s:47:"/diypage/resource/images/diypage/default/11.jpg";s:5:"title";s:18:"拼团商品标题";s:11:"description";s:18:"拼团商品简介";s:5:"count";s:3:"927";s:5:"price";s:2:"21";s:6:"person";s:1:"2";s:2:"tz";s:2:"92";s:3:"tgr";s:3:"427";s:3:"tgj";s:4:"17.2";s:7:"linkurl";s:0:"";s:8:"linktype";s:0:"";}}s:2:"id";s:2:"pt";}s:14:"M1544152348341";a:7:{s:4:"icon";s:21:"iconfont2 icon-caidan";s:6:"isfoot";s:1:"1";s:3:"max";s:1:"1";s:6:"params";a:8:{s:8:"navstyle";s:1:"0";s:8:"textshow";s:1:"1";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:20:{s:11:"pagebgcolor";s:7:"#f9f9f9";s:7:"bgcolor";s:7:"#ffffff";s:9:"bgcoloron";s:7:"#ffffff";s:9:"iconcolor";s:7:"#000000";s:11:"iconcoloron";s:7:"#ff3420";s:9:"textcolor";s:7:"#666666";s:11:"textcoloron";s:7:"#ff3420";s:11:"bordercolor";s:7:"#cccccc";s:13:"bordercoloron";s:7:"#ffffff";s:14:"childtextcolor";s:7:"#666666";s:12:"childbgcolor";s:7:"#f4f4f4";s:16:"childbordercolor";s:7:"#eeeeee";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:11:"paddingleft";s:1:"0";s:10:"paddingtop";s:1:"0";s:8:"iconfont";s:2:"20";s:8:"textfont";s:2:"10";s:3:"bdr";s:1:"0";s:8:"bdrcolor";s:7:"#cccccc";}s:4:"data";a:5:{s:14:"C1544152348341";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot1.png";s:7:"linkurl";s:23:"/sudu8_page/index/index";s:9:"iconclass";s:14:"icon-x-shouye1";s:4:"text";s:6:"首页";s:8:"linktype";s:4:"page";}s:14:"C1544152348342";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot2.png";s:7:"linkurl";s:36:"/sudu8_page_plugin_forum/index/index";s:9:"iconclass";s:11:"icon-c-xin1";s:4:"text";s:12:"好物种草";s:8:"linktype";s:4:"page";}s:14:"C1544152348343";a:4:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot3.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:14:"icon-x-caidan4";s:4:"text";s:12:"全部商品";}s:14:"C1544152348344";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot4.png";s:7:"linkurl";s:19:"/sudu8_page/gwc/gwc";s:9:"iconclass";s:11:"icon-x-gwc1";s:4:"text";s:9:"购物车";s:8:"linktype";s:4:"page";}s:14:"M1544152378070";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot5.png";s:7:"linkurl";s:33:"/sudu8_page/usercenter/usercenter";s:9:"iconclass";s:13:"icon-x-geren1";s:4:"text";s:6:"我的";s:8:"linktype";s:4:"page";}}s:2:"id";s:8:"footmenu";}}';
        $item3 = unserialize($item3);
        foreach($item3 as &$vi){
            if($vi['data']){
                foreach($vi['data'] as &$vvi){
                    if($vvi['imgurl'] && strpos($vvi['imgurl'],'https://duli.nttrip.cn/') !== false){
                        $vvi['imgurl'] = ASSETSS.explode('https://duli.nttrip.cn/', $vvi['imgurl'])[1];
                    }
                    if($vvi['imgurl'] && strpos($vvi['imgurl'],'/diypage/resource/images/diypage/default/11.jpg') !== false){
                        $vvi['imgurl'] = ASSETSS."resource/images/diypage/default/11.jpg";
                    }
                }
            }
        }
        $page3['items'] = serialize($item3);
        $page3['page'] = 'a:7:{s:10:"background";s:7:"#f1f1f1";s:13:"topbackground";s:7:"#ff3420";s:8:"topcolor";s:1:"2";s:9:"styledata";s:1:"0";s:5:"title";s:9:"拼团购";s:4:"name";s:9:"拼团购";s:10:"visitlevel";a:2:{s:6:"member";s:0:"";s:10:"commission";s:0:"";}}';
        $page3['tpl_name'] = "拼团购";

        $page4 = [];
        $page4['uniacid'] = $uniacid;
        $page4['index'] = 0;
        $item4 = 'a:2:{s:14:"M1543283679197";a:6:{s:4:"icon";s:19:"iconfont2 icon-zutu";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:6:{s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"15";s:2:"mt";s:2:"10";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"background";s:7:"#f1f1f1";}s:4:"data";a:4:{s:14:"C1543283679197";a:3:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_shop/page/picture5.png";s:7:"linkurl";s:0:"";s:8:"linktype";s:4:"page";}s:14:"M1543283680688";a:3:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_shop/page/picture6.png";s:7:"linkurl";s:0:"";s:8:"linktype";s:4:"page";}s:14:"M1543283681989";a:3:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_shop/page/picture7.png";s:7:"linkurl";s:0:"";s:8:"linktype";s:4:"page";}s:14:"M1543283716630";a:3:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_shop/page/picture8.png";s:7:"linkurl";s:0:"";s:8:"linktype";s:4:"page";}}s:2:"id";s:7:"picture";s:5:"index";s:3:"NaN";}s:14:"M1544152497662";a:7:{s:4:"icon";s:21:"iconfont2 icon-caidan";s:6:"isfoot";s:1:"1";s:3:"max";s:1:"1";s:6:"params";a:8:{s:8:"navstyle";s:1:"0";s:8:"textshow";s:1:"1";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:20:{s:11:"pagebgcolor";s:7:"#f9f9f9";s:7:"bgcolor";s:7:"#ffffff";s:9:"bgcoloron";s:7:"#ffffff";s:9:"iconcolor";s:7:"#000000";s:11:"iconcoloron";s:7:"#ff3420";s:9:"textcolor";s:7:"#666666";s:11:"textcoloron";s:7:"#ff3420";s:11:"bordercolor";s:7:"#cccccc";s:13:"bordercoloron";s:7:"#ffffff";s:14:"childtextcolor";s:7:"#666666";s:12:"childbgcolor";s:7:"#f4f4f4";s:16:"childbordercolor";s:7:"#eeeeee";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:11:"paddingleft";s:1:"0";s:10:"paddingtop";s:1:"0";s:8:"iconfont";s:2:"20";s:8:"textfont";s:2:"10";s:3:"bdr";s:1:"0";s:8:"bdrcolor";s:7:"#cccccc";}s:4:"data";a:5:{s:14:"C1544152497662";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot1.png";s:7:"linkurl";s:23:"/sudu8_page/index/index";s:9:"iconclass";s:14:"icon-x-shouye1";s:4:"text";s:6:"首页";s:8:"linktype";s:4:"page";}s:14:"C1544152497663";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot2.png";s:7:"linkurl";s:36:"/sudu8_page_plugin_forum/index/index";s:9:"iconclass";s:11:"icon-c-xin1";s:4:"text";s:12:"好物种草";s:8:"linktype";s:4:"page";}s:14:"C1544152497664";a:4:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot3.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:14:"icon-x-caidan4";s:4:"text";s:12:"全部商品";}s:14:"C1544152497665";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot4.png";s:7:"linkurl";s:19:"/sudu8_page/gwc/gwc";s:9:"iconclass";s:11:"icon-x-gwc1";s:4:"text";s:9:"购物车";s:8:"linktype";s:4:"page";}s:14:"M1544152507358";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot5.png";s:7:"linkurl";s:33:"/sudu8_page/usercenter/usercenter";s:9:"iconclass";s:13:"icon-x-geren1";s:4:"text";s:6:"我的";s:8:"linktype";s:4:"page";}}s:2:"id";s:8:"footmenu";}}';
        $item4 = unserialize($item4);
        foreach($item4 as &$vi){
            if($vi['data']){
                foreach($vi['data'] as &$vvi){
                    if($vvi['imgurl'] && strpos($vvi['imgurl'],'https://duli.nttrip.cn/') !== false){
                        $vvi['imgurl'] = ASSETSS.explode('https://duli.nttrip.cn/', $vvi['imgurl'])[1];
                    }
                }
            }
        }
        $page4['items'] = serialize($item4);
        $page4['page'] = 'a:7:{s:10:"background";s:7:"#f1f1f1";s:13:"topbackground";s:7:"#ff3420";s:8:"topcolor";s:1:"2";s:9:"styledata";s:1:"0";s:5:"title";s:12:"优惠活动";s:4:"name";s:12:"优惠活动";s:10:"visitlevel";a:2:{s:6:"member";s:0:"";s:10:"commission";s:0:"";}}';
        $page4['tpl_name'] = "优惠活动";

        $page5 = [];
        $page5['uniacid'] = $uniacid;
        $page5['index'] = 0;
        $item5 = 'a:4:{s:14:"M1544150247611";a:5:{s:4:"icon";s:19:"iconfont2 icon-zutu";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:6:{s:10:"paddingtop";s:1:"0";s:11:"paddingleft";s:1:"0";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"background";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1544150247611";a:2:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_shop/page/picture4.png";s:7:"linkurl";s:0:"";}}s:2:"id";s:7:"picture";}s:14:"M1544150260723";a:5:{s:4:"icon";s:22:"iconfont2 icon-chanpin";s:6:"params";a:31:{s:11:"goodsscroll";s:1:"0";s:9:"showtitle";s:1:"1";s:9:"showprice";s:1:"1";s:7:"showtag";s:1:"0";s:9:"goodsdata";s:1:"1";s:6:"cateid";s:0:"";s:8:"catename";s:0:"";s:7:"groupid";s:0:"";s:9:"groupname";s:0:"";s:9:"goodssort";s:1:"0";s:8:"goodsnum";s:1:"6";s:8:"showicon";s:1:"0";s:12:"iconposition";s:8:"left top";s:12:"productprice";s:1:"1";s:16:"showproductprice";s:1:"0";s:9:"showsales";s:1:"1";s:16:"productpricetext";s:6:"原价";s:9:"salestext";s:6:"销量";s:16:"productpriceline";s:1:"0";s:7:"saleout";s:1:"0";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:7:"imgh_is";s:1:"1";s:4:"imgh";s:3:"100";s:7:"con_key";s:1:"1";s:8:"con_type";s:1:"1";s:8:"sourceid";s:0:"";}s:5:"style";a:20:{s:10:"background";s:7:"#f3f3f3";s:9:"liststyle";s:5:"block";s:8:"buystyle";s:0:"";s:9:"goodsicon";s:7:"bigsale";s:9:"iconstyle";s:8:"triangle";s:10:"pricecolor";s:7:"#ff5555";s:17:"productpricecolor";s:7:"#999999";s:14:"iconpaddingtop";s:1:"0";s:15:"iconpaddingleft";s:1:"0";s:11:"buybtncolor";s:7:"#ff5555";s:8:"iconzoom";s:2:"50";s:10:"titlecolor";s:7:"#000000";s:13:"tagbackground";s:7:"#fe5455";s:10:"salescolor";s:7:"#999999";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"paddingtop";s:1:"4";s:11:"paddingleft";s:1:"4";s:8:"showtype";s:1:"0";}s:4:"data";a:4:{s:14:"C1544150260723";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"title";s:21:"这里是产品标题";s:5:"sales";s:1:"5";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"1";s:3:"des";s:21:"这里是产品描述";}s:14:"C1544150260724";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"title";s:21:"这里是产品标题";s:5:"sales";s:1:"5";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"1";s:4:"desc";s:21:"这里是产品描述";}s:14:"C1544150260725";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"sales";s:1:"5";s:5:"title";s:21:"这里是产品标题";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"0";s:4:"desc";s:21:"这里是产品描述";}s:14:"C1544150260726";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"sales";s:1:"5";s:5:"title";s:21:"这里是产品标题";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"0";s:4:"desc";s:21:"这里是产品描述";}}s:2:"id";s:5:"goods";}s:14:"M1544152626046";a:5:{s:4:"icon";s:22:"iconfont2 icon-chanpin";s:6:"params";a:31:{s:11:"goodsscroll";s:1:"0";s:9:"showtitle";s:1:"1";s:9:"showprice";s:1:"1";s:7:"showtag";s:1:"0";s:9:"goodsdata";s:1:"1";s:6:"cateid";s:0:"";s:8:"catename";s:0:"";s:7:"groupid";s:0:"";s:9:"groupname";s:0:"";s:9:"goodssort";s:1:"0";s:8:"goodsnum";s:1:"6";s:8:"showicon";s:1:"0";s:12:"iconposition";s:8:"left top";s:12:"productprice";s:1:"1";s:16:"showproductprice";s:1:"0";s:9:"showsales";s:1:"1";s:16:"productpricetext";s:6:"原价";s:9:"salestext";s:6:"销量";s:16:"productpriceline";s:1:"0";s:7:"saleout";s:1:"0";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:7:"imgh_is";s:1:"1";s:4:"imgh";s:3:"100";s:7:"con_key";s:1:"1";s:8:"con_type";s:1:"1";s:8:"sourceid";s:0:"";}s:5:"style";a:20:{s:10:"background";s:7:"#f3f3f3";s:9:"liststyle";s:5:"block";s:8:"buystyle";s:0:"";s:9:"goodsicon";s:9:"recommand";s:9:"iconstyle";s:8:"triangle";s:10:"pricecolor";s:7:"#ff5555";s:17:"productpricecolor";s:7:"#999999";s:14:"iconpaddingtop";s:1:"0";s:15:"iconpaddingleft";s:1:"0";s:11:"buybtncolor";s:7:"#ff5555";s:8:"iconzoom";s:2:"50";s:10:"titlecolor";s:7:"#000000";s:13:"tagbackground";s:7:"#fe5455";s:10:"salescolor";s:7:"#999999";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"paddingtop";s:1:"0";s:11:"paddingleft";s:1:"4";s:8:"showtype";s:1:"0";}s:4:"data";a:4:{s:14:"C1544152626046";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"title";s:21:"这里是产品标题";s:5:"sales";s:1:"5";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"1";s:3:"des";s:21:"这里是产品描述";}s:14:"C1544152626047";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"title";s:21:"这里是产品标题";s:5:"sales";s:1:"5";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"1";s:4:"desc";s:21:"这里是产品描述";}s:14:"C1544152626048";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"sales";s:1:"5";s:5:"title";s:21:"这里是产品标题";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"0";s:4:"desc";s:21:"这里是产品描述";}s:14:"C1544152626049";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"sales";s:1:"5";s:5:"title";s:21:"这里是产品标题";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"0";s:4:"desc";s:21:"这里是产品描述";}}s:2:"id";s:5:"goods";}s:14:"M1544152644912";a:7:{s:4:"icon";s:21:"iconfont2 icon-caidan";s:6:"isfoot";s:1:"1";s:3:"max";s:1:"1";s:6:"params";a:8:{s:8:"navstyle";s:1:"0";s:8:"textshow";s:1:"1";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:20:{s:11:"pagebgcolor";s:7:"#f9f9f9";s:7:"bgcolor";s:7:"#ffffff";s:9:"bgcoloron";s:7:"#ffffff";s:9:"iconcolor";s:7:"#000000";s:11:"iconcoloron";s:7:"#ff3420";s:9:"textcolor";s:7:"#666666";s:11:"textcoloron";s:7:"#ff3420";s:11:"bordercolor";s:7:"#cccccc";s:13:"bordercoloron";s:7:"#ffffff";s:14:"childtextcolor";s:7:"#666666";s:12:"childbgcolor";s:7:"#f4f4f4";s:16:"childbordercolor";s:7:"#eeeeee";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:11:"paddingleft";s:1:"0";s:10:"paddingtop";s:1:"0";s:8:"iconfont";s:2:"20";s:8:"textfont";s:2:"10";s:3:"bdr";s:1:"0";s:8:"bdrcolor";s:7:"#cccccc";}s:4:"data";a:5:{s:14:"C1544152644912";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot1.png";s:7:"linkurl";s:23:"/sudu8_page/index/index";s:9:"iconclass";s:14:"icon-x-shouye1";s:4:"text";s:6:"首页";s:8:"linktype";s:4:"page";}s:14:"C1544152644913";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot2.png";s:7:"linkurl";s:36:"/sudu8_page_plugin_forum/index/index";s:9:"iconclass";s:11:"icon-c-xin1";s:4:"text";s:12:"好物种草";s:8:"linktype";s:4:"page";}s:14:"C1544152644914";a:4:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot3.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:14:"icon-x-caidan4";s:4:"text";s:12:"全部商品";}s:14:"C1544152644915";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot4.png";s:7:"linkurl";s:19:"/sudu8_page/gwc/gwc";s:9:"iconclass";s:11:"icon-x-gwc1";s:4:"text";s:9:"购物车";s:8:"linktype";s:4:"page";}s:14:"M1544152681671";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot5.png";s:7:"linkurl";s:33:"/sudu8_page/usercenter/usercenter";s:9:"iconclass";s:13:"icon-x-geren1";s:4:"text";s:12:"个人中心";s:8:"linktype";s:4:"page";}}s:2:"id";s:8:"footmenu";}}';
        $item5 = unserialize($item5);
        foreach($item5 as &$vi){
            if($vi['data']){
                foreach($vi['data'] as &$vvi){
                    if($vvi['imgurl'] && strpos($vvi['imgurl'],'https://duli.nttrip.cn/') !== false){
                        $vvi['imgurl'] = ASSETSS.explode('https://duli.nttrip.cn/', $vvi['imgurl'])[1];
                    }
                    if($vvi['thumb'] && strpos($vvi['thumb'],'/diypage/resource/images/diypage/default/2.jpg') !== false){
                        $vvi['thumb'] = ASSETSS."resource/images/diypage/default/2.jpg";
                    }
                }
            }
        }
        $page5['items'] = serialize($item5);
        $page5['page'] = 'a:7:{s:10:"background";s:7:"#f1f1f1";s:13:"topbackground";s:7:"#ff3420";s:8:"topcolor";s:1:"2";s:9:"styledata";s:1:"0";s:5:"title";s:12:"新品预约";s:4:"name";s:12:"新品预约";s:10:"visitlevel";a:2:{s:6:"member";s:0:"";s:10:"commission";s:0:"";}}';
        $page5['tpl_name'] = "新品预约";

        $page6 = [];
        $page6['uniacid'] = $uniacid;
        $page6['index'] = 0;
        $item6 = 'a:3:{s:14:"M1544150311503";a:5:{s:4:"icon";s:19:"iconfont2 icon-zutu";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:6:{s:10:"paddingtop";s:1:"0";s:11:"paddingleft";s:1:"0";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"background";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1544150311503";a:2:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_shop/page/picture3.png";s:7:"linkurl";s:0:"";}}s:2:"id";s:7:"picture";}s:14:"M1544150324081";a:6:{s:3:"max";s:1:"1";s:4:"icon";s:23:"iconfont2 icon-shandian";s:6:"params";a:12:{s:8:"navstyle";s:1:"2";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:9:"goodsdata";s:1:"1";s:8:"goodsnum";s:1:"4";s:7:"con_key";s:1:"1";s:8:"con_type";s:1:"1";s:8:"sourceid";s:0:"";}s:5:"style";a:9:{s:10:"background";s:7:"#ffffff";s:3:"pdw";s:1:"6";s:3:"pdh";s:2:"10";s:2:"mb";s:2:"10";s:2:"mt";s:2:"10";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:4:"pich";s:1:"1";s:8:"showtype";s:1:"0";}s:4:"data";a:3:{s:14:"C1544150324081";a:14:{s:6:"imgurl";s:47:"/diypage/resource/images/diypage/default/11.jpg";s:5:"title";s:18:"秒杀商品标题";s:11:"description";s:18:"秒杀商品简介";s:5:"count";s:3:"927";s:5:"price";s:2:"21";s:4:"hour";s:2:"10";s:3:"min";s:2:"11";s:6:"second";s:2:"12";s:6:"person";s:1:"2";s:2:"tz";s:2:"92";s:3:"tgr";s:3:"427";s:3:"tgj";s:4:"17.2";s:7:"linkurl";s:0:"";s:8:"linktype";s:0:"";}s:14:"C1544150324082";a:14:{s:6:"imgurl";s:47:"/diypage/resource/images/diypage/default/11.jpg";s:5:"title";s:18:"秒杀商品标题";s:11:"description";s:18:"秒杀商品简介";s:5:"count";s:3:"927";s:5:"price";s:2:"21";s:4:"hour";s:2:"10";s:3:"min";s:2:"11";s:6:"second";s:2:"12";s:6:"person";s:1:"2";s:2:"tz";s:2:"92";s:3:"tgr";s:3:"427";s:3:"tgj";s:4:"17.2";s:7:"linkurl";s:0:"";s:8:"linktype";s:0:"";}s:14:"C1544150324083";a:14:{s:6:"imgurl";s:47:"/diypage/resource/images/diypage/default/11.jpg";s:5:"title";s:18:"秒杀商品标题";s:11:"description";s:18:"秒杀商品简介";s:5:"count";s:3:"927";s:5:"price";s:2:"21";s:4:"hour";s:2:"10";s:3:"min";s:2:"11";s:6:"second";s:2:"12";s:6:"person";s:1:"2";s:2:"tz";s:2:"92";s:3:"tgr";s:3:"427";s:3:"tgj";s:4:"17.2";s:7:"linkurl";s:0:"";s:8:"linktype";s:0:"";}}s:2:"id";s:4:"msmk";}s:14:"M1544152814309";a:7:{s:4:"icon";s:21:"iconfont2 icon-caidan";s:6:"isfoot";s:1:"1";s:3:"max";s:1:"1";s:6:"params";a:8:{s:8:"navstyle";s:1:"0";s:8:"textshow";s:1:"1";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:20:{s:11:"pagebgcolor";s:7:"#f9f9f9";s:7:"bgcolor";s:7:"#ffffff";s:9:"bgcoloron";s:7:"#ffffff";s:9:"iconcolor";s:7:"#000000";s:11:"iconcoloron";s:7:"#ff3420";s:9:"textcolor";s:7:"#666666";s:11:"textcoloron";s:7:"#ff3420";s:11:"bordercolor";s:7:"#cccccc";s:13:"bordercoloron";s:7:"#ffffff";s:14:"childtextcolor";s:7:"#666666";s:12:"childbgcolor";s:7:"#f4f4f4";s:16:"childbordercolor";s:7:"#eeeeee";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:11:"paddingleft";s:1:"0";s:10:"paddingtop";s:1:"0";s:8:"iconfont";s:2:"20";s:8:"textfont";s:2:"10";s:3:"bdr";s:1:"0";s:8:"bdrcolor";s:7:"#cccccc";}s:4:"data";a:5:{s:14:"C1544152814309";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot1.png";s:7:"linkurl";s:23:"/sudu8_page/index/index";s:9:"iconclass";s:14:"icon-x-shouye1";s:4:"text";s:6:"首页";s:8:"linktype";s:4:"page";}s:14:"C1544152814310";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot2.png";s:7:"linkurl";s:36:"/sudu8_page_plugin_forum/index/index";s:9:"iconclass";s:11:"icon-c-xin1";s:4:"text";s:12:"好物种草";s:8:"linktype";s:4:"page";}s:14:"C1544152814311";a:4:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot3.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:14:"icon-x-caidan4";s:4:"text";s:12:"全部商品";}s:14:"C1544152814312";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot4.png";s:7:"linkurl";s:19:"/sudu8_page/gwc/gwc";s:9:"iconclass";s:11:"icon-x-gwc1";s:4:"text";s:9:"购物车";s:8:"linktype";s:4:"page";}s:14:"M1544152825575";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_shop/index/foot5.png";s:7:"linkurl";s:33:"/sudu8_page/usercenter/usercenter";s:9:"iconclass";s:13:"icon-x-geren1";s:4:"text";s:6:"我的";s:8:"linktype";s:4:"page";}}s:2:"id";s:8:"footmenu";}}';
        $item6 = unserialize($item6);
        foreach($item6 as &$vi){
            if($vi['data']){
                foreach($vi['data'] as &$vvi){
                    if($vvi['imgurl'] && strpos($vvi['imgurl'],'https://duli.nttrip.cn/') !== false){
                        $vvi['imgurl'] = ASSETSS.explode('https://duli.nttrip.cn/', $vvi['imgurl'])[1];
                    }
                    if($vvi['imgurl'] && strpos($vvi['imgurl'],'/diypage/resource/images/diypage/default/11.jpg') !== false){
                        $vvi['imgurl'] = ASSETSS."resource/images/diypage/default/11.jpg";
                    }
                }
            }
        }
        $page6['items'] = serialize($item6);
        $page6['page'] = 'a:7:{s:10:"background";s:7:"#f1f1f1";s:13:"topbackground";s:7:"#ff3420";s:8:"topcolor";s:1:"2";s:9:"styledata";s:1:"0";s:5:"title";s:12:"特惠秒杀";s:4:"name";s:12:"特惠秒杀";s:10:"visitlevel";a:2:{s:6:"member";s:0:"";s:10:"commission";s:0:"";}}';
        $page6['tpl_name'] = "特惠秒杀";
        pdo_insert("sudu8_page_diypage", $page1);
        $page1_id = pdo_insertid();
        pdo_insert("sudu8_page_diypage", $page2);
        $page2_id = pdo_insertid();
        pdo_insert("sudu8_page_diypage", $page3);
        $page3_id = pdo_insertid();
        pdo_insert("sudu8_page_diypage", $page4);
        $page4_id = pdo_insertid();
        pdo_insert("sudu8_page_diypage", $page5);
        $page5_id = pdo_insertid();
        pdo_insert("sudu8_page_diypage", $page6);
        $page6_id = pdo_insertid();
        $pageids = $page1_id.",".$page2_id.",".$page3_id.",".$page4_id.",".$page5_id.",".$page6_id;

        $page1_set = [
        	'pid' => $page1_id,
        	'uniacid' => $uniacid,
        	'kp' => ASSETSS."resource/images/diypage/default/default_start.jpg",
        	'kp_is' => 2,
        	'kp_m' => 2,
        	'tc' => ASSETSS."resource/images/diypage/default/tcgg.jpg",
        	'tc_is' => 2,
        	'foot_is' => 2
        ];
        $page2_set = [
        	'pid' => $page2_id,
        	'uniacid' => $uniacid,
        	'kp' => ASSETSS."resource/images/diypage/default/default_start.jpg",
        	'kp_is' => 2,
        	'kp_m' => 2,
        	'tc' => ASSETSS."resource/images/diypage/default/tcgg.jpg",
        	'tc_is' => 2,
        	'foot_is' => 2
        ];
        $page3_set = [
        	'pid' => $page3_id,
        	'uniacid' => $uniacid,
        	'kp' => ASSETSS."resource/images/diypage/default/default_start.jpg",
        	'kp_is' => 2,
        	'kp_m' => 2,
        	'tc' => ASSETSS."resource/images/diypage/default/tcgg.jpg",
        	'tc_is' => 2,
        	'foot_is' => 2
        ];
        $page4_set = [
        	'pid' => $page4_id,
        	'uniacid' => $uniacid,
        	'kp' => ASSETSS."resource/images/diypage/default/default_start.jpg",
        	'kp_is' => 2,
        	'kp_m' => 2,
        	'tc' => ASSETSS."resource/images/diypage/default/tcgg.jpg",
        	'tc_is' => 2,
        	'foot_is' => 2
        ];
        $page5_set = [
        	'pid' => $page5_id,
        	'uniacid' => $uniacid,
        	'kp' => ASSETSS."resource/images/diypage/default/default_start.jpg",
        	'kp_is' => 2,
        	'kp_m' => 2,
        	'tc' => ASSETSS."resource/images/diypage/default/tcgg.jpg",
        	'tc_is' => 2,
        	'foot_is' => 2
        ];
        $page6_set = [
        	'pid' => $page6_id,
        	'uniacid' => $uniacid,
        	'kp' => ASSETSS."resource/images/diypage/default/default_start.jpg",
        	'kp_is' => 2,
        	'kp_m' => 2,
        	'tc' => ASSETSS."resource/images/diypage/default/tcgg.jpg",
        	'tc_is' => 2,
        	'foot_is' => 2
        ];

        pdo_insert("sudu8_page_diypageset", $page1_set);
        pdo_insert("sudu8_page_diypageset", $page2_set);
        pdo_insert("sudu8_page_diypageset", $page3_set);
        pdo_insert("sudu8_page_diypageset", $page4_set);
        pdo_insert("sudu8_page_diypageset", $page5_set);
        pdo_insert("sudu8_page_diypageset", $page6_set);

        $data = [
            'uniacid' => $uniacid,
            'pageid' => $pageids,
            'template_name' => '综合商城模板',
            'thumb' => ASSETSS."template_img/template_shop/cover.png",
            'status' => '1',
            'create_time' => time()
        ];
        pdo_insert("sudu8_page_diypagetpl", $data);
    	$tplid = pdo_insertid();
        if($tplid){
            echo $tplid;
        }
    }elseif($id == 'm_education'){
    	$page1 = [];
        $page1['uniacid'] = $uniacid;
        $page1['index'] = 1;
        $item1 = 'a:11:{s:14:"M1544003458527";a:4:{s:4:"icon";s:22:"iconfont2 icon-sousuo1";s:6:"params";a:7:{s:5:"value";s:0:"";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:12:{s:9:"textalign";s:4:"left";s:10:"background";s:7:"#f26e47";s:2:"bg";s:7:"#f57953";s:12:"borderradius";s:2:"20";s:6:"boxpdh";s:2:"10";s:6:"boxpdz";s:2:"15";s:7:"padding";s:1:"5";s:8:"fontsize";s:2:"13";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:5:"color";s:7:"#ffffff";}s:2:"id";s:3:"ssk";}s:14:"M1544003461117";a:5:{s:4:"icon";s:28:"iconfont2 icon-tuoyuankaobei";s:6:"params";a:10:{s:5:"totle";s:1:"2";s:8:"navstyle";s:1:"0";s:9:"styledata";s:1:"1";s:6:"repeat";s:9:"no-repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"1";s:13:"backgroundimg";s:68:"https://duli.nttrip.cn/template_img/template_edu/index/banner_bg.jpg";s:9:"navstyle2";s:1:"0";s:4:"imgh";s:3:"135";}s:5:"style";a:18:{s:8:"dotstyle";s:5:"round";s:8:"dotalign";s:4:"left";s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"25";s:10:"background";s:7:"#ffffff";s:13:"backgroundall";s:7:"#ffffff";s:9:"leftright";s:1:"5";s:6:"bottom";s:1:"5";s:7:"opacity";s:3:"0.8";s:10:"text_color";s:4:"#fff";s:2:"bg";s:7:"#000000";s:9:"jsq_color";s:3:"red";s:3:"pdh";s:1:"0";s:3:"pdw";s:1:"0";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:5:"speed";s:1:"5";}s:4:"data";a:2:{s:14:"C1544003461118";a:5:{s:6:"imgurl";s:66:"https://duli.nttrip.cn/template_img/template_edu/index/banner1.png";s:7:"linkurl";s:0:"";s:6:"single";s:1:"1";s:4:"text";s:12:"文字描述";s:8:"linktype";s:4:"page";}s:14:"C1544003461119";a:5:{s:6:"imgurl";s:66:"https://duli.nttrip.cn/template_img/template_edu/index/banner1.png";s:7:"linkurl";s:0:"";s:6:"single";s:1:"2";s:4:"text";s:12:"文字描述";s:8:"linktype";s:4:"page";}}s:2:"id";s:6:"banner";}s:14:"M1544003712049";a:5:{s:4:"icon";s:22:"iconfont2 icon-anniuzu";s:6:"params";a:8:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:7:"picicon";s:1:"1";s:8:"textshow";s:1:"1";}s:5:"style";a:14:{s:8:"navstyle";s:0:"";s:10:"background";s:7:"#ffffff";s:6:"rownum";s:1:"4";s:8:"showtype";s:1:"0";s:7:"pagenum";s:1:"8";s:7:"showdot";s:1:"1";s:7:"padding";s:1:"0";s:11:"paddingleft";s:2:"10";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:6:"iconfz";s:2:"14";s:9:"iconcolor";s:7:"#434343";s:8:"imgwidth";s:2:"30";}s:4:"data";a:4:{s:14:"C1544003712049";a:6:{s:6:"imgurl";s:64:"https://duli.nttrip.cn/template_img/template_edu/index/menu1.png";s:7:"linkurl";s:0:"";s:4:"text";s:12:"视频课堂";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";s:8:"linktype";s:4:"page";}s:14:"C1544003712050";a:6:{s:6:"imgurl";s:64:"https://duli.nttrip.cn/template_img/template_edu/index/menu2.png";s:7:"linkurl";s:0:"";s:4:"text";s:9:"展示墙";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";s:8:"linktype";s:4:"page";}s:14:"C1544003712051";a:6:{s:6:"imgurl";s:64:"https://duli.nttrip.cn/template_img/template_edu/index/menu3.png";s:7:"linkurl";s:0:"";s:4:"text";s:9:"讨论区";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";s:8:"linktype";s:4:"page";}s:14:"C1544003712052";a:6:{s:6:"imgurl";s:64:"https://duli.nttrip.cn/template_img/template_edu/index/menu4.png";s:7:"linkurl";s:0:"";s:4:"text";s:12:"活动中心";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";s:8:"linktype";s:4:"page";}}s:2:"id";s:4:"menu";}s:14:"M1544003790109";a:5:{s:4:"icon";s:22:"iconfont2 icon-gonggao";s:6:"params";a:12:{s:7:"iconurl";s:15:"icon-x-gonggao4";s:10:"noticedata";s:1:"0";s:5:"speed";s:1:"4";s:9:"noticenum";s:1:"5";s:8:"navstyle";s:1:"1";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:8:"sourceid";s:0:"";}s:5:"style";a:9:{s:10:"background";s:7:"#ffffff";s:9:"iconcolor";s:7:"#ff9b64";s:5:"color";s:7:"#666666";s:11:"bordercolor";s:7:"#e2e2e2";s:2:"mt";s:2:"10";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";}s:4:"data";a:2:{s:14:"C1544003790109";a:2:{s:5:"title";s:42:"这里是第一条自定义公告的标题";s:7:"linkurl";s:0:"";}s:14:"C1544003790110";a:2:{s:5:"title";s:42:"这里是第二条自定义公告的标题";s:7:"linkurl";s:0:"";}}s:2:"id";s:6:"notice";}s:14:"M1544084374773";a:5:{s:4:"icon";s:25:"iconfont2 icon-youhuiquan";s:6:"params";a:10:{s:8:"hidetext";s:1:"0";s:8:"showtype";s:1:"0";s:6:"rownum";s:1:"3";s:7:"showbtn";s:1:"0";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:10:{s:10:"background";s:7:"#f6f6f6";s:5:"yhqbg";s:7:"#f26e47";s:6:"yhqbg2";s:7:"#f57953";s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:5:"color";s:7:"#ffffff";s:2:"mt";s:1:"3";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:6:"counts";s:1:"3";}s:4:"data";a:3:{s:14:"C1544084374773";a:3:{s:7:"linkurl";s:0:"";s:5:"title";s:3:"100";s:4:"text";s:15:"满500元可用";}s:14:"C1544084374774";a:3:{s:7:"linkurl";s:0:"";s:5:"title";s:3:"100";s:4:"text";s:15:"满500元可用";}s:14:"C1544084374775";a:3:{s:7:"linkurl";s:0:"";s:5:"title";s:3:"100";s:4:"text";s:15:"满500元可用";}}s:2:"id";s:3:"yhq";}s:14:"M1544004061030";a:5:{s:4:"icon";s:23:"iconfont2 icon-daohang1";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:10:{s:9:"margintop";s:1:"0";s:10:"background";s:7:"#ffffff";s:9:"iconcolor";s:7:"#999999";s:9:"textcolor";s:7:"#666666";s:11:"remarkcolor";s:7:"#888888";s:5:"sizew";s:2:"20";s:11:"paddingleft";s:2:"10";s:7:"padding";s:1:"7";s:5:"sizeh";s:2:"20";s:9:"linecolor";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1544004061030";a:6:{s:4:"text";s:12:"课程直击";s:7:"linkurl";s:0:"";s:9:"iconclass";s:0:"";s:6:"remark";s:4:"more";s:6:"dotnum";s:0:"";s:8:"linktype";s:4:"page";}}s:2:"id";s:8:"listmenu";}s:14:"M1544004158643";a:5:{s:4:"icon";s:19:"iconfont2 icon-zutu";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:6:{s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"background";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1544004158643";a:3:{s:6:"imgurl";s:66:"https://duli.nttrip.cn/template_img/template_edu/index/banner2.png";s:7:"linkurl";s:0:"";s:8:"linktype";s:4:"page";}}s:2:"id";s:7:"picture";}s:14:"M1544003465567";a:6:{s:3:"max";s:1:"1";s:4:"icon";s:23:"iconfont2 icon-shandian";s:6:"params";a:12:{s:8:"navstyle";s:1:"1";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:9:"goodsdata";s:1:"1";s:8:"goodsnum";s:1:"3";s:7:"con_key";s:1:"1";s:8:"con_type";s:1:"1";s:8:"sourceid";s:0:"";}s:5:"style";a:9:{s:10:"background";s:7:"#ffffff";s:3:"pdw";s:2:"10";s:3:"pdh";s:2:"10";s:2:"mb";s:2:"10";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:4:"pich";s:1:"1";s:8:"showtype";s:1:"0";}s:4:"data";a:3:{s:14:"C1544003465567";a:14:{s:6:"imgurl";s:47:"/diypage/resource/images/diypage/default/11.jpg";s:5:"title";s:18:"秒杀商品标题";s:11:"description";s:18:"秒杀商品简介";s:5:"count";s:3:"927";s:5:"price";s:2:"21";s:4:"hour";s:2:"10";s:3:"min";s:2:"11";s:6:"second";s:2:"12";s:6:"person";s:1:"2";s:2:"tz";s:2:"92";s:3:"tgr";s:3:"427";s:3:"tgj";s:4:"17.2";s:7:"linkurl";s:0:"";s:8:"linktype";s:0:"";}s:14:"C1544003465568";a:14:{s:6:"imgurl";s:47:"/diypage/resource/images/diypage/default/11.jpg";s:5:"title";s:18:"秒杀商品标题";s:11:"description";s:18:"秒杀商品简介";s:5:"count";s:3:"927";s:5:"price";s:2:"21";s:4:"hour";s:2:"10";s:3:"min";s:2:"11";s:6:"second";s:2:"12";s:6:"person";s:1:"2";s:2:"tz";s:2:"92";s:3:"tgr";s:3:"427";s:3:"tgj";s:4:"17.2";s:7:"linkurl";s:0:"";s:8:"linktype";s:0:"";}s:14:"C1544003465569";a:14:{s:6:"imgurl";s:47:"/diypage/resource/images/diypage/default/11.jpg";s:5:"title";s:18:"秒杀商品标题";s:11:"description";s:18:"秒杀商品简介";s:5:"count";s:3:"927";s:5:"price";s:2:"21";s:4:"hour";s:2:"10";s:3:"min";s:2:"11";s:6:"second";s:2:"12";s:6:"person";s:1:"2";s:2:"tz";s:2:"92";s:3:"tgr";s:3:"427";s:3:"tgj";s:4:"17.2";s:7:"linkurl";s:0:"";s:8:"linktype";s:0:"";}}s:2:"id";s:4:"msmk";}s:14:"M1544004194084";a:6:{s:4:"icon";s:23:"iconfont2 icon-daohang1";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:10:{s:9:"margintop";s:1:"8";s:10:"background";s:7:"#ffffff";s:9:"iconcolor";s:7:"#999999";s:9:"textcolor";s:7:"#666666";s:11:"remarkcolor";s:7:"#888888";s:5:"sizew";s:2:"20";s:11:"paddingleft";s:2:"10";s:7:"padding";s:1:"7";s:5:"sizeh";s:2:"20";s:9:"linecolor";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1544004194084";a:6:{s:4:"text";s:12:"名师在线";s:7:"linkurl";s:0:"";s:9:"iconclass";s:0:"";s:6:"remark";s:4:"more";s:6:"dotnum";s:0:"";s:8:"linktype";s:4:"page";}}s:2:"id";s:8:"listmenu";s:5:"index";s:3:"NaN";}s:14:"M1544004241306";a:6:{s:4:"icon";s:23:"iconfont2 icon-wenzhang";s:6:"params";a:19:{s:9:"showstyle";s:4:"row1";s:7:"newsnum";s:1:"4";s:8:"newsdata";s:1:"0";s:5:"title";s:21:"请选择文章分类";s:7:"titleid";s:1:"0";s:8:"navstyle";s:1:"2";s:5:"show1";s:1:"1";s:5:"show2";s:1:"0";s:5:"show3";s:1:"0";s:5:"show4";s:1:"0";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:7:"con_key";s:1:"1";s:8:"con_type";s:1:"1";s:8:"sourceid";s:0:"";}s:5:"style";a:11:{s:10:"background";s:4:"#fff";s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:12:"marginbottom";s:2:"10";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:5:"color";s:7:"#434343";s:6:"radius";s:1:"0";s:4:"pich";s:1:"1";s:8:"showtype";s:1:"0";}s:4:"data";a:3:{s:14:"C1544004241306";a:8:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/3.jpg";s:2:"id";s:0:"";s:5:"title";s:15:"这里是标题";s:4:"time";s:16:"2017年10月1日";s:5:"intro";s:21:"简介1简介1简介1";s:3:"ydl";s:2:"10";s:3:"dzl";s:2:"10";s:3:"pll";s:2:"10";}s:14:"C1544004241307";a:8:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/3.jpg";s:2:"id";s:0:"";s:5:"title";s:15:"这里是标题";s:4:"time";s:16:"2017年10月1日";s:5:"intro";s:15:"这里是简介";s:3:"ydl";s:2:"10";s:3:"dzl";s:2:"10";s:3:"pll";s:2:"10";}s:14:"C1544004241308";a:8:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/3.jpg";s:2:"id";s:0:"";s:5:"title";s:15:"这里是标题";s:4:"time";s:16:"2017年10月1日";s:5:"intro";s:15:"这里是简介";s:3:"ydl";s:2:"10";s:3:"dzl";s:2:"10";s:3:"pll";s:2:"10";}}s:2:"id";s:8:"listdesc";s:5:"index";s:3:"NaN";}s:14:"M1544236340672";a:7:{s:4:"icon";s:21:"iconfont2 icon-caidan";s:6:"isfoot";s:1:"1";s:3:"max";s:1:"1";s:6:"params";a:8:{s:8:"navstyle";s:1:"1";s:8:"textshow";s:1:"1";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:20:{s:11:"pagebgcolor";s:7:"#f9f9f9";s:7:"bgcolor";s:7:"#ffffff";s:9:"bgcoloron";s:7:"#ffffff";s:9:"iconcolor";s:7:"#999999";s:11:"iconcoloron";s:7:"#999999";s:9:"textcolor";s:7:"#666666";s:11:"textcoloron";s:7:"#666666";s:11:"bordercolor";s:7:"#cccccc";s:13:"bordercoloron";s:7:"#ffffff";s:14:"childtextcolor";s:7:"#666666";s:12:"childbgcolor";s:7:"#f4f4f4";s:16:"childbordercolor";s:7:"#eeeeee";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:11:"paddingleft";s:1:"0";s:10:"paddingtop";s:1:"0";s:8:"iconfont";s:2:"20";s:8:"textfont";s:2:"10";s:3:"bdr";s:1:"0";s:8:"bdrcolor";s:7:"#cccccc";}s:4:"data";a:4:{s:14:"C1544236340672";a:5:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/index/footmenu1.png";s:7:"linkurl";s:23:"/sudu8_page/index/index";s:9:"iconclass";s:14:"icon-x-shouye2";s:4:"text";s:6:"首页";s:8:"linktype";s:4:"page";}s:14:"C1544236340673";a:4:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/index/footmenu2.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:15:"icon-x-chanpin2";s:4:"text";s:6:"课程";}s:14:"C1544236340674";a:5:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/index/footmenu3.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:14:"icon-x-liebiao";s:4:"text";s:6:"学校";s:8:"linktype";s:4:"page";}s:14:"C1544236340675";a:5:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/index/footmenu4.png";s:7:"linkurl";s:33:"/sudu8_page/usercenter/usercenter";s:9:"iconclass";s:16:"icon-x-dianhua10";s:4:"text";s:6:"我的";s:8:"linktype";s:4:"page";}}s:2:"id";s:8:"footmenu";}}';
        $item1 = unserialize($item1);
        foreach($item1 as $k => &$v){
            if($v['data']){
                foreach($v['data'] as $kk => &$vv){
                    if($vv['imgurl'] && strpos($vv['imgurl'],'https://duli.nttrip.cn/') !== false){
                        $vv['imgurl'] = ASSETSS.explode('https://duli.nttrip.cn/', $vv['imgurl'])[1];
                    }
                    if($vv['imgurl'] && strpos($vv['imgurl'],'/diypage/resource/images/diypage/default/11.jpg') !== false){
                        $vv['imgurl'] = ASSETSS."resource/images/diypage/default/11.jpg";
                    }
                    if($vv['thumb'] && strpos($vv['thumb'],'/diypage/resource/images/diypage/default/3.jpg') !== false){
                        $vv['thumb'] = ASSETSS."resource/images/diypage/default/3.jpg";
                    }
                }
            }
        }
        $page1['items'] = serialize($item1);
        $page1['page'] = 'a:7:{s:10:"background";s:7:"#f1f1f1";s:13:"topbackground";s:7:"#f26e47";s:8:"topcolor";s:1:"2";s:9:"styledata";s:1:"0";s:5:"title";s:12:"教育首页";s:4:"name";s:6:"首页";s:10:"visitlevel";a:2:{s:6:"member";s:0:"";s:10:"commission";s:0:"";}}';
        $page1['tpl_name'] = "首页";

        $page2 = [];
        $page2['uniacid'] = $uniacid;
        $page2['index'] = 0;
        $item2 = 'a:2:{s:14:"M1544004346958";a:6:{s:4:"icon";s:21:"iconfont2 icon-tupian";s:6:"params";a:9:{s:3:"row";s:1:"2";s:8:"showtype";s:1:"0";s:7:"pagenum";s:1:"2";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:8:{s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:7:"showdot";s:1:"0";s:7:"showbtn";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:2:"mt";s:1:"0";s:10:"background";s:7:"#ffffff";}s:4:"data";a:6:{s:14:"C1544004346959";a:2:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/page1/picturew1.png";s:7:"linkurl";s:0:"";}s:14:"C1544004346960";a:2:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/page1/picturew2.png";s:7:"linkurl";s:0:"";}s:14:"C1544004346961";a:2:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/page1/picturew3.png";s:7:"linkurl";s:0:"";}s:14:"C1544004346962";a:2:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/page1/picturew4.png";s:7:"linkurl";s:0:"";}s:14:"M1544004361449";a:2:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/page1/picturew5.png";s:7:"linkurl";s:0:"";}s:14:"M1544004363193";a:2:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/page1/picturew6.png";s:7:"linkurl";s:0:"";}}s:2:"id";s:8:"picturew";s:5:"index";s:3:"NaN";}s:14:"M1544238564913";a:7:{s:4:"icon";s:21:"iconfont2 icon-caidan";s:6:"isfoot";s:1:"1";s:3:"max";s:1:"1";s:6:"params";a:8:{s:8:"navstyle";s:1:"1";s:8:"textshow";s:1:"1";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:20:{s:11:"pagebgcolor";s:7:"#f9f9f9";s:7:"bgcolor";s:7:"#ffffff";s:9:"bgcoloron";s:7:"#ffffff";s:9:"iconcolor";s:7:"#999999";s:11:"iconcoloron";s:7:"#999999";s:9:"textcolor";s:7:"#666666";s:11:"textcoloron";s:7:"#666666";s:11:"bordercolor";s:7:"#cccccc";s:13:"bordercoloron";s:7:"#ffffff";s:14:"childtextcolor";s:7:"#666666";s:12:"childbgcolor";s:7:"#f4f4f4";s:16:"childbordercolor";s:7:"#eeeeee";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:11:"paddingleft";s:1:"0";s:10:"paddingtop";s:1:"0";s:8:"iconfont";s:2:"20";s:8:"textfont";s:2:"10";s:3:"bdr";s:1:"0";s:8:"bdrcolor";s:7:"#cccccc";}s:4:"data";a:4:{s:14:"C1544238564914";a:5:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/index/footmenu1.png";s:7:"linkurl";s:23:"/sudu8_page/index/index";s:9:"iconclass";s:14:"icon-x-shouye2";s:4:"text";s:6:"首页";s:8:"linktype";s:4:"page";}s:14:"C1544238564915";a:4:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/index/footmenu2.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:15:"icon-x-chanpin2";s:4:"text";s:6:"课程";}s:14:"C1544238564916";a:5:{s:6:"imgurl";s:58:"/upimages/20181208/e170fe64ce969d94f48821b2f981584d251.png";s:7:"linkurl";s:33:"/sudu8_page/index/index?pageid=38";s:9:"iconclass";s:14:"icon-x-liebiao";s:4:"text";s:6:"学校";s:8:"linktype";s:4:"page";}s:14:"C1544238564917";a:5:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/index/footmenu4.png";s:7:"linkurl";s:33:"/sudu8_page/usercenter/usercenter";s:9:"iconclass";s:16:"icon-x-dianhua10";s:4:"text";s:6:"我的";s:8:"linktype";s:4:"page";}}s:2:"id";s:8:"footmenu";}}';
        $item2 = unserialize($item2);
        foreach($item2 as $k => &$v){
            if($v['data']){
                foreach($v['data'] as $kk => &$vv){
                    if($vv['imgurl'] && strpos($vv['imgurl'],'https://duli.nttrip.cn/') !== false){
                        $vv['imgurl'] = ASSETSS.explode('https://duli.nttrip.cn/', $vv['imgurl'])[1];
                    }
                }
            }
        }
        $page2['items'] = serialize($item2);
        $page2['page'] = 'a:7:{s:10:"background";s:7:"#f1f1f1";s:13:"topbackground";s:7:"#f26e47";s:8:"topcolor";s:1:"2";s:9:"styledata";s:1:"0";s:5:"title";s:9:"展示墙";s:4:"name";s:9:"展示墙";s:10:"visitlevel";a:2:{s:6:"member";s:0:"";s:10:"commission";s:0:"";}}';
        $page2['tpl_name'] = "展示墙";

        $page3 = [];
        $page3['uniacid'] = $uniacid;
        $page3['index'] = 0;
        $item3 = 'a:4:{s:14:"M1544004589716";a:5:{s:4:"icon";s:19:"iconfont2 icon-zutu";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:6:{s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"background";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1544004589717";a:3:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_edu/page2/picture1.png";s:7:"linkurl";s:0:"";s:8:"linktype";s:4:"page";}}s:2:"id";s:7:"picture";}s:14:"M1544004632347";a:6:{s:4:"icon";s:19:"iconfont2 icon-zutu";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:6:{s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"background";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1544004632347";a:3:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_edu/page2/picture2.png";s:7:"linkurl";s:0:"";s:8:"linktype";s:4:"page";}}s:2:"id";s:7:"picture";s:5:"index";s:3:"NaN";}s:14:"M1544004632867";a:6:{s:4:"icon";s:19:"iconfont2 icon-zutu";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:6:{s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"background";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1544004632867";a:3:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_edu/page2/picture3.png";s:7:"linkurl";s:0:"";s:8:"linktype";s:4:"page";}}s:2:"id";s:7:"picture";s:5:"index";s:3:"NaN";}s:14:"M1544238643731";a:7:{s:4:"icon";s:21:"iconfont2 icon-caidan";s:6:"isfoot";s:1:"1";s:3:"max";s:1:"1";s:6:"params";a:8:{s:8:"navstyle";s:1:"1";s:8:"textshow";s:1:"1";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:20:{s:11:"pagebgcolor";s:7:"#f9f9f9";s:7:"bgcolor";s:7:"#ffffff";s:9:"bgcoloron";s:7:"#ffffff";s:9:"iconcolor";s:7:"#999999";s:11:"iconcoloron";s:7:"#999999";s:9:"textcolor";s:7:"#666666";s:11:"textcoloron";s:7:"#666666";s:11:"bordercolor";s:7:"#cccccc";s:13:"bordercoloron";s:7:"#ffffff";s:14:"childtextcolor";s:7:"#666666";s:12:"childbgcolor";s:7:"#f4f4f4";s:16:"childbordercolor";s:7:"#eeeeee";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:11:"paddingleft";s:1:"0";s:10:"paddingtop";s:1:"0";s:8:"iconfont";s:2:"20";s:8:"textfont";s:2:"10";s:3:"bdr";s:1:"0";s:8:"bdrcolor";s:7:"#cccccc";}s:4:"data";a:4:{s:14:"C1544238643731";a:5:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/index/footmenu1.png";s:7:"linkurl";s:23:"/sudu8_page/index/index";s:9:"iconclass";s:14:"icon-x-shouye2";s:4:"text";s:6:"首页";s:8:"linktype";s:4:"page";}s:14:"C1544238643732";a:4:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/index/footmenu2.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:15:"icon-x-chanpin2";s:4:"text";s:6:"课程";}s:14:"C1544238643733";a:5:{s:6:"imgurl";s:58:"/upimages/20181208/da626ceaeca72702a5c656f574b472c1491.png";s:7:"linkurl";s:33:"/sudu8_page/index/index?pageid=38";s:9:"iconclass";s:14:"icon-x-liebiao";s:4:"text";s:6:"学校";s:8:"linktype";s:4:"page";}s:14:"C1544238643734";a:5:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/index/footmenu4.png";s:7:"linkurl";s:33:"/sudu8_page/usercenter/usercenter";s:9:"iconclass";s:16:"icon-x-dianhua10";s:4:"text";s:6:"我的";s:8:"linktype";s:4:"page";}}s:2:"id";s:8:"footmenu";}}';
        $item3 = unserialize($item3);
        foreach($item3 as $k => &$v){
            if($v['data']){
                foreach($v['data'] as $kk => &$vv){
                    if($vv['imgurl'] && strpos($vv['imgurl'],'https://duli.nttrip.cn/') !== false){
                        $vv['imgurl'] = ASSETSS.explode('https://duli.nttrip.cn/', $vv['imgurl'])[1];
                    }
                }
            }
        }
        $page3['items'] = serialize($item3);
        $page3['page'] = 'a:7:{s:10:"background";s:7:"#f1f1f1";s:13:"topbackground";s:7:"#f26e47";s:8:"topcolor";s:1:"2";s:9:"styledata";s:1:"0";s:5:"title";s:12:"活动中心";s:4:"name";s:12:"活动中心";s:10:"visitlevel";a:2:{s:6:"member";s:0:"";s:10:"commission";s:0:"";}}';
        $page3['tpl_name'] = "活动中心";

        $page4 = [];
        $page4['uniacid'] = $uniacid;
        $page4['index'] = 0;
        $item4 = 'a:6:{s:14:"M1544004750684";a:5:{s:4:"icon";s:25:"iconfont2 icon-wenzianniu";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:6:{s:9:"margintop";s:1:"0";s:10:"background";s:7:"#f26e47";s:5:"sizew";s:2:"20";s:11:"paddingleft";s:2:"10";s:7:"padding";s:2:"10";s:5:"sizeh";s:2:"20";}s:4:"data";a:2:{s:14:"C1544004750684";a:6:{s:4:"text";s:12:"关于我们";s:9:"iconclass";s:0:"";s:9:"textcolor";s:7:"#ffffff";s:9:"iconcolor";s:7:"#666666";s:7:"linkurl";s:33:"/sudu8_page/index/index?pageid=38";s:8:"linktype";s:4:"page";}s:14:"C1544004750685";a:6:{s:4:"text";s:9:"分校区";s:9:"iconclass";s:0:"";s:9:"textcolor";s:7:"#ffffff";s:9:"iconcolor";s:7:"#666666";s:7:"linkurl";s:23:"/sudu8_page/store/store";s:8:"linktype";s:4:"page";}}s:2:"id";s:5:"menu2";}s:14:"M1544004811551";a:5:{s:4:"icon";s:28:"iconfont2 icon-tuoyuankaobei";s:6:"params";a:10:{s:5:"totle";s:1:"2";s:8:"navstyle";s:1:"0";s:9:"styledata";s:1:"1";s:6:"repeat";s:9:"no-repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"1";s:13:"backgroundimg";s:68:"https://duli.nttrip.cn/template_img/template_edu/page3/banner_bg.jpg";s:9:"navstyle2";s:1:"0";s:4:"imgh";s:3:"135";}s:5:"style";a:18:{s:8:"dotstyle";s:5:"round";s:8:"dotalign";s:4:"left";s:10:"paddingtop";s:2:"25";s:11:"paddingleft";s:2:"20";s:10:"background";s:7:"#ffffff";s:13:"backgroundall";s:7:"#ffffff";s:9:"leftright";s:1:"5";s:6:"bottom";s:1:"5";s:7:"opacity";s:3:"0.8";s:10:"text_color";s:4:"#fff";s:2:"bg";s:7:"#000000";s:9:"jsq_color";s:3:"red";s:3:"pdh";s:1:"0";s:3:"pdw";s:1:"0";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:5:"speed";s:1:"5";}s:4:"data";a:2:{s:14:"C1544004811551";a:4:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_edu/page3/banner.png";s:7:"linkurl";s:0:"";s:6:"single";s:1:"1";s:4:"text";s:12:"文字描述";}s:14:"C1544004811552";a:4:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_edu/page3/banner.png";s:7:"linkurl";s:0:"";s:6:"single";s:1:"2";s:4:"text";s:12:"文字描述";}}s:2:"id";s:6:"banner";}s:14:"M1544005009205";a:5:{s:3:"max";s:1:"5";s:4:"icon";s:23:"iconfont2 icon-fuwenben";s:6:"params";a:1:{s:7:"content";s:552:"PHA+PHNwYW4gc3R5bGU9ImZvbnQtc2l6ZTogMTZweDsiPjxzdHJvbmc+6L6+5YaF5Z+56K6t5py65p6EPC9zdHJvbmc+PC9zcGFuPjxici8+PC9wPjxwIHN0eWxlPSJtYXJnaW4tdG9wOiAxMHB4OyI+PHNwYW4gc3R5bGU9ImZvbnQtc2l6ZTogMTRweDsgY29sb3I6IHJnYigxMjcsIDEyNywgMTI3KTsiPui+vuWGheaXtuS7o+enkeaKgOmbhuWbouaciemZkOWFrOWPuOaIkOeri+S6jjIwMDLlubQ55pyI44CCMjAxNOW5tDTmnIgz5pel5oiQ5Yqf5Zyo576O5Zu957qz5pav6L6+5YWL5LiK5biC77yM6J6N6LWEMeS6vzPljYPkuIfnvo7lhYPjgILmiJDkuLrkuK3lm73otbTnvo7lm73kuIrluILnmoTogYzkuJrmlZnogrLlhazlj7jvvIzkuZ/mmK/lvJXpoobooYzkuJrnmoTogYzkuJrmlZnogrLlhazlj7jjgII8L3NwYW4+PC9wPg==";}s:5:"style";a:3:{s:10:"background";s:7:"#ffffff";s:7:"padding";s:2:"10";s:9:"margintop";s:1:"0";}s:2:"id";s:8:"richtext";}s:14:"M1544005052741";a:4:{s:4:"icon";s:32:"iconfont2 icon-liebiao_biaotilan";s:6:"params";a:10:{s:5:"title";s:46:"南通市人民东路228号东方广场2号楼";s:4:"icon";s:12:"icon-x-dizhi";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:4:"link";s:88:"32.023880,120.906530##达内培训机构##南通市人民东路228号东方广场2号楼";s:8:"linktype";s:3:"map";}s:5:"style";a:9:{s:10:"background";s:7:"#ffffff";s:5:"color";s:7:"#666666";s:9:"textalign";s:4:"left";s:8:"fontsize";s:2:"14";s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:2:"mt";s:1:"0";}s:2:"id";s:5:"title";}s:14:"M1544005180683";a:4:{s:4:"icon";s:32:"iconfont2 icon-liebiao_biaotilan";s:6:"params";a:10:{s:5:"title";s:22:"电话：0513-26278273";s:4:"icon";s:15:"icon-x-dianhua1";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:4:"link";s:17:"tel:0513-26278273";s:8:"linktype";s:3:"tel";}s:5:"style";a:9:{s:10:"background";s:7:"#ffffff";s:5:"color";s:7:"#666666";s:9:"textalign";s:4:"left";s:8:"fontsize";s:2:"14";s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:2:"mt";s:1:"0";}s:2:"id";s:5:"title";}s:14:"M1544238831018";a:7:{s:4:"icon";s:21:"iconfont2 icon-caidan";s:6:"isfoot";s:1:"1";s:3:"max";s:1:"1";s:6:"params";a:8:{s:8:"navstyle";s:1:"1";s:8:"textshow";s:1:"1";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:20:{s:11:"pagebgcolor";s:7:"#f9f9f9";s:7:"bgcolor";s:7:"#ffffff";s:9:"bgcoloron";s:7:"#ffffff";s:9:"iconcolor";s:7:"#999999";s:11:"iconcoloron";s:7:"#999999";s:9:"textcolor";s:7:"#666666";s:11:"textcoloron";s:7:"#666666";s:11:"bordercolor";s:7:"#cccccc";s:13:"bordercoloron";s:7:"#ffffff";s:14:"childtextcolor";s:7:"#666666";s:12:"childbgcolor";s:7:"#f4f4f4";s:16:"childbordercolor";s:7:"#eeeeee";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:11:"paddingleft";s:1:"0";s:10:"paddingtop";s:1:"0";s:8:"iconfont";s:2:"20";s:8:"textfont";s:2:"10";s:3:"bdr";s:1:"0";s:8:"bdrcolor";s:7:"#cccccc";}s:4:"data";a:4:{s:14:"C1544238831018";a:5:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/index/footmenu1.png";s:7:"linkurl";s:23:"/sudu8_page/index/index";s:9:"iconclass";s:14:"icon-x-shouye2";s:4:"text";s:6:"首页";s:8:"linktype";s:4:"page";}s:14:"C1544238831019";a:4:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/index/footmenu2.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:15:"icon-x-chanpin2";s:4:"text";s:6:"课程";}s:14:"C1544238831020";a:5:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/index/footmenu3.png";s:7:"linkurl";s:33:"/sudu8_page/index/index?pageid=38";s:9:"iconclass";s:14:"icon-x-liebiao";s:4:"text";s:6:"学校";s:8:"linktype";s:4:"page";}s:14:"C1544238831021";a:5:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/index/footmenu4.png";s:7:"linkurl";s:33:"/sudu8_page/usercenter/usercenter";s:9:"iconclass";s:16:"icon-x-dianhua10";s:4:"text";s:6:"我的";s:8:"linktype";s:4:"page";}}s:2:"id";s:8:"footmenu";}}';
        $item4 = unserialize($item4);
        foreach($item4 as $k => &$v){
            if($v['data']){
                foreach($v['data'] as $kk => &$vv){
                    if($vv['imgurl'] && strpos($vv['imgurl'],'https://duli.nttrip.cn/') !== false){
                        $vv['imgurl'] = ASSETSS.explode('https://duli.nttrip.cn/', $vv['imgurl'])[1];
                    }
                }
            }
        }
        $page4['items'] = serialize($item4);
        $page4['page'] = 'a:7:{s:10:"background";s:7:"#f1f1f1";s:13:"topbackground";s:7:"#f26e47";s:8:"topcolor";s:1:"2";s:9:"styledata";s:1:"0";s:5:"title";s:12:"学校介绍";s:4:"name";s:12:"学校介绍";s:10:"visitlevel";a:2:{s:6:"member";s:0:"";s:10:"commission";s:0:"";}}';
        $page4['tpl_name'] = "学校介绍";

        $page5 = [];
        $page5['uniacid'] = $uniacid;
        $page5['index'] = 0;
        $item5 = 'a:10:{s:14:"M1544062245674";a:5:{s:4:"icon";s:19:"iconfont2 icon-zutu";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:6:{s:10:"paddingtop";s:2:"15";s:11:"paddingleft";s:2:"15";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"background";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1544062245674";a:3:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_edu/page4/picture1.png";s:7:"linkurl";s:0:"";s:8:"linktype";s:4:"page";}}s:2:"id";s:7:"picture";}s:14:"M1544062259958";a:4:{s:4:"icon";s:32:"iconfont2 icon-liebiao_biaotilan";s:6:"params";a:10:{s:5:"title";s:37:"插画师养成记-初期练习指南";s:4:"icon";s:0:"";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:4:"link";s:0:"";s:8:"linktype";s:4:"page";}s:5:"style";a:9:{s:10:"background";s:7:"#ffffff";s:5:"color";s:7:"#666666";s:9:"textalign";s:4:"left";s:8:"fontsize";s:2:"14";s:10:"paddingtop";s:1:"3";s:11:"paddingleft";s:2:"10";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:2:"mt";s:1:"0";}s:2:"id";s:5:"title";}s:14:"M1544062263803";a:5:{s:4:"icon";s:23:"iconfont2 icon-daohang1";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:10:{s:9:"margintop";s:1:"0";s:10:"background";s:7:"#ffffff";s:9:"iconcolor";s:7:"#999999";s:9:"textcolor";s:7:"#666666";s:11:"remarkcolor";s:7:"#888888";s:5:"sizew";s:2:"20";s:11:"paddingleft";s:2:"10";s:7:"padding";s:1:"0";s:5:"sizeh";s:2:"20";s:9:"linecolor";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1544062263803";a:6:{s:4:"text";s:23:"11月21日  11:30开课";s:7:"linkurl";s:0:"";s:9:"iconclass";s:15:"icon-c-shijian2";s:6:"remark";s:15:"讲师：王蓉";s:6:"dotnum";s:0:"";s:8:"linktype";s:4:"page";}}s:2:"id";s:8:"listmenu";}s:14:"M1544061563099";a:6:{s:4:"icon";s:19:"iconfont2 icon-zutu";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:6:{s:10:"paddingtop";s:2:"15";s:11:"paddingleft";s:2:"15";s:2:"mt";s:2:"10";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"background";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1544061563099";a:3:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_edu/page4/picture2.png";s:7:"linkurl";s:0:"";s:8:"linktype";s:4:"page";}}s:2:"id";s:7:"picture";s:5:"index";s:3:"NaN";}s:14:"M1544061568609";a:4:{s:4:"icon";s:32:"iconfont2 icon-liebiao_biaotilan";s:6:"params";a:10:{s:5:"title";s:21:"语文写作进阶班";s:4:"icon";s:0:"";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:4:"link";s:0:"";s:8:"linktype";s:4:"page";}s:5:"style";a:9:{s:10:"background";s:7:"#ffffff";s:5:"color";s:7:"#666666";s:9:"textalign";s:4:"left";s:8:"fontsize";s:2:"14";s:10:"paddingtop";s:1:"3";s:11:"paddingleft";s:2:"10";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:2:"mt";s:1:"0";}s:2:"id";s:5:"title";}s:14:"M1544061573342";a:5:{s:4:"icon";s:23:"iconfont2 icon-daohang1";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:10:{s:9:"margintop";s:1:"0";s:10:"background";s:7:"#ffffff";s:9:"iconcolor";s:7:"#999999";s:9:"textcolor";s:7:"#666666";s:11:"remarkcolor";s:7:"#888888";s:5:"sizew";s:2:"20";s:11:"paddingleft";s:2:"10";s:7:"padding";s:1:"0";s:5:"sizeh";s:2:"20";s:9:"linecolor";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1544061573342";a:6:{s:4:"text";s:23:"11月22日  16:30开课";s:7:"linkurl";s:0:"";s:9:"iconclass";s:15:"icon-c-shijian2";s:6:"remark";s:15:"讲师：张亮";s:6:"dotnum";s:0:"";s:8:"linktype";s:4:"page";}}s:2:"id";s:8:"listmenu";}s:14:"M1544059901146";a:5:{s:4:"icon";s:19:"iconfont2 icon-zutu";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:6:{s:10:"paddingtop";s:2:"15";s:11:"paddingleft";s:2:"15";s:2:"mt";s:2:"10";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"background";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1544059901146";a:3:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_edu/page4/picture3.png";s:7:"linkurl";s:0:"";s:8:"linktype";s:4:"page";}}s:2:"id";s:7:"picture";}s:14:"M1544058945116";a:4:{s:4:"icon";s:32:"iconfont2 icon-liebiao_biaotilan";s:6:"params";a:10:{s:5:"title";s:20:"IT技术基础课程";s:4:"icon";s:0:"";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:4:"link";s:0:"";s:8:"linktype";s:4:"page";}s:5:"style";a:9:{s:10:"background";s:7:"#ffffff";s:5:"color";s:7:"#666666";s:9:"textalign";s:4:"left";s:8:"fontsize";s:2:"14";s:10:"paddingtop";s:1:"3";s:11:"paddingleft";s:2:"10";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:2:"mt";s:1:"0";}s:2:"id";s:5:"title";}s:14:"M1544058949612";a:5:{s:4:"icon";s:23:"iconfont2 icon-daohang1";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:10:{s:9:"margintop";s:1:"0";s:10:"background";s:7:"#ffffff";s:9:"iconcolor";s:7:"#999999";s:9:"textcolor";s:7:"#666666";s:11:"remarkcolor";s:7:"#888888";s:5:"sizew";s:2:"20";s:11:"paddingleft";s:2:"10";s:7:"padding";s:1:"0";s:5:"sizeh";s:2:"20";s:9:"linecolor";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1544058949612";a:6:{s:4:"text";s:23:"11月23日  19:30开课";s:7:"linkurl";s:0:"";s:9:"iconclass";s:15:"icon-c-shijian2";s:6:"remark";s:15:"讲师：周钰";s:6:"dotnum";s:0:"";s:8:"linktype";s:4:"page";}}s:2:"id";s:8:"listmenu";}s:14:"M1544238964885";a:7:{s:4:"icon";s:21:"iconfont2 icon-caidan";s:6:"isfoot";s:1:"1";s:3:"max";s:1:"1";s:6:"params";a:8:{s:8:"navstyle";s:1:"1";s:8:"textshow";s:1:"1";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:20:{s:11:"pagebgcolor";s:7:"#f9f9f9";s:7:"bgcolor";s:7:"#ffffff";s:9:"bgcoloron";s:7:"#ffffff";s:9:"iconcolor";s:7:"#999999";s:11:"iconcoloron";s:7:"#999999";s:9:"textcolor";s:7:"#666666";s:11:"textcoloron";s:7:"#666666";s:11:"bordercolor";s:7:"#cccccc";s:13:"bordercoloron";s:7:"#ffffff";s:14:"childtextcolor";s:7:"#666666";s:12:"childbgcolor";s:7:"#f4f4f4";s:16:"childbordercolor";s:7:"#eeeeee";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:11:"paddingleft";s:1:"0";s:10:"paddingtop";s:1:"0";s:8:"iconfont";s:2:"20";s:8:"textfont";s:2:"10";s:3:"bdr";s:1:"0";s:8:"bdrcolor";s:7:"#cccccc";}s:4:"data";a:4:{s:14:"C1544238964885";a:5:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/index/footmenu1.png";s:7:"linkurl";s:23:"/sudu8_page/index/index";s:9:"iconclass";s:14:"icon-x-shouye2";s:4:"text";s:6:"首页";s:8:"linktype";s:4:"page";}s:14:"C1544238964886";a:4:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/index/footmenu2.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:15:"icon-x-chanpin2";s:4:"text";s:6:"课程";}s:14:"C1544238964887";a:5:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/index/footmenu3.png";s:7:"linkurl";s:33:"/sudu8_page/index/index?pageid=38";s:9:"iconclass";s:14:"icon-x-liebiao";s:4:"text";s:6:"学校";s:8:"linktype";s:4:"page";}s:14:"C1544238964888";a:5:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_edu/index/footmenu4.png";s:7:"linkurl";s:33:"/sudu8_page/usercenter/usercenter";s:9:"iconclass";s:16:"icon-x-dianhua10";s:4:"text";s:6:"我的";s:8:"linktype";s:4:"page";}}s:2:"id";s:8:"footmenu";}}';
        $item5 = unserialize($item5);
        foreach($item5 as $k => &$v){
            if($v['data']){
                foreach($v['data'] as $kk => &$vv){
                    if($vv['imgurl'] && strpos($vv['imgurl'],'https://duli.nttrip.cn/') !== false){
                        $vv['imgurl'] = ASSETSS.explode('https://duli.nttrip.cn/', $vv['imgurl'])[1];
                    }
                }
            }
        }
        $page5['items'] = serialize($item5);
        $page5['page'] = 'a:7:{s:10:"background";s:7:"#ffffff";s:13:"topbackground";s:7:"#f26e47";s:8:"topcolor";s:1:"2";s:9:"styledata";s:1:"0";s:5:"title";s:12:"视频课堂";s:4:"name";s:12:"视频课堂";s:10:"visitlevel";a:2:{s:6:"member";s:0:"";s:10:"commission";s:0:"";}}';
        $page5['tpl_name'] = "视频课堂";

        pdo_insert("sudu8_page_diypage", $page1);
        $page1_id = pdo_insertid();
        pdo_insert("sudu8_page_diypage", $page2);
        $page2_id = pdo_insertid();
        pdo_insert("sudu8_page_diypage", $page3);
        $page3_id = pdo_insertid();
        pdo_insert("sudu8_page_diypage", $page4);
        $page4_id = pdo_insertid();
        pdo_insert("sudu8_page_diypage", $page5);
        $page5_id = pdo_insertid();
        $pageids = $page1_id.",".$page2_id.",".$page3_id.",".$page4_id.",".$page5_id;

        $page1_set = [
        	'pid' => $page1_id,
        	'uniacid' => $uniacid,
        	'kp' => ASSETSS."resource/images/diypage/default/default_start.jpg",
        	'kp_is' => 2,
        	'kp_m' => 2,
        	'tc' => ASSETSS."resource/images/diypage/default/tcgg.jpg",
        	'tc_is' => 2,
        	'foot_is' => 2
        ];
        $page2_set = [
        	'pid' => $page2_id,
        	'uniacid' => $uniacid,
        	'kp' => ASSETSS."resource/images/diypage/default/default_start.jpg",
        	'kp_is' => 2,
        	'kp_m' => 2,
        	'tc' => ASSETSS."resource/images/diypage/default/tcgg.jpg",
        	'tc_is' => 2,
        	'foot_is' => 2
        ];
        $page3_set = [
        	'pid' => $page3_id,
        	'uniacid' => $uniacid,
        	'kp' => ASSETSS."resource/images/diypage/default/default_start.jpg",
        	'kp_is' => 2,
        	'kp_m' => 2,
        	'tc' => ASSETSS."resource/images/diypage/default/tcgg.jpg",
        	'tc_is' => 2,
        	'foot_is' => 2
        ];
        $page4_set = [
        	'pid' => $page4_id,
        	'uniacid' => $uniacid,
        	'kp' => ASSETSS."resource/images/diypage/default/default_start.jpg",
        	'kp_is' => 2,
        	'kp_m' => 2,
        	'tc' => ASSETSS."resource/images/diypage/default/tcgg.jpg",
        	'tc_is' => 2,
        	'foot_is' => 2
        ];
        $page5_set = [
        	'pid' => $page5_id,
        	'uniacid' => $uniacid,
        	'kp' => ASSETSS."resource/images/diypage/default/default_start.jpg",
        	'kp_is' => 2,
        	'kp_m' => 2,
        	'tc' => ASSETSS."resource/images/diypage/default/tcgg.jpg",
        	'tc_is' => 2,
        	'foot_is' => 2
        ];

        pdo_insert("sudu8_page_diypageset", $page1_set);
        pdo_insert("sudu8_page_diypageset", $page2_set);
        pdo_insert("sudu8_page_diypageset", $page3_set);
        pdo_insert("sudu8_page_diypageset", $page4_set);
        pdo_insert("sudu8_page_diypageset", $page5_set);

        $data = [
            'uniacid' => $uniacid,
            'pageid' => $pageids,
            'template_name' => '教育类模板',
            'thumb' => ASSETSS."template_img/template_edu/cover.jpg",
            'status' => '1',
            'create_time' => time()
        ];
        pdo_insert("sudu8_page_diypagetpl", $data);
    	$tplid = pdo_insertid();
        if($tplid){
            echo $tplid;
        }
    }elseif($id == 'm_food'){
    	$page1 = [];
        $page1['uniacid'] = $uniacid;
        $page1['index'] = 1;
        $item1 = 'a:10:{s:14:"M1545274837699";a:6:{s:4:"icon";s:19:"iconfont2 icon-zutu";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:6:{s:10:"paddingtop";s:1:"0";s:11:"paddingleft";s:1:"0";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"background";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1545274837699";a:2:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_food/index/picture1.png";s:7:"linkurl";s:0:"";}}s:2:"id";s:7:"picture";s:5:"index";s:3:"NaN";}s:14:"M1545275020421";a:5:{s:4:"icon";s:19:"iconfont2 icon-zutu";s:6:"params";a:6:{s:9:"styledata";s:1:"1";s:6:"repeat";s:9:"no-repeat";s:9:"positionx";s:5:"right";s:9:"positiony";s:3:"top";s:4:"size";s:1:"1";s:13:"backgroundimg";s:71:"https://duli.nttrip.cn/template_img/template_food/index/picture2_bg.jpg";}s:5:"style";a:6:{s:10:"paddingtop";s:1:"0";s:11:"paddingleft";s:2:"10";s:2:"mt";s:1:"0";s:5:"sizew";s:3:"100";s:5:"sizeh";s:3:"100";s:10:"background";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1545275020421";a:3:{s:6:"imgurl";s:68:"https://duli.nttrip.cn/template_img/template_food/index/picture2.png";s:7:"linkurl";s:25:"/sudu8_page/coupon/coupon";s:8:"linktype";s:4:"page";}}s:2:"id";s:7:"picture";}s:14:"M1545275145163";a:5:{s:4:"icon";s:21:"iconfont2 icon-tupian";s:6:"params";a:9:{s:3:"row";s:1:"2";s:8:"showtype";s:1:"0";s:7:"pagenum";s:1:"2";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:8:{s:10:"paddingtop";s:1:"5";s:11:"paddingleft";s:2:"10";s:7:"showdot";s:1:"0";s:7:"showbtn";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:2:"mt";s:1:"9";s:10:"background";s:7:"#f1f1f1";}s:4:"data";a:2:{s:14:"C1545275145163";a:3:{s:6:"imgurl";s:71:"https://duli.nttrip.cn/template_img/template_food/index/picturew1-1.png";s:7:"linkurl";s:33:"/sudu8_page_plugin_food/food/food";s:8:"linktype";s:4:"page";}s:14:"C1545275145164";a:3:{s:6:"imgurl";s:71:"https://duli.nttrip.cn/template_img/template_food/index/picturew1-2.png";s:7:"linkurl";s:27:"/sudu8_page/shoppay/shoppay";s:8:"linktype";s:4:"page";}}s:2:"id";s:8:"picturew";}s:14:"M1545275242490";a:5:{s:4:"icon";s:23:"iconfont2 icon-daohang1";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:10:{s:9:"margintop";s:2:"10";s:10:"background";s:7:"#ffffff";s:9:"iconcolor";s:7:"#999999";s:9:"textcolor";s:7:"#333333";s:11:"remarkcolor";s:7:"#888888";s:5:"sizew";s:2:"20";s:11:"paddingleft";s:2:"15";s:7:"padding";s:1:"4";s:5:"sizeh";s:2:"20";s:9:"linecolor";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1545275242490";a:5:{s:4:"text";s:12:"今日特惠";s:7:"linkurl";s:0:"";s:9:"iconclass";s:0:"";s:6:"remark";s:4:"more";s:6:"dotnum";s:0:"";}}s:2:"id";s:8:"listmenu";}s:14:"M1545275327781";a:6:{s:4:"icon";s:21:"iconfont2 icon-tupian";s:6:"params";a:9:{s:3:"row";s:1:"1";s:8:"showtype";s:1:"0";s:7:"pagenum";s:1:"2";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:8:{s:10:"paddingtop";s:1:"5";s:11:"paddingleft";s:2:"10";s:7:"showdot";s:1:"0";s:7:"showbtn";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:2:"mt";s:1:"0";s:10:"background";s:7:"#ffffff";}s:4:"data";a:3:{s:14:"C1545275327781";a:2:{s:6:"imgurl";s:71:"https://duli.nttrip.cn/template_img/template_food/index/picturew2-1.png";s:7:"linkurl";s:0:"";}s:14:"C1545275327782";a:2:{s:6:"imgurl";s:71:"https://duli.nttrip.cn/template_img/template_food/index/picturew2-2.png";s:7:"linkurl";s:0:"";}s:14:"C1545275327783";a:2:{s:6:"imgurl";s:71:"https://duli.nttrip.cn/template_img/template_food/index/picturew2-3.png";s:7:"linkurl";s:0:"";}}s:2:"id";s:8:"picturew";s:5:"index";s:3:"NaN";}s:14:"M1545275449068";a:6:{s:4:"icon";s:23:"iconfont2 icon-daohang1";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:10:{s:9:"margintop";s:1:"6";s:10:"background";s:7:"#ffffff";s:9:"iconcolor";s:7:"#999999";s:9:"textcolor";s:7:"#666666";s:11:"remarkcolor";s:7:"#888888";s:5:"sizew";s:2:"20";s:11:"paddingleft";s:2:"15";s:7:"padding";s:1:"4";s:5:"sizeh";s:2:"20";s:9:"linecolor";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1545275449068";a:5:{s:4:"text";s:12:"招牌推荐";s:7:"linkurl";s:0:"";s:9:"iconclass";s:0:"";s:6:"remark";s:4:"more";s:6:"dotnum";s:0:"";}}s:2:"id";s:8:"listmenu";s:5:"index";s:3:"NaN";}s:14:"M1545275581762";a:6:{s:4:"icon";s:21:"iconfont2 icon-tupian";s:6:"params";a:9:{s:3:"row";s:1:"3";s:8:"showtype";s:1:"0";s:7:"pagenum";s:1:"2";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:8:{s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:7:"showdot";s:1:"0";s:7:"showbtn";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:2:"mt";s:1:"0";s:10:"background";s:7:"#ffffff";}s:4:"data";a:3:{s:14:"C1545275581762";a:2:{s:6:"imgurl";s:71:"https://duli.nttrip.cn/template_img/template_food/index/picturew3-1.png";s:7:"linkurl";s:0:"";}s:14:"C1545275581763";a:2:{s:6:"imgurl";s:71:"https://duli.nttrip.cn/template_img/template_food/index/picturew3-2.png";s:7:"linkurl";s:0:"";}s:14:"C1545275581764";a:2:{s:6:"imgurl";s:71:"https://duli.nttrip.cn/template_img/template_food/index/picturew3-3.png";s:7:"linkurl";s:0:"";}}s:2:"id";s:8:"picturew";s:5:"index";s:3:"NaN";}s:14:"M1545275868484";a:5:{s:4:"icon";s:23:"iconfont2 icon-daohang1";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:10:{s:9:"margintop";s:1:"6";s:10:"background";s:7:"#ffffff";s:9:"iconcolor";s:7:"#999999";s:9:"textcolor";s:7:"#666666";s:11:"remarkcolor";s:7:"#888888";s:5:"sizew";s:2:"20";s:11:"paddingleft";s:2:"15";s:7:"padding";s:1:"4";s:5:"sizeh";s:2:"20";s:9:"linecolor";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1545275868484";a:5:{s:4:"text";s:12:"精选套餐";s:7:"linkurl";s:0:"";s:9:"iconclass";s:0:"";s:6:"remark";s:4:"more";s:6:"dotnum";s:0:"";}}s:2:"id";s:8:"listmenu";}s:14:"M1545275913667";a:5:{s:4:"icon";s:19:"iconfont icon-c-pdf";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:9:"no-repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"1";s:13:"backgroundimg";s:0:"";}s:5:"style";a:6:{s:10:"background";s:7:"#ffffff";s:3:"pdw";s:1:"4";s:3:"pdh";s:1:"4";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";}s:4:"data";a:4:{s:14:"C1545275913667";a:5:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_food/index/classfit1.png";s:5:"title";s:24:"藤椒嫩笋堡薯条餐";s:4:"text";s:5:"30元";s:3:"bg1";s:7:"#ffffff";s:3:"bg2";s:7:"#ffffff";}s:14:"C1545275913668";a:5:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_food/index/classfit2.png";s:5:"title";s:22:"藤椒卷堡3人套餐";s:4:"text";s:5:"69元";s:3:"bg1";s:7:"#ffffff";s:3:"bg2";s:7:"#ffffff";}s:14:"C1545275913669";a:5:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_food/index/classfit3.png";s:5:"title";s:24:"藤椒嫩笋卷辣翅餐";s:4:"text";s:5:"35元";s:3:"bg1";s:7:"#ffffff";s:3:"bg2";s:7:"#ffffff";}s:14:"C1545275913670";a:5:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_food/index/classfit4.png";s:5:"title";s:24:"藤椒嫩笋卷辣翅餐";s:4:"text";s:5:"30元";s:3:"bg1";s:7:"#ffffff";s:3:"bg2";s:7:"#ffffff";}}s:2:"id";s:8:"classfit";}s:14:"M1545276147571";a:7:{s:4:"icon";s:21:"iconfont2 icon-caidan";s:6:"isfoot";s:1:"1";s:3:"max";s:1:"1";s:6:"params";a:8:{s:8:"navstyle";s:1:"0";s:8:"textshow";s:1:"1";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:20:{s:11:"pagebgcolor";s:7:"#f9f9f9";s:7:"bgcolor";s:7:"#ffffff";s:9:"bgcoloron";s:7:"#ffffff";s:9:"iconcolor";s:7:"#000000";s:11:"iconcoloron";s:7:"#ffcc00";s:9:"textcolor";s:7:"#000000";s:11:"textcoloron";s:7:"#ffcc00";s:11:"bordercolor";s:7:"#ffffff";s:13:"bordercoloron";s:7:"#ffffff";s:14:"childtextcolor";s:7:"#666666";s:12:"childbgcolor";s:7:"#f4f4f4";s:16:"childbordercolor";s:7:"#eeeeee";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:11:"paddingleft";s:1:"0";s:10:"paddingtop";s:1:"0";s:8:"iconfont";s:2:"24";s:8:"textfont";s:2:"14";s:3:"bdr";s:1:"0";s:8:"bdrcolor";s:7:"#cccccc";}s:4:"data";a:4:{s:14:"C1545276147571";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_food/index/foot1.png";s:7:"linkurl";s:23:"/sudu8_page/index/index";s:9:"iconclass";s:14:"icon-x-shouye5";s:4:"text";s:6:"首页";s:8:"linktype";s:4:"page";}s:14:"C1545276147572";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_food/index/foot2.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:14:"icon-c-dianpu1";s:4:"text";s:6:"门店";s:8:"linktype";s:4:"page";}s:14:"C1545276147573";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_food/index/foot3.png";s:7:"linkurl";s:33:"/sudu8_page_plugin_food/food/food";s:9:"iconclass";s:16:"icon-x-diangdan4";s:4:"text";s:6:"点餐";s:8:"linktype";s:4:"page";}s:14:"C1545276147574";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_food/index/foot4.png";s:7:"linkurl";s:33:"/sudu8_page/usercenter/usercenter";s:9:"iconclass";s:13:"icon-x-geren1";s:4:"text";s:6:"我的";s:8:"linktype";s:4:"page";}}s:2:"id";s:8:"footmenu";}}';
        $item1 = unserialize($item1);
        foreach($item1 as $k => &$v){
            if($v['data']){
                foreach($v['data'] as $kk => &$vv){
                    if($vv['imgurl'] && strpos($vv['imgurl'],'https://duli.nttrip.cn/') !== false){
                        $vv['imgurl'] = ASSETSS.explode('https://duli.nttrip.cn/', $vv['imgurl'])[1];
                    }
                }
            }
        }
        $page1['items'] = serialize($item1);
        $page1['page'] = 'a:7:{s:10:"background";s:7:"#f1f1f1";s:13:"topbackground";s:7:"#ffcc00";s:8:"topcolor";s:1:"1";s:9:"styledata";s:1:"0";s:5:"title";s:12:"餐饮首页";s:4:"name";s:6:"首页";s:10:"visitlevel";a:2:{s:6:"member";s:0:"";s:10:"commission";s:0:"";}}';
        $page1['tpl_name'] = "首页";

        $page2 = [];
        $page2['uniacid'] = $uniacid;
        $page2['index'] = 0;
        $item2 = 'a:6:{s:14:"M1545293933396";a:6:{s:4:"icon";s:40:"iconfont2 icon-icon_xuanxiangqiayangshi-";s:3:"max";s:1:"2";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:11:{s:10:"background";s:7:"#ffffff";s:5:"color";s:7:"#666666";s:16:"activebackground";s:7:"#ffffff";s:11:"activecolor";s:7:"#ffcc00";s:12:"activeborder";s:7:"#ffcc00";s:7:"padding";s:1:"6";s:11:"paddingleft";s:1:"8";s:2:"mt";s:1:"0";s:9:"scrollnum";s:1:"3";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";}s:4:"data";a:2:{s:14:"C1545293933396";a:2:{s:4:"text";s:12:"品牌故事";s:7:"linkurl";s:0:"";}s:14:"C1545293933397";a:3:{s:4:"text";s:12:"门店导航";s:7:"linkurl";s:23:"/sudu8_page/store/store";s:8:"linktype";s:4:"page";}}s:2:"id";s:6:"tabbar";}s:14:"M1545293752099";a:5:{s:4:"icon";s:28:"iconfont2 icon-tuoyuankaobei";s:6:"params";a:10:{s:5:"totle";s:1:"2";s:8:"navstyle";s:1:"0";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:9:"navstyle2";s:1:"0";s:4:"imgh";s:3:"250";}s:5:"style";a:18:{s:8:"dotstyle";s:5:"round";s:8:"dotalign";s:4:"left";s:10:"paddingtop";s:1:"0";s:11:"paddingleft";s:1:"9";s:10:"background";s:7:"#ffffff";s:13:"backgroundall";s:7:"#ffffff";s:9:"leftright";s:1:"5";s:6:"bottom";s:1:"5";s:7:"opacity";s:3:"0.8";s:10:"text_color";s:4:"#fff";s:2:"bg";s:7:"#000000";s:9:"jsq_color";s:3:"red";s:3:"pdh";s:1:"0";s:3:"pdw";s:1:"0";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:5:"speed";s:1:"5";}s:4:"data";a:2:{s:14:"C1545293752099";a:4:{s:6:"imgurl";s:66:"https://duli.nttrip.cn/template_img/template_food/page/banner1.png";s:7:"linkurl";s:0:"";s:6:"single";s:1:"1";s:4:"text";s:12:"文字描述";}s:14:"C1545293752100";a:4:{s:6:"imgurl";s:66:"https://duli.nttrip.cn/template_img/template_food/page/banner2.png";s:7:"linkurl";s:0:"";s:6:"single";s:1:"2";s:4:"text";s:12:"文字描述";}}s:2:"id";s:6:"banner";}s:14:"M1545288146922";a:5:{s:3:"max";s:1:"5";s:4:"icon";s:23:"iconfont2 icon-fuwenben";s:6:"params";a:1:{s:7:"content";s:608:"PHAgc3R5bGU9ImxpbmUtaGVpZ2h0OiAxLjVlbTsgbWFyZ2luLWJvdHRvbTogMTBweDsiPjxzcGFuIHN0eWxlPSJmb250LXNpemU6IDE4cHg7Ij48c3Ryb25nPuiCr+W+t+Wfujwvc3Ryb25nPjwvc3Bhbj48YnIvPjwvcD48cCBzdHlsZT0ibGluZS1oZWlnaHQ6IDEuNzVlbTsiPjxzcGFuIHN0eWxlPSJjb2xvcjogcmdiKDE2NSwgMTY1LCAxNjUpOyBmb250LXNpemU6IDE0cHg7Ij7mmK/nvo7lm73ot6jlm73ov57plIHppJDljoXkuYvkuIDvvIzkuZ/mmK/kuJbnlYznrKzkuozlpKfpgJ/po5/lj4rmnIDlpKfngrjpuKHov57plIHkvIHkuJrvvIwxOTUy5bm055Sx5Yib5aeL5Lq65ZOI5YWw4oCi5bGx5b635aOr5Yib5bu677yM5Li76KaB5Ye65ZSu54K46bih44CB5rGJ5aCh44CB6Jav5p2h44CB55uW6aWt44CB6JuL5oye44CB5rG95rC0562J6auY54Ot6YeP5b+r6aSQ6aOf5ZOB44CCPC9zcGFuPjwvcD4=";}s:5:"style";a:3:{s:10:"background";s:7:"#ffffff";s:7:"padding";s:2:"18";s:9:"margintop";s:1:"0";}s:2:"id";s:8:"richtext";}s:14:"M1545288892439";a:4:{s:4:"icon";s:32:"iconfont2 icon-liebiao_biaotilan";s:6:"params";a:10:{s:5:"title";s:26:"连锁电话：400-3625870";s:4:"icon";s:15:"icon-x-dianhua5";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:4:"link";s:15:"tel:400-3625870";s:8:"linktype";s:3:"tel";}s:5:"style";a:9:{s:10:"background";s:7:"#ffffff";s:5:"color";s:7:"#808080";s:9:"textalign";s:4:"left";s:8:"fontsize";s:2:"14";s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"23";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:2:"mt";s:1:"0";}s:2:"id";s:5:"title";}s:14:"M1545288895832";a:5:{s:4:"icon";s:32:"iconfont2 icon-liebiao_biaotilan";s:6:"params";a:8:{s:5:"title";s:27:"营业时间：8:00 - 20:00";s:4:"icon";s:15:"icon-x-shijian2";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:9:{s:10:"background";s:7:"#ffffff";s:5:"color";s:7:"#808080";s:9:"textalign";s:4:"left";s:8:"fontsize";s:2:"14";s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"23";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:2:"mt";s:1:"0";}s:2:"id";s:5:"title";s:5:"index";s:3:"NaN";}s:14:"M1545293704299";a:7:{s:4:"icon";s:21:"iconfont2 icon-caidan";s:6:"isfoot";s:1:"1";s:3:"max";s:1:"1";s:6:"params";a:8:{s:8:"navstyle";s:1:"0";s:8:"textshow";s:1:"1";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:20:{s:11:"pagebgcolor";s:7:"#f9f9f9";s:7:"bgcolor";s:7:"#ffffff";s:9:"bgcoloron";s:7:"#ffffff";s:9:"iconcolor";s:7:"#000000";s:11:"iconcoloron";s:7:"#ffcc00";s:9:"textcolor";s:7:"#000000";s:11:"textcoloron";s:7:"#ffcc00";s:11:"bordercolor";s:7:"#cccccc";s:13:"bordercoloron";s:7:"#ffffff";s:14:"childtextcolor";s:7:"#666666";s:12:"childbgcolor";s:7:"#f4f4f4";s:16:"childbordercolor";s:7:"#eeeeee";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:11:"paddingleft";s:1:"0";s:10:"paddingtop";s:1:"0";s:8:"iconfont";s:2:"23";s:8:"textfont";s:2:"12";s:3:"bdr";s:1:"0";s:8:"bdrcolor";s:7:"#cccccc";}s:4:"data";a:4:{s:14:"C1545293704299";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_food/index/foot1.png";s:7:"linkurl";s:23:"/sudu8_page/index/index";s:9:"iconclass";s:14:"icon-x-shouye3";s:4:"text";s:6:"首页";s:8:"linktype";s:4:"page";}s:14:"C1545293704300";a:4:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_food/index/foot2.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:14:"icon-c-dianpu1";s:4:"text";s:6:"门店";}s:14:"C1545293704301";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_food/index/foot3.png";s:7:"linkurl";s:33:"/sudu8_page_plugin_food/food/food";s:9:"iconclass";s:16:"icon-x-diangdan4";s:4:"text";s:6:"点餐";s:8:"linktype";s:4:"page";}s:14:"C1545293704302";a:5:{s:6:"imgurl";s:65:"https://duli.nttrip.cn/template_img/template_food/index/foot4.png";s:7:"linkurl";s:33:"/sudu8_page/usercenter/usercenter";s:9:"iconclass";s:13:"icon-x-geren1";s:4:"text";s:6:"我的";s:8:"linktype";s:4:"page";}}s:2:"id";s:8:"footmenu";}}';
        $item2 = unserialize($item2);
        foreach($item2 as $k => &$v){
            if($v['data']){
                foreach($v['data'] as $kk => &$vv){
                    if($vv['imgurl'] && strpos($vv['imgurl'],'https://duli.nttrip.cn/') !== false){
                        $vv['imgurl'] = ASSETSS.explode('https://duli.nttrip.cn/', $vv['imgurl'])[1];
                    }
                }
            }
        }
        $page2['items'] = serialize($item2);
        $page2['page'] = 'a:7:{s:10:"background";s:7:"#f1f1f1";s:13:"topbackground";s:7:"#ffcc00";s:8:"topcolor";s:1:"1";s:9:"styledata";s:1:"0";s:5:"title";s:6:"门店";s:4:"name";s:6:"门店";s:10:"visitlevel";a:2:{s:6:"member";s:0:"";s:10:"commission";s:0:"";}}';
        $page2['tpl_name'] = "门店";


        pdo_insert("sudu8_page_diypage", $page1);
        $page1_id = pdo_insertid();
        pdo_insert("sudu8_page_diypage", $page2);
        $page2_id = pdo_insertid();
     
        $pageids = $page1_id.",".$page2_id;

        $page1_set = [
        	'pid' => $page1_id,
        	'uniacid' => $uniacid,
        	'kp' => ASSETSS."resource/images/diypage/default/default_start.jpg",
        	'kp_is' => 2,
        	'kp_m' => 2,
        	'tc' => ASSETSS."resource/images/diypage/default/tcgg.jpg",
        	'tc_is' => 2,
        	'foot_is' => 2
        ];
        $page2_set = [
        	'pid' => $page2_id,
        	'uniacid' => $uniacid,
        	'kp' => ASSETSS."resource/images/diypage/default/default_start.jpg",
        	'kp_is' => 2,
        	'kp_m' => 2,
        	'tc' => ASSETSS."resource/images/diypage/default/tcgg.jpg",
        	'tc_is' => 2,
        	'foot_is' => 2
        ];
       
        pdo_insert("sudu8_page_diypageset", $page1_set);
        pdo_insert("sudu8_page_diypageset", $page2_set);
  

        $data = [
            'uniacid' => $uniacid,
            'pageid' => $pageids,
            'template_name' => '餐饮类模板',
            'thumb' => ASSETSS."template_img/template_edu/cover.png",
            'status' => '1',
            'create_time' => time()
        ];
        pdo_insert("sudu8_page_diypagetpl", $data);
    	$tplid = pdo_insertid();
        if($tplid){
            echo $tplid;
        }
    }elseif($id == 'm_travel'){
    	$page1 = [];
        $page1['uniacid'] = $uniacid;
        $page1['index'] = 1;
        $item1 = 'a:12:{s:14:"M1554195434216";a:5:{s:4:"icon";s:28:"iconfont2 icon-tuoyuankaobei";s:6:"params";a:10:{s:5:"totle";s:1:"2";s:8:"navstyle";s:1:"0";s:9:"styledata";s:1:"1";s:6:"repeat";s:9:"no-repeat";s:9:"positionx";s:6:"center";s:9:"positiony";s:6:"center";s:4:"size";s:1:"1";s:13:"backgroundimg";s:71:"https://duli.nttrip.cn/template_img/template_travel/index/banner_bg.png";s:9:"navstyle2";s:1:"0";s:4:"imgh";s:3:"180";}s:5:"style";a:18:{s:8:"dotstyle";s:5:"round";s:8:"dotalign";s:4:"left";s:10:"paddingtop";s:2:"50";s:11:"paddingleft";s:2:"35";s:10:"background";s:7:"#ffffff";s:13:"backgroundall";s:7:"#ffffff";s:9:"leftright";s:1:"5";s:6:"bottom";s:1:"5";s:7:"opacity";s:3:"0.8";s:10:"text_color";s:4:"#fff";s:2:"bg";s:7:"#000000";s:9:"jsq_color";s:3:"red";s:3:"pdh";s:1:"0";s:3:"pdw";s:1:"0";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:5:"speed";s:1:"5";}s:4:"data";a:3:{s:14:"C1554195434217";a:4:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_travel/index/banner1.png";s:7:"linkurl";s:0:"";s:6:"single";s:1:"1";s:4:"text";s:12:"文字描述";}s:14:"C1554195434218";a:4:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_travel/index/banner2.png";s:7:"linkurl";s:0:"";s:6:"single";s:1:"2";s:4:"text";s:12:"文字描述";}s:14:"M1554195630103";a:4:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_travel/index/banner3.png";s:7:"linkurl";s:0:"";s:6:"single";s:1:"1";s:4:"text";s:12:"文字描述";}}s:2:"id";s:6:"banner";}s:14:"M1554196897428";a:5:{s:4:"icon";s:22:"iconfont2 icon-anniuzu";s:6:"params";a:8:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:7:"picicon";s:1:"1";s:8:"textshow";s:1:"1";}s:5:"style";a:14:{s:8:"navstyle";s:0:"";s:10:"background";s:7:"#ffffff";s:6:"rownum";s:1:"4";s:8:"showtype";s:1:"0";s:7:"pagenum";s:1:"8";s:7:"showdot";s:1:"1";s:7:"padding";s:1:"0";s:11:"paddingleft";s:2:"10";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:6:"iconfz";s:2:"14";s:9:"iconcolor";s:7:"#434343";s:8:"imgwidth";s:2:"30";}s:4:"data";a:4:{s:14:"C1554196897428";a:6:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_travel/index/menu1.png";s:7:"linkurl";s:0:"";s:4:"text";s:12:"专属向导";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";s:9:"iconclass";s:14:"icon-x-shouye2";}s:14:"C1554196897429";a:6:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_travel/index/menu2.png";s:7:"linkurl";s:0:"";s:4:"text";s:12:"住在桂林";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";s:9:"iconclass";s:14:"icon-x-shouye2";}s:14:"C1554196897430";a:6:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_travel/index/menu3.png";s:7:"linkurl";s:0:"";s:4:"text";s:12:"吃在桂林";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";s:9:"iconclass";s:14:"icon-x-shouye2";}s:14:"C1554196897431";a:6:{s:6:"imgurl";s:67:"https://duli.nttrip.cn/template_img/template_travel/index/menu4.png";s:7:"linkurl";s:0:"";s:4:"text";s:12:"订购门票";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";s:9:"iconclass";s:14:"icon-x-shouye2";}}s:2:"id";s:4:"menu";}s:14:"M1554197194229";a:5:{s:4:"icon";s:22:"iconfont2 icon-gonggao";s:6:"params";a:12:{s:7:"iconurl";s:15:"icon-x-gonggao5";s:10:"noticedata";s:1:"0";s:5:"speed";s:1:"4";s:9:"noticenum";s:1:"5";s:8:"navstyle";s:1:"1";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:8:"sourceid";s:0:"";}s:5:"style";a:9:{s:10:"background";s:7:"#ffffff";s:9:"iconcolor";s:7:"#fd5454";s:5:"color";s:7:"#666666";s:11:"bordercolor";s:7:"#e2e2e2";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";}s:4:"data";a:2:{s:14:"C1554197194229";a:2:{s:5:"title";s:42:"这里是第一条自定义公告的标题";s:7:"linkurl";s:0:"";}s:14:"C1554197194230";a:2:{s:5:"title";s:42:"这里是第二条自定义公告的标题";s:7:"linkurl";s:0:"";}}s:2:"id";s:6:"notice";}s:14:"M1554197223649";a:5:{s:4:"icon";s:19:"iconfont2 icon-zutu";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:6:{s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:2:"mt";s:2:"10";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"background";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1554197223649";a:3:{s:6:"imgurl";s:72:"https://duli.nttrip.cn/template_img/template_travel/index/picture1_1.png";s:7:"linkurl";s:34:"/sudu8_page/index/index?pageid=226";s:8:"linktype";s:4:"page";}}s:2:"id";s:7:"picture";}s:14:"M1554197522751";a:5:{s:4:"icon";s:23:"iconfont2 icon-daohang1";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:10:{s:9:"margintop";s:2:"10";s:10:"background";s:7:"#ffffff";s:9:"iconcolor";s:7:"#999999";s:9:"textcolor";s:7:"#666666";s:11:"remarkcolor";s:7:"#888888";s:5:"sizew";s:2:"20";s:11:"paddingleft";s:2:"10";s:7:"padding";s:1:"5";s:5:"sizeh";s:2:"20";s:9:"linecolor";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1554197522751";a:5:{s:4:"text";s:12:"特产热卖";s:7:"linkurl";s:0:"";s:9:"iconclass";s:0:"";s:6:"remark";s:0:"";s:6:"dotnum";s:0:"";}}s:2:"id";s:8:"listmenu";}s:14:"M1554197601280";a:5:{s:4:"icon";s:22:"iconfont2 icon-chanpin";s:6:"params";a:31:{s:11:"goodsscroll";s:1:"0";s:9:"showtitle";s:1:"1";s:9:"showprice";s:1:"1";s:7:"showtag";s:1:"0";s:9:"goodsdata";s:1:"1";s:6:"cateid";s:0:"";s:8:"catename";s:0:"";s:7:"groupid";s:0:"";s:9:"groupname";s:0:"";s:9:"goodssort";s:1:"0";s:8:"goodsnum";s:1:"6";s:8:"showicon";s:1:"0";s:12:"iconposition";s:8:"left top";s:12:"productprice";s:1:"1";s:16:"showproductprice";s:1:"0";s:9:"showsales";s:1:"1";s:16:"productpricetext";s:6:"原价";s:9:"salestext";s:6:"销量";s:16:"productpriceline";s:1:"0";s:7:"saleout";s:1:"0";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:7:"imgh_is";s:1:"1";s:4:"imgh";s:3:"100";s:7:"con_key";s:1:"1";s:8:"con_type";s:1:"1";s:8:"sourceid";s:0:"";}s:5:"style";a:20:{s:10:"background";s:7:"#ffffff";s:9:"liststyle";s:5:"block";s:8:"buystyle";s:0:"";s:9:"goodsicon";s:9:"recommand";s:9:"iconstyle";s:8:"triangle";s:10:"pricecolor";s:7:"#ff5555";s:17:"productpricecolor";s:7:"#999999";s:14:"iconpaddingtop";s:1:"0";s:15:"iconpaddingleft";s:1:"0";s:11:"buybtncolor";s:7:"#ff5555";s:8:"iconzoom";s:2:"50";s:10:"titlecolor";s:7:"#000000";s:13:"tagbackground";s:7:"#fe5455";s:10:"salescolor";s:7:"#999999";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"paddingtop";s:1:"5";s:11:"paddingleft";s:2:"10";s:8:"showtype";s:1:"0";}s:4:"data";a:4:{s:14:"C1554197601280";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"title";s:21:"这里是产品标题";s:5:"sales";s:1:"5";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"1";s:3:"des";s:21:"这里是产品描述";}s:14:"C1554197601281";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"title";s:21:"这里是产品标题";s:5:"sales";s:1:"5";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"1";s:4:"desc";s:21:"这里是产品描述";}s:14:"C1554197601282";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"sales";s:1:"5";s:5:"title";s:21:"这里是产品标题";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"0";s:4:"desc";s:21:"这里是产品描述";}s:14:"C1554197601283";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"sales";s:1:"5";s:5:"title";s:21:"这里是产品标题";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"0";s:4:"desc";s:21:"这里是产品描述";}}s:2:"id";s:5:"goods";}s:14:"M1554197512364";a:4:{s:4:"icon";s:32:"iconfont2 icon-liebiao_biaotilan";s:6:"params";a:8:{s:5:"title";s:12:"玩在桂林";s:4:"icon";s:0:"";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:9:{s:10:"background";s:7:"#ffffff";s:5:"color";s:7:"#666666";s:9:"textalign";s:4:"left";s:8:"fontsize";s:2:"14";s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:2:"mt";s:2:"10";}s:2:"id";s:5:"title";}s:14:"M1554283977623";a:5:{s:4:"icon";s:21:"iconfont2 icon-tupian";s:6:"params";a:9:{s:3:"row";s:1:"2";s:8:"showtype";s:1:"0";s:7:"pagenum";s:1:"2";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:8:{s:10:"paddingtop";s:1:"8";s:11:"paddingleft";s:1:"8";s:7:"showdot";s:1:"0";s:7:"showbtn";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:2:"mt";s:1:"0";s:10:"background";s:7:"#ffffff";}s:4:"data";a:4:{s:14:"C1554283977623";a:2:{s:6:"imgurl";s:71:"https://duli.nttrip.cn/template_img/template_travel/index/picturew1.png";s:7:"linkurl";s:0:"";}s:14:"C1554283977624";a:2:{s:6:"imgurl";s:71:"https://duli.nttrip.cn/template_img/template_travel/index/picturew2.png";s:7:"linkurl";s:0:"";}s:14:"C1554283977625";a:2:{s:6:"imgurl";s:71:"https://duli.nttrip.cn/template_img/template_travel/index/picturew3.png";s:7:"linkurl";s:0:"";}s:14:"C1554283977626";a:2:{s:6:"imgurl";s:71:"https://duli.nttrip.cn/template_img/template_travel/index/picturew4.png";s:7:"linkurl";s:0:"";}}s:2:"id";s:8:"picturew";}s:14:"M1554284025822";a:6:{s:4:"icon";s:19:"iconfont2 icon-zutu";s:6:"params";a:6:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:6:{s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:2:"mt";s:2:"10";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"background";s:7:"#ffffff";}s:4:"data";a:1:{s:14:"C1554284025822";a:2:{s:6:"imgurl";s:72:"https://duli.nttrip.cn/template_img/template_travel/index/picture2_1.png";s:7:"linkurl";s:0:"";}}s:2:"id";s:7:"picture";s:5:"index";s:3:"NaN";}s:14:"M1554284038143";a:4:{s:4:"icon";s:32:"iconfont2 icon-liebiao_biaotilan";s:6:"params";a:8:{s:5:"title";s:20:"— 我们承诺 —";s:4:"icon";s:0:"";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:9:{s:10:"background";s:7:"#ffffff";s:5:"color";s:7:"#949494";s:9:"textalign";s:6:"center";s:8:"fontsize";s:2:"14";s:10:"paddingtop";s:1:"5";s:11:"paddingleft";s:2:"10";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:2:"mt";s:1:"0";}s:2:"id";s:5:"title";}s:14:"M1554284099976";a:5:{s:4:"icon";s:19:"iconfont2 icon-fuwu";s:6:"params";a:10:{s:8:"hidetext";s:1:"0";s:8:"showtype";s:1:"0";s:6:"rownum";s:1:"3";s:7:"showbtn";s:1:"0";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:12:{s:10:"background";s:7:"#ffffff";s:10:"paddingtop";s:1:"3";s:11:"paddingleft";s:2:"10";s:6:"iconfz";s:2:"16";s:7:"tbcolor";s:7:"#9ac2cf";s:5:"color";s:7:"#888888";s:4:"tbbg";s:0:"";s:3:"pdl";s:1:"5";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:8:"fontsize";s:2:"12";}s:4:"data";a:3:{s:14:"C1554284099976";a:2:{s:9:"iconclass";s:12:"icon-x-gouwu";s:4:"text";s:12:"拒绝购物";}s:14:"C1554284099977";a:2:{s:9:"iconclass";s:15:"icon-c-shangjia";s:4:"text";s:12:"认证保障";}s:14:"C1554284099978";a:2:{s:9:"iconclass";s:11:"icon-x-kefu";s:4:"text";s:12:"售后无忧";}}s:2:"id";s:4:"dnfw";}s:14:"M1556422688804";a:7:{s:4:"icon";s:21:"iconfont2 icon-caidan";s:6:"isfoot";s:1:"1";s:3:"max";s:1:"1";s:6:"params";a:8:{s:8:"navstyle";s:1:"1";s:8:"textshow";s:1:"1";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:20:{s:11:"pagebgcolor";s:7:"#f9f9f9";s:7:"bgcolor";s:7:"#ffffff";s:9:"bgcoloron";s:7:"#ffffff";s:9:"iconcolor";s:7:"#999999";s:11:"iconcoloron";s:7:"#999999";s:9:"textcolor";s:7:"#808080";s:11:"textcoloron";s:7:"#666666";s:11:"bordercolor";s:7:"#cccccc";s:13:"bordercoloron";s:7:"#ffffff";s:14:"childtextcolor";s:7:"#666666";s:12:"childbgcolor";s:7:"#f4f4f4";s:16:"childbordercolor";s:7:"#eeeeee";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:11:"paddingleft";s:1:"0";s:10:"paddingtop";s:1:"0";s:8:"iconfont";s:2:"27";s:8:"textfont";s:2:"12";s:3:"bdr";s:1:"0";s:8:"bdrcolor";s:7:"#cccccc";}s:4:"data";a:4:{s:14:"C1556422688805";a:4:{s:6:"imgurl";s:73:"https://duli.nttrip.cn/template_img/template_travel/index/footmenu1_1.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:14:"icon-x-shouye2";s:4:"text";s:6:"首页";}s:14:"C1556422688806";a:4:{s:6:"imgurl";s:73:"https://duli.nttrip.cn/template_img/template_travel/index/footmenu2_1.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:15:"icon-x-chanpin2";s:4:"text";s:9:"特产店";}s:14:"C1556422688807";a:4:{s:6:"imgurl";s:73:"https://duli.nttrip.cn/template_img/template_travel/index/footmenu3_1.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:14:"icon-x-liebiao";s:4:"text";s:12:"出行头条";}s:14:"C1556422688808";a:4:{s:6:"imgurl";s:73:"https://duli.nttrip.cn/template_img/template_travel/index/footmenu4_1.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:13:"icon-x-geren2";s:4:"text";s:6:"我的";}}s:2:"id";s:8:"footmenu";}}';
        $item1 = unserialize($item1);
        foreach($item1 as $k => &$v){
            if($v['data']){
                foreach($v['data'] as $kk => &$vv){
                    if($vv['imgurl'] && strpos($vv['imgurl'],'https://duli.nttrip.cn/') !== false){
                        $vv['imgurl'] = ASSETSS.explode('https://duli.nttrip.cn/', $vv['imgurl'])[1];
                    }
                }
            }
        }
        $page1['items'] = serialize($item1);
        $page1['page'] = 'a:7:{s:10:"background";s:7:"#f1f1f1";s:13:"topbackground";s:7:"#ffa844";s:8:"topcolor";s:1:"2";s:9:"styledata";s:1:"0";s:5:"title";s:6:"首页";s:4:"name";s:6:"首页";s:10:"visitlevel";a:2:{s:6:"member";s:0:"";s:10:"commission";s:0:"";}}';
        $page1['tpl_name'] = "首页";

        $page2 = [];
        $page2['uniacid'] = $uniacid;
        $page2['index'] = 0;
        $item2 = 'a:1:{s:14:"M1554281037772";a:5:{s:3:"max";s:1:"1";s:4:"icon";s:23:"iconfont2 icon-8636f874";s:6:"params";a:10:{s:8:"navstyle";s:1:"1";s:9:"styledata";s:1:"0";s:13:"backgroundimg";s:0:"";s:7:"btntext";s:6:"提交";s:4:"tslx";s:1:"0";s:6:"repeat";s:1:"0";s:9:"positionx";s:1:"0";s:9:"positiony";s:1:"0";s:4:"size";s:1:"0";s:8:"sourceid";s:0:"";}s:5:"style";a:17:{s:10:"background";s:7:"#ffffff";s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:12:"inputbgcolor";s:7:"#ffffff";s:10:"inputcolor";s:7:"#000000";s:7:"inputmt";s:2:"10";s:12:"borderradius";s:1:"3";s:11:"bordercolor";s:4:"#eee";s:15:"btnborderradius";s:2:"30";s:8:"btncolor";s:7:"#ffffff";s:10:"btnbgcolor";s:7:"#ffbc55";s:13:"btnpaddingtop";s:2:"10";s:12:"btnmargintop";s:2:"15";s:14:"btnmarginright";s:2:"10";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";}s:2:"id";s:8:"feedback";}}';
        $item2 = unserialize($item2);
        foreach($item2 as $k => &$v){
            if($v['data']){
                foreach($v['data'] as $kk => &$vv){
                    if($vv['imgurl'] && strpos($vv['imgurl'],'https://duli.nttrip.cn/') !== false){
                        $vv['imgurl'] = ASSETSS.explode('https://duli.nttrip.cn/', $vv['imgurl'])[1];
                    }
                }
            }
        }
        $page2['items'] = serialize($item2);
        $page2['page'] = 'a:7:{s:10:"background";s:7:"#f1f1f1";s:13:"topbackground";s:7:"#ffa844";s:8:"topcolor";s:1:"2";s:9:"styledata";s:1:"0";s:5:"title";s:12:"专属包车";s:4:"name";s:12:"专属包车";s:10:"visitlevel";a:2:{s:6:"member";s:0:"";s:10:"commission";s:0:"";}}';
        $page2['tpl_name'] = "专属包车";

        $page3 = [];
        $page3['uniacid'] = $uniacid;
        $page4['index'] = 0;
        $item3 = 'a:1:{s:14:"M1554284275665";a:4:{s:4:"icon";s:19:"iconfont2 icon-zutu";s:6:"params";a:7:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:12:"content_type";s:1:"1";}s:5:"style";a:7:{s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"background";s:7:"#ffffff";s:9:"viewcount";s:2:"10";}s:2:"id";s:5:"mlist";}}';
        $item3 = unserialize($item3);
        foreach($item3 as $k => &$v){
            if($v['data']){
                foreach($v['data'] as $kk => &$vv){
                    if($vv['imgurl'] && strpos($vv['imgurl'],'https://duli.nttrip.cn/') !== false){
                        $vv['imgurl'] = ASSETSS.explode('https://duli.nttrip.cn/', $vv['imgurl'])[1];
                    }
                }
            }
        }
        $page3['items'] = serialize($item3);
        $page3['page'] = 'a:7:{s:10:"background";s:7:"#f1f1f1";s:13:"topbackground";s:7:"#ffa844";s:8:"topcolor";s:1:"2";s:9:"styledata";s:1:"0";s:5:"title";s:9:"特产店";s:4:"name";s:9:"特产店";s:10:"visitlevel";a:2:{s:6:"member";s:0:"";s:10:"commission";s:0:"";}}';
        $page3['tpl_name'] = "特产店";

        pdo_insert("sudu8_page_diypage", $page1);
        $page1_id = pdo_insertid();
        pdo_insert("sudu8_page_diypage", $page2);
        $page2_id = pdo_insertid();
        pdo_insert("sudu8_page_diypage", $page3);
        $page3_id = pdo_insertid();
     
        $pageids = $page1_id.",".$page2_id.",".$page3_id;

        $page1_set = [
        	'pid' => $page1_id,
        	'uniacid' => $uniacid,
        	'kp' => ASSETSS."resource/images/diypage/default/default_start.jpg",
        	'kp_is' => 2,
        	'kp_m' => 2,
        	'tc' => ASSETSS."resource/images/diypage/default/tcgg.jpg",
        	'tc_is' => 2,
        	'foot_is' => 2
        ];
        $page2_set = [
        	'pid' => $page2_id,
        	'uniacid' => $uniacid,
        	'kp' => ASSETSS."resource/images/diypage/default/default_start.jpg",
        	'kp_is' => 2,
        	'kp_m' => 2,
        	'tc' => ASSETSS."resource/images/diypage/default/tcgg.jpg",
        	'tc_is' => 2,
        	'foot_is' => 2
        ];
        $page3_set = [
        	'pid' => $page3_id,
        	'uniacid' => $uniacid,
        	'kp' => ASSETSS."resource/images/diypage/default/default_start.jpg",
        	'kp_is' => 2,
        	'kp_m' => 2,
        	'tc' => ASSETSS."resource/images/diypage/default/tcgg.jpg",
        	'tc_is' => 2,
        	'foot_is' => 2
        ];
       
        pdo_insert("sudu8_page_diypageset", $page1_set);
        pdo_insert("sudu8_page_diypageset", $page2_set);
        pdo_insert("sudu8_page_diypageset", $page3_set);
  

        $data = [
            'uniacid' => $uniacid,
            'pageid' => $pageids,
            'template_name' => '旅游类模板',
            'thumb' => ASSETSS."template_img/template_travel/cover.png",
            'status' => '1',
            'create_time' => time()
        ];
        pdo_insert("sudu8_page_diypagetpl", $data);
    	$tplid = pdo_insertid();
        if($tplid){
            echo $tplid;
        }
    }elseif($id == 'm_retail'){
    	$page1 = [];
        $page1['uniacid'] = $uniacid;
        $page1['index'] = 1;
        $item1 = 'a:11:{s:14:"M1548408513705";a:5:{s:4:"icon";s:28:"iconfont2 icon-tuoyuankaobei";s:6:"params";a:10:{s:5:"totle";s:1:"2";s:8:"navstyle";s:1:"0";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:9:"navstyle2";s:1:"0";s:4:"imgh";s:3:"150";}s:5:"style";a:18:{s:8:"dotstyle";s:5:"round";s:8:"dotalign";s:4:"left";s:10:"paddingtop";s:1:"0";s:11:"paddingleft";s:2:"15";s:10:"background";s:7:"#ffffff";s:13:"backgroundall";s:7:"#ffffff";s:9:"leftright";s:1:"5";s:6:"bottom";s:1:"5";s:7:"opacity";s:1:"0";s:10:"text_color";s:4:"#fff";s:2:"bg";s:7:"#000000";s:9:"jsq_color";s:3:"red";s:3:"pdh";s:1:"0";s:3:"pdw";s:1:"0";s:2:"mt";s:1:"4";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:5:"speed";s:1:"5";}s:4:"data";a:2:{s:14:"C1548408513705";a:4:{s:6:"imgurl";s:71:"https://duli.nttrip.cn/template_img/template_retail/index/banner1_1.jpg";s:7:"linkurl";s:0:"";s:6:"single";s:1:"1";s:4:"text";s:12:"文字描述";}s:14:"C1548408513706";a:4:{s:6:"imgurl";s:71:"https://duli.nttrip.cn/template_img/template_retail/index/banner1_2.jpg";s:7:"linkurl";s:0:"";s:6:"single";s:1:"2";s:4:"text";s:12:"文字描述";}}s:2:"id";s:6:"banner";}s:14:"M1548408517561";a:5:{s:4:"icon";s:22:"iconfont2 icon-anniuzu";s:6:"params";a:8:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:7:"picicon";s:1:"1";s:8:"textshow";s:1:"2";}s:5:"style";a:14:{s:8:"navstyle";s:0:"";s:10:"background";s:7:"#ffffff";s:6:"rownum";s:1:"4";s:8:"showtype";s:1:"0";s:7:"pagenum";s:1:"8";s:7:"showdot";s:1:"1";s:7:"padding";s:1:"0";s:11:"paddingleft";s:2:"10";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:6:"iconfz";s:2:"14";s:9:"iconcolor";s:7:"#434343";s:8:"imgwidth";s:2:"64";}s:4:"data";a:4:{s:14:"C1548408517561";a:5:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_retail/index/menu1_1.png";s:7:"linkurl";s:0:"";s:4:"text";s:13:"按钮文字1";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";}s:14:"C1548408517562";a:5:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_retail/index/menu1_2.png";s:7:"linkurl";s:0:"";s:4:"text";s:13:"按钮文字2";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";}s:14:"C1548408517563";a:5:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_retail/index/menu1_3.png";s:7:"linkurl";s:0:"";s:4:"text";s:13:"按钮文字3";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";}s:14:"C1548408517564";a:5:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_retail/index/menu1_4.png";s:7:"linkurl";s:0:"";s:4:"text";s:13:"按钮文字4";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";}}s:2:"id";s:4:"menu";}s:14:"M1548408542818";a:6:{s:4:"icon";s:28:"iconfont2 icon-tuoyuankaobei";s:6:"params";a:10:{s:5:"totle";s:1:"2";s:8:"navstyle";s:1:"0";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:9:"navstyle2";s:1:"0";s:4:"imgh";s:2:"90";}s:5:"style";a:18:{s:8:"dotstyle";s:5:"round";s:8:"dotalign";s:4:"left";s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:10:"background";s:7:"#ffffff";s:13:"backgroundall";s:7:"#ffffff";s:9:"leftright";s:1:"5";s:6:"bottom";s:1:"5";s:7:"opacity";s:1:"0";s:10:"text_color";s:4:"#fff";s:2:"bg";s:7:"#000000";s:9:"jsq_color";s:3:"red";s:3:"pdh";s:1:"0";s:3:"pdw";s:1:"0";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:5:"speed";s:1:"5";}s:4:"data";a:1:{s:14:"C1548408542818";a:4:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_retail/index/banner2.png";s:7:"linkurl";s:0:"";s:6:"single";s:1:"1";s:4:"text";s:12:"文字描述";}}s:2:"id";s:6:"banner";s:5:"index";s:3:"NaN";}s:14:"M1548408545249";a:6:{s:4:"icon";s:22:"iconfont2 icon-anniuzu";s:6:"params";a:8:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:7:"picicon";s:1:"1";s:8:"textshow";s:1:"1";}s:5:"style";a:14:{s:8:"navstyle";s:0:"";s:10:"background";s:7:"#ffffff";s:6:"rownum";s:1:"4";s:8:"showtype";s:1:"0";s:7:"pagenum";s:1:"8";s:7:"showdot";s:1:"1";s:7:"padding";s:1:"0";s:11:"paddingleft";s:2:"10";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:6:"iconfz";s:2:"14";s:9:"iconcolor";s:7:"#434343";s:8:"imgwidth";s:2:"50";}s:4:"data";a:4:{s:14:"C1548408545249";a:5:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_retail/index/menu2_1.jpg";s:7:"linkurl";s:0:"";s:4:"text";s:12:"主题美食";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";}s:14:"C1548408545250";a:5:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_retail/index/menu2_2.jpg";s:7:"linkurl";s:0:"";s:4:"text";s:12:"美味寿司";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";}s:14:"C1548408545251";a:5:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_retail/index/menu2_3.jpg";s:7:"linkurl";s:0:"";s:4:"text";s:12:"能量西餐";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";}s:14:"C1548408545252";a:5:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_retail/index/menu2_4.jpg";s:7:"linkurl";s:0:"";s:4:"text";s:12:"蛋糕烘焙";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";}}s:2:"id";s:4:"menu";s:5:"index";s:3:"NaN";}s:14:"M1548408545594";a:6:{s:4:"icon";s:22:"iconfont2 icon-anniuzu";s:6:"params";a:8:{s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:7:"picicon";s:1:"1";s:8:"textshow";s:1:"1";}s:5:"style";a:14:{s:8:"navstyle";s:0:"";s:10:"background";s:7:"#ffffff";s:6:"rownum";s:1:"4";s:8:"showtype";s:1:"0";s:7:"pagenum";s:1:"8";s:7:"showdot";s:1:"1";s:7:"padding";s:1:"0";s:11:"paddingleft";s:2:"10";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:6:"iconfz";s:2:"14";s:9:"iconcolor";s:7:"#434343";s:8:"imgwidth";s:2:"50";}s:4:"data";a:4:{s:14:"C1548408545594";a:5:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_retail/index/menu2_5.jpg";s:7:"linkurl";s:0:"";s:4:"text";s:12:"日本料理";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";}s:14:"C1548408545595";a:5:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_retail/index/menu2_6.jpg";s:7:"linkurl";s:0:"";s:4:"text";s:12:"奶茶饮品";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";}s:14:"C1548408545596";a:5:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_retail/index/menu2_7.jpg";s:7:"linkurl";s:0:"";s:4:"text";s:15:"甜品下午茶";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";}s:14:"C1548408545597";a:5:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_retail/index/menu2_8.jpg";s:7:"linkurl";s:0:"";s:4:"text";s:12:"舌尖烤肉";s:5:"color";s:7:"#666666";s:4:"icon";s:14:"icon-x-shouye2";}}s:2:"id";s:4:"menu";s:5:"index";s:3:"NaN";}s:14:"M1548408562807";a:6:{s:4:"icon";s:28:"iconfont2 icon-tuoyuankaobei";s:6:"params";a:10:{s:5:"totle";s:1:"2";s:8:"navstyle";s:1:"0";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:9:"navstyle2";s:1:"0";s:4:"imgh";s:2:"90";}s:5:"style";a:18:{s:8:"dotstyle";s:5:"round";s:8:"dotalign";s:4:"left";s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:10:"background";s:7:"#ffffff";s:13:"backgroundall";s:7:"#ffffff";s:9:"leftright";s:1:"5";s:6:"bottom";s:1:"5";s:7:"opacity";s:1:"0";s:10:"text_color";s:4:"#fff";s:2:"bg";s:7:"#000000";s:9:"jsq_color";s:3:"red";s:3:"pdh";s:1:"0";s:3:"pdw";s:1:"0";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:5:"speed";s:1:"5";}s:4:"data";a:1:{s:14:"C1548408562807";a:4:{s:6:"imgurl";s:69:"https://duli.nttrip.cn/template_img/template_retail/index/banner3.png";s:7:"linkurl";s:0:"";s:6:"single";s:1:"1";s:4:"text";s:12:"文字描述";}}s:2:"id";s:6:"banner";s:5:"index";s:3:"NaN";}s:14:"M1548409151424";a:4:{s:4:"icon";s:32:"iconfont2 icon-liebiao_biaotilan";s:6:"params";a:8:{s:5:"title";s:36:"网红馆—人气美食都在这儿";s:4:"icon";s:0:"";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:9:{s:10:"background";s:7:"#ffffff";s:5:"color";s:7:"#666666";s:9:"textalign";s:6:"center";s:8:"fontsize";s:2:"17";s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:2:"mt";s:1:"0";}s:2:"id";s:5:"title";}s:14:"M1556418793802";a:5:{s:4:"icon";s:22:"iconfont2 icon-chanpin";s:6:"params";a:31:{s:11:"goodsscroll";s:1:"0";s:9:"showtitle";s:1:"1";s:9:"showprice";s:1:"1";s:7:"showtag";s:1:"0";s:9:"goodsdata";s:1:"1";s:6:"cateid";s:0:"";s:8:"catename";s:0:"";s:7:"groupid";s:0:"";s:9:"groupname";s:0:"";s:9:"goodssort";s:1:"0";s:8:"goodsnum";s:1:"6";s:8:"showicon";s:1:"1";s:12:"iconposition";s:8:"left top";s:12:"productprice";s:1:"1";s:16:"showproductprice";s:1:"0";s:9:"showsales";s:1:"1";s:16:"productpricetext";s:6:"原价";s:9:"salestext";s:6:"销量";s:16:"productpriceline";s:1:"0";s:7:"saleout";s:1:"0";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:7:"imgh_is";s:1:"1";s:4:"imgh";s:3:"100";s:7:"con_key";s:1:"1";s:8:"con_type";s:1:"1";s:8:"sourceid";s:0:"";}s:5:"style";a:20:{s:10:"background";s:7:"#ffffff";s:9:"liststyle";s:5:"block";s:8:"buystyle";s:0:"";s:9:"goodsicon";s:9:"recommand";s:9:"iconstyle";s:6:"circle";s:10:"pricecolor";s:7:"#ff5555";s:17:"productpricecolor";s:7:"#999999";s:14:"iconpaddingtop";s:1:"0";s:15:"iconpaddingleft";s:1:"0";s:11:"buybtncolor";s:7:"#ff5555";s:8:"iconzoom";s:2:"50";s:10:"titlecolor";s:7:"#000000";s:13:"tagbackground";s:7:"#fe5455";s:10:"salescolor";s:7:"#999999";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:8:"showtype";s:1:"0";}s:4:"data";a:4:{s:14:"C1556418793802";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"title";s:21:"这里是产品标题";s:5:"sales";s:1:"5";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"1";s:3:"des";s:21:"这里是产品描述";}s:14:"C1556418793803";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"title";s:21:"这里是产品标题";s:5:"sales";s:1:"5";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"1";s:4:"desc";s:21:"这里是产品描述";}s:14:"C1556418793804";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"sales";s:1:"5";s:5:"title";s:21:"这里是产品标题";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"0";s:4:"desc";s:21:"这里是产品描述";}s:14:"C1556418793805";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"sales";s:1:"5";s:5:"title";s:21:"这里是产品标题";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"0";s:4:"desc";s:21:"这里是产品描述";}}s:2:"id";s:5:"goods";}s:14:"M1548409277319";a:5:{s:4:"icon";s:32:"iconfont2 icon-liebiao_biaotilan";s:6:"params";a:8:{s:5:"title";s:33:"爆品馆—颜控吃货请打卡";s:4:"icon";s:0:"";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:9:{s:10:"background";s:7:"#ffffff";s:5:"color";s:7:"#666666";s:9:"textalign";s:6:"center";s:8:"fontsize";s:2:"17";s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:2:"mt";s:1:"0";}s:2:"id";s:5:"title";s:5:"index";s:3:"NaN";}s:14:"M1556418806849";a:6:{s:4:"icon";s:22:"iconfont2 icon-chanpin";s:6:"params";a:31:{s:11:"goodsscroll";s:1:"0";s:9:"showtitle";s:1:"1";s:9:"showprice";s:1:"1";s:7:"showtag";s:1:"0";s:9:"goodsdata";s:1:"1";s:6:"cateid";s:0:"";s:8:"catename";s:0:"";s:7:"groupid";s:0:"";s:9:"groupname";s:0:"";s:9:"goodssort";s:1:"0";s:8:"goodsnum";s:1:"6";s:8:"showicon";s:1:"1";s:12:"iconposition";s:8:"left top";s:12:"productprice";s:1:"1";s:16:"showproductprice";s:1:"0";s:9:"showsales";s:1:"1";s:16:"productpricetext";s:6:"原价";s:9:"salestext";s:6:"销量";s:16:"productpriceline";s:1:"0";s:7:"saleout";s:1:"0";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";s:7:"imgh_is";s:1:"1";s:4:"imgh";s:3:"100";s:7:"con_key";s:1:"1";s:8:"con_type";s:1:"1";s:8:"sourceid";s:0:"";}s:5:"style";a:20:{s:10:"background";s:7:"#ffffff";s:9:"liststyle";s:5:"block";s:8:"buystyle";s:0:"";s:9:"goodsicon";s:7:"hotsale";s:9:"iconstyle";s:6:"circle";s:10:"pricecolor";s:7:"#ff5555";s:17:"productpricecolor";s:7:"#999999";s:14:"iconpaddingtop";s:1:"0";s:15:"iconpaddingleft";s:1:"0";s:11:"buybtncolor";s:7:"#ff5555";s:8:"iconzoom";s:2:"50";s:10:"titlecolor";s:7:"#000000";s:13:"tagbackground";s:7:"#fe5455";s:10:"salescolor";s:7:"#999999";s:2:"mt";s:1:"0";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:10:"paddingtop";s:2:"10";s:11:"paddingleft";s:2:"10";s:8:"showtype";s:1:"0";}s:4:"data";a:4:{s:14:"C1556418806849";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"title";s:21:"这里是产品标题";s:5:"sales";s:1:"5";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"1";s:3:"des";s:21:"这里是产品描述";}s:14:"C1556418806850";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"title";s:21:"这里是产品标题";s:5:"sales";s:1:"5";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"1";s:4:"desc";s:21:"这里是产品描述";}s:14:"C1556418806851";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"sales";s:1:"5";s:5:"title";s:21:"这里是产品标题";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"0";s:4:"desc";s:21:"这里是产品描述";}s:14:"C1556418806852";a:10:{s:5:"thumb";s:46:"/diypage/resource/images/diypage/default/2.jpg";s:5:"price";s:5:"20.00";s:12:"productprice";s:5:"99.00";s:5:"sales";s:1:"5";s:5:"title";s:21:"这里是产品标题";s:3:"gid";s:0:"";s:7:"bargain";s:1:"0";s:6:"credit";s:1:"0";s:5:"ctype";s:1:"0";s:4:"desc";s:21:"这里是产品描述";}}s:2:"id";s:5:"goods";s:5:"index";s:3:"NaN";}s:14:"M1548726169447";a:7:{s:4:"icon";s:21:"iconfont2 icon-caidan";s:6:"isfoot";s:1:"1";s:3:"max";s:1:"1";s:6:"params";a:8:{s:8:"navstyle";s:1:"1";s:8:"textshow";s:1:"1";s:9:"styledata";s:1:"0";s:6:"repeat";s:6:"repeat";s:9:"positionx";s:4:"left";s:9:"positiony";s:3:"top";s:4:"size";s:1:"0";s:13:"backgroundimg";s:0:"";}s:5:"style";a:20:{s:11:"pagebgcolor";s:7:"#f9f9f9";s:7:"bgcolor";s:7:"#ffffff";s:9:"bgcoloron";s:7:"#ffffff";s:9:"iconcolor";s:7:"#999999";s:11:"iconcoloron";s:7:"#999999";s:9:"textcolor";s:7:"#666666";s:11:"textcoloron";s:7:"#666666";s:11:"bordercolor";s:7:"#cccccc";s:13:"bordercoloron";s:7:"#ffffff";s:14:"childtextcolor";s:7:"#666666";s:12:"childbgcolor";s:7:"#f4f4f4";s:16:"childbordercolor";s:7:"#eeeeee";s:5:"sizew";s:2:"20";s:5:"sizeh";s:2:"20";s:11:"paddingleft";s:1:"0";s:10:"paddingtop";s:1:"0";s:8:"iconfont";s:2:"28";s:8:"textfont";s:2:"12";s:3:"bdr";s:1:"0";s:8:"bdrcolor";s:7:"#cccccc";}s:4:"data";a:5:{s:14:"C1548726169447";a:4:{s:6:"imgurl";s:71:"https://duli.nttrip.cn/template_img/template_retail/index/footmenu1.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:14:"icon-x-shouye2";s:4:"text";s:6:"首页";}s:14:"C1548726169448";a:4:{s:6:"imgurl";s:71:"https://duli.nttrip.cn/template_img/template_retail/index/footmenu2.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:15:"icon-x-chanpin2";s:4:"text";s:9:"优惠吃";}s:14:"C1548726169449";a:4:{s:6:"imgurl";s:71:"https://duli.nttrip.cn/template_img/template_retail/index/footmenu3.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:14:"icon-x-liebiao";s:4:"text";s:9:"场景吃";}s:14:"C1548726169450";a:4:{s:6:"imgurl";s:71:"https://duli.nttrip.cn/template_img/template_retail/index/footmenu4.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:16:"icon-x-dianhua10";s:4:"text";s:6:"我的";}s:14:"M1548726171424";a:4:{s:6:"imgurl";s:71:"https://duli.nttrip.cn/template_img/template_retail/index/footmenu5.png";s:7:"linkurl";s:0:"";s:9:"iconclass";s:14:"icon-x-shouye2";s:4:"text";s:9:"霸王餐";}}s:2:"id";s:8:"footmenu";}}';
        $item1 = unserialize($item1);
        foreach($item1 as $k => &$v){
            if($v['data']){
                foreach($v['data'] as $kk => &$vv){
                    if($vv['imgurl'] && strpos($vv['imgurl'],'https://duli.nttrip.cn/') !== false){
                        $vv['imgurl'] = ASSETSS.explode('https://duli.nttrip.cn/', $vv['imgurl'])[1];
                    }
                }
            }
        }
        $page1['items'] = serialize($item1);
        $page1['page'] = 'a:7:{s:10:"background";s:7:"#f1f1f1";s:13:"topbackground";s:7:"#ffffff";s:8:"topcolor";s:1:"1";s:9:"styledata";s:1:"0";s:5:"title";s:6:"美食";s:4:"name";s:6:"首页";s:10:"visitlevel";a:2:{s:6:"member";s:0:"";s:10:"commission";s:0:"";}}';
        $page1['tpl_name'] = "首页";

        pdo_insert("sudu8_page_diypage", $page1);
        $page1_id = pdo_insertid();
        $pageids = $page1_id;
        $page1_set = [
        	'pid' => $page1_id,
        	'uniacid' => $uniacid,
        	'kp' => ASSETSS."resource/images/diypage/default/default_start.jpg",
        	'kp_is' => 2,
        	'kp_m' => 2,
        	'tc' => ASSETSS."resource/images/diypage/default/tcgg.jpg",
        	'tc_is' => 2,
        	'foot_is' => 2
        ];
        pdo_insert("sudu8_page_diypageset", $page1_set);

        $data = [
            'uniacid' => $uniacid,
            'pageid' => $pageids,
            'template_name' => '零售类模板',
            'thumb' => ASSETSS."template_img/template_retail/cover.png",
            'status' => '1',
            'create_time' => time()
        ];
        pdo_insert("sudu8_page_diypagetpl", $data);
    	$tplid = pdo_insertid();
        if($tplid){
            echo $tplid;
        }
    }
    elseif ($id == 'sys_blank') {
        //是
        //为空白模板添加页面
        $diypagedata = array(
            'uniacid' => $uniacid,
            'index' => 1,
            'page' => 'a:7:{s:10:"background";s:7:"#f1f1f1";s:13:"topbackground";s:7:"#ffffff";s:8:"topcolor";s:1:"1";s:9:"styledata";s:1:"0";s:5:"title";s:21:"小程序页面标题";s:4:"name";s:18:"后台页面名称";s:10:"visitlevel";a:2:{s:6:"member";s:0:"";s:10:"commission";s:0:"";}}',
            'items' => '',
            'tpl_name' => '后台页面名称',
        );
        pdo_insert("sudu8_page_diypage", $diypagedata);
    	$pageid = pdo_insertid();
        
        $tpldata = array(
            'uniacid' => $uniacid,
            'pageid' => $pageid,
            'template_name' => '空白模板',
            'thumb' => '',
            'status' => '1',
            'create_time' => time(),
        );
        pdo_insert("ims_sudu8_page_diypagetpl", $tpldata);
    	$tplid = pdo_insertid();
        if($tplid){
            echo $tplid;
        }
    } elseif($id > 0) {
        $tplinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_diypagetpl_sys')." WHERE id = :id", array(':id' => $id));
        $pageid = explode(",",$tplinfo['pageid']);
        $pageids = '';
        foreach ($pageid as $key => $value) {
            $info = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_diypage_sys')." WHERE id = :id", array(':id' => $value));
            if($info){
            	$insertdata = array(
                    'uniacid' => $uniacid,
                    'index' => $info['index'],
                    'page' => $info['page'],
                    'items' => $info['items'],
                    'tpl_name' => $info['tpl_name'],
                );
                pdo_insert("ims_sudu8_page_diypage", $insertdata);
    			$insert_id = pdo_insertid();
            	$pageids = $pageids .','. $insert_id;
            }
        }
        $pageids = substr($pageids,1);
        $data = [
            'uniacid' => $uniacid,
            'pageid' => $pageids,
            'template_name' => $tplinfo['template_name'],
            'thumb' => $tplinfo['thumb'],
            'status' => '1',
            'create_time' => time()
        ];
        pdo_insert("sudu8_page_diypagetpl", $data);
    	$tplid = pdo_insertid();
        if($tplid){
            echo $tplid;
        }
    }
}else if($opt == 'delete'){
	$id = $_GPC["id"];
	//删除当前删除模板关联的所有页面
    $tplpages = pdo_getcolumn("sudu8_page_diypagetpl", array("uniacid" => $uniacid, "id" => $id), 'pageid');
    if($tplpages){
    	$tplpagearr = explode(',',$tplpages);
    	foreach ($tplpagearr as $key => $value) {
    		pdo_delete("sudu8_page_diypage", array('uniacid' => $uniacid, 'id' => $value));
    	}
    }
    $res = pdo_delete("sudu8_page_diypagetpl", array("uniacid" => $uniacid, "id" => $id));
    if($res){
        echo 1;
    }else{
        echo 2;
    }
}else if($opt == 'delsys'){
    $id = $_GPC["id"];

    //删除当前删除模板关联的所有页面
    $tplpages = pdo_getcolumn("sudu8_page_diypagetpl_sys", array("id" => $id), 'pageid');
    if($tplpages){
        $tplpagearr = explode(',',$tplpages);
        foreach ($tplpagearr as $key => &$value) {
            pdo_delete("sudu8_page_diypage_sys", array('id' => $value));
        }
    }
    $res = pdo_delete("sudu8_page_diypagetpl_sys", array("id" => $id));
    if($res){
        echo 1;
    }else{
        echo 2;
    }
}
