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
    data: {},
    onLoad: function(a) {
        this.onLoadData();
    },
    onLoadData: function() {
        var t = this, a = wx.getStorageSync("userInfo");
        if (a) {
            var e = {
                user_id: a.id,
                page: this.data.list.page,
                length: this.data.list.length
            };
            app.ajax({
                url: "Crecharge|balanceList",
                data: e,
                success: function(a) {
                    t.setData({
                        show: !0
                    }), t.dealList(a.data, 0);
                }
            });
        } else wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(a) {
                if (a.confirm) {
                    var t = encodeURIComponent("/sqtg_sun/pages/home/my/my?id=123");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + t);
                } else a.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    loadList: function() {
        var t = this, a = wx.getStorageSync("userInfo");
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var e = {
                user_id: a.id,
                page: this.data.list.page,
                length: this.data.list.length
            };
            app.ajax({
                url: "Crecharge|balanceList",
                data: e,
                success: function(a) {
                    t.dealList(a.data, e.page);
                }
            });
        }
    },
    onReachBottom: function() {
        this.loadList();
    },
    onInfoTab: function(a) {
        var t = a.currentTarget.dataset.idx, e = "/sqtg_sun/pages/public/pages/balanceinfo/balanceinfo?id=" + JSON.stringify(this.data.list.data[t]);
        app.navTo(e);
    }
});