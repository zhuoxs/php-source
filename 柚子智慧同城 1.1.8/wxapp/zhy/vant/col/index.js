(0, require("../common/component").VantComponent)({
    relation: {
        name: "row",
        type: "ancestor"
    },
    props: {
        span: Number,
        offset: Number
    },
    data: {
        style: ""
    },
    methods: {
        setGutter: function(t) {
            var e = t / 2 + "px", n = t ? "padding-left: " + e + "; padding-right: " + e + ";" : "";
            n !== this.data.style && this.set({
                style: n
            });
        }
    }
});