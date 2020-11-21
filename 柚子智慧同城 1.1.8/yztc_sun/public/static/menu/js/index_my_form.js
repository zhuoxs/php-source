var snap = location.href;
var cuff = snap.split('addons');
var host = cuff[0];
//单行文本
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==1){
        $("#form_edit_text").css("display",'block').siblings().css("display",'none');
        bannerVM.this_index=bannerVM.all_data.length;
        var new_item ={};
        new_item['module']="input";
        new_item['title']="姓名";
        new_item['name']="field_"+ bannerVM.this_index+''+Date.parse(new Date())/1000+""+Math.round(Math.random()*100000)+"-input";
        new_item['value']="";
        new_item['type']="form_text";
        new_item['empty']=false;
        new_item['form_type']="text";
        new_item['password']=false;
        new_item['placeholder']="";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        bannerVM.now_index = bannerVM.all_data.length-1;
    }
});
//标题
function this_input_title(title) {
    bannerVM.all_data[bannerVM.now_index]['title']=title;
}
//初始值
function this_input_value(title) {
    bannerVM.all_data[bannerVM.now_index]['value']=title;
}
//提示内容
function this_input_placeholder(title) {
    bannerVM.all_data[bannerVM.now_index]['placeholder']=title;
}
//是否是密码
$("input[name='this_input_text_password']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['password']=eval(this.value.toLowerCase());
    $(this).prop("checked", "checked");
})
//选择是否为空
$("input[name='this_input_text_empty']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['empty']=eval(this.value.toLowerCase());
    $(this).prop("checked", "checked");
})
//选择类型
$("input[name='this_input_text_type']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['form_type']=this.value;
    $(this).prop("checked", "checked");
})
//多行文本
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==2){
        $("#form_edit_textarea").css("display",'block').siblings().css("display",'none');
        bannerVM.this_index=bannerVM.all_data.length;
        var new_item ={};
        new_item['module']="textarea";
        new_item['title']="内容";
        new_item['name']="field_"+ bannerVM.this_index+''+Date.parse(new Date())/1000+""+Math.round(Math.random()*100000)+"-textarea";
        new_item['value']="";
        new_item['empty']=false;
        new_item['type']="form_textarea";
        new_item['placeholder']="";
        new_item['maxlength']="140";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        bannerVM.now_index = bannerVM.all_data.length-1;
    }
});
function this_textarea_title(title) {
    bannerVM.all_data[bannerVM.now_index]['title']=title;
}
function this_textarea_value(title) {
    bannerVM.all_data[bannerVM.now_index]['value']=title;
}
function this_textarea_placeholder(title) {
    bannerVM.all_data[bannerVM.now_index]['placeholder']=title;
}
function this_textarea_maxlength(title) {
    bannerVM.all_data[bannerVM.now_index]['maxlength']=title;
}
//选择是否为空
$("input[name='this_input_textarea_empty']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['empty']=eval(this.value.toLowerCase());
    $(this).prop("checked", "checked");
})
//多项选择器
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==3){
        $("#form_edit_checkbox").css("display",'block').siblings().css("display",'none');
        bannerVM.this_index=bannerVM.all_data.length;
        var item = {};
        item['value']="选项";
        item['disabled']=false;
        item['checked']=false;
        var arr=[];
        arr.push(item);
        var new_item ={};
        new_item['module']="checkbox";
        new_item['title']="爱好";
        new_item['name']="field_"+  bannerVM.this_index+''+Date.parse(new Date())/1000+""+Math.round(Math.random()*100000)+"-checkbox";
        new_item['value']="";
        new_item['empty']=false;
        new_item['list']=arr;
        new_item['type']="form_checkbox";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        bannerVM.now_index = bannerVM.all_data.length-1;
        bannerVM.checkbox_list=arr;
    }
});
function this_checkbox_title(val) {
    bannerVM.all_data[bannerVM.now_index]['title']=val;
}
function this_input_checkbox_value(obj,val) {
   var index=$(obj).attr('data-index');
    bannerVM.all_data[bannerVM.now_index]['list'][index]['value']=val;
}
//选择是否为空
$("input[name='this_input_checkbox_empty']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['empty']=eval(this.value.toLowerCase());
    $(this).prop("checked", "checked");
})
function checkbox_add_menu() {
    var item = {};
    item['value']="选项";
    item['disabled']=false;
    item['checked']=false;
    var arr=[];
    arr.push(item);
    bannerVM.checkbox_list.push(item);
}
//单项选择器
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==4){
        $("#form_edit_radio").css("display",'block').siblings().css("display",'none');
        bannerVM.this_index=bannerVM.all_data.length;
        var item = {};
        item['value']="选项";
        item['disabled']=false;
        item['checked']=false;
        var arr=[];
        arr.push(item);
        var new_item ={};
        new_item['module']="radio";
        new_item['title']="性别";
        new_item['name']="field_"+ bannerVM.this_index+''+Date.parse(new Date())/1000+""+Math.round(Math.random()*100000)+"-radio";
        new_item['value']="";
        new_item['empty']=false;
        new_item['list']=arr;
        new_item['type']="form_radio";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        bannerVM.now_index = bannerVM.all_data.length-1;
        bannerVM.radio_list=arr;
    }
});
function this_radio_title(val) {
    bannerVM.all_data[bannerVM.now_index]['title']=val;
}
function radio_add_menu() {
    var item = {};
    item['value']="选项";
    item['disabled']=false;
    item['checked']=false;
    var arr=[];
    arr.push(item);
    bannerVM.radio_list.push(item);
}
function set_radio_def(obj,val) {
    var index=$(obj).attr('data-index');
    console.log(index);
    var list=bannerVM.all_data[bannerVM.now_index]['list'];
    $.each(list,function (ind,list) {
        bannerVM.all_data[bannerVM.now_index]['list'][ind]['checked']=false;
    })

    bannerVM.all_data[bannerVM.now_index]['list'][index]['checked']=eval(val.toLowerCase());
}
//下拉选择器
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==5){
        $("#form_edit_picker").css("display",'block').siblings().css("display",'none');
        bannerVM.this_index=bannerVM.all_data.length;
        var item = {};
        item['range']="选项";
        var arr=[];
        arr.push(item);
        var new_item ={};
        new_item['module']="picker";
        new_item['title']="下拉框";
        new_item['name']="field_"+ bannerVM.this_index+''+Date.parse(new Date())/1000+""+Math.round(Math.random()*100000)+"-picker";
        new_item['list']=arr;
        new_item['type']="form_picker";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        bannerVM.now_index = bannerVM.all_data.length-1;
        bannerVM.picker_list=arr;
    }
});
function this_picker_title(val) {
    bannerVM.all_data[bannerVM.now_index]['title']=val;
}
function picker_add_menu() {
    var item = {};
    item['range']="选项";
    var arr=[];
    arr.push(item);
    bannerVM.picker_list.push(item);
}
//日期
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==6){
        $("#form_edit_time_one").css("display",'block').siblings().css("display",'none');
        bannerVM.this_index=bannerVM.all_data.length;
        var now = new Date();
        var time = now.getFullYear() + "-" +((now.getMonth()+1)<10?"0":"")+(now.getMonth()+1)+"-"+(now.getDate()<10?"0":"")+now.getDate();
        var new_item ={};
        new_item['module']="time_one";
        new_item['title']="日期";
        new_item['name']="field_"+ bannerVM.this_index+''+Date.parse(new Date())/1000+""+Math.round(Math.random()*100000)+"-time_one";
        new_item['empty']=false;
        new_item['default']=time;
        new_item['start']='';
        new_item['end']='';
        new_item['type']="form_time_one";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        bannerVM.now_index = bannerVM.all_data.length-1;
        $("#id_this_time_one_def").val(time);
    }
});
function this_time_one_title(val) {
    bannerVM.all_data[bannerVM.now_index]['title']=val;
}
//选择是否为空
$("input[name='this_time_one_empty']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['empty']=eval(this.value.toLowerCase());
    $(this).prop("checked", "checked");
})
function this_time_one_def(element) {
    bannerVM.all_data[bannerVM.now_index]['default']=element.cal.getNewDateStr();
}
function this_time_one_star(element) {
    bannerVM.all_data[bannerVM.now_index]['start']=element.cal.getNewDateStr();
    $("#id_this_time_one_star").val(element.cal.getNewDateStr());
}
function this_time_one_end(element) {
    bannerVM.all_data[bannerVM.now_index]['end']=element.cal.getNewDateStr();
    $("#id_this_time_one_end").val(element.cal.getNewDateStr());
}
//日期
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==7){
        $("#form_edit_time_two").css("display",'block').siblings().css("display",'none');
        bannerVM.this_index=bannerVM.all_data.length;
        var now = new Date();
        var time = now.getFullYear() + "-" +((now.getMonth()+1)<10?"0":"")+(now.getMonth()+1)+"-"+(now.getDate()<10?"0":"")+now.getDate();
        var time1 = now.getFullYear()+1 + "-" +((now.getMonth()+1)<10?"0":"")+(now.getMonth()+1)+"-"+(now.getDate()<10?"0":"")+now.getDate();
        var new_item ={};
        new_item['module']="time_two";
        new_item['title']="日期范围";
        new_item['name']="field_"+ bannerVM.this_index+''+Date.parse(new Date())/1000+""+Math.round(Math.random()*100000)+"-time_two";
        new_item['empty']=false;
        new_item['default1']=time;
        new_item['default2']=time1;
        new_item['start']='';
        new_item['end']='';
        new_item['type']="form_time_two";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        bannerVM.now_index = bannerVM.all_data.length-1;
        $("#id_this_time_tow_def1").val(time);
        $("#id_this_time_tow_def2").val(time1);
    }
});
function this_time_two_title(val) {
    bannerVM.all_data[bannerVM.now_index]['title']=val;
}
//选择是否为空
$("input[name='this_time_tow_empty']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['empty']=eval(this.value.toLowerCase());
    $(this).prop("checked", "checked");
})
function this_time_tow_def1(element) {
    bannerVM.all_data[bannerVM.now_index]['default1']=element.cal.getNewDateStr();
    $("#id_this_time_tow_def1").val(element.cal.getNewDateStr());
}
function this_time_tow_def2(element) {
    bannerVM.all_data[bannerVM.now_index]['default2']=element.cal.getNewDateStr();
    $("#id_this_time_tow_def2").val(element.cal.getNewDateStr());
}
function this_time_tow_star(element) {
    bannerVM.all_data[bannerVM.now_index]['star']=element.cal.getNewDateStr();
    $("#id_this_time_tow_star").val(element.cal.getNewDateStr());
}
function this_time_tow_end(element) {
    bannerVM.all_data[bannerVM.now_index]['end']=element.cal.getNewDateStr();
    $("#id_this_time_tow_end").val(element.cal.getNewDateStr());
}
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==8){
        $("#form_edit_region").css("display",'block').siblings().css("display",'none');
        bannerVM.this_index=bannerVM.all_data.length;
        var new_item ={};
        new_item['module']="region";
        new_item['title']="地区";
        new_item['name']="field_"+ bannerVM.this_index+''+Date.parse(new Date())/1000+""+Math.round(Math.random()*100000)+"-region";
        new_item['empty']=false;
        new_item['default']='';
        new_item['type']="form_region";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        bannerVM.now_index = bannerVM.all_data.length-1;
    }
});
function this_region_title(val) {
    bannerVM.all_data[bannerVM.now_index]['title']=val;
}
$("input[name='this_region_empty']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['empty']=eval(this.value.toLowerCase());
    $(this).prop("checked", "checked");
})
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==9){
        $("#form_edit_pic").css("display",'block').siblings().css("display",'none');
        bannerVM.this_index=bannerVM.all_data.length;
        var new_item ={};
        new_item['module']="pic";
        new_item['title']="Logo";
        new_item['name']="field_"+ bannerVM.this_index+''+Date.parse(new Date())/1000+""+Math.round(Math.random()*100000)+"-pic";
        new_item['empty']=false;
        new_item['type']="form_pic";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        bannerVM.now_index = bannerVM.all_data.length-1;
    }
});
function this_pic_title(val) {
    bannerVM.all_data[bannerVM.now_index]['title']=val;
}
$("input[name='this_pic_empty']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['empty']=eval(this.value.toLowerCase());
    $(this).prop("checked", "checked");
})
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==10){
        $("#form_edit_pic_arr").css("display",'block').siblings().css("display",'none');
        bannerVM.this_index=bannerVM.all_data.length;
        var new_item ={};
        new_item['module']="pic_arr";
        new_item['title']="商品图片";
        new_item['name']="field_"+ bannerVM.this_index+''+Date.parse(new Date())/1000+""+Math.round(Math.random()*100000)+"-pic_arr";
        new_item['empty']=false;
        new_item['type']="form_pic_arr";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        bannerVM.now_index = bannerVM.all_data.length-1;
    }
});
function this_pic_arr_title(val) {
    bannerVM.all_data[bannerVM.now_index]['title']=val;
}
$("input[name='this_pic_arr_empty']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['empty']=eval(this.value.toLowerCase());
    $(this).prop("checked", "checked");
})
$(".j-diy-addModule").click(function () {
    if($(this).attr('data-type')==11){

        if ($("#get_button_len").length>0){
            layer.msg('按钮只能添加一个',{icon:5,time:1000});
            return false;
        }


        $("#form_button").css("display",'block').siblings().css("display",'none');
        bannerVM.this_index=bannerVM.all_data.length;
        var new_item ={};
        new_item['module']="button";
        new_item['color']="#dedede";
        new_item['title']="提交";
        new_item['text_color']="#646464";
        new_item['type']="form_button";
        new_item['time_key'] = Date.parse(new Date())/1000+""+Math.round(Math.random()*100000);
        bannerVM.all_data.push(new_item);
        bannerVM.now_index = bannerVM.all_data.length-1;
    }
});
function this_button_title(val) {
    bannerVM.all_data[bannerVM.now_index]['title']=val;
}
function this_button_bg(color) {
    bannerVM.all_data[bannerVM.now_index]['color']=color;
}
function this_button_color(color) {
    bannerVM.all_data[bannerVM.now_index]['text_color']=color;
}
$("input[name='this_button_empty']").click(function () {
    bannerVM.all_data[bannerVM.now_index]['size']=this.value;
    $(this).prop("checked", "checked");
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
//删除选项
function del_checkbox(obj) {
    if ( bannerVM.all_data[bannerVM.now_index]['list'].length==1){
        layer.msg('至少留一个吧~',{icon:5,time:1000});
        return false;
    }
    var index=$(obj).attr('data-index');
    bannerVM.all_data[bannerVM.now_index]['list'].splice(index,1)
}


var lock = false;

function add_submit() {
    event.preventDefault();
    layer.msg('正在加载,请稍等！',{icon:16,shade: 0.05});
    html2canvas(document.querySelector("#get_img"),{
        useCORS:true,
        logging:false,
    }).then(canvas => {
        var dataUrl = canvas.toDataURL();
    src=dataUrl;

    var form_title=$("#form_title").val();
    if (form_title==''){
        layer.prompt({title: '输入表单名称',formType: 0}, function (text, index) {
            if(!lock){
                lock = true;
                var id=$("#form_id").val();
                var form_type=$('input:radio[name="this_form_type"]:checked').val();
                $.ajax({
                    type: "post",
                    url: host + "addons/yb_shop/core/index.php?s=/admin/menu/universal_form_add",
                    data: {
                        'index_list': JSON.stringify(bannerVM._data),
                        'title':text,
                        'id':id,
                        'img':src,
                        'form_type':form_type
                    },
                    success: function (data) {
                        if(data['code']>0 ){
                            layer.msg('成功',{icon:1,time:1000},function () {
                                location.href=host+"addons/yb_shop/core/index.php?s=/admin/menu/universal_form";
                            });
                        }else{
                            layer.msg('失败',{icon:5,time:1000});
                            lock = false;
                        }
                    }
                })
            }

        })
    }else {
            if(!lock){
                lock = true;
                var id=$("#form_id").val();
                $.ajax({
                    type: "post",
                    url: host + "addons/yb_shop/core/index.php?s=/admin/menu/universal_form_add",
                    data: {
                        'index_list': JSON.stringify(bannerVM._data),
                        'id':id,
                        'img':src
                    },
                    success: function (data) {
                        if(data['code']>0 ){
                            layer.msg('成功',{icon:1,time:1000},function () {
                                location.href=host+"addons/yb_shop/core/index.php?s=/admin/menu/universal_form";
                            });
                        }else{
                            layer.msg('失败',{icon:5,time:1000});
                            lock = false;
                        }
                    }
                })
            }

    }

    })
}
