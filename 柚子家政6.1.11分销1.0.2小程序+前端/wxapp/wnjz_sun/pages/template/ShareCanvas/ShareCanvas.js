var app = getApp();

function img(i) {
    return new Promise(function(e, t) {
        wx.getImageInfo({
            src: i,
            success: function(t) {
                console.log(t.path), e(t.path);
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
                }), app.util.request({
                    url: "entry/wxapp/DelwxCode",
                    data: {
                        imgurl: e.data.posterInfo.wxcode_pic
                    },
                    success: function(t) {
                        console.log(t);
                    }
                }), e.drawPoster(t);
            });
        },
        drawPoster: function(t) {
            var e = this, i = wx.createCanvasContext("shareImg", this);
            i.setFillStyle("#41c2fc"), i.fillRect(0, 0, 375, 1200), i.drawImage(this.data.banner, 0, 0, 375, 340), 
            i.setFillStyle("#41c2fc"), i.fillRect(55, 229, 0, 0), i.setStrokeStyle("#ffffff"), 
            i.drawImage("../../../../style/images/canvasbg.png", 0, 340, 375, 260), i.drawImage(this.data.qr, 120, 450, 120, 120), 
            i.save(), i.beginPath(), i.arc(50, 382, 25, 0, 2 * Math.PI, !1), i.clip(), i.drawImage(this.data.avatar, 25, 357, 50, 50), 
            i.restore(), i.stroke(), i.draw(), i.beginPath(), i.arc(50, 382, 25, 0, 2 * Math.PI, !1), 
            i.setStrokeStyle("#ffffff"), i.fill(), setTimeout(function() {
                e.createPoster();
            }, 500);
        },
        createPoster: function() {
            var i = this;
            wx.canvasToTempFilePath({
                x: 0,
                y: 0,
                width: 375,
                height: 640,
                destWidth: 750,
                destHeight: 1200,
                canvasId: "shareImg",
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
                        var l = t.str.substring(r, o - 1) + "...";
                        if (t.center) {
                            var h = (750 - a) / 2;
                            e.fillText(l, h, t.initHeight);
                        } else e.fillText(l, t.initWidth, t.initHeight);
                        t.canvasWidth, t.titleHeight;
                        return t.titleHeight;
                    }
                    e.fillText(t.str.substring(r, o), t.initWidth, t.initHeight), t.initHeight += i, 
                    a = 0, r = o, t.titleHeight += i;
                }
                if (o == t.str.length - 1) if (s < 1 && (n = a), t.center) {
                    var f = (750 - a) / 2;
                    e.fillText(t.str.substring(r, o + 1), f, t.initHeight);
                } else e.fillText(t.str.substring(r, o + 1), t.initWidth, t.initHeight);
            }
            return {
                width: n,
                height: t.titleHeight
            };
        }
    }
});