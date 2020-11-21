var app = getApp();

Page({
    data: {
        manager: [ {
            uthumb: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg",
            uname: "这是名字",
            id: 1234
        }, {
            uthumb: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg",
            uname: "这是名字",
            id: 1234
        }, {
            uthumb: "http://cgkqd.img48.wal8.com/img48/569611_20170429191245/152550116768.jpg",
            uname: "这是名字",
            id: 1234
        } ],
        id: "",
        searchFlag: !1
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), this.getHxstaff();
    },
    getHxstaff: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/getHxstaff",
            cachetime: "0",
            data: {
                type: 1
            },
            success: function(t) {
                a.setData({
                    hxstaff: t.data
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
    enterInput: function(t) {
        this.setData({
            id: t.detail.value
        });
    },
    submit: function(t) {
        var a = this, e = a.data.id;
        console.log(e), "" == e ? wx.showModal({
            title: "提示",
            showCancel: !1,
            content: "id不得为空"
        }) : (app.util.request({
            url: "entry/wxapp/getUserXz",
            cachetime: "0",
            data: {
                id: e
            },
            success: function(t) {
                a.setData({
                    user: t.data
                });
            }
        }), a.setData({
            searchFlag: !0
        }));
    },
    toDelete: function(t) {
        var a = this, e = t.currentTarget.dataset.name, n = t.currentTarget.dataset.id;
        wx.showModal({
            title: "",
            content: "确定删除核销员：" + e,
            success: function(t) {
                t.confirm && app.util.request({
                    url: "entry/wxapp/delHxstaff",
                    cachetime: "0",
                    data: {
                        id: n
                    },
                    success: function(t) {
                        a.getHxstaff();
                    }
                });
            }
        });
    },
    toAdd: function(t) {
        console.log(t);
        var a = this;
        app.util.request({
            url: "entry/wxapp/setHxstaff",
            cachetime: "0",
            data: {
                openid: t.currentTarget.dataset.openid
            },
            success: function(t) {
                a.getHxstaff(), a.setData({
                    searchFlag: !1
                });
            }
        });
    }
});