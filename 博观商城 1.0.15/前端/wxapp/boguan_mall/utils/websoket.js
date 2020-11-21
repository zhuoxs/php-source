var o = "ws://0.0.0.0:9010/ajaxchattest", n = !1;

module.exports = {
    connect: function(e, c) {
        wx.connectSocket({
            url: o,
            header: {
                "content-type": "application/json"
            },
            success: function(o) {
                console.log("信息通道连接成功", o);
            },
            fail: function(o) {
                console.log("信息通道连接失败", o);
            }
        }), wx.onSocketOpen(function(o) {
            console.log("信息通道已开通", o), n = !0;
        }), wx.onSocketError(function(o) {
            console.log("信息通道连接失败，请检查", o);
        }), wx.onSocketMessage(function(o) {
            c && c(o);
        });
    },
    send: function(o) {
        n && wx.sendSocketMessage({
            data: o
        });
    }
};