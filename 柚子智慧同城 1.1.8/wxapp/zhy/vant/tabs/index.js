var t = require("../common/component"), e = require("../mixins/touch");

(0, t.VantComponent)({
    mixins: [ e.touch ],
    relation: {
        name: "tab",
        type: "descendant",
        linked: function(t) {
            this.child.push(t), this.updateTabs(this.data.tabs.concat(t.data));
        },
        unlinked: function(t) {
            var e = this.child.indexOf(t), i = this.data.tabs;
            i.splice(e, 1), this.child.splice(e, 1), this.updateTabs(i);
        }
    },
    props: {
        color: String,
        sticky: Boolean,
        animated: Boolean,
        swipeable: Boolean,
        lineWidth: {
            type: Number,
            value: -1
        },
        lineHeight: {
            type: Number,
            value: -1
        },
        active: {
            type: Number,
            value: 0
        },
        type: {
            type: String,
            value: "line"
        },
        border: {
            type: Boolean,
            value: !0
        },
        duration: {
            type: Number,
            value: .3
        },
        zIndex: {
            type: Number,
            value: 1
        },
        swipeThreshold: {
            type: Number,
            value: 4
        },
        offsetTop: {
            type: Number,
            value: 0
        }
    },
    data: {
        tabs: [],
        lineStyle: "",
        scrollLeft: 0,
        scrollable: !1,
        trackStyle: "",
        wrapStyle: "",
        position: ""
    },
    watch: {
        swipeThreshold: function() {
            this.set({
                scrollable: this.child.length > this.data.swipeThreshold
            });
        },
        color: "setLine",
        lineWidth: "setLine",
        lineHeight: "setLine",
        active: "setActiveTab",
        animated: "setTrack",
        offsetTop: "setWrapStyle"
    },
    beforeCreate: function() {
        this.child = [];
    },
    mounted: function() {
        this.setLine(), this.setTrack(), this.scrollIntoView(), this.observerTabScroll(), 
        this.observerContentScroll();
    },
    destroyed: function() {
        wx.createIntersectionObserver(this).disconnect();
    },
    methods: {
        updateTabs: function(t) {
            t = t || this.data.tabs, this.set({
                tabs: t,
                scrollable: t.length > this.data.swipeThreshold
            }), this.setActiveTab();
        },
        trigger: function(t, e) {
            this.$emit(t, {
                index: e,
                title: this.data.tabs[e].title
            });
        },
        onTap: function(t) {
            var e = t.currentTarget.dataset.index;
            this.data.tabs[e].disabled ? this.trigger("disabled", e) : (this.trigger("click", e), 
            this.setActive(e));
        },
        setActive: function(t) {
            t !== this.data.active && (this.trigger("change", t), this.set({
                active: t
            }), this.setActiveTab());
        },
        setLine: function() {
            var t = this;
            if ("line" === this.data.type) {
                var e = this.data, i = e.color, a = e.active, n = e.duration, s = e.lineWidth, o = e.lineHeight;
                this.getRect(".van-tab", !0).then(function(e) {
                    var r = e[a], c = -1 !== s ? s : r.width / 2, h = -1 !== o ? "height: " + o + "px;" : "", l = e.slice(0, a).reduce(function(t, e) {
                        return t + e.width;
                    }, 0);
                    l += (r.width - c) / 2, t.set({
                        lineStyle: "\n            " + h + "\n            width: " + c + "px;\n            background-color: " + i + ";\n            -webkit-transform: translateX(" + l + "px);\n            -webkit-transition-duration: " + n + "s;\n            transform: translateX(" + l + "px);\n            transition-duration: " + n + "s;\n          "
                    });
                });
            }
        },
        setTrack: function() {
            var t = this, e = this.data, i = e.animated, a = e.active, n = e.duration;
            if (!i) return "";
            this.getRect(".van-tabs__content").then(function(e) {
                var s = e.width;
                t.set({
                    trackStyle: "\n            width: " + s * t.child.length + "px;\n            left: " + -1 * a * s + "px;\n            transition: left " + n + "s;\n            display: flex;\n          "
                }), t.setTabsProps({
                    width: s,
                    animated: i
                });
            });
        },
        setTabsProps: function(t) {
            this.child.forEach(function(e) {
                e.set(t);
            });
        },
        setActiveTab: function() {
            var t = this;
            this.child.forEach(function(e, i) {
                var a = {
                    active: i === t.data.active
                };
                a.active && (a.inited = !0), a.active !== e.data.active && e.set(a);
            }), this.set({}, function() {
                t.setLine(), t.setTrack(), t.scrollIntoView();
            });
        },
        scrollIntoView: function() {
            var t = this;
            this.data.scrollable && this.getRect(".van-tab", !0).then(function(e) {
                var i = e[t.data.active], a = e.slice(0, t.data.active).reduce(function(t, e) {
                    return t + e.width;
                }, 0), n = i.width;
                t.getRect(".van-tabs__nav").then(function(e) {
                    var i = e.width;
                    t.set({
                        scrollLeft: a - (i - n) / 2
                    });
                });
            });
        },
        onTouchStart: function(t) {
            this.data.swipeable && this.touchStart(t);
        },
        onTouchMove: function(t) {
            this.data.swipeable && this.touchMove(t);
        },
        onTouchEnd: function() {
            if (this.data.swipeable) {
                var t = this.data, e = t.active, i = t.tabs, a = this.direction, n = this.deltaX, s = this.offsetX;
                "horizontal" === a && s >= 50 && (n > 0 && 0 !== e ? this.setActive(e - 1) : n < 0 && e !== i.length - 1 && this.setActive(e + 1));
            }
        },
        setWrapStyle: function() {
            var t, e = this.data, i = e.offsetTop;
            switch (e.position) {
              case "top":
                t = "\n            top: " + i + "px;\n            position: fixed;\n          ";
                break;

              case "bottom":
                t = "\n            top: auto;\n            bottom: 0;\n          ";
                break;

              default:
                t = "";
            }
            t !== this.data.wrapStyle && this.set({
                wrapStyle: t
            });
        },
        observerTabScroll: function() {
            var t = this;
            if (this.data.sticky) {
                var e = this.data.offsetTop;
                wx.createIntersectionObserver(this, {
                    thresholds: [ 1 ]
                }).relativeToViewport().observe(".van-tabs", function(i) {
                    var a = i.boundingClientRect.top, n = "";
                    e > a && (n = "top"), t.$emit("scroll", {
                        scrollTop: a + e,
                        isFixed: "top" === n
                    }), t.setPosition(n);
                });
            }
        },
        observerContentScroll: function() {
            var t = this;
            if (this.data.sticky) {
                var e = this.data.offsetTop;
                wx.createIntersectionObserver(this).relativeToViewport().observe(".van-tabs__content", function(i) {
                    var a = i.boundingClientRect.top, n = "";
                    i.intersectionRatio <= 0 ? n = "bottom" : e > a && (n = "top"), t.setPosition(n);
                });
            }
        },
        setPosition: function(t) {
            var e = this;
            t !== this.data.position && this.set({
                position: t
            }, function() {
                e.setWrapStyle();
            });
        }
    }
});