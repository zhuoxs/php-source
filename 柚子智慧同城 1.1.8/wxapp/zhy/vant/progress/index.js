var t = require("../common/component"), o = require("../common/color");

(0, t.VantComponent)({
    props: {
        inactive: Boolean,
        percentage: Number,
        pivotText: String,
        pivotColor: String,
        showPivot: {
            type: Boolean,
            value: !0
        },
        color: {
            type: String,
            value: o.BLUE
        },
        textColor: {
            type: String,
            value: "#fff"
        }
    },
    data: {
        pivotWidth: 0,
        progressWidth: 0
    },
    watch: {
        pivotText: "getWidth",
        showPivot: "getWidth"
    },
    computed: {
        portionStyle: function() {
            return "width: " + ((this.data.progressWidth - this.data.pivotWidth) * this.data.percentage / 100 + "px") + "; background: " + this.getCurrentColor() + "; ";
        },
        pivotStyle: function() {
            return "color: " + this.data.textColor + "; background: " + (this.data.pivotColor || this.getCurrentColor());
        },
        text: function() {
            return this.data.pivotText || this.data.percentage + "%";
        }
    },
    mounted: function() {
        this.getWidth();
    },
    methods: {
        getCurrentColor: function() {
            return this.data.inactive ? "#cacaca" : this.data.color;
        },
        getWidth: function() {
            var t = this;
            this.getRect(".van-progress").then(function(o) {
                t.set({
                    progressWidth: o.width
                });
            }), this.getRect(".van-progress__pivot").then(function(o) {
                t.set({
                    pivotWidth: o.width || 0
                });
            });
        }
    }
});