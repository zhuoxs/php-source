Object.defineProperty(exports, "__esModule", {
    value: !0
});

var _createClass = function() {
    function s(t, i) {
        for (var a = 0; a < i.length; a++) {
            var s = i[a];
            s.enumerable = s.enumerable || !1, s.configurable = !0, "value" in s && (s.writable = !0), 
            Object.defineProperty(t, s.key, s);
        }
    }
    return function(t, i, a) {
        return i && s(t.prototype, i), a && s(t, a), t;
    };
}();

function _classCallCheck(t, i) {
    if (!(t instanceof i)) throw new TypeError("Cannot call a class as a function");
}

var Scratch = function() {
    function a(t, i) {
        _classCallCheck(this, a), this.page = t, this.canvasWidth = i.canvasWidth, this.canvasHeight = i.canvasHeight, 
        this.imageResource = i.imageResource, this.maskColor = i.maskColor, this.r = i.r || 4, 
        this.endCallBack = i.callback, this.lastX = 0, this.lastY = 0, this.minX = "", this.minY = "", 
        this.maxX = "", this.maxY = "", this.isStart = !1, this.init(), this.page.touchStart = this.touchStart.bind(this), 
        this.page.touchMove = this.touchMove.bind(this), this.page.touchEnd = this.touchEnd.bind(this), 
        this.page.imgOnLoad = this.imgOnLoad.bind(this), this.page.setData({
            scratch: {
                awardTxt: i.awardTxt,
                awardTxtColor: i.awardTxtColor,
                awardTxtFontSize: i.awardTxtFontSize,
                awardTxtLineHeight: i.canvasHeight,
                width: i.canvasWidth,
                height: i.canvasHeight,
                imageResource: i.imageResource
            },
            isScroll: !0
        });
    }
    return _createClass(a, [ {
        key: "init",
        value: function() {
            var i = this.canvasWidth, a = this.canvasHeight, t = this.imageResource, s = this.maskColor, e = this;
            this.ctx = wx.createCanvasContext("scratch"), this.ctx.clearRect(0, 0, i, a), t && "" != t ? wx.downloadFile({
                url: t,
                success: function(t) {
                    e.ctx.drawImage(t.tempFilePath, 0, 0, i, a), e.ctx.draw();
                }
            }) : (e.ctx.setFillStyle(s), e.ctx.fillRect(0, 0, i, a), e.ctx.draw());
        }
    }, {
        key: "drawRect",
        value: function(t, i) {
            var a = this.r, s = (this.canvasWidth, this.canvasHeight, this.lastX, this.lastY, 
            this.minX), e = this.minY, h = this.maxX, c = this.maxY, n = 0 < t - a ? t - a : 0, r = 0 < i - a ? i - a : 0;
            return "" != s ? (this.minX = n < s ? n : s, this.minY = r < e ? r : e, this.maxX = n < h ? h : n, 
            this.maxY = r < c ? c : r) : (this.minX = n, this.minY = r, this.maxX = n, this.maxY = r), 
            [ this.lastX = n, this.lastY = r, 2 * a ];
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
                var i = this.canvasWidth, a = this.canvasHeight, s = this.minX, e = this.minY, h = this.maxX, c = this.maxY;
                .3 * i < h - s && .3 * a < c - e && (this.ctx.draw(), this.endCallBack && this.endCallBack(), 
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

exports.default = Scratch;