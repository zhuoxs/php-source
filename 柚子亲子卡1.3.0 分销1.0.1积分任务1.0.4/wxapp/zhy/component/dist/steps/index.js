var _create = require("../common/create");

(0, _create.create)({
    props: {
        icon: String,
        steps: {
            type: Array,
            observer: "formatSteps"
        },
        active: {
            type: Number,
            observer: "formatSteps"
        },
        direction: {
            type: String,
            value: "horizontal"
        },
        activeColor: {
            type: String,
            value: "#06bf04"
        }
    },
    attached: function() {
        this.formatSteps();
    },
    methods: {
        formatSteps: function() {
            var r = this, t = this.data.steps;
            t.forEach(function(t, e) {
                t.status = r.getStatus(e);
            }), this.setData({
                steps: t
            });
        },
        getStatus: function(t) {
            var e = this.data.active;
            return t < e ? "finish" : t === e ? "process" : "";
        }
    }
});