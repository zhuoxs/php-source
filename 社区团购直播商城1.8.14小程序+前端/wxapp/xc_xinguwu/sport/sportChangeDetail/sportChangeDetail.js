var app = getApp(), WxParse = require("../../../wxParse/wxParse.js"), nowtime = null, timer_getTip = null;

function getTip(t) {
    app.util.request({
        url: "entry/wxapp/sport",
        showLoading: !1,
        method: "POST",
        data: {
            op: "getTip",
            id: t.data.options.id,
            time: nowtime
        },
        success: function(a) {
            t.setData({
                tip: a.data.data.list
            }), t.showD(), nowtime = a.data.data.list.createtime;
        }
    }), timer_getTip = setTimeout(function() {
        getTip(t);
    }, 12e4);
}

Page({
    data: {
        curIndex: 1,
        ppt_set: {
            indicator_dots: 1,
            indicator_color: "#f0f0f0",
            indicator_active_color: "#f93d3d",
            autoplay: 1,
            interval: 5e3,
            duration: 500,
            circular: -1,
            vertical: -1,
            previous_margin: 0,
            next_margin: 0,
            display_multiple_items: 1,
            skip_hidden_item_layout: -1
        },
        page: 1,
        pagesize: 10,
        loadend: !1,
        record: null
    },
    imageLoad: function(a) {
        var t = a.detail.width, e = 100 * a.detail.height / t;
        this.setData({
            bannerHeight: e
        });
    },
    change: function(a) {
        var t = a.currentTarget.dataset.index;
        if (this.setData({
            curIndex: t
        }), 2 == t) {
            var e = this;
            app.util.request({
                url: "entry/wxapp/sport",
                showLoading: !1,
                method: "POST",
                data: {
                    op: "loadLog",
                    page: 1,
                    pagesize: e.data.pagesize,
                    id: e.data.list.id
                },
                success: function(a) {
                    var t = a.data;
                    t.data.list && e.setData({
                        record: t.data.list,
                        page: 1,
                        loadend: !1
                    });
                },
                fail: function(a) {
                    e.setData({
                        loadend: !0
                    });
                }
            });
        }
    },
    loadLog: function() {
        if (!this.data.loadend) {
            var e = this;
            app.util.request({
                url: "entry/wxapp/sport",
                showLoading: !1,
                method: "POST",
                data: {
                    op: "loadLog",
                    page: e.data.page + 1,
                    pagesize: e.data.pagesize,
                    id: e.data.list.id
                },
                success: function(a) {
                    var t = a.data;
                    t.data.list && e.setData({
                        record: e.data.list.concat(t.data.list),
                        page: e.data.page + 1
                    });
                },
                fail: function(a) {
                    e.setData({
                        loadend: !0
                    });
                }
            });
        }
    },
    exchange: function(a) {
        var t = this, e = wx.createAnimation({
            duration: 500,
            timingFunction: "linear"
        });
        (t.animation = e).translateY(100).step(), t.setData({
            animationData: e.export(),
            change: !0,
            shadow: !0
        }), setTimeout(function() {
            e.translateY(0).step(), t.setData({
                animationData: e.export()
            });
        }, 200);
    },
    close: function() {
        var a = this, t = wx.createAnimation({
            duration: 1e3,
            timingFunction: "linear"
        });
        (a.animation = t).translateY(100).step(), a.setData({
            animationData: t.export()
        }), setTimeout(function() {
            t.translateY(0).step(), a.setData({
                animationData: t.export(),
                change: !1,
                shadow: !1
            });
        }, 200);
    },
    showD: function(a) {
        var t = this, e = wx.createAnimation({
            duration: 500,
            timingFunction: "linear"
        });
        (t.animation = e).translateX(-100).step(), t.setData({
            animationData1: e.export(),
            has: !0
        }), setTimeout(function() {
            e.translateX(0).step(), t.setData({
                animationData1: e.export()
            });
        }, 200), setTimeout(function() {
            t.setData({
                has: !1
            });
        }, 1200);
    },
    submit: function() {
        if (parseInt(this.data.coin) < parseInt(this.data.list.coin)) app.look.alert("余币不足"); else {
            if (null == this.data.address) return app.look, void alert("请选择地址");
            parseInt(this.data.list.stock) <= 0 && app.look.alert("库存不足");
            var t = this, a = this.data.address;
            console.log(this.data.address), app.util.request({
                url: "entry/wxapp/sport",
                showLoading: !1,
                method: "POST",
                data: {
                    op: "makeOrder",
                    address: JSON.stringify(a),
                    id: t.data.list.id
                },
                success: function(a) {
                    app.look.ok(a.data.message, function() {
                        t.close(), wx.navigateTo({
                            url: "../sportSuccess/sportSuccess?img=" + t.data.list.img + "&name=" + t.data.list.name + "coin=" + t.data.list.coin + "&order=" + a.data.data
                        });
                    });
                },
                fail: function(a) {
                    2 == a.data.errno ? app.look.no(a.data.message) : wx.showModal({
                        title: "系统提示",
                        content: a.data.message
                    });
                }
            });
        }
    },
    onLoad: function(a) {
        var t = new app.util.date();
        nowtime = t.dateToStr("yyyy-MM-dd HH:mm:ss"), this.setData({
            options: a
        });
        var e = this;
        app.util.request({
            url: "entry/wxapp/sport",
            showLoading: !1,
            method: "POST",
            data: {
                op: "sportGoodDetail",
                id: e.data.options.id
            },
            success: function(a) {
                var t = a.data;
                console.log(t), t.data.list && (WxParse.wxParse("article", "html", t.data.list.contents, e, 0), 
                app.globalData.userInfo.coin = t.data.coin, e.setData({
                    list: t.data.list,
                    coin: t.data.coin
                }), getTip(e));
            },
            fail: function(a) {
                app.look.no(a.data.message);
            }
        });
    },
    onReady: function() {
        var a = {};
        a.sport_icon = app.module_url + "resource/wxapp/sport/sport-icon.png", a.sport_pos = app.module_url + "resource/wxapp/sport/sport-pos.png", 
        this.setData({
            images: a
        });
    },
    onShow: function() {
        this.setData({
            address: app.address
        });
    },
    onHide: function() {},
    onUnload: function() {
        clearTimeout(timer_getTip);
    },
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});