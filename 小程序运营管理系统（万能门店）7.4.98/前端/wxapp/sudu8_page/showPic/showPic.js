var WxParse = require("../../sudu8_page/resource/wxParse/wxParse.js"), app = getApp();

Page({
    data: {
        bg: "",
        picList: [],
        btn: -1,
        showbg: 0,
        shareShow: 0,
        shareScore: 0,
        shareNotice: 0,
        fxsid: 0,
        shareHome: 0
    },
    onPullDownRefresh: function() {
        var a = this.data.id;
        this.getShowPic(a), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this, e = a.id;
        t.setData({
            id: e
        }), wx.showShareMenu({
            withShareTicket: !0
        });
        var s = 0;
        a.fxsid && (s = a.fxsid, t.setData({
            fxsid: a.fxsid,
            shareHome: 1
        })), a.userid && t.setData({
            userid: a.userid
        }), app.util.request({
            url: "entry/wxapp/base",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(a) {
                a.data.data;
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            }
        }), app.util.getUserInfo(t.getinfos, s);
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    getinfos: function() {
        var e = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                e.setData({
                    openid: a.data
                });
                var t = e.data.id;
                e.getShowPic(t), e.givepscore();
            }
        });
    },
    getShowPic: function(a) {
        var t = this, e = t.data.openid;
        app.util.request({
            url: "entry/wxapp/globaluserinfo",
            data: {
                openid: e
            },
            success: function(a) {
                t.setData({
                    globaluser: a.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/showPic",
            data: {
                id: a
            },
            cachetime: "30",
            success: function(a) {
                t.setData({
                    bg: a.data.data.text[0],
                    picList: a.data.data.text,
                    title: a.data.data.title,
                    desc: a.data.data.desc,
                    btn: a.data.data.btn.pic_page_btn,
                    showbg: a.data.data.btn.pic_page_bg
                }), wx.setNavigationBarTitle({
                    title: t.data.title
                }), wx.setStorageSync("isShowLoading", !1), wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
            }
        });
    },
    changeSwiper: function(a) {
        var t = a.detail.current;
        this.setData({
            bg: this.data.picList[t]
        });
    },
    makePhoneCall: function(a) {
        var t = this.data.baseinfo.tel;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    makePhoneCallB: function(a) {
        var t = this.data.baseinfo.tel_b;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    openMap: function(a) {
        var t = this;
        wx.openLocation({
            latitude: parseFloat(t.data.baseinfo.latitude),
            longitude: parseFloat(t.data.baseinfo.longitude),
            name: t.data.baseinfo.name,
            address: t.data.baseinfo.address,
            scale: 22
        });
    },
    wxParseImgTap: function(a) {
        var t = a.target.dataset.src;
        wx.previewImage({
            current: t,
            urls: this.data.picList
        });
    },
    shareClo: function() {
        this.setData({
            shareShow: 0
        });
    },
    onShareAppMessage: function() {
        var a = this, t = wx.getStorageSync("openid"), e = a.data.id, s = "";
        return s = 1 == a.data.globaluser.fxs ? "/sudu8_page/showPic/showPic?id=" + e + "&userid=" + t : "/sudu8_page/showPic/showPic?id=" + e + "&userid=" + t + "&fxsid=" + t, 
        {
            title: a.data.title,
            path: s,
            success: function(a) {}
        };
    },
    share111: function() {
        this.setData({
            share: 1
        });
    },
    share_close: function() {
        this.setData({
            share: 0
        });
    },
    givepscore: function() {
        var a = this.data.id, t = this.data.userid, e = wx.getStorageSync("openid");
        t != e && 0 != t && "" != t && app.util.request({
            url: "entry/wxapp/giveposcore",
            data: {
                id: a,
                types: "showPic",
                openid: e,
                fxsid: t
            },
            success: function(a) {}
        });
    }
});