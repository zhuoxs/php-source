module.exports = Behavior({
    properties: {
        loading: Boolean,
        openType: String,
        appParameter: String,
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
        },
        sendMessageTitle: String,
        sendMessagePath: String,
        sendMessageImg: String,
        showMessageCard: String
    },
    methods: {
        bindgetuserinfo: function() {
            var e = (0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {}).detail, t = void 0 === e ? {} : e;
            this.triggerEvent("getuserinfo", t);
        },
        bindcontact: function() {
            var e = (0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {}).detail, t = void 0 === e ? {} : e;
            this.triggerEvent("contact", t);
        },
        bindgetphonenumber: function() {
            var e = (0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {}).detail, t = void 0 === e ? {} : e;
            this.triggerEvent("getphonenumber", t);
        },
        binderror: function() {
            var e = (0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {}).detail, t = void 0 === e ? {} : e;
            this.triggerEvent("error", t);
        }
    }
});