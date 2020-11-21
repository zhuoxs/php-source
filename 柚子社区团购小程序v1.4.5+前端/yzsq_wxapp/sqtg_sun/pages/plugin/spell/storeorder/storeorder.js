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
        choose: 0
    },
    onLoad: function(t) {
        this.setData({
            choose: t.status,
            id: t.id
        }), this.onLoadData();
    },
    onLoadData: function() {
        var t = wx.getStorageSync("userInfo");
        t ? (this.setData({
            uInfo: t
        }), this.loadList()) : wx.showModal({
            title: "提示",
            content: "您未登陆，请先登陆！",
            success: function(t) {
                if (t.confirm) {
                    var a = encodeURIComponent("/sqtg_sun/pages/plugin/spell/myorder/myorder");
                    app.reTo("/sqtg_sun/pages/home/login/login?id=" + a);
                } else t.cancel && app.lunchTo("/sqtg_sun/pages/home/index/index");
            }
        });
    },
    loadList: function() {
        var a = this;
        if (!this.data.list.over) {
            this.setData(_defineProperty({}, "list.load", !0));
            var e = {
                user_id: this.data.uInfo.id,
                page: this.data.list.page,
                length: this.data.list.length,
                type: this.data.choose,
                store_id: this.data.id,
                ordertype: 2
            };
            app.api.getCpinOrderList(e).then(function(t) {
                1 == e.page && a.setData({
                    show: !0,
                    imgRoot: t.other.img_root
                }), a.dealList(t.data, e.page);
            }).catch(function(t) {
                t.code, app.tips(t.msg);
            });
        }
    },
    onReachBottom: function() {
        this.loadList();
    },
    onNavTab: function(t) {
        this.setData({
            choose: t.target.dataset.index,
            list: {
                page: 1,
                length: 10,
                over: !1,
                load: !1,
                none: !1,
                data: []
            }
        }), this.loadList();
    },
    onBtnTab: function(t) {
        var a = t.target.dataset.idx;
        if (1 == this.data.list.data[a].order_status) {
            var e = {
                heads_id: this.data.list.data[a].heads_id,
                goods_id: this.data.list.data[a].goods_id
            }, i = JSON.stringify(e);
            app.navTo("/sqtg_sun/pages/plugin/spell/join/join?id=" + i);
        } else if (4 == this.data.list.data[a].order_status) app.navTo("/sqtg_sun/pages/plugin/spell/comment/comment?id=" + this.data.list.data[a].id); else {
            var s = this.data.list.data[a].id;
            app.navTo("/sqtg_sun/pages/plugin/spell/orderinfo/orderinfo?id=" + s);
        }
    }
});