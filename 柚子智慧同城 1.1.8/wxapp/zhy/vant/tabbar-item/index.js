(0, require("../common/component").VantComponent)({
    props: {
        info: null,
        icon: String,
        dot: Boolean
    },
    relation: {
        name: "tabbar",
        type: "ancestor"
    },
    data: {
        active: !1
    },
    methods: {
        onClick: function() {
            var t = this.getRelationNodes("../tabbar/index")[0];
            t && t.onChange(this), this.$emit("click");
        },
        setActive: function(t) {
            var o = t.active, e = t.color;
            this.data.active !== o && this.set({
                active: o,
                color: e
            });
        }
    }
});