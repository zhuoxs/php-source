var app = getApp(), pageNum = 0;

Page({
    data: {
        thiseven: 0,
        gun: !0,
        text: [ "综合", "佣金比例", "销量", "价格" ],
        zoor: 0,
        searchinput: "",
        fen: !0,
        rankno: 0
    },
    bindchange: function(a) {
        this.setData({
            tuhight: a.detail.current
        });
    },
    onLoad: function(a) {
        a.cateid;
        var t = this;
        t.setData({
            qieone: 0,
            qietwo: 0,
            qiethree: 0
        }), t.Headcolor(), t.shangpin(), t.Theme();
    },
    Theme: function() {
        var s = this;
        app.util.request({
            url: "entry/wxapp/Theme",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.yesno, e = a.data.data.list;
                console.log(e), console.log(t), s.setData({
                    yesno: t,
                    goodsist: e
                });
            },
            fail: function(a) {}
        });
    },
    shangpin: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/Theme",
            method: "POST",
            data: {
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.list;
                e.setData({
                    goodsist: t
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    fenlei: function(a) {
        var e = this, t = a.currentTarget.dataset.cateid;
        e.setData({
            cateid: t
        }), app.util.request({
            url: "entry/wxapp/Theme",
            method: "POST",
            data: {
                cateid: t,
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.list;
                e.setData({
                    goodsist: t
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    jaizai: function(a) {
        var s = this, i = s.data.goodsist;
        app.util.request({
            url: "entry/wxapp/Theme",
            method: "POST",
            data: {
                pageNum: a,
                rankno: s.data.rankno,
                user_id: app.globalData.user_id
            },
            success: function(a) {
                for (var t = a.data.data.list, e = 0; e < t.length; e++) i.push(t[e]);
                s.setData({
                    goodsist: i
                });
            }
        });
    },
    details: function(a) {
        var t = a.currentTarget.dataset.id, e = a.currentTarget.dataset.hui;
        wx.navigateTo({
            url: "../details/details?goods_id=" + t + "&hui=" + e
        });
    },
    swiperChange: function(a) {
        this.setData({
            swiperCurrent: a.detail.current
        });
    },
    Headcolor: function() {
        var s = this;
        app.util.request({
            url: "entry/wxapp/Headcolor",
            method: "POST",
            success: function(a) {
                var t = a.data.data.search_color, e = a.data.data.config.share_icon;
                s.setData({
                    search_color: t,
                    share_icon: e
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    paixu: function(a, t) {
        var i = this;
        a = a;
        i.setData({
            rankno: a
        }), app.util.request({
            url: "entry/wxapp/Theme",
            method: "POST",
            data: {
                rankno: a,
                inputValue: t,
                user_id: app.globalData.user_id
            },
            success: function(a) {
                var t = a.data.data.list, e = a.data.data.banner, s = a.data.data.nav;
                i.setData({
                    goodsist: t,
                    banner: e,
                    nav: s
                });
            },
            fail: function(a) {
                console.log("失败" + a);
            }
        });
    },
    onShareAppMessage: function(a) {
        a.from;
        var t = a.target.dataset.src, e = a.target.dataset.id, s = a.target.dataset.name;
        return this.setData({
            goods_src: t,
            goods_id: e,
            goods_name: s
        }), {
            title: this.data.goods_name,
            path: "hc_pdd/pages/details/details?goods_id=" + this.data.goods.goods_id + "&user_id=" + app.globalData.user_id,
            imageUrl: this.data.goods_src,
            success: function(a) {},
            fail: function(a) {}
        };
    }
});