var app = getApp();

Page({
    data: {},
    onLoad: function(o) {
        var t = this, n = app.globalData.Headcolor;
        t.setData({
            backgroundColor: n
        }), app.util.request({
            url: "entry/wxapp/Contact",
            method: "POST",
            data: {},
            success: function(o) {
                var n = o.data.data;
                console.log(n), t.setData({
                    ofFriendsimg: n
                });
            },
            fail: function(o) {
                console.log("失败" + o);
            }
        });
    },
    onReady: function() {},
    bingLongTap: function(o) {
        console.log(11), wx.downloadFile({
            url: this.data.ofFriendsimg.contact_qr,
            success: function(o) {
                console.log(o);
                var n = o.tempFilePath;
                wx.showToast({
                    title: "保存成功",
                    icon: "success",
                    duration: 2e3
                }), wx.saveImageToPhotosAlbum({
                    filePath: n
                });
            },
            fail: function(o) {
                console.log(o);
            }
        });
    },
    imgYu: function(o) {
        var n = o.currentTarget.dataset.src, t = [];
        t.push(n), console.log(t), wx.previewImage({
            current: n,
            urls: t
        });
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});