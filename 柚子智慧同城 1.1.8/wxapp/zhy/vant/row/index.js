(0, require("../common/component").VantComponent)({
    relation: {
        name: "col",
        type: "descendant",
        linked: function(t) {
            this.data.gutter && t.setGutter(this.data.gutter);
        }
    },
    props: {
        gutter: Number
    },
    watch: {
        gutter: "setGutter"
    },
    mounted: function() {
        this.data.gutter && this.setGutter();
    },
    methods: {
        setGutter: function() {
            var t = this, e = this.data.gutter, n = "-" + Number(e) / 2 + "px", r = e ? "margin-right: " + n + "; margin-left: " + n + ";" : "";
            this.set({
                style: r
            }), this.getRelationNodes("../col/index").forEach(function(e) {
                e.setGutter(t.data.gutter);
            });
        }
    }
});