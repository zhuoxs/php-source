/*   time:2019-08-09 13:18:39*/
var app = getApp();
Page({
    data: {
        address: !0,
        select: !0,
        data: "",
        value: !1,
        is_modal_Hidden: !0,
        radioValue: 1,
        id: "",
        addressList: [],
        gid: "",
        parameterid: ""
    },
    onLoad: function(e) {
        app.wxauthSetting();
        var t = e.gid;
        console.log("你的gid是多少11111"), console.log(t), this.setData({
            gid: t
        });
        this.getAddressList()
    },
    getAddressList: function() {
        var t = this,
            e = wx.getStorageSync("users").openid;
        app.util.request({
            url: "entry/wxapp/getAddressList",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: e
            },
            showLoading: !1,
            success: function(e) {
                console.log(e), t.setData({
                    addressList: e.data
                })
            }
        })
    },
    addManually: function() {
        var e = this.data.gid;
        console.log("手动gid"), console.log(e), wx.navigateTo({
            url: "../editAddress/editAddress?gid=" + e
        })
    },
    editor: function(e) {
        var t = e.currentTarget.dataset.id;
        wx.navigateTo({
            url: "../editAddress/editAddress?id=" + t
        })
    },
    deleteAddress: function(e) {
        var t = e.currentTarget.dataset.id;
        wx.getStorageSync("users").openid;
        app.util.request({
            url: "entry/wxapp/delAddress",
            data: {
                m: app.globalData.Plugin_scoretask,
                id: t
            },
            showLoading: !1,
            success: function(e) {
                console.log("删除默认地址"), console.log(e)
            }
        }), this.getAddressList()
    },
    install: function(e) {
        var s = this,
            t = e.currentTarget.dataset.id,
            a = (this.data.gid, wx.getStorageSync("users").openid);
        app.util.request({
            url: "entry/wxapp/setAddressDefault",
            data: {
                m: app.globalData.Plugin_scoretask,
                openid: a,
                id: t
            },
            showLoading: !1,
            success: function(e) {
                console.log("设置默认地址"), console.log(e);
                var t = e.data;
                s.setData({
                    data: t
                })
            }
        })
    },
    jump: function(e) {
        this.data.gid;
        var t = wx.getStorageSync("jump_type"),
            s = e.currentTarget.dataset.address_id;
        wx.setStorageSync("scoretask_address_id", s), 1 == t ? (wx.setStorageSync("jump_type", 0), wx.navigateTo({
            url: "../pointsDraw/pointsDraw"
        })) : 2 == t && (wx.setStorageSync("jump_type", 0), wx.navigateBack({}))
    },
    chooseAddress: function() {
        var c = this,
            g = this;
        wx.chooseAddress({
            success: function(e) {
                var t = e.userName,
                    s = e.telNumber,
                    a = e.provinceName,
                    o = e.cityName,
                    d = e.countyName,
                    i = e.detailInfo,
                    n = e.postalCode,
                    r = c.data.radioValue,
                    l = wx.getStorageSync("users").openid;
                app.util.request({
                    url: "entry/wxapp/setAddress",
                    data: {
                        m: app.globalData.Plugin_scoretask,
                        openid: l,
                        name: t,
                        phone: s,
                        province: a,
                        city: o,
                        zip: d,
                        address: i,
                        postalcode: n,
                        lottery: r
                    },
                    success: function(e) {
                        g.getAddressList(), console.log(e)
                    }
                })
            },
            fail: function(e) {
                console.log("失败"), console.log(e.errMsg), "chooseAddress:fail auth deny" == e.errMsg && wx.showModal({
                    title: "提示",
                    content: "请点击右上角打开关于小程序再点击右上角选择设置"
                })
            },
            complete: function(e) {
                console.log("完成"), console.log(e)
            }
        })
    },
    onShow: function() {
        app.func.islogin(app, this), this.getAddressList()
    },
    updateUserInfo: function(e) {
        app.wxauthSetting()
    }
});