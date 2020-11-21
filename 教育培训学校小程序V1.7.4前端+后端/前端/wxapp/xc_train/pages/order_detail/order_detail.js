function a(a) {
    var t = setInterval(function() {
        var e = a.data.fail;
        if (e > 0) {
            e -= 1;
            var n = [ 0, 0, 0 ];
            n[0] = parseInt(e / 60 / 60), n[2] = parseInt(e % 60), n[1] = parseInt(e / 60 % 60), 
            a.setData({
                fail: e,
                times: n
            });
        } else {
            clearInterval(t);
            var s = a.data.list;
            s.status, a.setData({
                list: s
            });
        }
    }, 1e3);
}

var t = getApp(), e = require("../common/common.js");

Page({
    data: {
        times: [ 0, 0, 0 ],
        fail: 0
    },
    onLoad: function(n) {
        var s = this;
        e.config(s), e.theme(s), t.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "group",
                id: n.id
            },
            success: function(t) {
                var e = t.data;
                if ("" != e.data) {
                    if (-1 == e.data.status && parseInt(e.data.fail) > 0) {
                        var n = [ 0, 0, 0 ];
                        n[0] = parseInt(e.data.fail / 60 / 60), n[2] = parseInt(e.data.fail % 60), n[1] = parseInt(e.data.fail / 60 % 60), 
                        s.setData({
                            fail: e.data.fail,
                            times: n
                        });
                    }
                    s.setData({
                        list: e.data
                    }), a(s);
                }
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        e.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var a = this, t = "/xc_train/pages/shared/shared?&group=" + a.data.list.id;
        return t = escape(t), console.log(t), {
            title: a.data.config.title + "-团购",
            path: "/xc_train/pages/base/base?&share=" + t,
            success: function(a) {
                console.log(a);
            },
            fail: function(a) {
                console.log(a);
            }
        };
    }
});