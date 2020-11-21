function img(i) {
    return new Promise(function(e, t) {
        wx.getImageInfo({
            src: i,
            success: function(t) {
                e(t.path);
            }
        });
    });
}

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
                t && this.startCreat();
            }
        },
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
            observer: function(t, e, i) {}
        }
    },
    ready: function() {},
    methods: {
        startCreat: function() {
            var e = this;
            Promise.all([ img(e.data.posterInfo.banner), img(e.data.posterInfo.qr), img(e.data.posterInfo.avatar) ]).then(function(t) {
                e.setData({
                    banner: t[0],
                    qr: t[1],
                    avatar: t[2]
                }), e.drawPoster(t);
            });
        },
        drawPoster: function(t) {
            var e = this, i = wx.createCanvasContext("poster", this);
            i.setFillStyle("#fc95a9"), i.fillRect(0, 0, 750, 1100), i.drawImage("http://wx2.sinaimg.cn/small/005ysW6agy1fu7wiohrrbj30ku0iwng0.jpg", 0, 0, 750, 680);
            i.setFillStyle("#fc95a9"), i.fillRect(55, 229, 640, 840);
            this.data.posterInfo.title;
            i.drawImage(this.data.qr, 260, 800, 230, 230), i.beginPath(), i.arc(96, 434, 50, 0, 2 * Math.PI), 
            i.clip(), i.drawImage(this.data.avatar, 46, 384, 100, 100), i.restore(), i.draw(), 
            setTimeout(function() {
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
            var e = t.obj, i = t.titleHeight, a = 0, r = 0, n = 0, s = t.canvasWidth;
            e.setFontSize(t.fontsize), e.fillStyle = t.color;
            for (var o = 0; o < t.str.length; o++) {
                if ((a += e.measureText(t.str[o]).width) > t.canvasWidth) {
                    if (++n >= t.maxline) {
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
                if (o == t.str.length - 1) if (n < 1 && (s = a), t.center) {
                    var c = (750 - a) / 2;
                    e.fillText(t.str.substring(r, o + 1), c, t.initHeight);
                } else e.fillText(t.str.substring(r, o + 1), t.initWidth, t.initHeight);
            }
            return {
                width: s,
                height: t.titleHeight
            };
        }
    }
});