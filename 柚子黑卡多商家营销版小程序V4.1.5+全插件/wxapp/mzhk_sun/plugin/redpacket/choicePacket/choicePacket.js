/*   time:2019-08-09 13:18:40*/
var app = getApp();
Page({
    data: {},
    onLoad: function(e) {
        var t = this;
        t.setData({
            price: e.price,
            totalprice: e.totalprice,
            goodsnum: e.goodsnum,
            id: e.id,
            type: e.type,
            deliveryfee: e.deliveryfee,
            sincetype: e.sincetype,
            firstmoney: e.firstmoney,
            tels: e.tels
        }), app.util.request({
            url: "entry/wxapp/GetredpacketList",
            showLoading: !1,
            data: {
                id: e.id,
                openid: wx.getStorageSync("openid"),
                m: app.globalData.Plugin_redpacket
            },
            success: function(e) {
                console.log(e.data), 2 != e.data && t.setData({
                    uselist: e.data.use,
                    nouselist: e.data.nouse,
                    explain: e.data.explain
                })
            }
        })
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    setRmoney: function(e) {
        var t = this,
            r = parseInt(e.currentTarget.dataset.rid),
            o = parseFloat(e.currentTarget.dataset.rmoney),
            a = parseFloat(e.currentTarget.dataset.allowmoney),
            i = parseFloat(t.data.price),
            n = parseInt(t.data.goodsnum),
            d = t.data.id,
            p = t.data.type,
            s = t.data.deliveryfee,
            l = t.data.sincetype,
            y = t.data.firstmoney,
            c = parseFloat(i * n) + parseFloat(s) - parseFloat(y),
            m = parseFloat(i * n) - parseFloat(o) + parseFloat(s) - parseFloat(y),
            u = t.data.tels;
        if (m < 0) m = 0;
        if (!(a <= c)) return wx.showModal({
            title: "提示",
            content: "不满足使用条件",
            showCancel: !1
        }), !1;
        if (1 == p) var f = "../../../pages/member/order/order?id=" + d + "&price=" + i + "&totalprice=" + m + "&goodsnum=" + n + "&allowmoney=" + a + "&typeid=1&rmoney=" + o + "&redtype=1&rid=" + r + "&deliveryfee=" + s + "&sincetype=" + l;
        if (2 == p) f = "../../../pages/member/order/order?id=" + d + "&price=" + i + "&totalprice=" + m + "&goodsnum=" + n + "&allowmoney=" + a + "&rmoney=" + o + "&redtype=1&rid=" + r + "&deliveryfee=" + s + "&sincetype=" + l;
        if (3 == p) f = "../../../pages/member/ptorder/ptorder?id=" + d + "&price=" + i + "&totalprice=" + m + "&goodsnum=" + n + "&allowmoney=" + a + "&buytype=1&rmoney=" + o + "&redtype=1&rid=" + r + "&deliveryfee=" + s + "&sincetype=" + l;
        if (4 == p) f = "../../../pages/member/ptorder/ptorder?id=" + d + "&totalprice=" + m + "&goodsnum=" + n + "&allowmoney=" + a + "&rmoney=" + o + "&redtype=1&rid=" + r + "&deliveryfee=" + s + "&sincetype=" + l;
        if (5 == p) f = "../../../pages/member/cforder/cforder?id=" + d + "&price=" + i + "&totalprice=" + m + "&goodsnum=" + n + "&allowmoney=" + a + "&rmoney=" + o + "&redtype=1&rid=" + r + "&deliveryfee=" + s + "&sincetype=" + l;
        if (12 == p) f = "/mzhk_sun/plugin2/secondary/order/order?id=" + d + "&price=" + i + "&totalprice=" + m + "&goodsnum=" + n + "&allowmoney=" + a + "&rmoney=" + o + "&redtype=1&rid=" + r + "&deliveryfee=" + s + "&sincetype=" + l + "&telnumber=" + u;
        wx.redirectTo({
            url: f
        })
    }
});