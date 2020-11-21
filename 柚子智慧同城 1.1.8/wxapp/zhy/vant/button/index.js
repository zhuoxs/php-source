var e = require("../common/component"), o = require("../mixins/button"), n = require("../mixins/open-type");

(0, e.VantComponent)({
    classes: [ "loading-class" ],
    mixins: [ o.button, n.openType ],
    props: {
        plain: Boolean,
        block: Boolean,
        round: Boolean,
        square: Boolean,
        loading: Boolean,
        disabled: Boolean,
        type: {
            type: String,
            value: "default"
        },
        size: {
            type: String,
            value: "normal"
        }
    },
    methods: {
        onClick: function() {
            this.data.disabled || this.data.loading || this.$emit("click");
        }
    }
});