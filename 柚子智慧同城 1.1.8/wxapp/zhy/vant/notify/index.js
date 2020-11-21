var t = require("../common/component"), e = require("../common/color");

(0, t.VantComponent)({
    props: {
        text: String,
        color: {
            type: String,
            value: "#fff"
        },
        backgroundColor: {
            type: String,
            value: e.RED
        },
        duration: {
            type: Number,
            value: 3e3
        }
    },
    methods: {
        show: function() {
            var t = this, e = this.data.duration;
            clearTimeout(this.timer), this.set({
                show: !0
            }), e > 0 && e !== 1 / 0 && (this.timer = setTimeout(function() {
                t.hide();
            }, e));
        },
        hide: function() {
            clearTimeout(this.timer), this.set({
                show: !1
            });
        }
    }
});