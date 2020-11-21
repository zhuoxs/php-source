var app = getApp();

Page({
    data: {
        navIndex: 0,
        list1: []
    },
    onLoad: function(t) {
        console.log(t);
        var a = this, e = t.navTitleText;
        a.setData({
            navTitleText: e
        }), wx.setNavigationBarTitle({
            title: e
        }), app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), a.setData({
                    url: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetMall",
            data: {
                id: t.id
            },
            cachetime: "0",
            success: function(t) {
                a.setData({
                    list: t.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetMallCourse",
            data: {
                id: t.id
            },
            cachetime: "0",
            success: function(t) {
                a.setData({
                    list1: t.data
                });
            }
        });
    },
    callTel: function() {
        var t = this.data.list.tel;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    onUnload: function() {},
    goCourseGoInfo: function(t) {
        wx.navigateTo({
            url: "../../product/courseGoInfo/courseGoInfo?id=" + t.currentTarget.dataset.id
        });
    },
    onReachBottom: function() {}
});