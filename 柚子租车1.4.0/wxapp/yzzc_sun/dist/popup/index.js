Component({
    properties: {
        show: {
            type: Boolean,
            value: !1
        },
        overlay: {
            type: Boolean,
            value: !0
        },
        closeOnClickOverlay: {
            type: Boolean,
            value: !0
        },
        type: {
            type: String,
            value: "center"
        }
    },
    methods: {
        handleMaskClick: function() {
            this.triggerEvent("click-overlay", {}), this.data.closeOnClickOverlay && this.triggerEvent("close", {});
        }
    }
});