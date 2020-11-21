var app = getApp();

Page({
    data: {
        gid: "",
        curIndex: 0,
        nav: [ "普通", "砍价", "拼团", "抢购", "优惠券" ],
        lids: [ 1, 2, 3, 5, 7 ],
        imgRoot: "",
        stocktype: 0,
        stocks: [ {
            name: "0",
            value: "下单",
            checked: "true"
        }, {
            name: "1",
            value: "付款"
        } ],
        canrefund: 0,
        refunds: [ {
            name: "0",
            value: "可以",
            checked: "true"
        }, {
            name: "1",
            value: "不能"
        } ],
        mustlowprice: 0,
        mustlowprices: [ {
            name: "0",
            value: "否",
            checked: "true"
        }, {
            name: "1",
            value: "是"
        } ],
        isshelf: 0,
        isshelfs: [ {
            name: "0",
            value: "下架",
            checked: "true"
        }, {
            name: "1",
            value: "上架"
        } ],
        startDate: "",
        endDate: "",
        startTime: "",
        endTime: "",
        deliveryDate: "",
        deliveryTime: "",
        indexImg: [],
        pic: [],
        index3Img: [],
        lbImgs: [],
        imgDetails: [],
        commodityInfo: [],
        index: "",
        classifyIdArray: [],
        classifyArra: [],
        classifyId: ""
    },
    onLoad: function(d) {
        var r = this;
        d.index && r.setData({
            curIndex: d.index
        });
        var c = r.data.stocks, o = r.data.refunds, m = r.data.mustlowprices, u = r.data.isshelfs;
        if (d.gid) {
            var g = r.data.lids[d.index];
            app.util.request({
                url: "entry/wxapp/GetGoodsDetail",
                cachetime: "0",
                data: {
                    lid: g,
                    gid: d.gid
                },
                success: function(a) {
                    if (console.log(a.data), 7 != g) {
                        c[a.data.stocktype].checked = "true", o[a.data.canrefund].checked = "true", m[a.data.mustlowprice].checked = "true", 
                        u[a.data.isshelf].checked = "true";
                        var t = [];
                        t = a.data.expirationtime.split(" ");
                        var e = [];
                        e = a.data.index_img;
                        var i = [];
                        i = a.data.index3_img;
                    }
                    var n;
                    n = a.data.astime.split(" ");
                    var s;
                    s = a.data.antime.split(" ");
                    var l;
                    l = a.data.pic, 7 == g ? r.setData({
                        commodityInfo: a.data,
                        startDate: n[0],
                        startTime: n[1],
                        endDate: s[0],
                        endTime: s[1],
                        pic: [ l ],
                        gid: d.gid,
                        imgDetails: a.data.img_details,
                        index: a.data.cid
                    }) : r.setData({
                        commodityInfo: a.data,
                        stocks: c,
                        refunds: o,
                        mustlowprices: m,
                        isshelfs: u,
                        startDate: n[0],
                        startTime: n[1],
                        endDate: s[0],
                        endTime: s[1],
                        deliveryDate: t[0],
                        deliveryTime: t[1],
                        indexImg: [ e ],
                        pic: [ l ],
                        index3Img: [ i ],
                        lbImgs: a.data.lb_imgs,
                        imgDetails: a.data.img_details,
                        gid: d.gid
                    });
                }
            });
        }
        app.util.request({
            url: "entry/wxapp/getCouponCate",
            success: function(a) {
                if (console.log(a.data), 2 == a.data) r.setData({
                    classifyArra: []
                }); else {
                    var e = [], i = [];
                    a.data.forEach(function(a, t) {
                        e.push(a.catename), i.push(a.id);
                    }), r.setData({
                        classifyArra: e,
                        classifyIdArray: i
                    });
                }
            }
        });
    },
    bindPickerChange: function(a) {
        console.log(a), console.log("picker发送选择改变，携带值为", this.data.classifyIdArray[a.detail.value]), 
        this.setData({
            index: a.detail.value,
            classifyId: this.data.classifyIdArray[a.detail.value]
        });
    },
    bindStartDate: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            startDate: a.detail.value
        });
    },
    bindEndDate: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            endDate: a.detail.value
        });
    },
    bindDeliveryDate: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            deliveryDate: a.detail.value
        });
    },
    bindStartTime: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            startTime: a.detail.value
        });
    },
    bindEndTime: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            endTime: a.detail.value
        });
    },
    bindDeliveryTime: function(a) {
        console.log("picker发送选择改变，携带值为", a.detail.value), this.setData({
            deliveryTime: a.detail.value
        });
    },
    getIndexImgGround: function(a) {
        console.log(a);
        for (var t = a.detail, e = 0; e < t.length; e++) {
            var i = RegExp(/attachment/);
            if (t[e].match(i)) for (var n = t[e].split("attachment"), s = 0; s < n.length; s++) {
                var l = RegExp(/images/);
                n[s].match(l) && (t[e] = n[s].substr(1));
            }
        }
        this.setData({
            indexImg: t
        });
    },
    getPicGround: function(a) {
        console.log(a);
        for (var t = a.detail, e = 0; e < t.length; e++) {
            var i = RegExp(/attachment/);
            if (t[e].match(i)) for (var n = t[e].split("attachment"), s = 0; s < n.length; s++) {
                var l = RegExp(/images/);
                n[s].match(l) && (t[e] = n[s].substr(1));
            }
        }
        this.setData({
            pic: t
        });
    },
    getIndex3ImgGround: function(a) {
        console.log(a);
        for (var t = a.detail, e = 0; e < t.length; e++) {
            var i = RegExp(/attachment/);
            if (t[e].match(i)) for (var n = t[e].split("attachment"), s = 0; s < n.length; s++) {
                var l = RegExp(/images/);
                n[s].match(l) && (t[e] = n[s].substr(1));
            }
        }
        this.setData({
            index3Img: t
        });
    },
    geLbImgsGround: function(a) {
        for (var t = a.detail, e = 0; e < t.length; e++) {
            var i = RegExp(/attachment/);
            if (t[e].match(i)) for (var n = t[e].split("attachment"), s = 0; s < n.length; s++) {
                var l = RegExp(/images/);
                n[s].match(l) && (t[e] = n[s].substr(1));
            }
        }
        this.setData({
            lbImgs: t
        });
    },
    getImgDetailsGround: function(a) {
        for (var t = a.detail, e = 0; e < t.length; e++) {
            var i = RegExp(/attachment/);
            if (t[e].match(i)) for (var n = t[e].split("attachment"), s = 0; s < n.length; s++) {
                var l = RegExp(/images/);
                n[s].match(l) && (t[e] = n[s].substr(1));
            }
        }
        this.setData({
            imgDetails: t
        });
    },
    formBindsubmit: function(a) {
        for (var t = this, e = t.data.classifyId, i = a.detail.value.allowance, n = a.detail.value.total, s = a.detail.value.expiryDate, l = t.data.gid, d = t.data.lids, r = t.data.curIndex, c = d[r], o = a.detail.value.gname, m = a.detail.value.ptshopprice, u = a.detail.value.shopprice, g = a.detail.value.num, h = t.data.stocktype, p = t.data.canrefund, v = t.data.startDate + " " + t.data.startTime, f = t.data.endDate + " " + t.data.endTime, x = t.data.deliveryDate + " " + t.data.deliveryTime, D = t.data.isshelf, y = t.data.indexImg, b = 0; b < y.length; b++) {
            var I = RegExp(/attachment/);
            if (y[b].match(I)) for (var k = y[b].split("attachment"), R = 0; R < k.length; R++) {
                var E = RegExp(/images/);
                k[R].match(E) && (y[b] = k[R].substr(1));
            }
        }
        var T = y[0], w = t.data.pic;
        for (b = 0; b < w.length; b++) {
            I = RegExp(/attachment/);
            if (w[b].match(I)) for (k = w[b].split("attachment"), R = 0; R < k.length; R++) {
                E = RegExp(/images/);
                k[R].match(E) && (w[b] = k[R].substr(1));
            }
        }
        w = w[0];
        var _ = t.data.index3Img;
        for (b = 0; b < _.length; b++) {
            I = RegExp(/attachment/);
            if (_[b].match(I)) for (k = _[b].split("attachment"), R = 0; R < k.length; R++) {
                E = RegExp(/images/);
                k[R].match(E) && (_[b] = k[R].substr(1));
            }
        }
        var A = _[0], G = t.data.lbImgs;
        for (b = 0; b < G.length; b++) {
            I = RegExp(/attachment/);
            if (G[b].match(I)) for (k = G[b].split("attachment"), R = 0; R < k.length; R++) {
                E = RegExp(/images/);
                k[R].match(E) && (G[b] = k[R].substr(1));
            }
        }
        var C = G, S = t.data.imgDetails;
        for (b = 0; b < S.length; b++) {
            I = RegExp(/attachment/);
            if (S[b].match(I)) for (k = S[b].split("attachment"), R = 0; R < k.length; R++) {
                E = RegExp(/images/);
                k[R].match(E) && (S[b] = k[R].substr(1));
            }
        }
        var q = S, j = wx.getStorageSync("brand_info").bid, P = a.detail.value.kjprice, B = t.data.mustlowprice, L = a.detail.value.cutnum, z = a.detail.value.ptprice, H = a.detail.value.ptnum, U = a.detail.value.limittime, F = a.detail.value.probably, J = a.detail.value.qgprice, K = a.detail.value.limitnum;
        C && (C = C.join(",")), q && (q = q.join(",")), app.util.request({
            url: "entry/wxapp/SaveGoods",
            cachetime: "0",
            data: {
                gid: l,
                lid: c,
                gname: o,
                ptshopprice: m,
                kjprice: P,
                ptprice: z,
                qgprice: J,
                shopprice: u,
                num: g,
                cutnum: L,
                ptnum: H,
                limittime: U,
                limitnum: K,
                probably: F,
                stocktype: h,
                canrefund: p,
                isshelf: D,
                mustlowprice: B,
                astime: v,
                aetime: f,
                expirationtime: x,
                index_img: T,
                pic: w,
                index3_img: A,
                lb_imgs: C,
                img_details: q,
                bid: j,
                classifyId: e,
                allowance: i,
                total: n,
                expiryDate: s
            },
            success: function(a) {
                console.log(a.data), "success" == a.data && wx.navigateTo({
                    url: "/mzhk_sun/pages/backstage/mygoods/mygoods?index=" + r + "&lid=" + c
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
    bargainTap: function(a) {
        var t = parseInt(a.currentTarget.dataset.index);
        if (0 < this.data.gid) return !1;
        this.setData({
            curIndex: t
        });
    },
    radioChange: function(a) {
        var t = a.detail.value;
        this.setData({
            stocktype: t
        });
    },
    radioChange2: function(a) {
        var t = a.detail.value;
        this.setData({
            canrefund: t
        });
    },
    radioChange3: function(a) {
        var t = a.detail.value;
        this.setData({
            mustlowprice: t
        });
    },
    radioChange4: function(a) {
        var t = a.detail.value;
        this.setData({
            isshelf: t
        });
    }
});