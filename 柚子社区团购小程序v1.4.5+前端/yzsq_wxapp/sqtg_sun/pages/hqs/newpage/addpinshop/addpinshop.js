var app = getApp();

function formatDateTime(a) {
    var t = new Date();
    t.setTime(1e3 * a);
    var e = t.getFullYear(), i = t.getMonth() + 1;
    i = i < 10 ? "0" + i : i;
    var o = t.getDate();
    o = o < 10 ? "0" + o : o;
    var n = t.getHours();
    n = n < 10 ? "0" + n : n;
    var d = t.getMinutes(), s = t.getSeconds();
    return e + "-" + i + "-" + o + " " + n + ":" + (d = d < 10 ? "0" + d : d) + ":" + (s = s < 10 ? "0" + s : s);
}

Page({
    data: {
        shopId: "",
        index: "",
        imgRoot: "",
        classifyArra: [],
        classifyIdArray: [],
        classifyId: "",
        stockArray: [ "不显示", "显示" ],
        alonepayArray: [ "关闭", "开启" ],
        groupCouponArray: [ "关闭", "开启" ],
        hotArray: [ "否", "是" ],
        imgDisplay: "",
        imgBack: "",
        imgBan: [],
        imgDetails: [],
        video: []
    },
    onLoad: function(a) {
        this.setData({
            shopId: a.shopId
        }), this.getCommodityClassification(), a.commodityId && (this.setData({
            commodityId: a.commodityId
        }), this.getCommodityInfo());
    },
    getCommodityClassification: function() {
        var t = this;
        app.ajax({
            url: "Cpin|classifyList",
            data: {},
            success: function(a) {
                console.log(a.data);
                var e = [], i = [];
                a.data.forEach(function(a, t) {
                    e.push(a.name), i.push(a.id);
                }), t.setData({
                    classifyArra: e,
                    classifyIdArray: i,
                    imgRoot: a.other.img_root
                });
            }
        });
    },
    chooseVideo: function() {
        var e = this;
        wx.chooseVideo({
            success: function(a) {
                console.log(a);
                var t = a.tempFilePath;
                console.log(t), wx.uploadFile({
                    url: app.siteInfo.siteroot + "?i=" + app.siteInfo.uniacid + "&from=wxapp&c=entry&a=wxapp&m=sqtg_sun&do=Cgoods|uploadVideo",
                    filePath: t,
                    name: "file",
                    formData: {
                        user: "test"
                    },
                    success: function(a) {
                        var t = JSON.parse(a.data);
                        console.log(t), e.setData({
                            video: t.data,
                            imgRoot: t.other.img_root
                        });
                    }
                });
            }
        });
    },
    deleteVideo: function() {
        var a = [ this.data.video ];
        this.setData({
            video: a.splice(1, 0)
        });
    },
    bindPickerChange: function(a) {
        console.log("picker发送选择改变，携带值为", this.data.classifyIdArray[a.detail.value]), this.setData({
            index: a.detail.value,
            classifyId: this.data.classifyIdArray[a.detail.value]
        });
    },
    bindPickerStock: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            indexStock: a.detail.value
        });
    },
    bindPickerAlonepay: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            indexAlonepay: a.detail.value
        });
    },
    bindPickerGroupCoupon: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            indexGroupCoupon: a.detail.value
        });
    },
    bindPickerHot: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            indexHot: a.detail.value
        });
    },
    bindStartDate: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            startDate: a.detail.value
        });
    },
    bindStartTime: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            startTime: a.detail.value
        });
    },
    bindEndDate: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            endDate: a.detail.value
        });
    },
    bindEndTime: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            endTime: a.detail.value
        });
    },
    getImgDisplayGround: function(a) {
        console.log(a), this.setData({
            imgDisplay: a.detail
        });
    },
    getImgBackGround: function(a) {
        console.log(a), this.setData({
            imgBack: a.detail
        });
    },
    getImgBanGround: function(a) {
        console.log(a), this.setData({
            imgBan: a.detail
        });
    },
    getImgDetailsGround: function(a) {
        console.log(a), this.setData({
            imgDetails: a.detail
        });
    },
    formBindsubmit: function(a) {
        var t = this;
        if (t.data.commodityId) return console.log(t.data.commodityId), void t.updateShop(a);
        var e = t.data.classifyId, i = a.detail.value.name, o = a.detail.value.stock, n = t.data.indexStock, d = a.detail.value.pin_price, s = a.detail.value.original_price, l = a.detail.value.cost_price, c = a.detail.value.pin_price, u = t.data.indexAlonepay, r = a.detail.value.price, p = a.detail.value.need_num, m = a.detail.value.limit_num, g = a.detail.value.limit_times, _ = a.detail.value.group_time, v = a.detail.value.pay_time, h = a.detail.value.unit, f = a.detail.value.sales_xnnum, y = a.detail.value.group_xnnum, D = t.data.startDate + " " + t.data.startTime, x = t.data.endDate + " " + t.data.endTime, k = t.data.indexGroupCoupon, I = a.detail.value.coupon_money, A = a.detail.value.coupon_discount, C = t.data.indexHot, T = a.detail.value.details, B = t.data.video, S = (T = t.data.imgDetails, 
        t.data.imgDisplay), w = t.data.imgBack, b = t.data.imgBan, G = t.data.shopId;
        console.log("传参"), console.log(e, i, o, n, d, s, l, c, u, r, p, m, g, _, v, h, f, y, D, x, k, I, A, C, B, T, S, w, b, G), 
        app.ajax({
            url: "Cpin|save",
            data: {
                cid: e,
                name: i,
                stock: o,
                is_stock: n,
                pin_price: d,
                original_price: s,
                cost_price: l,
                most_coin_use: c,
                is_alonepay: u,
                price: r,
                need_num: p,
                limit_num: m,
                limit_times: g,
                group_time: _,
                pay_time: v,
                unit: h,
                sales_xnnum: f,
                group_xnnum: y,
                start_time: D,
                end_time: x,
                is_group_coupon: k,
                coupon_money: I,
                coupon_discount: A,
                is_hot: C,
                details: "",
                video: B,
                img_details: T,
                home_pic: S,
                pic: w,
                pics: b,
                store_id: G
            },
            success: function(a) {
                console.log(a), 0 == a.code && wx.showToast({
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
        var l = this;
        app.ajax({
            url: "Cpin|pingoods",
            data: {
                pingoods_id: l.data.commodityId,
                store_id: l.data.shopId
            },
            success: function(e) {
                console.log(e);
                var a, t = formatDateTime(e.data.start_time), i = formatDateTime(e.data.end_time);
                a = t.split(" ");
                var o;
                o = i.split(" ");
                var n;
                n = e.data.home_pic;
                var d;
                d = e.data.pic;
                e.data.pics;
                var s;
                s = JSON.parse(e.data.img_details), console.log(s), l.data.classifyIdArray.forEach(function(a, t) {
                    a == e.data.cid && l.setData({
                        index: t
                    });
                }), l.setData({
                    commodityInfo: e.data,
                    startDate: a[0],
                    startTime: a[1],
                    endDate: o[0],
                    endTime: o[1],
                    imgDetails: s,
                    imgDisplay: [ n ],
                    imgBack: [ d ],
                    imgBan: e.data.pics,
                    classifyId: e.data.cid,
                    classifyArra1: [ e.data.cat_name ],
                    indexStock: e.data.is_stock,
                    indexAlonepay: e.data.is_alonepay,
                    indexGroupCoupon: e.data.is_group_coupon,
                    indexHot: e.data.is_hot,
                    imgRoot: e.other.img_root,
                    video: e.data.video
                });
            }
        });
    },
    updateShop: function(a) {
        var t = this, e = t.data.commodityId, i = t.data.classifyId, o = a.detail.value.name, n = a.detail.value.stock, d = t.data.indexStock, s = a.detail.value.pin_price, l = a.detail.value.original_price, c = a.detail.value.cost_price, u = a.detail.value.pin_price, r = t.data.indexAlonepay, p = a.detail.value.price, m = a.detail.value.need_num, g = a.detail.value.limit_num, _ = a.detail.value.limit_times, v = a.detail.value.group_time, h = a.detail.value.pay_time, f = a.detail.value.unit, y = a.detail.value.sales_xnnum, D = a.detail.value.group_xnnum, x = t.data.startDate + " " + t.data.startTime, k = t.data.endDate + " " + t.data.endTime, I = t.data.indexGroupCoupon, A = a.detail.value.coupon_money, C = a.detail.value.coupon_discount, T = t.data.indexHot, B = a.detail.value.details, S = t.data.video, w = (B = t.data.imgDetails, 
        t.data.imgDisplay), b = t.data.imgBack, G = t.data.imgBan, P = t.data.shopId;
        console.log("传参"), console.log(e, i, o, n, d, s, l, c, u, r, p, m, g, _, v, h, f, y, D, x, k, I, A, C, T, S, B, w, b, G, P), 
        app.ajax({
            url: "Cpin|save",
            data: {
                id: e,
                cid: i,
                name: o,
                stock: n,
                is_stock: d,
                pin_price: s,
                original_price: l,
                cost_price: c,
                most_coin_use: u,
                is_alonepay: r,
                price: p,
                need_num: m,
                limit_num: g,
                limit_times: _,
                group_time: v,
                pay_time: h,
                unit: f,
                sales_xnnum: y,
                group_xnnum: D,
                start_time: x,
                end_time: k,
                is_group_coupon: I,
                coupon_money: A,
                coupon_discount: C,
                is_hot: T,
                details: "",
                video: S,
                img_details: B,
                home_pic: w,
                pic: b,
                pics: G,
                store_id: P
            },
            success: function(a) {
                console.log(a), 0 == a.code && wx.showToast({
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
    }
});