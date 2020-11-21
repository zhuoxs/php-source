var app = getApp();

Page({
    data: {
        jiluArr: [ {
            time: "29",
            time1: "四月",
            money: "12154.12",
            index: "000"
        } ]
    },
    onLoad: function(t) {
        var e = this, o = t.docmoney, a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        }), e.setData({
            bgc: a,
            docmoney: o
        });
        var n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Doctormoney",
            data: {
                openid: n
            },
            success: function(t) {
                console.log(t), e.setData({
                    shouru: t.data.data.d_txmoney
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    createNewImg: function() {
        var t = this, e = t.data.widths, o = t.data.heights, a = t.data.bgc, n = wx.createCanvasContext("line");
        console.log(n), n.setFillStyle(a), n.fillRect(0, 0, e, o), console.log(n);
        var i = [ "200", "150", "80", "0", "200", "0", "200" ];
        n.setLineWidth(.0053 * e), n.setStrokeStyle("#ffffff");
        for (var s = 0; s < i.length; s++) 0 == s ? (n.moveTo(.116 * e + .096 * e * s, .42 * o - i[s] / 4), 
        n.lineTo(.116 * e + .096 * e * s, .42 * o - i[s] / 4)) : (i.length, n.moveTo(.116 * e + .096 * e * s, .42 * o - i[s - 1] / 4), 
        n.lineTo(.116 * e + .096 * e * (s + 1), .42 * o - i[s] / 4)), n.stroke();
        for (var r = "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/canvas_cir_01.png", c = "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/canvas_cir_02.png", l = 0; l < i.length; l++) i[l + 1] > i[l] ? 0 == l ? n.drawImage(r, .116 * e + .096 * e * (l + 1) - .042 * e, .42 * o - i[l] / 4 - .048 * e) : l == i.length - 1 ? n.drawImage(c, .116 * e + .096 * e * (l + 1) - .042 * e, .42 * o - i[l] / 4 - .048 * e) : n.drawImage(r, .116 * e + .096 * e * (l + 1) - .042 * e, .42 * o - i[l] / 4 - .048 * e) : 0 == l ? n.drawImage(r, .116 * e + .096 * e * (l + 1) - .042 * e, .42 * o - i[l] / 4 - .038 * e) : l == i.length - 1 ? n.drawImage(c, .116 * e + .096 * e * (l + 1) - .042 * e, .42 * o - i[l] / 4 - .038 * e) : n.drawImage(r, .116 * e + .096 * e * (l + 1) - .042 * e, .42 * o - i[l] / 4 - .038 * e);
        n.font = "方正兰亭细黑_GBK", n.setTextAlign("center"), n.fillStyle = "#fff", n.setFontSize(28);
        var g = i = t.data.docmoney, d = n.measureText(g).width;
        n.fillText(g, .5 * e, .7 * o);
        n.setFontSize(15);
        var f = n.measureText("元").width;
        n.fillText("元", .5 * e + .5 * d + .5 * f, .7 * o), n.draw();
    },
    onReady: function() {
        var a = this;
        wx.getSystemInfo({
            success: function(t) {
                var e = t.windowWidth, o = 384 * (e / 750);
                a.setData({
                    widths: e,
                    heights: o
                });
            }
        }), a.createNewImg(), console.log(a.data.widths, a.data.heights);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});