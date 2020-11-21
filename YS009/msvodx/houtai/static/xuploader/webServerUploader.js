/**
 webServer上传用js
 @Author:   Dreamer
 @LastData: 2017/11/24
 @Version:  v1.0.8
 */

/**
 * 根据文件类型获取当前配置信息
 * @param fileType
 * @returns {*}
 */
function getParamsByFileType(fileType,fileName) {
    var returnData = null;
    $.ajax({
        url: '/admin.php/admin/Uploader/createUploader.html',
        type: 'POST',
        dataType: "JSON",
        async: false,
        data: {fileType: fileType,fileName:fileName},
        success: function (resp) {
            returnData = resp;
        }
    });

    return returnData;
}


/***
 * 创建上传对象
 * @param choseFileBtn  点击触发选择文件的元素id
 * @param postUrl       上传文件的接收端URL
 * @param fileName      指定的文件名称
 * @param fileType      文件类型： image / video / ico
 * @param callBack      回调函数
 * @param isMulit       是否是多文件上传
 * @param afterChoseCallBack    选择文件后回调
 */
function createWebUploader(choseFileBtn, beginBtn, fileName, fileType, callBack, isMulit, afterChoseCallBack) {
    var upParams = getParamsByFileType(fileType);
    var curFullName = '';
    var isMulit = isMulit || false;

    //if (beginBtn == '') beginBtn = choseFileBtn;

    if (!upParams) {
        console.error('获取上传服务器参数发生异常.');
        //layer.msg('获取上传服务器参数发生异常.');
    }
    var postUrl = upParams.data.post_url;   //公共上传属性,post提交地址

    var fileTypeData = null;
    switch (fileType) {
        case 'image':
            fileTypeData = {title: "图片文件", extensions: "jpg,gif,png"};
            break;
        case 'video':
            fileTypeData = {title: "视频文件", extensions: 'rmvb,flv,mp4,mov,3gp,wmv,mp3,avi,mpeg'};
            break;
        case 'ico':
            fileTypeData = {title: "像素图标", extensions: 'ico'};
            break;
    }

    if (fileTypeData == null) console.log('上传文件类型错误.');

    var params = {'newFileName': fileName || randomStr(20)};
    if (fileType == 'ico') {
        params.isFavicon = 1;
        params.newFileName = 'favicon';
    }

    //clear yunzhuanma upload button
    if (upParams.data.serverType == 'yunzhuanma') {
        //console.log('yunzhuanma');
        document.getElementById('yzm_panel').style.display = 'inline-block';
        document.getElementById(choseFileBtn).style.display = ''
    }

    //阿里云OSS上传参数
   // if (upParams.data.serverType == 'aliyunoss') {
        for (attr in upParams.data) {
            params[attr] = upParams.data[attr];
        }
   // }

    var uploader = new plupload.Uploader({
        runtimes: 'html5,flash,silverlight,html4',
        browse_button: choseFileBtn,
        //container: document.getElementById('container'),
        //drop_element:document.getElementById('container'),

        url: postUrl,
        flash_swf_url: '/static/plupload-2.3.6/js/Moxie.swf',
        silverlight_xap_url: '/static/plupload-2.3.6/js/Moxie.xap',
        chunk_size: '2mb',
        unique_names: true,
        max_retries: 2,
        multi_selection: isMulit,
        prevent_duplicates: true, //不允许选取重复文件

        multipart_params: params,

        filters: {
            max_file_size: '1000mb',
            mime_types: [fileTypeData]
        },

        init: {
            PostInit: function () {
                if (beginBtn != '') {
                    document.getElementById(beginBtn).onclick = function () {
                        uploader.start();
                        return false;
                    };
                }
            },

            FilesAdded: function (up, files) {

                if (!afterChoseCallBack) {

                    $('#' + choseFileBtn).html('<span id="' + files[0].id + '">' + files[0].name + ' (' + plupload.formatSize(files[0].size) + ') <b></b></span>');

                } else {
                    var _tmp={'fileCount':up.files.length,'fileList':up.files};
                    afterChoseCallBack(_tmp);

                }


                /*plupload.each(files, function (file) {
                    document.getElementById(choseFileBtn).appendChild('<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>')
                });*/

                if (beginBtn === '') {
                    layer.msg('开始上传……', {time: 500});
                    up.start();
                }

            },

            BeforeUpload: function (up, file) {
                if (fileName == '') {
                    //console.log('未指定文件名');
                    params.newFileName = randomStr();
                }

                if (upParams.data.serverType == 'aliyunoss') {
                    //console.log('****************aliyunoss*****************');
                    params.key = upParams.data.key + randomStr() + getSuffix(file.name);
                    up.setOption({chunk_size: 0});  //兼容性,保障设置生效 @dreamer
                    up.settings.chunk_size=0;   //兼容性,保障设置生效 @dreamer
                }

                if(upParams.data.serverType=='qiniuyun'){
                    //console.log('****************qiniuyun*****************');
                    var _tmp=getParamsByFileType(fileType);
                    params.key=_tmp.data.key+ getSuffix(file.name);
                    up.setOption({chunk_size: 0});  //兼容性,保障设置生效 @dreamer
                    up.settings.chunk_size=0;   //兼容性,保障设置生效 @dreamer
                }

                up.setOption({"multipart_params": params});
                curFullName = params.key;
            },

            UploadProgress: function (up, file) {
                if (!isMulit) {
                    document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
                } else {
                    //console.log(file.percent + "%");
                }
            },

            Error: function (up, err) {
                layer.msg(err.message);
            },

            FileUploaded: function (uploader, file, responseObject) {
                var returnData = null;
                switch (upParams.data.serverType) {
                    case 'aliyunoss':
                        returnData = {filePath: upParams.data.post_url + "/" + curFullName};
                        break;
                    case 'web_server':
                        //console.log(responseObject.response);
                        returnData = JSON.parse(responseObject.response);
                        break;
                    case 'qiniuyun':
                        returnData = {filePath: upParams.data.resource_domain + "/" + curFullName};
                        break;
                }
                callBack(returnData);
            }
        }
    });

    uploader.init();
}

/**
 * 获取文件扩展名
 * @param filename
 * @returns {string}
 */
function getSuffix(filename) {
    pos = filename.lastIndexOf('.')
    suffix = ''
    if (pos != -1) {
        suffix = filename.substring(pos)
    }
    return suffix;
}

/**
 * 生成指定长度的字符串
 * @param len
 * @returns {string}
 */
function randomStr(len) {
    len = len || 32;
    var chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';
    var maxPos = chars.length;
    var str = '';
    for (i = 0; i < len; i++) {
        str += chars.charAt(Math.floor(Math.random() * maxPos));
    }
    return str;
}