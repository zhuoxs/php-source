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
    data: {
        navChoose: 0,
        showmodalstatus: !1
    },
    onLoad: function(t) {
        this.onLoadData();
    },
    onLoadData: function() {
        var a = 0, e = this, t = wx.getStorageSync("userInfo");
        if (t) {
            app.ajax({
                url: "Cintegral|myInteral",
                data: {
                    user_id: t.id
                },
                success: function(t) {
                    e.setData({
                        info: t.data
                    }), 1 == ++a && e.setData({
                        show: !0
                    });
                }
            });
            var s = {
                page: this.data.list.page,
                length: this.data.list.length,
                user_id: t.id,
                type: 1
            };
            app.ajax({
                url: "Cintegral|integralRecord",
                data: s,
                success: function(t) {
                    e.dealList(t.data, 0), 1 == ++a && e.setData({
                        show: !0
                    });
                }
            });
        } else wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                t.confirm ? app.reTo("/sqtg_sun/pages/home/login/login?id=/sqtg_sun/pages/public/pages/myintegral/myintegral") : t.cancel && wx.navigateBack({
                    delta: 1
                });
            }
        });
    },
    loadList: function() {
        var a = this, t = wx.getStorageSync("userInfo");
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var e = {
                page: this.data.list.page,
                length: this.data.list.length,
                user_id: t.id,
                type: this.data.navChoose - 0 + 1
            };
            app.ajax({
                url: "Cintegral|integralRecord",
                data: e,
                success: function(t) {
                    a.dealList(t.data, e.page);
                }
            });
        }
    },
    onReachBottom: function() {
        this.loadList();
    },
    onSwichNav: function(t) {
        var a = t.target.dataset.id;
        this.setData({
            navChoose: a,
            list: {
                page: 0,
                length: 10,
                over: !1,
                load: !1,
                none: !1,
                data: []
            }
        }), this.loadList();
    },
    warm: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.util(a);
    },
    close: function(t) {
        var a = t.currentTarget.dataset.statu;
        this.util(a);
    },
    util: function(t) {
        "open" == t && this.setData({
            showmodalstatus: !0
        }), "close" == t && this.setData({
            showmodalstatus: !1
        });
    }
});