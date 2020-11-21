Component({
    data: {
        avatar: "",
        banner: "",
        qr: "",
        img: [],
        show: !0
    },
    properties: {
        posterInfo: {
            type: Object,
            value: {
                avatar: "",
                banner: "",
                title: "",
                hot: "",
                qr: "",
                address: ""
            },
            observer: function(t, e, i) {
                var a = this;
                if (null != t && "" != t.qr) {
                    this.data.posterInfo.banner, this.data.posterInfo.qr, this.data.posterInfo.avatar;
                    wx.getImageInfo({
                        src: a.data.posterInfo.banner,
                        success: function(t) {
                            a.setData({
                                banner: t.path
                            }), wx.getImageInfo({
                                src: a.data.posterInfo.qr,
                                success: function(t) {
                                    a.setData({
                                        qr: t.path
                                    }), wx.getImageInfo({
                                        src: a.data.posterInfo.avatar,
                                        success: function(t) {
                                            a.setData({
                                                avatar: t.path
                                            }), a.drawPoster(t);
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
            }
        }
    },
    ready: function() {},
    methods: {
        drawPoster: function(t) {
            var e = this, i = wx.createCanvasContext("poster", this);
            i.setFillStyle("#ffde55"), i.fillRect(0, 0, 750, 1100), i.drawImage("./bg.png", 168, 95, 533, 74);
            var a = {
                obj: i,
                str: "我有一个好东西，想要和你分享一下",
                initHeight: 140,
                initWidth: 241,
                titleHeight: 60,
                canvasWidth: 560,
                fontsize: 26,
                color: "#333",
                maxline: 1,
                center: !1
            };
            this.drawText(a);
            i.setFillStyle("#fff"), i.fillRect(55, 228, 640, 820), i.setStrokeStyle("#000"), 
            i.strokeRect(55, 228, 640, 820), i.drawImage(this.data.banner, 75, 250, 600, 330);
            var r = {
                obj: i,
                str: this.data.posterInfo.title,
                initHeight: 630,
                initWidth: 75,
                titleHeight: 60,
                canvasWidth: 560,
                fontsize: 30,
                color: "#333",
                maxline: 1,
                center: !0
            }, s = (this.drawText(r), {
                obj: i,
                str: this.data.posterInfo.hot,
                initHeight: 680,
                initWidth: 75,
                titleHeight: 60,
                canvasWidth: 560,
                fontsize: 24,
                color: "#FFAE45",
                maxline: 1,
                center: !0
            });
            this.drawText(s);
            i.drawImage(this.data.qr, 260, 710, 230, 230);
            var n = {
                obj: i,
                str: this.data.posterInfo.address,
                initHeight: 990,
                initWidth: 80,
                titleHeight: 40,
                canvasWidth: 560,
                fontsize: 28,
                color: "#999",
                maxline: 2,
                center: !0
            };
            this.drawText(n);
            i.beginPath(), i.arc(96, 134, 50, 0, 2 * Math.PI), i.clip(), i.drawImage(this.data.avatar, 46, 84, 100, 100), 
            i.restore(), i.draw(), setTimeout(function() {
                e.createPoster();
            }, 500);
        },
        createPoster: function() {
            var i = this;
            wx.canvasToTempFilePath({
                x: 0,
                y: 0,
                width: 750,
                height: 1100,
                destWidth: 750,
                destHeight: 1100,
                canvasId: "poster",
                success: function(t) {
                    i.setData({
                        show: !1
                    });
                    var e = {
                        url: t.tempFilePath
                    };
                    i.triggerEvent("create", e);
                }
            }, this);
        },
        drawText: function(t) {
            var e = t.obj, i = t.titleHeight, a = 0, r = 0, s = 0, n = t.canvasWidth;
            e.setFontSize(t.fontsize), e.fillStyle = t.color;
            for (var o = 0; o < t.str.length; o++) {
                if ((a += e.measureText(t.str[o]).width) > t.canvasWidth) {
                    if (++s >= t.maxline) {
                        var h = t.str.substring(r, o - 1) + "...";
                        if (t.center) {
                            var l = (750 - a) / 2;
                            e.fillText(h, l, t.initHeight);
                        } else e.fillText(h, t.initWidth, t.initHeight);
                        t.canvasWidth, t.titleHeight;
                        return t.titleHeight;
                    }
                    e.fillText(t.str.substring(r, o), t.initWidth, t.initHeight), t.initHeight += i, 
                    a = 0, r = o, t.titleHeight += i;
                }
                if (o == t.str.length - 1) if (s < 1 && (n = a), t.center) {
                    var d = (750 - a) / 2;
                    e.fillText(t.str.substring(r, o + 1), d, t.initHeight);
                } else e.fillText(t.str.substring(r, o + 1), t.initWidth, t.initHeight);
            }
            return {
                width: n,
                height: t.titleHeight
            };
        }
    }
});