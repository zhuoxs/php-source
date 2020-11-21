var t = getApp(), a = require("../../../wxParse/wxParse.js"), e = require("../common/common.js");

Page({
    data: {},
    zan: function(a) {
        var e = this, s = a.currentTarget.dataset.index, i = !0;
        1 == s ? 1 == e.data.list.is_student && (i = !1) : 2 == s && 1 == e.data.list.is_zan && (i = !1), 
        i && t.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "zan",
                id: e.data.list.id,
                status: s
            },
            success: function(a) {
                if ("" != a.data.data) {
                    wx.showToast({
                        title: "操作成功",
                        icon: "success",
                        duration: 2e3
                    });
                    var i = e.data.list;
                    if (1 == s) {
                        var n = {
                            avatar: t.userinfo.avatar
                        };
                        i.member.unshift(n), i.is_student = 1;
                    } else 2 == s && (i.is_zan = 1);
                    e.setData({
                        list: i
                    });
                }
            }
        });
    },
    onLoad: function(s) {
        var i = this;
        e.config(i), e.theme(i), t.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "teacher_detail",
                id: s.id
            },
            success: function(t) {
                var e = t.data;
                if ("" != e.data && (i.setData({
                    list: e.data
                }), 2 == e.data.content_type)) {
                    var s = e.data.content2;
                    a.wxParse("content", "html", s, i, 5);
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
        var a = this;
        t.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "teacher_detail",
                id: a.data.list.id
            },
            success: function(t) {
                wx.stopPullDownRefresh();
                var e = t.data;
                "" != e.data && a.setData({
                    list: e.data
                });
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var t = this, a = "/xc_train/pages/teacher/detail?&id=" + t.data.list.id;
        return a = escape(a), {
            title: t.data.config.title + "-" + t.data.list.name,
            path: "/xc_train/pages/base/base?&share=" + a,
            success: function(t) {
                console.log(t);
            },
            fail: function(t) {
                console.log(t);
            }
        };
    }
});