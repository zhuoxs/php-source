var common = require("../common/common.js"), app = getApp();

function getUrlParam(e, t) {
    var a = new RegExp("(^|&)" + t + "=([^&]*)(&|$)"), r = e.split("?")[1].match(a);
    return null != r ? unescape(r[2]) : null;
}

Page({
    data: {
        files: []
    },
    chooseImage: function(e) {
        var r = this, s = "entry/wxapp/upload";
        -1 == s.indexOf("http://") && -1 == s.indexOf("https://") && (s = app.util.url(s));
        var t = wx.getStorageSync("userInfo").sessionid;
        !getUrlParam(s, "state") && t && (s = s + "&state=we7sid-" + t), s = s + "&state=we7sid-" + t;
        var a = getCurrentPages();
        a.length && (a = a[getCurrentPages().length - 1]) && a.__route__ && (s = s + "&m=" + a.__route__.split("/")[0]), 
        wx.chooseImage({
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                for (var t = e.tempFilePaths, a = 0; a < t.length; a++) wx.uploadFile({
                    url: s,
                    filePath: t[a],
                    name: "file",
                    formData: {
                        user: "test"
                    },
                    success: function(e) {
                        var t = r.data.files;
                        t.push(e.data), r.setData({
                            files: t
                        });
                    }
                });
            }
        });
    },
    previewImage: function(e) {
        wx.previewImage({
            current: e.currentTarget.id,
            urls: this.data.files
        });
    },
    backbtn: function() {
        wx.navigateBack({
            delta: 1
        });
    },
    submmit: function(e) {
        var t = this, a = e.detail.value.content;
        if ("" != a && null != a) {
            var r = {
                op: "discuss",
                content: a,
                order: t.data.list.id
            }, s = t.data.list;
            4 == s.order_type ? r.type = 4 : r.type = 1, 3 == s.order_status ? ("" != s.service && null != s.service && 0 != s.service ? r.id = s.service : r.id = s.services[0].pid, 
            0 < t.data.files.length && (r.bimg = JSON.stringify(t.data.files)), app.util.request({
                url: "entry/wxapp/index",
                method: "POST",
                data: r,
                success: function(e) {
                    "" != e.data.data && (wx.showToast({
                        title: "评论成功",
                        icon: "success",
                        duration: 2e3
                    }), setTimeout(function() {
                        4 == s.order_type ? wx.reLaunch({
                            url: "../pin_order/index"
                        }) : wx.reLaunch({
                            url: "../order/order"
                        });
                    }, 2e3));
                }
            })) : wx.showModal({
                title: "错误",
                content: "已评价"
            });
        } else wx.showModal({
            title: "错误",
            content: "请输入内容"
        });
    },
    onLoad: function(e) {
        var a = this;
        common.config(a), app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "order_detail",
                id: e.id
            },
            success: function(e) {
                var t = e.data;
                "" != t.data && a.setData({
                    list: t.data
                });
            }
        });
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    }
});