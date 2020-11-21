var app = getApp();

Page({
    data: {
        page_signs: "/sudu8_page/register_success/register_success",
        is_editing: !1
    },
    onLoad: function(a) {
        var t = this;
        a.from && (t.data.from = a.from), wx.setNavigationBarTitle({
            title: "查看会员卡"
        }), t.getBase(), t.getUserinfo(), wx.getStorage({
            key: "openid",
            success: function(a) {
                app.util.request({
                    url: "entry/wxapp/getVIPinfo",
                    data: {
                        openid: a.data
                    },
                    success: function(a) {
                        t.setData({
                            year: a.data.data.year,
                            week: a.data.data.week,
                            vipid1: a.data.data.vipid.substr(0, 4),
                            vipid2: a.data.data.vipid.substr(4, 4),
                            vipid3: a.data.data.vipid.substr(8, 4),
                            vipid4: a.data.data.vipid.substr(12, 4),
                            name: a.data.data.realname,
                            mobile: a.data.data.mobile,
                            month_day: a.data.data.month_day,
                            birth: a.data.data.birth,
                            address: a.data.data.address
                        });
                    },
                    fail: function(a) {}
                });
            }
        });
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    onReady: function() {},
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        wx.stopPullDownRefresh();
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    getBase: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/BaseMin",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(a) {
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        });
    },
    getUserinfo: function() {
        var t = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                app.util.request({
                    url: "entry/wxapp/mymoney",
                    data: {
                        openid: a.data
                    },
                    success: function(a) {
                        t.setData({
                            userbg: a.data.data.userbg,
                            cardname: a.data.data.cardname
                        });
                    }
                });
            }
        });
    },
    editing: function() {
        this.setData({
            is_editing: !this.data.is_editing
        });
    },
    editComplete: function() {
        var e = this, a = wx.getStorageSync("openid"), t = e.data.mobile;
        if (!/^(((13[0-9]{1})|(14[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1})|(19[0-9]{1}))+\d{8})$/.test(t)) return wx.showModal({
            title: "提醒",
            content: "请输入有效的手机号码！",
            showCancel: !1
        }), !1;
        app.util.request({
            url: "entry/wxapp/changeUserinfo",
            data: {
                openid: a,
                name: e.data.name,
                mobile: t,
                birth: e.data.birth,
                address: e.data.address
            },
            success: function(a) {
                if ("lottery" == e.data.from) {
                    var t = getCurrentPages();
                    t[t.length - 2].setUserinfo(e.data.name, e.data.mobile, e.data.address);
                }
                wx.showToast({
                    title: "修改成功！",
                    icon: "success",
                    success: function() {
                        setTimeout(function() {
                            e.setData({
                                is_editing: !1
                            });
                        }, 1500);
                    }
                });
            }
        });
    },
    getName: function(a) {
        this.setData({
            name: a.detail.value
        });
    },
    getMobile: function(a) {
        this.setData({
            mobile: a.detail.value
        });
    },
    getAddress: function(a) {
        this.setData({
            address: a.detail.value
        });
    },
    changeDate: function(a) {
        this.setData({
            birth: a.detail.value
        });
    }
});