(0, require("../common/component").VantComponent)({
    props: {
        info: null,
        name: String,
        size: String,
        color: String,
        customStyle: String,
        classPrefix: {
            type: String,
            value: "van-icon"
        }
    },
    methods: {
        onClick: function() {
            this.$emit("click");
        }
    }
});