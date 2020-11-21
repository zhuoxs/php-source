(0, require("../common/component").VantComponent)({
    field: !0,
    classes: [ "field-class", "input-class", "cancel-class" ],
    props: {
        focus: Boolean,
        error: Boolean,
        disabled: Boolean,
        readonly: Boolean,
        inputAlign: String,
        showAction: Boolean,
        useActionSlot: Boolean,
        placeholder: String,
        placeholderStyle: String,
        background: {
            type: String,
            value: "#f2f2f2"
        },
        maxlength: {
            type: Number,
            value: -1
        }
    },
    methods: {
        onChange: function(e) {
            this.set({
                value: e.detail
            }), this.$emit("change", e.detail);
        },
        onCancel: function() {
            this.set({
                value: ""
            }), this.$emit("cancel"), this.$emit("change", "");
        },
        onSearch: function() {
            this.$emit("search", this.data.value);
        },
        onFocus: function() {
            this.$emit("focus");
        },
        onBlur: function() {
            this.$emit("blur");
        },
        onClear: function() {
            this.$emit("clear");
        }
    }
});