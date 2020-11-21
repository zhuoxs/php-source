var modal = {};
$(function () {
    //--- 初始化
    modal.init = function() {
        //判断当前浏览器是否支持该图片上传的插件
        if(typeof FileReader === 'undefined') {
            var tipsInfo = "<span class='uploadImg_unsupportedTips'>抱歉，你的浏览器不支持该图片上传!</span>";
            $(".uploadImg_content.uploadImg_main").html(tipsInfo);
            return false;
        }
        //声明基本变量
        modal.fd        = ''; //FormData方式发送请求
        modal.url       = common.createUrl('common/wlCommon/createImages');//图片上传请求的地址
        modal.view      = $('.uploadImg_createImgView');//删除触发class
        modal.delurl    = common.createUrl('common/wlCommon/deleteImages');//删除图片请求的地址
        modal.state     = true;//判断是否执行change事件   由于当同页面多个当前模块内容时会同时触发 模块数量的次数 添加当前字段判断是否触发change事件
        modal.sizeLimit =  1000000;//压缩图片的大小限制，超过限制需要压缩图片 单位：像素  约为100kb
        modal.timer     = '';//定时器
        modal.length    = 0;
        //上传图片被触发
        $(".uploadImg_content.uploadImg_main").on('change','.uploadImg_fileContent',function (e) {
            if(!modal.state){
                return false;
            }
            modal.state = false;
            //获取基本信息
            modal.fd = new FormData();
            var the = $(this),
                theThis = the.closest(".uploadImg_content.uploadImg_main").siblings(".uploadImg_createImgView"),
                existenceNum = the.closest(".uploadImg_content.uploadImg_main").siblings(".uploadImg_createImgView").children(".uploadImg_images").length,//已存在的数量
                max = the.closest(".uploadImg_content.uploadImg_main").prev().prev().attr("maxlength"),//限制长度获取
                surplusNum = parseInt(max) - parseInt(existenceNum),//还能添加的图片数量
                file = e.currentTarget.files,//上传的图片资源信息
                name = the.closest(".uploadImg_content.uploadImg_main").prev().prev().attr("name"),//限制长度获取
                count = file.length;//上传的图片总数量
                modal.length = count;
            modal.loading(theThis);
            //判断数量限制
            if(count > surplusNum){
                modal.tips("还能上传"+surplusNum+"张图片");
                modal.state = true;
                modal.loading(theThis);
                return false;
            }
            //开始上传图片 ——  进行图片预览
            $.each(file,function (k,v) {
                var img = v;
                var maxSize = 10;
                var sizeRestriction = 1024*1024*maxSize;
                var size = img['size'];
                var type = img['type'];
                //判断图片格式
                if (!type.match(/.jpg|.gif|.png|.jpeg|.bmp/i)) {　　 //判断上传文件格式
                    modal.tips("第"+(k+1)+"张图上传的格式不正确，请重新选择");
                    modal.state = true;
                    modal.loading(theThis);
                    return true;
                }
                //判断图片大小
                if(size > sizeRestriction && type.match(/.jpg|.gif|.png|.jpeg/i)){
                    modal.tips("第"+(k+1)+"张图上传的大小超过"+maxSize+"M");
                    modal.state = true;
                    modal.loading(theThis);
                    return true;
                }
                //预览图片信息
                var reader = new FileReader;
                reader.readAsDataURL(v);
                reader.onload = function (evt) {
                    var image = new Image();
                    image.onload = function () {
                        var imgObj = {};
                        imgObj.pic_url = this.src;
                        imgObj.width  = this.width;
                        imgObj.height  = this.height;
                        var number = theThis.children(".uploadImg_images").length;
                        var imgstr = '<span class="uploadImg_images changeImg_position'+number+'"><img src="' + this.src + '"><input value="" type="hidden" name="'+name+'"></span>';
                        theThis.append(imgstr);
                        //上传图片信息
                        modal.uploadImg(theThis,v,imgObj,size,number);
                    };
                    image.src = evt.target.result;
                };
            });
        });
        //点击删除图片被触发
        modal.view.on('click','.uploadImg_images',function () {
            if(!modal.state){
                return false;
            }
            modal.state = false;
            var the = $(this);
            $.confirm('确定删除当前图片吗？',function () {
                var imgurl = the.children("img").attr("src");
                //请求删除
                $.post(modal.delurl,{url:imgurl});
                //由于需要时间删除 直接删除页面图片
                the.remove();
                modal.state = true;
            });
        });
    };
    //--- 上传图片获取图片路径
    modal.uploadImg = function (theThis,file,imgObj,size,key) {
        if(modal.sizeLimit < size){
            file = modal.compress(file,imgObj);//图片过大 进行压缩
        }
        modal.fd.append("0", file);
        $.ajax({
            url: modal.url,
            type: "POST",
            dataType:'json',
            data: modal.fd,
            async:false,
            processData: false,  // 告诉jQuery不要去处理发送的数据
            contentType: false,   // 告诉jQuery不要去设置Content-Type请求头
            success:function (res) {
                var val = res.data[0];
                theThis.children(".uploadImg_images.changeImg_position"+key+"").children("input").val(val['img']);
                modal.state = true;
                modal.length--;
                if(modal.length == 0){
                    modal.loading(theThis);
                }
            }
        });
    };
    //--- 生成压缩后的图片资源信息
    modal.compress = function(img,imgObj) {
        //图片信息
        var image = new Image();
        image.src = imgObj.pic_url;
        var minImage = new Image();
        var dataurl = minImage.src = modal.compressimg(image);
        //转换成file对象
        var arr = dataurl.split(',');
        var mime = arr[0].match(/:(.*?);/)[1];
        var bstr = atob(arr[1]);
        var n = bstr.length;
        var u8arr = new Uint8Array(n);
        while(n--){
            u8arr[n] = bstr.charCodeAt(n);
        }
        var fileObj = new File([u8arr], img.name, {type:mime});
        return fileObj;
    };
    //--- 进行图片的压缩操作
    modal.compressimg = function(img) {
        var width = img.width;
        var height = img.height;
        var bili = 1;
        if(width>480){
            bili = 480/width;
        }else{
            if(height>640){
                bili = 640/height;
            }else{
                bili=1;
            }
        }
        //建立canvas内容
        //用于压缩图片的canvas
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext('2d');
        // 瓦片canvas
        var tCanvas = document.createElement("canvas");
        var tctx = tCanvas.getContext("2d");
        //如果图片大于十万像素，计算压缩比并将大小压至十万以下
        var ratio;
        if ((ratio = width * height / modal.sizeLimit) > 1) {
            ratio = Math.sqrt(ratio);
            width /= ratio;
            height /= ratio;
        } else {
            ratio = 1;
        }
        canvas.width = width;
        canvas.height = height;
        // 铺底色
        ctx.fillStyle = "#fff";
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        //如果图片像素大于五万则使用瓦片绘制
        var count;
        if ((count = width * height / 500000) > 1) {
            count = ~~(Math.sqrt(count) + 1); //计算要分成多少块瓦片
            //计算每块瓦片的宽和高
            var nw = ~~(width / count);
            var nh = ~~(height / count);
            tCanvas.width = nw;
            tCanvas.height = nh;
            for (var i = 0; i < count; i++) {
                for (var j = 0; j < count; j++) {
                    tctx.drawImage(img, i * nw * ratio, j * nh * ratio, nw * ratio, nh * ratio, 0, 0, nw, nh);
                    ctx.drawImage(tCanvas, i * nw, j * nh, nw, nh);
                }
            }
        } else {
            ctx.drawImage(img, 0, 0, width, height);
        }
        //进行最小压缩
        var ndata = canvas.toDataURL('image/jpeg', bili);
        tCanvas.width = tCanvas.height = canvas.width = canvas.height = 0;
        return ndata;
    };
    //--- 提示信息弹出框
    modal.tips = function (info) {
        $.alert(info);
    };
    //--- 加载中效果
    modal.loading = function (theThis) {
        if(!modal.state){
            var imgstr = '<span class="uploadImg_images" id="uploadImg_loading">' +
                '   <img src="/addons/weliam_merchant/app/resource/image/loading.gif">' +
                '</span>';
            theThis.append(imgstr);
        }else {
            $("#uploadImg_loading").remove();
        }
    };
    //当页面存在图片上传插件时  初始化init();
    if($(".uploadImg_content.uploadImg_main").length > 0){
        modal.init();//开始初始化
    }
    return modal
});