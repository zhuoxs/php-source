var app = getApp();

Page({
    data: {},
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var e = this, a = wx.getStorageSync("mlogin");
        this._getTxjl(a);
        var n = 0;
        t.fxsid && (n = t.fxsid, e.setData({
            fxsid: t.fxsid
        }));
        var o = app.util.url("entry/wxapp/BaseMin", {
            m: "sudu8_page"
        });
        wx.request({
            url: o,
            data: {
                vs1: 1
            },
            cachetime: "30",
            success: function(t) {
                t.data.data;
                e.setData({
                    baseinfo: t.data.data
                }), wx.setNavigationBarColor({
                    frontColor: e.data.baseinfo.base_tcolor,
                    backgroundColor: e.data.baseinfo.base_color
                });
            }
        }), app.util.getUserInfo(e.getinfos, n);
    },
    timestampToTime: function(t) {
        var e = new Date(1e3 * t);
        return e.getFullYear() + "-" + ((e.getMonth() + 1 < 10 ? "0" + (e.getMonth() + 1) : e.getMonth() + 1) + "-") + (e.getDate() + " ") + (e.getHours() + ":") + e.getMinutes();
    },
    _getTxjl: function(t) {
        var s = this;
        if (!t) return wx.showModal({
            title: "非法操作！",
            content: "没有商户号",
            showCancel: !1
        }), !1;
        app.util.request({
            url: "entry/wxapp/getSzjl",
            data: {
                id: t,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                var e = t.data.data[0], a = t.data.data[1], n = new Array();
                0 == e.length || 0 == a.length ? (0 < e.length && (n = e), 0 < a.length && (n = a)) : n = e.concat(a), 
                n.sort(function(t, e) {
                    return e.creattime - t.creattime;
                });
                for (var o = 0; o < n.length; o++) n[o].creattime = s.timestampToTime(n[o].creattime), 
                1 == n[o].types && (n[o].types = "微信"), 2 == n[o].types && (n[o].types = "支付宝"), 
                3 == n[o].types && (n[o].types = "银行卡"), 0 == n[o].flag && delete n[o];
                s.setData({
                    szjlINfo: n
                });
            }
        });
    }
});