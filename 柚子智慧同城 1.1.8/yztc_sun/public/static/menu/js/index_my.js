require(['vue','VueDragging'], function (Vue,VueDragging) {
var snap = location.href;
var cuff = snap.split('web/index.php');
var host = cuff[0];
//点击轮播图
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==1){
        $("#form_edit_banner").css("display",'block').siblings().css("display",'none');
        bannerVM.add_h=245;
        bannerVM.add_top=145;
        //右边向当前数组中增加数据
        var item = {};
        item['imgurl'] = host + "addons/yb_shop/core/public/menu/images/Lb2.png";
        item['jiaodian_color']="#be0000";
        item['top'] = 0;
        item['img_dis'] = "none";
        item['this_type'] = 'banner';
        var arr=[];
        arr.push(item);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="banner";
        new_item['jiaodian_color']="#be0000";
        new_item['jiaodian_dots']="block";
        new_item['indicator_dots']="2";
        new_item['ly_width']="10";
        new_item['ly_height']="3";
        new_item['juedui_height']="93";
        new_item['topimg']=host + "addons/yb_shop/core/public/menu/images/Lb.jpg";
        new_item['list'] = arr;
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        //获取当前增加的幻灯片下标
       bannerVM.now_index = bannerVM.all_data.length-1;
        //右边当前数组=左侧当前幻灯片下标
        bannerVM.banner=bannerVM.all_data[bannerVM.now_index]['list'];
        $('#banner_color_r').val(bannerVM.all_data[bannerVM.now_index]['jiaodian_color']);
        $('#banner_height').val(bannerVM.all_data[bannerVM.now_index]['ly_height']);
        $('#banner_width').val(bannerVM.all_data[bannerVM.now_index]['ly_width']);
    }
})
//轮播图添加一条空数据
function banner_add_menu() {
    var item = {};
    item['imgurl'] =  host+ "addons/yb_shop/core/public/menu/images/Lb2.png";
    item['top'] = bannerVM.banner.length * 135;
    item['this_type'] = "banner";
    item['img_dis'] = "none";
    item['jiaodian_color']="#898989";
    bannerVM.add_h += 135;
    bannerVM.add_top += 135;
    bannerVM.banner.push(item);
}
$("input[name='componentLayouton']").click(function () {
   // $(this).parent().addClass("selected").siblings().removeClass("selected");
    if(this.value==2){
        bannerVM.all_data[bannerVM.now_index]['jiaodian_dots']='block';
    }else {
        bannerVM.all_data[bannerVM.now_index]['jiaodian_dots']='none';
    }
    bannerVM.all_data[bannerVM.now_index]['indicator_dots']=this.value;
})
//轮播图焦点颜色
function select_color(color) {
    bannerVM.all_data[bannerVM.now_index]['jiaodian_color']=color;
    $("#banner_color_text").html(color);
}
//轮播图高度
function select_banner_height(height) {
    bannerVM.all_data[bannerVM.now_index]['ly_height']=height;
    bannerVM.all_data[bannerVM.now_index]['juedui_height']=(height/bannerVM.all_data[bannerVM.now_index]['ly_width'])*310;
    console.log(bannerVM.all_data[bannerVM.now_index]['ly_width']);
    $("#this_banner_height").html(height*10);
}
//宽度
function select_banner_width(width) {
    bannerVM.all_data[bannerVM.now_index]['ly_width']=width;
    bannerVM.all_data[bannerVM.now_index]['juedui_height']=(bannerVM.all_data[bannerVM.now_index]['ly_height']/width)*310;
}
//*********************************************广告位star*************************************************
//点击广告位
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==2){
        //alert(form_edit_advert);
        $("#form_edit_advert").css("display",'block').siblings().css("display",'none');

        bannerVM.add_h=245;
        bannerVM.add_top=145;
        //右边向当前数组中增加数据
        var item = {};
        item['imgurl'] = host+ "addons/yb_shop/core/public/menu/images/Lb2.png";
        item['top'] = 0;
        item['this_type']="advert";
        item['width']="100";
        var arr=[];
        arr.push(item);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="advert";
        new_item['ly_width']="10";
        new_item['ly_height']="3";
        new_item['juedui_height']="93";
        new_item['topimg']=host+ "addons/yb_shop/core/public/menu/images/Ad.jpg";
        new_item['list'] = arr;
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        //获取当前增加的幻灯片下标
        bannerVM.now_index = bannerVM.all_data.length-1;
        //右边当前数组=左侧当前幻灯片下标
        bannerVM.advert=bannerVM.all_data[bannerVM.now_index]['list'];
        $('#advert_width').val(bannerVM.all_data[bannerVM.now_index]['ly_width']);
        $('#advert_height').val(bannerVM.all_data[bannerVM.now_index]['ly_height']);
    }
})
//广告位宽度比例
function this_advert_height(obj,width) {
    var index=$(obj).attr("data-index");
    console.log(index);
    console.log(width);
    bannerVM.advert[index]['width']=width;
}
//广告位添加一条空数据
function advert_add_menu () {
    var item = {};
    item['imgurl'] =  host+ "addons/yb_shop/core/public/menu/images/Lb2.png";
    item['top'] = bannerVM.advert.length * 135;
    item['this_type'] = "advert";
    item['width'] = "100";
    bannerVM.add_h += 135;
    bannerVM.add_top += 135;
    bannerVM.advert.push(item);
}
//高度
function select_advert_height(height) {
    bannerVM.all_data[bannerVM.now_index]['ly_height']=height;
    bannerVM.all_data[bannerVM.now_index]['juedui_height']=(height/bannerVM.all_data[bannerVM.now_index]['ly_width'])*310;
    $("#what_advert_height").html(height*10);
}
//宽度
function select_advert_width(width) {
    bannerVM.all_data[bannerVM.now_index]['ly_width']=width;
    bannerVM.all_data[bannerVM.now_index]['juedui_height']=(bannerVM.all_data[bannerVM.now_index]['ly_height']/width)*310;
}
//*********************************************广告位end*************************************************//
//*********************************************宫格导航star*************************************************//
//点击宫格导航
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==3){
        $("#from_edit_iconnav").css("display",'block').siblings().css("display",'none');
        bannerVM.add_h=245;
        bannerVM.add_top=145;
        var item = {};
        item['imgurl'] = host+ "addons/yb_shop/core/public/menu/images/Lb21.png";
        item['top'] = 0;
        item['name'] = '名称';
        item['alias'] = '链接';
        item['this_type']="navigation";
        var arr=[];
        arr.push(item);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="navigation";
        new_item['radian']="0";
        new_item['style']=4;
        new_item['layout']="cubeNavigationArea column-4 clearfix";
        new_item['color']="#000000";
        new_item['font_size']="12";
        new_item['topimg']=host+ "addons/yb_shop/core/public/menu/images/Ggdh1.png";
        new_item['list'] = arr;
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        //获取当前增加的幻灯片下标
        bannerVM.now_index = bannerVM.all_data.length-1;
        //右边当前数组=左侧当前幻灯片下标
        bannerVM.catenav=bannerVM.all_data[bannerVM.now_index]['list'];
    }
})
//宫格导航添加一条空数据
function catenav_add_menu() {
    var item = {};
    item['imgurl'] =  host+ "addons/yb_shop/core/public/menu/images/Lb21.png";
    item['top'] = bannerVM.catenav.length * 135;
    item['this_type'] = "navigation";
    item['name'] = '名称';
    item['alias'] = '链接';
    bannerVM.add_h += 135;
    bannerVM.add_top += 135;
    bannerVM.catenav.push(item);
}
//公告导航单独一条名称
function this_catenav_name(obj,name) {
    var index=$(obj).attr("data-index");
    bannerVM.all_data[bannerVM.now_index]['list'][index]['name']=name;
}
//列数
$("input[name='componentLayoutRadio']").click(function () {
    $(this).parent().addClass("selected").siblings().removeClass("selected");
    bannerVM.all_data[bannerVM.now_index]['layout']="cubeNavigationArea column-"+this.value+" clearfix";
    bannerVM.all_data[bannerVM.now_index]['style']=this.value;
});
//字体设置
$("input[name='fontsize_zt']").click(function () {
    //console.log(this.value);
    bannerVM.all_data[bannerVM.now_index]['font_size']=this.value;
    $(this).parent().addClass("selected").siblings().removeClass("selected");
});
//选择颜色
 function catenav_font_color(color) {
     bannerVM.all_data[bannerVM.now_index]['color']=color;
     $("#catenav_color_text").html(color);
}
//圆角弧度
function catenav_catenav_corners(corners) {
    bannerVM.all_data[bannerVM.now_index]['radian']=corners;
    $("#catenav_corners_height").html(corners);
}
//*********************************************宫格导航end*************************************************//
//*********************************************标题star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==4){
        $("#form_edit_title").css("display",'block').siblings().css("display",'none');
        var item = {};
         item['top'] = 0;
         item['this_type']="headline";
         var arr=[];
         arr.push(item);
         //左边幻灯片增加数据
         var new_item ={};
        new_item['name'] = '标题名称';
         new_item['type']="headline";
         new_item['style']="1";
         new_item['color']="#000000";
         new_item['font_size']="18";
         new_item['bg_color']="#ffffff";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
         bannerVM.all_data.push(new_item);
        // //获取当前增加的幻灯片下标
         bannerVM.now_index = bannerVM.all_data.length-1;
        //右边当前数组=左侧当前幻灯片下标
         bannerVM.columntitle=bannerVM.all_data[bannerVM.now_index]['list'];
    }
})
//标题名称
function alias_title(name) {
    bannerVM.all_data[bannerVM.now_index]['name']=name;
}
//字体颜色
function alias_font_color(color) {
    bannerVM.all_data[bannerVM.now_index]['color']=color;
    $("#Bt_TitlecolorSet_text").html(color);
}
//背景颜色
function title_bg_color(color) {
    bannerVM.all_data[bannerVM.now_index]['bg_color']=color;
    $("#titlebgcolorSet_text").html(color);
}
//字体大小
$("input[name='fontsize_bt']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['font_size']=this.value;
    $(this).parent().addClass("selected").siblings().removeClass("selected");
});
//标题样式
$("input[name='pureTitles']").click(function () {
    var modstyle={};
    var type = $(this).val();
    var type2=$(this).attr('data-value');
    var type3=$(this).attr('data-value2');
    modstyle={
        titlestyle:'',
    };
    $(this).parent().addClass("selected").siblings().removeClass("selected");
    if (type=='{background-color:#fff}') {
        modstyle.titlestyle='1';
        modstyle.titlestyle3=type3;
        modstyle.titlestyle2=type2;
        AddCss("title_"+bannerVM.all_data[bannerVM.now_index]['time_key'],modstyle);
    }
    if (type==' .pureText .wrap .aframe{width:4px;background-color:#cd3637;border-radius:3px;margin:0;position:absolute;height:37.5%;top:33%;left:15px}') {
        modstyle.titlestyle='2';
        modstyle.titlestyle3=type3;
        modstyle.titlestyle2=type2;
        AddCss("title_"+bannerVM.all_data[bannerVM.now_index]['time_key'],modstyle);
    }
    if (type==' .pureText .wrap{text-align:center}') {
        modstyle.titlestyle='3';
        modstyle.titlestyle3=type3;
        modstyle.titlestyle2=type2;
        AddCss("title_"+bannerVM.all_data[bannerVM.now_index]['time_key'],modstyle);
    }
    if (type==' .pureText .wrap .aframe{left:8px;top:32.3%;position:absolute;display:block;border:2px solid #cd3637;margin:0;border-radius:50px;height:14px;width:14px;}') {
        modstyle.titlestyle='4';
        modstyle.titlestyle3=type3;
        modstyle.titlestyle2=type2;
        AddCss("title_"+bannerVM.all_data[bannerVM.now_index]['time_key'],modstyle);
    }
    if (type==' .pureText .wrap::before{display:inline-block;height:1px;background-color:#cd3637;margin-right:5px;width:28%;vertical-align: middle;}') {
        modstyle.titlestyle='5';
        modstyle.titlestyle3=type3;
        modstyle.titlestyle2=type2;
        AddCss("title_"+bannerVM.all_data[bannerVM.now_index]['time_key'],modstyle);
    }
    if (type==' .pureText .wrap span{color:#ffa000;}') {
        modstyle.titlestyle='6';
        modstyle.titlestyle3=type3;
        modstyle.titlestyle2=type2;
        AddCss("title_"+bannerVM.all_data[bannerVM.now_index]['time_key'],modstyle);
    }
    if (type=='pureTitle7') {
        modstyle.titlestyle='7';
        modstyle.titlestyle3=type3;
        modstyle.titlestyle2=type2;
        AddCss("title_"+bannerVM.all_data[bannerVM.now_index]['time_key'],modstyle);
    }
    if (type=='pureTitle8') {
        modstyle.titlestyle='8';
        modstyle.titlestyle3=type3;
        modstyle.titlestyle2=type2;
        AddCss("title_"+bannerVM.all_data[bannerVM.now_index]['time_key'],modstyle);
    }
});
function EditCss(modid,modstyle) {
    var title_titlestyle='';
    if (modstyle.titlestyle=='1') {
        title_titlestyle=modstyle.titlestyle==''?'':'#'+modid+' '+modstyle.titlestyle+' #'+modid+' '+modstyle.titlestyle2+' #'+modid+' '+modstyle.titlestyle3+' ';
    }
    if (modstyle.titlestyle=='2') {
        title_titlestyle=modstyle.titlestyle==''?'':'#'+modid+' .pureText .wrap .aframe{width:4px;background-color:#cd3637;border-radius:3px;margin:0;position:absolute;height:37.5%;top:33%;left:15px} #'+modid+' '+modstyle.titlestyle2+' #'+modid+' '+modstyle.titlestyle3+' ';
    }
    if (modstyle.titlestyle=='3') {
        title_titlestyle=modstyle.titlestyle==''?'':'#'+modid+' .pureText .wrap{text-align:center} #'+modid+' '+modstyle.titlestyle2+' #'+modid+' '+modstyle.titlestyle3+' ';
    }
    if (modstyle.titlestyle=='4') {
        title_titlestyle=modstyle.titlestyle==''?'':'#'+modid+' .pureText .wrap .aframe{left:8px;top:32.3%;position:absolute;display:block;border:2px solid #cd3637;margin:0;border-radius:50px;height:14px;width:14px;} #'+modid+' '+modstyle.titlestyle2+' #'+modid+' '+modstyle.titlestyle3+' ';
    }
    if (modstyle.titlestyle=='5') {
        title_titlestyle=modstyle.titlestyle==''?'':'#'+modid+' .pureText .wrap::before{display:inline-block;height:1px;background-color:#cd3637;margin-right:5px;width:28%;vertical-align: middle;} #'+modid+' '+modstyle.titlestyle2+' #'+modid+' '+modstyle.titlestyle3+' ';
    }
    if (modstyle.titlestyle=='6') {
        title_titlestyle=modstyle.titlestyle==''?'':'#'+modid+' .pureText .wrap span{color:#ffa000;} #'+modid+' '+modstyle.titlestyle2+' #'+modid+' '+modstyle.titlestyle3+' ';
    }
    if (modstyle.titlestyle=='7') {
        title_titlestyle=modstyle.titlestyle==''?'':'#'+modid+' .middle_titleO::before {display:inline-block;  width:16%;  height:1px;  background-color:#333;  content: "";  vertical-align: middle;  margin-left:6px;  margin-right:6px;} #'+modid+' '+modstyle.titlestyle2+' #'+modid+' '+modstyle.titlestyle3+' #'+modid+' .middle_titleS::after {display:inline-block;  width:16%;  height:1px;  background-color:#333;  content: "";  vertical-align: middle;  margin-left:6px;  margin-right:6px;} #'+modid+' .pureText .wrap{text-align:center}';
    }
    if (modstyle.titlestyle=='8') {
        title_titlestyle=modstyle.titlestyle==''?'':'#'+modid+' .middle_titleO::before {display:inline-block;  width:16%;  height:1px;  background-color:#333;  content: "";  vertical-align: middle;  margin-left:6px;  margin-right:6px;} #'+modid+' '+modstyle.titlestyle2+' #'+modid+' '+modstyle.titlestyle3+' #'+modid+' .middle_titleS::after {display:inline-block;  width:16%;  height:1px;  background-color:#333;  content: "";  vertical-align: middle;  margin-left:6px;  margin-right:6px;} #'+modid+' .pureText .wrap{text-align:center}';
    }

    var styleElem = document.getElementsByTagName('style');
    for (var i = 0,len = styleElem.length; i < len; i++) {
        if (styleElem[i]) {
            if ("form_style_scheme_"+modid === styleElem[i].id) {
                styleElem[i].parentNode.removeChild(styleElem[i]);
            }
        }
    }
    $('<style id="form_style_scheme_' + modid + '">' + title_titlestyle + '</style>').appendTo('head');
}
function AddCss(modid,modstyle) {
    var title_titlestyle='';
    if (modstyle.titlestyle=='1') {
        title_titlestyle=modstyle.titlestyle==''?'':'#'+modid+' '+modstyle.titlestyle+' #'+modid+' '+modstyle.titlestyle2+' #'+modid+' '+modstyle.titlestyle3+' ';
    }
    if (modstyle.titlestyle=='2') {
        title_titlestyle=modstyle.titlestyle==''?'':'#'+modid+' .pureText .wrap .aframe{width:4px;background-color:#cd3637;border-radius:3px;margin:0;position:absolute;height:37.5%;top:33%;left:15px} #'+modid+' '+modstyle.titlestyle2+' #'+modid+' '+modstyle.titlestyle3+' ';
    }
    if (modstyle.titlestyle=='3') {
        title_titlestyle=modstyle.titlestyle==''?'':'#'+modid+' .pureText .wrap{text-align:center} #'+modid+' '+modstyle.titlestyle2+' #'+modid+' '+modstyle.titlestyle3+' ';
    }
    if (modstyle.titlestyle=='4') {
        title_titlestyle=modstyle.titlestyle==''?'':'#'+modid+' .pureText .wrap .aframe{left:8px;top:32.3%;position:absolute;display:block;border:2px solid #cd3637;margin:0;border-radius:50px;height:14px;width:14px;} #'+modid+' '+modstyle.titlestyle2+' #'+modid+' '+modstyle.titlestyle3+' ';
    }
    if (modstyle.titlestyle=='5') {
        title_titlestyle=modstyle.titlestyle==''?'':'#'+modid+' .pureText .wrap::before{display:inline-block;height:1px;background-color:#cd3637;margin-right:5px;width:28%;vertical-align: middle;} #'+modid+' '+modstyle.titlestyle2+' #'+modid+' '+modstyle.titlestyle3+' ';
    }
    if (modstyle.titlestyle=='6') {
        title_titlestyle=modstyle.titlestyle==''?'':'#'+modid+' .pureText .wrap span{color:#ffa000;} #'+modid+' '+modstyle.titlestyle2+' #'+modid+' '+modstyle.titlestyle3+' ';
    }
    if (modstyle.titlestyle=='7') {
        title_titlestyle=modstyle.titlestyle==''?'':'#'+modid+' .middle_titleO::before {display:inline-block;  width:16%;  height:1px;  background-color:#333;  content: "";  vertical-align: middle;  margin-left:6px;  margin-right:6px;} #'+modid+' '+modstyle.titlestyle2+' #'+modid+' '+modstyle.titlestyle3+' #'+modid+' .middle_titleS::after {display:inline-block;  width:16%;  height:1px;  background-color:#333;  content: "";  vertical-align: middle;  margin-left:6px;  margin-right:6px;} #'+modid+' .pureText .wrap{text-align:center}';
    }
    if (modstyle.titlestyle=='8') {
        title_titlestyle=modstyle.titlestyle==''?'':'#'+modid+' .middle_titleO::before {display:inline-block;  width:16%;  height:1px;  background-color:#333;  content: "";  vertical-align: middle;  margin-left:6px;  margin-right:6px;} #'+modid+' '+modstyle.titlestyle2+' #'+modid+' '+modstyle.titlestyle3+' #'+modid+' .middle_titleS::after {display:inline-block;  width:16%;  height:1px;  background-color:#333;  content: "";  vertical-align: middle;  margin-left:6px;  margin-right:6px;} #'+modid+' .pureText .wrap{text-align:center}';
    }

    var styleElem = document.getElementsByTagName('style');
    for (var i = 0,len = styleElem.length; i < len; i++) {
        if (styleElem[i]) {
            if ("form_style_scheme_"+modid === styleElem[i].id) {
                styleElem[i].parentNode.removeChild(styleElem[i]);
            }
        }
    }
    bannerVM.all_data[bannerVM.now_index]['style']= modstyle.titlestyle;
    $('<style id="form_style_scheme_' + modid + '">' + title_titlestyle + '</style>').appendTo('head');
}
//*********************************************标题end*************************************************//
//*********************************************辅助空白star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==5){
        $("#form_edit_blank").css("display",'block').siblings().css("display",'none');
        var item = {};
        item['top'] = 0;
        item['this_type']="blank";
        var arr=[];
        arr.push(item);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="blank";
        new_item['bg_color']="#ffffff";
        new_item['ly_height']="20";
       // new_item['list'] = arr;
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        // //获取当前增加的幻灯片下标
        bannerVM.now_index = bannerVM.all_data.length-1;
    }
})
//空白高度
function this_blank_height(height) {
    bannerVM.all_data[bannerVM.now_index]['ly_height']=height;
    $("#blank_height_number").html(height);
}
//背景颜色
function this_blank_color(color) {
    bannerVM.all_data[bannerVM.now_index]['bg_color']=color;
    $("#blank_color_text").html(color);
}
//*********************************************辅助空白end*************************************************//
//*********************************************搜索框star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==6){
        $("#form_edit_search").css("display",'block').siblings().css("display",'none');
        var item = {};
        item['this_type']="search";
        var arr=[];
        arr.push(item);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="search";
        new_item['default']="";
        new_item['search_style']="0";
        new_item['bg_color']="#ffffff";
        new_item['li_bg_color']="#ffffff";
        new_item['text_color']="#000000";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        // //获取当前增加的幻灯片下标
        bannerVM.now_index = bannerVM.all_data.length-1;
        //右边当前数组=左侧当前幻灯片下标
    }
})
//热门搜索
function this_search_hot(hot) {
    bannerVM.all_data[bannerVM.now_index]['default']=hot;
}
//背景color
function this_search_color(color) {
    bannerVM.all_data[bannerVM.now_index]['bg_color']=color;
    $("#search_color_text").html(color);
}
//li背景color
function this_search_bj_color(color) {
    bannerVM.all_data[bannerVM.now_index]['li_bg_color']=color;
    $("#search_bj_color_text").html(color);
}
//文字color
function this_search_text_color(color) {
    bannerVM.all_data[bannerVM.now_index]['text_color']=color;
    $("#search_text_color_text").html(color);
}
//样式
$("input[name='search_style']").click(function () {
    if (this.value==0){
        bannerVM.all_data[bannerVM.now_index]['search_style']="0";
    }
    if (this.value==1){
        bannerVM.all_data[bannerVM.now_index]['search_style']="1";
    }
    $(this).parent().addClass("selected").siblings().removeClass("selected");
});
//*********************************************搜索框end*************************************************//
//*********************************************分割线star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==7){
        $("#form_edit_Parting").css("display",'block').siblings().css("display",'none');
        var item = {};
        item['this_type']="line";
        var arr=[];
        arr.push(item);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="line";
        new_item['line']="solid";
        new_item['style']="1";
        new_item['color']="#000000";
        new_item['bg_color']="#ffffff";
        new_item['ly_height']="1";
        new_item['margin']="10";
        //new_item['list'] = arr;
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        // //获取当前增加的幻灯片下标
        bannerVM.now_index = bannerVM.all_data.length-1;
    }
})
//样式
$("input[name='Fgx_style']").click(function () {
    if (this.value==0){
        bannerVM.all_data[bannerVM.now_index]['line']="solid";
    }else if(this.value==1){
        bannerVM.all_data[bannerVM.now_index]['line']="dashed";
    }else {
        bannerVM.all_data[bannerVM.now_index]['line']="dotted";
    }
    bannerVM.all_data[bannerVM.now_index]['style']=this.value;
    $(this).parent().addClass("selected").siblings().removeClass("selected");
});
//线条颜色
function this_parting_line_color(color) {
    bannerVM.all_data[bannerVM.now_index]['color']=color;
    $("#Fgx_Color_text").html(color);
}
//背景颜色
function this_parting_bg_color(color) {
    bannerVM.all_data[bannerVM.now_index]['bg_color']=color;
    $("#Fgx_bgColor_text").html(color);
}
//线条高度
function this_parting_line_height(height) {
    bannerVM.all_data[bannerVM.now_index]['ly_height']=height;
    $("#line_height_height").html(height);
}
//间距
function this_parting_line_margin(margin) {
    bannerVM.all_data[bannerVM.now_index]['margin']=margin;
    $("#line_margin_height").html(height);
}
//*********************************************分割线end*************************************************//
//*********************************************图文集star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==8){
        $("#form_edit_imgtextlist").css("display",'block').siblings().css("display",'none');
        bannerVM.add_h=245;
        bannerVM.add_top=145;
        var item = {};
        item['this_type']="article";
        item['name']="标题";
        item['description']="内容描述";
        item['imgurl']=host+ "addons/yb_shop/core/public/menu/images/Tpj_3.png";
        item['top']=0;
        var arr=[];
        arr.push(item);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="article";
        new_item['title_size']="15";
        new_item['bg_color']="#ffffff";
        new_item['title_color']="#000000";
        new_item['layout']="1";
        new_item['style_width']="";
        new_item['style_height']="";
        new_item['text_width']="180px";
        new_item['style_num']="1";
        new_item['list'] = arr;
        new_item['add_type']="1";
        new_item['add_num']="1";
        new_item['add_sort']="time";
        new_item['add_cate']="0";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        // //获取当前增加的幻灯片下标
        bannerVM.now_index = bannerVM.all_data.length-1;
        //右边当前数组=左侧当前幻灯片下标
        bannerVM.imgtextlist=bannerVM.all_data[bannerVM.now_index]['list'];
    }
})
//添加一条空数据
function imgtextlist_add_menu() {
    var item = {};
    item['this_type']="article";
    item['name']="标题";
    item['description']="内容描述";
    item['imgurl']=host+ "addons/yb_shop/core/public/menu/images/Tpj_3.png";
    item['top'] = bannerVM.imgtextlist.length * 135;
    bannerVM.add_h += 135;
    bannerVM.add_top += 135;
    bannerVM.imgtextlist.push(item);
}
//样式选中
$("input[name='cateLists']").click(function () {
    if (this.value==1){
        bannerVM.all_data[bannerVM.now_index]['style_num']=1;
        bannerVM.all_data[bannerVM.now_index]['style_width']="";
        bannerVM.all_data[bannerVM.now_index]['style_height']="";
    }
    if (this.value==2){
        bannerVM.all_data[bannerVM.now_index]['style_num']=1;
        bannerVM.all_data[bannerVM.now_index]['style_width']="width:100%;height:130px;";
        bannerVM.all_data[bannerVM.now_index]['style_height']="border-bottom:0px;height:220px;";
        bannerVM.all_data[bannerVM.now_index]['text_width']="94%";
    }
    if (this.value==3){
        bannerVM.all_data[bannerVM.now_index]['style_num']=2;
        bannerVM.all_data[bannerVM.now_index]['style_width']="width:100%;height:130px;";
        bannerVM.all_data[bannerVM.now_index]['style_height']="border-bottom:0px;height:220px;";
        bannerVM.all_data[bannerVM.now_index]['text_width']="140px";
    }
    console.log(bannerVM.all_data[bannerVM.now_index]['style_num']);
    bannerVM.all_data[bannerVM.now_index]['layout']=this.value;
    $(this).parent().addClass("selected").siblings().removeClass("selected");
})
//标题大小
$("input[name='fontsize_Twj']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['title_size']=this.value;
    $(this).parent().addClass("selected").siblings().removeClass("selected");
})
//标题颜色
function imgtextlist_title_color(color) {
    bannerVM.all_data[bannerVM.now_index]['title_color']=color;
    $("#pureTitlecolorSet_text").html(color);
}
//背景颜色
function imgtextlist_bg_color(color) {
    bannerVM.all_data[bannerVM.now_index]['bg_color']=color;
    $("#imgtextColorSet_text").html(color);
}
//添加类型
$("input[name='img_add_type']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['add_type']=this.value;
    $(this).prop("checked", "checked");
    var num=$("#add_img_list_val").val();
    if (this.value==1){
        $("#img_add_type_zid").css('display','none');
        bannerVM.add_h = bannerVM.imgtextlist.length *135+135;
        bannerVM.add_top = bannerVM.imgtextlist.length *135+15;
    }else {
        $("#img_type_time").prop("checked", "checked");
        $("#img_add_type_zid").css('display','block');
        $("#add_img_list_val").val(1);
        bannerVM.add_h=245;
        bannerVM.add_top=145;
        bannerVM.imgtextlist.splice(0,bannerVM.imgtextlist.length)
        bannerVM.all_data[bannerVM.now_index]['list'].splice(0, bannerVM.all_data[bannerVM.now_index]['list'].length);
        $.ajax({
            type : "post",
            url :  host+"addons/yb_shop/core/index.php?s=/admin/goods/get_sort_img_list",
            data : {'num':num,'sort':'time'},
            success : function(data) {
                var item = {};

                item['this_type']="article";
                item['name']=data[0]['title'];
                item['description']= data[0]['short_title'];
                item['imgurl']= data[0]['image'];

                if (data[0]['link']!=''){
                    item['pagesurl'] = "/yb_shop/pages/web/index?url="+escape(data[0]['link'])+"&name="+ data[0]['title'];
                }else {
                    item['pagesurl'] = '/yb_shop/pages/find_info/index?id='+data[0]['article_id'];
                }

                item['param'] = data[0]['article_id'];
                item['add_cate'] = data[0]['class_id'];
                item['top']=0;
                var arr=[];
                arr.push(item);
                var new_item ={};
                new_item['type']="article";
                new_item['list'] = arr;
                new_item['title_size']=bannerVM.all_data[bannerVM.now_index]['title_size'];
                new_item['bg_color']=bannerVM.all_data[bannerVM.now_index]['bg_color'];
                new_item['title_color']=bannerVM.all_data[bannerVM.now_index]['title_color'];
                new_item['layout']=bannerVM.all_data[bannerVM.now_index]['layout'];
                new_item['style_width']=bannerVM.all_data[bannerVM.now_index]['style_width'];
                new_item['style_height']=bannerVM.all_data[bannerVM.now_index]['style_height'];
                new_item['add_type']="2";
                new_item['add_num']=bannerVM.all_data[bannerVM.now_index]['add_num'];
                new_item['add_sort']=bannerVM.all_data[bannerVM.now_index]['add_sort'];
                new_item['add_cate']=bannerVM.all_data[bannerVM.now_index]['add_cate'];
                new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
                Vue.set(bannerVM.all_data,bannerVM.now_index,new_item);
                bannerVM.imgtextlist=bannerVM.all_data[bannerVM.now_index]['list'];
            }
        });
    }
})
function add_img_list(val) {
    bannerVM.all_data[bannerVM.now_index]['add_num']=val;
    var sort=$("input[name='img_sort_type']:checked").val();
    var select_cate_id=$("#select_img_id").val();
    $.ajax({
        type: "post",
        url:  host+"addons/yb_shop/core/index.php?s=/admin/goods/get_sort_img_list",
        data: {'num': val, 'sort': sort,'cate':select_cate_id},
        success: function (data) {
            bannerVM.add_h=245;
            bannerVM.add_top=145;
            bannerVM.imgtextlist.splice(0,bannerVM.imgtextlist.length);
            bannerVM.all_data[bannerVM.now_index]['list'].splice(0, bannerVM.all_data[bannerVM.now_index]['list'].length);
            $.each(data, function(){
                var item = {};

                item['this_type']="article";
                item['name']=this.title;
                item['description']= this.short_title;
                item['imgurl']= this.image;
                if (this.link!=''){
                    item['pagesurl'] = "/yb_shop/pages/web/index?url="+escape(this.link)+"&name="+ this.title;
                }else {
                    item['pagesurl'] = '/yb_shop/pages/find_info/index?id='+this.article_id;
                }

                item['param'] = this.article_id;
                item['top'] = bannerVM.imgtextlist.length * 135;

                bannerVM.add_h += 135;
                bannerVM.add_top += 135;
                bannerVM.all_data[bannerVM.now_index]['list'].push(item);
            });
        }
    })
}
$("input[name='img_sort_type']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['add_sort']=this.value;
    $(this).parent().addClass("selected").siblings().removeClass("selected");
    var select_cate_id=$("#select_img_id").val();
    var num=$("#add_img_list_val").val();
    $.ajax({
        type: "post",
        url:  host+"addons/yb_shop/core/index.php?s=/admin/goods/get_sort_img_list",
        data: {'num': num, 'sort': this.value,'cate':select_cate_id},
        success: function (data) {
            bannerVM.add_h=245;
            bannerVM.add_top=145;
            bannerVM.imgtextlist.splice(0,bannerVM.imgtextlist.length);
            bannerVM.all_data[bannerVM.now_index]['list'].splice(0, bannerVM.all_data[bannerVM.now_index]['list'].length);
            $.each(data, function(){
                var item = {};


                item['this_type']="article";
                item['name']=this.title;
                item['description']= this.short_title;
                item['imgurl']= this.image;
                if (this.link!=''){
                    item['pagesurl'] = "/yb_shop/pages/web/index?url="+escape(this.link)+"&name="+ this.title;
                }else {
                    item['pagesurl'] = '/yb_shop/pages/find_info/index?id='+this.article_id;
                }
                item['param'] = this.article_id;
                item['top'] = bannerVM.imgtextlist.length * 135;

                bannerVM.add_h += 135;
                bannerVM.add_top += 135;
                bannerVM.all_data[bannerVM.now_index]['list'].push(item);
            });
        }
    })
})
//选择分类
function get_select_img_id() {
    var select_cate_id=$("#select_img_id").val();
    var sort=$("input[name='img_sort_type']:checked").val();
    var num=$("#add_img_list_val").val();
    bannerVM.all_data[bannerVM.now_index]['add_cate']=select_cate_id;
    $.ajax({
        type: "post",
        url:  host+"addons/yb_shop/core/index.php?s=/admin/goods/get_sort_img_list",
        data: {'num': num, 'sort': sort,'cate':select_cate_id},
        success: function (data) {
            bannerVM.add_h=245;
            bannerVM.add_top=145;
            bannerVM.imgtextlist.splice(0,bannerVM.imgtextlist.length);
            bannerVM.all_data[bannerVM.now_index]['list'].splice(0, bannerVM.all_data[bannerVM.now_index]['list'].length);
            $.each(data, function(){
                var item = {};
                item['this_type']="article";
                item['name']=this.title;
                item['description']= this.short_title;
                item['imgurl']= this.image;
                if (this.link!=''){
                    item['pagesurl'] = "/yb_shop/pages/web/index?url="+escape(this.link)+"&name="+ this.title;
                }else {
                    item['pagesurl'] = '/yb_shop/pages/find_info/index?id='+this.article_id;
                }
                item['param'] = this.article_id;
                item['top'] = bannerVM.imgtextlist.length * 135;
                bannerVM.add_h += 135;
                bannerVM.add_top += 135;
                bannerVM.all_data[bannerVM.now_index]['list'].push(item);
            });
        }
    })

}
//*********************************************图文集end*************************************************//
//*********************************************商品集star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==9){
        $("#from_edit_goodlist").css("display",'block').siblings().css("display",'none');
        bannerVM.add_h=245;
        bannerVM.add_top=145;
        var item = {};
        item['this_type']="goods";
        item['name']="标题";
        item['description']="商品简介";
        item['price']="9.9";
        item['imgurl']=host+ "addons/yb_shop/core/public/menu/images/Tpj_3.png";
        item['top']=0;
        var arr=[];
        arr.push(item);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="goods";
        new_item['title_size']="12";
        new_item['title_color']="#000000";
        new_item['layout']="1";
        new_item['list'] = arr;
        new_item['add_type']="1";
        new_item['add_num']="1";
        new_item['add_sort']="time";
        new_item['add_cate']="0";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        // //获取当前增加的幻灯片下标
        bannerVM.now_index = bannerVM.all_data.length-1;
        //右边当前数组=左侧当前幻灯片下标
        bannerVM.goodlist=bannerVM.all_data[bannerVM.now_index]['list'];
    }
})
//添加一条空数据
function goods_add_menu() {
    var item = {};
    item['this_type']="goods";
    item['name']="标题";
    item['price']="9.9";
    item['description']="商品简介";
    item['imgurl']=host+ "addons/yb_shop/core/public/menu/images/Tpj_3.png";
    item['top'] = bannerVM.goodlist.length * 135;
    bannerVM.add_h += 135;
    bannerVM.add_top += 135;
    bannerVM.goodlist.push(item);
}
//字体大小
$("input[name='goodfontsize_zt']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['title_size']=this.value;
    $(this).parent().addClass("selected").siblings().removeClass("selected");
})

//添加类型
$("input[name='goods_add_type']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['add_type']=this.value;
    $(this).prop("checked", "checked");
    var num=$("#add_goods_list_val").val();
    if (this.value==1){
        $("#goods_add_type_zid").css('display','none');
        bannerVM.add_h = bannerVM.goodlist.length *135+135;
        bannerVM.add_top = bannerVM.goodlist.length *135+15;
    }else {
        $("#Goods_type_time").prop("checked", "checked");
        $("#goods_add_type_zid").css('display','block');
        $("#add_goods_list_val").val(1);
        bannerVM.add_h=245;
        bannerVM.add_top=145;
        bannerVM.goodlist.splice(0,bannerVM.goodlist.length)
        bannerVM.all_data[bannerVM.now_index]['list'].splice(0, bannerVM.all_data[bannerVM.now_index]['list'].length);
        $.ajax({
            type : "post",
            url :  host+"addons/yb_shop/core/index.php?s=/admin/goods/get_sort_list",
            data : {'num':num,'sort':'time'},
            success : function(data) {
                var item = {};
                item['this_type']="goods";
                item['name']=data[0]['goods_name'];
                item['description']= data[0]['introduction'];
                item['price']=data[0]['price'];
                item['imgurl']= data[0]['img_cover'];
                item['pagesurl'] = '/yb_shop/pages/goods/detail/index?id='+data[0]['goods_id'];
                item['param'] = data[0]['goods_id'];
                item['top']=0;
                var arr=[];
                arr.push(item);
                var new_item ={};
                new_item['type']="goods";
                new_item['title_size']=bannerVM.all_data[bannerVM.now_index]['title_size'];
                new_item['title_color']=bannerVM.all_data[bannerVM.now_index]['title_color'];
                new_item['layout']=bannerVM.all_data[bannerVM.now_index]['layout'];
                new_item['list'] = arr;
                new_item['add_type']="2";
                new_item['add_num']=bannerVM.all_data[bannerVM.now_index]['add_num'];
                new_item['add_sort']=bannerVM.all_data[bannerVM.now_index]['add_sort'];
                new_item['add_cate']=bannerVM.all_data[bannerVM.now_index]['add_cate'];
                new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
                Vue.set(bannerVM.all_data,bannerVM.now_index,new_item);
                bannerVM.goodlist=bannerVM.all_data[bannerVM.now_index]['list'];
            }
        });
    }
})
$("input[name='goods_sort_type']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['add_sort']=this.value;
    $(this).parent().addClass("selected").siblings().removeClass("selected");
    var select_cate_id=$("#select_cate_id").val();
    var num=$("#add_goods_list_val").val();
    $.ajax({
        type: "post",
        url:  host+"addons/yb_shop/core/index.php?s=/admin/goods/get_sort_list",
        data: {'num': num, 'sort': this.value,'cate':select_cate_id},
        success: function (data) {
            bannerVM.add_h=245;
            bannerVM.add_top=145;
            bannerVM.goodlist.splice(0,bannerVM.goodlist.length);
            bannerVM.all_data[bannerVM.now_index]['list'].splice(0, bannerVM.all_data[bannerVM.now_index]['list'].length);
            $.each(data, function(){
                var item = {};
                item['this_type']="goods";
                item['name']=this.goods_name;
                item['price']=this.price;
                item['description']=this.introduction;
                item['imgurl']=this.img_cover;
                item['top'] = bannerVM.goodlist.length * 135;
                item['pagesurl'] = '/yb_shop/pages/goods/detail/index?id='+this.goods_id;
                item['param'] = this.goods_id;
                bannerVM.add_h += 135;
                bannerVM.add_top += 135;
                bannerVM.all_data[bannerVM.now_index]['list'].push(item);
            });
        }
    })
})
//多少条数据
function add_goods_list(val) {
    bannerVM.all_data[bannerVM.now_index]['add_num']=val;
    var sort=$("input[name='goods_sort_type']:checked").val();
    var select_cate_id=$("#select_cate_id").val();
    $.ajax({
        type: "post",
        url:  host+"addons/yb_shop/core/index.php?s=/admin/goods/get_sort_list",
        data: {'num': val, 'sort': sort,'cate':select_cate_id},
        success: function (data) {
            bannerVM.add_h=245;
            bannerVM.add_top=145;
            bannerVM.goodlist.splice(0,bannerVM.goodlist.length);
            bannerVM.all_data[bannerVM.now_index]['list'].splice(0, bannerVM.all_data[bannerVM.now_index]['list'].length);
            $.each(data, function(){
                var item = {};
                item['this_type']="goods";
                item['name']=this.goods_name;
                item['price']=this.price;
                item['description']=this.introduction;
                item['imgurl'] = this.img_cover;
                item['pagesurl'] = '/yb_shop/pages/goods/detail/index?id='+this.goods_id;
                item['param'] = this.goods_id;
                item['top'] = bannerVM.goodlist.length * 135;
                bannerVM.add_h += 135;
                bannerVM.add_top += 135;
                bannerVM.all_data[bannerVM.now_index]['list'].push(item);
            });
        }
    })
}
//选择分类
function get_select_id() {
    var select_cate_id=$("#select_cate_id").val();
    var sort=$("input[name='goods_sort_type']:checked").val();
    var num=$("#add_goods_list_val").val();
    bannerVM.all_data[bannerVM.now_index]['add_cate']=select_cate_id;
    $.ajax({
        type: "post",
        url:  host+"addons/yb_shop/core/index.php?s=/admin/goods/get_sort_list",
        data: {'num': num, 'sort': sort,'cate':select_cate_id},
        success: function (data) {
            bannerVM.add_h=245;
            bannerVM.add_top=145;
            bannerVM.goodlist.splice(0,bannerVM.goodlist.length);
            bannerVM.all_data[bannerVM.now_index]['list'].splice(0, bannerVM.all_data[bannerVM.now_index]['list'].length);
            $.each(data, function(){
                var item = {};
                item['this_type']="goods";
                item['name']=this.goods_name;
                item['price']=this.price;
                item['description']=this.introduction;
                item['imgurl']=this.img_cover;
                item['pagesurl'] = '/yb_shop/pages/goods/detail/index?id='+this.goods_id;
                item['param'] = this.goods_id;
                item['top'] = bannerVM.goodlist.length * 135;
                bannerVM.add_h += 135;
                bannerVM.add_top += 135;
                bannerVM.all_data[bannerVM.now_index]['list'].push(item);
            });
        }
    })

}
//字体颜色
function goods_font_color(color) {
    bannerVM.all_data[bannerVM.now_index]['title_color']=color;
    $("#goods_color_text").html(color);
}
//名称
function this_goodlist_name(obj,name) {
    var index=$(obj).attr("data-index");
    bannerVM.all_data[bannerVM.now_index]['list'][index]['name']=name;
}
//简介
function this_goodlist_description(obj,description) {
    var index=$(obj).attr("data-index");
    bannerVM.all_data[bannerVM.now_index]['list'][index]['description']=description;
}
//*********************************************商品集end*************************************************//
//*********************************************按钮star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==10){
        $("#form_edit_button").css("display",'block').siblings().css("display",'none');
        var item = {};
        item['this_type']="edit_button";
        item['imgurl']=host+ "addons/yb_shop/core/public/menu/images/kefu.png";//显示图片
        item['name']='点击选择链接';
        var arr=[];
        arr.push(item);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="edit_button";
        new_item['button_name']="按钮";//按钮名称
        new_item['button_radius']="0";//按钮样式
        new_item['button_border']="0";//边框显示
        new_item['button_bg_color']="#0DA3F9";//背景颜色
        new_item['button_title_color']="#ffffff";//背景颜色
        new_item['button_border_color']="#0DA3F9";//边框颜色
        new_item['img_style']="1";//显示图片
        new_item['list'] = arr;
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        // //获取当前增加的幻灯片下标
        bannerVM.now_index = bannerVM.all_data.length-1;
        //右边当前数组=左侧当前幻灯片下标
        bannerVM.edit_button=bannerVM.all_data[bannerVM.now_index]['list'];
    }
})
//按钮名称
function select_button_name(name) {
    bannerVM.all_data[bannerVM.now_index]['button_name']=name;
}
//按钮样式
function select_button_radius(radius) {
    bannerVM.all_data[bannerVM.now_index]['button_radius']=radius;
    $("#button_radius_height").html(radius);
}
//边框
$("input[name='An_Xs']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['button_border']=this.value;
    $(this).parent().addClass("selected").siblings().removeClass("selected");
})
//图标
$("input[name='An_pic']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['img_style']=this.value;
    $(this).parent().addClass("selected").siblings().removeClass("selected");
})
//背景颜色
function button_bj_color(color) {
    bannerVM.all_data[bannerVM.now_index]['button_bg_color']=color;
    $("#AnbgcolorSet_text").html(color);
}
//标题颜色
function button_title_color(color) {
    bannerVM.all_data[bannerVM.now_index]['button_title_color']=color;
    $("#Title_ancolor_text").html(color);
}
//边框颜色
function button_border_color(color) {
    bannerVM.all_data[bannerVM.now_index]['button_border_color']=color;
    $("#Title_bkcolor_text").html(color);
}
//*********************************************按钮end*************************************************//


//*********************************************地理位置star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==11){
        $("#form_edit_position").css("display",'block').siblings().css("display",'none');
        var item = {};
        item['this_type']="position";
        var arr=[];
        arr.push(item);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="position";
        new_item['position_name']="请输入地址描述(限制20字内)";//按钮名称
        new_item['lng']="";
        new_item['lat']="";
        new_item['is_display']="1";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        // //获取当前增加的幻灯片下标
        bannerVM.now_index = bannerVM.all_data.length-1;
        //右边当前数组=左侧当前幻灯片下标
        //bannerVM.edit_button=bannerVM.all_data[bannerVM.now_index]['list'];
    }
})
//坐标名称
function position_name(name){
    bannerVM.all_data[bannerVM.now_index]['position_name']=name;
}
//位置显示方式
$("input[name='positionLayouton']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['is_display']=this.value;
    $(this).parent().addClass("selected").siblings().removeClass("selected");
})
//*********************************************地理位置end*************************************************//
//*********************************************富文本star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==12){
        $("#form_rich_text").css("display",'block').siblings().css("display",'none');
        var item = {};
        item['this_type']="rich_text";
        var arr=[];
        arr.push(item);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="rich_text";
        new_item['content']="请输入";//按钮名称
        new_item['bg_color']="#ffffff";//按钮样式
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        // //获取当前增加的幻灯片下标
        bannerVM.now_index = bannerVM.all_data.length-1;
        //右边当前数组=左侧当前幻灯片下标
        //bannerVM.edit_button=bannerVM.all_data[bannerVM.now_index]['list'];
    }
})
function rich_text_bg(color) {
    bannerVM.all_data[bannerVM.now_index]['bg_color']=color;
    $("#rich_bg_color_text").html(color);
}
//*********************************************富文本end*************************************************//
//*********************************************图片列表star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==13){
        $("#form_edit_piclist").css("display",'block').siblings().css("display",'none');
        bannerVM.add_h=245;
        bannerVM.add_top=145;
        var item = {};
        item['this_type']="edit_piclist";
        item['imgurl'] = host+ "addons/yb_shop/core/public/menu/images/Tplb_3.png";
        item['top'] = 0;
        item['title'] = '标题';
        item['name'] = '链接至';
        var arr=[];
        arr.push(item);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="edit_piclist";
        new_item['layout']="2";  //排版选择
        new_item['pic_style']="1";  //样式选择
        new_item['html_style']="";  //样式选择
        new_item['pic_radius']="0";  //圆角弧度
        new_item['list'] = arr;
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        // //获取当前增加的幻灯片下标
        bannerVM.now_index = bannerVM.all_data.length-1;
        //右边当前数组=左侧当前幻灯片下标
        bannerVM.edit_piclist=bannerVM.all_data[bannerVM.now_index]['list'];
    }
})
//添加一跳空数据
function pic_add_menu() {
    var item = {};
    item['this_type']="edit_piclist";
    item['imgurl'] = host+ "addons/yb_shop/core/public/menu/images/Tplb_3.png";
    item['top'] = bannerVM.edit_piclist.length * 135;
    item['name'] = '链接至';
    item['title'] = '标题';
    bannerVM.add_h += 135;
    bannerVM.add_top += 135;
    bannerVM.edit_piclist.push(item);
}
//公告导航单独一条名称
function this_pic_name(obj,name) {
    var index=$(obj).attr("data-index");
    bannerVM.all_data[bannerVM.now_index]['list'][index]['title']=name;
}
//样式
$("input[name='pureTitlesImg']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['pic_style']=this.value;
    if (this.value==1){
        bannerVM.all_data[bannerVM.now_index]['html_style']="";
    }
    if (this.value==2){
        bannerVM.all_data[bannerVM.now_index]['html_style']="text-align:center;color:#fff;position:absolute;left:0;bottom:-3px;width:100%;line-height:29px;background-color:rgba(0,0,0,.5);text-decoration:inherit; ";
    }
    if (this.value==3){
        bannerVM.all_data[bannerVM.now_index]['html_style']="";
    }
    $(this).parent().addClass("selected").siblings().removeClass("selected");
})
//排版
$("input[name='Tplb_piclistpb']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['layout']=this.value;
    $(this).parent().addClass("selected").siblings().removeClass("selected");
})
//图片弧度
function select_piclist_radius(radius) {
    bannerVM.all_data[bannerVM.now_index]['pic_radius']=radius;
    $("#piclist_radius_span").html(radius);
}
//*********************************************图片列表end*************************************************//
//*********************************************悬浮客服star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==24){

        if ($("#customer_button_this").length>0){
            layer.msg('客服按钮只能添加一个',{icon:5,time:1000});
            return false;
        }
        $("#form_edit_Customer").css("display",'block').siblings().css("display",'none');
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="customer";
        new_item['form_bottom']="235";
        new_item['form_margin']="272";
        new_item['form_transparent']="1";
        new_item['form_icon_transparent']="1";
        new_item['imgurl'] = host+ "addons/yb_shop/core/public/menu/images/service_icon.png";
        new_item['b_form_bottom']="45";
        new_item['b_form_margin']="100";
        new_item['b_form_transparent']="100";
        new_item['b_form_icon_transparent']="100";
        //new_item['bg_color']="#808080";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        // //获取当前增加的幻灯片下标
        bannerVM.now_index = bannerVM.all_data.length-1;
        //右边当前数组=左侧当前幻灯片下标
        bannerVM.customer=bannerVM.all_data[bannerVM.now_index]['list'];
    }
})
//距离底部
function is_Customer_button(button) {
    bannerVM.all_data[bannerVM.now_index]['b_form_bottom']=button;
    bannerVM.all_data[bannerVM.now_index]['form_bottom']=button*4.5;
    $("[name='customer']").css('bottom',bannerVM.all_data[bannerVM.now_index]['form_bottom']);
    $("#Customer_button_text").html(button);
}
//边距
function is_Customer_margin(margin) {
    bannerVM.all_data[bannerVM.now_index]['b_form_margin']=margin;
    bannerVM.all_data[bannerVM.now_index]['form_margin']=margin*2.72;
    $("[name='customer']").css('left', bannerVM.all_data[bannerVM.now_index]['form_margin']);
    $("#Customer_margin_text").html(margin);
}
//透明
function is_Customer_transparent(transparent) {
    bannerVM.all_data[bannerVM.now_index]['b_form_transparent']=transparent;
    bannerVM.all_data[bannerVM.now_index]['form_transparent']=transparent/100;
    $("#Customer_transparent_text").html(transparent);
}
//图标透明
function is_icon_Customer_transparent(transparent) {
    bannerVM.all_data[bannerVM.now_index]['b_form_icon_transparent']=transparent;
    bannerVM.all_data[bannerVM.now_index]['form_icon_transparent']=transparent/100;
    $("#icon_Customer_transparent_text").html(transparent);
}
//背景颜色
function floaticon_bg_color(color){
    bannerVM.all_data[bannerVM.now_index]['bg_color']=color;
}
function get_floaticon_this_type() {
    var type_id=$("#floaticon_this_type").val();
    console.log(type_id);
}
//*********************************************悬浮客服end*************************************************//
//*********************************************电话*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==25){

        if ($("#phone_button_this").length>0){
            layer.msg('电话按钮只能添加一个',{icon:5,time:1000});
            return false;
        }
        $("#form_edit_phone").css("display",'block').siblings().css("display",'none');
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="phone";
        new_item['form_bottom']="335";
        new_item['form_margin']="272";
        new_item['form_transparent']="1";
        new_item['form_icon_transparent']="1";
        new_item['imgurl'] = host+ "addons/yb_shop/core/public/menu/images/tel_icon.png";
        new_item['b_form_bottom']="70";
        new_item['b_form_margin']="100";
        new_item['b_form_transparent']="100";
        new_item['b_form_icon_transparent']="100";
        new_item['phone']="";
        //new_item['bg_color']="#808080";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        // //获取当前增加的幻灯片下标
        bannerVM.now_index = bannerVM.all_data.length-1;
        //右边当前数组=左侧当前幻灯片下标
    }
})
//距离底部
function is_phone_button(button) {
    bannerVM.all_data[bannerVM.now_index]['b_form_bottom']=button;
    bannerVM.all_data[bannerVM.now_index]['form_bottom']=button*4.5;
    $("[name='phone']").css('bottom',bannerVM.all_data[bannerVM.now_index]['form_bottom']);
    $("#phone_button_text").html(button);
}
//边距
function is_phone_margin(margin) {
    bannerVM.all_data[bannerVM.now_index]['b_form_margin']=margin;
    bannerVM.all_data[bannerVM.now_index]['form_margin']=margin*2.72;
    $("[name='phone']").css('left', bannerVM.all_data[bannerVM.now_index]['form_margin']);
    $("#phone_margin_text").html(margin);
}
//透明
function is_phone_transparent(transparent) {
    bannerVM.all_data[bannerVM.now_index]['b_form_transparent']=transparent;
    bannerVM.all_data[bannerVM.now_index]['form_transparent']=transparent/100;
    $("#phone_transparent_text").html(transparent);
}
//图标透明
function is_icon_phone_transparent(transparent) {
    bannerVM.all_data[bannerVM.now_index]['b_form_icon_transparent']=transparent;
    bannerVM.all_data[bannerVM.now_index]['form_icon_transparent']=transparent/100;
    $("#icon_phone_transparent_text").html(transparent);
}
//背景颜色
function phone_bg_color(color){
    bannerVM.all_data[bannerVM.now_index]['bg_color']=color;
}
function set_this_phone(phone) {
    bannerVM.all_data[bannerVM.now_index]['phone']=phone;
}
//*********************************************电话*************************************************//
//*********************************************悬浮按钮star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==14){

        if ($("#floaticon_button_this").length>0){
            layer.msg('悬浮按钮只能添加一个',{icon:5,time:1000});
            return false;
        }
        $("#form_edit_floaticon").css("display",'block').siblings().css("display",'none');
        bannerVM.add_h=245;
        bannerVM.add_top=145;
        var item = {};
        item['this_type']="floaticon";
        item['imgurl'] = host+ "addons/yb_shop/core/public/menu/images/kefu.png";
        item['name']="点击选择链接";
        var arr=[];
        arr.push(item);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="floaticon";
        new_item['form_bottom']="157.5";
        new_item['form_margin']="272";
        new_item['form_transparent']="1";
        new_item['form_icon_transparent']="1";

        new_item['b_form_bottom']="30";
        new_item['b_form_margin']="100";
        new_item['b_form_transparent']="100";
        new_item['b_form_icon_transparent']="100";

       // new_item['bg_color']="#808080";
        new_item['list'] = arr;
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        // //获取当前增加的幻灯片下标
        bannerVM.now_index = bannerVM.all_data.length-1;
        //右边当前数组=左侧当前幻灯片下标
        bannerVM.floaticon=bannerVM.all_data[bannerVM.now_index]['list'];
    }
})
//距离底部
function is_floaticon_button(button) {
    bannerVM.all_data[bannerVM.now_index]['b_form_bottom']=button;
    bannerVM.all_data[bannerVM.now_index]['form_bottom']=button*4.5;
    //bannerVM.all_data[bannerVM.now_index]['form_bottom']=button;
    $("[name='floaticon']").css('bottom',bannerVM.all_data[bannerVM.now_index]['form_bottom']);
    $("#floaticon_button_text").html(button);
}
//边距
function is_floaticon_margin(margin) {
    bannerVM.all_data[bannerVM.now_index]['b_form_margin']=margin;
    bannerVM.all_data[bannerVM.now_index]['form_margin']=margin*2.72;
   // bannerVM.all_data[bannerVM.now_index]['form_margin']=margin;
    $("[name='floaticon']").css('left', bannerVM.all_data[bannerVM.now_index]['form_margin']);
    $("#floaticon_margin_text").html(margin);
}
//透明
function is_floaticon_transparent(transparent) {
    bannerVM.all_data[bannerVM.now_index]['b_form_transparent']=transparent;
    bannerVM.all_data[bannerVM.now_index]['form_transparent']=transparent/100;
    $("#floaticon_transparent_text").html(transparent);
}
//图标透明
function is_icon_floaticon_transparent(transparent) {
    bannerVM.all_data[bannerVM.now_index]['b_form_icon_transparent']=transparent;
    bannerVM.all_data[bannerVM.now_index]['form_icon_transparent']=transparent/100;
    $("#icon_floaticon_transparent_text").html(transparent);
}
//背景颜色
function floaticon_bg_color(color){
    bannerVM.all_data[bannerVM.now_index]['bg_color']=color;
}
//*********************************************悬浮按钮end*************************************************//
//*********************************************视频star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==15){
        $("#form_edit_video").css("display",'block').siblings().css("display",'none');
        var item = {};
        item['this_type']="edit_video";
        var arr=[];
        arr.push(item);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="edit_video";
        new_item['video_height']="150";
        new_item['video_url']="";
        new_item['imgurl']="";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        bannerVM.now_index = bannerVM.all_data.length-1;
    }
})
//视频高度
function is_vidoe_height(height) {
    bannerVM.all_data[bannerVM.now_index]['video_height']=height;
    $("#is_vidoe_height_text").html(height);
}
//视频链接
function video_url(url) {
    bannerVM.all_data[bannerVM.now_index]['video_url']=url;
}
//*********************************************视频end*************************************************//
//*********************************************评论star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==16){
        $("#form_edit_comment").css("display",'block').siblings().css("display",'none');
        var item = {};
        item['this_type']="comment";
        var arr=[];
        arr.push(item);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="comment";
        new_item['is_display']="1";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        // //获取当前增加的幻灯片下标
        bannerVM.now_index = bannerVM.all_data.length-1;
    }
})
//显示条数
function is_comment_count(count){
    bannerVM.all_data[bannerVM.now_index]['is_display']=count;
    $('#is_comment_count_text').html(count);
}
//*********************************************评论end*************************************************//
//*********************************************音频star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==17){

        if ($("#edit_music").length>0){
            layer.msg('音频只能添加一个',{icon:5,time:1000});
            return false;
        }

        $("#form_edit_audio").css("display",'block').siblings().css("display",'none');
        var item = {};
        item['this_type']="edit_music";
        var arr=[];
        arr.push(item);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="edit_music";
        new_item['music_url']="";
        new_item['imgurl']="";
        new_item['title']="音乐名称";
        new_item['author']="作者";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        bannerVM.now_index = bannerVM.all_data.length-1;
    }
})
//链接
function music_url(url) {
    bannerVM.all_data[bannerVM.now_index]['music_url']=url;
}
//获取标题
function get_this_music_title(title) {
    bannerVM.all_data[bannerVM.now_index]['title']=title;
}
//获取作者
function get_this_music_author(title) {
    bannerVM.all_data[bannerVM.now_index]['author']=title;
}
//*********************************************音频end*************************************************//
//*********************************************拼团star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==18){

        $("#form_fight_group").css("display",'block').siblings().css("display",'none');
        bannerVM.add_h=245;
        bannerVM.add_top=145;
        var item = {};
        item['this_type']="fight_group";
        item['name']="标题";
        item['description']="内容描述";
        item['imgurl']=host+ "addons/yb_shop/core/public/menu/images/Tpj_3.png";
        item['top']=0;
        var arr=[];
        arr.push(item);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="fight_group";
        new_item['title_size']="15";
        new_item['bg_color']="#ffffff";
        new_item['title_color']="#000000";
        new_item['layout']="1";
        new_item['style_width']="";
        new_item['style_height']="";
        new_item['list'] = arr;
        new_item['add_type']="1";
        new_item['add_num']="1";
        new_item['add_sort']="time";
        new_item['add_cate']="0";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        // //获取当前增加的幻灯片下标
        bannerVM.now_index = bannerVM.all_data.length-1;
        //右边当前数组=左侧当前幻灯片下标
        bannerVM.fight_group_list=bannerVM.all_data[bannerVM.now_index]['list'];
    }
})
//添加一条空数据
function fight_group_add_menu() {
    var item = {};
    item['this_type']="fight_group";
    item['name']="标题";
    item['description']="内容描述";
    item['imgurl']=host+ "addons/yb_shop/core/public/menu/images/Tpj_3.png";
    item['top'] = bannerVM.fight_group_list.length * 135;
    bannerVM.add_h += 135;
    bannerVM.add_top += 135;
    bannerVM.fight_group_list.push(item);
}
$("input[name='fontsize_group']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['title_size']=this.value;
    $(this).prop("checked", "checked");
})
//标题颜色
function group_title_color(color) {
    bannerVM.all_data[bannerVM.now_index]['title_color']=color;
}
//背景颜色
function group_bg_color(color) {
    bannerVM.all_data[bannerVM.now_index]['bg_color']=color;
}
//*********************************************拼团end*************************************************//
//*********************************************三方图star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==19){
        $("#form_edit_tripartite").css("display",'block').siblings().css("display",'none');
        bannerVM.add_h=245;
        bannerVM.add_top=145;
        var item = {};
        item['this_type']="tripartite";
        item['img']=host+ "addons/yb_shop/core/public/menu/images/11red.PNG";
        item['top'] =0;
        var item1 = {};
        item1['this_type']="tripartite";
        item1['img']=host+ "addons/yb_shop/core/public/menu/images/21blue.PNG";
        item1['top'] = 135;
        var item2 = {};
        item2['this_type']="tripartite";
        item2['img']=host+ "addons/yb_shop/core/public/menu/images/21yellow.PNG";
        item2['top'] = 270;
        var arr=[];
        arr.push(item);
        arr.push(item1);
        arr.push(item2);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="tripartite";
        new_item['list']=arr;
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        // //获取当前增加的幻灯片下标
        bannerVM.now_index = bannerVM.all_data.length-1;
        //右边当前数组=左侧当前幻灯片下标
        bannerVM.tripartite_list=bannerVM.all_data[bannerVM.now_index]['list'];
    }
})
//*********************************************三方图end*************************************************//
//*********************************************四方图star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==20){
        $("#form_edit_quartet").css("display",'block').siblings().css("display",'none');
        bannerVM.add_h=245;
        bannerVM.add_top=145;
        var item = {};
        item['this_type']="quartet";
        item['img']=host+ "addons/yb_shop/core/public/menu/images/23blue.PNG";
        item['top'] =0;
        var item1 = {};
        item1['this_type']="quartet";
        item1['img']=host+ "addons/yb_shop/core/public/menu/images/11blue.PNG";
        item1['top'] = 135;
        var item2 = {};
        item2['this_type']="quartet";
        item2['img']=host+ "addons/yb_shop/core/public/menu/images/11red.PNG";
        item2['top'] = 270;
        var item3 = {};
        item3['this_type']="quartet";
        item3['img']=host+ "addons/yb_shop/core/public/menu/images/11yellow.PNG";
        item3['top'] = 405;
        var arr=[];
        arr.push(item);
        arr.push(item1);
        arr.push(item2);
        arr.push(item3);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="quartet";
        new_item['list']=arr;
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        // //获取当前增加的幻灯片下标
        bannerVM.now_index = bannerVM.all_data.length-1;
        //右边当前数组=左侧当前幻灯片下标
        bannerVM.quartet_list=bannerVM.all_data[bannerVM.now_index]['list'];
    }
})
//*********************************************四方图end*************************************************//

//*********************************************公告star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==26){

        // if ($("#set_announcement").length>0){
        //     layer.msg('公告只能添加一个',{icon:5,time:1000});
        //     return false;
        // }
        $("#form_edit_announcement").css("display",'block').siblings().css("display",'none');
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="announcement";

        new_item['imgurl'] = host+ "addons/yb_shop/core/public/menu/images/hotdot.png";
        new_item['bg_color']="#ffffff";
        new_item['color']="#000000";
        new_item['title']="";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        // //获取当前增加的幻灯片下标
        bannerVM.now_index = bannerVM.all_data.length-1;
        //右边当前数组=左侧当前幻灯片下标
    }
})
//文字颜色
function this_announcement_color(val) {
    bannerVM.all_data[bannerVM.now_index]['color']=val;
}
//背景颜色
function this_announcement_bg_color(val) {
    bannerVM.all_data[bannerVM.now_index]['bg_color']=val;
}
//内容
function this_announcement_textarea(val) {
    bannerVM.all_data[bannerVM.now_index]['title']=val;
}
//*********************************************公告end*************************************************//
//*********************************************流量主*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==27){

        // if ($("#set_announcement").length>0){
        //     layer.msg('公告只能添加一个',{icon:5,time:1000});
        //     return false;
        // }
        $("#form_edit_ad").css("display",'block').siblings().css("display",'none');
        //左边幻灯片增加数据
        var new_item ={};
        new_item['img']=host+ "addons/yb_shop/core/public/menu/images/tencent_app.jpg";
        new_item['type']="ad";
        new_item['ad_id']="0";
        new_item['height']="140";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        // //获取当前增加的幻灯片下标
        bannerVM.now_index = bannerVM.all_data.length-1;
        //右边当前数组=左侧当前幻灯片下标
    }
})
function select_ad_height(val) {
    bannerVM.all_data[bannerVM.now_index]['height']=val;
    $("#what_ad_height").html(val);
}
function set_ad_ad_id(val) {
    bannerVM.all_data[bannerVM.now_index]['ad_id']=val;
}
//*********************************************流量主*************************************************//
//*********************************************门店*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==22){
        $("#form_edit_store_door").css("display",'block').siblings().css("display",'none');
        var item = {};
        item['this_type']="store_door";
        var arr=[];
        arr.push(item);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="store_door";
        new_item['door_name']="门店名称";
        new_item['door_job']="8:00-18:00";
        new_item['door_phone']="";
        new_item['imgurl']=host+ "addons/yb_shop/core/public/menu/images/business.png";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        bannerVM.now_index = bannerVM.all_data.length-1;
    }
})
function  door_name_set(val) {
    bannerVM.all_data[bannerVM.now_index]['door_name']=val;
}
function  door_job_time(val) {
    bannerVM.all_data[bannerVM.now_index]['door_job']=val;
}
function  door_phone_set(val) {
    bannerVM.all_data[bannerVM.now_index]['door_phone']=val;
}
//*********************************************门店*************************************************//
//*********************************************留言板*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==21){
        $("#form_message_board").css("display",'block').siblings().css("display",'none');
        var item = {};
        item['this_type']="message_board";
        var arr=[];
        arr.push(item);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="message_board";
        new_item['imgurl']="";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        bannerVM.now_index = bannerVM.all_data.length-1;
    }
})
//*********************************************留言板*************************************************//
//*********************************************表单star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==23){
        if ($("#edit_form_this").length>0){
            layer.msg('首页表单只能添加一个',{icon:5,time:1000});
            return false;
        }
        $("#form_edit_form").css("display",'block').siblings().css("display",'none');
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="edit_form";
        new_item['imgurl']=host+ "addons/yb_shop/core/public/menu/images/choose_form.jpg";
        new_item['param']="0";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        bannerVM.now_index = bannerVM.all_data.length-1;
    }
})
function get_form_info(item) {
    bannerVM.all_data[bannerVM.now_index]['imgurl']=item['img'];
    bannerVM.all_data[bannerVM.now_index]['param']=item['param'];
}
//链接
function music_url(url) {
    bannerVM.all_data[bannerVM.now_index]['music_url']=url;
}
//获取标题
function get_this_music_title(title) {
    bannerVM.all_data[bannerVM.now_index]['title']=title;
}
//获取作者
function get_this_music_author(title) {
    bannerVM.all_data[bannerVM.now_index]['author']=title;
}
//*********************************************表单end*************************************************//
//*********************************************底部导航*************************************************//
function di_select(){
    $("#form_edit_bottom").css("display",'block').siblings().css("display",'none');
}
function set_nab_name(name) {
    bannerVM.nab_name=name;
}
function fontColorSet_set(color) {
    bannerVM.font_color=color;
    $("#fontColorSet_text").html(color);
}
function iconColorSet_set(color) {
    $("#iconColorSet_text").html(color);
}
function pureBorderColor_set(color) {
    bannerVM.db_color=color;
    $("#pureBorderColor_text").html(color);
}
function DhColor_set(color) {
    $("#fontColorSet_text").html(color);
}
//底部导航单独一条名称
function this_di_name(obj,name) {
    var index=$(obj).attr("data-index");
    //bannerVM.all_data[bannerVM.now_index]['list'][index]['name']=name;
    bannerVM.menu_list[index]['name'] = name;
}
//是否显示底部导航
$("input[name='IsDiDisplay']").click(function () {
    $(this).prop("checked", "checked");
    bannerVM.is_di_dis=eval(this.value.toLowerCase());
    console.log( bannerVM.is_di_dis);
})
/**
 * 上移组件
 */
function tool_up_vue(){
    //获取组件index
    //当前index
    var index=bannerVM.now_index;
    if (index==0){
        return false;
    }
    //当前的元素
    var Option = bannerVM.all_data[bannerVM.now_index];
    //上面那个元素
    var tempOption = bannerVM.all_data[index - 1];

    Vue.set(bannerVM.all_data, index - 1, Option);
    Vue.set(bannerVM.all_data, index, tempOption);

    bannerVM.now_index= bannerVM.now_index-1;

}
function tool_down_vue() {
    var index=bannerVM.now_index;
    if (index==bannerVM.all_data.length-1){
        return false;
    }
    //当前的元素
    var Option = bannerVM.all_data[bannerVM.now_index];
    //下面那个元素
    var tempOption = bannerVM.all_data[index + 1];
    //  console.log(index);
    //console.log(tempOption);
    Vue.set(bannerVM.all_data, index + 1, Option);
    Vue.set(bannerVM.all_data, index, tempOption);
    bannerVM.now_index= bannerVM.now_index+1;
}
//*********************************************底部导航*************************************************//
//*********************************************头部导航*************************************************//
function head_info() {
    $("#form_edit_head").css("display",'block').siblings().css("display",'none');

}
function WinColor_set(color) {
    bannerVM.win_color=color;
    $("#WinColor_text").html(color);
    console.log(bannerVM.win_color);
}

function del_win_img() {
    bannerVM.win_img='';
    $("#win_img").attr('src','');
}
//*********************************************头部导航*************************************************//
//(回调函数)
function PopUpCallBack(img_id, img_src, this_id, com,type) {

    if (type=='phone'){
        bannerVM.all_data[bannerVM.now_index]['imgurl']=img_src;
        $("#phone_img").attr('src',img_src);
    }
    if (type=='win_img'){
        bannerVM.win_img=img_src;
        $("#win_img").attr('src',img_src);
    }

    if (type=='customer'){
        bannerVM.all_data[bannerVM.now_index]['imgurl']=img_src;
        $("#Customer_img").attr('src',img_src);
    }

    if (type=='announcement'){
        bannerVM.all_data[bannerVM.now_index]['imgurl']=img_src;
        $("#announcement_img").attr('src',img_src);
    }

    if (type=='edit_video'){
        bannerVM.all_data[bannerVM.now_index]['imgurl']=img_src;
      $("#this_video_img").attr('src',img_src);
    }
    if (type=='edit_music'){
        bannerVM.all_data[bannerVM.now_index]['imgurl']=img_src;
        $("#this_music_img").attr('src',img_src);
    }
    if (type=='store_door'){
        bannerVM.all_data[bannerVM.now_index]['imgurl']=img_src;
        $("#this_door_img").attr('src',img_src);
    }
    if (type=='tripartite'){
        var new_item = bannerVM.tripartite_list[this_id];
        new_item['img'] = img_src;
        Vue.set(bannerVM.tripartite_list,this_id,new_item);
    }
    if (type=='quartet'){
        var new_item = bannerVM.quartet_list[this_id];
        new_item['img'] = img_src;
        Vue.set(bannerVM.quartet_list,this_id,new_item);
    }
    if (type=='floaticon'){
        var new_item = bannerVM.floaticon[this_id];
        new_item['imgurl'] = img_src;
        Vue.set(bannerVM.floaticon,this_id,new_item);
        var item={};
        item['imgurl'] = img_src;
        var arr=[];
        arr.push(item);
        bannerVM.all_data[bannerVM.now_index]['imgurl']= img_src;
    }
    if (type=='edit_button'){
        var new_item = bannerVM.edit_button[this_id];
        new_item['imgurl'] = img_src;
        Vue.set(bannerVM.edit_button,this_id,new_item);
        var item={};
        item['imgurl'] = img_src;
        var arr=[];
        arr.push(item);
        bannerVM.all_data[bannerVM.now_index]['imgurl']= img_src;
    }
    if (type=='navigation'){
        var new_item = bannerVM.catenav[this_id];
        new_item['imgurl'] = img_src;
        Vue.set(bannerVM.catenav,this_id,new_item);
        var item={};
        item['imgurl'] = img_src;
        var arr=[];
        arr.push(item);
    }
    if (type=='edit_piclist'){
        var new_item = bannerVM.edit_piclist[this_id];
        new_item['imgurl'] = img_src;
        Vue.set(bannerVM.edit_piclist,this_id,new_item);
        var item={};
        item['imgurl'] = img_src;
        var arr=[];
        arr.push(item);
    }
    if (type=='banner'){
        var new_item = bannerVM.banner[this_id];
        new_item['imgurl'] = img_src;
        new_item['img_dis'] = 'block';
        Vue.set(bannerVM.banner,this_id,new_item);
        var item={};
        item['imgurl'] = img_src;
        var arr=[];
        arr.push(item);

        bannerVM.all_data[bannerVM.now_index]['topimg']= bannerVM.banner[0]['imgurl'];
    }
    if (type=='advert'){
        var new_item = bannerVM.advert[this_id];
        new_item['imgurl'] = img_src;
        Vue.set(bannerVM.advert,this_id,new_item);
        var item={};
        item['imgurl'] = img_src;
        var arr=[];
        arr.push(item);
        bannerVM.all_data[bannerVM.now_index]['topimg']= img_src;
    }
    if (type=='article'){
        var new_item = bannerVM.imgtextlist[this_id];
        new_item['imgurl'] = img_src;
        Vue.set(bannerVM.imgtextlist,this_id,new_item);
    }
    if (type=='fight_group'){
        var new_item = bannerVM.fight_group_list[this_id];
        new_item['imgurl'] = img_src;
        Vue.set(bannerVM.fight_group_list,this_id,new_item);
    }
    if (type == 'page_icon') {
        var new_item = bannerVM.menu_list[this_id];
        new_item['page_icon'] = img_src;
        Vue.set(bannerVM.menu_list, this_id, new_item);
    }
    if (type == 'page_select_icon') {
        var new_item = bannerVM.menu_list[this_id];
        new_item['page_select_icon'] = img_src;
        Vue.set(bannerVM.menu_list, this_id, new_item);
    }
}
function get_not_attr_di(id, item) {
    var new_item = bannerVM.menu_list[id];
    //console.log(item);
    if (item['key']=='applets'){
        new_item['key'] = item['key'];
        new_item['name_this'] = item['name'];
        new_item['appid'] = item['appid'];
        new_item['ident'] = item['ident'];
        new_item['path'] = '';
    }
    else if(item['key']=='web_page'){
        new_item['key'] = item['key'];
        new_item['name_this'] = item['name'];
        new_item['path'] = item['url'];
        new_item['ident'] = item['ident'];
        new_item['appid'] = '';
    }
    else if(item['key']=='call_phone'){
        new_item['key'] = item['key'];
        new_item['name_this'] = item['name'];
        new_item['phone'] = item['phone'];
        new_item['ident'] = item['ident'];
        new_item['appid'] = '';
        new_item['path'] = '';
    }
    else if(item['key']=='map'){
        new_item['key'] = item['key'];
        new_item['name_this'] = item['name'];
        new_item['lat'] = item['lat'];
        new_item['lng'] = item['lng'];;
        new_item['ident'] = item['ident'];
        new_item['appid'] = '';
        new_item['phone'] = '';
        new_item['path'] = '';
    }
    else {
        new_item['key'] = item['key'];
        new_item['imgurl'] = removeAllSpace(item['imgurl']);
        new_item['name_this'] = item['name'];
        new_item['ident'] = 1;
        new_item['path'] = '';
        new_item['appid'] = '';
    }
   Vue.set(bannerVM.menu_list, id, new_item);
}
//获取pagesURL
function get_not_attr(index,item) {
    var new_item=bannerVM.all_data[bannerVM.now_index]['list'][index];
    new_item['pagesurl']= removeAllSpace("/yb_shop/"+item['imgurl']);
    new_item['name']=item['name'];
    if (bannerVM.this_type=="floaticon"){
        Vue.set(bannerVM.floaticon,index,new_item);
    }
    if (bannerVM.this_type=="edit_button"){
        Vue.set(bannerVM.edit_button,index,new_item);
    }
    if (bannerVM.this_type=="banner"){
        Vue.set(bannerVM.banner,index,new_item);
    }
    if (bannerVM.this_type=="advert"){
        Vue.set(bannerVM.advert,index,new_item);
    }
    if (bannerVM.this_type=="navigation"){
        new_item['alias']=item['name'];
        Vue.set(bannerVM.catenav,index,new_item);
    }
    if (bannerVM.this_type=="article"){
        Vue.set(bannerVM.imgtextlist,index,new_item);
    }
    if (bannerVM.this_type=="edit_piclist"){
        Vue.set(bannerVM.edit_piclist,index,new_item);
    }
    if (bannerVM.this_type=="tripartite"){
        Vue.set(bannerVM.tripartite_list,index,new_item);
    }
    if (bannerVM.this_type=="quartet"){
        Vue.set(bannerVM.quartet_list,index,new_item);
    }
}
function get_position(lat,lng) {
    bannerVM.all_data[bannerVM.now_index]['lat']=lat;
    bannerVM.all_data[bannerVM.now_index]['lng']=lng;
    $('#lng').val(lng);
    $('#lat').val(lat);
}
//获取pagesURL
function get_images(index,item,a,b,c,this_index) {

    var new_item =bannerVM.all_data[bannerVM.now_index]['list'][this_index];

    if (item['type']=='applets'){
        new_item['name'] = item['name'];
        new_item['key'] = item['key'];
        new_item['appid'] = item['appid'];
        new_item['path'] = '';
        new_item['type'] = item['type'];
    }else if(item['type']=='web_page'){
        new_item['name'] = item['name'];
        new_item['title'] = item['name'];
        new_item['key'] = item['key'];
        new_item['path'] = item['path'];
        new_item['type'] = item['type'];
    }
    else {
        if (typeof(item['imgurl'])!="undefined"){
            new_item['pagesurl'] = removeAllSpace("/yb_shop/"+a+"/"+b+"/"+c+"?id="+item['param']);
        }
        if (typeof(item['link'])!="undefined"&&item['link']!=''){
            new_item['pagesurl'] = "/yb_shop/pages/web/index?url="+escape(item['link'])+"&name="+ item['name'];
        }
        new_item['key'] = 1;
        new_item['name'] = item['name'];
        new_item['param'] = item['param'];
        new_item['type'] = item['type'];
    }

    if (bannerVM.this_type=="banner"){
        Vue.set(bannerVM.banner,this_index,new_item);
    }
    if (bannerVM.this_type=="edit_piclist"){
        Vue.set(bannerVM.edit_piclist,index,new_item);
    }
    if (bannerVM.this_type=="advert"){
        Vue.set(bannerVM.advert,this_index,new_item);
    }
    if (bannerVM.this_type=="navigation"){
        new_item['alias'] = item['name'];
        Vue.set(bannerVM.catenav,this_index,new_item);
    }
    if (bannerVM.this_type=="article"){
        new_item['description'] = item['short_title'];
        new_item['imgurl'] = item['img_path'];
        console.log(item);
        Vue.set(bannerVM.imgtextlist,this_index,new_item);
    }
    if (bannerVM.this_type=="fight_group"){
        new_item['name'] = item['name'];
       new_item['imgurl'] = item['img_path'];
        Vue.set(bannerVM.fight_group_list,this_index,new_item);
    }
    if (bannerVM.this_type=="goods"){
        new_item['description'] = item['short_title'];
        new_item['imgurl'] = item['img_path'];
        new_item['price'] =item['price'];
        Vue.set(bannerVM.goodlist,this_index,new_item);
    }
    if (bannerVM.this_type=="tripartite"){
        Vue.set(bannerVM.tripartite_list,this_index,new_item);
    }
    if (bannerVM.this_type=="quartet"){
        Vue.set(bannerVM.quartet_list,this_index,new_item);
    }
}
//保存
$("#saveButon").click(function () {
    var BtColor_color = '';
    iconTitColor_color = $("#fontColorSet").val();
    iconColorSet_color = $("#iconColorSet").val();
    pureBorderColor_color = $("#pureBorderColor").val();
        DhColor_color = $("#DhColor").val();
        BjColor_color = $("#BjColor").val();
    var BtColor=$('input:radio[name="BtBorderColor"]:checked').val();
    if (BtColor == 1) {
        BtColor_color = '#ffffff';
    } else {
        BtColor_color = '#000000'
    }
    console.log(bannerVM._data);
    console.log(123)
    return;
    $.ajax({
        type : "post",
        url : host+"addons/yb_shop/core/index.php?s=/admin/menu/index_module",
        data : {
            'index_list':JSON.stringify(bannerVM._data),
            'BtColor_color': BtColor_color,
            'DhColor_color': DhColor_color,
            'BjColor_color': BjColor_color,
            'win_color': bannerVM.win_color,
            'win_img': bannerVM.win_img,
            'wx_name':bannerVM.nab_name,
            'is_di_dis':bannerVM.is_di_dis,
            'iconTitColor_color': iconTitColor_color,
            'iconColorSet_color': iconColorSet_color,
            'pureBorderColor_color': pureBorderColor_color,
            'menu_list': JSON.stringify(bannerVM.menu_list)
        },
        success : function(data) {
               if(data['code']>0){

                   layer.msg('添加成功!',{icon:1,time:1000});
                   flag = false;
               }

               else{

                   flag = false;

                   layer.msg(data['message'],{icon:5,time:1000});

               }
        }
    });
})

//打开一个子窗口
function lay_open(title, url, w, h) {
    layer.open({
        type: 2,
        area: [w, h],
        fix: false, //不固定
        maxmin: true,
        shade: 0.4,
        title: title,
        content: url,
        scrollbar: false
    });
}
//比例计算
function gcd(w, h) {
    if(w % h)
        return gcd(h, w % h);
    else
        return h;
}
function removeAllSpace(str) {
    return str.replace(/\s+/g, "");
}
});
