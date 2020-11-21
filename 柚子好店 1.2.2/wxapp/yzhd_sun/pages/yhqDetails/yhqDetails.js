var app = getApp();

Page({
    data: {},
    onLoad: function(o) {
        console.log(o);
        var t = this, a = o.id, e = o.bid;
        console.log(a);
        var n = wx.getStorageSync("openid");
        t.setData({
            got: 2,
            id: o.id,
            bid: o.bid
        }), wx.getStorage({
            key: "url",
            success: function(o) {
                t.setData({
                    url: o.data
                });
            }
        });
        n = wx.getStorageSync("openid");
        console.log(n), app.util.request({
            url: "entry/wxapp/UserISGetCoupon",
            cachetime: "0",
            data: {
                cid: a,
                openid: n
            },
            success: function(o) {
                console.log(o), o.data && t.setData({
                    got: 1,
                    userCouInfo: o.data,
                    openid: n,
                    qrcode: o.data.qrcode
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetCouponDetail",
            cachetime: "0",
            data: {
                cid: a
            },
            success: function(o) {
                console.log(o), t.setData({
                    CouponInfo: o.data.data,
                    openid: n
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetBranchDetail",
            cachetime: "0",
            data: {
                bid: e
            },
            success: function(o) {
                t.setData({
                    shopInfo: o.data.data
                });
            }
        }), t.diyWinColor();
    },
    getNowTap: function(o) {
        var t = this;
        console.log(t.data.openid), app.util.request({
            url: "entry/wxapp/UserGetCoupon",
            cachetime: "0",
            data: {
                cid: t.data.CouponInfo.id,
                openid: t.data.openid
            },
            success: function(o) {
                console.log(o), t.setData({
                    userCouInfo: o.data,
                    qrcode: o.data.data.qrcode
                }), wx.showToast({
                    title: "领取成功！"
                });
            }
        });
    },
    goShopTap: function(o) {
        wx.navigateTo({
            url: "../shopDetails/shopDetails?store_id=" + this.data.shopInfo.id
        });
    },
    makePhone: function(o) {
        console.log(o);
        wx.makePhoneCall({
            phoneNumber: this.data.shopInfo.phone
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = this, a = wx.getStorageSync("openid");
        console.log(a), app.util.request({
            url: "entry/wxapp/UserISGetCoupon",
            cachetime: "0",
            data: {
                cid: t.data.gid,
                openid: a
            },
            success: function(o) {
                console.log(o), 1 == o.data && t.setData({
                    got: 1,
                    userCouInfo: o.data,
                    openid: a
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    diyWinColor: function(o) {
        var t = wx.getStorageSync("system");
        wx.setNavigationBarColor({
            frontColor: t.color,
            backgroundColor: t.fontcolor,
            animation: {
                duration: 400,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: "优惠券详情"
        });
    }
});