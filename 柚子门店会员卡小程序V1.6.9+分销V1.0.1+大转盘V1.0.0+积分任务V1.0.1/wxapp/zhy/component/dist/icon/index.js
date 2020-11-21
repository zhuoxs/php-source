var _create = require("../common/create");

(0, _create.create)({
    props: {
        info: null,
        name: String,
        size: String,
        color: String,
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