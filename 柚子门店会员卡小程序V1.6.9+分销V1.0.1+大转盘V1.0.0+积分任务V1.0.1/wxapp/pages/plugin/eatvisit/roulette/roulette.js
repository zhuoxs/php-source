var dot_inter, app = getApp();

Component({
    properties: {
        options: {
            type: Object,
            value: {},
            observer: function(t, a) {}
        },
        iscandraw: {
            type: Boolean,
            value: !1
        }
    },
    data: {
        show: !1,
        isCan: !0,
        animationData: {},
        btnDisabled: ""
    },
    attached: function() {},
    detached: function() {
        clearInterval(dot_inter);
    },
    ready: function() {
        this.drawCanvas(), this.dotStart();
    },
    methods: {
        drawCanvas: function() {
            var t = wx.createCanvasContext("roulette", this), a = this.data.options, e = this.data.angelTo || -30, o = 295;
            t.translate(147.5, 147.5), t.clearRect(-o, -295, o, 295);
            var n = 2 * Math.PI / 360 * 60, i = 2 * Math.PI / 360 * -90, r = 2 * Math.PI / 360 * -90 + n;
            t.rotate(e * Math.PI / 180), t.beginPath(), t.lineWidth = 20, t.strokeStyle = a.bgOut, 
            t.arc(0, 0, 130, 0, 2 * Math.PI), t.stroke(), t.beginPath(), t.lineWidth = 6, t.strokeStyle = a.bgMiddle, 
            t.arc(0, 0, 120, 0, 2 * Math.PI), t.stroke();
            for (var s = a.dotColor, l = 0; l < 26; l++) {
                t.beginPath();
                var d = 131 * Math.cos(i), h = 131 * Math.sin(i);
                t.fillStyle = s[l % s.length], t.arc(d, h, 5, 0, 2 * Math.PI), t.fill(), i += 2 * Math.PI / 360 * (360 / 26);
            }
            var c = a.bgInner;
            for (l = 0; l < 6; l++) t.beginPath(), t.lineWidth = 116, t.strokeStyle = c[l % c.length], 
            t.arc(0, 0, 60, i, r), t.stroke(), i = r, r += n;
            var v = a.award;
            i = n / 2;
            for (l = 0; l < 6; l++) t.save(), t.rotate(i), t.font = a.font, t.fillStyle = a.fontColor, 
            t.textAlign = "center", t.fillText(v[l].level, 0, -90), i += n, t.restore();
            t.draw();
        },
        getLottery: function() {
            var a = this, t = a.data.options;
            if (console.log(t), !t.isable) return wx.showToast({
                title: "数据加载中，请稍后...",
                icon: "none"
            }), !1;
            var e = 6 * Math.random() >>> 0, o = option.award;
            console.log(e);
            var n = wx.createAnimation({
                duration: 1
            });
            (this.animationInit = n).rotate(0).step(), this.setData({
                animationData: n.export(),
                btnDisabled: "disabled"
            }), setTimeout(function() {
                var t = wx.createAnimation({
                    duration: 4e3,
                    timingFunction: "ease"
                });
                (a.animationRun = t).rotate(2880 - 60 * e).step(), a.setData({
                    animationData: t.export()
                });
            }, 100), setTimeout(function() {
                wx.showModal({
                    title: "恭喜",
                    content: "获得" + o.awards[e].name,
                    showCancel: !1
                }), o.chance && a.setData({
                    btnDisabled: ""
                });
            }, 4100);
        },
        dotStart: function() {
            var t = this, a = 0, e = t.data.options;
            dot_inter = setInterval(function() {
                e.dotColor = a % 2 ? e.dotColor_1 : e.dotColor_2, a++, t.setData({
                    options: e
                }), t.drawCanvas();
            }, e.speedDot);
        }
    }
});