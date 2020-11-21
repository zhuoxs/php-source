var app = getApp();

Page({
    data: {},
    onLoad: function(o) {
        console.log(o);
        var n = this;
        n.setData({
            meals_date: o.meals_date,
            person_num: o.person_num,
            meals_pos: o.meals_pos,
            name: o.name,
            tel: o.tel
        }), wx.getStorage({
            key: "url",
            success: function(o) {
                n.setData({
                    url: o.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/GetBranchDetail",
            cahetime: "0",
            data: {
                bid: o.bid
            },
            success: function(o) {
                console.log(o), n.setData({
                    shopInfo: o.data.data
                });
            }
        }), n.diyWinColor();
    },
    goHomeTap: function(o) {
        wx.redirectTo({
            url: "../index/index"
        });
    },
    makePhone: function(o) {
        wx.makePhoneCall({
            phoneNumber: o.currentTarget.dataset.tel
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return "button" === res.from && console.log(res.target), {
            title: "我已经订好位置了，你来看看",
            path: "yzhd_sun/pages/dingzuoDet/dingzuoDet",
            success: function(o) {
                console.log("转发成功"), console.log(o);
            }
        };
    },
    diyWinColor: function(o) {
        var n = wx.getStorageSync("system");
        wx.setNavigationBarColor({
            frontColor: n.color,
            backgroundColor: n.fontcolor,
            animation: {
                duration: 400,
                timingFunc: "easeIn"
            }
        }), wx.setNavigationBarTitle({
            title: "订座详情"
        });
    }
});