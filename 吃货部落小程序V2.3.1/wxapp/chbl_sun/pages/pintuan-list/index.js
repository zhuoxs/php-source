var util = require("../../resource/js/utils/util.js"), app = getApp();

Page({
    data: {
        activeList: [ {
            goodsPic: "http://oydnzfrbv.bkt.clouddn.com/toutiao.jpg",
            goodsName: "超大份三文鱼寿司拼盘",
            pintuanNum: "目前已有201801人参与社团",
            activeShut: "2018-03-15",
            status: "去开团",
            tuanNum: "5人团",
            join: "1"
        }, {
            goodsPic: "http://oydnzfrbv.bkt.clouddn.com/toutiao.jpg",
            goodsName: "超小小份三文鱼寿司拼盘",
            pintuanNum: "目前已有201801人参与社团",
            activeShut: "2018-02-05",
            status: "已结束",
            tuanNum: "5人团",
            join: ""
        }, {
            goodsPic: "http://oydnzfrbv.bkt.clouddn.com/toutiao.jpg",
            goodsName: "超小小份三文鱼寿司拼盘",
            pintuanNum: "目前已有201801人参与社团",
            activeShut: "2018-02-06",
            tuanNum: "5人团",
            status: "已结束",
            join: ""
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
        });
        var o = this, n = wx.getStorageSync("url");
        o.setData({
            url: n
        });
        var a = wx.getStorageSync("latitude");
        wx.getStorageSync("longitude");
        console.log(a);
        var e = wx.getStorageSync("county");
        console.log(e), app.get_location().then(function(t) {
            console.log(t), app.util.request({
                url: "entry/wxapp/groupsList",
                cachetime: "3",
                data: {
                    currCityId: e.id,
                    latitude: t.latitude,
                    longitude: t.longitude
                },
                success: function(t) {
                    console.log(t), o.setData({
                        groupslist: t.data.data
                    });
                }
            });
        });
    },
    goJoin: function(t) {
        console.log(t);
        var o = t.currentTarget.dataset.gogogo;
        1 == t.currentTarget.dataset.status ? 1 == o ? wx.showToast({
            title: "活动尚未开始！",
            icon: "none"
        }) : wx.navigateTo({
            url: "../pintuan-list/details?id=" + t.currentTarget.dataset.id
        }) : wx.showToast({
            title: "活动已结束！",
            icon: "none"
        });
    },
    noJoin: function(t) {
        wx.showToast({
            title: "该活动已结束",
            icon: "none",
            duration: 2e3
        });
    },
    onReady: function() {},
    onShow: function() {
        var t = util.formatTime(new Date());
        this.setData({
            time: t
        }), console.log(this.data.time);
        for (var o = this.data, n = 0; n < o.activeList.length; n++) o.activeList[n].activeShut <= this.data.time && console.log("11111111");
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});