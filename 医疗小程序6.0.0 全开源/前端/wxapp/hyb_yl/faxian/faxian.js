var app = getApp(), page = 1;

Page({
    data: {
        qusetiontype: [],
        nav: [ "/hyb_yl/images/hua1.png", "/hyb_yl/images/hua2.png", "/hyb_yl/images/hua1.png", "/hyb_yl/images/hua2.png" ],
        zan: !0,
        ismore: !0,
        none: [ {
            img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/微信图片_20180727121929.png",
            con: "暂无信息"
        } ],
        questionCon: [],
        current: 0
    },
    questionsZan: function(t) {
        var a = this.data.zan;
        a = 1 != a, this.setData({
            zan: a
        });
    },
    zixun: function() {
        wx.reLaunch({
            url: "/hyb_yl/zhuanjialiebiao/zhuanjialiebiao"
        });
    },
    searchClick: function() {
        wx.navigateTo({
            url: "/hyb_yl/search_01/search_01"
        });
    },
    historyListClick: function(t) {
        wx.navigateTo({
            url: "/hyb_yl/history_list/history_list"
        });
    },
    zhuanLiaoClick: function(t) {
        var a = t.currentTarget.dataset.money;
        console.log(a);
        var e = t.currentTarget.dataset.zid, n = t.currentTarget.dataset.qid, o = t.currentTarget.dataset.openid, i = t.currentTarget.dataset.fromuser, s = t.currentTarget.dataset.z_name, u = t.currentTarget.dataset.z_thumbs, r = t.currentTarget.dataset.z_zhiwu, l = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Adddianjil",
            header: {
                "Content-Type": "application/xml"
            },
            method: "GET",
            data: {
                qid: n
            },
            success: function(t) {
                console.log(t);
            }
        }), 0 == a || null == a ? wx.navigateTo({
            url: "/hyb_yl/zhuan_liao/zhuan_liao?zid=" + e + "&user_openid=" + o + "&qid=" + n + "&fromuser=" + i + "&z_name=" + s + "&z_thumbs=" + u + "&z_zhiwu=" + r
        }) : app.util.request({
            url: "entry/wxapp/Pay",
            header: {
                "Content-Type": "application/xml"
            },
            method: "GET",
            data: {
                openid: l,
                z_tw_money: a
            },
            success: function(t) {
                console.log(t), wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: t.data.signType,
                    paySign: t.data.paySign,
                    success: function(t) {
                        wx.navigateTo({
                            url: "/hyb_yl/zhuan_liao/zhuan_liao?zid=" + e + "&user_openid=" + o + "&qid=" + n + "&fromuser=" + i + "&z_name=" + s + "&z_thumbs=" + u + "&z_zhiwu=" + r
                        }), app.util.request({
                            url: "entry/wxapp/Goodsinfo",
                            data: {
                                money: a,
                                qid: n,
                                openid: l,
                                type1: 1
                            },
                            header: {
                                "content-type": "application/json"
                            },
                            success: function(t) {
                                console.log(t);
                            },
                            fail: function(t) {
                                console.log(t);
                            }
                        });
                    },
                    fail: function(t) {
                        app.util.request({
                            url: "entry/wxapp/Goodsinfo",
                            data: {
                                money: a,
                                qid: n,
                                openid: l,
                                type1: 0
                            },
                            header: {
                                "content-type": "application/json"
                            },
                            success: function(t) {
                                console.log(t);
                            },
                            fail: function(t) {
                                console.log(t);
                            }
                        });
                    }
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    navbar: function(t) {
        var e = this, a = t.currentTarget.dataset.id;
        e.setData({
            current: t.currentTarget.dataset.index
        }), app.util.request({
            url: "entry/wxapp/Questionimgsingle",
            data: {
                id: a
            },
            success: function(t) {
                console.log(t);
                var a = t.data.data;
                e.setData({
                    qusetiontype: a
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    onLoad: function(t) {
        wx.getStorageSync("userInfo");
        var a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        });
        var e = this;
        app.util.request({
            url: "entry/wxapp/Scurl",
            success: function(t) {
                e.setData({
                    scurl: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), app.util.request({
            url: "entry/wxapp/Questionimg",
            success: function(t) {
                e.setData({
                    questionimg: t.data.data
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), app.util.request({
            url: "entry/wxapp/Base",
            success: function(t) {
                e.setData({
                    bq_thumb: t.data.data.bq_thumb,
                    bq_name: t.data.data.bq_name
                });
            },
            fail: function(t) {
                console.log(t);
            }
        }), page = 1, e.getAllquestions(page);
    },
    previewImage: function(t) {
        for (var a = t.currentTarget.dataset.src, e = t.currentTarget.dataset.qid, n = this.data.qusetiontype, o = [], i = 0; i < n.length; i++) n[i].qid == e && (o = n[i].user_picture);
        wx.previewImage({
            current: a,
            urls: o
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var t = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: t
        }), this.getAllquestions(), wx.showNavigationBarLoading(), setTimeout(function() {
            wx.stopPullDownRefresh(), wx.hideNavigationBarLoading();
        }, 1e3);
    },
    onShareAppMessage: function() {},
    getAllquestions: function(t) {
        console.log(t);
        var o = this;
        app.util.request({
            url: "entry/wxapp/Qusetiontype",
            data: {
                page: t
            },
            success: function(t) {
                console.log(t), t.data.data.length < 5 && o.setData({
                    ismore: !1
                });
                for (var a = t.data.data, e = o.data.qusetiontype, n = (t.data.data.length, 0); n < a.length; n++) e.push(a[n]);
                o.setData({
                    qusetiontype: e
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
    },
    onReachBottom: function() {
        this.data.ismore && (page++, this.getAllquestions(page));
    }
});