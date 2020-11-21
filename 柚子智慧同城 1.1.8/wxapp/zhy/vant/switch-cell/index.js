(0, require("../common/component").VantComponent)({
    field: !0,
    props: {
        title: String,
        border: Boolean,
        checked: Boolean,
        loading: Boolean,
        disabled: Boolean,
        activeColor: String,
        inactiveColor: String,
        size: {
            type: String,
            value: "24px"
        }
    },
    watch: {
        checked: function(e) {
            this.set({
                value: e
            });
        }
    },
    created: function() {
        this.set({
            value: this.data.checked
        });
    },
    methods: {
        onChange: function(e) {
            this.$emit("change", e.detail);
        }
    }
});