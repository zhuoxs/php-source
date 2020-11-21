var e = require("../common/component"), i = require("../mixins/transition"), t = require("../mixins/iphonex");

(0, e.VantComponent)({
    mixins: [ (0, i.transition)(!1), t.iphonex ],
    props: {
        transition: String,
        customStyle: String,
        overlayStyle: String,
        zIndex: {
            type: Number,
            value: 100
        },
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