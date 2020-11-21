var t = require("../common/component"), a = require("../mixins/touch");

(0, t.VantComponent)({
    mixins: [ a.touch ],
    props: {
        disabled: Boolean,
        useButtonSlot: Boolean,
        activeColor: String,
        inactiveColor: String,
        max: {
            type: Number,
            value: 100
        },
        min: {
            type: Number,
            value: 0
        },
        step: {
            type: Number,
            value: 1
        },
        value: {
            type: Number,
            value: 0
        },
        barHeight: {
            type: String,
            value: "2px"
        }
    },
    watch: {
        value: function(t) {
            this.updateValue(t, !1);
        }
    },
    created: function() {
        this.updateValue(this.data.value);
    },
    methods: {
        onTouchStart: function(t) {
            this.data.disabled || (this.touchStart(t), this.startValue = this.format(this.data.value));
        },
        onTouchMove: function(t) {
            var a = this;
            this.data.disabled || (this.touchMove(t), this.getRect(".van-slider").then(function(t) {
                var e = a.deltaX / t.width * 100;
                a.updateValue(a.startValue + e, !1, !0);
            }));
        },
        onTouchEnd: function() {
            this.data.disabled || this.updateValue(this.data.value, !0);
        },
        onClick: function(t) {
            var a = this;
            this.data.disabled || this.getRect(function(e) {
                var i = (t.detail.x - e.left) / e.width * 100;
                a.updateValue(i, !0);
            });
        },
        updateValue: function(t, a, e) {
            t = this.format(t), this.set({
                value: t,
                barStyle: "width: " + t + "%; height: " + this.data.barHeight + ";"
            }), e && this.$emit("drag", {
                value: t
            }), a && this.$emit("change", t);
        },
        format: function(t) {
            var a = this.data, e = a.max, i = a.min, u = a.step;
            return Math.round(Math.max(i, Math.min(t, e)) / u) * u;
        }
    }
});