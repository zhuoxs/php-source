var t = require("../../../../utils/base.js"), a = require("../../../../../api.js"), e = new t.Base(), s = getApp();

Page({
    data: {
        star: 5,
        content: ""
    },
    onLoad: function(t) {
        var a = {
            orderId: t.orderId,
            productId: t.productId,
            image: t.image,
            name: t.name,
            summary: t.summary
        }, e = JSON.stringify(t.attr_id_list).replace(/\"/g, "");
        this.setData({
            porduct: a,
            attr_id_list: e.split(",")
        });
    },
    chooseImage: function() {
        var t = this, e = [];
        wx.chooseImage({
            count: 6,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(i) {
                var r = i.tempFilePaths;
                t.setData({
                    tempFilePaths: r
                });
                for (var o = 0; o < r.length; o++) console.log(s.globalData.api_root + a.default.upload_images), 
                wx.uploadFile({
                    url: s.globalData.api_root + a.default.upload_images,
                    filePath: r[o],
                    name: "files",
                    header: {
                        token: wx.getStorageSync("token"),
                        uniacid: s.globalData.uniacid
                    },
                    success: function(a) {
                        console.log(a), wx.showToast({
                            title: "正在上传...",
                            icon: "loading",
                            mask: !0
                        }), a.data && e.push(a.data), t.setData({
                            imgs: e
                        });
                    }
                });
            }
        });
    },
    previewImage: function(t) {
        var a = t.currentTarget.dataset.index;
        wx.previewImage({
            current: this.data.imgs[a],
            urls: this.data.imgs
        });
    },
    deleteImage: function(t) {
        var s = this, i = this.data.imgs, r = t.currentTarget.dataset.index, o = t.currentTarget.dataset.src;
        i.splice(r, 1);
        var n = {
            url: a.default.uploadDel,
            data: {
                imageUrl: o
            }
        };
        e.getData(n, function(t) {
            1 == t.errorCode && s.setData({
                imgs: i
            });
        });
    },
    starBtn: function(t) {
        var a = t.currentTarget.dataset.star;
        this.setData({
            star: a
        });
    },
    content: function(t) {
        this.data.content = t.detail.value;
    },
    submit: function() {
        var t = {
            url: a.default.comment_submit,
            data: {
                orderId: this.data.porduct.orderId,
                productId: this.data.porduct.productId,
                content: this.data.content,
                score: this.data.star,
                image: this.data.imgs,
                attr_id_list: this.data.attr_id_list
            }
        };
        e.getData(t, function(t) {
            1 == t.errorCode && wx.showModal({
                title: "提示",
                content: t.msg,
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.navigateBack({
                        delta: 2
                    });
                }
            });
        });
    }
});