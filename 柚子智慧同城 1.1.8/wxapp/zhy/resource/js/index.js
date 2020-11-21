function e(e) {
    return Math.round(wx.getSystemInfoSync().windowWidth * e / 750);
}

var t = require("./barcode"), r = require("./qrcode");

module.exports = {
    barcode: function(r, n, o, c) {
        t.code128(wx.createCanvasContext(r), n, e(o), e(c));
    },
    qrcode: function(t, n, o, c) {
        r.api.draw(n, {
            ctx: wx.createCanvasContext(t),
            width: e(o),
            height: e(c)
        });
    }
};