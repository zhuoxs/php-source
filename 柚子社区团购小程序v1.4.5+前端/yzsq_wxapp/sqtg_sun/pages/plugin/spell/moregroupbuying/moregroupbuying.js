var _data;

function _defineProperty(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a;
}

var app = getApp();

Page({
    data: (_data = {
        olist: [],
        limit: 5,
        page: 1
    }, _defineProperty(_data, "limit", 5), _defineProperty(_data, "show", !1), _data),
    onLoad: function(a) {
        wx.setStorageSync("goods_id", a.goods_id), wx.setStorageSync("head_id", a.head_id), 
        this.loadData();
    },
    loadData: function() {
        var o = this, n = o.data.olist, i = o.data.limit, d = o.data.page, a = wx.getStorageSync("goods_id"), t = (wx.getStorageSync("head_id"), 
        wx.getStorageSync("linkaddress"));
        app.ajax({
            url: "Cpin|getGroup",
            data: {
                page: d,
                limit: i,
                leader_id: t.id,
                goods_id: a
            },
            success: function(a) {
                console.log(a.data);
                var t = a.data.length == i;
                if (1 == d) n = a.data; else for (var e in a.data) n.push(a.data[e]);
                d += 1, o.setData({
                    olist: n,
                    show: !0,
                    hasMore: t,
                    page: d,
                    imgroot: a.other.img_root
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this;
        setInterval(function() {
            var a = new Date().getTime();
            t.setData({
                curr: a
            });
        }, 1e3);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    joinpage: function(a) {
        var t = a.currentTarget.dataset.headid + "-" + a.currentTarget.dataset.goodsid + "-" + a.currentTarget.dataset.user + "-" + a.currentTarget.dataset.leaderid;
        console.log(t), app.lunchTo("/sqtg_sun/pages/plugin/spell/join/join?id=" + t);
    }
});