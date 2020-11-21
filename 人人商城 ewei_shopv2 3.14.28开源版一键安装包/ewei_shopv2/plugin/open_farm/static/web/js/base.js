/**
 * 人人农场
 * 中禾大数据科技（青岛）有限公司
 * 公共方法
 * @author 葛兴枫
 */

/**
 * 验证数据
 * @param parameter
 * @param message
 * @returns {boolean}
 */
function checkInfo(parameter, message) {
    for (var key in message) {
        if (parameter[key] === '') {
            alert(message[key]);
            return false;
        }
    }
    return true;
}

/**
 * 复制url
 */
$('.js-clip').each(function () {
    util.clip(this, $(this).attr('data-url'));
});

/**
 * 图片上传插件展示图片
 * @param elm
 * @param opts
 * @param options
 */
function showImageDialog(elm, opts, options) {
    require(["util"], function (util) {
        var btn = $(elm);
        var ipt = btn.parent().prev();
        var val = ipt.val();
        var img = ipt.parent().next().children();
        options = {'global': false, 'class_extra': '', 'direct': true, 'multiple': false, 'fileSizeLimit': 5120000};
        util.image(val, function (url) {
            if (url.url) {
                if (img.length > 0) {
                    img.get(0).src = url.url;
                }
                ipt.val(url.attachment);
                ipt.attr("filename", url.filename);
                ipt.attr("url", url.url);
            }
            if (url.media_id) {
                if (img.length > 0) {
                    img.get(0).src = "";
                }
                ipt.val(url.media_id);
            }
        }, options);
    });
}

/**
 * 图片上传插件删除图片
 * @param elm
 */
function deleteImage(elm) {
    $(elm).prev().attr("src", "./resource/images/nopic.jpg");
    $(elm).parent().prev().find("input").val("");
}

/**
 * 转换时间字符串变成 JS DATE 对象
 * @param strTime
 * @returns {*}
 */
function parseToDate(strTime) {
    var arr = strTime.split(" ");
    if (arr.length >= 2) {
        var arr1 = arr[0].split("-");
        var arr2 = arr[1].split(":");
    } else
        return null;
    if (arr1.length >= 3 && arr2.length >= 3) {
        //将字符串转换为date类型
        return new Date(arr1[0], arr1[1], arr1[2], arr2[0], arr2[1], arr2[2]);
    } else{
        return null;
    }
}

/**
 * 上传多张照片
 * @param elm
 */
function uploadMultiImage(elm) {
    var name = $(elm).next().val();
    util.image( "", function(urls){
        $.each(urls, function(idx, url){
            $(elm).parent().parent().next().append('<div class="multi-item"><img onerror="this.src=\'./resource/images/nopic.jpg\'; this.title=\'图片未找到.\'" src="'+url.url+'" class="img-responsive img-thumbnail"><input type="hidden" name="'+name+'[]" value="'+url.attachment+'"><em class="close" title="删除这张图片" onclick="deleteMultiImage(this)">×</em></div>');
        });
    }, {"multiple":true,"direct":false,"fileSizeLimit":5120000});
}
function deleteMultiImage(elm){
    $(elm).parent().remove();
}