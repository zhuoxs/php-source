var app = getApp();

Page({
    data: {
        address: !0,
        select: !0,
        data: "",
        value: !1,
        radioValue: 1,
        id: "",
        addressList: [],
        gid: "",
        parameterid: ""
    },
    onLoad: function(e) {
        var t = e.gid;
        console.log("你的gid是多少11111"), console.log(t), this.setData({
            gid: t
        });
    },
    getAddressList: function() {
        var t = this, e = t.data.openid;
        app.util.request({
            url: "entry/wxapp/getAddressList",
            data: {
                openid: e,
                m: app.globalData.Plugin_scoretask
            },
            success: function(e) {
                console.log(e), t.setData({
                    addressList: e.data
                });
            }
        });
    },
    addManually: function() {
        var e = this.data.gid;
        console.log("手动gid"), console.log(e), wx.navigateTo({
            url: "../editAddress/editAddress?gid=" + e
        });
    },
    editor: function(e) {
        var t = e.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../editAddress/editAddress?id=" + t
        });
    },
    deleteAddress: function(e) {
        var t = e.currentTarget.dataset.id;
        wx.getStorageSync("user"), this.data.openid;
        app.util.request({
            url: "entry/wxapp/delAddress",
            data: {
                m: app.globalData.Plugin_scoretask,
                id: t
            },
            showLoading: !1,
            success: function(e) {
                console.log("删除默认地址"), console.log(e);
            }
        }), this.getAddressList();
    },
    install: function(e) {
        var a = this, t = e.currentTarget.dataset.id, s = (this.data.gid, wx.getStorageSync("user"), 
        a.data.openid);
        app.util.request({
            url: "entry/wxapp/setAddressDefault",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: s,
                id: t
            },
            showLoading: !1,
            success: function(e) {
                console.log("设置默认地址"), console.log(e);
                var t = e.data;
                a.setData({
                    data: t
                });
            }
        });
    },
    jump: function(e) {
        this.data.gid;
        var t = wx.getStorageSync("jump_type"), a = e.currentTarget.dataset.address_id;
        wx.setStorageSync("scoretask_address_id", a), 1 == t ? (wx.setStorageSync("jump_type", 0), 
        wx.navigateTo({
            url: "../pointsDraw/pointsDraw"
        })) : 2 == t && (wx.setStorageSync("jump_type", 0), wx.navigateBack({}));
    },
    chooseAddress: function() {
        var l = this, c = this, g = c.data.openid;
        console.log(g), wx.chooseAddress({
            success: function(e) {
                var t = e.userName, a = e.telNumber, s = e.provinceName, o = e.cityName, d = e.countyName, n = e.detailInfo, i = e.postalCode, r = l.data.radioValue;
                wx.getStorageSync("user");
                console.log(g), app.util.request({
                    url: "entry/wxapp/setAddress",
                    data: {
                        m: app.globalData.Plugin_scoretask,
                        openid: g,
                        name: t,
                        phone: a,
                        province: s,
                        city: o,
                        zip: d,
                        address: n,
                        postalcode: i,
                        lottery: r
                    },
                    success: function(e) {
                        c.getAddressList(), console.log(e);
                    }
                });
            },
            fail: function(e) {
                console.log("失败"), console.log(e.errMsg), "chooseAddress:fail auth deny" == e.errMsg && wx.showModal({
                    title: "提示",
                    content: "请点击右上角打开关于小程序再点击右上角选择设置"
                });
            },
            complete: function(e) {
                console.log("完成"), console.log(e);
            }
        });
    },
    onShow: function() {
        var t = this;
        app.get_openid().then(function(e) {
            console.log(e), t.setData({
                openid: e
            }), t.getAddressList();
        });
    }
});