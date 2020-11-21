/***** 多级联动SELECT jquery插件 *******/
$.fn.areaPicker = function (opt) {
    var config = $.extend({
        default: {id: "", name: "--请选择--"},
        url: "/index/index/getArea",
    }, opt);
    var selects = $(this).find("select");
    //加载选项
    var loadData = function (obj, url) {
        var def = config.default;
        obj.html('<option value="' + def.id + '">' + def.name + '</option>');
        if (typeof (url) != "undefined") {
            var loadData = JSON.parse($.ajax({async: false, url: url}).responseText);
            for (var i in loadData.data) {
                var item = loadData.data[i];
                if (item != "") {
                    obj.append('<option value="' + item.id + '">' + item.name + '</option>');
                }
            }
        }
    };
    //设置选中值
    var setValue = function (obj, value) {
        obj.val(value);
        obj.attr("value", value);
    };
    //更新处理
    var updateValue = function (index, value) {
        var pid = value;

        for (var i = index + 1; i < selects.length; i++) {
            if (i <= index) continue;
            if (pid == "" && pid == 0) {
                loadData($(selects[i]));
                setValue($(selects[i]), "");
            } else {
                var url = config.url + "?pid=" + pid;
                pid = 0;
                loadData($(selects[i]), url);
                setValue($(selects[i]), value);
            }
        }
    }
    selects.each(function (index) {
        if (index > 0) {
            var pid = $(selects[index - 1]).attr("value");
            if (pid == "" || typeof(pid) == "undefined") {
                loadData($(this));
            } else {
                var url = config.url + "?pid=" + pid;
                loadData($(this), url);
            }
        } else {
            loadData($(this), config.url);
        }
        setValue($(this), $(this).attr('value'));
        $(this).change(function () {
            updateValue(index, $(this).val());
        })
    });
}

/** 封装webupload上传插件 **/
$.fn.webupload = function (options) {
    var btn_id = "#" + $(this).prop("id");
    var allow_image_ext = "jpg,png,gif";
    var upload_swf = "/";
    var max_upload_size = 10 * 1024 * 1024;
    var load_url = "/";
    var op = {
        //选择自动上传
        auto: true,
        //指定选择文件的按钮容器，不指定则不创建按钮
        pick: {
            id: btn_id,
            label: '<i class="Hui-iconfont">&#xe642;</i> 点击上传文件'
        },
        //拖拽容器
        //dnd: '#uploader .queueList',
        //指定监听paste事件的容器，如果不指定，不启用此功能。
        //paste: document.body,
        //指定接受哪些类型的文件。 由于目前还有ext转mimeType表，所以这里需要分开指定。
        accept: {
            title: 'Images',
            extensions: allow_image_ext,
            mimeTypes: 'image/*'
        },
        // swf文件路径
        swf: upload_swf,
        //是否禁掉整个页面的拖拽功能，如果不禁用，图片拖进来的时候会默认被浏览器打开
        disableGlobalDnd: false,
        //是否要分片处理大文件上传
        chunked: false,
        //上传url地址
        server: load_url,
        //验证文件总数量, 超出则不允许加入队列。
        fileNumLimit: 1,
        //验证文件总大小是否超出限制, 超出则不允许加入队列。
        fileSizeLimit: max_upload_size,    // 200 M
        //验证单个文件大小是否超出限制, 超出则不允许加入队列。
        fileSingleSizeLimit: max_upload_size,    // 50 M
        //文件加入队列监听
        onFileQueued: function (file) {

        },
        //开始上传监听
        onStartUpload: function (file) {

        },
        //上传成功监听
        onUploadSuccess: function (file, response) {
            console.log(response);
        },
        //错误监听
        onError: function (code) {
            alert('Error: ' + code);
        },
    };
    options = $.extend({}, op, options);
    WebUploader.create(options);
}



//身份证识别函数
function discriCard(idcard) {
    var ret = {};
    ret.sex = ((idcard.substr(16, 1) % 2) == 1) ? "男" : "女";
    ret.birth = idcard.substring(6, 10) + "-" + idcard.substring(10, 12) + "-" + idcard.substring(12, 14);

    //获取年龄
    var myDate = new Date();
    var month = myDate.getMonth() + 1;
    var day = myDate.getDate();
    ret.age = myDate.getFullYear() - idcard.substring(6, 10) - 1;
    if (idcard.substring(10, 12) < month || idcard.substring(10, 12) == month && idcard.substring(12, 14) <= day) {
        ret.age++;
    }
    return ret;
}

//获取月份的周
function getWeekOfMonth(year_month) {
    //year_month = "2017-4";
    var oneDaySecond = 24 * 60 * 60 * 1000;
    var date = new Date(year_month + "-1");

    var month = date.getMonth();
    var nextMonth = date.getMonth() + 1 <= 11 ? date.getMonth() + 1 : 0;

    var day = date.getDay();
    var start_day = new Date();
    //国外每周从星期天开始
    start_day.setTime(date.getTime() - day * oneDaySecond);
    //国内每周从星期一开始
    start_day.setTime(date.getTime() - (day-1) * oneDaySecond);

    //获取每周日期数据
    var week_date = [];
    var daySencond = start_day.getTime();
    outerloop:for (var w = 0; w <= 6; w++) {
        for (var d = 0; d <= 6; d++) {
            start_day.setTime(daySencond);
            if((start_day.getMonth() == nextMonth) && d==0){
                break outerloop;
            }
            if(d==0){ week_date[w] = [];}
            var fulldate = start_day.getFullYear() + "-" + (start_day.getMonth() + 1) + "-" + start_day.getDate();
            week_date[w].push(fulldate);
            daySencond += oneDaySecond;
        }
    }
    //console.log(week_date);
}

//获取年的周
function getWeekOfYear(year){

    var date = new Date(year+"-1-1");
    var cYear = date.getYear();

    var oneDaySecond = 24 * 60 * 60 * 1000;
    var startDate = new Date();

    var day = date.getDay();

    //国外每周从星期天开始
    startDate.setTime(date.getTime() - day * oneDaySecond);
    //国内每周从星期一开始
    startDate.setTime(date.getTime() - (day-1) * oneDaySecond);

    var week = new Array();
    var daySencond = startDate.getTime();
    outerloop:for(var w=0;w<=53;w++){
        for(var d=0;d<=6;d++){
            startDate.setTime(daySencond);
            if((startDate.getYear() == cYear+1) && d==0){
                break outerloop;
            }
            if(d==0){week[w] = new Array();}
            var fulldate = startDate.getFullYear() + "-" + (startDate.getMonth() + 1) + "-" + startDate.getDate();
            week[w].push(fulldate);
            daySencond += oneDaySecond;
        }
    }
    return week;
}



var util_model = {
    init: function(opt){
        this.templates = this.template(opt);
        this.event(opt.callback,opt.showButton);
        this.center().show();
        return this;
    },
    template: function(opt){
         this.model = $('<div class="toolmodel">');
         this.title = $('<div class="toolmodel_title">');
         this.inner = $('<div class="toolmodel_inner">');
         this.title.html(opt.title + '<span>&times;</span>');
         if(opt.title_bg)this.title.css('background',opt.title_bg);
         if(opt.frame){
            var $this = this,
            frame = document.createElement("iframe");
            frame.src = opt.content;
            frame.style.display = 'none';
            opt.content = '<div class="iframe_load"><i class="fa fa-spinner fa-pulse"></i>正在加载中</div>';
            this.inner.html(opt.content);
            this.inner.append(frame);
            this.frame = frame;
            $(frame).load(function(){
                $this.model.find('.iframe_load').remove();
                frame.style.display = 'block';
            });
         }else{
            this.inner.html(opt.content);
        }
        this.model.append(this.title).append(this.inner);
        if(opt.showButton){
            this.btn = $('<div class="toolmodel_btn">');
            var  sure = $('<span class="sure">'),
                cancle = $('<span class="cancle">');
                sure.html(opt.sureText);
                cancle.html(opt.cancleText);
                this.btn.append(sure).append(cancle);
                this.model.append(this.btn);
        }
        $('body').append(this.model);
        this.model.width(opt.width);
        this.model.height(opt.height);
        if(opt.showScren){
            this.scren = $('<div id="scren">');
            $('body').append(this.scren);
        }
    },
    center: function(){
        var windowWidth = $(window).width();
        var windowHeight = $(window).height();
        var width = this.model.width();
        var height = this.model.height();
        var left = (windowWidth - width) / 2;
        var top = (windowHeight - height) / 2;
        this.model.css({left: left,top : top });
        return this;
    },
    event: function(callback,mark){
        var $this = this;
        this.title.on('click','span',function(){
            $this.remove();
        });
        if(mark){
            this.btn.on('click','span',function(){
                if(callback){
                    if($(this).hasClass('sure')){
                         if($this.frame) callback.call($this.frame,$this);
                         else callback.call($this.inner,$this);
                     }else{
                         $this.remove();
                     }
                }else{
                    $this.remove();
                }
            });
        }
        this.move(this.model,this.title);
    },
    show: function(){
        if(this.scren){
            $this = this;
            this.scren.animate({opacity:1},100,function(){
                $this.model.slideDown(200);
            });
        }else{
            this.model.slideDown(200);
        }
        return this.model;
    },
    remove: function(){
        if(this.scren){
            $this = this;
            this.model.slideUp(200,function(){
                $this.scren.remove();
                $this.model.remove();
            });
        }else{
            this.model.remove();
        }
    },
    move: function(dom,handle){
        handle.on('mousedown',function(e){
            dom.css('user-select','none');
            var data = {
                x : e.clientX,
                y : e.clientY,
                left: dom.offset().left,
                top : dom.offset().top,
                maxY: $(window).height() - dom.height(),
                maxX: $(window).width() - dom.width()
            };
            var left = data.left - data.x;
            var top = data.top - data.y;
            $(document).on('mousemove.module',function(e){
                data.x = e.clientX + left;
                data.y = e.clientY + top;
                if(data.x < 0) data.x = 0;
                else if(data.x > data.maxX) data.x = data.maxX;
                if(data.y < 0) data.y = 0;
                else if(data.y > data.maxY) data.y = data.maxY;
                dom.css({left:data.x,top:data.y});
            }).on('mouseup',function(){
                dom.css('user-select','');
                $(document).off('mousemove.module');
                return false;
            });
        });
    }
};



var model_default = {
    width: 400,
    height: 300,
    showButton: true,
    title_bg: '',
    sureText: '确定',
    cancleText: '取消',
    title: '标题',
    content: '内容',
    showScren: true
};

function model(opt) {
    var option = $.extend({}, model_default, opt);
    util_model.init(option);
}

function iframe(opt){
    opt.frame = true;
    var option = $.extend({}, model_default, opt);
    util_model.init(option);

}