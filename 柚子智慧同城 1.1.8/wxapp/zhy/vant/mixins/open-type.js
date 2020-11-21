Object.defineProperty(exports, "__esModule", {
    value: !0
});

exports.openType = Behavior({
    properties: {
        openType: String
    },
    methods: {
        bindGetUserInfo: function(e) {
            this.$emit("getuserinfo", e.detail);
        },
        bindContact: function(e) {
            this.$emit("contact", e.detail);
        },
        bindGetPhoneNumber: function(e) {
            this.$emit("getphonenumber", e.detail);
        },
        bindOpenSetting: function(e) {
            this.$emit("opensetting", e.detail);
        },
        bindError: function(e) {
            this.$emit("error", e.detail);
        }
    }
});