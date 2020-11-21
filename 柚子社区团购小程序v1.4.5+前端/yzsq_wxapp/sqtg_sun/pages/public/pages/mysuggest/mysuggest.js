function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp();

Page({
    data: {},
    onLoad: function(t) {
        this.onLoadData();
    },
    onLoadData: function() {
        var a = this, t = wx.getStorageSync("userInfo");
        if (t) {
            var e = {
                user_id: t.id,
                page: this.data.list.page,
                length: this.data.list.length
            };
            app.ajax({
                url: "Csuggest|mySuggest",
                data: e,
                success: function(t) {
                    a.setData({
                        show: !0
                    }), a.dealList(t.data, 0);
                }
            });
        } else wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/home/my/my?id=123");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else t.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    loadList: function() {
        var a = this, t = wx.getStorageSync("userInfo");
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var e = {
                user_id: t.id,
                page: this.data.list.page,
                length: this.data.list.length
            };
            app.ajax({
                url: "Csuggest|mySuggest",
                data: e,
                success: function(t) {
                    a.dealList(t.data, e.page);
                }
            });
        }
    },
    onReachBottom: function() {
        this.loadList();
    }
});