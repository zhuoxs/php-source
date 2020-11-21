var i = require("../mixins/link");

(0, require("../common/component").VantComponent)({
    classes: [ "title-class", "label-class", "value-class", "right-icon-class" ],
    mixins: [ i.link ],
    props: {
        title: null,
        value: null,
        icon: String,
        size: String,
        label: String,
        center: Boolean,
        isLink: Boolean,
        required: Boolean,
        clickable: Boolean,
        titleWidth: String,
        customStyle: String,
        arrowDirection: String,
        border: {
            type: Boolean,
            value: !0
        }
    },
    methods: {
        onClick: function(i) {
            this.$emit("click", i.detail), this.jumpLink();
        }
    }
});