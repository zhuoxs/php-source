var VALID_MODE = [ "closeable" ], FONT_COLOR = "#f60", BG_COLOR = "#fff7cc";

Component({
    properties: {
        text: {
            type: String,
            value: ""
        },
        mode: {
            type: String,
            value: ""
        },
        url: {
            type: String,
            value: ""
        },
        openType: {
            type: String,
            value: "navigate"
        },
        delay: {
            type: Number,
            value: 0
        },
        speed: {
            type: Number,
            value: 40
        },
        scrollable: {
            type: Boolean,
            value: !1
        },
        leftIcon: {
            type: String,
            value: ""
        },
        color: {
            type: String,
            value: FONT_COLOR
        },
        backgroundColor: {
            type: String,
            value: BG_COLOR
        }
    },
    data: {
        show: !0,
        hasRightIcon: !1,
        width: void 0,
        wrapWidth: void 0,
        elapse: void 0,
        animation: null,
        resetAnimation: null,
        timer: null
    },
    attached: function() {
        var t = this.data.mode;
        t && this._checkMode(t) && this.setData({
            hasRightIcon: !0
        });
    },
    detached: function() {
        var t = this.data.timer;
        t && clearTimeout(t);
    },
    ready: function() {
        this._init();
    },
    methods: {
        _checkMode: function(t) {
            var e = ~VALID_MODE.indexOf(t);
            return e || console.warn("mode only accept value of " + VALID_MODE + ", now get " + t + "."), 
            e;
        },
        _init: function() {
            var u = this;
            wx.createSelectorQuery().in(this).select(".zan-noticebar__content").boundingClientRect(function(t) {
                if (!t || !t.width) throw new Error("页面缺少 noticebar 元素");
                u.setData({
                    width: t.width
                }), wx.createSelectorQuery().in(u).select(".zan-noticebar__content-wrap").boundingClientRect(function(t) {
                    if (t && t.width) {
                        var e = t.width, a = u.data, i = a.width, n = a.speed, o = a.scrollable, r = a.delay;
                        if (o && e < i) {
                            var l = i / n * 1e3, c = wx.createAnimation({
                                duration: l,
                                timeingFunction: "linear",
                                delay: r
                            }), s = wx.createAnimation({
                                duration: 0,
                                timeingFunction: "linear"
                            });
                            u.setData({
                                elapse: l,
                                wrapWidth: e,
                                animation: c,
                                resetAnimation: s
                            }, function() {
                                u._scroll();
                            });
                        }
                    }
                }).exec();
            }).exec();
        },
        _scroll: function() {
            var t = this, e = this.data, a = e.animation, i = e.resetAnimation, n = e.wrapWidth, o = e.elapse, r = e.speed;
            i.translateX(n).step();
            var l = a.translateX(-o * r / 1e3).step();
            this.setData({
                animationData: i.export()
            }), setTimeout(function() {
                t.setData({
                    animationData: l.export()
                });
            }, 100);
            var c = setTimeout(function() {
                t._scroll();
            }, o);
            this.setData({
                timer: c
            });
        },
        _handleButtonClick: function() {
            var t = this.data.timer;
            t && clearTimeout(t), this.setData({
                show: !1,
                timer: null
            });
        }
    }
});