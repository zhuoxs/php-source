(0, require("../common/component").VantComponent)({
    props: {
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
            value: "#ed6a0c"
        },
        backgroundColor: {
            type: String,
            value: "#fffbe8"
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
    watch: {
        text: function() {
            this.set({}, this.init);
        }
    },
    created: function() {
        this.data.mode && this.set({
            hasRightIcon: !0
        });
    },
    destroyed: function() {
        var t = this.data.timer;
        t && clearTimeout(t);
    },
    methods: {
        init: function() {
            var t = this;
            this.getRect(".van-notice-bar__content").then(function(e) {
                e && e.width && (t.set({
                    width: e.width
                }), t.getRect(".van-notice-bar__content-wrap").then(function(e) {
                    if (e && e.width) {
                        var i = e.width, n = t.data, a = n.width, o = n.speed, r = n.scrollable, s = n.delay;
                        if (r && i < a) {
                            var l = a / o * 1e3, c = wx.createAnimation({
                                duration: l,
                                timeingFunction: "linear",
                                delay: s
                            }), u = wx.createAnimation({
                                duration: 0,
                                timeingFunction: "linear"
                            });
                            t.set({
                                elapse: l,
                                wrapWidth: i,
                                animation: c,
                                resetAnimation: u
                            }, function() {
                                t.scroll();
                            });
                        }
                    }
                }));
            });
        },
        scroll: function() {
            var t = this, e = this.data, i = e.animation, n = e.resetAnimation, a = e.wrapWidth, o = e.elapse, r = e.speed;
            n.translateX(a).step();
            var s = i.translateX(-o * r / 1e3).step();
            this.set({
                animationData: n.export()
            }), setTimeout(function() {
                t.set({
                    animationData: s.export()
                });
            }, 100);
            var l = setTimeout(function() {
                t.scroll();
            }, o);
            this.set({
                timer: l
            });
        },
        onClickIcon: function() {
            var t = this.data.timer;
            t && clearTimeout(t), this.set({
                show: !1,
                timer: null
            });
        },
        onClick: function(t) {
            this.$emit("click", t);
        }
    }
});