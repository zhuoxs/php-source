var VERY_LARGE_NUMBER = 2147483647;

Component({
    properties: {
        size: String,
        stepper: {
            type: Number,
            value: 1
        },
        min: {
            type: Number,
            value: 1
        },
        max: {
            type: Number,
            value: VERY_LARGE_NUMBER
        },
        step: {
            type: Number,
            value: 1
        }
    },
    methods: {
        handleZanStepperChange: function(e, t) {
            var n = e.currentTarget.dataset, a = (void 0 === n ? {} : n).disabled, i = this.data.step, r = this.data.stepper;
            return a ? null : ("minus" === t ? r -= i : "plus" === t && (r += i), r < this.data.min || r > this.data.max ? null : (this.triggerEvent("change", r), 
            void this.triggerEvent(t)));
        },
        handleZanStepperMinus: function(e) {
            this.handleZanStepperChange(e, "minus");
        },
        handleZanStepperPlus: function(e) {
            this.handleZanStepperChange(e, "plus");
        },
        handleZanStepperBlur: function(e) {
            var t = this, n = e.detail.value, a = this.data, i = a.min, r = a.max;
            n ? (r < (n = +n) ? n = r : n < i && (n = i), this.triggerEvent("change", n)) : setTimeout(function() {
                t.triggerEvent("change", i);
            }, 16);
        }
    }
});