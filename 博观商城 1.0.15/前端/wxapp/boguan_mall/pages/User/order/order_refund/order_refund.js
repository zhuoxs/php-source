var e = require("../../../../utils/base.js"), t = require("../../../../../api.js"), a = new e.Base(), r = getApp();

Page({
    data: {},
    onLoad: function(e) {
        console.log("options=>", e), this.refundPrice(e), 1 == e.refund ? this.orderDetail(e) : this.orderRefund(e.orderId, e.productId), 
        this.setData({
            orderId: e.orderId,
            productId: e.productId
        });
    },
    orderRefund: function(e, r) {
        var o = this, d = {
            url: t.default.refund_detail,
            data: {
                orderId: e
            }
        };
        console.log("参数=>", d), a.getData(d, function(e) {
            console.log("售后=>", e), 1 == e.errorCode && o.setData({
                orderInfo: e.data,
                goodPrice: Number(e.data.snap_info.discount).toFixed(2)
            });
        });
    },
    orderDetail: function(e) {
        var t = e.attr_id_list, a = e.attr_name, r = t.split(","), o = a.split(",");
        this.setData({
            orderId: e.orderId,
            productId: e.productId,
            image: e.image,
            name: e.name,
            price: e.price,
            num: e.num,
            attr_name: o,
            attr_id_list: r,
            refund: e.refund,
            goodPrice: (Number(e.price * e.num) - Number(e.discount)).toFixed(2)
        });
    },
    refundPrice: function(e) {
        console.log("页面参数=>", e);
        var t = Number(e.price), a = Number(e.num), r = Number(e.express_price), o = Number(e.delivery_price), d = Number(e.o_amount), i = Number(e.goodsPrice), s = e.order_type, n = 0;
        n = 1 == s ? t * a / i * (d - r) : 2 == s ? t * a / (i + o) * (d - o) : t * a / i * d, 
        this.setData({
            refundPrice: Math.floor(100 * n) / 100
        }), console.log("refundPrice=>", Math.floor(100 * n) / 100);
    },
    chooseImage: function() {
        var e = this, a = [];
        wx.chooseImage({
            count: 6,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(o) {
                console.log(o), console.log(r.globalData.uniacid);
                var d = o.tempFilePaths;
                e.setData({
                    tempFilePaths: d
                });
                for (var i = 0; i < d.length; i++) console.log(r.globalData.api_root + t.default.upload_images), 
                wx.uploadFile({
                    url: r.globalData.api_root + t.default.upload_images,
                    filePath: d[i],
                    name: "files",
                    header: {
                        token: wx.getStorageSync("token"),
                        uniacid: r.globalData.uniacid
                    },
                    success: function(t) {
                        console.log(t), wx.showToast({
                            title: "正在上传...",
                            icon: "loading",
                            mask: !0
                        }), t.data && a.push(t.data), e.setData({
                            imgs: a
                        });
                    }
                });
            }
        });
    },
    previewImage: function(e) {
        var t = e.currentTarget.dataset.index;
        wx.previewImage({
            current: this.data.imgs[t],
            urls: this.data.imgs
        });
    },
    deleteImage: function(e) {
        var r = this, o = this.data.imgs, d = e.currentTarget.dataset.index, i = e.currentTarget.dataset.src;
        o.splice(d, 1);
        var s = {
            url: t.default.uploadDel,
            data: {
                imageUrl: i
            }
        };
        a.getData(s, function(e) {
            1 == e.errorCode && r.setData({
                imgs: o
            });
        });
    },
    refund: function(e) {
        var r = e.detail.value.remark, o = {
            url: t.default.refund_submit,
            data: {
                orderId: this.data.orderId,
                productId: this.data.productId,
                attr_id_list: this.data.attr_id_list,
                remark: r,
                image: this.data.imgs,
                formId: e.detail.formId
            }
        };
        a.getData(o, function(e) {
            1 == e.errorCode ? wx.showModal({
                title: e.msg,
                showCancel: !1,
                success: function(e) {
                    wx.redirectTo({
                        url: "../order/order?kind=after&sindex=5"
                    });
                }
            }) : wx.showModal({
                title: "提示",
                content: e.msg,
                showCancel: !1
            });
        });
    },
    refundExpress: function(e) {
        var r = {
            url: t.default.refund_confirm,
            data: {
                orderId: this.data.orderId,
                expressName: e.detail.value.express,
                expressNumber: e.detail.value.express_no
            }
        };
        a.getData(r, function(e) {
            wx.showModal({
                title: e.msg,
                showCancel: !1,
                success: function(e) {
                    wx.redirectTo({
                        url: "../order/order?kind=after&sindex=5"
                    });
                }
            });
        });
    }
});