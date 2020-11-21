(0, require("../common/component").VantComponent)({
    props: {
        show: Boolean,
        mask: Boolean,
        customStyle: String,
        zIndex: {
            type: Number,
            value: 1
        }
    },
    methods: {
        onClick: function() {
            this.$emit("click");
        },
        noop: function() {}
    }
});