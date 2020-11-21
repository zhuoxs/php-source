var app = getApp();

Page({
    data: {
        template: {},
        address_type: 0,
        name: "",
        phone: "",
        des: ""
    },
    onLoad: function(e) {
        this.setData({
            address_type: e.address_type
        });
        var t = "";
        (t = 0 == e.address_type ? wx.getStorageSync("fahuo") : wx.getStorageSync("shouhuo")) && (t.person && this.setData({
            name: t.person.name,
            phone: t.person.phone,
            des: t.person.des
        }), this.setData({
            template: t
        }));
    },
    onReady: function() {
        app.setNavigation();
    },
    onShow: function() {
        this.examineAddress();
    },
    confirm: function(e) {
        var t = e.detail.value;
        if (!t.phone) return app.hint("联系电话不能为空~");
        if (!/^1(3|4|5|6|7|8|9)\d{9}$/.test(t.phone)) return app.hint("请填写正确的手机号~");
        var a = {};
        if (a.name = t.name, !t.name) {
            var n = wx.getStorageSync("userInfo");
            n && n.wxInfo && n.wxInfo.nickName && (a.name = n.wxInfo.nickName);
        }
        a.phone = t.phone, a.des = t.des, t.des || (a.des = "电话联系");
        var o = this.data.template;
        o.person = a, 0 == this.data.address_type ? wx.setStorageSync("fahuo", o) : wx.setStorageSync("shouhuo", o), 
        wx.navigateBack({
            delta: 100
        });
    },
    getTime: function() {
        var a = this;
        homeModule.getTime().then(function(e) {
            var t = homeModule.date(e.days, e.hours, e.minutes);
            a.setData({
                xTime: t
            });
        }, function(e) {}), this.setData({
            time_bg: !1
        });
    },
    examineAddress: function() {
        var e = "";
        e = 0 == wx.getStorageSync("address_type") ? wx.getStorageSync("fahuo_template") : wx.getStorageSync("shouhuo_template"), 
        this.setData({
            template: e
        });
    },
    searchAddress: function() {
        wx.navigateTo({
            url: "../search_address/search_address"
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    onShareAppMessage: function() {
        return app.userShare();
    }
});