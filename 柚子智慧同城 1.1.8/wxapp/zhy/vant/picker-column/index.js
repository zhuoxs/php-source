var t = require("../common/component"), e = require("../common/utils");

(0, t.VantComponent)({
    classes: [ "active-class" ],
    props: {
        valueKey: String,
        className: String,
        itemHeight: Number,
        visibleItemCount: Number,
        initialOptions: {
            type: Array,
            value: []
        },
        defaultIndex: {
            type: Number,
            value: 0
        }
    },
    data: {
        startY: 0,
        offset: 0,
        duration: 0,
        startOffset: 0,
        options: [],
        currentIndex: 0
    },
    created: function() {
        var t = this, e = this.data, n = e.defaultIndex, i = e.initialOptions;
        this.set({
            currentIndex: n,
            options: i
        }, function() {
            t.setIndex(n);
        });
    },
    computed: {
        count: function() {
            return this.data.options.length;
        },
        baseOffset: function() {
            var t = this.data;
            return t.itemHeight * (t.visibleItemCount - 1) / 2;
        },
        wrapperStyle: function() {
            var t = this.data;
            return [ "transition: " + t.duration + "ms", "transform: translate3d(0, " + (t.offset + t.baseOffset) + "px, 0)", "line-height: " + t.itemHeight + "px" ].join("; ");
        }
    },
    watch: {
        defaultIndex: function(t) {
            this.setIndex(t);
        }
    },
    methods: {
        onTouchStart: function(t) {
            this.set({
                startY: t.touches[0].clientY,
                startOffset: this.data.offset,
                duration: 0
            });
        },
        onTouchMove: function(t) {
            var n = this.data, i = t.touches[0].clientY - n.startY;
            this.set({
                offset: (0, e.range)(n.startOffset + i, -n.count * n.itemHeight, n.itemHeight)
            });
        },
        onTouchEnd: function() {
            var t = this.data;
            if (t.offset !== t.startOffset) {
                this.set({
                    duration: 200
                });
                var n = (0, e.range)(Math.round(-t.offset / t.itemHeight), 0, t.count - 1);
                this.setIndex(n, !0);
            }
        },
        onClickItem: function(t) {
            var e = t.currentTarget.dataset.index;
            this.setIndex(e, !0);
        },
        adjustIndex: function(t) {
            for (var n = this.data, i = t = (0, e.range)(t, 0, n.count); i < n.count; i++) if (!this.isDisabled(n.options[i])) return i;
            for (var s = t - 1; s >= 0; s--) if (!this.isDisabled(n.options[s])) return s;
        },
        isDisabled: function(t) {
            return (0, e.isObj)(t) && t.disabled;
        },
        getOptionText: function(t) {
            var n = this.data;
            return (0, e.isObj)(t) && n.valueKey in t ? t[n.valueKey] : t;
        },
        setIndex: function(t, e) {
            var n = this, i = this.data, s = -(t = this.adjustIndex(t) || 0) * i.itemHeight;
            return t !== i.currentIndex ? this.set({
                offset: s,
                currentIndex: t
            }).then(function() {
                e && n.$emit("change", t);
            }) : this.set({
                offset: s
            });
        },
        setValue: function(t) {
            for (var e = this.data.options, n = 0; n < e.length; n++) if (this.getOptionText(e[n]) === t) return this.setIndex(n);
            return Promise.resolve();
        },
        getValue: function() {
            var t = this.data;
            return t.options[t.currentIndex];
        }
    }
});