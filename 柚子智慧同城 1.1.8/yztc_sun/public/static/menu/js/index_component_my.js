var snap = location.href;
var cuff = snap.split('addons');
var host = cuff[0];
//单行文本
Vue.component('form_text', {
    props: ['index','title','value','placeholder'],
    template: '<li  title="点击进行修改,拖动交换位置" class="ui-draggable"><div v-on:click="del_left(index)" class="deleteButton"></div><div v-on:click="onc_banner(index,$event)"><div class="title">{{title}}</div><div class="yb_input"><input type="text" :placeholder="placeholder" :value="value" class="es-input data-bind" style="cursor: text; border: 1px solid rgb(239, 239, 239); background: rgb(255, 255, 255); text-align: center;"></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_text").css("display",'none');
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_text").css("display",'block').siblings().css("display",'none');

            $("#id_this_input_title").val(bannerVM.all_data[index]['title']);
            $("#id_this_input_value").val(bannerVM.all_data[index]['value']);
            $("#id_this_input_placeholder").val(bannerVM.all_data[index]['placeholder']);
            if (bannerVM.all_data[index]['password']=='0'){
                $("#this_input_text_password1").prop("checked", "checked");
            }else {
                $("#this_input_text_password2").prop("checked", "checked");
            }

            if (bannerVM.all_data[index]['empty']==false){
                $("#this_input_text_empty1").prop("checked", "checked");
            }else {
                $("#this_input_text_empty2").prop("checked", "checked");
            }
            if (bannerVM.all_data[index]['form_type']=='text'){
                $("#this_input_text_type1").prop("checked", "checked");
            }else if(bannerVM.all_data[index]['form_type']=='number'){
                $("#this_input_text_empty2").prop("checked", "checked");
            }else if(bannerVM.all_data[index]['form_type']=='idcard'){
                $("#this_input_text_empty3").prop("checked", "checked");
            }else if(bannerVM.all_data[index]['form_type']=='digit'){
                $("#this_input_text_empty4").prop("checked", "checked");
            }

            bannerVM.now_index = index;
        },
    },
})
//单行文本
Vue.component('form_textarea', {
    props: ['index','title','value','placeholder'],
    template: '<li title="点击进行修改,拖动交换位置" class="ui-draggable"><div v-on:click="del_left(index)" class="deleteButton"></div><div v-on:click="onc_banner(index,$event)"><div class="title">{{title}}</div><div class="yb_textarea"><textarea :placeholder="placeholder" class="es-input data-bind" style="cursor: text; border: 1px solid rgb(239, 239, 239); background: rgb(255, 255, 255); text-align: center;">{{value}}</textarea></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_textarea").css("display",'none');
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_textarea").css("display",'block').siblings().css("display",'none');

            $("#id_this_textarea_title").val(bannerVM.all_data[index]['title']);
            $("#id_this_textarea_value").val(bannerVM.all_data[index]['value']);
            $("#id_this_textarea_placeholder").val(bannerVM.all_data[index]['placeholder']);
            $("#id_this_textarea_maxlength").val(bannerVM.all_data[index]['maxlength']);

            if (bannerVM.all_data[index]['empty']==false){
                $("#this_input_textarea_empty1").prop("checked", "checked");
            }else {
                $("#this_input_textarea_empty2").prop("checked", "checked");
            }
            bannerVM.now_index = index;
        },
    },
})
//多项选择器
Vue.component('form_checkbox', {
    props: ['index','title','value','list'],
    template: '<li  title="点击进行修改,拖动交换位置" class="ui-draggable"><div v-on:click="del_left(index)" class="deleteButton"></div><div v-on:click="onc_banner(index,$event)"><div class="title">{{title}}</div><div class="yb_checkbox" v-for="m in list"><input style="display: block" type="checkbox" :value="m.value" class="es-input data-bind">{{m.value}}</div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_checkbox").css("display",'none');
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_checkbox").css("display",'block').siblings().css("display",'none');

            $("#id_this_checkbox_title").val(bannerVM.all_data[index]['title']);
            if (bannerVM.all_data[index]['empty']===false){
                $("#this_input_checkbox_empty1").prop("checked", "checked");
            }else {
                $("#this_input_checkbox_empty2").prop("checked", "checked");
            }
            bannerVM.checkbox_list=bannerVM.all_data[index]['list'];
            bannerVM.now_index = index;
        },
    },
})
//单项选择器
Vue.component('form_radio', {
    props: ['index','title','value','list','time_key'],
    template: '<li title="点击进行修改,拖动交换位置" class="ui-draggable"><div v-on:click="del_left(index)" class="deleteButton"></div><div v-on:click="onc_banner(index,$event)"><div class="title">{{title}}</div><div class="yb_radio" v-for="m in list"><input style="display: block" type="radio" :value="m.value" :name="\'radio-\'+time_key"  :checked="m.checked" disabled="true" class="es-input data-bind">{{m.value}}</div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_radio").css("display",'none');
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_radio").css("display",'block').siblings().css("display",'none');

            $("#id_this_radio_title").val(bannerVM.all_data[index]['title']);
            bannerVM.radio_list=bannerVM.all_data[index]['list'];

            bannerVM.now_index = index;
        },
    },
})
//下拉选择器
Vue.component('form_picker', {
    props: ['index','title','value','list','time_key'],
    template: '<li title="点击进行修改,拖动交换位置" class="ui-draggable"><div v-on:click="del_left(index)" class="deleteButton"></div><div  v-on:click="onc_banner(index,$event)"><div class="title">{{title}}</div><div class="yb_select"><select style="display: block"><option v-for="o in list" :value="o.range">{{o.range}}</option></select></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_picker").css("display",'none');
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_picker").css("display",'block').siblings().css("display",'none');


            $("#id_this_picker_title").val(bannerVM.all_data[index]['title']);

            bannerVM.picker_list=bannerVM.all_data[index]['list'];

            bannerVM.now_index = index;
        },
    },
})
//日期
Vue.component('form_time_one', {
    props: ['index','title','time_key','default_time'],
    template: '<li title="点击进行修改,拖动交换位置" class="ui-draggable"><div v-on:click="del_left(index)" class="deleteButton"></div><div  v-on:click="onc_banner(index,$event)"><div class="title">{{title}}</div><div class="yb_time_one"><input type="text" :value="default_time" readonly class="es-input data-bind" style="cursor: text; border: 1px solid rgb(239, 239, 239); background: rgb(255, 255, 255); text-align: center;"></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_time_one").css("display",'none');
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_time_one").css("display",'block').siblings().css("display",'none');

            $("#id_this_time_one_title").val(bannerVM.all_data[index]['title']);

            if (bannerVM.all_data[index]['empty']==false){
                $("#this_time_one_empty1").prop("checked", "checked");
            }else {
                $("#this_time_one_empty2").prop("checked", "checked");
            }
            $("#id_this_time_one_def").val(bannerVM.all_data[index]['default']);

            $("#id_this_time_one_star").val(bannerVM.all_data[index]['star']);
            $("#id_this_time_one_end").val(bannerVM.all_data[index]['end']);

            bannerVM.now_index = index;
        },
    },
})
//日期范围
Vue.component('form_time_two', {
    props: ['index','title','time_key','default_time1','default_time2'],
    template: '<li title="点击进行修改,拖动交换位置" class="ui-draggable"><div v-on:click="del_left(index)" class="deleteButton"></div><div v-on:click="onc_banner(index,$event)"><div class="title">{{title}}</div><div class="yb_time_two"><input type="text" :value="default_time1" readonly class="es-input data-bind" style="cursor: text; border: 1px solid rgb(239, 239, 239); background: rgb(255, 255, 255); text-align: center;">-<input type="text" :value="default_time2" readonly class="es-input data-bind" style="cursor: text; border: 1px solid rgb(239, 239, 239); background: rgb(255, 255, 255); text-align: center;"></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_time_two").css("display",'none');
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_time_two").css("display",'block').siblings().css("display",'none');

            $("#id_this_time_two_title").val(bannerVM.all_data[index]['title']);

            if (bannerVM.all_data[index]['empty']==false){
                $("#this_time_tow_empty1").prop("checked", "checked");
            }else {
                $("#this_time_tow_empty2").prop("checked", "checked");
            }
            $("#id_this_time_tow_def1").val(bannerVM.all_data[index]['default1']);
            $("#id_this_time_tow_def2").val(bannerVM.all_data[index]['default2']);

            $("#id_this_time_tow_star").val(bannerVM.all_data[index]['star']);
            $("#id_this_time_tow_end").val(bannerVM.all_data[index]['end']);


            bannerVM.now_index = index;
        },
    },
})
//城市选择
Vue.component('form_region', {
    props: ['index','title','time_key'],
    template: '<li title="点击进行修改,拖动交换位置" class="ui-draggable"><div v-on:click="del_left(index)" class="deleteButton"></div><div  v-on:click="onc_banner(index,$event)"><div class="title">{{title}}</div><div  class="yb_region"><input type="text" value="省" readonly class="es-input data-bind" style="cursor: text; border: 1px solid rgb(239, 239, 239); background: rgb(255, 255, 255); text-align: center;">-<input type="text" value="市" readonly class="es-input data-bind" style="cursor: text; border: 1px solid rgb(239, 239, 239); background: rgb(255, 255, 255); text-align: center;">-<input type="text" value="区/县" readonly class="es-input data-bind" style="cursor: text; border: 1px solid rgb(239, 239, 239); background: rgb(255, 255, 255); text-align: center;"></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_region").css("display",'none');
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_region").css("display",'block').siblings().css("display",'none');

            $("#id_this_region_title").val(bannerVM.all_data[index]['title']);

            if (bannerVM.all_data[index]['empty']==false){
                $("#this_region_empty1").prop("checked", "checked");
            }else {
                $("#this_region_empty2").prop("checked", "checked");
            }

            bannerVM.now_index = index;
        },
    },
})
//单图
Vue.component('form_pic', {
    props: ['index','title','time_key'],
    template: '<li  title="点击进行修改,拖动交换位置" class="ui-draggable"><div v-on:click="del_left(index)" class="deleteButton"></div><div v-on:click="onc_banner(index,$event)"><div class="title">{{title}}</div><div class="yb_pic"><img style="width: 100px;height: 100px;" src="'+host+'addons/yb_shop/core/public/menu/images/add_pic.jpg"></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_pic").css("display",'none');
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_pic").css("display",'block').siblings().css("display",'none');



            $("#id_this_pic_title").val(bannerVM.all_data[index]['title']);

            if (bannerVM.all_data[index]['empty']==false){
                $("#this_pic_empty1").prop("checked", "checked");
            }else {
                $("#this_pic_empty2").prop("checked", "checked");
            }


            bannerVM.now_index = index;
        },
    },
})
Vue.component('form_pic_arr', {
    props: ['index','title','time_key'],
    template: '<li title="点击进行修改,拖动交换位置" class="ui-draggable"><div v-on:click="del_left(index)" class="deleteButton"></div><div v-on:click="onc_banner(index,$event)"><div class="title">{{title}}</div><div class="yb_pic_arr"><img style="width: 100px;height: 100px;" src="'+host+'addons/yb_shop/core/public/menu/images/add_pic.jpg"></div></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_edit_pic_arr").css("display",'none');
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_edit_pic_arr").css("display",'block').siblings().css("display",'none');


            $("#id_this_pic_arr_title").val(bannerVM.all_data[index]['title']);

            if (bannerVM.all_data[index]['empty']==false){
                $("#this_pic_arr_empty1").prop("checked", "checked");
            }else {
                $("#this_pic_arr_empty2").prop("checked", "checked");
            }

            bannerVM.now_index = index;
        },
    },
})
Vue.component('form_button', {
    props: ['index','title','color','size','text_color'],
    template: '<li id="get_button_len" title="点击进行修改,拖动交换位置" class="ui-draggable"><div v-on:click="del_left(index)" class="deleteButton"></div><div class="form_button"  v-on:click="onc_banner(index,$event)" ><button type="button"  :style="'+"'background-color:'"+'+color+'+"';font-size:'"+'+size+'+"'px;color:'"+'+text_color">{{title}}</button></div></li>',
    methods: {
        //删除
        del_left: function (index) {
            bannerVM.all_data.splice(index,1);
            $("#form_button").css("display",'none');
        },
        //选中
        onc_banner:function (index,e) {
            $(".activeMod").children().children().removeClass('yb_select');
            $(".activeMod").children().children().eq(index).addClass('yb_select');
            $("#form_button").css("display",'block').siblings().css("display",'none');
            $("#id_this_button_title").val(bannerVM.all_data[index]['title']);
            $("#id_this_button_bg").val(bannerVM.all_data[index]['color']);
            $("#id_this_button_color").val(bannerVM.all_data[index]['text_color']);
            bannerVM.now_index = index;
        },
    },
})
var bannerVM = new Vue({
    el: '#b_menu',
    data: {
        all_data: [],//所有数据
        checkbox_list: [],//多选框数据
        radio_list: [],//单选框数据
        picker_list: [],//下拉框
        now_index : 0,//当前下标
        this_index : 0,//当前下标
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
        this.$dragging.$on('dragend', function(data) {
        })
    },
})