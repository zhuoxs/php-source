var app = getApp();

Page({
    data: {
        upload_picture_list: []
    },
    uploadpic: function(a) {
        var s = this, l = s.data.upload_picture_list;
        function p(t, s, l) {
            var a = t.data.uniacid;
            console.log("开始上传" + l + "图片到服务器："), console.log(s[l]), wx.uploadFile({
                url: t.data.url + "app/index.php?i=" + a + "&c=entry&a=wxapp&do=msg_send_imgs&m=hyb_yl",
                filePath: s[l].path,
                name: "file",
                formData: {
                    path: "wxchat"
                },
                success: function(a) {
                    console.log(a);
                    var e = a.data;
                    if (console.log(e), 1 == e.success) {
                        var o = t.data.url + e.SaveName;
                        s[l].path_server = o;
                    }
                    t.setData({
                        upload_picture_list: s
                    }), console.log("图片上传" + l + "到服务器完成："), console.log(s[l]);
                }
            }).onProgressUpdate(function(a) {
                s[l].upload_percent = a.progress, console.log("第" + l + "个图片上传进度：" + s[l].upload_percent), 
                console.log(s), t.setData({
                    upload_picture_list: s
                });
            });
        }
        wx.chooseImage({
            count: 8,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(a) {
                var e = a.tempFiles;
                for (var o in e) e[o].upload_percent = 0, e[o].path_server = "", l.push(e[o]);
                for (var t in s.setData({
                    upload_picture_list: l
                }), l) 0 == l[t].upload_percent && p(s, l, t);
            }
        });
    },
    onLoad: function() {
        var e = this;
        app.siteInfo.uniacid;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(a) {
                console.log(a), e.setData({
                    url: a.data
                });
            }
        });
    }
});