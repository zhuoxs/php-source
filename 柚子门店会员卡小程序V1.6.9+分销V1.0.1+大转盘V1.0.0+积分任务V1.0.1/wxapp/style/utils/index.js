var barcode = require("./barcode"), qrcode = require("./qrcode");

function convert_length(e) {
    return Math.round(wx.getSystemInfoSync().windowWidth * e / 750);
}

function barc(e, r, t, c) {
    barcode.code128(wx.createCanvasContext(e), r, convert_length(t), convert_length(c));
}

function qrc(e, r, t, c) {
    qrcode.api.draw(r, {
        ctx: wx.createCanvasContext(e),
        width: convert_length(t),
        height: convert_length(c)
    });
}

module.exports = {
    barcode: barc,
    qrcode: qrc
};