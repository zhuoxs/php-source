function t(t) {
    return new Promise(function(i, e) {
        wx.getImageInfo({
            src: t,
            success: function(t) {
                i(t.path);
            }
        });
    });
}

function i(t, i, e, a, s, r, n) {
    t.beginPath(), t.setFillStyle(n), t.arc(i + r, e + r, r, Math.PI, 1.5 * Math.PI), 
    t.moveTo(i + r, e), t.lineTo(i + a - r, e), t.lineTo(i + a, e + r), t.arc(i + a - r, e + r, r, 1.5 * Math.PI, 2 * Math.PI), 
    t.lineTo(i + a, e + s - r), t.lineTo(i + a - r, e + s), t.arc(i + a - r, e + s - r, r, 0, .5 * Math.PI), 
    t.lineTo(i + r, e + s), t.lineTo(i, e + s - r), t.arc(i + r, e + s - r, r, .5 * Math.PI, Math.PI), 
    t.lineTo(i, e + r), t.lineTo(i + r, e), t.fill(), t.closePath();
}

var e = getApp();

Component({
    data: {
        avatar: "",
        banner: "",
        qr: "",
        img: [],
        show: !0
    },
    properties: {
        load: {
            type: Boolean,
            value: !1,
            observer: function(t, i, e) {
                t && (this.data.posterInfo.is_pic && 2 != this.data.posterInfo.style ? (console.log(1), 
                this.startCreatImg()) : (console.log(2), this.startCreat()));
            }
        },
        posterInfo: {
            type: Object,
            value: {
                delRoot: "",
                bg: "",
                img: "",
                avatar: "",
                qr: "",
                title: "",
                price: "",
                name: "",
                hot: "",
                style: ""
            },
            observer: function(t, i, e) {}
        }
    },
    ready: function() {},
    methods: {
        startCreatImg: function() {
            var i = this, a = [ t(this.data.posterInfo.qr), t(this.data.posterInfo.is_pic) ];
            Promise.all(a).then(function(t) {
                i.setData({
                    qr: t[0],
                    is_pic: t[1]
                }), e.api.apiDeleteQRCode({
                    path: i.data.posterInfo.delRoot
                }).then(function(t) {
                    wx.showLoading({
                        title: "海报生成中..."
                    });
                }).catch(function(t) {
                    wx.showLoading({
                        title: "海报生成中..."
                    });
                }), i.drawPosterImg(t);
            });
        },
        drawPosterImg: function(t) {
            var i = this, e = wx.createCanvasContext("poster", this);
            this.data.is_pic ? e.drawImage(this.data.is_pic, 0, 0, 750, 1330) : (e.setFillStyle("#f9f3e0"), 
            e.fillRect(0, 0, 750, 1330)), e.drawImage(this.data.qr, 480, 1060, 195, 195), e.draw(), 
            setTimeout(function() {
                i.createPoster();
            }, 500);
        },
        startCreat: function() {
            var i = this, a = [];
            a = "" == this.data.posterInfo.bg ? [ t(this.data.posterInfo.img), t(this.data.posterInfo.avatar), t(this.data.posterInfo.qr) ] : [ t(this.data.posterInfo.img), t(this.data.posterInfo.avatar), t(this.data.posterInfo.qr), t(this.data.posterInfo.bg) ], 
            Promise.all(a).then(function(t) {
                i.setData({
                    img: t[0],
                    avatar: t[1],
                    qr: t[2]
                }), t[3] && i.setData({
                    bg: t[3]
                }), e.api.apiDeleteQRCode({
                    path: i.data.posterInfo.delRoot
                }).then(function(t) {
                    wx.showLoading({
                        title: "海报生成中..."
                    });
                }).catch(function(t) {
                    wx.showLoading({
                        title: "海报生成中..."
                    });
                }), i.drawPoster(t);
            });
        },
        drawPoster: function(t) {
            var e = this, a = wx.createCanvasContext("poster", this);
            this.data.bg ? a.drawImage(this.data.bg, 0, 0, 750, 1330) : (a.setFillStyle("#f9f3e0"), 
            a.fillRect(0, 0, 750, 1330)), i(a, 40, 150, 670, 795, 10, "#fff"), a.save(), a.beginPath(), 
            i(a, 54, 164, 642, 642, 10, "#fff"), a.clip(), a.drawImage(this.data.img, 54, 164, 642, 642), 
            a.restore();
            var s = {
                obj: a,
                str: this.data.posterInfo.title,
                initHeight: 854,
                initWidth: 55,
                titleHeight: 50,
                canvasWidth: 630,
                fontsize: 30,
                color: "#333",
                maxline: 1,
                center: !1
            };
            if (this.drawText(s), i(a, 40, 984, 670, 248, 10, "#fff"), 2 == this.data.posterInfo.style) {
                var r = {
                    obj: a,
                    str: this.data.posterInfo.name,
                    initHeight: 1085,
                    initWidth: 168,
                    titleHeight: 50,
                    canvasWidth: 300,
                    fontsize: 26,
                    color: "#222",
                    maxline: 1,
                    center: !1
                };
                this.drawText(r);
            } else {
                var n = {
                    obj: a,
                    str: this.data.posterInfo.name,
                    initHeight: 1085,
                    initWidth: 168,
                    titleHeight: 50,
                    canvasWidth: 300,
                    fontsize: 26,
                    color: "#222",
                    maxline: 1,
                    center: !1
                };
                this.drawText(n);
            }
            var o = {
                obj: a,
                str: "「" + this.data.posterInfo.recommend + "」",
                initHeight: 1165,
                initWidth: 54,
                titleHeight: 50,
                canvasWidth: 360,
                fontsize: 30,
                color: "#000",
                maxline: 1,
                center: !1
            };
            this.drawText(o);
            if (-1 != this.data.posterInfo.price) if (2 == this.data.posterInfo.style) {
                var h = {
                    obj: a,
                    str: this.data.posterInfo.price,
                    initHeight: 910,
                    initWidth: 54,
                    titleHeight: 46,
                    canvasWidth: 360,
                    fontsize: 28,
                    color: "#fe433f",
                    maxline: 1,
                    center: !1
                };
                this.drawText(h);
                this.drawText(h);
            } else {
                var l = {
                    obj: a,
                    str: this.data.posterInfo.price,
                    initHeight: 910,
                    initWidth: 54,
                    titleHeight: 46,
                    canvasWidth: 360,
                    fontsize: 28,
                    color: "#fe433f",
                    maxline: 1,
                    center: !1
                };
                this.drawText(l);
                this.drawText(l);
            }
            var d = {
                obj: a,
                str: this.data.posterInfo.hot,
                initHeight: 1200,
                initWidth: 70,
                titleHeight: 50,
                canvasWidth: 240,
                fontsize: 22,
                color: "#222",
                maxline: 1,
                center: !1
            };
            this.drawText(d);
            if (2 == this.data.posterInfo.style ? a.drawImage(this.data.qr, 480, 1015, 195, 195) : a.drawImage(this.data.qr, 480, 986, 195, 195), 
            2 != this.data.posterInfo.style) {
                var f = {
                    obj: a,
                    str: "长按立即查看",
                    initHeight: 1212,
                    initWidth: 504,
                    titleHeight: 50,
                    canvasWidth: 240,
                    fontsize: 24,
                    color: "#fff",
                    maxline: 1,
                    center: !1
                };
                i(a, 456, 1187, 240, 32, 16, "#222"), this.drawText(f);
            }
            this.data.posterInfo.style, a.save(), a.beginPath(), a.arc(106, 1075, 42, 0, 2 * Math.PI), 
            a.clip(), a.drawImage(this.data.avatar, 64, 1033, 84, 84), a.restore(), a.draw(), 
            setTimeout(function() {
                e.createPoster();
            }, 500);
        },
        createPoster: function() {
            var t = this;
            wx.canvasToTempFilePath({
                x: 0,
                y: 0,
                width: 750,
                height: 1330,
                destWidth: 750,
                destHeight: 1330,
                canvasId: "poster",
                success: function(i) {
                    t.setData({
                        show: !1
                    });
                    var e = {
                        url: i.tempFilePath
                    };
                    t.triggerEvent("create", e);
                }
            }, this);
        },
        drawText: function(t) {
            var i = t.obj, e = t.titleHeight, a = 0, s = 0, r = 0, n = t.canvasWidth;
            i.setFontSize(t.fontsize), i.fillStyle = t.color;
            for (var o = 0; o < t.str.length; o++) {
                if ((a += i.measureText(t.str[o]).width) > t.canvasWidth) {
                    if (++r >= t.maxline) {
                        var h = t.str.substring(s, o - 1) + "...";
                        if (t.center) {
                            var l = (750 - a) / 2;
                            i.fillText(h, l, t.initHeight);
                        } else i.fillText(h, t.initWidth, t.initHeight);
                        t.canvasWidth, t.titleHeight;
                        return t.titleHeight;
                    }
                    i.fillText(t.str.substring(s, o), t.initWidth, t.initHeight), t.initHeight += e, 
                    a = 0, s = o, t.titleHeight += e;
                }
                if (o == t.str.length - 1) if (r < 1 && (n = a), t.center) {
                    var d = (750 - a) / 2;
                    i.fillText(t.str.substring(s, o + 1), d, t.initHeight);
                } else i.fillText(t.str.substring(s, o + 1), t.initWidth, t.initHeight);
            }
            return {
                width: n,
                height: t.titleHeight
            };
        }
    }
});