function t(t, i) {
    if (!(t instanceof i)) throw new TypeError("Cannot call a class as a function");
}

Object.defineProperty(exports, "__esModule", {
    value: !0
});

var i = function() {
    function t(t, i) {
        for (var a = 0; a < i.length; a++) {
            var s = i[a];
            s.enumerable = s.enumerable || !1, s.configurable = !0, "value" in s && (s.writable = !0), 
            Object.defineProperty(t, s.key, s);
        }
    }
    return function(i, a, s) {
        return a && t(i.prototype, a), s && t(i, s), i;
    };
}(), a = function() {
    function a(i, s) {
        t(this, a), this.page = i, this.canvasWidth = s.canvasWidth, this.canvasHeight = s.canvasHeight, 
        this.imageResource = s.imageResource, this.maskColor = s.maskColor, this.r = s.r || 4, 
        this.endCallBack = s.callback, this.lastX = 0, this.lastY = 0, this.minX = "", this.minY = "", 
        this.maxX = "", this.maxY = "", this.isStart = !1, this.init(), this.page.touchStart = this.touchStart.bind(this), 
        this.page.touchMove = this.touchMove.bind(this), this.page.touchEnd = this.touchEnd.bind(this), 
        this.page.imgOnLoad = this.imgOnLoad.bind(this), console.log(this.page.data), this.page.setData({
            scratch: {
                awardTxtStyle: s.awardTxtStyle,
                awardTxt: s.awardTxt,
                awardTxtColor: s.awardTxtColor,
                awardTxtFontSize: s.awardTxtFontSize,
                awardTxtLineHeight: s.canvasHeight,
                awardImage: s.awardImage,
                width: s.canvasWidth,
                height: s.canvasHeight,
                imageResource: s.imageResource
            },
            isScroll: !0,
            awardShow: !1
        });
    }
    return i(a, [ {
        key: "init",
        value: function() {
            var t = this.canvasWidth, i = this.canvasHeight, a = this.imageResource, s = this.maskColor, e = this;
            this.ctx = wx.createCanvasContext("scratch"), this.ctx.clearRect(0, 0, t, i), a && "" != a ? wx.downloadFile({
                url: a,
                success: function(a) {
                    e.ctx.drawImage(a.tempFilePath, 0, 0, t, i), e.ctx.draw(), setTimeout(function() {
                        e.page.setData({
                            awardShow: !0
                        });
                    }, 200);
                }
            }) : (e.ctx.setFillStyle(s), e.ctx.fillRect(0, 0, t, i), e.ctx.draw(), setTimeout(function() {
                e.page.setData({
                    awardShow: !0
                });
            }, 200));
        }
    }, {
        key: "drawRect",
        value: function(t, i) {
            var a = this.r, s = (this.canvasWidth, this.canvasHeight, this.lastX, this.lastY, 
            this.minX), e = this.minY, h = this.maxX, n = this.maxY, c = t - a > 0 ? t - a : 0, r = i - a > 0 ? i - a : 0;
            return "" != s ? (this.minX = s > c ? c : s, this.minY = e > r ? r : e, this.maxX = h > c ? h : c, 
            this.maxY = n > r ? n : r) : (this.minX = c, this.minY = r, this.maxX = c, this.maxY = r), 
            this.lastX = c, this.lastY = r, [ c, r, 2 * a ];
        }
    }, {
        key: "start",
        value: function() {
            this.isStart = !0, this.page.setData({
                isScroll: !1
            });
        }
    }, {
        key: "restart",
        value: function() {
            this.init(), this.lastX = 0, this.lastY = 0, this.minX = "", this.minY = "", this.maxX = "", 
            this.maxY = "", this.isStart = !0, this.page.setData({
                isScroll: !1
            });
        }
    }, {
        key: "touchStart",
        value: function(t) {
            if (this.isStart) {
                var i = this.drawRect(t.touches[0].x, t.touches[0].y);
                this.ctx.clearRect(i[0], i[1], i[2], i[2]), this.ctx.draw(!0);
            }
        }
    }, {
        key: "touchMove",
        value: function(t) {
            if (this.isStart) {
                var i = this.drawRect(t.touches[0].x, t.touches[0].y);
                this.ctx.clearRect(i[0], i[1], i[2], i[2]), this.ctx.draw(!0);
            }
        }
    }, {
        key: "touchEnd",
        value: function(t) {
            if (this.isStart) {
                var i = this.canvasWidth, a = this.canvasHeight, s = this.minX, e = this.minY, h = this.maxX, n = this.maxY;
                h - s > .7 * i && n - e > .7 * a && (this.ctx.draw(), this.endCallBack && this.endCallBack(), 
                this.isStart = !1, this.page.setData({
                    isScroll: !0
                }));
            }
        }
    }, {
        key: "reset",
        value: function() {
            this.init();
        }
    }, {
        key: "imgOnLoad",
        value: function() {}
    } ]), a;
}();

exports.default = a;