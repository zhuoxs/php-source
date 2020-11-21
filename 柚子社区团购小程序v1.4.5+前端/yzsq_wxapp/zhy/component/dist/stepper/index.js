var _create = require("../common/create"), MAX = 2147483647;

(0, _create.create)({
    field: !0,
    classes: [ "input-class", "plus-class", "minus-class" ],
    props: {
        integer: Boolean,
        disabled: Boolean,
        disableInput: Boolean,
        min: {
            type: null,
            value: 1
        },
        max: {
            type: null,
            value: MAX
        },
        step: {
            type: null,
            value: 1
        }
    },
    attached: function() {
        this.setData({
            value: this.range(this.data.value)
        });
    },
    methods: {
        range: function(t) {
            return Math.max(Math.min(this.data.max, t), this.data.min);
        },
        onInput: function(t) {
            var a = (t.detail || {}).value, e = void 0 === a ? "" : a;
            this.triggerInput(e);
        },
        onChange: function(t) {
            if (this[t + "Disabled"]) this.$emit("overlimit", t); else {
                var a = "minus" === t ? -this.data.step : +this.data.step, e = Math.round(100 * (this.data.value + a)) / 100;
                this.triggerInput(this.range(e)), this.$emit(t);
            }
        },
        onBlur: function(t) {
            var a = this.range(this.data.value);
            this.triggerInput(a), this.$emit("blur", t);
        },
        onMinus: function() {
            this.onChange("minus");
        },
        onPlus: function() {
            this.onChange("plus");
        },
        triggerInput: function(t) {
            this.setData({
                value: t
            }), this.$emit("change", t);
        }
    }
});