var app = getApp();

Page({
    data: {
        Completed: [ {
            orderNum: 11111,
            cname: 1111111,
            name: "1111",
            time: "11111"
        }, {
            orderNum: 11111,
            cname: 1111111,
            name: "1111",
            time: "11111"
        } ],
        nav: [ "全部", "待服务", "已完成" ],
        curIndex: 0,
        isIpx: app.globalData.isIpx
    },
    onLoad: function(e) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(e) {
                wx.setStorageSync("url", e.data), a.setData({
                    url: e.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this, e = wx.getStorageSync("bid");
        app.util.request({
            url: "entry/wxapp/BranchOrder",
            cachetime: "0",
            data: {
                bid: e
            },
            success: function(e) {
                a.setData({
                    order: e.data.order,
                    Waitervice: e.data.Waitervice,
                    Byservice: e.data.Byservice
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toDialog: function(e) {
        var a = e.currentTarget.dataset.phone;
        wx.makePhoneCall({
            phoneNumber: a
        });
    },
    toIndex: function(e) {
        var a = wx.getStorageSync("bid");
        wx.redirectTo({
            url: "../index3/index3?id=" + a
        });
    },
    bargainTap: function(e) {
        var a = parseInt(e.currentTarget.dataset.index);
        this.setData({
            curIndex: a
        });
    }
});