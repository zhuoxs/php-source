var _create = require("../common/create"), ITEM_HEIGHT = 44;

(0, _create.create)({
    props: {
        items: {
            type: Array,
            observer: function() {
                this.updateSubItems(), this.updateMainHeight();
            }
        },
        mainActiveIndex: {
            type: Number,
            value: 0,
            observer: "updateSubItems"
        },
        activeId: {
            type: Number,
            value: 0
        },
        maxHeight: {
            type: Number,
            value: 300,
            observer: function() {
                this.updateItemHeight(), this.updateMainHeight();
            }
        }
    },
    data: {
        subItems: [],
        mainHeight: 0,
        itemHeight: 0
    },
    methods: {
        onSelectItem: function(t) {
            this.$emit("click-item", t.currentTarget.dataset.item);
        },
        onClickNav: function(t) {
            var e = t.currentTarget.dataset.index;
            this.$emit("click-nav", {
                index: e
            });
        },
        updateSubItems: function() {
            var t = this.data.items[this.data.mainActiveIndex] || {};
            this.setData({
                subItems: t.children || []
            }), this.updateItemHeight();
        },
        updateMainHeight: function() {
            var t = Math.max(this.data.items.length * ITEM_HEIGHT, this.data.subItems.length * ITEM_HEIGHT);
            this.setData({
                mainHeight: Math.min(t, this.data.maxHeight)
            });
        },
        updateItemHeight: function() {
            this.setData({
                itemHeight: Math.min(this.data.subItems.length * ITEM_HEIGHT, this.data.maxHeight)
            });
        }
    }
});