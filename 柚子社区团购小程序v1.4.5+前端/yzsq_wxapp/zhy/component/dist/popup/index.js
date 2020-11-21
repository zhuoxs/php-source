var _create = require("../common/create"), _transition = require("../mixins/transition");

(0, _create.create)({
    mixins: [ (0, _transition.transition)(!1) ],
    props: {
        transition: String,
        overlayStyle: String,
        overlay: {
            type: Boolean,
            value: !0
        },
        closeOnClickOverlay: {
            type: Boolean,
            value: !0
        },
        position: {
            type: String,
            value: "center"
        }
    },
    methods: {
        onClickOverlay: function() {
            this.$emit("click-overlay"), this.data.closeOnClickOverlay && this.$emit("close");
        }
    }
});