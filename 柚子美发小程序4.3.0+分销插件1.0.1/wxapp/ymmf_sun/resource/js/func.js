var func = {
    decodeScene: function(e) {
        if (e.scene) for (var t = e, n = decodeURIComponent(e.scene).split("&"), i = 0; i < n.length; i++) {
            var o = n[i].split("=");
            t[o[0]] = o[1];
        } else t = e;
        return t;
    },
    creatPoster2: function(e, t, a, n, c) {
        console.log("-------------------");
        var s = getApp(), r = s, i = getCurrentPages(), u = i[i.length - 1], l = (u.__route__, 
        s.siteInfo.siteroot.split("/app/")[0] + "/attachment/"), f = "", o = (a.gid && a.gid, 
        a.scene), g = wx.getStorageSync("users");
        s.util.request({
            url: "entry/wxapp/GetwxCode",
            data: {
                scene: o,
                page: e,
                width: t,
                showLoading: !1
            },
            success: function(e) {
                wx.showLoading({
                    title: "获取图片中..."
                }), console.log("获取小程序二维码22"), console.log(e.data), f = e.data;
                var t = new Promise(function(t, e) {
                    wx.getImageInfo({
                        src: a.url + a.logo,
                        success: function(e) {
                            t(e.path);
                        },
                        fail: function(e) {
                            t(a.url + a.logo);
                        }
                    });
                }), n = new Promise(function(t, e) {
                    wx.getImageInfo({
                        src: g.img,
                        success: function(e) {
                            t(e.path);
                        },
                        fail: function(e) {
                            t(g.img), console.log(e);
                        }
                    });
                }), i = new Promise(function(t, e) {
                    wx.getImageInfo({
                        src: a.url + a.goodspicbg,
                        success: function(e) {
                            t(e.path);
                        },
                        fail: function(e) {
                            t(a.url + a.goodspicbg);
                        }
                    });
                }), o = new Promise(function(t, e) {
                    wx.getImageInfo({
                        src: l + f,
                        success: function(e) {
                            s.util.request({
                                url: "entry/wxapp/DelwxCode",
                                data: {
                                    imgurl: f,
                                    showLoading: !1
                                },
                                success: function(e) {}
                            }), t(e.path);
                        },
                        fail: function(e) {
                            s.util.request({
                                url: "entry/wxapp/DelwxCode",
                                data: {
                                    imgurl: f,
                                    showLoading: !1
                                },
                                success: function(e) {}
                            }), t(l + f);
                        }
                    });
                });
                Promise.all([ t, o, n, i ]).then(function(e) {
                    wx.hideLoading(), wx.showLoading({
                        title: "开始生成海报..."
                    });
                    var t = wx.createCanvasContext(c), n = a.bname, i = e[0], o = e[1], s = e[2], l = e[3];
                    t.rect(0, 0, 750, 1234), t.drawImage(l, 0, 0, 750, 1334), t.beginPath(), t.rect(30, 260, 690, 870), 
                    t.setStrokeStyle("rgba(0,0,0,0)"), t.setFillStyle("#fff"), t.fill(), t.drawImage(i, 60, 150, 630, 630), 
                    t.setFillStyle("#000"), r.Func.func.drawText(n, 65, 780, 600, t), t.drawImage(s, 85, 890, 70, 70), 
                    t.setFillStyle("#222"), t.setFontSize(28), t.fillText(g.name, 180, 910), t.setFillStyle("#e5bb03"), 
                    t.setFontSize(20), t.fillText("向您推荐", 180, 945), t.setFillStyle("#e9472c"), t.setFontSize(22), 
                    a.br && t.drawImage(a.br, 73, 985), a.price && (t.fillText("￥", 73, 1073), t.setFillStyle("#e9472c"), 
                    t.setFontSize(32), t.fillText(a.price, 97, 1060)), t.drawImage(o, 475, 890, 200, 200), 
                    t.stroke(), t.draw(), new Promise(function(e, t) {
                        setTimeout(function() {
                            e("second ok");
                        }, 500);
                    }).then(function(e) {
                        wx.canvasToTempFilePath({
                            x: 0,
                            y: 0,
                            width: 750,
                            height: 1234,
                            destWidth: 750,
                            destHeight: 1234,
                            canvasId: c,
                            success: function(e) {
                                u.setData({
                                    prurl: e.tempFilePath,
                                    hidden: !1
                                }), wx.hideLoading();
                            },
                            fail: function(e) {
                                console.log(e);
                            }
                        });
                    });
                });
            }
        });
    },
    drawText: function(e, t, n, i, o) {
        var s = e.split(""), l = "", a = [];
        o.font = "28rpx Arial", o.fillStyle = "#222222", o.textBaseline = "middle";
        for (var c = 0; c < s.length; c++) o.measureText(l).width < i ? l += s[c] : (c--, 
        a.push(l), l = "");
        if (a.push(l), 2 < a.length) {
            var r = a.slice(0, 2), u = r[1], f = "", g = [];
            for (c = 0; c < u.length - 3 && o.measureText(f).width < i; c++) f += u[c];
            g.push(f);
            var d = g[0] + "...";
            r.splice(1, 1, d), a = r;
        }
        for (var w = 0; w < a.length; w++) o.fillText(a[w], t, n + 36 * (w + 1));
    }
};

module.exports = {
    func: func
};