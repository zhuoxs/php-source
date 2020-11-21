(0, require("../common/component").VantComponent)({
    field: !0,
    relation: {
        name: "checkbox",
        type: "descendant",
        linked: function(e) {
            var a = this.data, n = a.value, d = a.disabled;
            e.set({
                value: -1 !== n.indexOf(e.data.name),
                disabled: d || e.data.disabled
            });
        }
    },
    props: {
        max: Number,
        value: Array,
        disabled: Boolean
    },
    watch: {
        value: function(e) {
            this.getRelationNodes("../checkbox/index").forEach(function(a) {
                a.set({
                    value: -1 !== e.indexOf(a.data.name)
                });
            });
        },
        disabled: function(e) {
            this.getRelationNodes("../checkbox/index").forEach(function(a) {
                a.set({
                    disabled: e || a.data.disabled
                });
            });
        }
    }
});