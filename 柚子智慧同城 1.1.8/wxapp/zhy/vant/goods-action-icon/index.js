var i = require("../common/component"), n = require("../mixins/link"), t = require("../mixins/button"), e = require("../mixins/open-type");

(0, i.VantComponent)({
    mixins: [ n.link, t.button, e.openType ],
    props: {
        text: String,
        info: String,
        icon: String
    },
    methods: {
        onClick: function(i) {
            this.$emit("click", i.detail), this.jumpLink();
        }
    }
});