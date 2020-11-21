/*   time:2019-08-09 13:18:47*/
var app = getApp();
Page({
    data: {
        lbImgs: []
    },
    onLoad: function(o) {
        var e = wx.getStorageSync("openid"),
            a = wx.getStorageSync("url");
        console.log(a), this.setData({
            openid: e,
            url: a
        }), o.editid && this.setData({
            editid: o.editid
        }), this.onCloudShopApply(), this.getShopkeeper()
    },
    onCloudShopApply: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/CloudShopApply",
            showLoading: !1,
            data: {
                openid: e.data.openid,
                m: app.globalData.Plugin_cloud
            },
            success: function(o) {
                console.log(o), 2 == o.data && -1 == e.data.editid ? e.setData({
                    shopkeeper: o.data
                }) : 2 == o.data ? wx.showModal({
                    title: "前往云店中心",
                    content: "您已是云店店主",
                    showCancel: !1,
                    success: function(o) {
                        if (o.confirm) return console.log("用户点击确定"), wx.redirectTo({
                            url: "/mzhk_sun/plugin3/cloudShop/managementCenter/managementCenter"
                        }), !1;
                        o.cancel && console.log("用户点击取消")
                    }
                }) : e.setData({
                    prescription: o.data
                })
            }
        })
    },
    geLbImgsGround: function(o) {
        var e = o.detail;
        console.log(e);
        for (var a = 0; a < e.length; a++) {
            var t = RegExp(/attachment/);
            if (e[a].match(t)) for (var n = e[a].split("attachment"), l = 0; l < n.length; l++) {
                var s = RegExp(/images/);
                n[l].match(s) && (e[a] = n[l].substr(1))
            }
        }
        this.setData({
            lbImgs: e
        })
    },
    formBindsubmit: function(o) {
        var e = this;
        if (2 != e.data.shopkeeper) {
            console.log(o);
            var a = e.data.openid,
                t = e.data.prescription.settled_money,
                n = o.detail.value.welcoming,
                l = o.detail.value.shopname,
                s = o.detail.value.contacts,
                i = o.detail.value.mobilephone,
                p = o.detail.value.shopcontacts,
                c = e.data.lbImgs;
            console.log("传参"), console.log(a, t, n, l, s, i, p, c, 0), app.util.request({
                url: "entry/wxapp/Orderarr",
                data: {
                    openid: a,
                    price: t
                },
                success: function(o) {
                    console.log(o), wx.requestPayment({
                        timeStamp: o.data.timeStamp,
                        nonceStr: o.data.nonceStr,
                        package: o.data.package,
                        signType: o.data.signType,
                        paySign: o.data.paySign,
                        success: function(o) {
                            console.log(), app.util.request({
                                url: "entry/wxapp/CloudShopAdd",
                                data: {
                                    m: app.globalData.Plugin_cloud,
                                    openid: a,
                                    welcoming: n,
                                    shopname: l,
                                    contacts: s,
                                    mobilephone: i,
                                    shopcontacts: p,
                                    shopbanner: c,
                                    type: 0
                                },
                                success: function(o) {
                                    console.log("提交成功"), console.log(o), wx.redirectTo({
                                        url: "/mzhk_sun/pages/user/user"
                                    })
                                }
                            })
                        },
                        fail: function(o) {
                            wx.showToast({
                                title: "支付失败",
                                icon: "error",
                                duration: 2e3
                            })
                        }
                    })
                }
            })
        } else e.updateShop(o)
    },
    getShopkeeper: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/CloudShopUser",
            data: {
                openid: e.data.openid,
                m: app.globalData.Plugin_cloud
            },
            success: function(o) {
                console.log("获取店主信息"), console.log(o), e.setData({
                    prescription: o.data
                })
            }
        })
    },
    updateShop: function(o) {
        var e = this;
        console.log(o);
        var a = e.data.prescription.id,
            t = e.data.openid,
            n = o.detail.value.welcoming,
            l = o.detail.value.shopname,
            s = o.detail.value.contacts,
            i = o.detail.value.mobilephone,
            p = o.detail.value.shopcontacts,
            c = e.data.uploadPicTwo;
        console.log("传参"), console.log(a, t, n, l, s, i, p, c, 1), app.util.request({
            url: "entry/wxapp/CloudShopAdd",
            data: {
                m: app.globalData.Plugin_cloud,
                shopid: a,
                openid: t,
                welcoming: n,
                shopname: l,
                contacts: s,
                mobilephone: i,
                shopcontacts: p,
                shopbanner: c,
                type: 1
            },
            success: function(o) {
                console.log("提交成功"), console.log(o), wx.redirectTo({
                    url: "/mzhk_sun/pages/user/user"
                })
            }
        })
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});