var app = getApp();

Page({
    data: {
        navTile: "我的分享",
        curIndex: 0,
        nav: [ "分享列表", "分享商品", "分享金" ],
        distributList: [ {
            uthumb: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg",
            uname: "墨纸",
            time: "2018-05-05 10:10:10",
            money: "0.05"
        }, {
            uthumb: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg",
            uname: "墨纸",
            time: "2018-05-05 10:10:10",
            money: "0.05"
        }, {
            uthumb: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg",
            uname: "墨纸",
            time: "2018-05-05 10:10:10",
            money: "0.05"
        } ],
        newList: [ {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295627.png",
            price: "399.00"
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
            price: "399.00"
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
            price: "399.00"
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
            price: "399.00"
        }, {
            title: "发财树绿萝栀子花海棠花卉盆栽",
            src: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152531295634.png",
            price: "399.00"
        } ],
        cash: "3.00"
    },
    onLoad: function(t) {
        var e = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: e.data.navTile
        }), e.setData({
            url: wx.getStorageSync("url")
        });
        var a = wx.getStorageSync("openid"), n = wx.getStorageSync("settings");
        e.setData({
            settings: n
        }), app.util.request({
            url: "entry/wxapp/getShareRecord",
            cachetime: "0",
            data: {
                uid: a
            },
            success: function(t) {
                e.setData({
                    sharerecord: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var e = this, t = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/getUser",
            cachetime: "0",
            data: {
                openid: t
            },
            success: function(t) {
                e.setData({
                    user: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/getUserMoneyRecord",
            cachetime: "0",
            data: {
                openid: t,
                type: 2
            },
            success: function(t) {
                e.setData({
                    record: t.data
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    bargainTap: function(t) {
        var e = this, a = wx.getStorageSync("openid"), n = parseInt(t.currentTarget.dataset.index);
        this.setData({
            curIndex: n
        }), 1 == n ? app.util.request({
            url: "entry/wxapp/getShareGoodsRecord",
            cachetime: "0",
            data: {
                uid: a
            },
            success: function(t) {
                e.setData({
                    shareregoodscord: t.data
                });
            }
        }) : 0 == n && app.util.request({
            url: "entry/wxapp/getShareRecord",
            cachetime: "0",
            data: {
                uid: a
            },
            success: function(t) {
                e.setData({
                    sharerecord: t.data
                });
            }
        });
    }
});