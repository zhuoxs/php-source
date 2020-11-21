function a(a) {
    i = setInterval(function() {
        var e = o.innerAudioContext.currentTime, n = o.innerAudioContext.duration;
        if (n >= 2 && (n -= 2), 0 != e && 0 != n) {
            var d = a.data.audio_left;
            d[0] = parseInt(parseInt(e) / 60), d[0] = t(d[0]), d[1] = parseInt(parseInt(e) % 60), 
            d[1] = t(d[1]);
            var u = a.data.audio_right;
            u[0] = parseInt(parseInt(n) / 60), u[0] = t(u[0]), u[1] = parseInt(parseInt(n) % 60), 
            u[1] = t(u[1]), d[0] == u[0] && d[1] == u[1] && 0 != parseInt(d[0]) && 0 != parseInt(d[1]) ? (clearInterval(i), 
            o.innerAudioContext.stop()) : a.setData({
                audio_left: d,
                audio_right: u,
                audio_value: e,
                audio_max: n
            });
        }
    }, 1e3);
}

function t(a) {
    return parseInt(a) < 10 ? a = "0" + a : a;
}

var i, o = getApp(), e = require("../common/common.js");

Page({
    data: {
        curr: 0,
        page: 1,
        pagesize: 20,
        isbottom: !1,
        code: "",
        audio_play: !1,
        audio_left: [ "00", "00" ],
        audio_right: [ "00", "00" ],
        audio_value: 0,
        audio_max: 0
    },
    mark: function() {
        var a = this, t = a.data.list;
        o.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "mark",
                id: a.data.list.id
            },
            success: function(i) {
                "" != i.data.data && (wx.showToast({
                    title: "操作成功"
                }), t.is_mark = -parseInt(t.is_mark), t.mark = parseInt(t.mark) + parseInt(t.is_mark), 
                a.setData({
                    list: t
                }));
            }
        });
    },
    menu_on: function() {
        this.setData({
            yin: !0
        });
    },
    yin_close: function() {
        this.setData({
            yin: !1,
            showhb: !1
        });
    },
    getcode: function() {
        var a = this;
        "" != a.data.code ? a.setData({
            showhb: !0
        }) : o.util.request({
            url: "entry/wxapp/user",
            data: {
                op: "audioCode",
                id: a.data.pid
            },
            success: function(t) {
                var i = t.data;
                "" != i.data && a.setData({
                    showhb: !0,
                    code: i.data.code
                });
            }
        });
    },
    dlimg: function() {
        var a = this;
        wx.showLoading({
            title: "保存中"
        }), wx.downloadFile({
            url: a.data.code,
            success: function(a) {
                wx.saveImageToPhotosAlbum({
                    filePath: a.tempFilePath,
                    success: function(a) {
                        wx.hideLoading(), wx.showToast({
                            title: "保存成功",
                            icon: "success",
                            duration: 2e3
                        });
                    },
                    fail: function(a) {
                        wx.hideLoading(), wx.showToast({
                            title: "保存失败",
                            icon: "success",
                            duration: 2e3
                        });
                    }
                });
            }
        });
    },
    audio_pause: function() {
        var a = this;
        1 == a.data.audio.try || 1 == a.data.list.is_buy ? (o.innerAudioContext.src != a.data.audio.src && (o.innerAudioContext.src = a.data.audio.audio, 
        o.audio_Id = a.data.pid, o.audio_on = a.data.audio, o.audio_curr = a.data.curr), 
        a.data.audio_play ? o.innerAudioContext.pause() : o.innerAudioContext.play()) : wx.showModal({
            title: "提示",
            content: "请先购买才能播放哟~",
            confirmText: "购买",
            success: function(t) {
                t.confirm ? wx.navigateTo({
                    url: "pay?id=" + a.data.pid
                }) : t.cancel;
            }
        });
    },
    audio_next: function() {
        var a = this, t = a.data.curr, i = a.data.list.audio_list;
        t + 1 >= i.length ? t = 0 : t += 1;
        var e = i[t];
        1 == e.try || 1 == a.data.list.is_buy ? (a.setData({
            audio: e,
            id: e.id,
            curr: t
        }), o.audio_Id = a.data.pid, o.audio_on = a.data.audio, o.innerAudioContext.paused || o.innerAudioContext.stop(), 
        o.innerAudioContext.src = e.audio, o.audio_curr = a.data.curr, o.innerAudioContext.play()) : wx.showModal({
            title: "提示",
            content: "请先购买才能播放哟~",
            confirmText: "购买",
            success: function(t) {
                t.confirm ? wx.navigateTo({
                    url: "pay?id=" + a.data.pid
                }) : t.cancel;
            }
        });
    },
    audio_perv: function() {
        var a = this, t = a.data.curr, i = a.data.list.audio_list;
        0 == t ? t = i.length - 1 : t -= 1;
        var e = i[t];
        1 == e.try || 1 == a.data.list.is_buy ? (a.setData({
            audio: e,
            id: e.id,
            curr: t
        }), o.audio_Id = a.data.pid, o.audio_on = a.data.audio, o.audio_curr = a.data.curr, 
        o.innerAudioContext.paused || o.innerAudioContext.stop(), o.innerAudioContext.src = e.audio, 
        o.innerAudioContext.play()) : wx.showModal({
            title: "提示",
            content: "请先购买才能播放哟~",
            confirmText: "购买",
            success: function(t) {
                t.confirm ? wx.navigateTo({
                    url: "pay?id=" + a.data.pid
                }) : t.cancel;
            }
        });
    },
    audio_choose: function(a) {
        var t = this, i = a.currentTarget.dataset.index;
        if (i != t.data.curr) {
            var e = t.data.list.audio_list[i];
            1 == e.try || 1 == t.data.list.is_buy ? (t.setData({
                audio: e,
                id: e.id,
                curr: i,
                yin: !1
            }), o.audio_Id = t.data.pid, o.audio_on = t.data.audio, o.audio_curr = t.data.curr, 
            o.innerAudioContext.paused || o.innerAudioContext.stop(), o.innerAudioContext.src = e.audio, 
            o.innerAudioContext.play()) : wx.showModal({
                title: "提示",
                content: "请先购买才能播放哟~",
                confirmText: "购买",
                success: function(a) {
                    a.confirm ? wx.navigateTo({
                        url: "pay?id=" + t.data.pid
                    }) : a.cancel;
                }
            });
        } else t.setData({
            yin: !1
        });
    },
    sliderchange: function(a) {
        0 != this.data.audio_max && (clearInterval(i), o.innerAudioContext.seek(a.detail.value));
    },
    onLoad: function(a) {
        var t = this;
        e.config(t), e.theme(t), t.setData({
            id: a.id,
            pid: a.pid
        }), o.util.request({
            url: "entry/wxapp/order",
            showLoading: !1,
            data: {
                op: "discuss",
                page: t.data.page,
                pagesize: t.data.pagesize,
                id: t.data.pid,
                type: 3
            },
            success: function(a) {
                var i = a.data;
                "" != i.data ? t.setData({
                    tui: i.data,
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
        o.util.request({
            url: "entry/wxapp/service",
            data: {
                op: "audio_item",
                id: t.data.id
            },
            success: function(a) {
                var i = a.data;
                "" != i.data && t.setData({
                    audio: i.data,
                    list: i.data.list,
                    curr: i.data.curr
                });
            }
        }), o.innerAudioContext.onPlay(function() {
            clearInterval(i), a(t), t.setData({
                audio_play: !0
            }), o.audio_status = !0;
        }), o.innerAudioContext.onError(function(a) {
            console.log(a.errMsg), console.log(a.errCode);
        }), o.innerAudioContext.onPause(function() {
            clearInterval(i), t.setData({
                audio_play: !1
            }), o.audio_status = !1;
        }), o.innerAudioContext.onStop(function() {
            clearInterval(i), t.setData({
                audio_play: !1,
                audio_left: [ "00", "00" ],
                audio_value: 0
            }), o.audio_status = !1;
        }), o.innerAudioContext.onSeeked(function() {
            a(t);
        }), "" != o.innerAudioContext.src && null != o.innerAudioContext.src && "" != o.audio_Id && null != o.audio_Id && o.audio_Id == t.data.pid && o.audio_on.id == t.data.id && (o.innerAudioContext.paused ? t.setData({
            audio_play: !1
        }) : t.setData({
            audio_play: !0
        }), clearInterval(i), a(t));
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onReachBottom: function() {
        var a = this;
        a.data.isbottom || o.util.request({
            url: "entry/wxapp/order",
            data: {
                op: "discuss",
                page: a.data.page,
                pagesize: a.data.pagesize,
                id: a.data.pid,
                type: 3
            },
            success: function(t) {
                var i = t.data;
                "" != i.data ? a.setData({
                    tui: a.data.tui.concat(i.data),
                    page: a.data.page + 1
                }) : a.setData({
                    isbottom: !0
                });
            }
        });
    },
    onShareAppMessage: function() {
        var a = this, t = "/xc_train/pages/audio/audio?&id=" + a.data.id + "&pid=" + a.data.pid;
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