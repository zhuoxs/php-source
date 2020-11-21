function _defineProperty(a, e, t) {
    return e in a ? Object.defineProperty(a, e, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[e] = t, a;
}

var app = getApp();

Page({
    data: {},
    onLoad: function(a) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(a) {
                wx.setStorageSync("url", a.data), e.setData({
                    url: a.data
                });
            }
        });
    },
    onShow: function() {
        var e = this, a = wx.getStorageSync("userid");
        app.util.request({
            url: "entry/wxapp/Userdance",
            cachetime: "0",
            data: {
                openid: a
            },
            success: function(a) {
                console.log(a.data), e.setData({
                    peraonal: a.data
                });
            }
        });
    },
    tappraise: function(a) {
        var e, t = this, n = a.currentTarget.dataset.index, r = t.data.peraonal[n].praisetatus, i = t.data.peraonal[n].praisenum;
        0 == r ? (r = 1, i++) : (r = 0, i--);
        var o = "peraonal[" + n + "].praisenum", c = "peraonal[" + n + "].praisetatus";
        t.setData((_defineProperty(e = {}, c, r), _defineProperty(e, o, i), e));
    },
    attention: function(a) {
        var e = a.currentTarget.dataset.index, t = this.data.peraonal[e].attention;
        t = 0 == t ? 1 : 0;
        var n = "peraonal[" + e + "].attention";
        this.setData(_defineProperty({}, n, t));
    },
    goMydancederail: function(a) {
        wx.navigateTo({
            url: "../mydancederail/mydancederail?id=" + a.currentTarget.dataset.id
        });
    },
    closeitem: function(a) {
        var e = this, t = a.currentTarget.dataset.index, n = a.currentTarget.dataset.id, r = e.data.peraonal;
        console.log(t);
        var i = wx.getStorageSync("openid");
        wx.showModal({
            title: "提示",
            content: "是否删除动态",
            success: function(a) {
                a.confirm ? (console.log("用户点击确定"), app.util.request({
                    url: "entry/wxapp/deldance",
                    cachetime: "0",
                    data: {
                        openid: i,
                        id: n
                    },
                    success: function(a) {
                        r.splice(t, 1), e.setData({
                            peraonal: r
                        });
                    }
                })) : a.cancel && console.log("用户点击取消");
            }
        });
    }
});