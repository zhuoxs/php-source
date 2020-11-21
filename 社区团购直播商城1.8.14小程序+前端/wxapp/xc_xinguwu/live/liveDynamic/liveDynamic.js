var app = getApp();

Page({
    data: {
        max: 3,
        files: [],
        remind: [ {
            img: "../../images/head.png"
        }, {
            img: "../../images/head.png"
        }, {
            img: "../../images/head.png"
        }, {
            img: "../../images/head.png"
        }, {
            img: "../../images/head.png"
        }, {
            img: "../../images/head.png"
        } ]
    },
    remind: function() {
        wx.navigateTo({
            url: "../liveRemind/liveRemind"
        });
    },
    chooseImage: function(e) {
        var a = this, i = this.data.files;
        wx.chooseImage({
            count: 9 - i.length,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                var i = e.tempFilePaths;
                e.tempFiles.forEach(function(e, a) {
                    2048e3 < e.size && (i.splice(a, 1), app.look.alert("图片尺寸过大"));
                }), a.setData({
                    files: a.data.files.concat(i)
                });
            }
        });
    },
    deleteImg: function(e) {
        var a = this.data.files, i = e.currentTarget.dataset.index;
        a.splice(i, 1), this.setData({
            files: a
        });
    },
    previewImage: function(e) {
        wx.previewImage({
            current: e.currentTarget.id,
            urls: this.data.files
        });
    },
    myform: function(e) {
        console.log(e);
        var a = this, i = e.detail.value.text, t = a.data.files;
        if ("" != i || 0 != t.length) {
            wx.showLoading({
                title: "提交中"
            });
            var n = app.look.updata(t);
            app.util.request({
                url: "entry/wxapp/live",
                method: "POST",
                showLoading: !1,
                data: {
                    op: "in_dynamic",
                    id: a.data.options.id,
                    text: i,
                    imgs: n
                },
                success: function(e) {
                    wx.hideLoading(), app.look.ok("发表成功", function() {
                        wx.redirectTo({
                            url: "../liveIndex/liveIndex?style=2&id=" + a.data.options.id
                        });
                    });
                },
                fail: function() {
                    wx.hideLoading(), app.look.no("操作失败");
                }
            });
        } else app.look.no("内容不能为空");
    },
    onLoad: function(e) {
        this.setData({
            options: e
        });
    },
    onReady: function() {
        var e = {};
        e.dy_add = app.module_url + "resource/wxapp/live/dy-add.png", e.create_close = app.module_url + "resource/wxapp/live/create-close.png", 
        this.setData({
            images: e
        }), app.look.navbar(this);
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});