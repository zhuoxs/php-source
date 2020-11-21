var e = new getApp(), t = e.siteInfo.uniacid;

Page({
    data: {
        imgArr: [],
        orderData: [],
        orderDetail: [],
        module_name: "kundian_farm"
    },
    onLoad: function(a) {
        var r = this, o = a.order_id, i = wx.getStorageSync("kundian_farm_uid"), n = "kundian_farm";
        a.module_name && (n = a.module_name);
        var d = {}, u = "entry/wxapp/class";
        if ("kundian_farm" == n && (d = {
            control: "order",
            op: "getOrderDetail",
            uid: i,
            uniacid: t,
            order_id: o,
            module_name: n
        }), "kundian_farm_plugin_pt" == n) return u = e.util.getNewUrl("entry/wxapp/pt", n), 
        d = {
            op: "getCommentOrder",
            action: "index",
            uid: i,
            uniacid: t,
            order_id: o,
            module_name: n
        }, wx.request({
            url: u,
            data: d,
            success: function(e) {
                var t = e.data, a = t.orderDetail, o = t.orderData;
                a.map(function(e) {
                    e.score = 5, e.title = "非常好", e.commentSrc = new Array();
                }), r.setData({
                    orderData: o,
                    orderDetail: a,
                    module_name: n
                });
            }
        }), !1;
        e.util.request({
            url: u,
            data: d,
            success: function(e) {
                var t = e.data, a = t.orderDetail, o = t.orderData;
                a.map(function(e) {
                    e.score = 5, e.title = "非常好", e.commentSrc = new Array();
                }), r.setData({
                    orderData: o,
                    orderDetail: a,
                    module_name: n
                });
            }
        });
    },
    pickScore: function(e) {
        var t = e.currentTarget.dataset, a = t.goodsid, r = t.score, o = t.title, i = this.data.orderDetail;
        i.map(function(e) {
            e.goods_id == a && (e.score = r, e.title = o);
        }), this.setData({
            score: r,
            title: o,
            orderDetail: i
        });
    },
    addImg: function(e) {
        var t = this, a = e.currentTarget.dataset.goodsid, r = t.data.orderDetail;
        wx.chooseImage({
            count: 9,
            sizeType: [ "original", "compressed" ],
            sourceType: [ "album", "camera" ],
            success: function(e) {
                var o = e.tempFilePaths;
                r.map(function(e) {
                    if (e.goods_id == a) for (var t = 0; t < o.length; t++) e.commentSrc.push(o[t]);
                }), t.setData({
                    orderDetail: r
                });
            }
        });
    },
    deleteImg: function(e) {
        var t = e.currentTarget.dataset, a = t.index, r = t.goodsid, o = this.data.orderDetail;
        o.map(function(e) {
            e.goods_id == r && e.commentSrc.splice(a, 1);
        }), this.setData({
            orderDetail: o
        });
    },
    getContent: function(e) {
        var t = e.currentTarget.dataset.goodsid;
        this.data.orderDetail.map(function(a) {
            t == a.goods_id && (a.content = e.detail.value);
        });
    },
    submitData: function(a) {
        var r = this;
        wx.showToast({
            title: "正在发布中...",
            icon: "loading",
            mask: !0,
            duration: 1e4
        }), this.updateImg().then(function(a) {
            var o = wx.getStorageSync("kundian_farm_uid"), i = r.data.module_name;
            e.util.request({
                url: "entry/wxapp/class",
                data: {
                    control: "order",
                    op: "commentOrder",
                    orderDetail: JSON.stringify(a),
                    uniacid: t,
                    uid: o,
                    module_name: i
                },
                method: "POST",
                header: {
                    "content-type": "application/x-www-form-urlencoded"
                },
                success: function(e) {
                    wx.hideToast(), wx.showModal({
                        title: "提示",
                        content: e.data.msg,
                        showCancel: "false",
                        success: function() {
                            0 == e.data.code && wx.navigateBack({
                                delta: 1
                            });
                        }
                    });
                }
            });
        }).then(function() {});
    },
    updateImg: function() {
        var e = this, t = this.data.orderDetail;
        return new Promise(function(a, r) {
            Promise.all(e.geturl()).then(function(e) {
                for (var r = 0; r < t.length; r++) {
                    t[r].imgs = [];
                    for (var o = 0; o < e.length; o++) t[r].goods_id === e[o].id && t[r].imgs.push(e[o].url);
                }
                a(t);
            });
        });
    },
    geturl: function() {
        var e = this.data.orderDetail, t = [];
        for (var a in e) for (var r = 0; r < e[a].commentSrc.length; r++) t.push(this.uploadImg(e[a].commentSrc[r], e[a].goods_id));
        return t;
    },
    uploadImg: function(t, a) {
        var r = e.siteInfo.siteroot, o = (r = r.replace("app/index.php", "web/index.php")) + "?i=" + e.siteInfo.uniacid + "&c=utility&a=file&do=upload&thumb=0";
        return new Promise(function(e, r) {
            wx.uploadFile({
                url: o,
                filePath: t,
                name: "file",
                formData: {
                    op: "upload_file"
                },
                success: function(t) {
                    var r = JSON.parse(t.data);
                    e({
                        url: r.url,
                        id: a
                    });
                }
            });
        });
    }
});