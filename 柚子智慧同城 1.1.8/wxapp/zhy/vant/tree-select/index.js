(0, require("../common/component").VantComponent)({
    classes: [ "main-item-class", "content-item-class", "main-active-class", "content-active-class", "main-disabled-class", "content-disabled-class" ],
    props: {
        items: Array,
        mainActiveIndex: {
            type: Number,
            value: 0
        },
        activeId: {
            type: [ Number, String ]
        },
        maxHeight: {
            type: Number,
            value: 300
        }
    },
    data: {
        subItems: [],
        mainHeight: 0,
        itemHeight: 0
    },
    watch: {
        items: function() {
            this.updateSubItems(), this.updateMainHeight();
        },
        maxHeight: function() {
            this.updateItemHeight(), this.updateMainHeight();
        },
        mainActiveIndex: "updateSubItems"
    },
    methods: {
        onSelectItem: function(t) {
            var e = t.currentTarget.dataset.item;
            e.disabled || this.$emit("click-item", e);
        },
        onClickNav: function(t) {
            var e = t.currentTarget.dataset.index;
            this.data.items[e].disabled || this.$emit("click-nav", {
                index: e
            });
        },
        updateSubItems: function() {
            var t = this.data.items[this.data.mainActiveIndex] || {};
            this.set({
                subItems: t.children || []
            }), this.updateItemHeight();
        },
        updateMainHeight: function() {
            var t = Math.max(44 * this.data.items.length, 44 * this.data.subItems.length);
            this.set({
                mainHeight: Math.min(t, this.data.maxHeight)
            });
        },
        updateItemHeight: function() {
            this.set({
                itemHeight: Math.min(44 * this.data.subItems.length, this.data.maxHeight)
            });
        }
    }
});