var _create = require("../common/create");

(0, _create.create)({
    props: {
        show: Boolean,
        title: String,
        cancelText: String,
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
            var t = e.currentTarget.dataset.index, a = this.data.actions[t];
            !a || a.disabled || a.loading || this.$emit("select", a);
        },
        onCancel: function() {
            this.$emit("cancel");
        },
        onClose: function() {
            this.$emit("close");
        }
    }
});