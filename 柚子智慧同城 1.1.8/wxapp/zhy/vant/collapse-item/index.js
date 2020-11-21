(0, require("../common/component").VantComponent)({
    classes: [ "content-class" ],
    relation: {
        name: "collapse",
        type: "ancestor",
        linked: function(t) {
            this.parent = t;
        }
    },
    props: {
        name: null,
        title: null,
        value: null,
        icon: String,
        label: String,
        disabled: Boolean,
        border: {
            type: Boolean,
            value: !0
        },
        isLink: {
            type: Boolean,
            value: !0
        }
    },
    data: {
        contentHeight: 0,
        expanded: !1
    },
    beforeCreate: function() {
        this.animation = wx.createAnimation({
            duration: 300,
            timingFunction: "ease-in-out"
        });
    },
    methods: {
        updateExpanded: function() {
            if (!this.parent) return null;
            var t = this.parent.data, n = t.value, e = t.accordion, a = t.items, i = this.data.name, o = a.indexOf(this), s = null == i ? o : i, d = e ? n === s : n.some(function(t) {
                return t === s;
            });
            d !== this.data.expanded && this.updateStyle(d), this.set({
                expanded: d
            });
        },
        updateStyle: function(t) {
            var n = this;
            this.getRect(".van-collapse-item__content").then(function(e) {
                var a = n.animation.height(t ? e.height : 0).step().export();
                t ? n.set({
                    animationData: a
                }) : n.set({
                    contentHeight: e.height + "px"
                }, function() {
                    setTimeout(function() {
                        n.set({
                            animationData: a
                        });
                    }, 20);
                });
            });
        },
        onClick: function() {
            if (!this.data.disabled) {
                var t = this.data, n = t.name, e = t.expanded, a = this.parent.data.items.indexOf(this), i = null == n ? a : n;
                this.parent.switch(i, !e);
            }
        },
        onTransitionEnd: function() {
            this.data.expanded && this.set({
                contentHeight: "auto"
            });
        }
    }
});