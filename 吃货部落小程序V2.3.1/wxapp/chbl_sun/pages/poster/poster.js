var _data;

function _defineProperty(e, t, o) {
    return t in e ? Object.defineProperty(e, t, {
        value: o,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : e[t] = o, e;
}

var app = getApp();

Page({
    data: (_data = {
        img: "../../resource/images/first/logo.jpg",
        wechat: "../../resource/images/first/logo.jpg",
        quan: "../../resource/images/first/logo.jpg",
        code: "E7AI98",
        inputValue: "",
        maskHidden: !1,
        name: "",
        touxiang: ""
    }, _defineProperty(_data, "code", "E7A93C"), _defineProperty(_data, "title", "一起吃吓"), 
    _defineProperty(_data, "desc", "50元爱购券50元爱购50元爱购券"), _data),
    onLoad: function(e) {
        console.log(e);
        var t = wx.getStorageSync("user_info"), o = wx.getStorageSync("url");
        console.log(t), console.log(o), this.setData({
            userInfo: t,
            url: o
        });
    },
    bindPreviewTap: function(e) {
        wx.previewImage({
            urls: [ this.data.imagePath ]
        });
        var t = this.data.wxcode;
        console.log(t);
    },
    drawText: function(e, t, o, a, n, i) {
        for (var l = 1, s = 0, c = 0, r = 0; r < t.length; r++) {
            if (i < (s += e.measureText(t[r]).width)) {
                if (++l, console.log("line" + l), 2 == l) e.fillText(t.substring(c, r), a, o); else {
                    t = t.substring(c, r - 1) + "...";
                    e.fillText(t, a, o);
                }
                if (o += 30, s = 0, c = r, n += 30, 2 < l) return;
            }
            r == t.length - 1 && e.fillText(t.substring(c, r + 1), a, o);
        }
        return n += 10;
    },
    createNewImg: function() {
        var o = this, e = wx.createCanvasContext("mycanvas");
        e.setFillStyle("#fff"), e.fillRect(0, 0, 375, 1334);
        var t = wx.getStorageSync("active");
        wx.getStorageSync("url");
        console.log(t);
        var a = o.data.activethumb;
        console.log(a), e.drawImage(a, 0, 0, 375, 240);
        var n = o.data.name;
        console.log(n), e.setTextAlign("center");
        var i = (e.measureText(n).width / 2).toFixed(0);
        e.setFontSize(16), e.setFillStyle("#666"), e.lineWidth = 1;
        var l = 55, s = 260, c = 295, r = 200;
        if (l = this.drawText(e, n, c, r, l, s), e.closePath(), t.subtitle) g = t.subtitle; else var g = "";
        e.setFontSize(26), e.fillStyle = "#000", e.lineWidth = 1;
        var u = "【" + t.title + "】" + g;
        e.setTextAlign("left");
        l = 55, s = 330, c = 370, r = 20;
        l = this.drawText(e, u, c, r, l, s), e.setFontSize(28), e.fillStyle = "#ce0000", 
        e.lineWidth = 1;
        l = 55, s = 250, c = 490, r = 20;
        l = this.drawText(e, "立即参与", c, r, l, s), e.setFontSize(20), e.fillStyle = "#666", 
        e.lineWidth = 1;
        var f = "剩余数量：" + t.active_num;
        l = 55, s = 250, c = 530, r = 20;
        l = this.drawText(e, f, c, r, l, s), e.setFontSize(18), e.fillStyle = "#666", e.lineWidth = 1;
        var d = "已有" + t.part_num + "人参与";
        l = 55, s = 250, c = 570, r = 20;
        l = this.drawText(e, d, c, r, l, s);
        var w = o.data.wxcode_img;
        console.log(w), e.drawImage(w, 230, 460, 120, 120);
        var h = o.data.touxiang;
        console.log(h), console.log(i), console.log(i / 2), e.arc(200 - i - 20 - 25, 286, 25, 0, 2 * Math.PI), 
        e.setStrokeStyle("white"), e.stroke(), e.clip(), e.drawImage(h, 200 - i - 20 - 50, 261, 50, 50), 
        e.draw(), setTimeout(function() {
            wx.canvasToTempFilePath({
                canvasId: "mycanvas",
                success: function(e) {
                    var t = e.tempFilePath;
                    o.setData({
                        imagePath: t,
                        canvasHidden: !0
                    }), wx.hideLoading();
                },
                fail: function(e) {
                    console.log(e);
                }
            });
        }, 1e3);
    },
    onShow: function() {
        var t = this;
        wx.getUserInfo({
            success: function(e) {
                console.log(e.userInfo, "huoqudao le "), t.getImageInfo(e.userInfo.avatarUrl), t.setData({
                    name: e.userInfo.nickName
                });
            }
        });
    },
    getImageInfo: function(o) {
        var n = this, i = wx.getStorageSync("url"), a = wx.getStorageSync("active"), e = n.data.wxcode;
        if (console.log(e), console.log(n.data), "string" == typeof o) {
            wx.showLoading({
                title: "卡片生成中...",
                icon: "loading",
                duration: 4e3
            });
            var t = new Promise(function(t, e) {
                wx.getImageInfo({
                    src: o,
                    success: function(e) {
                        console.log("图片缓存1"), console.log(e), n.setData({
                            touxiang: e.path
                        }), t(e.path);
                    },
                    fail: function(e) {
                        console.log("图片1缓存失败"), t(o), console.log(e);
                    }
                });
            }), l = new Promise(function(t, e) {
                wx.getImageInfo({
                    src: i + a.thumb,
                    success: function(e) {
                        console.log("图片缓存2"), console.log(e), n.setData({
                            activethumb: e.path
                        }), t(e.path);
                    },
                    fail: function(e) {
                        console.log("图片2保存失败"), t(i + a.thumb), console.log(e);
                    }
                });
            }), s = new Promise(function(o, e) {
                var a = wx.getStorageSync("active"), t = wx.getStorageSync("page");
                console.log(t), console.log(a), app.util.request({
                    url: "entry/wxapp/GetwxCode",
                    cachetime: "0",
                    data: {
                        page: t
                    },
                    success: function(e) {
                        var t = e.data;
                        wx.getImageInfo({
                            src: i + t,
                            success: function(e) {
                                console.log("图片缓存3"), console.log(e), n.setData({
                                    wxcode_img: e.path
                                }), o(e.path);
                            },
                            fail: function(e) {
                                console.log("图片3保存失败"), o(i + t), console.log(e);
                            }
                        }), app.util.request({
                            url: "entry/wxapp/DelCtxImg",
                            cachetime: "0",
                            data: {
                                wxcode: t
                            },
                            success: function(e) {
                                console.log(e);
                            }
                        }), n.setData({
                            active: a,
                            wxcode: e.data
                        });
                    }
                });
            });
            Promise.all([ t, l, s ]).then(function(e) {
                console.log(e), console.log("进入 promise"), wx.hideLoading(), wx.showLoading({
                    title: "开始生成海报..."
                }), n.createNewImg();
            });
        }
    },
    onReady: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});