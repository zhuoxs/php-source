var WxParse = require("../../sudu8_page/resource/wxParse/wxParse.js"), app = getApp();

Page({
    data: {
        banner: "",
        page_signs: "/sudu8_page/fenxiao/fenxiao",
        indicatorDots: !1,
        autoplay: !1,
        interval: 5e3,
        duration: 1e3,
        check: 0,
        xieyi_block: 0,
        input_name: "",
        input_tel: "",
        fxs_name: ""
    },
    onPullDownRefresh: function() {
        this.fxssq(), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var e = this;
        e.setData({
            isIphoneX: app.globalData.isIphoneX
        });
        var t = 0;
        a.fxsid && (t = a.fxsid, e.setData({
            fxsid: a.fxsid
        })), app.util.request({
            url: "entry/wxapp/BaseMin",
            data: {
                vs1: 1
            },
            success: function(a) {
                e.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: e.data.baseinfo.base_tcolor,
                    backgroundColor: e.data.baseinfo.base_color
                }), e.fxssq();
            }
        }), app.util.getUserInfo(e.getinfos, t);
    },
    redirectto: function(a) {
        var e = a.currentTarget.dataset.link, t = a.currentTarget.dataset.linktype;
        app.util.redirectto(e, t);
    },
    getinfos: function() {
        var t = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                var e = a.data;
                t.setData({
                    openid: e
                });
            }
        });
    },
    fxssq: function() {
        var i = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/sqcwfxsbase",
            data: {
                openid: a
            },
            success: function(a) {
                var e = a.data.data.sq, t = a.data.data.userinfo;
                if (2 == t.fxs && 2 != t.fxsstop) wx.redirectTo({
                    url: "/sudu8_page/fenxiao_center/fenxiao_center"
                }); else {
                    var s = a.data.data.gz;
                    wx.setNavigationBarTitle({
                        title: "申请成为" + s.fxs_name
                    });
                    var n = s.sq_thumb;
                    i.setData({
                        item: n,
                        fxs_name: s.fxs_name
                    }), 2 == s.fxs_sz && e && 1 == e.flag && wx.redirectTo({
                        url: "/sudu8_page/fenxiao_s/fenxiao_s?type=1"
                    }), 3 == s.fxs_sz && wx.redirectTo({
                        url: "/sudu8_page/fenxiao_s/fenxiao_s?type=4"
                    }), 4 == s.fxs_sz && wx.redirectTo({
                        url: "/sudu8_page/fenxiao_s/fenxiao_s?type=3"
                    });
                }
                i.setData({
                    content: WxParse.wxParse("content", "html", a.data.data.gz.fxs_xy, i, 0),
                    fxs: a.data.data.fxs
                });
            }
        });
    },
    sub: function(a) {
        var e = this, t = e.data.input_name, s = e.data.input_tel, n = e.data.check, i = a.detail.formId;
        return 0 == n ? (wx.showToast({
            title: "请先阅读协议",
            icon: "none"
        }), !1) : "" == t ? (wx.showToast({
            title: "请先输入姓名",
            icon: "none"
        }), !1) : s.length < 11 ? (wx.showToast({
            title: "请输入正确手机号",
            icon: "none"
        }), !1) : "" == s ? (wx.showToast({
            title: "请先输入手机号",
            icon: "none"
        }), !1) : void wx.getStorage({
            key: "openid",
            success: function(a) {
                app.util.request({
                    url: "entry/wxapp/sqcwfxs",
                    data: {
                        truename: t,
                        truetel: s,
                        openid: a.data,
                        formId: i
                    },
                    success: function(a) {
                        if (a.data.data < 3) {
                            var e = "";
                            -1 == a.data.data && (e = "恭喜您申请成功！"), 1 == a.data.data && (e = "您的申请正在审核中"), 2 == a.data.data && (e = "您已经是分销商了"), 
                            wx.showModal({
                                title: "提醒",
                                content: e,
                                showCancel: !1,
                                success: function() {
                                    wx.redirectTo({
                                        url: "/sudu8_page/fenxiao_center/fenxiao_center"
                                    });
                                }
                            });
                        } else wx.redirectTo({
                            url: "/sudu8_page/fenxiao_s/fenxiao_s?type=2"
                        });
                    }
                });
            }
        });
    },
    xieyi_close: function() {
        this.setData({
            xieyi_block: 0
        });
    },
    xieyi_hidden: function() {
        this.setData({
            xieyi_block: 1,
            check: 1
        });
    },
    check_change: function() {
        var a = this;
        0 == a.data.check ? a.setData({
            check: 1
        }) : a.setData({
            check: 0
        });
    },
    input_name: function(a) {
        this.setData({
            input_name: a.detail.value
        });
    },
    input_tel: function(a) {
        this.setData({
            input_tel: a.detail.value
        });
    }
});