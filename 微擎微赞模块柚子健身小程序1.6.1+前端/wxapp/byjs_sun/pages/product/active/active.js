var app = getApp();

Page({
    data: {
        curIndex: 0,
        activeType: [ "最新", "推荐" ],
        list: [ {
            id: 1,
            pic: "http://wx4.sinaimg.cn/small/005ysW6agy1fujr5m4ccnj306o050mya.jpg",
            status: 0,
            title: "标题啊啊啊",
            address: "地址啊",
            watch: 999,
            good: 11
        }, {
            id: 1,
            pic: "http://wx4.sinaimg.cn/small/005ysW6agy1fujr5m4ccnj306o050mya.jpg",
            status: 0,
            title: "标题啊啊啊",
            address: "地址啊",
            watch: 999,
            good: 11
        }, {
            id: 1,
            pic: "http://wx4.sinaimg.cn/small/005ysW6agy1fujr5m4ccnj306o050mya.jpg",
            status: 0,
            title: "标题啊啊啊",
            address: "地址啊",
            watch: 999,
            good: 11
        }, {
            id: 1,
            pic: "http://wx4.sinaimg.cn/small/005ysW6agy1fujr5m4ccnj306o050mya.jpg",
            status: 0,
            title: "标题啊啊啊",
            address: "地址啊",
            watch: 999,
            good: 11
        }, {
            id: 1,
            pic: "http://wx4.sinaimg.cn/small/005ysW6agy1fujr5m4ccnj306o050mya.jpg",
            status: 0,
            title: "标题啊啊啊",
            address: "地址啊",
            watch: 999,
            good: 11
        }, {
            id: 1,
            pic: "http://wx4.sinaimg.cn/small/005ysW6agy1fujr5m4ccnj306o050mya.jpg",
            status: 0,
            title: "标题啊啊啊",
            address: "地址啊",
            watch: 999,
            good: 11
        }, {
            id: 1,
            pic: "http://wx4.sinaimg.cn/small/005ysW6agy1fujr5m4ccnj306o050mya.jpg",
            status: 0,
            title: "标题啊啊啊",
            address: "地址啊",
            watch: 999,
            good: 11
        } ]
    },
    onLoad: function(t) {
        var a = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        });
    },
    onReady: function() {},
    onShow: function() {
        var a = this;
        console.log(a.data.curIndex), app.util.request({
            url: "entry/wxapp/getActiveList",
            cachetime: "30",
            data: {
                curIndex: a.data.curIndex
            },
            success: function(t) {
                a.setData({
                    list: t.data.activity,
                    Type: t.data.activitytype
                });
            }
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    changeIndex: function(t) {
        var a = t.currentTarget.dataset.index;
        console.log(a), this.setData({
            curIndex: a
        }), this.onShow();
    },
    goActiveDet: function(t) {
        var a = t.currentTarget.dataset.id, s = wx.getStorageSync("users").id;
        app.util.request({
            url: "entry/wxapp/addLiu",
            cachetime: "0",
            data: {
                aid: a,
                uid: s
            },
            success: function(t) {
                wx.navigateTo({
                    url: "/byjs_sun/pages/product/activeDet/activeDet?aid=" + a
                });
            }
        });
    },
    goActiveApply: function(t) {
        wx.navigateTo({
            url: "/byjs_sun/pages/product/activeApply/activeApply"
        });
    }
});