var t = require("../common/component"), i = require("../mixins/touch");

(0, t.VantComponent)({
    props: {
        disabled: Boolean,
        leftWidth: {
            type: Number,
            value: 0
        },
        rightWidth: {
            type: Number,
            value: 0
        },
        asyncClose: Boolean
    },
    mixins: [ i.touch ],
    data: {
        offset: 0,
        draging: !1
    },
    computed: {
        wrapperStyle: function() {
            var t = this.data, i = "translate3d(" + t.offset + "px, 0, 0)", e = t.draging ? "none" : ".6s cubic-bezier(0.18, 0.89, 0.32, 1)";
            return "\n        -webkit-transform: " + i + ";\n        -webkit-transition: " + e + ";\n        transform: " + i + ";\n        transition: " + e + ";\n      ";
        }
    },
    methods: {
        onTransitionend: function() {
            this.swipe = !1;
        },
        open: function(t) {
            var i = this.data, e = i.leftWidth, s = i.rightWidth, n = "left" === t ? e : -s;
            this.swipeMove(n), this.resetSwipeStatus();
        },
        close: function() {
            this.set({
                offset: 0
            });
        },
        resetSwipeStatus: function() {
            this.swiping = !1, this.opened = !0;
        },
        swipeMove: function(t) {
            void 0 === t && (t = 0), this.set({
                offset: t
            }), t && (this.swiping = !0), !t && (this.opened = !1);
        },
        swipeLeaveTransition: function(t) {
            var i = this.data, e = i.offset, s = i.leftWidth, n = i.rightWidth, o = this.opened ? .85 : .15;
            t > 0 && -e > n * o && n > 0 ? this.open("right") : t < 0 && e > s * o && s > 0 ? this.open("left") : this.swipeMove();
        },
        startDrag: function(t) {
            this.data.disabled || (this.set({
                draging: !0
            }), this.touchStart(t), this.opened && (this.startX -= this.data.offset));
        },
        onDrag: function(t) {
            if (!this.data.disabled) {
                this.touchMove(t);
                var i = this.deltaX, e = this.data, s = e.leftWidth, n = e.rightWidth;
                i < 0 && (-i > n || !n) || i > 0 && (i > s || i > 0 && !s) || "horizontal" === this.direction && this.swipeMove(i);
            }
        },
        endDrag: function() {
            this.data.disabled || (this.set({
                draging: !1
            }), this.swiping && this.swipeLeaveTransition(this.data.offset > 0 ? -1 : 1));
        },
        onClick: function(t) {
            var i = t.currentTarget.dataset.key, e = void 0 === i ? "outside" : i;
            this.$emit("click", e), this.data.offset && (this.data.asyncClose ? this.$emit("close", {
                position: e,
                instance: this
            }) : this.swipeMove(0));
        }
    }
});