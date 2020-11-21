var app = getApp(), Toast = require("../../libs/zanui/toast/toast");

Page({
    data: {},
    onLoad: function(a) {
        var t = this, e = wx.getStorageSync("loading_img");
        if (e ? t.setData({
            loadingImg: e
        }) : t.setData({
            loadingImg: "../../libs/images/loading.gif"
        }), a.id && (t.setData({
            inner: !0
        }), t.getNoticeDetail(a.id)), a.path) {
            var o = decodeURIComponent(a.path);
            t.setData({
                inner: !1,
                pageUrl: o,
                completed: !0
            });
        }
    },
    getNoticeDetail: function(a) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/notice",
            cachetime: "0",
            data: {
                id: a,
                m: "superman_hand2"
            },
            success: function(a) {
                a.data.errno ? t.showIconToast(a.data.errmsg) : t.setData({
                    detail: a.data.data,
                    completed: !0
                });
            },
            fail: function(a) {
                t.setData({
                    completed: !0
                }), t.showIconToast(a.data.errmsg);
            }
        });
    },
    showIconToast: function(a) {
        var t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "fail";
        Toast({
            type: t,
            message: a,
            selector: "#zan-toast"
        });
    }
});