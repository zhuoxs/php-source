function a(a, s) {
    a.scratch = new t.default(a, {
        canvasWidth: n,
        canvasHeight: o,
        imageResource: a.data.list.gua_img,
        maskColor: a.data.caColor,
        r: 8,
        awardTxtStyle: a.data.awTxtStyle,
        awardTxt: a.data.awTxt,
        awardTxtColor: a.data.awTxtColor,
        awardTxtFontSize: a.data.awTxtFontSize,
        awardImage: s,
        callback: function() {
            e.util.request({
                url: "entry/wxapp/user",
                data: {
                    op: "active_status",
                    id: a.data.list.id
                },
                success: function(a) {
                    var t = a.data;
                    "" != t.data && wx.showModal({
                        title: "恭喜",
                        content: "您中奖了,奖品是" + t.data.name,
                        showCancel: !1
                    });
                }
            });
        }
    }), a.scratch.start();
}

var t = function(a) {
    return a && a.__esModule ? a : {
        default: a
    };
}(require("../../../components/scratch/scratch.js")), e = getApp(), s = require("../common/common.js"), i = 320, n = 0, o = 0;

Page({
    data: {
        awImage: "",
        awTxtStyle: "img"
    },
    menu_close: function() {
        var a = this;
        a.setData({
            menu: !1,
            shadow: !1
        }), e.util.request({
            url: "entry/wxapp/user",
            data: {
                op: "active_detail",
                id: a.data.list.id
            },
            success: function(t) {
                var s = t.data;
                "" != s.data && a.setData({
                    list: s.data,
                    userinfo: e.userinfo
                });
            }
        });
    },
    onLoad: function(t) {
        var r = this;
        s.config(r), s.theme(r), e.util.request({
            url: "entry/wxapp/user",
            data: {
                op: "active_detail",
                id: t.id
            },
            success: function(t) {
                var s = t.data;
                "" != s.data && (r.setData({
                    list: s.data,
                    userinfo: e.userinfo
                }), "" != s.data.prize_bimg && null != s.data.prize_bimg && a(r, s.data.prize_bimg));
            }
        }), wx.showShareMenu({
            withShareTicket: !0
        }), "undefined" != e.shareTicket && "" != t.openid && null != t.openid && null != t.share && "" != t.share && null != e.shareTicket && "" != e.shareTicket && wx.getShareInfo({
            shareTicket: e.shareTicket,
            success: function(a) {
                var s = a;
                s.id = t.id, s.share = t.share, s.openid = t.openid, e.util.request({
                    url: "entry/wxapp/prize",
                    data: s,
                    success: function(a) {
                        "" != a.data.data && wx.showToast({
                            title: "助力成功",
                            icon: "success",
                            duration: 2e3
                        });
                    }
                });
            }
        }), wx.getSystemInfo({
            success: function(a) {
                i = a.windowWidth, n = parseInt(700 / 750 * i), o = parseInt(275 / 750 * i);
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        s.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var a = this;
        e.util.request({
            url: "entry/wxapp/user",
            data: {
                op: "active_detail",
                id: a.data.list.id
            },
            success: function(t) {
                var s = t.data;
                "" != s.data && (wx.stopPullDownRefresh(), a.setData({
                    list: s.data,
                    userinfo: e.userinfo
                }));
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function(t) {
        var s = this, i = "";
        "button" === t.from && (console.log(t.target), i = t.target.dataset.index);
        var n = "/xc_train/pages/active/active?&id=" + s.data.list.id;
        return 2 == parseInt(s.data.list.share_type) && (n = n + "&share=" + i + "&openid=" + s.data.userinfo.openid), 
        n = escape(n), {
            title: s.data.list.name,
            path: "/xc_train/pages/base/base?&share=" + n,
            success: function(t) {
                console.log(1111), 2 == parseInt(s.data.list.share_type) ? console.log(n) : 1 == parseInt(s.data.list.share_type) && "" != t.shareTickets && null != t.shareTickets && "" != i && null != i && wx.getShareInfo({
                    shareTicket: t.shareTickets[0],
                    success: function(t) {
                        var n = t;
                        n.id = s.data.list.id, n.share = i, e.util.request({
                            url: "entry/wxapp/prize",
                            data: n,
                            success: function(t) {
                                var e = t.data;
                                if ("" != e.data) if (1 == e.data.status) wx.showToast({
                                    title: "分享成功",
                                    icon: "success",
                                    duration: 2e3
                                }), (i = s.data.list).you_xiao = parseInt(i.you_xiao) + 1, i.opengid = e.data.opengid, 
                                s.setData({
                                    list: i
                                }), "" != e.data.bimg && null != e.data.bimg && a(s, e.data.bimg); else if (2 == e.data.status) {
                                    var i = s.data.list;
                                    i.opengid = e.data.opengid, i.you_xiao = parseInt(i.you_xiao) + 1, s.setData({
                                        list: i,
                                        menu: !0,
                                        shadow: !0
                                    });
                                }
                            }
                        });
                    }
                });
            },
            fail: function(a) {}
        };
    }
});