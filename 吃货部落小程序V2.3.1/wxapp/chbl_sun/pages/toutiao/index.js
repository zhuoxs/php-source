var app = getApp();

Page({
    data: {
        lid: "",
        toutiaoList: [ {
            pic: "http://oydnzfrbv.bkt.clouddn.com/toutiao.jpg",
            newsTitle: "热烈庆祝稻荷寿司入驻厦门",
            newsContent: "测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容",
            newsDate: "2018-01-26 10:00"
        }, {
            pic: "http://oydnzfrbv.bkt.clouddn.com/toutiao.jpg",
            newsTitle: "热烈庆祝稻荷寿司入驻厦门",
            newsContent: "测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容",
            newsDate: "2018-01-26 10:00"
        }, {
            pic: "http://oydnzfrbv.bkt.clouddn.com/toutiao.jpg",
            newsTitle: "热烈庆祝稻荷寿司入驻厦门",
            newsContent: "测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容",
            newsDate: "2018-01-26 10:00"
        }, {
            pic: "http://oydnzfrbv.bkt.clouddn.com/toutiao.jpg",
            newsTitle: "热烈庆祝稻荷寿司入驻厦门",
            newsContent: "测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容测试内容",
            newsDate: "2018-01-26 10:00"
        } ]
    },
    onLoad: function(t) {
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), console.log(t);
        var a = this;
        app.util.request({
            url: "entry/wxapp/Url2",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url2", t.data);
            }
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "0",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/zxlist",
            cachetime: "0",
            success: function(t) {
                console.log(t), a.setData({
                    toutiao: t.data,
                    page: 1,
                    state: 1
                });
            }
        }), a.setData({
            title: t.Title,
            currentType: t.currentType
        }), wx.setNavigationBarTitle({
            title: a.data.title
        });
    },
    goDetails: function(t) {
        console.log(t), wx.navigateTo({
            url: "../toutiao/details?lid=" + t.currentTarget.dataset.lid
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {
        console.log("下拉到底");
        var e = this;
        this.data.state ? (this.data.page++, app.util.request({
            url: "entry/wxapp/zxlist",
            cachetime: "0",
            data: {
                page: this.data.page
            },
            success: function(t) {
                if (console.log(t.data), 0 != t.data.length) {
                    var a = e.data.toutiao.concat(t.data);
                    e.setData({
                        toutiao: a
                    });
                } else e.setData({
                    state: !1
                }), wx.showToast({
                    title: "没有更多数据了",
                    icon: "none",
                    duration: 1500
                });
            }
        })) : (this.data.state = 0, wx.showToast({
            title: "没有更多数据了",
            icon: "none",
            duration: 1500
        }));
    },
    onShareAppMessage: function() {}
});