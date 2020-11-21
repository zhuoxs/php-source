(0, require("../common/component").VantComponent)({
    relation: {
        name: "collapse-item",
        type: "descendant",
        linked: function(t) {
            this.set({
                items: [].concat(this.data.items, [ t ])
            }, function() {
                t.updateExpanded();
            });
        }
    },
    props: {
        accordion: Boolean,
        value: null
    },
    data: {
        items: []
    },
    watch: {
        value: function() {
            this.data.items.forEach(function(t) {
                t.updateExpanded();
            });
        },
        accordion: function() {
            this.data.items.forEach(function(t) {
                t.updateExpanded();
            });
        }
    },
    methods: {
        switch: function(t, n) {
            var a = this.data, e = a.accordion, i = a.value;
            t = e ? n ? t : "" : n ? i.concat(t) : i.filter(function(n) {
                return n !== t;
            }), this.$emit("change", t), this.$emit("input", t);
        }
    }
});