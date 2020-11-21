Object.defineProperty(exports, "__esModule", {
    value: !0
});

var button = exports.button = Behavior({
    properties: {
        loading: Boolean,
        openType: String,
        appParameter: String,
        sendMessageTitle: String,
        sendMessagePath: String,
        sendMessageImg: String,
        showMessageCard: String,
        hoverStopPropagation: Boolean,
        hoverStartTime: {
            type: Number,
            value: 20
        },
        hoverStayTime: {
            type: Number,
            value: 70
        },
        lang: {
            type: String,
            value: "en"
        },
        sessionFrom: {
            type: String,
            value: ""
        }
    },
    methods: {
        bindgetuserinfo: function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
            this.$emit("getuserinfo", e.detail);
        },
        bindcontact: function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
            this.$emit("contact", e.detail);
        },
        bindgetphonenumber: function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
            this.$emit("getphonenumber", e.detail);
        },
        bindopensetting: function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
            this.$emit("opensetting", e.detail);
        },
        binderror: function() {
            var e = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
            this.$emit("error", e.detail);
        }
    }
});