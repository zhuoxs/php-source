var _create = require("../common/create"), FONT_COLOR = "#f60", BG_COLOR = "#fff7cc";

(0, _create.create)({
    props: {
        text: {
            type: String,
            value: "",
            observer: function() {
                this.setData({}, this.init);
            }
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
            value: 50
        },
        scrollable: {
            type: Boolean,
            value: !0
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
        this.data.mode && this.setData({
            hasRightIcon: !0
        });
    },
    detached: function() {
        var t = this.data.timer;
        t && clearTimeout(t);
    },
    methods: {
        init: function() {
            var u = this;
            this.getRect(".van-notice-bar__content").then(function(t) {
                t && t.width && (u.setData({
                    width: t.width
                }), u.getRect(".van-notice-bar__content-wrap").then(function(t) {
                    if (t && t.width) {
                        var e = t.width, a = u.data, i = a.width, n = a.speed, o = a.scrollable, r = a.delay;
                        if (o && e < i) {
                            var s = i / n * 1e3, l = wx.createAnimation({
                                duration: s,
                                timeingFunction: "linear",
                                delay: r
                            }), c = wx.createAnimation({
                                duration: 0,
                                timeingFunction: "linear"
                            });
                            u.setData({
                                elapse: s,
                                wrapWidth: e,
                                animation: l,
                                resetAnimation: c
                            }, function() {
                                u.scroll();
                            });
                        }
                    }
                }));
            });
        },
        scroll: function() {
            var t = this, e = this.data, a = e.animation, i = e.resetAnimation, n = e.wrapWidth, o = e.elapse, r = e.speed;
            i.translateX(n).step();
            var s = a.translateX(-o * r / 1e3).step();
            this.setData({
                animationData: i.export()
            }), setTimeout(function() {
                t.setData({
                    animationData: s.export()
                });
            }, 100);
            var l = setTimeout(function() {
                t.scroll();
            }, o);
            this.setData({
                timer: l
            });
        },
        onClickIcon: function() {
            var t = this.data.timer;
            t && clearTimeout(t), this.setData({
                show: !1,
                timer: null
            });
        },
        onClick: function(t) {
            this.$emit("click", t);
        }
    }
});