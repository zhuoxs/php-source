Component({
    properties: {
        checked: {
            type: Boolean,
            value: !1
        },
        loading: {
            type: Boolean,
            value: !1
        },
        disabled: {
            type: Boolean,
            value: !1
        }
    },
    methods: {
        handleZanSwitchChange: function() {
            if (!this.data.loading && !this.data.disabled) {
                var e = !this.data.checked;
                this.triggerEvent("change", {
                    checked: e,
                    loading: this.data.loading
                });
            }
        }
    }
});