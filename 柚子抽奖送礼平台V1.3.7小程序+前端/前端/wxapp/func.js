var func = {};

function drawText(e, o, t, l, n) {
    var s = e.split(""), i = "", a = [];
    n.font = "30rpx Arial", n.fillStyle = "#222222", n.textBaseline = "middle";
    for (var c = 0; c < s.length; c++) n.measureText(i).width < l || (a.push(i), i = ""), 
    i += s[c];
    a.push(i);
    for (var r = 0; r < a.length; r++) n.fillText(a[r], o, t + 30 * (r + 1));
}

func.creatPoster = function(t, e, o, s, l, i) {
    var n = getCurrentPages(), a = n[n.length - 1], c = t.siteInfo.siteroot.split("/app/")[0] + "/attachment/", r = "";
    wx.showLoading({
        title: "获取图片中..."
    });
    var f = s.gid ? s.gid : 0;
    t.util.request({
        url: "entry/wxapp/GetwxCode",
        data: {
            page: e,
            width: o,
            gid: f
        },
        success: function(n) {
            console.log("获取小程序二维码"), console.log(n.data), r = n.data;
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
                console.log(e), console.log("进入 promise"), console.log(n);
                var o = wx.createCanvasContext(i), t = (s.bname, e[0]), l = e[1];
                o.rect(0, 0, 580, 680), o.setStrokeStyle("#ffffff"), o.setFillStyle("#ffffff"), 
                o.fill(), o.drawImage(t, 0, 0, 580, 350), o.setFontSize(36), o.setFillStyle("#fe5047"), 
                o.fillText("参与抽奖 有惊喜哦！", 126, 420, 340, 36), o.drawImage(l, 60, 460, 196, 196), 
                o.drawImage("../../../resource/images/fingerprint.png", 368, 480, 120, 134), o.setFontSize(24), 
                o.setFillStyle("#999"), o.fillText("长按识别二维码进入", 316, 650, 340, 24), o.stroke(), 
                o.draw(), console.log("结束 promise"), wx.hideLoading(), wx.showLoading({
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
}, module.exports = func;