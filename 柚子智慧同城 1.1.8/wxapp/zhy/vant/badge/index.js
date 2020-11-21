(0, require("../common/component").VantComponent)({
    relation: {
        type: "ancestor",
        name: "badge-group"
    },
    props: {
        info: null,
        title: String
    },
    methods: {
        onClick: function() {
            var t = this.getRelationNodes("../badge-group/index")[0];
            t && t.setActive(this);
        },
        setActive: function(t) {
            this.set({
                active: t
            });
        }
    }
});