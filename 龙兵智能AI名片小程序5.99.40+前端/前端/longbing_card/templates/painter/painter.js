var _pen = require("./lib/pen"), _pen2 = _interopRequireDefault(_pen), _downloader = require("./lib/downloader"), _downloader2 = _interopRequireDefault(_downloader);

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

var util = require("./lib/util"), downloader = new _downloader2.default(), MAX_PAINT_COUNT = 5;

Component({
    canvasWidthInPx: 0,
    canvasHeightInPx: 0,
    paintCount: 0,
    properties: {
        customStyle: {
            type: String
        },
        palette: {
            type: Object,
            observer: function(t, e) {
                this.isNeedRefresh(t, e) && (this.paintCount = 0, this.startPaint());
            }
        }
    },
    data: {
        picURL: "",
        showCanvas: !0,
        painterStyle: ""
    },
    attached: function() {
        setStringPrototype();
    },
    methods: {
        isEmpty: function(t) {
            for (var e in t) return !1;
            return !0;
        },
        isNeedRefresh: function(t, e) {
            return !(!t || this.isEmpty(t));
        },
        startPaint: function() {
            var i = this;
            if (!this.isEmpty(this.properties.palette)) {
                if (!getApp().systemInfo || !getApp().systemInfo.screenWidth) try {
                    getApp().systemInfo = wx.getSystemInfoSync();
                } catch (t) {
                    var e = "Painter get system info failed, " + JSON.stringify(t);
                    return that.triggerEvent("imgErr", {
                        error: e
                    }), void console.error(e);
                }
                screenK = getApp().systemInfo.screenWidth / 750, this.downloadImages().then(function(t) {
                    var e = t.width, n = t.height;
                    if (i.canvasWidthInPx = e.toPx(), i.canvasHeightInPx = n.toPx(), e && n) {
                        i.setData({
                            painterStyle: "width:" + e + ";height:" + n + ";"
                        });
                        var r = wx.createCanvasContext("k-canvas", i);
                        new _pen2.default(r, t).paint(function() {
                            i.saveImgToLocal();
                        });
                    } else console.error("You should set width and height correctly for painter, width: " + e + ", height: " + n);
                });
            }
        },
        downloadImages: function() {
            var l = this;
            return new Promise(function(n, t) {
                var r = 0, i = 0, o = JSON.parse(JSON.stringify(l.properties.palette));
                if (o.background && (r++, downloader.download(o.background).then(function(t) {
                    o.background = t, r === ++i && n(o);
                }, function() {
                    r === ++i && n(o);
                })), o.views) {
                    var e = !0, a = !1, s = void 0;
                    try {
                        for (var c, u = function() {
                            var e = c.value;
                            e && "image" === e.type && e.url && (r++, downloader.download(e.url).then(function(t) {
                                e.url = t, wx.getImageInfo({
                                    src: e.url,
                                    success: function(t) {
                                        e.sWidth = t.width, e.sHeight = t.height;
                                    },
                                    fail: function(t) {
                                        console.error("getImageInfo failed, " + JSON.stringify(t));
                                    },
                                    complete: function() {
                                        r === ++i && n(o);
                                    }
                                });
                            }, function() {
                                r === ++i && n(o);
                            }));
                        }, f = o.views[Symbol.iterator](); !(e = (c = f.next()).done); e = !0) u();
                    } catch (t) {
                        a = !0, s = t;
                    } finally {
                        try {
                            !e && f.return && f.return();
                        } finally {
                            if (a) throw s;
                        }
                    }
                }
                0 === r && n(o);
            });
        },
        saveImgToLocal: function() {
            var t = this, e = this;
            setTimeout(function() {
                wx.canvasToTempFilePath({
                    canvasId: "k-canvas",
                    success: function(t) {
                        e.getImageInfo(t.tempFilePath);
                    },
                    fail: function(t) {
                        console.error("canvasToTempFilePath failed, " + JSON.stringify(t)), e.triggerEvent("imgErr", {
                            error: t
                        });
                    }
                }, t);
            }, 300);
        },
        getImageInfo: function(n) {
            var r = this;
            wx.getImageInfo({
                src: n,
                success: function(t) {
                    if (r.paintCount > MAX_PAINT_COUNT) {
                        var e = "The result is always fault, even we tried " + MAX_PAINT_COUNT + " times";
                        return console.error(e), void r.triggerEvent("imgErr", {
                            error: e
                        });
                    }
                    Math.abs((t.width * r.canvasHeightInPx - r.canvasWidthInPx * t.height) / (t.height * r.canvasHeightInPx)) < .01 ? r.triggerEvent("imgOK", {
                        path: n
                    }) : r.startPaint(), r.paintCount++;
                },
                fail: function(t) {
                    console.error("getImageInfo failed, " + JSON.stringify(t)), r.triggerEvent("imgErr", {
                        error: t
                    });
                }
            });
        }
    }
});

var screenK = .5;

function setStringPrototype() {
    String.prototype.toPx = function(t) {
        var e = (t ? /^-?[0-9]+([.]{1}[0-9]+){0,1}(rpx|px)$/g : /^[0-9]+([.]{1}[0-9]+){0,1}(rpx|px)$/g).exec(this);
        if (!this || !e) return console.error("The size: " + this + " is illegal"), 0;
        var n = e[2], r = parseFloat(this), i = 0;
        return "rpx" === n ? i = Math.round(r * screenK) : "px" === n && (i = r), i;
    };
}