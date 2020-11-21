var app = getApp();

Page({
    data: {
        shopId: "",
        commodityId: "",
        imgRoot: "",
        imgDisplay: "",
        imgBack: "",
        imgBan: [],
        imgDetails: [],
        index: "",
        classifyArra: [],
        classifyIdArray: [],
        classifyId: "",
        startDate: "",
        endDate: "",
        deliveryDate: "",
        serviceDate: "",
        startTime: "",
        endTime: "",
        deliveryTime: "",
        serviceTime: "",
        commodityInfo: {},
        video: []
    },
    onLoad: function(e) {
        this.setData({
            shopId: e.shopId
        }), this.getCommodityClassification(), e.commodityId && (this.setData({
            commodityId: e.commodityId
        }), this.getCommodityInfo());
    },
    chooseVideo: function() {
        var t = this;
        wx.chooseVideo({
            success: function(e) {
                console.log(e);
                var a = e.tempFilePath;
                console.log(a), wx.uploadFile({
                    url: app.siteInfo.siteroot + "?i=" + app.siteInfo.uniacid + "&from=wxapp&c=entry&a=wxapp&m=sqtg_sun&do=Cgoods|uploadVideo",
                    filePath: a,
                    name: "file",
                    formData: {
                        user: "test"
                    },
                    success: function(e) {
                        var a = JSON.parse(e.data);
                        console.log(a), t.setData({
                            video: a.data,
                            imgAddr: a.other.img_root
                        });
                    }
                });
            }
        });
    },
    deleteVideo: function() {
        var e = [ this.data.video ];
        this.setData({
            video: e.splice(1, 0)
        });
    },
    getImgDisplayGround: function(e) {
        console.log(e), this.setData({
            imgDisplay: e.detail
        });
    },
    getImgBackGround: function(e) {
        console.log(e), this.setData({
            imgBack: e.detail
        });
    },
    getImgBanGround: function(e) {
        console.log(e), this.setData({
            imgBan: e.detail
        });
    },
    getImgDetailsGround: function(e) {
        console.log(e), this.setData({
            imgDetails: e.detail
        });
    },
    bindStartDate: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            startDate: e.detail.value
        });
    },
    bindEndDate: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            endDate: e.detail.value
        });
    },
    bindDeliveryDate: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            deliveryDate: e.detail.value
        });
    },
    bindServiceDate: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            serviceDate: e.detail.value
        });
    },
    bindStartTime: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            startTime: e.detail.value
        });
    },
    bindEndTime: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            endTime: e.detail.value
        });
    },
    bindDeliveryTime: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            deliveryTime: e.detail.value
        });
    },
    bindServiceTime: function(e) {
        console.log("picker发送选择改变，携带值为", e.detail.value), this.setData({
            serviceTime: e.detail.value
        });
    },
    getCommodityClassification: function() {
        var a = this;
        app.ajax({
            url: "Ccategory|index",
            data: {},
            success: function(e) {
                console.log(e.data);
                var t = [], i = [];
                e.data.forEach(function(e, a) {
                    t.push(e.name), i.push(e.id);
                }), a.setData({
                    classifyArra: t,
                    classifyIdArray: i,
                    imgRoot: e.other.img_root
                });
            }
        });
    },
    bindPickerChange: function(e) {
        console.log("picker发送选择改变，携带值为", this.data.classifyIdArray[e.detail.value]), this.setData({
            index: e.detail.value,
            classifyId: this.data.classifyIdArray[e.detail.value]
        });
    },
    formBindsubmit: function(e) {
        var a = this;
        if (a.data.commodityId) return console.log(a.data.commodityId), void a.updateShop(e);
        var t = a.data.classifyId, i = e.detail.value.name, o = e.detail.value.price, d = e.detail.value.cost_price, s = e.detail.value.original_price, l = e.detail.value.less, n = e.detail.value.weight, c = e.detail.value.unit, r = e.detail.value.customer_tag, u = e.detail.value.stock, m = e.detail.value.virtual_num, v = e.detail.value.limit, g = e.detail.value.price, p = a.data.startDate + " " + a.data.startTime, f = a.data.endDate + " " + a.data.endTime, h = a.data.deliveryDate + " " + a.data.deliveryTime, D = a.data.serviceDate + " " + a.data.serviceTime, y = e.detail.value.service, _ = a.data.video, I = a.data.imgDetails, T = a.data.imgDisplay, k = a.data.imgBack, x = a.data.imgBan, w = a.data.shopId;
        console.log("传参"), console.log(t, i, 0, o, d, s, l, n, c, r, u, m, v, g, p, f, h, D, y, _, I, T, k, x), 
        app.ajax({
            url: "Cgoods|save",
            data: {
                cat_id: t,
                name: i,
                index: 0,
                price: o,
                cost_price: d,
                original_price: s,
                less: l,
                weight: n,
                unit: c,
                customer_tag: r,
                stock: u,
                virtual_num: m,
                limit: v,
                most_coin_use: g,
                begin_time: p,
                end_time: f,
                send_time: h,
                receive_time: D,
                service: y,
                details: "",
                video: _,
                img_details: I,
                pic: k,
                pics: x,
                home_pic: T,
                store_id: w
            },
            success: function(e) {
                console.log(e), 0 == e.code && wx.showToast({
                    title: "添加商品成功",
                    icon: "none",
                    duration: 5e3,
                    success: function() {
                        wx.reLaunch({
                            url: "/sqtg_sun/pages/zkx/pages/merchants/merchantcenter/merchantcenter"
                        });
                    }
                });
            }
        });
    },
    getCommodityInfo: function() {
        var n = this;
        app.ajax({
            url: "Cgoods|read",
            data: {
                goods_id: n.data.commodityId,
                store_id: n.data.shopId
            },
            success: function(t) {
                console.log(t);
                var e;
                e = t.data.begin_time.split(" ");
                var a;
                a = t.data.end_time.split(" ");
                var i;
                i = t.data.begin_time.split(" ");
                var o;
                o = t.data.receive_time.split(" ");
                var d;
                d = t.data.home_pic;
                var s;
                s = t.data.pic;
                t.data.pics;
                var l;
                l = JSON.parse(t.data.img_details), console.log(l), n.data.classifyIdArray.forEach(function(e, a) {
                    e == t.data.cat_id && n.setData({
                        index: a
                    });
                }), n.setData({
                    commodityInfo: t.data,
                    startDate: e[0],
                    startTime: e[1],
                    endDate: a[0],
                    endTime: a[1],
                    deliveryDate: i[0],
                    deliveryTime: i[1],
                    serviceDate: o[0],
                    serviceTime: o[1],
                    imgDisplay: [ d ],
                    imgBack: [ s ],
                    imgDetails: l,
                    imgBan: t.data.pics,
                    classifyId: t.data.cat_id,
                    classifyArra1: [ t.data.cat_name ],
                    video: t.data.video,
                    imgAddr: t.other.img_root
                });
            }
        });
    },
    updateShop: function(e) {
        var a = this, t = a.data.commodityId, i = a.data.classifyId, o = e.detail.value.name, d = e.detail.value.price, s = e.detail.value.cost_price, l = e.detail.value.original_price, n = e.detail.value.less, c = e.detail.value.weight, r = e.detail.value.unit, u = e.detail.value.customer_tag, m = e.detail.value.stock, v = e.detail.value.virtual_num, g = e.detail.value.limit, p = e.detail.value.price, f = a.data.startDate + " " + a.data.startTime, h = a.data.endDate + " " + a.data.endTime, D = a.data.deliveryDate + " " + a.data.deliveryTime, y = a.data.serviceDate + " " + a.data.serviceTime, _ = e.detail.value.service, I = a.data.video, T = a.data.imgDetails, k = a.data.imgDisplay, x = a.data.imgBack, w = a.data.imgBan, b = a.data.shopId;
        console.log("传参"), console.log(t, i, o, 0, d, s, l, n, c, r, u, m, v, g, p, f, h, D, y, _, I, T, k, x, w), 
        app.ajax({
            url: "Cgoods|save",
            data: {
                id: t,
                cat_id: i,
                name: o,
                index: 0,
                price: d,
                cost_price: s,
                original_price: l,
                less: n,
                weight: c,
                unit: r,
                customer_tag: u,
                stock: m,
                virtual_num: v,
                limit: g,
                most_coin_use: p,
                begin_time: f,
                end_time: h,
                send_time: D,
                receive_time: y,
                service: _,
                details: "",
                video: I,
                img_details: T,
                pic: x,
                pics: w,
                home_pic: k,
                store_id: b
            },
            success: function(e) {
                console.log(e), 0 == e.code && wx.showToast({
                    title: "添加商品成功",
                    icon: "none",
                    duration: 5e3,
                    success: function() {
                        wx.reLaunch({
                            url: "/sqtg_sun/pages/zkx/pages/merchants/merchantcenter/merchantcenter"
                        });
                    }
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});