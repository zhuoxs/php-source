var t = require("../common/component"), e = require("../common/color");

(0, t.VantComponent)({
    props: {
        icon: String,
        steps: Array,
        active: Number,
        direction: {
            type: String,
            value: "horizontal"
        },
        activeColor: {
            type: String,
            value: e.GREEN
        }
    },
    watch: {
        steps: "formatSteps",
        active: "formatSteps"
    },
    created: function() {
        this.formatSteps();
    },
    methods: {
        formatSteps: function() {
            var t = this, e = this.data.steps;
            e.forEach(function(e, s) {
                e.status = t.getStatus(s);
            }), this.set({
                steps: e
            });
        },
        getStatus: function(t) {
            var e = this.data.active;
            return t < e ? "finish" : t === e ? "process" : "";
        }
    }
});