function t() {
    return (t = Object.assign || function(t) {
        for (var e = 1; e < arguments.length; e++) {
            var n = arguments[e];
            for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (t[r] = n[r]);
        }
        return t;
    }).apply(this, arguments);
}

(0, require("../common/component").VantComponent)({
    field: !0,
    classes: [ "icon-class" ],
    props: {
        readonly: Boolean,
        disabled: Boolean,
        size: {
            type: Number,
            value: 20
        },
        icon: {
            type: String,
            value: "star"
        },
        voidIcon: {
            type: String,
            value: "star-o"
        },
        color: {
            type: String,
            value: "#ffd21e"
        },
        voidColor: {
            type: String,
            value: "#c7c7c7"
        },
        disabledColor: {
            type: String,
            value: "#bdbdbd"
        },
        count: {
            type: Number,
            value: 5
        },
        value: {
            type: Number,
            value: 0
        }
    },
    data: {
        innerValue: 0
    },
    watch: {
        value: function(t) {
            t !== this.data.innerValue && this.set({
                innerValue: t
            });
        }
    },
    computed: {
        list: function() {
            var t = this.data, e = t.count, n = t.innerValue;
            return Array.from({
                length: e
            }, function(t, e) {
                return e < n;
            });
        }
    },
    methods: {
        onSelect: function(t) {
            var e = this.data, n = t.currentTarget.dataset.index;
            e.disabled || e.readonly || (this.set({
                innerValue: n + 1
            }), this.$emit("input", n + 1), this.$emit("change", n + 1));
        },
        onTouchMove: function(e) {
            var n = this, r = e.touches[0], a = r.clientX, o = r.clientY;
            this.getRect(".van-rate__item", !0).then(function(r) {
                var i = r.find(function(t) {
                    return a >= t.left && a <= t.right && o >= t.top && o <= t.bottom;
                });
                null != i && n.onSelect(t({}, e, {
                    currentTarget: i
                }));
            });
        }
    }
});