var e = require("../common/component"), n = require("../mixins/iphonex");

(0, e.VantComponent)({
    mixins: [ n.iphonex ],
    props: {
        show: Boolean,
        title: String,
        cancelText: String,
        zIndex: {
            type: Number,
            value: 100
        },
        actions: {
            type: Array,
            value: []
        },
        overlay: {
            type: Boolean,
            value: !0
        },
        closeOnClickOverlay: {
            type: Boolean,
            value: !0
        }
    },
    methods: {
        onSelect: function(e) {
            var n = e.currentTarget.dataset.index, t = this.data.actions[n];
            !t || t.disabled || t.loading || this.$emit("select", t);
        },
        onCancel: function() {
            this.$emit("cancel");
        },
        onClose: function() {
            this.$emit("close");
        }
    }
});