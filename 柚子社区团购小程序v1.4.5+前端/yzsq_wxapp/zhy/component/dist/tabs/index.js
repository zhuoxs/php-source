var _create = require("../common/create");

(0, _create.create)({
    relations: {
        "../tab/index": {
            type: "descendant",
            linked: function(t) {
                this.data.tabs.push({
                    instance: t,
                    data: t.data
                }), this.updateTabs();
            },
            unlinked: function(e) {
                var t = this.data.tabs.filter(function(t) {
                    return t.instance !== e;
                });
                this.setData({
                    tabs: t,
                    scrollable: t.length > this.data.swipeThreshold
                }), this.setActiveTab();
            }
        }
    },
    props: {
        color: {
            type: String,
            observer: "setLine"
        },
        lineWidth: {
            type: Number,
            observer: "setLine"
        },
        active: {
            type: null,
            value: 0,
            observer: "setActiveTab"
        },
        type: {
            type: String,
            value: "line"
        },
        duration: {
            type: Number,
            value: .2
        },
        swipeThreshold: {
            type: Number,
            value: 4,
            observer: function() {
                this.setData({
                    scrollable: this.data.tabs.length > this.data.swipeThreshold
                });
            }
        }
    },
    data: {
        tabs: [],
        lineStyle: "",
        scrollLeft: 0
    },
    ready: function() {
        this.setLine(), this.scrollIntoView();
    },
    methods: {
        updateTabs: function() {
            var t = this.data.tabs;
            this.setData({
                tabs: t,
                scrollable: t.length > this.data.swipeThreshold
            }), this.setActiveTab();
        },
        trigger: function(t, e) {
            this.$emit(t, {
                index: e,
                title: this.data.tabs[e].data.title
            });
        },
        onTap: function(t) {
            var e = t.currentTarget.dataset.index;
            this.data.tabs[e].data.disabled ? this.trigger("disabled", e) : (this.trigger("click", e), 
            this.setActive(e));
        },
        setActive: function(t) {
            t !== this.data.active && (this.trigger("change", t), this.setData({
                active: t
            }), this.setActiveTab());
        },
        setLine: function() {
            var s = this;
            "line" === this.data.type && this.getRect(".van-tab", !0).then(function(t) {
                var e = t[s.data.active], a = s.data.lineWidth || e.width, i = t.slice(0, s.data.active).reduce(function(t, e) {
                    return t + e.width;
                }, 0);
                i += (e.width - a) / 2, s.setData({
                    lineStyle: "\n            width: " + a + "px;\n            background-color: " + s.data.color + ";\n            transform: translateX(" + i + "px);\n            transition-duration: " + s.data.duration + "s;\n          "
                });
            });
        },
        setActiveTab: function() {
            var i = this;
            this.data.tabs.forEach(function(t, e) {
                var a = {
                    active: e === i.data.active
                };
                a.active && (a.inited = !0), a.active !== t.instance.data.active && t.instance.setData(a);
            }), this.setLine(), this.scrollIntoView();
        },
        scrollIntoView: function(t) {
            var s = this;
            this.data.scrollable && this.getRect(".van-tab", !0).then(function(t) {
                var e = t[s.data.active], a = t.slice(0, s.data.active).reduce(function(t, e) {
                    return t + e.width;
                }, 0), i = e.width;
                s.getRect(".van-tabs__nav").then(function(t) {
                    var e = t.width;
                    s.setData({
                        scrollLeft: a - (e - i) / 2
                    });
                });
            });
        }
    }
});