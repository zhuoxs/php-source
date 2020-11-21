Component({
    behaviors: [ "wx://form-field" ],
    properties: {
        title: String,
        type: {
            type: String,
            value: "input"
        },
        disabled: Boolean,
        inputType: {
            type: String,
            value: "text"
        },
        placeholder: String,
        focus: Boolean,
        mode: {
            type: String,
            value: "normal"
        },
        right: Boolean,
        error: Boolean,
        maxlength: {
            type: Number,
            value: 140
        }
    },
    methods: {
        handleFieldChange: function(e) {
            var t = e.detail, i = (void 0 === t ? {} : t).value, n = void 0 === i ? "" : i;
            this.setData({
                value: n
            }), this.triggerEvent("change", e);
        },
        handleFieldFocus: function(e) {
            this.triggerEvent("focus", e);
        },
        handleFieldBlur: function(e) {
            this.triggerEvent("blur", e);
        }
    }
});