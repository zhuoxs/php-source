var app = getApp();

function strlen(t) {
    for (var a = 0, e = 0; e < t.length; e++) {
        var o = t.charCodeAt(e);
        1 <= o && o <= 126 || 65376 <= o && o <= 65439 ? a++ : a += 2;
    }
    return a;
}

Page({
    data: {
        buyNumber: 1,
        buyNumMin: 1,
        buyNumMax: 10
    },
    onLoad: function(t) {
        var o = this;
        console.log(t);
        var a = wx.getStorageSync("openid"), e = t.buyType, n = wx.getStorageSync("shopcart");
        console.log(n), app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(t) {
                console.log(t), o.setData({
                    url: t.data,
                    buyType: e,
                    shopcart: n
                });
            }
        }), "undefined" != t.buyType ? app.util.request({
            url: "entry/wxapp/GetGoodsDetail",
            cachetime: "0",
            data: {
                gid: t.gid,
                buyType: e
            },
            success: function(t) {
                console.log(t);
                var a = ((t.data.data.current_price - t.data.data.fans_price) * o.data.buyNumber).toFixed(2), e = t.data.data.current_price;
                o.setData({
                    goodsInfo: t.data.data,
                    totalPrice: t.data.data.current_price,
                    singlePrice: e,
                    saveMoney: a
                });
            }
        }) : app.util.request({
            url: "entry/wxapp/GetGoodsDetail",
            cachetime: "0",
            data: {
                gid: t.gid
            },
            success: function(t) {
                console.log(t);
                var a = ((t.data.data.current_price - t.data.data.fans_price) * o.data.buyNumber).toFixed(2), e = t.data.data.current_price;
                o.setData({
                    goodsInfo: t.data.data,
                    totalPrice: t.data.data.current_price,
                    singlePrice: e,
                    saveMoney: a
                });
            }
        }), app.util.request({
            url: "entry/wxapp/IsVip",
            cachetime: "0",
            data: {
                openid: a
            },
            success: function(t) {
                console.log(t), o.setData({
                    isVip: t.data
                });
            }
        }), o.diyWinColor();
    },
    numJianTap: function() {
        if (this.data.buyNumber > this.data.buyNumMin) {
            var t = this.data.buyNumber;
            t--;
            var a = this.data.singlePrice * t;
            this.setData({
                buyNumber: t,
                totalPrice: a
            });
            var e = ((this.data.goodsInfo.current_price - this.data.goodsInfo.fans_price) * this.data.buyNumber).toFixed(2);
            this.setData({
                saveMoney: e
            });
        }
    },
    numJiaTap: function() {
        if (this.data.buyNumber < this.data.buyNumMax) {
            var t = this.data.buyNumber;
            t++, console.log(this.data.singlePrice);
            var a = this.data.singlePrice * t;
            this.setData({
                buyNumber: t,
                totalPrice: a
            });
            var e = ((this.data.goodsInfo.current_price - this.data.goodsInfo.fans_price) * this.data.buyNumber).toFixed(2);
            this.setData({
                saveMoney: e
            });
        }
    },
    goBuyVipTap: function(t) {
        wx.navigateTo({
            url: "../fansCard/fansCard"
        });
    },
    bindSubmit: function(a) {
        console.log(a);
        var e = this, o = a.detail.value.name;
        o || (o = wx.getStorageSync("consigneename"));
        var n = a.detail.value.tel;
        n || (n = wx.getStorageSync("consigneetel")), wx.setStorageSync("consigneename", o), 
        wx.setStorageSync("consigneetel", n);
        var t = a.detail.value.num;
        console.log(t);
        var i = e.data.buyType;
        console.log(i);
        var r = a.detail.target.dataset.gid;
        app.util.request({
            url: "entry/wxapp/GetGoodsStock",
            cachetime: "0",
            data: {
                gid: r,
                buyType: i,
                num: t,
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                if (console.log(t), "" != o) return "" == n || 11 != strlen(n) ? (console.log(n), 
                void wx.showModal({
                    title: "提示",
                    content: "请输入正确的联系电话！",
                    showCancel: !1
                })) : void wx.navigateTo({
                    url: "../orderDetails/orderDetails?gid=" + a.detail.target.dataset.gid + "&&num=" + e.data.buyNumber + "&&totalPrice=" + e.data.totalPrice + "&&name=" + o + "&&tel=" + n + "&&buyType=" + i
                });
                wx.showModal({
                    title: "提示",
                    content: "请输入姓名",
                    showCancel: !1
                });
            }
        });
    },
    inputTap: function(t) {
        this.setData({
            telLength: t.detail.cursor
        });
    },
    pushOrderTap: function(t) {},
    onReady: function() {},
    onShow: function() {
        var t = wx.getStorageSync("consigneename"), a = wx.getStorageSync("consigneetel");
        console.log(t), console.log(a), this.setData({
            consignee_name: t,
            consignee_tel: a
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    diyWinColor: function(t) {
        var a = wx.getStorageSync("system");
        wx.setNavigationBarColor({
            frontColor: a.color,
            backgroundColor: a.fontcolor,
            animation: {
                duration: 400,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: "提交订单"
        });
    }
});