function t(t) {
    return new Promise(function(e, i) {
        wx.getImageInfo({
            src: t,
            success: function(t) {
                e(t.path);
            }
        });
    });
}

function e(t, e, i, a, s, o, r) {
    t.beginPath(), t.setFillStyle(r), t.arc(e + o, i + o, o, Math.PI, 1.5 * Math.PI), 
    t.moveTo(e + o, i), t.lineTo(e + a - o, i), t.lineTo(e + a, i + o), t.arc(e + a - o, i + o, o, 1.5 * Math.PI, 2 * Math.PI), 
    t.lineTo(e + a, i + s - o), t.lineTo(e + a - o, i + s), t.arc(e + a - o, i + s - o, o, 0, .5 * Math.PI), 
    t.lineTo(e + o, i + s), t.lineTo(e, i + s - o), t.arc(e + o, i + s - o, o, .5 * Math.PI, Math.PI), 
    t.lineTo(e, i + o), t.lineTo(e + o, i), t.fill(), t.closePath();
}

var i = getApp();

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
            observer: function(t, e, i) {
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
            observer: function(t, e, i) {}
        }
    },
    ready: function() {},
    methods: {
        startCreatImg: function() {
            var e = this, a = [ t(this.data.posterInfo.qr), t(this.data.posterInfo.is_pic) ];
            Promise.all(a).then(function(t) {
                e.setData({
                    qr: t[0],
                    is_pic: t[1]
                }), i.api.apiDeleteQRCode({
                    path: e.data.posterInfo.delRoot
                }).then(function(t) {
                    wx.showLoading({
                        title: "海报生成中..."
                    });
                }).catch(function(t) {
                    wx.showLoading({
                        title: "海报生成中..."
                    });
                }), e.drawPosterImg(t);
            });
        },
        drawPosterImg: function(t) {
            var e = this, i = wx.createCanvasContext("poster", this);
            this.data.is_pic ? i.drawImage(this.data.is_pic, 0, 0, 750, 1330) : (i.setFillStyle("#f9f3e0"), 
            i.fillRect(0, 0, 750, 1330)), i.drawImage(this.data.qr, 480, 1060, 195, 195), i.draw(), 
            setTimeout(function() {
                e.createPoster();
            }, 500);
        },
        startCreat: function() {
            var e = this, a = [];
            a = "" == this.data.posterInfo.bg ? [ t(this.data.posterInfo.img), t(this.data.posterInfo.avatar), t(this.data.posterInfo.qr) ] : [ t(this.data.posterInfo.img), t(this.data.posterInfo.avatar), t(this.data.posterInfo.qr), t(this.data.posterInfo.bg) ], 
            Promise.all(a).then(function(t) {
                e.setData({
                    img: t[0],
                    avatar: t[1],
                    qr: t[2]
                }), t[3] && e.setData({
                    bg: t[3]
                }), i.api.apiDeleteQRCode({
                    path: e.data.posterInfo.delRoot
                }).then(function(t) {
                    wx.showLoading({
                        title: "海报生成中..."
                    });
                }).catch(function(t) {
                    wx.showLoading({
                        title: "海报生成中..."
                    });
                }), e.drawPoster(t);
            });
        },
        drawPoster: function(t) {
            var i = this, a = wx.createCanvasContext("poster", this);
            this.data.bg ? a.drawImage(this.data.bg, 0, 0, 750, 1330) : (a.setFillStyle("#f9f3e0"), 
            a.fillRect(0, 0, 750, 1330)), e(a, 20, 104, 710, 1128, 10, "#fff"), a.drawImage(this.data.img, 20, 104, 710, 710), 
            a.restore();
            var s = {
                obj: a,
                str: this.data.posterInfo.title,
                initHeight: 876,
                initWidth: 55,
                titleHeight: 50,
                canvasWidth: 630,
                fontsize: 36,
                color: "#333",
                maxline: 1,
                center: !0
            };
            if (this.drawText(s), 2 == this.data.posterInfo.style) {
                var o = {
                    obj: a,
                    str: this.data.posterInfo.name,
                    initHeight: 1065,
                    initWidth: 188,
                    titleHeight: 50,
                    canvasWidth: 300,
                    fontsize: 30,
                    color: "#222",
                    maxline: 1,
                    center: !1
                };
                this.drawText(o);
            } else {
                var r = {
                    obj: a,
                    str: this.data.posterInfo.name,
                    initHeight: 1065,
                    initWidth: 188,
                    titleHeight: 50,
                    canvasWidth: 300,
                    fontsize: 30,
                    color: "#222",
                    maxline: 1,
                    center: !1
                };
                this.drawText(r);
            }
            var n = {
                obj: a,
                str: "「" + this.data.posterInfo.recommend + "」",
                initHeight: 1180,
                initWidth: 40,
                titleHeight: 50,
                canvasWidth: 360,
                fontsize: 32,
                color: "#000",
                maxline: 1,
                center: !1
            };
            this.drawText(n);
            if (-1 != this.data.posterInfo.price) {
                var h = {
                    obj: a,
                    str: this.data.posterInfo.hot + " | " + this.data.posterInfo.price,
                    initHeight: 930,
                    initWidth: 70,
                    titleHeight: 50,
                    canvasWidth: 600,
                    fontsize: 25,
                    color: "#000",
                    maxline: 1,
                    center: !0
                };
                this.drawText(h);
            } else {
                var l = {
                    obj: a,
                    str: this.data.posterInfo.hot,
                    initHeight: 930,
                    initWidth: 70,
                    titleHeight: 50,
                    canvasWidth: 600,
                    fontsize: 25,
                    color: "#000",
                    maxline: 1,
                    center: !0
                };
                this.drawText(l);
            }
            a.drawImage(this.data.qr, 468, 969, 229, 229), this.data.posterInfo.style, a.save(), 
            a.beginPath(), a.arc(115, 1055, 55, 0, 2 * Math.PI), a.clip(), a.drawImage(this.data.avatar, 60, 1e3, 110, 110), 
            a.restore(), a.draw(), setTimeout(function() {
                i.createPoster();
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
                success: function(e) {
                    t.setData({
                        show: !1
                    });
                    var i = {
                        url: e.tempFilePath
                    };
                    t.triggerEvent("create", i);
                }
            }, this);
        },
        drawText: function(t) {
            var e = t.obj, i = t.titleHeight, a = 0, s = 0, o = 0, r = t.canvasWidth;
            e.setFontSize(t.fontsize), e.fillStyle = t.color;
            for (var n = 0; n < t.str.length; n++) {
                if ((a += e.measureText(t.str[n]).width) > t.canvasWidth) {
                    if (++o >= t.maxline) {
                        var h = t.str.substring(s, n - 1) + "...";
                        if (t.center) {
                            var l = (750 - a) / 2;
                            e.fillText(h, l, t.initHeight);
                        } else e.fillText(h, t.initWidth, t.initHeight);
                        t.canvasWidth, t.titleHeight;
                        return t.titleHeight;
                    }
                    e.fillText(t.str.substring(s, n), t.initWidth, t.initHeight), t.initHeight += i, 
                    a = 0, s = n, t.titleHeight += i;
                }
                if (n == t.str.length - 1) if (o < 1 && (r = a), t.center) {
                    var d = (750 - a) / 2;
                    e.fillText(t.str.substring(s, n + 1), d, t.initHeight);
                } else e.fillText(t.str.substring(s, n + 1), t.initWidth, t.initHeight);
            }
            return {
                width: r,
                height: t.titleHeight
            };
        }
    }
});