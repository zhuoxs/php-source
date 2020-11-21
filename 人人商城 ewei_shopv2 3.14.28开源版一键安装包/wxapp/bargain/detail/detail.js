var t = getApp(), i = t.requirejs("core"), a = (t.requirejs("jquery"), t.requirejs("foxui"), 
t.requirejs("wxParse/wxParse"));

Page({
    data: {
        id: "",
        layer: !1,
        goods: {},
        istimeTitle: "",
        timer: 0,
        upper_limit: !1,
        upper_limitTitle: "",
        act_swi: "",
        error_hint: !1,
        error_hint_title: "",
        advHeight: 1
    },
    imageLoad: function(t) {
        var i = t.detail.height, a = t.detail.width, e = Math.floor(750 * i / a);
        i == a ? this.setData({
            advHeight: 750
        }) : this.setData({
            advHeight: e
        });
    },
    onLoad: function(e) {
        var r = this;
        t.getCache("isIpx") ? r.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar"
        }) : r.setData({
            isIpx: !1,
            iphonexnavbar: ""
        }), i.get("bargain/get_detail", e, function(t) {
            if (r.setData({
                goods: t.list
            }), r.setData({
                id: t.list.id,
                act_swi: t.list.act_swi
            }), a.wxParse("wxParseData", "html", t.list.content, r, "0"), r.countDown(t.list.start_time, t.list.end_time, "istime"), 
            1 == t.list.isStart) {
                clearInterval(r.data.timer);
                var i = setInterval(function() {
                    r.countDown(t.list.start_time, t.list.end_time, "istime");
                }, 1e3);
                r.setData({
                    timer: i
                });
            }
        }), wx.setNavigationBarTitle({
            title: "砍价商品详情"
        });
    },
    cutPrice: function() {
        this.setData({
            layer: !0
        });
    },
    closeLayer: function() {
        this.setData({
            layer: !1
        });
    },
    countDown: function(t, i, a) {
        var e = parseInt(Date.now() / 1e3), r = (t > e ? t : i) - e, s = parseInt(r), n = Math.floor(s / 86400), o = Math.floor((s - 24 * n * 60 * 60) / 3600), l = Math.floor((s - 24 * n * 60 * 60 - 3600 * o) / 60), h = [ n, o, l, Math.floor(s - 24 * n * 60 * 60 - 3600 * o - 60 * l) ];
        if (this.setData({
            time: h
        }), "istime") {
            var u = "";
            t > e ? (u = "未开始", this.setData({
                istime: 0
            })) : t <= e && i > e ? (u = "剩余时间", this.setData({
                istime: 1
            })) : (u = "活动已经结束，下次早点来~", this.setData({
                istime: 2
            })), this.setData({
                istimeTitle: u
            });
        }
    },
    backhome: function() {
        wx.switchTab({
            url: "/pages/index/index"
        });
    },
    goJoin: function() {
        t.checkAuth();
        var a = this, e = a.data.id;
        i.get("bargain/join", {
            id: e
        }, function(t) {
            if (1 != t.error) {
                if (0 == t.error) {
                    if (1 == t.initiate) return void a.setData({
                        upper_limit: !0,
                        upper_limitTitle: "您已经发起过一次本商品的砍价活动,是否立即查看？",
                        act_swi: t.bargainid
                    });
                    wx.navigateTo({
                        url: "/bargain/bargain/bargain?id=" + t.id + "&mid=" + t.mid
                    });
                }
            } else a.setData({
                error_hint: !0,
                error_hint_title: t.message
            });
        });
    },
    alreadyHave: function() {
        t.checkAuth(), this.setData({
            upper_limit: !0,
            upper_limitTitle: "您已经发起过一次本商品的砍价活动,是否立即查看？"
        });
    },
    closeUpper: function() {
        this.setData({
            upper_limit: !1
        });
    },
    affirmUpper: function() {
        var t = this.data.act_swi;
        wx.navigateTo({
            url: "/bargain/bargain/bargain?id=" + t
        });
    },
    closeError: function() {
        this.setData({
            error_hint: !1
        });
    }
});