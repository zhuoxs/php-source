(0, require("../common/component").VantComponent)({
    field: !0,
    classes: [ "input-class" ],
    props: {
        icon: String,
        label: String,
        error: Boolean,
        fixed: Boolean,
        focus: Boolean,
        center: Boolean,
        isLink: Boolean,
        leftIcon: String,
        disabled: Boolean,
        autosize: Boolean,
        readonly: Boolean,
        required: Boolean,
        iconClass: String,
        clearable: Boolean,
        inputAlign: String,
        customClass: String,
        confirmType: String,
        confirmHold: Boolean,
        errorMessage: String,
        placeholder: String,
        customStyle: String,
        useIconSlot: Boolean,
        useButtonSlot: Boolean,
        showConfirmBar: {
            type: Boolean,
            value: !0
        },
        placeholderStyle: String,
        adjustPosition: {
            type: Boolean,
            value: !0
        },
        cursorSpacing: {
            type: Number,
            value: 50
        },
        maxlength: {
            type: Number,
            value: -1
        },
        type: {
            type: String,
            value: "text"
        },
        border: {
            type: Boolean,
            value: !0
        },
        titleWidth: {
            type: String,
            value: "90px"
        }
    },
    data: {
        showClear: !1
    },
    beforeCreate: function() {
        this.focused = !1;
    },
    methods: {
        onInput: function(e) {
            var t = this, o = (e.detail || {}).value, i = void 0 === o ? "" : o;
            this.set({
                value: i,
                showClear: this.getShowClear(i)
            }, function() {
                t.emitChange(i);
            });
        },
        onFocus: function(e) {
            var t = e.detail || {}, o = t.value, i = void 0 === o ? "" : o, a = t.height, n = void 0 === a ? 0 : a;
            this.$emit("focus", {
                value: i,
                height: n
            }), this.focused = !0, this.blurFromClear = !1, this.set({
                showClear: this.getShowClear()
            });
        },
        onBlur: function(e) {
            var t = this, o = e.detail || {}, i = o.value, a = void 0 === i ? "" : i, n = o.cursor, l = void 0 === n ? 0 : n;
            this.$emit("blur", {
                value: a,
                cursor: l
            }), this.focused = !1;
            var r = this.getShowClear();
            this.data.value === a ? this.set({
                showClear: r
            }) : this.blurFromClear || this.set({
                value: a,
                showClear: r
            }, function() {
                t.emitChange(a);
            });
        },
        onClickIcon: function() {
            this.$emit("click-icon");
        },
        getShowClear: function(e) {
            return e = void 0 === e ? this.data.value : e, this.data.clearable && this.focused && e && !this.data.readonly;
        },
        onClear: function() {
            var e = this;
            this.blurFromClear = !0, this.set({
                value: "",
                showClear: this.getShowClear("")
            }, function() {
                e.emitChange(""), e.$emit("clear", "");
            });
        },
        onConfirm: function() {
            this.$emit("confirm", this.data.value);
        },
        emitChange: function(e) {
            this.$emit("input", e), this.$emit("change", e);
        }
    }
});