(0, require("../common/component").VantComponent)({
    props: {
        show: Boolean,
        mask: Boolean,
        message: String,
        forbidClick: Boolean,
        zIndex: {
            type: Number,
            value: 1e3
        },
        type: {
            type: String,
            value: "text"
        },
        loadingType: {
            type: String,
            value: "circular"
        },
        position: {
            type: String,
            value: "middle"
        }
    },
    methods: {
        clear: function() {
            this.set({
                show: !1
            });
        },
        noop: function() {}
    }
});