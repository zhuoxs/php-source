function o(o, t, r) {
    return t in o ? Object.defineProperty(o, t, {
        value: r,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : o[t] = r, o;
}

var t = require("../common/component"), r = require("../common/color"), e = {
    danger: r.RED,
    primary: r.BLUE,
    success: r.GREEN
};

(0, t.VantComponent)({
    props: {
        size: String,
        type: String,
        mark: Boolean,
        color: String,
        plain: Boolean,
        round: Boolean,
        textColor: String
    },
    computed: {
        style: function() {
            var t = this.data.color || e[this.data.type] || "#999", r = o({}, this.data.plain ? "color" : "background-color", t);
            return this.data.textColor && (r.color = this.data.textColor), Object.keys(r).map(function(o) {
                return o + ": " + r[o];
            }).join(";");
        }
    }
});