function a(a) {
    e = setInterval(function() {
        var n = i.innerAudioContext.currentTime, o = i.innerAudioContext.duration;
        o >= 2 && (o -= 2);
        var d = a.data.audio_left;
        d[0] = parseInt(parseInt(n) / 60), d[0] = t(d[0]), d[1] = parseInt(parseInt(n) % 60), 
        d[1] = t(d[1]);
        var s = a.data.audio_right;
        s[0] = parseInt(parseInt(o) / 60), s[0] = t(s[0]), s[1] = parseInt(parseInt(o) % 60), 
        s[1] = t(s[1]), d[0] == s[0] && d[1] == s[1] && 0 != parseInt(d[0]) && 0 != parseInt(d[1]) ? (clearInterval(e), 
        i.innerAudioContext.stop()) : a.setData({
            audio_left: d,
            audio_right: s
        });
    }, 1e3);
}

function t(a) {
    return parseInt(a) < 10 ? a = "0" + a : a;
}

var e, i = getApp(), n = require("../common/common.js"), o = require("../../../wxParse/wxParse.js");

Page({
    data: {
        curr: 1,
        page: 1,
        pagesize: 20,
        isbottom: !1,
        audio_status: !1,
        audio_play: !1,
        audio_left: [ "00", "00" ],
        audio_right: [ "00", "00" ]
    },
    tab: function(a) {
        var t = this, e = a.currentTarget.dataset.index;
        e != t.data.curr && t.setData({
            curr: e
        });
    },
    input: function(a) {
        this.setData({
            value: a.detail.value
        });
    },
    discuss_on: function(a) {
        var t = this, e = t.data.value;
        "" != e && null != e ? i.util.request({
            url: "entry/wxapp/order",
            data: {
                op: "discuss_on",
                id: t.data.id,
                content: e,
                type: 3
            },
            success: function(a) {
                if ("" != a.data.data) {
                    wx.showToast({
                        title: "评论成功",
                        icon: "success",
                        duration: 2e3
                    }), t.setData({
                        page: 1,
                        isbottom: !1,
                        value: ""
                    });
                    var e = t.data.list;
                    e.discuss_num = parseInt(e.discuss_num) + 1, t.setData({
                        list: e
                    }), i.util.request({
                        url: "entry/wxapp/order",
                        data: {
                            op: "discuss",
                            page: t.data.page,
                            pagesize: t.data.pagesize,
                            id: t.data.id,
                            type: 3
                        },
                        success: function(a) {
                            var e = a.data;
                            "" != e.data ? t.setData({
                                tui: e.data,
                                page: t.data.page + 1
                            }) : t.setData({
                                isbottom: !0
                            });
                        }
                    });
                }
            }
        }) : wx.showModal({
            title: "错误",
            content: "请输入评论内容",
            showCancel: !1
        });
    },
    audio_buy: function() {
        var a = this;
        wx.navigateTo({
            url: "pay?id=" + a.data.id
        });
    },
    audio_play: function(a) {
        var t = this, e = t.data.list.audio_list, n = a.currentTarget.dataset.index;
        i.audio_Id = t.data.id, i.audio_on = e[n], i.audio_curr = n, i.innerAudioContext.src = e[n].audio, 
        i.innerAudioContext.play(), t.setData({
            audio_on: e[n],
            audio_curr: n
        });
    },
    audio_pause: function() {
        this.data.audio_play ? i.innerAudioContext.pause() : i.innerAudioContext.play();
    },
    audio_prev: function() {
        var a = this, t = a.data.list.audio_list, e = a.data.audio_curr;
        e + 1 >= t.length ? e = 0 : e += 1, 1 == t[e].try || 1 == a.data.list.is_buy ? (i.innerAudioContext.src = t[e].audio, 
        i.innerAudioContext.play(), a.setData({
            audio_on: t[e],
            audio_curr: e
        })) : wx.showModal({
            title: "提示",
            content: "请先购买才能播放哟~",
            confirmText: "购买",
            success: function(t) {
                t.confirm ? wx.navigateTo({
                    url: "pay?id=" + a.data.id
                }) : t.cancel;
            }
        });
    },
    onLoad: function(a) {
        var t = this;
        n.config(t), n.theme(t), t.setData({
            id: a.id
        }), i.util.request({
            url: "entry/wxapp/order",
            showLoading: !1,
            data: {
                op: "discuss",
                page: t.data.page,
                pagesize: t.data.pagesize,
                id: t.data.id,
                type: 3
            },
            success: function(a) {
                var e = a.data;
                "" != e.data ? t.setData({
                    tui: e.data,
                    page: t.data.page + 1
                }) : t.setData({
                    isbottom: !0
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this;
        i.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "audio_detail",
                id: t.data.id
            },
            success: function(a) {
                var e = a.data;
                if ("" != e.data && (t.setData({
                    list: e.data,
                    content: ""
                }), "" != e.data.content && null != e.data.content)) {
                    var i = e.data.content;
                    o.wxParse("content", "html", i, t, 5);
                }
            }
        }), i.innerAudioContext.onPlay(function() {
            clearInterval(e), a(t), t.setData({
                audio_status: !0,
                audio_play: !0
            }), i.audio_status = !0;
        }), i.innerAudioContext.onError(function(a) {
            console.log(a.errMsg), console.log(a.errCode);
        }), i.innerAudioContext.onPause(function() {
            clearInterval(e), t.setData({
                audio_play: !1
            }), i.audio_status = !1;
        }), i.innerAudioContext.onStop(function() {
            clearInterval(e), t.setData({
                audio_play: !1,
                audio_left: [ "00", "00" ]
            }), i.audio_status = !1;
        }), "" != i.innerAudioContext.src && null != i.innerAudioContext.src && "" != i.audio_Id && null != i.audio_Id && i.audio_Id == t.data.id ? (i.innerAudioContext.paused ? t.setData({
            audio_play: !1
        }) : t.setData({
            audio_play: !0
        }), t.setData({
            audio_status: !0,
            audio_on: i.audio_on,
            audio_curr: i.audio_curr
        }), clearInterval(e), a(t)) : t.setData({
            audio_status: !1
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var a = this;
        i.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "audio_detail",
                id: a.data.id
            },
            success: function(t) {
                var e = t.data;
                if (wx.stopPullDownRefresh(), "" != e.data && (a.setData({
                    list: e.data,
                    content: ""
                }), "" != e.data.content && null != e.data.content)) {
                    var i = e.data.content;
                    o.wxParse("content", "html", i, a, 5);
                }
            }
        });
    },
    onReachBottom: function() {
        var a = this;
        3 != a.data.curr || a.data.isbottom || i.util.request({
            url: "entry/wxapp/order",
            data: {
                op: "discuss",
                page: a.data.page,
                pagesize: a.data.pagesize,
                id: a.data.id,
                type: 3
            },
            success: function(t) {
                var e = t.data;
                "" != e.data ? a.setData({
                    tui: a.data.tui.concat(e.data),
                    page: a.data.page + 1
                }) : a.setData({
                    isbottom: !0
                });
            }
        });
    },
    onShareAppMessage: function() {
        var a = this, t = "/xc_train/pages/audio/detail?&id=" + a.data.id;
        return t = escape(t), {
            title: a.data.config.title + "-" + a.data.list.name,
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