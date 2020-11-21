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
        showOverlay: {
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
            this.triggerEvent("clickmask", {});
        }
    }
});