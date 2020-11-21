var common = require("../common/common.js"), app = getApp();

function time_up(s) {
    var i = setInterval(function() {
        var a = s.data.fail;
        if (0 < a) {
            a -= 1;
            var t = [ 0, 0, 0 ];
            t[0] = parseInt(a / 60 / 60), t[2] = parseInt(a % 60), t[1] = parseInt(a / 60 % 60), 
            s.setData({
                fail: a,
                times: t
            });
        } else {
            clearInterval(i);
            var e = s.data.list;
            e.status, s.setData({
                list: e
            });
        }
    }, 1e3);
}

Page({
    data: {
        times: [ 0, 0, 0 ],
        fail: 0
    },
    onLoad: function(a) {
        var s = this;
        common.config(s), s.setData({
            id: a.id
        }), app.util.request({
            url: "entry/wxapp/order",
            method: "POST",
            data: {
                op: "group",
                id: a.id
            },
            success: function(a) {
                var t = a.data;
                if ("" != t.data) {
                    if (-1 == t.data.status && 0 < parseInt(t.data.fail)) {
                        var e = [ 0, 0, 0 ];
                        e[0] = parseInt(t.data.fail / 60 / 60), e[2] = parseInt(t.data.fail % 60), e[1] = parseInt(t.data.fail / 60 % 60), 
                        s.setData({
                            fail: t.data.fail,
                            times: e
                        });
                    }
                    s.setData({
                        list: t.data
                    }), time_up(s);
                }
            }
        });
    },
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onShareAppMessage: function(a) {
        var t = this;
        return "button" === a.from && console.log(a.target), {
            title: t.data.list.service_list.name,
            path: "/xc_farm/pages/shared/shared?&group=" + t.data.list.id,
            imageUrl: t.data.list.service_list.simg,
            success: function(a) {},
            fail: function(a) {}
        };
    }
});