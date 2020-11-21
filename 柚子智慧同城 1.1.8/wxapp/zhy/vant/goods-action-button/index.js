var i = require("../common/component"), e = require("../mixins/link"), n = require("../mixins/button"), t = require("../mixins/open-type");

(0, i.VantComponent)({
    mixins: [ e.link, n.button, t.openType ],
    props: {
        text: String,
        loading: Boolean,
        disabled: Boolean,
        type: {
            type: String,
            value: "danger"
        }
    },
    methods: {
        onClick: function(i) {
            this.$emit("click", i.detail), this.jumpLink();
        }
    }
});