Object.defineProperty(exports, "__esModule", {
    value: !0
});

exports.button = Behavior({
    properties: {
        id: String,
        sessionFrom: String,
        appParameter: String,
        sendMessageImg: String,
        sendMessagePath: String,
        showMessageCard: String,
        sendMessageTitle: String,
        lang: {
            type: String,
            value: "en"
        }
    }
});