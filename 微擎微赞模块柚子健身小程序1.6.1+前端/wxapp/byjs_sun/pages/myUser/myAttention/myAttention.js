var _data;

function _defineProperty(t, e, n) {
    return e in t ? Object.defineProperty(t, e, {
        value: n,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = n, t;
}

var app = getApp();

Page({
    data: (_data = {
        status: 0,
        lovestatus: 0,
        loveimg: "../../../../byjs_sun/resource/images/find/icon-love.png",
        loveimg1: "../../../../byjs_sun/resource/images/find/icon-love-1.png",
        lovenum: 0
    }, _defineProperty(_data, "lovestatus", 0), _defineProperty(_data, "talent", []), 
    _data),
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        });
    },
    attention: function(t) {
        var e = this, n = wx.getStorageSync("users").id, o = t.currentTarget.dataset.atten;
        wx.showModal({
            title: "提示",
            content: "确定要删除吗？",
            success: function(t) {
                t.confirm ? app.util.request({
                    url: "entry/wxapp/ChangeFans",
                    data: {
                        user_id: n,
                        fansid: o,
                        is_attention: 0
                    },
                    cachetime: 0,
                    success: function(t) {
                        e.onShow();
                    }
                }) : t.cancel && console.log("用户点击取消");
            }
        });
    },
    lovefun: function(t) {
        var e = this, n = (t.currentTarget.dataset.id, wx.getStorageSync("users").id), o = t.currentTarget.dataset.id, a = (wx.getStorageSync("url"), 
        t.currentTarget.dataset.f_index), i = e.data.talent;
        console.log(i), console.log(a), console.log(i[a]), 1 == i[a].is_love ? (i[a].is_love = 0, 
        i[a].expertInfo.collect_num = parseInt(i[a].expertInfo.collect_num) - 1) : (i[a].is_love = 1, 
        i[a].expertInfo.collect_num = parseInt(i[a].expertInfo.collect_num) + 1), app.util.request({
            url: "entry/wxapp/lovefun",
            cachetime: "0",
            data: {
                id: o,
                user_id: n
            },
            success: function(t) {
                1 == t.data ? e.setData({
                    talent: i
                }) : wx.showToast({
                    title: "点赞失败，网络延迟！！！",
                    icon: "none"
                });
            },
            fail: function(t) {
                wx.showToast({
                    title: "点赞失败，网络延迟！！！",
                    icon: "none"
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this, t = wx.getStorageSync("users").id, n = wx.getStorageSync("url");
        app.util.request({
            url: "entry/wxapp/getAttentionList",
            cachetime: "0",
            data: {
                user_id: t
            },
            success: function(t) {
                e.setData({
                    talent: t.data,
                    url: n
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    gointeractiveInfoone: function(t) {
        var e = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../../find/interactive/interactiveInfoone/interactiveInfoone?id=" + e
        });
    }
});