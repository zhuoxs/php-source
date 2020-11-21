var func = {};

function drawText(e, o, t, n, l) {
    var s = e.split(""), i = "", a = [];
    l.font = "30rpx Arial", l.fillStyle = "#222222", l.textBaseline = "middle";
    for (var c = 0; c < s.length; c++) l.measureText(i).width < n || (a.push(i), i = ""), 
    i += s[c];
    a.push(i);
    for (var r = 0; r < a.length; r++) l.fillText(a[r], o, t + 30 * (r + 1));
}

func.creatPoster = function(t, e, o, s, n, i) {
    var l = getCurrentPages(), a = l[l.length - 1], c = t.siteInfo.siteroot.split("/app/")[0] + "/attachment/";
    console.log(c);
    var r = "";
    wx.showLoading({
        title: "获取图片中..."
    }), t.util.request({
        url: "entry/wxapp/GetwxCode",
        data: {
            page: e,
            width: o
        },
        success: function(l) {
            console.log("获取小程序二维码"), console.log(l.data), r = l.data, console.log(r), console.log(s.logo);
            var e = new Promise(function(o, e) {
                wx.getImageInfo({
                    src: s.url + s.logo,
                    success: function(e) {
                        console.log("图片缓存1"), console.log(e), o(e.path);
                    },
                    fail: function(e) {
                        console.log("图片1缓存失败"), o(s.url + s.logo), console.log(e);
                    }
                });
            });
            console.log(c + r);
            var o = new Promise(function(o, e) {
                wx.getImageInfo({
                    src: c + r,
                    success: function(e) {
                        t.util.request({
                            url: "entry/wxapp/DelwxCode",
                            data: {
                                imgurl: r
                            },
                            success: function(e) {
                                console.log(e.data);
                            }
                        }), console.log("图片缓存2"), console.log(e), o(e.path);
                    },
                    fail: function(e) {
                        console.log("图片2保存失败"), o(c + r), console.log(e);
                    }
                });
            });
            Promise.all([ e, o ]).then(function(e) {
                console.log(e), console.log("进入 promise"), console.log(e), console.log(l);
                var o = wx.createCanvasContext(i), t = (s.bname, e[0]), n = e[1];
                o.rect(0, 0, 580, 680), o.setStrokeStyle("#ffffff"), o.setFillStyle("#ffffff"), 
                o.fill(), o.drawImage(t, 0, 0, 580, 350), o.setFontSize(28), o.setFillStyle("#fe5047"), 
                o.fillText(s.font, 60, 420, 480, 28), o.drawImage(n, 60, 460, 196, 196), o.drawImage("../../../resource/images/fingerprint.png", 368, 480, 120, 136), 
                o.setFontSize(24), o.setFillStyle("#999"), o.fillText("长按识别二维码进入", 318, 650, 340, 24), 
                o.stroke(), o.draw(), console.log("结束 promise"), wx.hideLoading(), wx.showLoading({
                    title: "开始生成海报..."
                }), new Promise(function(e, o) {
                    setTimeout(function() {
                        e("second ok");
                    }, 500);
                }).then(function(e) {
                    console.log(e), wx.canvasToTempFilePath({
                        x: 0,
                        y: 0,
                        width: 580,
                        height: 680,
                        destWidth: 580,
                        destHeight: 680,
                        canvasId: i,
                        success: function(e) {
                            console.log("进入 canvasToTempFilePath"), a.setData({
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
}, func.decodeScene = function(e) {
    if (e.scene) for (var o = e, t = decodeURIComponent(e.scene).split("&"), n = 0; n < t.length; n++) {
        var l = t[n].split("=");
        o[l[0]] = l[1];
    } else o = e;
    return o;
}, func.islogin = function(o, t) {
    wx.getStorageSync("have_wxauth") || wx.getSetting({
        success: function(e) {
            e.authSetting["scope.userInfo"] ? (o.wxauthSetting(), wx.setStorageSync("have_wxauth", 1), 
            t.setData({
                is_modal_Hidden: !0
            })) : t.setData({
                is_modal_Hidden: !1
            });
        }
    });
}, func.gotoUrl = function(e, o, t, n, l) {
    1 == n ? (wx, wx.redirectTo({
        url: "/" + t
    })) : wx.navigateTo({
        url: "/" + t
    });
}, module.exports = func;