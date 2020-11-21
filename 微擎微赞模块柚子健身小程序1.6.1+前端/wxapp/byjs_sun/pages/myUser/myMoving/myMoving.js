function _defineProperty(e, t, n) {
    return t in e ? Object.defineProperty(e, t, {
        value: n,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = n, e;
}

var app = getApp();

Page({
    data: _defineProperty({
        activeIndex: 0,
        sliderOffset: 0,
        sliderLeft: 0,
        commentimgsrc: "../../../resource/images/find/icon-comment.png",
        status: 0,
        lovestatus: 0,
        loveimgsrc1: "../../../../byjs_sun/resource/images/find/icon-love.png",
        loveimgsrc2: "../../../../byjs_sun/resource/images/find/icon-love-1.png",
        lovenum: 0,
        lovenumadd1: 1,
        talent: [],
        gowith: [],
        seeall: "全文",
        hideall: "收起",
        page: 1,
        user: {}
    }, "talent", []),
    onLoad: function(e) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), t.setData({
                    url: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetMyMoving",
            data: {
                user_id: wx.getStorageSync("users").id
            },
            cachetime: 0,
            success: function(e) {
                t.setData({
                    talent: e.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetMyInfo",
            data: {
                user_id: wx.getStorageSync("users").id
            },
            cachetime: 0,
            success: function(e) {
                t.setData({
                    user: e.data
                });
            }
        });
    },
    onReady: function() {},
    seetalentimg: function(e) {
        var t = this, n = wx.getStorageSync("url"), a = e.currentTarget.dataset.f_index, i = e.currentTarget.dataset.s_index;
        if (1 == t.data.activeIndex) var o = t.data.gowith; else o = t.data.talent;
        for (var r = n + o[a].img[i], c = o[a].img, s = [], u = 0; u < c.length; u++) s[u] = n + c[u];
        wx.previewImage({
            current: r,
            urls: s
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    cut: function(e) {
        var t = this, n = e.currentTarget.dataset.id;
        wx.showModal({
            title: "提示",
            content: "确认删除?",
            success: function(e) {
                e.confirm ? app.util.request({
                    url: "entry/wxapp/CutMyMoving",
                    data: {
                        id: n
                    },
                    cachetime: 0,
                    success: function(e) {
                        t.onLoad();
                    }
                }) : e.cancel;
            }
        });
    },
    gointeractiveInfoone: function(e) {
        var t = e.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../../find/interactive/interactiveInfoone/interactiveInfoone?id=" + t
        });
    },
    lovefun: function(e) {
        var t = this, n = e.currentTarget.dataset.id, a = wx.getStorageSync("users").id, i = t.data.talent;
        1 == i.is_love ? (i.is_love = 0, i.collect_num = parseInt(i.collect_num) - 1) : (i.is_love = 1, 
        i.collect_num = parseInt(i.collect_num) + 1), app.util.request({
            url: "entry/wxapp/lovefun",
            cachetime: "0",
            data: {
                tag: 0,
                id: n,
                user_id: a
            },
            success: function(e) {
                1 == e.data ? (t.setData({
                    talent: i
                }), t.onLoad()) : wx.showToast({
                    title: "点赞失败，网络延迟！！！",
                    icon: "none"
                });
            },
            fail: function(e) {
                wx.showToast({
                    title: "点赞失败，网络延迟！！！",
                    icon: "none"
                });
            }
        });
    }
});