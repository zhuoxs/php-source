var func = {
    decodeScene: function(e) {
        if (e.scene) for (var o = e, t = decodeURIComponent(e.scene).split("&"), n = 0; n < t.length; n++) {
            var s = t[n].split("=");
            o[s[0]] = s[1];
        } else o = e;
        return o;
    },
    creatPoster2: function(e, o, a, t, r) {
        console.log("-------------------");
        var n = getApp(), g = n, s = getCurrentPages(), u = s[s.length - 1], l = (u.__route__, 
        n.siteInfo.siteroot.split("/app/")[0] + "/attachment/"), i = "";
        wx.showLoading({
            title: "获取图片中..."
        });
        var c = a.gid ? a.gid : 0, f = a.scene, d = wx.getStorageSync("userInfo");
        wx.request({
            url: n.siteInfo.siteroot + "?i=" + n.siteInfo.uniacid + "&t=0&v=1.0&from=wxapp&c=entry&a=wxapp&do=Cuser|GetwxCode&m=sqtg_sun",
            header: {
                "content-type": "application/json"
            },
            data: {
                scene: f,
                page: e,
                width: o,
                gid: c
            },
            success: function(c) {
                console.log("获取小程序二维码"), i = c.data;
                var e = new Promise(function(o, e) {
                    wx.getImageInfo({
                        src: a.url + a.logo,
                        success: function(e) {
                            console.log("banner图片"), console.log(e.path), o(e.path);
                        },
                        fail: function(e) {
                            console.log("banner图片保存失败"), o(a.url + a.logo), console.log(e);
                        }
                    });
                }), o = new Promise(function(o, e) {
                    wx.getImageInfo({
                        src: a.url + a.goodspicbg,
                        success: function(e) {
                            console.log("海报背景图成功"), o(e.path), console.log(e.path);
                        },
                        fail: function(e) {
                            console.log("海报背景图保存失败"), o(a.url + a.goodspicbg), console.log(e);
                        }
                    });
                }), t = new Promise(function(o, e) {
                    wx.getImageInfo({
                        src: d.img,
                        success: function(e) {
                            console.log("用户头像缓存"), o(e.path);
                        },
                        fail: function(e) {
                            console.log("用户头像缓存失败"), o(d.img), console.log(e);
                        }
                    });
                }), n = new Promise(function(o, e) {
                    wx.getImageInfo({
                        src: l + i,
                        success: function(e) {
                            wx.request({
                                url: g.siteInfo.siteroot + "?i=" + g.siteInfo.uniacid + "&t=0&v=1.0&from=wxapp&c=entry&a=wxapp&do=Cuser|DelwxCode&m=sqtg_sun",
                                data: {
                                    imgurl: i
                                },
                                success: function(e) {
                                    console.log("删除缓存成功");
                                }
                            }), console.log("图片缓存2"), console.log(e.path), o(e.path);
                        },
                        fail: function(e) {
                            wx.request({
                                url: g.siteInfo.siteroot + "?i=" + g.siteInfo.uniacid + "&t=0&v=1.0&from=wxapp&c=entry&a=wxapp&do=Cuser|DelwxCode&m=sqtg_sun",
                                data: {
                                    imgurl: i
                                },
                                success: function(e) {
                                    console.log(e.data);
                                }
                            }), console.log("图片2保存失败"), o(l + i), console.log(e);
                        }
                    });
                });
                Promise.all([ e, n, t, o ]).then(function(e) {
                    console.log(e), console.log("进入 promise"), console.log(c);
                    var o = wx.createCanvasContext(r), t = a.bname, n = e[0], s = e[1], l = e[2], i = e[3];
                    o.rect(0, 0, 750, 1234), o.setStrokeStyle("rgba(0,0,0,0)"), o.drawImage(i, 0, 0, 750, 1334), 
                    o.beginPath(), o.rect(30, 260, 690, 870), o.setStrokeStyle("rgba(0,0,0,0)"), o.setFillStyle("#fff"), 
                    o.fill(), o.drawImage(n, 60, 150, 630, 630), o.setFillStyle("#000"), g.Func.func.drawText(t, 65, 780, 600, o), 
                    o.drawImage(l, 85, 890, 70, 70), o.setFillStyle("#222"), o.setFontSize(28), o.fillText(d.name, 180, 910), 
                    o.setFillStyle("#e5bb03"), o.setFontSize(20), o.fillText("向您推荐", 180, 945), o.setFillStyle("#e9472c"), 
                    o.setFontSize(22), o.drawImage("/zhy/resource/images/group.png", 75, 995, 100, 48), 
                    o.fillText("￥", 73, 1073), o.setFillStyle("#e9472c"), o.setFontSize(32), o.fillText(a.price, 97, 1060), 
                    o.drawImage(s, 475, 890, 200, 200), o.stroke(), o.draw(), console.log("结束 promise"), 
                    wx.hideLoading(), wx.showLoading({
                        title: "开始生成海报..."
                    }), console.log("生成中"), new Promise(function(e, o) {
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
                            canvasId: r,
                            success: function(e) {
                                console.log("进入 canvasToTempFilePath"), u.setData({
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
    drawText: function(e, o, t, n, s) {
        var l = e.split(""), i = "", c = [];
        s.font = "28rpx Arial", s.fillStyle = "#222222", s.textBaseline = "middle";
        for (var a = 0; a < l.length; a++) s.measureText(i).width < n ? i += l[a] : (a--, 
        c.push(i), i = "");
        if (c.push(i), 2 < c.length) {
            var r = c.slice(0, 2), g = r[1], u = "", f = [];
            for (a = 0; a < g.length - 3 && s.measureText(u).width < n; a++) u += g[a];
            f.push(u);
            var d = f[0] + "...";
            r.splice(1, 1, d), c = r;
        }
        for (var p = 0; p < c.length; p++) s.fillText(c[p], o, t + 36 * (p + 1));
    }
};

module.exports = {
    func: func
};