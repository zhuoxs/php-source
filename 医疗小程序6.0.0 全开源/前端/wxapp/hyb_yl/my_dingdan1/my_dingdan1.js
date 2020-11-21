var app = getApp();

Page({
    data: {
        nav: {
            nav_list: [ {
                img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/dingdan.png",
                con: "全部"
            }, {
                img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/ding_wei.png",
                con: "未支付"
            }, {
                img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/ding_yi.png",
                con: "已支付"
            } ],
            currentTab: 0
        },
        dingdanArr: [ {
            time: "2018-05-06 12:35:00",
            state: "0",
            img: "../images/active_01.jpg",
            title: "上班族支付体检基本套餐",
            shop: "山西省疾病预防体检中心",
            num: "x3",
            pay: "￥1293"
        }, {
            time: "2018-05-06 12:35:00",
            state: "1",
            img: "../images/active_01.jpg",
            title: "上班族支付体检基本套餐",
            shop: "山西省疾病预防体检中心",
            num: "x3",
            pay: "￥1293"
        }, {
            time: "2018-05-06 12:35:00",
            state: "2",
            img: "../images/active_01.jpg",
            title: "上班族支付体检基本套餐",
            shop: "山西省疾病预防体检中心",
            num: "x3",
            pay: "￥1293"
        } ]
    },
    swichNav: function(t) {
        var a = this, e = this.data.nav;
        e.currentTab = t.currentTarget.dataset.current, this.setData({
            nav: e
        }), console.log(t);
        var n = t.currentTarget.dataset.current, o = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Myfuwuorder",
            data: {
                openid: o,
                index: n
            },
            success: function(t) {
                console.log(t), a.setData({
                    fuorder: t.data.data
                });
            }
        });
    },
    payClick: function(t) {
        console.log(t);
        var a = t.currentTarget.dataset.m_oid, e = t.currentTarget.dataset.m_oid, n = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Pay",
            header: {
                "Content-Type": "application/xml"
            },
            method: "GET",
            data: {
                openid: n,
                z_tw_money: e
            },
            success: function(t) {
                console.log(t), wx.requestPayment({
                    timeStamp: t.data.timeStamp,
                    nonceStr: t.data.nonceStr,
                    package: t.data.package,
                    signType: t.data.signType,
                    paySign: t.data.paySign,
                    success: function(t) {
                        app.util.request({
                            url: "entry/wxapp/Upgoods",
                            data: {
                                openid: wx.getStorageSync("openid"),
                                m_oid: a
                            },
                            success: function(t) {
                                console.log(t), wx.showToast({
                                    title: "支付成功",
                                    icon: "success"
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    delClick: function(t) {
        var a = this;
        console.log(t);
        var e = a.data.fuorder, n = t.currentTarget.dataset.index, o = t.currentTarget.dataset.m_oid;
        e.splice(n, 1), console.log(e), wx.showModal({
            content: "是否删除",
            success: function(t) {
                t.cancel || app.util.request({
                    url: "entry/wxapp/Delmyorder",
                    data: {
                        m_oid: o
                    },
                    success: function(t) {
                        console.log(t), a.setData({
                            fuorder: e
                        });
                    }
                });
            }
        });
    },
    tijianDetailClick: function() {
        wx.navigateTo({
            url: "/pages/tijian_detail/tijian_detail?currentTab=1"
        });
    },
    tijianDetailClick2: function() {
        wx.navigateTo({
            url: "/pages/tijian_detail/tijian_detail?currentTab=1&focus=" + !0
        });
    },
    tijianDetailClick1: function() {
        wx.navigateTo({
            url: "/pages/tijian_detail/tijian_detail"
        });
    },
    onLoad: function(t) {
        var a = wx.getStorageSync("color");
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: a
        });
    },
    onReady: function() {
        this.getMyfuwuorder();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    getMyfuwuorder: function() {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Myfuwuorder",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                console.log(t), a.setData({
                    fuorder: t.data.data
                });
            }
        });
    }
});