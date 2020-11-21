var e = getApp(), o = require("../common/common.js");

Page({
    data: {},
    onLoad: function(i) {
        var n = this;
        "" != i.share_id && null != i.share_id && (e.share = i.share_id), o.login(n), wx.getSystemInfo({
            success: function(o) {
                -1 != o.system.indexOf("Android") ? e.mobile = 2 : -1 != o.system.indexOf("iOS") && (e.mobile = 1);
            }
        }), e.util.request({
            url: "entry/wxapp/index",
            data: {
                op: "base"
            },
            showLoading: !1,
            success: function(o) {
                var n = o.data;
                if ("" != n.data && ("" != n.data.config && null != n.data.config && (e.config = n.data.config), 
                "" != n.data.theme && null != n.data.theme && (e.theme = n.data.theme), "" != n.data.closed && null != n.data.closed && wx.redirectTo({
                    url: "../closed/closed"
                })), "" != e.service && null != e.service) wx.redirectTo({
                    url: "../service/detail?&id=" + e.service
                }); else if ("" != e.audio && null != e.audio) wx.redirectTo({
                    url: "../audio/detail?&id=" + e.audio
                }); else if ("" != i.share && null != i.share) {
                    var a = unescape(i.share);
                    wx.redirectTo({
                        url: a
                    });
                } else wx.redirectTo({
                    url: "../index/index"
                });
            }
        }), e.util.request({
            url: "entry/wxapp/grouprefund",
            method: "POST",
            showLoading: !1
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});