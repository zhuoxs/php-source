var Page = require("../../../../zhy/sdk/qitui/oddpush.js").oddPush(Page).Page;

Page({
    data: {
        jiangpin: "喜马拉雅自由行"
    },
    onLoad: function(e) {
        var t = this;
        wx.getUserInfo({
            success: function(e) {
                t.setData({
                    userInfo: e.userInfo
                });
            }
        }), wx.getSystemInfo({
            success: function(e) {
                t.setData({
                    windowWidth: e.windowWidth,
                    windowHeight: e.windowHeight
                });
            }
        });
    },
    onShow: function() {},
    headerload: function(e) {
        var t = this;
        0 < e.detail.height && t.setData({
            beginimgone: !0
        });
        var a = (t = this).data.beginimgone, i = t.data.beginimgtwo, n = t.data.beginimgthree;
        if (a && i && n) {
            console.log("图片都加载好了");
            var o = t.data.windowWidth, s = (t.data.windowHeight, t.data.userInfo.avatarUrl), l = t.data.userInfo.nickName, g = t.data.jiangpin, c = wx.createCanvasContext("myCanvas");
            c.rect(0, 0, o, 380), c.setFillStyle("#d6564d"), c.fill(), c.beginPath(), c.setStrokeStyle("#f5907c"), 
            c.strokeRect(10, 10, o - 20, 360), c.drawImage(s, o / 2 - 30, 30, 60, 60), c.setFillStyle("#fdeac2"), 
            c.setTextAlign("center"), c.setFontSize(12), c.fillText(l, o / 2, 110), c.setFillStyle("#fdeac2"), 
            c.setTextAlign("center"), c.setFontSize(16), c.fillText("我中奖了：" + g, o / 2, 155), 
            c.setShadow(0, 10, 10, "rgba(0,0,0,0.3)"), c.drawImage("../../../resource/images/banner.jpg", 25, 180, o - 50, (o - 50) / 2), 
            c.rect(0, 380, o, 80), c.setFillStyle("#fff"), c.fill(), c.setShadow(0, 10, 10, "rgba(0,0,0,0)"), 
            c.drawImage("http://bmvqgd.img48.wal8.com/img48/17288183_20180408105809/s/152404306032_medium.jpg", 15, 390, 60, 60), 
            c.setFillStyle("#7f7f7f"), c.setTextAlign("left"), c.setFontSize(12), c.fillText("长按识别小程序", 90, 414), 
            c.fillText("来试试运气", 90, 436), c.draw();
        } else console.log("图片加载不成功");
        setTimeout(function() {
            wx.canvasToTempFilePath({
                x: 0,
                y: 0,
                canvasId: "myCanvas",
                success: function(e) {
                    t.setData({
                        imgSrc: e.tempFilePath
                    });
                }
            });
        }, 10);
    },
    erweimaload: function(e) {
        0 < e.detail.height && this.setData({
            beginimgtwo: !0
        });
    },
    bannerload: function(e) {
        0 < e.detail.height && this.setData({
            beginimgthree: !0
        });
    },
    saveImgToPhotosAlbumTap: function() {
        wx.downloadFile({
            url: this.data.imgSrc,
            success: function(e) {
                console.log("下载图片成功"), wx.saveImageToPhotosAlbum({
                    filePath: e.tempFilePath,
                    success: function(e) {
                        console.log("保存图片成功");
                    },
                    fail: function(e) {
                        console.log(e), console.log("保存图片不成功");
                    }
                });
            },
            fail: function() {
                console.log("下载图片不成功");
            }
        });
    }
});