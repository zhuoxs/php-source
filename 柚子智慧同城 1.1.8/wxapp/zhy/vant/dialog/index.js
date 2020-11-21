function n(n, o, e) {
    return o in n ? Object.defineProperty(n, o, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : n[o] = e, n;
}

var o = require("../common/component"), e = require("../mixins/open-type");

(0, o.VantComponent)({
    mixins: [ e.openType ],
    props: {
        show: Boolean,
        title: String,
        message: String,
        useSlot: Boolean,
        asyncClose: Boolean,
        messageAlign: String,
        showCancelButton: Boolean,
        closeOnClickOverlay: Boolean,
        confirmButtonOpenType: String,
        zIndex: {
            type: Number,
            value: 100
        },
        confirmButtonText: {
            type: String,
            value: "确认"
        },
        cancelButtonText: {
            type: String,
            value: "取消"
        },
        showConfirmButton: {
            type: Boolean,
            value: !0
        },
        overlay: {
            type: Boolean,
            value: !0
        },
        transition: {
            type: String,
            value: "scale"
        }
    },
    data: {
        loading: {
            confirm: !1,
            cancel: !1
        }
    },
    watch: {
        show: function(n) {
            !n && this.stopLoading();
        }
    },
    methods: {
        onConfirm: function() {
            this.handleAction("confirm");
        },
        onCancel: function() {
            this.handleAction("cancel");
        },
        onClickOverlay: function() {
            this.onClose("overlay");
        },
        handleAction: function(o) {
            this.data.asyncClose && this.set(n({}, "loading." + o, !0)), this.onClose(o);
        },
        close: function() {
            this.set({
                show: !1
            });
        },
        stopLoading: function() {
            this.set({
                loading: {
                    confirm: !1,
                    cancel: !1
                }
            });
        },
        onClose: function(n) {
            this.data.asyncClose || this.close(), this.$emit("close", n), this.$emit(n, {
                dialog: this
            });
            var o = this.data["confirm" === n ? "onConfirm" : "onCancel"];
            o && o(this);
        }
    }
});