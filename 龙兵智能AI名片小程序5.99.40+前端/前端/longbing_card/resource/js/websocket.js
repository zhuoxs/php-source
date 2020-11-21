Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _siteinfo = require("../../../siteinfo.js"), _siteinfo2 = _interopRequireDefault(_siteinfo), _xx_util = require("./xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

exports.default = {
    localSocket: null,
    limit: 0,
    timeout: 2e4,
    timeoutObj: null,
    serverTimeoutObj: null,
    isInitPage: !1,
    isLogin: !1,
    watcherList: [],
    reset: function() {
        return clearTimeout(this.timeoutObj), clearTimeout(this.serverTimeoutObj), this;
    },
    start: function() {
        var t = this;
        t.timeoutObj = setTimeout(function() {
            wx.sendSocketMessage({
                data: "78346+SJDHFA.longbing",
                success: function() {}
            }), t.serverTimeoutObj = setTimeout(function() {
                console.log("关闭"), wx.closeSocket();
            }, t.timeout);
        }, t.timeout);
    },
    connect: function() {
        var i = this;
        i.closeReconnect = !1, i.limit = 0;
        var t = "wss://" + _xx_util2.default.getHostname(_siteinfo2.default.siteroot) + "/wss";
        i.localSocket = wx.connectSocket({
            url: t
        }), i.localSocket.onMessage(function(t) {
            var e = JSON.parse(t.data);
            "78346+SJDHFA.longbing" == e.data ? i.reset().start() : i.getSocketMsg(e);
        }), i.localSocket.onOpen(function(t) {
            i.reset().start();
        }), i.localSocket.onError(function(t) {
            console.log(t, "onError"), i.reconnect();
        }), i.localSocket.onClose(function(t) {
            console.log(t, "onclose"), i.reconnect();
        });
    },
    reconnect: function() {
        console.log("WebSocket重连中...");
        var t = this;
        clearTimeout(t.timer), t.limit < 12 ? (t.timer = setTimeout(function() {
            t.connect();
        }, 5e3), t.limit++) : console.log("WebSocket连接失败！");
    },
    getSocketMsg: function(t) {
        var e = t.msg;
        this.publish(e, t);
    },
    sendMessage: function(t) {
        var o = this, e = _siteinfo2.default.uniacid;
        return t = Object.assign({}, t, {
            uniacid: e
        }), t = JSON.stringify(t), new Promise(function(e, i) {
            o.localSocket.send({
                data: t,
                success: function(t) {
                    e(t);
                },
                fail: function(t) {
                    i(t);
                }
            });
        });
    },
    subscribe: function(t, e) {
        this.watcherList[t] || (this.watcherList[t] = []), this.watcherList[t].push(e);
    },
    publish: function() {
        var t = arguments, e = [].shift.call(t), i = this.watcherList[e];
        if (!i || i.length <= 0) return !1;
        for (var o = 0, n = i.length; o < n; o++) i[o].apply(this, t);
    },
    unSubscribe: function(t) {
        delete this.watcherList[t];
    },
    unSubscribeLast: function(t) {
        this.watcherList[t].pop();
    }
};