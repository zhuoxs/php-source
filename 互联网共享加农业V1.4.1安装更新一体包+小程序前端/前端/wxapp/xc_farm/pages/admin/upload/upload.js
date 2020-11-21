var common = require("../../common/common.js"), app = getApp();

function getUrlParam(t, e) {
    var a = new RegExp("(^|&)" + e + "=([^&]*)(&|$)"), n = t.split("?")[1].match(a);
    return null != n ? unescape(n[2]) : null;
}

Page({
    data: {
        type: 1,
        img: ""
    },
    upload: function(t) {
        var a = this, n = "entry/wxapp/upload";
        -1 == n.indexOf("http://") && -1 == n.indexOf("https://") && (n = app.util.url(n));
        var e = wx.getStorageSync("userInfo").sessionid;
        !getUrlParam(n, "state") && e && (n = n + "&state=we7sid-" + e), n = n + "&state=we7sid-" + e;
        var o = getCurrentPages();
        o.length && (o = o[getCurrentPages().length - 1]) && o.__route__ && (n = n + "&m=" + o.__route__.split("/")[0]), 
        wx.chooseImage({
            count: 1,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(t) {
                var e = t.tempFilePaths[0];
                wx.uploadFile({
                    url: n,
                    filePath: e,
                    name: "file",
                    formData: {
                        user: "test"
                    },
                    success: function(t) {
                        a.setData({
                            img: t.data
                        });
                    }
                });
            }
        });
    },
    submit: function() {
        var t = this;
        if ("" != t.data.img && null != t.data.img) {
            var e = {
                op: "upload",
                img: t.data.img,
                name: t.data.name
            };
            app.util.request({
                url: "entry/wxapp/manage",
                method: "POST",
                data: e,
                success: function(t) {
                    "" != t.data.data && wx.showToast({
                        title: "提交成功",
                        icon: "success",
                        duration: 2e3
                    });
                }
            });
        } else wx.showModal({
            title: "错误",
            content: "请上传图片"
        });
    },
    onLoad: function(t) {
        common.config(this, "admin2"), this.setData({
            type: t.type,
            name: t.name
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});