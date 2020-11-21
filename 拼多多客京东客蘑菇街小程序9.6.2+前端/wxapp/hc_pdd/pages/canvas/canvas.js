Page({
    canvasIdErrorCallback: function(e) {
        console.error(e.detail.errMsg);
    },
    onReady: function(e) {
        var t = wx.createCanvasContext("firstCanvas");
        t.setStrokeStyle("#00ff00"), t.setLineWidth(5), t.rect(0, 0, 200, 200), t.stroke(), 
        t.setStrokeStyle("#ff0000"), t.setLineWidth(2), t.moveTo(160, 100), t.arc(100, 100, 60, 0, 2 * Math.PI, !0), 
        t.moveTo(140, 100), t.arc(100, 100, 40, 0, Math.PI, !1), t.moveTo(85, 80), t.arc(80, 80, 5, 0, 2 * Math.PI, !0), 
        t.moveTo(125, 80), t.arc(120, 80, 5, 0, 2 * Math.PI, !0), t.stroke(), t.draw();
    }
});