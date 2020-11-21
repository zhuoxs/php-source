var app = getApp();

Page({
    data: {},
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onLoad: function(t) {
        var e = this, a = wx.getStorageSync("mlogin");
        this._getTxjl(a);
        var s = 0;
        t.fxsid && (s = t.fxsid, e.setData({
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
        }), app.util.getUserInfo(e.getinfos, s);
    },
    timestampToTime: function(t) {
        var e = new Date(1e3 * t);
        return e.getFullYear() + "-" + ((e.getMonth() + 1 < 10 ? "0" + (e.getMonth() + 1) : e.getMonth() + 1) + "-") + (e.getDate() + " ") + (e.getHours() + "") + e.getMinutes();
    },
    _getTxjl: function(t) {
        var s = this;
        if (!t) return wx.showModal({
            title: "非法操作！",
            content: "没有商户号",
            showCancel: !1
        }), !1;
        app.util.request({
            url: "entry/wxapp/getTxjl",
            data: {
                id: t
            },
            success: function(t) {
                for (var e = t.data.data, a = 0; a < e.length; a++) e[a].createtime = s.timestampToTime(e[a].createtime), 
                1 == e[a].types && (e[a].types = "微信"), 2 == e[a].types && (e[a].types = "支付宝"), 
                3 == e[a].types && (e[a].types = "银行卡");
                s.setData({
                    txjlINfo: e
                });
            }
        });
    }
});