var t = require("../common/component"), e = require("../mixins/iphonex");

(0, t.VantComponent)({
    mixins: [ e.iphonex ],
    classes: [ "bar-class", "price-class", "button-class" ],
    props: {
        tip: null,
        type: Number,
        price: null,
        label: String,
        loading: Boolean,
        disabled: Boolean,
        buttonText: String,
        currency: {
            type: String,
            value: "¥"
        },
        buttonType: {
            type: String,
            value: "danger"
        }
    },
    computed: {
        hasPrice: function() {
            return "number" == typeof this.data.price;
        },
        priceStr: function() {
            return (this.data.price / 100).toFixed(2);
        },
        tipStr: function() {
            var t = this.data.tip;
            return "string" == typeof t ? t : "";
        }
    },
    methods: {
        onSubmit: function(t) {
            this.$emit("submit", t.detail);
        }
    }
});