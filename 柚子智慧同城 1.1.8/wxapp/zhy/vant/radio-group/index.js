(0, require("../common/component").VantComponent)({
    field: !0,
    relation: {
        name: "radio",
        type: "descendant",
        linked: function(e) {
            var a = this.data, d = a.value, i = a.disabled;
            e.set({
                value: d,
                disabled: i || e.data.disabled
            });
        }
    },
    props: {
        value: null,
        disabled: Boolean
    },
    watch: {
        value: function(e) {
            this.getRelationNodes("../radio/index").forEach(function(a) {
                a.set({
                    value: e
                });
            });
        },
        disabled: function(e) {
            this.getRelationNodes("../radio/index").forEach(function(a) {
                a.set({
                    disabled: e || a.data.disabled
                });
            });
        }
    }
});