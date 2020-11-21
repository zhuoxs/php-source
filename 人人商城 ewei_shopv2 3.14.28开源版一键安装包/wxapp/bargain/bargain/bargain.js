var a = getApp(), t = a.requirejs("core"), i = (a.requirejs("jquery"), a.requirejs("foxui"), 
a.requirejs("wxParse/wxParse"));

Page({
    data: {
        label: "/static/images/label.png",
        showtab: "family",
        bargainid: "",
        layer: !1,
        cutPrice: "",
        error_hint: !1,
        error_hint_title: "",
        list: {},
        bargain: {},
        bargain_set: {},
        istimeTitle: "剩余时间",
        bargain_record: {},
        bargain_actor: {},
        swi: "",
        trade_swi: "",
        myself_swi: "",
        mid: "",
        randomHint: {
            0: "大王，您即将触及我的价格底线，不要放弃继续砍价吧～",
            1: "主人，达到价格底线就可以带我回家啦！等你哦～",
            2: "加把劲，再砍一刀，马上就到底价了哦～",
            3: "砍到底价才能购买哦，邀请小伙伴来帮忙吧！",
            4: "叫上您的小伙伴来砍价，我们的的目标是底价买买买！"
        },
        marked_words: "",
        arrived: "",
        timeout: 0
    },
    onLoad: function(r) {
        a.url(r);
        var e = this;
        a.getCache("isIpx") ? e.setData({
            isIpx: !0,
            iphonexnavbar: "fui-iphonex-navbar"
        }) : e.setData({
            isIpx: !1,
            iphonexnavbar: ""
        }), t.get("bargain/bargain", r, function(a) {
            if (1 != a.error) {
                if (0 == a.error) {
                    1 == a.unequalMid && wx.navigateTo({
                        url: "/bargain/bargain/bargain?id=" + a.id + "&mid=" + a.mid
                    }), e.setData({
                        list: a.list,
                        bargain: a.bargain,
                        bargain_set: a.bargain_set,
                        bargain_record: a.bargain_record,
                        bargain_actor: a.bargain_actor,
                        swi: a.swi,
                        trade_swi: a.trade_swi,
                        myself_swi: a.myself_swi,
                        bargainid: a.list.id,
                        mid: a.mid,
                        arrived: a.arrived,
                        timeout: a.timeout
                    }), i.wxParse("wxParseData", "html", a.bargain.content, e, "0"), "" == a.bargain.rule || void 0 == a.bargain.rule ? i.wxParse("wxParseDataRule", "html", a.bargain_set.rule, e, "0") : i.wxParse("wxParseDataRule", "html", a.bargain.rule, e, "0"), 
                    e.countDown(a.bargain.start_time, a.bargain.end_time, "istime"), clearInterval(e.data.timer);
                    var t = setInterval(function() {
                        e.countDown(a.bargain.start_time, a.bargain.end_time, "istime");
                    }, 1e3);
                    e.setData({
                        timer: t
                    });
                }
            } else e.setData({
                upper_limit: !0,
                upper_limitTitle: a.message
            });
        });
        var s = Math.floor(4 * Math.random()), n = e.data.randomHint[s];
        e.setData({
            marked_words: n
        });
    },
    goodsTab: function(a) {
        this.setData({
            showtab: a.currentTarget.dataset.tap
        });
    },
    cutPrice: function() {
        a.checkAuth();
        var i = "/pages/message/auth/index", r = this, e = r.data.bargainid, s = r.data.mid;
        t.get("bargain/bargain", {
            id: e,
            ajax: 151,
            mid: s
        }, function(a) {
            -1 != a.error ? 1 != a.error ? 0 == a.error && a.cutPrice ? r.setData({
                layer: !0,
                cutPrice: a.cutPrice
            }) : wx.redirectTo({
                url: i
            }) : r.setData({
                error_hint: !0,
                error_hint_title: a.message
            }) : wx.redirectTo({
                url: i
            });
        });
    },
    closeLayer: function() {
        this.setData({
            layer: !1
        });
        var a = this.data.bargainid, t = this.data.mid;
        this.onLoad({
            id: a,
            mid: t
        });
    },
    goBackPrev: function() {
        wx.navigateBack({
            delta: 1
        });
    },
    countDown: function(a, t, i) {
        var r = parseInt(Date.now() / 1e3), e = (a > r ? a : t) - r, s = parseInt(e), n = Math.floor(s / 86400), o = Math.floor((s - 24 * n * 60 * 60) / 3600), d = Math.floor((s - 24 * n * 60 * 60 - 3600 * o) / 60), g = [ n, o, d, Math.floor(s - 24 * n * 60 * 60 - 3600 * o - 60 * d) ];
        if (this.setData({
            time: g
        }), "istime") {
            var u = "";
            a > r ? (u = "未开始", this.setData({
                istime: 0
            })) : a <= r && t > r ? (u = "剩余时间", this.setData({
                istime: 1
            })) : (u = "活动已经结束，下次早点来~", this.setData({
                istime: 2
            })), this.setData({
                istimeTitle: u
            });
        }
    },
    closeError: function() {
        this.setData({
            error_hint: !1
        });
    },
    seekHelp: function() {
        this.onShareAppMessage();
    },
    onShareAppMessage: function(a) {
        var t = this;
        return {
            title: "帮砍价",
            path: "/bargain/bargain/bargain?id=" + t.data.bargainid + "&mid=" + t.data.mid,
            success: function(a) {},
            fail: function(a) {}
        };
    }
});