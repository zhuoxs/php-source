require(['vue','VueDragging',"util","angular",'html2canvas'], function (Vue,VueDragging,util,angular,html2canvas) {
var snap = location.href;
var cuff = snap.split('web/index.php');
var host = cuff[0];
var hosts =location.href+'web/index.php';
var imgroot = window.sysinfo.attachurl;
// console.log('window.sysinfo.attachurl')
// console.log(window.sysinfo.attachurl)
// <li class="ui-draggable abc">
//     <div class="couponslist-box" style="background: yellow;">
//         <div class='couponsList' style="background: red">
//             <div class='clTit'>
//                 <p style="color: #f0f">立即领取</p>
//             </div>
//             <div class='clLine'></div>
//             <div class='clCont'>
//                 <div class='clBigmoney'>
//                     <p style="color: #f0f">¥</p>
//                     <p style="color: #f0f">{{g.mj_price}}</p>
//                 </div>
//                 <div class='clLitmoney' style="color: red;background: blue;">满{{g.m_price}}元可用</div>
//             </div>
//         </div>
//     </div>
// </li>
/** -----------------------------------------------------------组件 start-------------------------------------------------------------- */
//优惠券集
Vue.component('coupons', {
    props: ['list','index','color_a','color_b','color_c','color_d'],
    template: '<li title="点击进行修改,拖动交换位置." class="ui-draggable"><div v-on:click="del_left(index)" class="deleteButton"></div><div v-on:click="onc_banner(index,$event)" class="cubeNavigationArea column-2 clearfix"><div class="couponslist-box" :style="{background: color_a}"><div class="couponsList" :style="{background: color_b}" v-for="g in list" ><div class="clTit"><p :style="{color: color_d}">立即领取</p></div><div class="clLine" style="borderLeftWidth:1pxborderLeftStyle:dashed" :style="{borderLeftColor: color_d}"><span class="span-dot-a" :style="{background: color_a}"></span><span class="span-dot-b" :style="{background: color_a}"></span></div><div class="clCont"><div class="clBigmoney"><p :style="{color:color_d}">¥</p><p :style="{color: color_d}">{{g.mj_price}}</p></div><div class="clLitmoney" :style="{color:color_b,background:color_c}">满{{g.m_price}}元可用</div></div></div></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#from_edit_couponslist").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#from_edit_couponslist").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});


            bannerVM.couponslist=bannerVM.all_data[index]['list'];
            console.log('bannerVM.couponslist')
            console.log(bannerVM.couponslist)
            bannerVM.add_h = bannerVM.storelist.length *135+135;
            bannerVM.add_top = bannerVM.storelist.length *135+15;
            bannerVM.now_index = index;
        },
    },
})

//轮播图
Vue.component('banner', {
    props: ['topimg','jiaodian_color','index','list','ly_height','juedui_height','jiaodian_dots'],
    template: '<li :style="'+"'height:'"+'+juedui_height+'+"'px;'"+'" class="ui-draggable pr" title="点击进行修改,拖动交换位置."><div v-on:click="del_left(index)" class="deleteButton"></div><div class="swiperImg"><div v-on:click="onc_banner(index,$event)" class="imgList"><ul><li><img :src="topimg"></li></ul></div><div class="buttle" :style="'+"'display:'"+'+jiaodian_dots+'+"';'"+'"><i  v-on:click="select_jiaodian(index)" v-for="(right,index) in list" :style="'+"'background:'"+'+jiaodian_color+'+"';'"+'" class="on"></i></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_banner").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            console.log(index);
            $("#rich-box").css({zIndex: -100,opacity: 0});
            $(".activeMod").children().children().removeClass('yb_select');
            //$(e.target).parents().find('.ui-draggable').eq(index).addClass('select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            //$(e.target).parent().parent().parent().parent().parent().addClass("clicked").siblings().removeClass('clicked');
            $("#form_edit_banner").css("display",'block').siblings().css("display",'none');
            bannerVM.banner=bannerVM.all_data[index]['list'];
            $('#banner_color_r').val(bannerVM.all_data[index]['jiaodian_color']);
            $('#banner_height').val(bannerVM.all_data[index]['ly_height']);

            $('#this_banner_height').html(bannerVM.all_data[index]['ly_height']*10);
            $("#banner_color_text").html(bannerVM.all_data[index]['jiaodian_color']);
            $('#banner_width').val(bannerVM.all_data[index]['ly_width']);
            bannerVM.add_h = bannerVM.banner.length *135+135;
            bannerVM.add_top = bannerVM.banner.length *135+15;
            bannerVM.now_index = index;

            // Vue.set(example1.items, 0, bannerVM.all_data[index]['list'];)
        },
        select_jiaodian:function (index) {
            this.onc_banner(this.index);
            //console.log();
            //console.log(index);
            for (var i=0;i<bannerVM.banner.length;i++){
                if (i==index){
                    bannerVM.all_data[bannerVM.now_index]['topimg']= bannerVM.banner[index]['imgurl'];
                    bannerVM.banner[index]['jiaodian_color']=bannerVM.all_data[bannerVM.now_index]['jiaodian_color'];
                }else {
                    bannerVM.banner[i]['jiaodian_color']='#898989';
                }
            }


        }
    },
})
//广告位
Vue.component('advert', {
    props: ['imgurl','index','list','ly_width','ly_height','juedui_height'],
    template: '<li :style="'+"'width:'"+'+100+'+"'%;height:'"+'+juedui_height+'+"'px;'"+'" class="ui-draggable" data-title="点击拖动到左侧" title="点击进行修改,拖动交换位置."><div v-on:click="del_left(index)" class="deleteButton"></div><div class="swiperImg pr"><div v-on:click="onc_banner(index,$event)" class="imgList"><ul><li style="float:left;" v-for="right in list" :style="'+"'width:'"+'+right.width+'+"'%;'"+""+'"><img style="height: 100%" :src="right.imgurl"></li></ul></div><div class="buttle" style="display: block;"></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_advert").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            //$(e.target).parent().parent().parent().parent().parent().parent().addClass("clicked").siblings().removeClass('clicked');
            $("#form_edit_advert").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
            bannerVM.advert=bannerVM.all_data[index]['list'];
            $('#advert_width').val(bannerVM.all_data[index]['ly_width']);
            $('#advert_height').val(bannerVM.all_data[index]['ly_height']);

            $('#what_advert_height').html(bannerVM.all_data[index]['ly_height']*10);

            bannerVM.add_h = bannerVM.advert.length *135+135;
            bannerVM.add_top = bannerVM.advert.length *135+15;
            bannerVM.now_index = index;
        },
    },
})
//宫格导航
Vue.component('navigation', {
    props: ['index','list','font_size','color','radian','layout'],
    template: '<li class="ui-draggable" title="点击进行修改,拖动交换位置."><div v-on:click="del_left(index)" class="deleteButton"></div><div v-on:click="onc_banner(index,$event)" :class="layout"><div v-for="c in list" class="cubeLink cubeLink1 Ggdh" style="height:100px"> <a class="cubeLink_a" href="javascript:;"> <div class="cubeLink_bg"></div> <div class="cubeLink_curtain"></div> <div class="cubeLink_ico icon-cube" :style="'+"'background-image:url('"+'+c.imgurl+'+"');border-radius:'"+'+radian+'+"'px;'"+'"></div> <div class="cubeLink_text g_link"> <div  :style="'+"'font-size:'"+'+font_size+'+"'px;color:'"+'+color+'+"';'"+'"  class="cubeLink_text_p "><em>{{c.name}}</em> <p class="cubeLink_subText_p"></p> </div> </div> </a> </div>    </div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#from_edit_iconnav").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {

            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');


            $("#from_edit_iconnav").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
            bannerVM.catenav=bannerVM.all_data[index]['list'];
            $('#catenav_corners').val(bannerVM.all_data[index]['radian']);
            $('#catenav_corners_height').val(bannerVM.all_data[index]['radian']);
            $('#catenav_color').val(bannerVM.all_data[index]['color']);

            $("#catenav_color_text").html(bannerVM.all_data[index]['color']);

            if (bannerVM.all_data[index]['font_size']==12){
                $("#Ggdh_fontsize_s").prop("checked", "checked");
            }
            else if (bannerVM.all_data[index]['font_size']==14){
                $("#Ggdh_fontsize_m").prop("checked", "checked");
            }
            else{
                $("#Ggdh_fontsize_l").prop("checked", "checked");
            }

            if (bannerVM.all_data[index]['layout'].replace(/[^0-9]/ig,"")==2) {
                $("#editlayout_2").prop("checked", "checked");
            }
            else if(bannerVM.all_data[index]['layout'].replace(/[^0-9]/ig,"")==3){
                $("#editlayout_3").prop("checked", "checked");
            }
            else if(bannerVM.all_data[index]['layout'].replace(/[^0-9]/ig,"")==4){
                $("#editlayout_4").prop("checked", "checked");
            }
            else {
                $("#editlayout_5").prop("checked", "checked");
            }

            bannerVM.add_h = bannerVM.catenav.length *135+135;
            bannerVM.add_top = bannerVM.catenav.length *135+15;
            bannerVM.now_index = index;
        },
    },
})
//标题
Vue.component('headline', {
    props: ['name','index','list','font_size','color','bg_color','layout','time_key'],
    // template: '<li class="ui-draggable" title="点击进行修改,拖动交换位置." name="id_title"><div v-on:click="del_left(index)" class="deleteButton"></div><div v-on:click="onc_banner(index,$event)" style="" :style="'+"'background-color:'"+'+bg_color+'+"';'"+'" class="pureText"><div class="wrap"><a  class="aframe"></a><span class="middle_titleO"></span><span class="seven_titleO"></span><span :style="'+"'font-size:'"+'+font_size+'+"'px;color:'"+'+color+'+"';'"+'" class="Bt_title">{{name}}</span><span class="seven_titleS"></span><span class="middle_titleS"></span></div></div></li>',
    template: '<li :id="\'title_\'+time_key" class="ui-draggable" title="点击进行修改,拖动交换位置." name="id_title"><div v-on:click="del_left(index)" class="deleteButton"></div><div v-on:click="onc_banner(index,$event)" style="" :style="'+"'background-color:'"+'+bg_color+'+"';'"+'" class="pureText"><div class="wrap"><a  class="aframe"></a><span class="middle_titleO"></span><span class="seven_titleO"></span><span :style="\'font-size:\'+ font_size+\'px;color:\'+color" class="Bt_title">{{name}}</span><span class="seven_titleS"></span><span class="middle_titleS"></span></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_title").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_title").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
            bannerVM.columntitle=bannerVM.all_data[index]['list'];
            $('#titlebgcolorSet').val(bannerVM.all_data[index]['bg_color']);
            $('#Bt_TitlecolorSet').val(bannerVM.all_data[index]['color']);
            $('#Bt_textarea').val(bannerVM.all_data[index]['name']);
            $("#Bt_TitlecolorSet_text").html(bannerVM.all_data[index]['color']);
            $("#titlebgcolorSet_text").html(bannerVM.all_data[index]['bg_color']);
            if (bannerVM.all_data[index]['font_size']==14){
                $("#Bt_fontsize_s").prop("checked", "checked");
            }
            else if (bannerVM.all_data[index]['font_size']==18){
                $("#Bt_fontsize_m").prop("checked", "checked");
            }
            else{
                $("#Bt_fontsize_l").prop("checked", "checked");
            }
            if(bannerVM.all_data[index]['style']==1){
                $("#pureTitle1").prop("checked", "checked");
            }
            if(bannerVM.all_data[index]['style']==2){
                $("#pureTitle2").prop("checked", "checked");
            }
            if(bannerVM.all_data[index]['style']==3){
                $("#pureTitle3").prop("checked", "checked");
            }
            if(bannerVM.all_data[index]['style']==4){
                $("#pureTitle4").prop("checked", "checked");
            }
            if(bannerVM.all_data[index]['style']==5){
                $("#pureTitle5").prop("checked", "checked");
            }
            if(bannerVM.all_data[index]['style']==6){
                $("#pureTitle6").prop("checked", "checked");
            }
            if(bannerVM.all_data[index]['style']==7){
                $("#pureTitle7").prop("checked", "checked");
            }
            if(bannerVM.all_data[index]['style']==8){
                $("#pureTitle8").prop("checked", "checked");
            }
            // bannerVM.add_h = bannerVM.columntitle.length *245;
            //bannerVM.add_top = bannerVM.columntitle.length *135;
            bannerVM.now_index = index;
        },
    },
})
//辅助空白
Vue.component('blank', {
    props: ['ly_height','index','list','bg_color'],
    template: '<li class="ui-draggable" title="点击进行修改,拖动交换位置."><div v-on:click="del_left(index)"  class="deleteButton"></div><div v-on:click="onc_banner(index,$event)" class="Parting" :style="'+"'height:'"+'+ly_height+'+"'px;background-color:'"+'+bg_color+'+"';'"+'"></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_blank").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_blank").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
            $('#blank_color').val(bannerVM.all_data[index]['bg_color']);
            $('#blank_height').val(bannerVM.all_data[index]['ly_height']);
            $('#blank_height_number').html(bannerVM.all_data[index]['ly_height']);
            $("#blank_color_text").html(bannerVM.all_data[index]['bg_color']);

            bannerVM.now_index = index;
        },
    },
})
//搜索框
Vue.component('search', {
    props: ['index','bg_color','li_bg_color','text_color'],
    template: '<li  class="ui-draggable" :style="'+"'background-color:'"+'+li_bg_color+'+"';'"+'"  title="点击进行修改,拖动交换位置."><div v-on:click="del_left(index)" class="deleteButton"></div><section :style="'+"'background-color:'"+'+bg_color+'+"';'"+'" v-on:click="onc_banner(index,$event)" class="members_search"><button type="submit"></button><input :style="{color: text_color}" type="text" id="search" value="搜索" readonly ></section></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_search").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_search").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
            $('#search_textarea').val(bannerVM.all_data[index]['default']);
            $('#search_color').val(bannerVM.all_data[index]['bg_color']);
            $('#search_bj_color').val(bannerVM.all_data[index]['li_bg_color']);
            $('#search_text_color').val(bannerVM.all_data[index]['text_color']);

            $("#search_color_text").html(bannerVM.all_data[index]['bg_color']);
            $("#search_bj_color_text").html(bannerVM.all_data[index]['li_bg_color']);
            $("#search_text_color_text").html(bannerVM.all_data[index]['text_color']);

            if (bannerVM.all_data[index]['search_style']=='0'){
                $("#search_style_1").prop("checked", "checked");
            }
            if (bannerVM.all_data[index]['search_style']=='1'){
                $("#search_style_2").prop("checked", "checked");
            }
            bannerVM.now_index = index;
        },
    },
})
//分割线
Vue.component('blankline', {
    props: ['index','color','bg_color','ly_height','margin','line'],
    template: '<li class="ui-draggable" title="点击进行修改,拖动交换位置."><div v-on:click="del_left(index)" class="deleteButton"></div><div v-on:click="onc_banner(index,$event)"  class="Parting" :style="'+"'background-color:'"+'+bg_color+'+"';height:'"+'+margin+'+"'px;'"+'" ><section class="custom-line-wrap"><hr :style="'+"'border-top-color:'"+'+color+'+"';border-width:'"+'+ly_height+'+"'px;border-top-style:'"+'+line+'+"''"+'"" class="custom-line"></section></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_search").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_Parting").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
            $("#Fgx_Color").val(bannerVM.all_data[index]['color']);
            $("#Fgx_bgColor").val(bannerVM.all_data[index]['bg_color']);
            $("#line_height").val(bannerVM.all_data[index]['ly_height']);
            $("#line_margin").val(bannerVM.all_data[index]['margin']);

            $("#Fgx_Color_text").html(bannerVM.all_data[index]['color']);
            $("#Fgx_bgColor_text").html(bannerVM.all_data[index]['bg_color']);

            $("#line_height_height").html(bannerVM.all_data[index]['ly_height']);
            $("#line_margin_height").html(bannerVM.all_data[index]['margin']);

            if (bannerVM.all_data[index]['line']=='solid'){
                $("#Fgx_style_1").prop("checked", "checked");
            }else if(bannerVM.all_data[index]['line']=='dashed'){
                $("#Fgx_style_2").prop("checked", "checked");
            }else {
                $("#Fgx_style_3").prop("checked", "checked");
            }
            //$('#search_textarea').val(bannerVM.all_data[index]['hot_search']);
            bannerVM.now_index = index;
        },
    },
})
//图文集
Vue.component('article_list', {
    props: ['list','index','bg_color','title_size','title_color','style_width','style_height','style_num','text_width'],
    template: '<li :style="'+"'background-color:'"+'+bg_color+'+"';'"+'" class="ui-draggable" title="点击进行修改,拖动交换位置."><div v-on:click="del_left(index)" class="deleteButton"></div><div  v-on:click="onc_banner(index,$event)" :class="\'cubeNavigationArea column-\'+style_num+\' clearfix\'"><div class="imgList" v-for="d in list"><div :style="style_height" class="cubeLink cubeLink1"><div :style="style_width" class="_img"><img :src="d.imgurl"></div><div :style="'+"'width:'"+'+text_width+'+"';'"+'" class="_text"><p :style="'+"'font-size:'"+'+title_size+'+"'px;color:'"+'+title_color+'+"';'"+'" class="title">{{d.name}}</p><p style="font-size: 14px;">{{d.description}}</p></div></div></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_imgtextlist").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_imgtextlist").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
            $("#imgtextColorSet").val(bannerVM.all_data[index]['bg_color']);
            $("#pureTitlecolorSet").val(bannerVM.all_data[index]['title_color']);

            $("#add_img_list_val").val(bannerVM.all_data[index]['add_num']);
            $("#imgtextColorSet_text").html(bannerVM.all_data[index]['bg_color']);
            $("#pureTitlecolorSet_text").html(bannerVM.all_data[index]['title_color']);
            $("#select_img_id").find("option[value = '"+bannerVM.all_data[index]['add_cate']+"']").attr("selected","selected");

            bannerVM.imgtextlist=bannerVM.all_data[index]['list'];
            if (bannerVM.all_data[index]['layout']==1){
                $("#cateLists1").prop("checked", "checked");
            }
            else if(bannerVM.all_data[index]['layout']==2) {
                $("#cateLists2").prop("checked", "checked");
            }
            else if(bannerVM.all_data[index]['layout']==3) {
                $("#cateLists3").prop("checked", "checked");
            }

            if (bannerVM.all_data[index]['title_size']=='15'){
                $("#Twj_fontsize_s").prop("checked", "checked");
            }else if(bannerVM.all_data[index]['title_size']=='17'){
                $("#Twj_fontsize_m").prop("checked", "checked");
            }else {
                $("#Twj_fontsize_l").prop("checked", "checked");
            }

            if(bannerVM.all_data[index]['add_type']=='1'){
                $("#img_add_type_zid").css('display','none');
                $("#img_type_anually").prop("checked", "checked");
            }
            console.log(bannerVM.all_data[index]['add_type']);
            if(bannerVM.all_data[index]['add_type']=='2'){
                $("#img_add_type_zid").css('display','block');
                $("#img_type_automatic").prop("checked", "checked");
            }

            if (bannerVM.all_data[index]['add_sort']=='time'){
                $("#img_type_time").prop("checked", "checked");
            }
            else if(bannerVM.all_data[index]['add_sort']=='pop'){
                $("#img_type_pop").prop("checked", "checked");
            }else {
                $("#img_type_sales").prop("checked", "checked");
            }


            bannerVM.add_h = bannerVM.imgtextlist.length *135+135;
            bannerVM.add_top = bannerVM.imgtextlist.length *135+15;
            bannerVM.now_index = index;
        },
    },
})
//商品集
Vue.component('goods', {
    props: ['list','index','bg_color','title_size','title_color'],
    template: '<li title="点击进行修改,拖动交换位置." class="ui-draggable"><div v-on:click="del_left(index)" class="deleteButton"></div><div  v-on:click="onc_banner(index,$event)" class="cubeNavigationArea column-2 clearfix"><div v-for="g in list" class="cubeLink cubeLink1 Ggdh" style="height: 200px; border-bottom: 1px solid rgb(229, 229, 229); border-right: 1px solid rgb(229, 229, 229);"><a href="javascript:;" class="cubeLink_a"><div class="cubeLink_bg"></div> <div class="cubeLink_curtain"></div> <div class="cubeLink_ico icon-cube" :style="'+"'background-image:url('"+'+g.imgurl+'+"');border-radius: 0px; width: 100px; height: 100px; background-size: 100px 100px;'"+'"></div> <div class="cubeLink_text g_link" style="position: relative;"><div class="cubeLink_text_p " style="font-size: 12px; color: rgb(0, 0, 0);"><em :style="'+"'color:'"+'+title_color+'+"';font-size:'"+'+title_size+'+"'px;font-weight: bold; padding-left: 5px;'"+'">{{g.name}}</em><em style="padding-left: 5px;font-size: 10px;color: #68838B">{{g.description}}</em> <p class="cubeLink_subText_p" style="margin-bottom: 1rem; color: rgb(255, 0, 0); padding-left: 5px;">￥{{g.price}}</p><p public="" static="" images="" style="display: block; width: 25px; height: 25px; border-radius: 50%; position: absolute; right: 10px; bottom: 5px; margin-bottom: 0px;"></p></div></div></a></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#from_edit_goodlist").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#from_edit_goodlist").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
            $("#goods_color").val(bannerVM.all_data[index]['bg_color']);
            $("#add_goods_list_val").val(bannerVM.all_data[index]['add_num']);
            $("#goods_color_text").html(bannerVM.all_data[index]['bg_color']);

            $("#select_cate_id").find("option[value = '"+bannerVM.all_data[index]['add_cate']+"']").attr("selected","selected");

            if (bannerVM.all_data[index]['title_size']=='12'){
                $("#Goods_fontsize_s").prop("checked", "checked");
            }else if(bannerVM.all_data[index]['title_size']=='14'){
                $("#Goods_fontsize_m").prop("checked", "checked");
            }else {
                $("#Goods_fontsize_l").prop("checked", "checked");
            }


            if(typeof bannerVM.all_data[index]['add_type']=="undefined"){
                $("#goods_add_type_zid").css('display','none');
                $("#Goods_type_anually").prop("checked", "checked");
            }
            if(bannerVM.all_data[index]['add_type']=='1'){
                $("#goods_add_type_zid").css('display','none');
                $("#Goods_type_anually").prop("checked", "checked");
            }
            if(bannerVM.all_data[index]['add_type']=='2'){
                $("#goods_add_type_zid").css('display','block');
                $("#Goods_type_automatic").prop("checked", "checked");
            }

            if (bannerVM.all_data[index]['add_sort']=='time'){
                $("#Goods_type_time").prop("checked", "checked");
            }
            else if(bannerVM.all_data[index]['add_sort']=='pop'){
                $("#Goods_type_pop").prop("checked", "checked");
            }else {
                $("#Goods_type_sales").prop("checked", "checked");
            }


            bannerVM.goodlist=bannerVM.all_data[index]['list'];
            bannerVM.add_h = bannerVM.goodlist.length *135+135;
            bannerVM.add_top = bannerVM.goodlist.length *135+15;

            bannerVM.now_index = index;
        },
    },
})
//按钮
Vue.component('edit_button', {
    props: ['list','index','button_name','button_radius','img_style','button_border','button_bg_color','button_title_color','button_border_color'],
    template: '<li class="ui-draggable" title="点击进行修改,拖动交换位置."><div v-on:click="del_left(index)" class="deleteButton"></div><div v-on:click="onc_banner(index)" class="button_Text" style="text-align:center;"> <div class="wrap" :style="'+"'border-radius:'"+'+button_radius+'+"'px;border:'"+'+button_border+'+"'px solid;border-color:'"+'+button_border_color+'+"';background-color:'"+'+button_bg_color+'+"';padding: 0 20px;'"+'"><img v-if="img_style == 1" v-for="item in list" :src="item.imgurl" style="width:20px;margin: 0px 15px 0px 0px;vertical-align: middle;"><span :style="'+"'color:'"+'+button_title_color+'+"';'"+'">{{button_name}}</span></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_button").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            console.log('xuanzhongle')
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_button").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
            $("#button_name").val(bannerVM.all_data[index]['button_name']);
            $("#button_radius").val(bannerVM.all_data[index]['button_radius']);

            $("#AnbgcolorSet").val(bannerVM.all_data[index]['button_bg_color']);
            $("#Title_ancolor").val(bannerVM.all_data[index]['button_title_color']);
            $("#Title_bkcolor").val(bannerVM.all_data[index]['button_border_color']);

            $("#AnbgcolorSet_text").html(bannerVM.all_data[index]['button_bg_color']);
            $("#Title_ancolor_text").html(bannerVM.all_data[index]['button_title_color']);
            $("#Title_bkcolor_text").html(bannerVM.all_data[index]['button_border_color']);
            $("#button_radius_height").html(bannerVM.all_data[index]['button_radius']);
            if (bannerVM.all_data[index]['button_border']=='1'){
                $("#An_bg_show").prop("checked", "checked");
            }else{
                $("#An_bg_hide").prop("checked", "checked");
            }

            if (bannerVM.all_data[index]['img_style']=='1'){
                $("#An_pic_show").prop("checked", "checked");
            }else {
                $("#An_pic_hide").prop("checked", "checked");
            }

            bannerVM.edit_button=bannerVM.all_data[index]['list'];
            // bannerVM.add_h = bannerVM.goodlist.length *135+135;
            // bannerVM.add_top = bannerVM.goodlist.length *135+15;

            bannerVM.now_index = index;
        },
    },
})
//地图
Vue.component('position', {
    props: ['index','position_name','is_display'],
    template: '<li class="ui-draggable" title="点击进行修改,拖动交换位置."><div v-on:click="del_left(index)" class="deleteButton"></div><div v-on:click="onc_banner(index)" class="position"><img v-if="is_display==2" src="'+ host +'addons/yztc_sun/public/static/menu/images/pos.png"> <div v-if="is_display==1" class="wrap"> <em class="fr iconfont icon-arrow-right"></em> <span class="title"><i class="Hui-iconfont Hui-iconfont-weizhi"></i>{{position_name}}</span> </div> </div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_position").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_position").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});

            $("#Dlwz_textarea").val(bannerVM.all_data[index]['position_name']);
            $("#lng").val(bannerVM.all_data[index]['lng']);
            $("#lat").val(bannerVM.all_data[index]['lat']);
            if (bannerVM.all_data[index]['is_display']==1){
                $("#position_editlayout_1").prop("checked", "checked");
            }else {
                $("#position_editlayout_2").prop("checked", "checked");
            }

            bannerVM.now_index = index;
        },
    },
})
//富文本
Vue.component('rich_text', {
    props: ['index','content','bg_color'],
    template: '<li class="ui-draggable"title="点击进行修改,拖动交换位置."><div v-on:click="del_left(index)" class="deleteButton"></div><div v-on:click="onc_banner(index)" style="" :style="'+"'background-color:'"+'+bg_color+'+"';'"+'" class="control"><div :id="'+"'um_text-'"+'+index+'+"';'"+'" class="custom-richtext" v-html="content"></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_rich_text").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_rich_text").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: 1,opacity: 1});
            $("#rich_bg_color_text").html(bannerVM.all_data[index]['bg_color']);

            $('#um_text-'+index).html(bannerVM.all_data[index]['content']);
            //document.getElementById("ueditor_0").contentDocument.body.innerHTML=bannerVM.all_data[index]['content'];
            // ue.setContent(bannerVM.all_data[index]['content']);
            $("#rich_bg_color").val(bannerVM.all_data[index]['bg_color']);
            bannerVM.now_index = index;
            var editor = UE.getEditor('content');
            editor.setContent(bannerVM.all_data[bannerVM.now_index]['content'], false);
        },
    },
})
//图片列表
Vue.component('edit_piclist', {
    props: ['index','list','layout','pic_style','html_style','pic_radius'],
    template: '<li class="ui-draggable" title="点击进行修改,拖动交换位置."><div v-on:click="del_left(index)" class="deleteButton"></div><div v-on:click="onc_banner(index,$event)" :class="\'cubeNavigationArea column-\'+layout+\' clearfix\'"><div v-for="item in list" class="cubeLink cubeLink1"><a class="cubeLink_a" href="javascript:;"><div class="cubeLink_curtain"></div><div :style="\'border-radius:\'+pic_radius+\'%;width:100%\'" class="cubeLink_ico1 icon-cube"><img :src="item.imgurl" width="100%" height="100%"></div> <div  v-if="pic_style < 3"  class="cubeLink_text1 g_link"><div class="cubeLink_text_p"><em :style="html_style">{{item.title}}</em> <p class="cubeLink_subText_p" style="margin:0px;"></p></div></div></a></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_piclist").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_piclist").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
            if(bannerVM.all_data[index]['layout']==1){
                $("#editpiclayout_1").prop("checked", "checked");
            }
            else if(bannerVM.all_data[index]['layout']==2){
                $("#editpiclayout_2").prop("checked", "checked");
            }
            else if(bannerVM.all_data[index]['layout']==3){
                $("#editpiclayout_3").prop("checked", "checked");
            }
            else if(bannerVM.all_data[index]['layout']==4){
                $("#editpiclayout_4").prop("checked", "checked");
            }
            if (bannerVM.all_data[index]['pic_style']==1){
                $("#purePiclist1").prop("checked", "checked");
            }
            else if (bannerVM.all_data[index]['pic_style']==2){
                $("#purePiclist2").prop("checked", "checked");
            }
            else if (bannerVM.all_data[index]['pic_style']==3){
                $("#purePiclist3").prop("checked", "checked");
            }
            $("#piclist_radius").val(bannerVM.all_data[index]['pic_radius']);
            $("#piclist_radius_span").html(bannerVM.all_data[index]['pic_radius']);
            bannerVM.edit_piclist=bannerVM.all_data[index]['list'];
            bannerVM.add_h = bannerVM.edit_piclist.length *135+135;
            bannerVM.add_top = bannerVM.edit_piclist.length *135+15;
            bannerVM.now_index = index;
        },
    },
})
//悬浮按钮
Vue.component('floaticon', {
    props: ['index','form_bottom','form_margin','form_transparent','list'],
    template: '<li id="floaticon_button_this" :style="\'bottom:\'+form_bottom+\'px;left:\'+form_margin+\'px\'" class="ui-draggable"  title="点击进行修改,拖动交换位置."><div v-on:click="del_left(index)" class="deleteButton"></div><div  v-on:click="onc_banner(index,$event)" class="floaticon pr"><div class="icon_right"><img :style="\'opacity:\'+form_transparent+\';width:35px;height:35px;\'" v-for="item in list" :src="item.imgurl" alt=""></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_floaticon").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_floaticon").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
            $("#floaticon_button").val(bannerVM.all_data[index]['b_form_bottom']);
            $("#floaticon_margin").val(bannerVM.all_data[index]['b_form_margin']);
            $("#floaticon_transparent").val(bannerVM.all_data[index]['b_form_transparent']);


            $("#floaticon_button_text").html(bannerVM.all_data[index]['b_form_bottom']);
            $("#floaticon_margin_text").html(bannerVM.all_data[index]['b_form_margin']);

            bannerVM.floaticon=bannerVM.all_data[index]['list'];
            bannerVM.now_index = index;
        },
    },
})
//悬浮客服
Vue.component('customer', {
    props: ['index','form_bottom','form_margin','form_transparent','imgurl'],
    template: '<li id="customer_button_this" :style="\'bottom:\'+form_bottom+\'px;left:\'+form_margin+\'px\'" class="ui-draggable"  title="点击进行修改,拖动交换位置."><div v-on:click="del_left(index)" class="deleteButton"></div><div  v-on:click="onc_banner(index,$event)" class="floaticon pr"><div class="icon_right" ><img :style="\'opacity:\'+form_transparent+\';width:35px;height:35px;\'" :src="imgurl" alt=""></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_Customer").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_Customer").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
            $("#Customer_button").val(bannerVM.all_data[index]['b_form_bottom']);
            $("#Customer_margin").val(bannerVM.all_data[index]['b_form_margin']);
            $("#Customer_transparent").val(bannerVM.all_data[index]['b_form_transparent']);
            $("#Customer_img").attr('src',bannerVM.all_data[index]['imgurl']);

            $("#Customer_button_text").html(bannerVM.all_data[index]['b_form_bottom']);
            $("#Customer_margin_text").html(bannerVM.all_data[index]['b_form_margin']);


            bannerVM.now_index = index;
        },
    },
})
//悬浮电话
Vue.component('edit_phone', {
    props: ['index','form_bottom','form_margin','form_transparent','imgurl'],
    template: '<li id="phone_button_this" :style="\'bottom:\'+form_bottom+\'px;left:\'+form_margin+\'px\'" class="ui-draggable"  title="点击进行修改,拖动交换位置."><div v-on:click="del_left(index)" class="deleteButton"></div><div  v-on:click="onc_banner(index,$event)" class="floaticon pr"><div class="icon_right"><img :style="\'opacity:\'+form_transparent+\';width:35px;height:35px;\'" :src="imgurl" alt=""></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_phone").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_phone").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
            $("#phone_button").val(bannerVM.all_data[index]['b_form_bottom']);
            $("#phone_margin").val(bannerVM.all_data[index]['b_form_margin']);
            $("#phone_transparent").val(bannerVM.all_data[index]['b_form_transparent']);
            $("#phone_img").attr('src',bannerVM.all_data[index]['imgurl']);
            $("#this_phone_val").val(bannerVM.all_data[index]['phone']);

            $("#phone_button_text").html(bannerVM.all_data[index]['b_form_bottom']);
            $("#phone_margin_text").html(bannerVM.all_data[index]['b_form_margin']);

            bannerVM.now_index = index;
        },
    },
})
//公告
Vue.component('announcement', {
    props: ['index','color','bg_color','title','imgurl'],
    template: '<li id="set_announcement" :style="'+"'background-color:'"+'+bg_color+'+"''"+'" class="ui-draggable" v-on:click="onc_banner(index,$event)" title="点击进行修改,拖动交换位置."><div v-on:click="del_left(index)" class="deleteButton"></div><div class="floaticon pr"><div style="float: left;overflow: hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp:1;-webkit-box-orient: vertical;"><img style="width: 40px;height: 30px;" :src="imgurl" alt=""><span :style="'+"'color:'"+'+color+'+"';font-size:12px;'"+'">{{title}}</span></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_announcement").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_announcement").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});

            $("#announcement_bgColor_text").html(bannerVM.all_data[index]['bg_color']);
            $("#announcement_Color").val(bannerVM.all_data[index]['color']);


            $("#announcement_bgColor").val(bannerVM.all_data[index]['bg_color']);
            $("#announcement_Color_text").html(bannerVM.all_data[index]['color']);

            $("#announcement_textarea").val(bannerVM.all_data[index]['title']);

            $("#announcement_img").attr('src',bannerVM.all_data[index]['imgurl']);


            bannerVM.now_index = index;
        },
    },
})
//流量主
Vue.component('ad', {
    props: ['index','height','img'],
    template: '<li class="ui-draggable" :style="'+"'height:'"+'+height+'+"'px;'"+'" v-on:click="onc_banner(index,$event)" title="点击进行修改,拖动交换位置."><div v-on:click="del_left(index)" class="deleteButton"></div><img style="width: 100%;" :src="img" alt=""></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_ad").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_ad").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});


            $("#what_ad_height").html(bannerVM.all_data[index]['height']);

            $("#ad_height").val(bannerVM.all_data[index]['height']);

            $("#ad_ad_id").val(bannerVM.all_data[index]['ad_id']);

            bannerVM.now_index = index;
        },
    },
})
//视频
Vue.component('edit_video', {
    props: ['index','video_height','video_url','imgurl'],
    template: '<li title="点击进行修改,拖动交换位置" class="ui-draggable"><div v-on:click="del_left(index)" class="deleteButton"></div><div v-on:click="onc_banner(index,$event)" class="video_sub" :style="\'margin-left: 0px; margin-right: auto; margin-top: 0px; position: relative;height:\'+video_height+\'px;\'"><video id="my_video" :src="video_url" :poster="imgurl" controls>您的浏览器不支持 video 标签</video><img v-if="imgurl" :src="imgurl" class="video-mask"> <div class="video_unapplet" style="display: none;"></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_video").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_video").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});

            $("#vidoe_height").val(bannerVM.all_data[index]['vidoe_height']);

            $("#Sp_textarea").val(bannerVM.all_data[index]['video_url']);

            $("#this_video_img").attr('src',bannerVM.all_data[index]['imgurl']);

            bannerVM.now_index = index;
        },
        video_play:function () {
            $("#my_video").play();

        }
    },
})
//音频
Vue.component('edit_music', {
    props: ['index','music_url','title','author','imgurl'],
    template: '<li id="edit_music" class="ui-draggable" title="点击进行修改,拖动交换位置."><div v-on:click="del_left(index)" class="deleteButton"></div><div v-on:click="onc_banner(index,$event)" style="width:310px;height:100px"> <div style="padding:12px;">  <div style="    border: 1px solid #a89e9e;"><img id="audio_img" :src="imgurl" style="width:70px;cursor:pointer;height:70px;"><img id="audio_stare" src="'+host+'addons/yztc_sun/public/static/menu/images/audio_stare.png" style="width:80px;cursor:pointer;height:70px;position:absolute;top:10px;left:10px;"><div style="float: right;width: 50px;margin:4px 4px;">00:00</div> <div style="float:right;width: 120px;text-align: center;height: 70px;"><p style="height: 35px;margin: 0;font-size: 15px;line-height: 35px;" class="audio_title">{{title}}</p><p class="audio_desc">{{author}}</p>   </div>  </div> </div> <audio id="my_audio" controls="controls" src=""></audio></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_audio").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_audio").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});

            $("#edit_music_url").val(bannerVM.all_data[index]['music_url']);

            $("#this_music_title").val(bannerVM.all_data[index]['title']);

            $("#this_music_author").val(bannerVM.all_data[index]['author']);

            $("#this_music_img").val(bannerVM.all_data[index]['imgurl']);

            bannerVM.now_index = index;
        },
    },
})
//评论
Vue.component('comment_s', {
    props: ['index'],
    template: '<li title="点击进行修改,拖动交换位置" class="ui-draggable"><div v-on:click="del_left(index)" class="deleteButton"></div><img v-on:click="onc_banner(index)" src="'+ host +'addons/yztc_sun/public/static/menu/images/comment.jpg"></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_comment").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_comment").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
            $("#comment_count").val(bannerVM.all_data[index]['is_display']);
            $('#is_comment_count_text').html(bannerVM.all_data[index]['is_display']);
            bannerVM.now_index = index;
        },
    },
})
//拼团
Vue.component('fight_group', {
    props: ['list','index','bg_color','title_size','title_color','style_width','style_height'],
    template: '<li :style="'+"'background-color:'"+'+bg_color+'+"';'"+'" class="ui-draggable" title="点击进行修改,拖动交换位置."><div v-on:click="del_left(index)" class="deleteButton"></div><div  v-on:click="onc_banner(index,$event)" class="swiper"><div class="imgList" v-for="d in list"><div :style="style_height" class="imgtext"><div :style="style_width" class="_img"><img :src="d.imgurl"></div><div class="_text"><p :style="'+"'font-size:'"+'+title_size+'+"'px;color:'"+'+title_color+'+"';'"+'" class="title">{{d.name}}</p><p style="font-size: 14px;">{{d.description}}</p></div></div></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_imgtextlist").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_fight_group").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
            $("#groupbjtextColorSet").val(bannerVM.all_data[index]['bg_color']);
            $("#groupTitlecolorSet").val(bannerVM.all_data[index]['title_color']);


            $("#add_img_list_val").val(bannerVM.all_data[index]['add_num']);
            $("#select_img_id").find("option[value = '"+bannerVM.all_data[index]['add_cate']+"']").attr("selected","selected");

            bannerVM.fight_group_list=bannerVM.all_data[index]['list'];
            if (bannerVM.all_data[index]['layout']==1){
                $("#cateLists1").prop("checked", "checked");
            }else if(bannerVM.all_data[index]['layout']==2) {
                $("#cateLists2").prop("checked", "checked");
            }

            if (bannerVM.all_data[index]['title_size']=='15'){
                $("#Twj_fontsize_s").prop("checked", "checked");
            }else if(bannerVM.all_data[index]['title_size']=='17'){
                $("#Twj_fontsize_m").prop("checked", "checked");
            }else {
                $("#Twj_fontsize_l").prop("checked", "checked");
            }
            if(typeof bannerVM.all_data[index]['add_type']=="undefined"){
                $("#img_add_type_zid").css('display','none');
                $("#img_type_anually").prop("checked", "checked");
            }
            if(bannerVM.all_data[index]['add_type']=='1'){
                $("#img_add_type_zid").css('display','none');
                $("#img_type_anually").prop("checked", "checked");
            }
            if(bannerVM.all_data[index]['add_type']=='2'){
                $("#img_add_type_zid").css('display','block');
                $("#img_type_automatic").prop("checked", "checked");
            }

            if (bannerVM.all_data[index]['add_sort']=='time'){
                $("#img_type_time").prop("checked", "checked");
            }
            else if(bannerVM.all_data[index]['add_sort']=='pop'){
                $("#img_type_pop").prop("checked", "checked");
            }else {
                $("#img_type_sales").prop("checked", "checked");
            }


            bannerVM.add_h = bannerVM.fight_group_list.length *135+135;
            bannerVM.add_top = bannerVM.fight_group_list.length *135+15;
            bannerVM.now_index = index;
        },
    },
})
//三方图
Vue.component('tripartite', {
    props: ['list','index'],
    template: '<li><div v-on:click="del_left(index)" class="deleteButton"></div><div  v-on:click="onc_banner(index,$event)" class="weui-grids threeimage" style="display: flex;"><div href="javascript:;" style="flex: 1 1 0%;"><div class="weui-grid__icon" style="width: 159px; height: 159px;"><img :src="list[0].img" alt="" draggable="false" style="width: 159px; height: 159px;"></div></div><div href="javascript:;" style="flex: 1 1 0%;"><div class="weui-grid__icon" style="width: 159px; height: 79.5px;"><img :src="list[1].img" alt="" draggable="false" style="width: 159px; height: 79.5px;"></div> <div class="weui-grid__icon" style="width: 159px; height: 79.5px;"><img :src="list[2].img" alt="" draggable="false" style="width: 159px; height: 79.5px;;"></div></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_tripartite").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_tripartite").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
            bannerVM.tripartite_list=bannerVM.all_data[index]['list'];
            bannerVM.now_index = index;
        },
    },
})
//四方图
Vue.component('quartet', {
    props: ['list','index'],
    template: '<li><div v-on:click="del_left(index)" class="deleteButton"></div><div  v-on:click="onc_banner(index,$event)" class="weui-grids threeimage" style="display: flex;"><div href="javascript:;" style="flex: 1 1 0%;"><div class="weui-grid__icon" style="width: 212px; height: 318px;"><img :src="list[0].img" alt="" draggable="false" style="width: 212px; height: 318px;"></div></div><div href="javascript:;" style="flex: 1 1 0%;"><div class="weui-grid__icon" style="width: 106px; height: 106px;"><img :src="list[1].img" alt="" draggable="false" style="width: 106px; height: 106px;"></div> <div class="weui-grid__icon" style="width: 106px; height: 106px;"><img :src="list[2].img" alt="" draggable="false" style="width: 106px; height: 106px;"></div> <div class="weui-grid__icon" style="width: 106px; height: 106px;"><img :src="list[3].img" alt="" draggable="false" style="width: 106px; height: 106px;"></div></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_quartet").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_quartet").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
            bannerVM.quartet_list=bannerVM.all_data[index]['list'];
            bannerVM.now_index = index;
        },
    },
})
//留言板
Vue.component('message_board', {
    props: ['index'],
    template: '<li title="点击进行修改,拖动交换位置" class="ui-draggable"><div v-on:click="del_left(index)" class="deleteButton"></div><div v-on:click="onc_banner(index,$event)"  class="widget_wrap" style="padding:5px;background:#eee"><div style="background:#fff"><textarea class="tests" placeholder="感谢提出建议"></textarea></div><div class="input" style="border-bottom:1px solid #EEEEEE;margin-top:15px">姓名<input type="text" name="" placeholder="请输入姓名（可选）" style=""></div><div class="input">手机<input type="text" name="" placeholder="请输入手机号（可选）" style=""></div><div class="sub">提交</div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_message_board").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_message_board").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
            bannerVM.now_index = index;
        },
    },
})
//门店
Vue.component('store_door', {
    props: ['index','imgurl','door_name','door_job'],
    template: '<li title="点击进行修改,拖动交换位置" class="ui-draggable"><div v-on:click="del_left(index)" class="deleteButton"></div><div  v-on:click="onc_banner(index,$event)"  class="widget_wrap" style="padding:5px"><div style="display:flex;"><img style="width:50px;height:50px" :src="imgurl"  class="top-img"><div style="flex:1;font-size:12px;"><div class="title-name">{{door_name}}</div><div>工作时间:<span class="time">{{door_job}}</span><div class="shop_phone_icon"><img style="width:100%;height:100%" src="'+host+'addons/yztc_sun/public/static/menu/images/shop_phone_icon.png"></div></div></div></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_store_door").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_store_door").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
            $("#door_textarea").val(bannerVM.all_data[index]['door_name']);
            $("#door_job").val(bannerVM.all_data[index]['door_job']);
            $("#this_door_img").attr(bannerVM.all_data[index]['imgurl']);
            $("#door_phone").val(bannerVM.all_data[index]['door_phone']);
            bannerVM.storelist=bannerVM.all_data[index]['list'];
            console.log(index)
            bannerVM.now_index = index;
        },
    },
})
//公告
/*
 Vue.component('form_edit_bulletin', {
 props: ['index','imgurl','door_name','door_job'],
 template: '<li title="点击进行修改,拖动交换位置" class="ui-draggable"><div v-on:click="del_left(index)" class="deleteButton"></div><div  v-on:click="onc_banner(index,$event)"  class="widget_wrap" style="padding:5px"><div style="display:flex;"><img style="width:50px;height:50px" :src="imgurl"  class="top-img"><div style="flex:1;font-size:12px;"><div class="title-name">{{door_name}}</div><div>工作时间:<span class="time">{{door_job}}</span><div class="shop_phone_icon"><img src="'+host+'addons/yztc_sun/public/static/menu/images/shop_phone_icon.png"></div></div></div></div></div></li>',
 methods: {
 //删除
 del_left: function (index) {
 bannerVM.all_data.splice(index,1);
 $("#form_edit_store_door").css("display",'none');
 },
 //选中
 onc_banner:function (index,e) {
 $(".activeMod").children().children().removeClass('yb_select');
 $(".activeMod").children().children().eq(index).addClass('yb_select');
 $("#form_edit_store_door").css("display",'block').siblings().css("display",'none');
 $("#door_textarea").val(bannerVM.all_data[index]['door_name']);
 $("#door_job").val(bannerVM.all_data[index]['door_job']);
 $("#this_door_img").attr(bannerVM.all_data[index]['imgurl']);
 bannerVM.now_index = index;
 },
 },
 })
 */
//表单
Vue.component('edit_form', {
    props: ['index','imgurl'],
    template: '<li id="edit_form_this" class="ui-draggable" title="点击进行修改,拖动交换位置."><div v-on:click="del_left(index)" class="deleteButton"></div><div v-on:click="onc_banner(index,$event)" style="width:310px;"><img :src="imgurl"></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_form").css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_form").css("display",'block').siblings().css("display",'none');
            $("#rich-box").css({zIndex: -100,opacity: 0});

            // $("#edit_music_url").val(bannerVM.all_data[index]['music_url']);
            //
            // $("#this_music_title").val(bannerVM.all_data[index]['title']);
            //
            // $("#this_music_author").val(bannerVM.all_data[index]['author']);
            //
            // $("#this_music_img").val(bannerVM.all_data[index]['imgurl']);

            bannerVM.now_index = index;
        },
    },
})
/** -----------------------------------------------------------组件 end-------------------------------------------------------------- */

/** -----------------------------------------------------------主内容 start-------------------------------------------------------------- */
var bannerVM = new Vue({
    el: '#b_menu',
    data: {
        all_data:[],//所有数据
        menu_list:[],

        add_h_di: 360,
        add_top_di: 250,

        display: "block",
        nab_name: '小程序名称',
        nab_color: '#000000',
        font_color: '#8b8b8b',
        db_color: '#ffffff',
        dh_color: '#ffffff',
        dbj_color: '#ffffff',
        bag_url: host+ "addons/yztc_sun/public/static/menu/images/black.png",
        win_color:'#ffffff',
        win_img:'',
        is_di_dis:true, //是否显示底部导航
        banner:[],//轮播图当前数据
        advert:[],//广告位当前数据
        catenav:[],//宫格导航
        columntitle:[],//标题
        imgtextlist:[],//图文集
        fight_group_list:[],//拼团
        goodlist:[],//商品集
        storelist:[],//门店
        edit_piclist:[],//图片列表
        edit_button:[],//按钮
        floaticon:[],//悬浮
        customer:[],
        add_h:245,//DIV高度
        add_top:145,//添加按钮高度
        now_index : 0,//当前下标
        this_type:'',
        tripartite_list:[],//三方图
        quartet_list:[],//四方图
        hasDefault: 0, // 是否有默认模板
        couponslist:[],//优惠券集
        modelName: '小程序名称',
    },
    mounted: function() {
        this.$dragging.$on('dragged', function(data) {
            // $("#from_edit_goodlist").css("display",'none').siblings().css("display",'none');
            var list=Object.keys(data['value']['list']);
            var index='';
            for(var i=0;i<list.length;i++){
                if (data['draged']['time_key']==data['value']['list'][i]['time_key']){
                    index=i;
                }
            }
            bannerVM.now_index = index;

        })

    },
    methods: {
        //选中功能呢
        select_article:function (index,type) {
            $("#goods_select_id").val(index);
            bannerVM.this_type=type;
            lay_open('选择功能', host+'addons/yb_shop/core/index.php?s=/admin/menu/index_select_article&this_type='+type+'&select_id=' + index, '800px', '600px');
        },
        //砍价
        select_fight_group:function (index,type) {
            $("#goods_select_id").val(index);
            bannerVM.this_type=type;
            lay_open('选择功能',host+'/addons/yb_shop/core/index.php?s=/admin/menu/select_fight_group&this_type='+type+'&select_id=' + index, '800px', '600px');

        },
        click_position_wz:function () {
            layui.use('table', function () {
                lay_open('坐标', hosts+'c=site&a=entry&do=Chome&op=pagemap&m=yztc_sun','800px', '600px');
            })
        },
        add_menu: function (index, type) {
            var _this = this;
            util.image('',function(url){
                PopUpCallBack(1, url.url, index, '', type);
            },{'multiple':false});
        },
        //表单选择
        select_form_all:function (index) {
            lay_open('选择表单', host+'/addons/yb_shop/core/index.php?s=/admin/menu/select_form_all', '800px', '600px');
        },
        //删除图片
        remove_img:function (index,type) {
            layui.use('table', function () {
                if (type=="goods"){
                    if(bannerVM.goodlist.length == 1)
                    {
                        layer.msg('不能小于1件商品！',{icon:2,time:1000});
                        return false;
                    }
                    for (var i=1;i<=10;i++){
                        if(typeof (bannerVM.goodlist[index+i])!='undefined'){
                            bannerVM.goodlist[index+i]['top']=bannerVM.goodlist[index+i]['top']-135;
                        }else {
                            continue;
                        }
                    }
                    bannerVM.goodlist.splice(index,1);
                    bannerVM.add_top -= 135;
                    bannerVM.add_h -= 135;
                }
                if (type=="article"){
                    if(bannerVM.imgtextlist.length == 1)
                    {
                        layer.msg('不能小于1张图片！',{icon:2,time:1000});
                        return false;
                    }
                    for (var i=1;i<=10;i++){
                        if(typeof (bannerVM.imgtextlist[index+i])!='undefined'){
                            bannerVM.imgtextlist[index+i]['top']=bannerVM.imgtextlist[index+i]['top']-135;
                        }else {
                            continue;
                        }
                    }
                    bannerVM.imgtextlist.splice(index,1);
                    bannerVM.add_top -= 135;
                    bannerVM.add_h -= 135;
                }

                if (type=="banner"){
                    if(bannerVM.banner.length == 1)
                    {
                        layer.msg('不能小于1张图片！',{icon:2,time:1000});
                        return false;
                    }
                    for (var i=1;i<=10;i++){
                        if(typeof (bannerVM.banner[index+i])!='undefined'){
                            bannerVM.banner[index+i]['top']=bannerVM.banner[index+i]['top']-135;
                        }else {
                            continue;
                        }
                    }
                    bannerVM.banner.splice(index,1);
                    bannerVM.add_top -= 135;
                    bannerVM.add_h -= 135;
                }

                if (type=="advert"){
                    if(bannerVM.advert.length == 1)
                    {
                        layer.msg('不能小于1张图片！',{icon:2,time:1000});
                        return false;
                    }
                    for (var i=1;i<=10;i++){
                        if(typeof (bannerVM.advert[index+i])!='undefined'){
                            bannerVM.advert[index+i]['top']=bannerVM.advert[index+i]['top']-135;
                        }else {
                            continue;
                        }
                    }
                    bannerVM.advert.splice(index,1);
                    bannerVM.add_top -= 135;
                    bannerVM.add_h -= 135;
                }
                if (type=="navigation"){
                    if(bannerVM.catenav.length == 1)
                    {
                        layer.msg('不能小于1张图片！',{icon:2,time:1000});
                        return false;
                    }
                    for (var i=1;i<=10;i++){
                        if(typeof (bannerVM.catenav[index+i])!='undefined'){
                            bannerVM.catenav[index+i]['top']=bannerVM.catenav[index+i]['top']-135;
                        }else {
                            continue;
                        }
                    }
                    bannerVM.catenav.splice(index,1);
                    bannerVM.add_top -= 135;
                    bannerVM.add_h -= 135;
                }
                if (type=="edit_piclist"){
                    if(bannerVM.edit_piclist.length == 1)
                    {
                        layer.msg('不能小于1张图片！',{icon:2,time:1000});
                        return false;
                    }
                    for (var i=1;i<=10;i++){
                        if(typeof (bannerVM.edit_piclist[index+i])!='undefined'){
                            bannerVM.edit_piclist[index+i]['top']=bannerVM.edit_piclist[index+i]['top']-135;
                        }else {
                            continue;
                        }
                    }
                    bannerVM.edit_piclist.splice(index,1);
                    bannerVM.add_top -= 135;
                    bannerVM.add_h -= 135;
                }
            })
        },
        clip_menu: function (index) {
            layui.use('table', function () {
                if (bannerVM.menu_list.length == 2) {
                    layer.msg('不能小于2个菜单！', {icon: 2, time: 1000});
                    return;
                }
                //bannerVM.menu_list[index]['top'] - 135;
                if (typeof (bannerVM.menu_list[index + 1]) != 'undefined') {
                    bannerVM.menu_list[index + 1]['top'] = bannerVM.menu_list[index + 1]['top'] - 112;
                    if (typeof (bannerVM.menu_list[index + 2]) != 'undefined') {
                        bannerVM.menu_list[index + 2]['top'] = bannerVM.menu_list[index + 2]['top'] - 112;
                        if (typeof (bannerVM.menu_list[index + 3]) != 'undefined') {
                            bannerVM.menu_list[index + 3]['top'] = bannerVM.menu_list[index + 3]['top'] - 112;
                            if (typeof (bannerVM.menu_list[index + 4]) != 'undefined') {
                                bannerVM.menu_list[index + 4]['top'] = bannerVM.menu_list[index + 4]['top'] - 112;
                            }
                        }
                    }
                }

                bannerVM.menu_list.splice(index, 1);

                bannerVM.add_top_di -= 112;
                bannerVM.add_h_di -= 112;

                if (bannerVM.menu_list.length == 4) {
                    bannerVM.add_h_di += 80;
                }

                bannerVM.display = "block";
            })
        },
        // 修改模板名称
        getModelName: function(e) {
            console.log(e)
        },
        // 选择图片
        select_img: function (index,type) {
            var _this = this;
            util.image('',function(url){
                PopUpCallBack(1, url.url, index, '', type);
            },{'multiple':false});
        },
        //选择各种链接
        select_menu:function (index,type) {
            $("#goods_select_id").val(index);
            bannerVM.this_type=type;
            layui.use('table', function () {
                layer.open({
                    type: 2,
                    title: '选择功能',
                    shadeClose: true,
                    shade: false,
                    maxmin: true, //开启最大化最小化按钮
                    area: ['800px', '600px'],
                    content:hosts+'c=site&a=entry&do=Chome&op=pageselect&m=yztc_sun&select_id=' + index + '&this_type='+type
                });
            });

        },
        // 选择单件商品详情
        select_goods:function (index,type) {
            $("#goods_select_id").val(index);
            bannerVM.this_type=type;
            layui.use('table', function () {
                console.log(index);
                console.log(type);
                layer.open({
                    type: 2,
                    title: '选择商品',
                    shadeClose: true,
                    shade: false,
                    maxmin: true, //开启最大化最小化按钮
                    area: ['800px', '600px'],
                    content:hosts+'c=site&a=entry&do=Chome&op=shopselect&m=yztc_sun&select_id=' + index + '&this_type='+type
                });
            });
        },
        // 选择单个门店详情
        select_shop_info: function(index,type) {
            $("#goods_select_id").val(index);
            bannerVM.this_type=type;
            layui.use('table', function () {
                layer.open({
                    type: 2,
                    title: '选择功能',
                    shadeClose: true,
                    shade: false,
                    maxmin: true, //开启最大化最小化按钮
                    area: ['800px', '600px'],
                    content:hosts+'c=site&a=entry&do=Chome&op=storeselect&m=yztc_sun&select_id=' + index + '&this_type='+type
                });
            });
        },
        // 选择单个优惠券详情
        select_coupons_info: function(index,type) {
            $("#goods_select_id").val(index);
            bannerVM.this_type=type;
            layui.use('table', function () {
                layer.open({
                    type: 2,
                    title: '选择功能',
                    shadeClose: true,
                    shade: false,
                    maxmin: true, //开启最大化最小化按钮
                    area: ['800px', '600px'],
                    content:hosts+'c=site&a=entry&do=Chome&op=couponselect&m=yztc_sun&select_id=' + index + '&this_type='+type
                });
            });
        },
        //底部导航
        select_di_menu: function (index) {
            layui.use('table', function () {
                layer.open({
                    type: 2,
                    title: '选择功能',
                    shadeClose: true,
                    shade: false,
                    maxmin: true, //开启最大化最小化按钮
                    area: ['800px', '600px'],
                    content:hosts+'c=site&a=entry&do=Chome&op=pageselect&m=yztc_sun&select_id=' + index + '&this_type=isfoot'
                });
            });
        },
    }
});
/** -----------------------------------------------------------主内容 end-------------------------------------------------------------- */

/** -----------------------------------------------------------渲染首次数据 start-------------------------------------------------------------- */
$.ajax({
    type: "post",
    url:  hosts+'c=site&a=entry&do=Chome&op=getHomepage&m=yztc_sun',
    data: {id: getUrlParam('id')},
     // getUrlParam('id')
    success : function(res) {
        res = $.parseJSON(res);

        if (res.data) {
            bannerVM.hasDefault= res.data.id;
            var resinfo = $.parseJSON(res.data.index_value);
            bannerVM.all_data=resinfo.all_data;
            for (var i in bannerVM.all_data) {
                if (bannerVM.all_data[i]['type'] == 'headline') {
                    var new_item = {};
                    new_item['type'] = bannerVM.all_data[i]['type'];
                    new_item['name'] = bannerVM.all_data[i]['name'];
                    new_item['style'] = bannerVM.all_data[i]['style'];
                    new_item['color'] = bannerVM.all_data[i]['color'];
                    new_item['font_size'] = bannerVM.all_data[i]['font_size'];
                    new_item['bg_color'] = bannerVM.all_data[i]['bg_color'];
                    new_item['time_key'] = bannerVM.all_data[i]['time_key'];
                    var modstyle = {};
                    modstyle = {
                        titlestyle: '',
                    };
                    if (bannerVM.all_data[i]['style'] == 1) {
                        modstyle.titlestyle = '1';
                        modstyle.titlestyle3 = '';
                        modstyle.titlestyle2 = '';
                        AddCss("title_"+bannerVM.all_data[i]['time_key'],modstyle);
                    }
                    if (bannerVM.all_data[i]['style'] == 2) {
                        modstyle.titlestyle = '2';
                        modstyle.titlestyle3 = '';
                        modstyle.titlestyle2 = '';
                        AddCss("title_"+bannerVM.all_data[i]['time_key'],modstyle);

                    }
                    if (bannerVM.all_data[i]['style'] == 3) {
                        modstyle.titlestyle = '3';
                        modstyle.titlestyle3 = '';
                        modstyle.titlestyle2 = '';
                        AddCss("title_"+bannerVM.all_data[i]['time_key'],modstyle);
                    }
                    if (bannerVM.all_data[i]['style'] == 4) {
                        modstyle.titlestyle = '4';
                        modstyle.titlestyle3 = '';
                        modstyle.titlestyle2 = '';
                        AddCss("title_"+bannerVM.all_data[i]['time_key'],modstyle);
                    }
                    if (bannerVM.all_data[i]['style'] == 5) {
                        modstyle.titlestyle = '5';
                        modstyle.titlestyle3 = ' .pureText .wrap{text-indent:2px;text-align: center;';
                        modstyle.titlestyle2 = ' .pureText .wrap::after{display:inline-block;height:1px;background-color:#cd3637;margin-left:5px;width:28%;vertical-align: middle;}';
                        AddCss("title_"+bannerVM.all_data[i]['time_key'],modstyle);
                    }
                    if (bannerVM.all_data[i]['style'] == 6) {
                        modstyle.titlestyle = '6';
                        modstyle.titlestyle3 = ' .pureText .wrap{text-indent:2px;text-align: center;';
                        modstyle.titlestyle2 = ' .pureText .wrap::after{display: block;margin-left: 49%;margin-top: 20px;vertical-align: middle;width: 0;height: 0;margin-top: 4px;border-left: 7px solid transparent;border-right: 7px solid transparent;border-top: 7px solid #ffa000;}';
                        AddCss("title_"+bannerVM.all_data[i]['time_key'],modstyle);
                    }
                    if (bannerVM.all_data[i]['style'] == 7) {
                        modstyle.titlestyle = '7';
                        modstyle.titlestyle3 = ' .seven_titleS{display:inline-block;width:8px;height:8px;background-color:#333;transform:rotate(45deg);margin-left:6px;margin-right:6px}';
                        modstyle.titlestyle2 = ' .seven_titleS{display:inline-block;width:8px;height:8px;background-color:#333;transform:rotate(45deg);margin-left:6px;margin-right:6px}';
                        AddCss("title_"+bannerVM.all_data[i]['time_key'],modstyle);
                    }
                    if (bannerVM.all_data[i]['style'] == 8) {
                        modstyle.titlestyle = '8';
                        modstyle.titlestyle3 = ' .seven_titleS{display:inline-block;width:2px;height:22px;background-color:#0da3f9;margin-top:-4px;margin-left:6px;vertical-align: middle;}';
                        modstyle.titlestyle2 = ' .seven_titleO{display:inline-block;width:2px;height:22px;background-color:#0da3f9;margin-top:-4px;margin-right:6px;vertical-align: middle;}';
                        AddCss("title_"+bannerVM.all_data[i]['time_key'],modstyle);
                    }
                }
            }
            bannerVM.modelName= res.data.name;
            bannerVM.menu_list=list;
            var footnav = $.parseJSON(res.data.footnav_value);
            var alist = [];
            footnav.forEach( function(e, i) {
                var imga = e.clickago_icon;
                var imgb = e.clickafter_icon;
                if (!imga.match(host)) {
                    imga = imgroot + imga;
                }
                if (!imgb.match(host)) {
                    imgb = imgroot + imgb;
                }
                alist.push({
                    imgurl: e.url,
                    key: "index",
                    name: e.title,
                    linkname: e.url_name,
                    name_this: undefined,
                    page_icon: imga,
                    page_select_icon: imgb,
                    top: 0
                })
            });
            bannerVM.menu_list=alist;
            var sysset = $.parseJSON(res.data.system_value);
            bannerVM.nab_name = sysset.index_title;
            bannerVM.nab_color = sysset.fontcolor;
            bannerVM.dh_color = sysset.top_color;
            bannerVM.db_color = sysset.bottom_color;
            bannerVM.font_color = sysset.bottom_fontcolor_a;
            $("#iconColorSet").val(sysset.bottom_fontcolor_b);
            $("#iconColorSet_text").html(sysset.bottom_fontcolor_b);
            $('#DhColor_text').html(bannerVM.dh_color);
            $('#fontColorSet_text').html(bannerVM.font_color);
            $("#pureBorderColor_text").html(bannerVM.db_color);
            $("#pureBorderColor").val(bannerVM.db_color);
        } else {
            bannerVM.all_data = [{
                "type": "banner",
                "jiaodian_color": "#be0000",
                "jiaodian_dots": "block",
                "indicator_dots": "2",
                "ly_width": "10",
                "ly_height": "3",
                "juedui_height": "93",
                "topimg": host + "/addons/yztc_sun/public/static/menu/images/Lb.jpg",
                "list": [{
                  "imgurl": host + "/addons/yztc_sun/public/static/menu/images/Lb2.png",
                  "jiaodian_color": "#be0000",
                  "top": 0,
                  "img_dis": "none",
                  "this_type": "banner"
                }, {
                  "imgurl": host + "/addons/yztc_sun/public/static/menu/images/Lb2.png",
                  "top": 135,
                  "this_type": "banner",
                  "img_dis": "none",
                  "jiaodian_color": "#898989"
                }],
                "time_key": "15403663656863"
              }, {
                "type": "tripartite",
                "list": [{
                  "this_type": "tripartite",
                  "img": host + "/addons/yztc_sun/public/static/menu/images/11red.PNG",
                  "top": 0
                }, {
                  "this_type": "tripartite",
                  "img": host + "/addons/yztc_sun/public/static/menu/images/21blue.PNG",
                  "top": 135
                }, {
                  "this_type": "tripartite",
                  "img": host + "/addons/yztc_sun/public/static/menu/images/21yellow.PNG",
                  "top": 270
                }],
                "time_key": "154036637992556"
              }]
            bannerVM.hasDefault= 0;

            var list = res.other.footnav;
            if (list.length == 0) {
                list = [{
                    imgurl:"/yztc_sun/pages/home/index/index",
                    key: "index",
                    name: "首页",
                    linkname: "首页",
                    name_this: undefined,
                    page_icon: host + "addons/yztc_sun/public/static/menu/images/footnav/a.png",
                    page_select_icon: host + "addons/yztc_sun/public/static/menu/images/footnav/ah.png",
                    top: 0
                },
                {
                    imgurl:"/yztc_sun/pages/home/classify/classify",
                    key: "index",
                    name: "分类",
                    linkname: "分类",
                    name_this: undefined,
                    page_icon: host + "addons/yztc_sun/public/static/menu/images/footnav/b.png",
                    page_select_icon: host + "addons/yztc_sun/public/static/menu/images/footnav/bh.png",
                    top: 0
                },
                {
                    imgurl:"/yztc_sun/pages/home/shopcar/shopcar",
                    key: "index",
                    name: "购物车",
                    linkname: "购物车",
                    name_this: undefined,
                    page_icon: host + "addons/yztc_sun/public/static/menu/images/footnav/c.png",
                    page_select_icon: host + "addons/yztc_sun/public/static/menu/images/footnav/ch.png",
                    top: 0
                },
                {
                    imgurl:"/yztc_sun/pages/home/my/my",
                    key: "index",
                    name: "我的",
                    linkname: "我的",
                    name_this: undefined,
                    page_icon: host + "addons/yztc_sun/public/static/menu/images/footnav/d.png",
                    page_select_icon: host + "addons/yztc_sun/public/static/menu/images/footnav/dh.png",
                    top: 0
                }]
            } else {
                var a = [];
                list.forEach( function(e, i) {
                    a.push({
                        imgurl: e.url,
                        key: "index",
                        name: e.title,
                        linkname: e.title,
                        name_this: undefined,
                        page_icon: imghost + e.clickago_icon,
                        page_select_icon: imghost + e.clickafter_icon,
                        top: 0
                    })
                });
                list = a;
            }
            bannerVM.menu_list=list;
            bannerVM.nab_name = res.other.system.index_title;
            bannerVM.nab_color = res.other.system.fontcolor;
            bannerVM.dh_color = res.other.system.top_color;
            bannerVM.db_color = res.other.system.bottom_color;
            bannerVM.font_color = res.other.system.bottom_fontcolor_a;
            $("#iconColorSet").val(res.other.system.bottom_fontcolor_b);
        }
    }
});

/** -----------------------------------------------------------渲染首次数据 end-------------------------------------------------------------- */
//点击轮播图
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==1){
        $("#form_edit_banner").css("display",'block').siblings().css("display",'none');
        $("#rich-box").css({zIndex: -100,opacity: 0});
        bannerVM.add_h=245;
        bannerVM.add_top=145;
        //右边向当前数组中增加数据
        var item = {};
        item['imgurl'] = host + "addons/yztc_sun/public/static/menu/images/Lb2.png";
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
        new_item['topimg']=host + "addons/yztc_sun/public/static/menu/images/Lb.jpg";
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
banner_add_menu = function() {
    var item = {};
    item['imgurl'] =  host+ "addons/yztc_sun/public/static/menu/images/Lb2.png";
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
select_color = function(color) {
    bannerVM.all_data[bannerVM.now_index]['jiaodian_color']=color;
    $("#banner_color_text").html(color);
}
//轮播图高度
select_banner_height = function(height) {
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
        $("#rich-box").css({zIndex: -100,opacity: 0});

        bannerVM.add_h=245;
        bannerVM.add_top=145;
        //右边向当前数组中增加数据
        var item = {};
        item['imgurl'] = host+ "addons/yztc_sun/public/static/menu/images/Lb2.png";
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
        new_item['topimg']=host+ "addons/yztc_sun/public/static/menu/images/Ad.jpg";
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
this_advert_height = function(obj,width) {
    var index=$(obj).attr("data-index");
    console.log(index);
    console.log(width);
    bannerVM.advert[index]['width']=width;
}
//广告位添加一条空数据
advert_add_menu = function() {
    var item = {};
    item['imgurl'] =  host+ "addons/yztc_sun/public/static/menu/images/Lb2.png";
    item['top'] = bannerVM.advert.length * 135;
    item['this_type'] = "advert";
    item['width'] = "100";
    bannerVM.add_h += 135;
    bannerVM.add_top += 135;
    bannerVM.advert.push(item);
}
//高度
select_advert_height = function(height) {
    bannerVM.all_data[bannerVM.now_index]['ly_height']=height;
    bannerVM.all_data[bannerVM.now_index]['juedui_height']=(height/bannerVM.all_data[bannerVM.now_index]['ly_width'])*310;
    $("#what_advert_height").html(height*10);
}
//宽度
select_advert_width = function(width) {
    bannerVM.all_data[bannerVM.now_index]['ly_width']=width;
    bannerVM.all_data[bannerVM.now_index]['juedui_height']=(bannerVM.all_data[bannerVM.now_index]['ly_height']/width)*310;
}
//*********************************************广告位end*************************************************//
//*********************************************宫格导航star*************************************************//
//点击宫格导航
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==3){
        $("#from_edit_iconnav").css("display",'block').siblings().css("display",'none');
        $("#rich-box").css({zIndex: -100,opacity: 0});
        bannerVM.add_h=245;
        bannerVM.add_top=145;
        var item = {};
        item['imgurl'] = host+ "addons/yztc_sun/public/static/menu/images/Lb21.png";
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
        new_item['topimg']=host+ "addons/yztc_sun/public/static/menu/images/Ggdh1.png";
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
catenav_add_menu = function() {
    var item = {};
    item['imgurl'] =  host+ "addons/yztc_sun/public/static/menu/images/Lb21.png";
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
 catenav_font_color = function(color) {
     bannerVM.all_data[bannerVM.now_index]['color']=color;
     console.log('color');
     console.log(color);
     $("#catenav_color_text").html(color);
}
//圆角弧度
catenav_catenav_corners = function(corners) {
    bannerVM.all_data[bannerVM.now_index]['radian']=corners;
    $("#catenav_corners_height").html(corners);
}
//*********************************************宫格导航end*************************************************//
//*********************************************标题star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==4){
        $("#form_edit_title").css("display",'block').siblings().css("display",'none');
        $("#rich-box").css({zIndex: -100,opacity: 0});
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
alias_title = function(name) {
    bannerVM.all_data[bannerVM.now_index]['name']=name;
}
//字体颜色
alias_font_color = function(color) {
    bannerVM.all_data[bannerVM.now_index]['color']=color;
    $("#Bt_TitlecolorSet_text").html(color);
}
//背景颜色
title_bg_color = function(color) {
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
    console.log('111ddd')
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
        $("#rich-box").css({zIndex: -100,opacity: 0});
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
this_blank_height = function(height) {
    bannerVM.all_data[bannerVM.now_index]['ly_height']=height;
    $("#blank_height_number").html(height);
}
//背景颜色
this_blank_color = function(color) {
    bannerVM.all_data[bannerVM.now_index]['bg_color']=color;
    $("#blank_color_text").html(color);
}
//*********************************************辅助空白end*************************************************//
//*********************************************搜索框star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==6){
        $("#form_edit_search").css("display",'block').siblings().css("display",'none');
        $("#rich-box").css({zIndex: -100,opacity: 0});
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
this_search_hot = function(hot) {
    bannerVM.all_data[bannerVM.now_index]['default']=hot;
}
//背景color
this_search_color = function(color) {
    bannerVM.all_data[bannerVM.now_index]['bg_color']=color;
    $("#search_color_text").html(color);
}
//li背景color
this_search_bj_color = function(color) {
    bannerVM.all_data[bannerVM.now_index]['li_bg_color']=color;
    $("#search_bj_color_text").html(color);
}
//文字color
this_search_text_color = function(color) {
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
        $("#rich-box").css({zIndex: -100,opacity: 0});
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
this_parting_line_color = function(color) {
    bannerVM.all_data[bannerVM.now_index]['color']=color;
    $("#Fgx_Color_text").html(color);
}
//背景颜色
this_parting_bg_color = function(color) {
    bannerVM.all_data[bannerVM.now_index]['bg_color']=color;
    $("#Fgx_bgColor_text").html(color);
}
//线条高度
this_parting_line_height = function(height) {
    bannerVM.all_data[bannerVM.now_index]['ly_height']=height;
    $("#line_height_height").html(height);
}
//间距
this_parting_line_margin = function(margin) {
    bannerVM.all_data[bannerVM.now_index]['margin']=margin;
    $("#line_margin_height").html(height);
}
//*********************************************分割线end*************************************************//
//*********************************************图文集star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==8){
        $("#form_edit_imgtextlist").css("display",'block').siblings().css("display",'none');
        $("#rich-box").css({zIndex: -100,opacity: 0});
        bannerVM.add_h=245;
        bannerVM.add_top=145;
        var item = {};
        item['this_type']="article";
        item['name']="标题";
        item['description']="内容描述";
        item['imgurl']=host+ "addons/yztc_sun/public/static/menu/images/Tpj_3.png";
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
imgtextlist_add_menu = function() {
    var item = {};
    item['this_type']="article";
    item['name']="标题";
    item['description']="内容描述";
    item['imgurl']=host+ "addons/yztc_sun/public/static/menu/images/Tpj_3.png";
    item['top'] = bannerVM.imgtextlist.length * 135;
    bannerVM.add_h += 135;
    bannerVM.add_top += 135;
    bannerVM.imgtextlist.push(item);
    console.log(bannerVM.imgtextlist)
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
imgtextlist_title_color =function(color) {
    bannerVM.all_data[bannerVM.now_index]['title_color']=color;
    $("#pureTitlecolorSet_text").html(color);
}
//背景颜色
imgtextlist_bg_color = function(color) {
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
//*********************************************优惠券集star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==30){
        $("#from_edit_couponslist").css("display",'block').siblings().css("display",'none');
        $("#rich-box").css({zIndex: -100,opacity: 0});
        bannerVM.add_h=245;
        bannerVM.add_top=145;
        var item = {};
        item['this_type']="coupons";
        item['m_price']="000";
        item['mj_price']="000";
        item['id']= 0;
        item['top']=0;
        var arr=[];
        arr.push(item);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="coupons";
        new_item['color_a']="#ffffff";
        new_item['color_b']="#ffb1bd";
        new_item['color_c']="#ffffff";
        new_item['color_d']="#ffffff";
        new_item['list'] = arr;
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        // //获取当前增加的幻灯片下标
        bannerVM.now_index = bannerVM.all_data.length-1;
        bannerVM.couponslist=bannerVM.all_data[bannerVM.now_index]['list'];
    }
})
//整体背景色
coupons_bg_a = function(color) {
    bannerVM.all_data[bannerVM.now_index]['color_a']=color;
    $("#coupons_txt_a").html(color);
}
//优惠券背景色
coupons_bg_b = function(color) {
    bannerVM.all_data[bannerVM.now_index]['color_b']=color;
    $("#coupons_txt_b").html(color);
}
//按钮背景色
coupons_bg_c = function(color) {
    bannerVM.all_data[bannerVM.now_index]['color_c']=color;
    $("#coupons_txt_c").html(color);
}
//字体颜色
coupons_bg_d = function(color) {
    bannerVM.all_data[bannerVM.now_index]['color_d']=color;
    $("#coupons_txt_d").html(color);
}
//添加一条空数据
coupons_add_menu = function() {
    var item = {};
    item['this_type']="coupons";
    item['m_price']="000";
    item['mj_price']="000";
    item['id']= 0;
    item['top']=0;
    bannerVM.add_h += 135;
    bannerVM.add_top += 135;
    bannerVM.couponslist.push(item);
}
//*********************************************优惠券集end*************************************************//
//*********************************************商品集star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==9){
        $("#from_edit_goodlist").css("display",'block').siblings().css("display",'none');
        $("#rich-box").css({zIndex: -100,opacity: 0});
        bannerVM.add_h=245;
        bannerVM.add_top=145;
        var item = {};
        item['this_type']="goods";
        item['name']="标题";
        item['description']="商品简介";
        item['price']="9.9";
        item['imgurl']=host+ "addons/yztc_sun/public/static/menu/images/Tpj_3.png";
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
goods_add_menu = function() {
    var item = {};
    item['this_type']="goods";
    item['name']="标题";
    item['price']="9.9";
    item['description']="商品简介";
    item['imgurl']=host+ "addons/yztc_sun/public/static/menu/images/Tpj_3.png";
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
goods_font_color = function(color) {
    bannerVM.all_data[bannerVM.now_index]['title_color']=color;
    $("#goods_color_text").html(color);
}
//名称
this_goodlist_name = function(obj,name) {
    var index=$(obj).attr("data-index");
    bannerVM.all_data[bannerVM.now_index]['list'][index]['name']=name;
}
//简介
this_goodlist_description = function(obj,description) {
    var index=$(obj).attr("data-index");
    bannerVM.all_data[bannerVM.now_index]['list'][index]['description']=description;
}
//*********************************************商品集end*************************************************//
//*********************************************按钮star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==10){
        $("#form_edit_button").css("display",'block').siblings().css("display",'none');
        $("#rich-box").css({zIndex: -100,opacity: 0});
        var item = {};
        item['this_type']="edit_button";
        item['imgurl']=host+ "addons/yztc_sun/public/static/menu/images/kefu.png";//显示图片
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
select_button_name = function(name) {
    bannerVM.all_data[bannerVM.now_index]['button_name']=name;
}
//按钮样式
select_button_radius = function(radius) {
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
button_bj_color = function(color) {
    bannerVM.all_data[bannerVM.now_index]['button_bg_color']=color;
    $("#AnbgcolorSet_text").html(color);
}
//标题颜色
button_title_color = function(color) {
    bannerVM.all_data[bannerVM.now_index]['button_title_color']=color;
    $("#Title_ancolor_text").html(color);
}
//边框颜色
button_border_color = function(color) {
    bannerVM.all_data[bannerVM.now_index]['button_border_color']=color;
    $("#Title_bkcolor_text").html(color);
}
//*********************************************按钮end*************************************************//


//*********************************************地理位置star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==11){
        $("#form_edit_position").css("display",'block').siblings().css("display",'none');
        $("#rich-box").css({zIndex: -100,opacity: 0});
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
position_name = function(name){
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
        $("#rich-box").css({zIndex: 1,opacity: 1});
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
        var editor = UE.getEditor('content');
        editor.setContent(bannerVM.all_data[bannerVM.now_index]['content'], false);
        //右边当前数组=左侧当前幻灯片下标
        //bannerVM.edit_button=bannerVM.all_data[bannerVM.now_index]['list'];
    }
})
rich_text_bg = function(color) {
    bannerVM.all_data[bannerVM.now_index]['bg_color']=color;
    $("#rich_bg_color_text").html(color);
}
//*********************************************富文本end*************************************************//
//*********************************************图片列表star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==13){
        $("#form_edit_piclist").css("display",'block').siblings().css("display",'none');
        $("#rich-box").css({zIndex: -100,opacity: 0});
        bannerVM.add_h=245;
        bannerVM.add_top=145;
        var item = {};
        item['this_type']="edit_piclist";
        item['imgurl'] = host+ "addons/yztc_sun/public/static/menu/images/Tplb_3.png";
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
pic_add_menu = function() {
    var item = {};
    item['this_type']="edit_piclist";
    item['imgurl'] = host+ "addons/yztc_sun/public/static/menu/images/Tplb_3.png";
    item['top'] = bannerVM.edit_piclist.length * 135;
    item['name'] = '链接至';
    item['title'] = '标题';
    bannerVM.add_h += 135;
    bannerVM.add_top += 135;
    bannerVM.edit_piclist.push(item);
}
//公告导航单独一条名称
this_pic_name = function(obj,name) {
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
select_piclist_radius = function(radius) {
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
        new_item['imgurl'] = host+ "addons/yztc_sun/public/static/menu/images/service_icon.png";
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
        new_item['imgurl'] = host+ "addons/yztc_sun/public/static/menu/images/tel_icon.png";
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
        item['imgurl'] = host+ "addons/yztc_sun/public/static/menu/images/kefu.png";
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
is_floaticon_transparent = function(transparent) {
    bannerVM.all_data[bannerVM.now_index]['b_form_transparent']=transparent;
    bannerVM.all_data[bannerVM.now_index]['form_transparent']=transparent/100;
    $("#floaticon_transparent_text").html(transparent);
}
//图标透明
is_icon_floaticon_transparent = function(transparent) {
    bannerVM.all_data[bannerVM.now_index]['b_form_icon_transparent']=transparent;
    bannerVM.all_data[bannerVM.now_index]['form_icon_transparent']=transparent/100;
    $("#icon_floaticon_transparent_text").html(transparent);
}
//背景颜色
floaticon_bg_color = function(color){
    bannerVM.all_data[bannerVM.now_index]['bg_color']=color;
}
//*********************************************悬浮按钮end*************************************************//
//*********************************************视频star*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==15){
        $("#form_edit_video").css("display",'block').siblings().css("display",'none');
        $("#rich-box").css({zIndex: -100,opacity: 0});
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
is_vidoe_height = function(height) {
    bannerVM.all_data[bannerVM.now_index]['video_height']=height;
    $("#is_vidoe_height_text").html(height);
}
//视频链接
video_url = function(url) {
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
        $("#rich-box").css({zIndex: -100,opacity: 0});
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
music_url = function(url) {
    bannerVM.all_data[bannerVM.now_index]['music_url']=url;
}
//获取标题
get_this_music_title = function(title) {
    bannerVM.all_data[bannerVM.now_index]['title']=title;
}
//获取作者
get_this_music_author = function(title) {
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
        item['imgurl']=host+ "addons/yztc_sun/public/static/menu/images/Tpj_3.png";
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
    item['imgurl']=host+ "addons/yztc_sun/public/static/menu/images/Tpj_3.png";
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
        $("#rich-box").css({zIndex: -100,opacity: 0});
        bannerVM.add_h=245;
        bannerVM.add_top=145;
        var item = {};
        item['this_type']="tripartite";
        item['img']=host+ "addons/yztc_sun/public/static/menu/images/11red.PNG";
        item['top'] =0;
        var item1 = {};
        item1['this_type']="tripartite";
        item1['img']=host+ "addons/yztc_sun/public/static/menu/images/21blue.PNG";
        item1['top'] = 135;
        var item2 = {};
        item2['this_type']="tripartite";
        item2['img']=host+ "addons/yztc_sun/public/static/menu/images/21yellow.PNG";
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
        $("#rich-box").css({zIndex: -100,opacity: 0});
        bannerVM.add_h=245;
        bannerVM.add_top=145;
        var item = {};
        item['this_type']="quartet";
        item['img']=host+ "addons/yztc_sun/public/static/menu/images/23blue.PNG";
        item['top'] =0;
        var item1 = {};
        item1['this_type']="quartet";
        item1['img']=host+ "addons/yztc_sun/public/static/menu/images/11blue.PNG";
        item1['top'] = 135;
        var item2 = {};
        item2['this_type']="quartet";
        item2['img']=host+ "addons/yztc_sun/public/static/menu/images/11red.PNG";
        item2['top'] = 270;
        var item3 = {};
        item3['this_type']="quartet";
        item3['img']=host+ "addons/yztc_sun/public/static/menu/images/11yellow.PNG";
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
        $("#rich-box").css({zIndex: -100,opacity: 0});
        //左边幻灯片增加数据
        var new_item ={};
        new_item['type']="announcement";

        new_item['imgurl'] = host+ "addons/yztc_sun/public/static/menu/images/hotdot.png";
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
this_announcement_color = function(val) {
    bannerVM.all_data[bannerVM.now_index]['color']=val;
}
//背景颜色
this_announcement_bg_color = function(val) {
    bannerVM.all_data[bannerVM.now_index]['bg_color']=val;
}
//内容
this_announcement_textarea = function(val) {
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
        $("#rich-box").css({zIndex: -100,opacity: 0});
        //左边幻灯片增加数据
        var new_item ={};
        new_item['img']=host+ "addons/yztc_sun/public/static/menu/images/tencent_app.jpg";
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
select_ad_height = function(val) {
    bannerVM.all_data[bannerVM.now_index]['height']=val;
    $("#what_ad_height").html(val);
}
set_ad_ad_id = function(val) {
    bannerVM.all_data[bannerVM.now_index]['ad_id']=val;
}
//*********************************************流量主*************************************************//
//*********************************************门店*************************************************//

$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==22){
        $("#form_edit_store_door").css("display",'block').siblings().css("display",'none');
        $("#rich-box").css({zIndex: -100,opacity: 0});
        var item = {};
        item['this_type']="store_door";
        item['page_url']="";
        var arr=[];
        arr.push(item);
        //左边幻灯片增加数据
        var new_item ={};
        new_item['list'] = arr;
        new_item['type']="store_door";
        new_item['door_name']="门店名称";
        new_item['door_job']="8:00-18:00";
        new_item['door_phone']="";
        new_item['imgurl']=host+ "addons/yztc_sun/public/static/menu/images/business.png";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        bannerVM.now_index = bannerVM.all_data.length-1;
        bannerVM.storelist=bannerVM.all_data[bannerVM.now_index]['list'];
    }
})
door_name_set = function(val) {
    bannerVM.all_data[bannerVM.now_index]['door_name']=val;
}
door_job_time = function(val) {
    bannerVM.all_data[bannerVM.now_index]['door_job']=val;
}
door_phone_set = function(val) {
    bannerVM.all_data[bannerVM.now_index]['door_phone']=val;
}
//*********************************************门店*************************************************//
//*********************************************留言板*************************************************//
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==21){
        $("#form_message_board").css("display",'block').siblings().css("display",'none');
        $("#rich-box").css({zIndex: -100,opacity: 0});
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
        new_item['imgurl']=host+ "addons/yztc_sun/public/static/menu/images/choose_form.jpg";
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
// //链接
// function music_url(url) {
//     bannerVM.all_data[bannerVM.now_index]['music_url']=url;
// }
// //获取标题
// function get_this_music_title(title) {
//     bannerVM.all_data[bannerVM.now_index]['title']=title;
// }
// //获取作者
// function get_this_music_author(title) {
//     bannerVM.all_data[bannerVM.now_index]['author']=title;
// }
//*********************************************表单end*************************************************//
//*********************************************底部导航*************************************************//
di_select = function(){
    bannerVM.this_type='foot';
    $("#goods_select_id").val('foot');
    $("#form_edit_bottom").css("display",'block').siblings().css("display",'none');
}
set_nab_name = function(name) {
    bannerVM.nab_name=name;
}
fontColorSet_set = function(color) {
    bannerVM.font_color=color;
    $("#fontColorSet_text").html(color);
}
iconColorSet_set = function(color) {
    $("#iconColorSet_text").html(color);
}
pureBorderColor_set = function(color) {
    bannerVM.db_color=color;
    $("#pureBorderColor_text").html(color);
}
DhColor_set = function(color) {
    $("#fontColorSet_text").html(color);
}
//底部导航单独一条名称
this_di_name = function(obj,name) {
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
tool_up_vue = function(){
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
tool_down_vue = function() {
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
head_info = function() {
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
//获取富文本内容
getRichNode = function(txt) {
    bannerVM.all_data[bannerVM.now_index]['content'] = txt;
}
//获取pagesURL
get_not_attr = function(index,item) {
    console.log(111111111)
    console.log(index + 'index')
    console.log(item + 'item')
    console.log(bannerVM.this_type);
    console.log(111111111)
    if (bannerVM.this_type=="foot"){
        var new_item=bannerVM.menu_list[index];
        new_item['imgurl']= removeAllSpace(item['imgurl']); 
        new_item['linkname']=item['name'];
        Vue.set(bannerVM.menu_list,index,new_item);
    } else {
        var new_item=bannerVM.all_data[bannerVM.now_index]['list'][index];
        new_item['pagesurl']= removeAllSpace(item['imgurl']);
        new_item['name']=item['name'];
        new_item['linkname']=item['name'];
        new_item['linkid']=item['linkid'] ? item['linkid'] : -1;
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
}
get_position = function(lat,lng) {
    bannerVM.all_data[bannerVM.now_index]['lat']=lat;
    bannerVM.all_data[bannerVM.now_index]['lng']=lng;
    $('#lng').val(lng);
    $('#lat').val(lat);
}
//获取pagesURL
get_images = function(index,item,a,b,c,this_index) {
    var new_item =bannerVM.all_data[bannerVM.now_index]['list'][this_index];
    console.log(item)
    console.log(new_item)
    new_item['name'] = item['short_title'];
    new_item['imgurl'] = item['img_path'];
    new_item['price'] =item['price'];
    new_item['id'] =item['id'];
    Vue.set(bannerVM.goodlist,this_index,new_item);
}
//获取商户id
get_store_info_id = function(index,item,this_index) {

    var new_item =bannerVM.all_data[bannerVM.now_index]['list'][this_index];

    new_item['id'] =item['id'];
    new_item['imgurl'] = item['img_path'];
    new_item['title'] = item['title'];
    new_item['tel'] =item['tel'];
    new_item['time'] =item['time'];
    console.log(this_index);
    console.log(new_item);
    Vue.set(bannerVM.storelist,this_index,new_item);
    bannerVM.all_data[bannerVM.now_index]['door_name']=item['title'];
    bannerVM.all_data[bannerVM.now_index]['door_job']=item['time'];
    bannerVM.all_data[bannerVM.now_index]['door_phone']=item['tel'];
    bannerVM.all_data[bannerVM.now_index]['imgurl']=item['img_path'];
}
//获取优惠券id
get_coupons_info_id = function(index,item,this_index) {

    var new_item =bannerVM.all_data[bannerVM.now_index]['list'][this_index];

    new_item['id'] =item['id'];
    new_item['m_price'] = item['mprice'];
    new_item['mj_price'] = item['mjprice'];
    new_item['name'] = item['name'];
    Vue.set(bannerVM.couponslist,this_index,new_item);
}
//保存
save_template = function(event) {
    var bottomnav = bannerVM.menu_list;
    var sendnav = [];
    for (var i in bottomnav) {
        var imga = bottomnav[i].page_icon;
        var imgb = bottomnav[i].page_select_icon;
        if (imga.match(imgroot)) {
            imga = imga.replace(imgroot,"");
        }
        if (imgb.match(imgroot)) {
            imgb = imgb.replace(imgroot,"");
        }
        var json = {
            title: bottomnav[i].name,
            link_type: 1,
            type:3,
            url: bottomnav[i].imgurl,
            clickago_icon: imga,
            clickafter_icon: imgb,
            sort: i,
            state: 1,
            url_name: bottomnav[i].linkname
        }
        sendnav.push(json);
    }
    var index_title = bannerVM.nab_name;
    var fontcolor = bannerVM.nab_color;
    var top_color = bannerVM.dh_color;
    var bottom_color = bannerVM.db_color;
    var bottom_fontcolor_a = bannerVM.font_color;
    var bottom_fontcolor_b = $("#iconColorSet").val();
    var sys_set = {
        index_title: index_title,
        fontcolor: fontcolor,
        top_color: top_color,
        bottom_color: bottom_color,
        bottom_fontcolor_a: bottom_fontcolor_a,
        bottom_fontcolor_b: bottom_fontcolor_b
    }
    var modelName = bannerVM.modelName;
    layui.use('table', function () {
        console.log(123);
        var src='';
        layer.msg('正在保存,请稍等！',{icon:16,shade: 0.05});
        html2canvas(document.querySelector("#contents"),{
            useCORS:true,
            logging:false,
        }).then(canvas => {
            var dataUrl = canvas.toDataURL();
            src=dataUrl;
            // $("#imgs").attr({
            //     src: src});
            var param = {
                pic: src,
                index_list: JSON.stringify(bannerVM._data),
                id: bannerVM.hasDefault,
                sendnav: JSON.stringify(sendnav),
                sys_set: JSON.stringify(sys_set),
                name: modelName
            }
            $.ajax({
                type : "post",
                url : hosts+'c=site&a=entry&do=Chome&op=save_tem&m=yztc_sun',
                data : param,
                success : function(data) {
                   if(data['code']==0){
                       layer.msg('保存成功!',{icon:6,time:1000});
                       location.reload();
                       flag = false;
                   } else {
                       flag = false;
                       layer.msg(data['message'],{icon:5,time:1000});
                   }
                }
            });
        });
    })
}
// 添加新模板
get_my_mod = function (event) {
    console.log(bannerVM.menu_list);
    var bottomnav = bannerVM.menu_list;
    var sendnav = [];
    for (var i in bottomnav) {
        var imga = bottomnav[i].page_icon;
        var imgb = bottomnav[i].page_select_icon;
        if (imga.match(imgroot)) {
            imga = imga.replace(imgroot,"");
        }
        if (imgb.match(imgroot)) {
            imgb = imgb.replace(imgroot,"");
        }
        var json = {
            title: bottomnav[i].name,
            link_type: 1,
            type:3,
            url: bottomnav[i].imgurl,
            clickago_icon: imga,
            clickafter_icon: imgb,
            sort: i,
            state: 1,
            url_name: bottomnav[i].linkname
        }
        sendnav.push(json);
    }
    var index_title = bannerVM.nab_name;
    var fontcolor = bannerVM.nab_color;
    var top_color = bannerVM.dh_color;
    var bottom_color = bannerVM.db_color;
    var bottom_fontcolor_a = bannerVM.font_color;
    var bottom_fontcolor_b = $("#iconColorSet").val();
    var sys_set = {
        index_title: index_title,
        fontcolor: fontcolor,
        top_color: top_color,
        bottom_color: bottom_color,
        bottom_fontcolor_a: bottom_fontcolor_a,
        bottom_fontcolor_b: bottom_fontcolor_b
    }
    layui.use('table', function () {
        var src='';
        event.preventDefault();
        layer.msg('正在加载,请稍等！',{icon:16,shade: 0.05});
        html2canvas(document.querySelector("#contents"),{
            useCORS:true,
            logging:false,
        }).then(canvas => {
            var dataUrl = canvas.toDataURL();
            src=dataUrl;
            layer.prompt({title: '输入模版名称', formType: 0}, function (text, index) {
                var param = {
                    pic: src,
                    name: text,
                    index_value: JSON.stringify(bannerVM._data),
                    sendnav: JSON.stringify(sendnav),
                    sys_set: JSON.stringify(sys_set)
                }
                 $.ajax({
                    type : "post",
                    url : hosts+'c=site&a=entry&do=Chome&op=add_mytem&m=yztc_sun',
                    data : param,
                    success : function(data) {
                       if(data['code']==0){
                           layer.msg('添加成功!',{icon:6,time:1000});
                       } else {
                           layer.msg(data['message'],{icon:5,time:1000});
                       }
                       layer.close(index);
                    }
                });
            })
        });
    });
};

//打开一个子窗口
lay_open = function(title, url, w, h) {
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
removeAllSpace = function(str) {
    return str.replace(/\s+/g, "");
}
    add_menu_di = function() {
        var item = {};
        item['imgurl'] = "";
        item['name'] = "";
        item['page_icon'] = "";
        item['page_select_icon'] = "";
        item['top'] = bannerVM.menu_list.length * 112;
        bannerVM.menu_list.push(item);
        bannerVM.add_h_di += 112;
        bannerVM.add_top_di += 112;
        if (bannerVM.menu_list.length == 5) {
            bannerVM.add_h_di -= 80;
            bannerVM.display = "none";
        } else {
            bannerVM.display = "block";
        }
    }

setTimeout(function(){
    var editor = UE.getEditor('content');
    editor.addListener('contentChange', function() {
        var txt = editor.getContent();
        console.log(txt)
        bannerVM.all_data[bannerVM.now_index]['content'] = txt;
    });
},1000)

    function getUrlParam(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); 
        var r = window.location.search.substr(1).match(reg);
        if(r != null){
            return decodeURIComponent(r[2]);
        }
        return null;//返回参数值
    }

        //导航栏标题颜色

    $('#BtColorDefault').click(function () {

        if ($('#BtColorCustom').parent().hasClass('selected')) {

            $('#BtColorCustom').parent().removeClass('selected');

        }

        bannerVM.bag_url = host+ "addons/yztc_sun/public/static/menu/images/black.png";

        bannerVM.nab_color = '#000000';

        $(this).parent().addClass('selected');

    })



    $('#BtColorCustom').click(function () {

        if ($('#BtColorDefault').parent().hasClass('selected')) {

            $('#BtColorDefault').parent().removeClass('selected');

        }

        bannerVM.bag_url = host+ "addons/yztc_sun/public/static/menu/images/white.png";

        bannerVM.nab_color = '#ffffff';

        $(this).parent().addClass('selected');

    })
});