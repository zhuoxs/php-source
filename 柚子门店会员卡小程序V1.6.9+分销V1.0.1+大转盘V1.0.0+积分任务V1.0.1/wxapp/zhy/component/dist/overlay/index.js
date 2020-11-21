var _create = require("../common/create");

(0, _create.create)({
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
        }
    }
});