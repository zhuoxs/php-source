var app = getApp();

Page({
    data: {
        mess: [ {
            id: 0,
            name: "花花",
            age: "18",
            gender: "女",
            tel: "12345689",
            money: "15.00",
            order_number: "FJDSFK1215454",
            doctor: "叠加方块",
            rp: "但可接沙发客适当放宽圣诞节可是大家翻开手机的卡德加看似简单",
            date: "2017-45-12"
        }, {
            id: 1,
            name: "花花",
            age: "18",
            gender: "女",
            tel: "12345689",
            money: "15.00",
            order_number: "FJDSFK1215454",
            doctor: "叠加方块",
            rp: "但可接沙发客适当放宽圣诞节可是大家翻开手机的卡德加看似简单",
            date: "2017-45-12"
        } ]
    },
    look_detail: function(t) {
        console.log(t);
        var e = t.currentTarget.dataset.data, a = t.currentTarget.dataset.id;
        wx.navigateTo({
            url: "/hyb_ylmz/personal_page/detail/prescription_detail/prescription_detail?id=" + a + "&ky_yibao=" + e
        });
    },
    onLoad: function(t) {
        var e = this, a = (wx.getStorageSync("openid"), t.id);
        a && app.util.request({
            url: "entry/wxapp/Selectdoctordocid",
            data: {
                docid: a
            },
            success: function(t) {
                console.log(t.data.data.content), e.setData({
                    infos: t.data.data,
                    ky_yibao: t.data.data.ky_yibao
                });
            },
            fail: function(t) {
                console.log(t);
            }
        });
        var o = wx.getStorageSync("title");
        wx.setNavigationBarTitle({
            title: o
        });
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {}
});