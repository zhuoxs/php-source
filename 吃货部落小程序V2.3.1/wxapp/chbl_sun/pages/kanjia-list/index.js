var util = require("../../resource/js/utils/util.js"), app = getApp();

Page({
    data: {
        activeList: [ {
            goodsPic: "http://oydnzfrbv.bkt.clouddn.com/toutiao.jpg",
            goodsName: "超大份三文鱼寿司拼盘",
            pintuanNum: "目前已有201801人参与社团",
            activeShut: "2018-03-15",
            status: "求助好友",
            join: "1"
        }, {
            goodsPic: "http://oydnzfrbv.bkt.clouddn.com/toutiao.jpg",
            goodsName: "超小小份三文鱼寿司拼盘",
            pintuanNum: "目前已有201801人参与社团",
            activeShut: "2018-02-05",
            status: "已结束",
            join: ""
        }, {
            goodsPic: "http://oydnzfrbv.bkt.clouddn.com/toutiao.jpg",
            goodsName: "超小小份三文鱼寿司拼盘",
            pintuanNum: "目前已有201801人参与社团",
            activeShut: "2018-02-06",
            status: "已结束",
            join: ""
        } ]
    },
    onLoad: function(t) {
        var o = this;
        app.util.request({
            url: "entry/wxapp/Url",
            cachetime: "30",
            success: function(t) {
                wx.setStorageSync("url", t.data), o.setData({
                    url: t.data
                });
            }
        });
        wx.getStorageSync("latitude"), wx.getStorageSync("longitude");
        var a = wx.getStorageSync("county");
        app.get_location().then(function(t) {
            app.util.request({
                url: "entry/wxapp/BargainList",
                cachetime: "10",
                data: {
                    currCityId: a.id,
                    latitude: t.latitude,
                    longitude: t.longitude
                },
                success: function(t) {
                    console.log(t), o.setData({
                        bargainlist: t.data.data
                    });
                }
            });
        });
    },
    goJoin: function(t) {
        console.log(t), 1 == t.currentTarget.dataset.gogogo ? wx.showToast({
            title: "活动尚未开启！",
            icon: "none"
        }) : 1 == t.currentTarget.dataset.state ? wx.showToast({
            title: "活动已结束",
            icon: "none"
        }) : wx.navigateTo({
            url: "../kanjia-list/details?id=" + t.currentTarget.dataset.id
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
        for (var o = this.data, a = 0; a < o.activeList.length; a++) o.activeList[a].activeShut <= this.data.time && console.log("11111111");
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {}
});