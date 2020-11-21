var app = getApp();

Page({
    data: {
        loadImgKey: !1,
        is_distribution: !0
    },
    onLoad: function(t) {
        var a = this, e = wx.getStorageSync("linkaddress");
        e && a.setData({
            linkaddress: e
        });
        var i = wx.getStorageSync("userInfo");
        app.ajax({
            url: "Cuser|myInfo",
            data: {
                user_id: i.id
            },
            success: function(t) {
                t.data;
                a.setData({
                    show: !0,
                    user_id: i.id
                }), a.getDistributionReport();
            }
        }), a.baseset();
    },
    getDistributionReport: function() {
        var a = this, t = a.data.user_id;
        app.ajax({
            url: "Cdistribution|getDistributionReport",
            data: {
                user_id: t
            },
            success: function(t) {
                a.setData({
                    getreport: t.data.distribution,
                    img_root: t.other.img_root,
                    withdraw_switch: t.data.withdraw_switch,
                    apply_bgm: t.data.apply_bgm,
                    is_distribution: t.data.distribution && 2 == t.data.distribution.check_state
                });
            }
        });
    },
    baseset: function() {
        var t = wx.getStorageSync("appConfig");
        this.setData({
            headerbg: t.personcenter_color_b ? t.personcenter_color_b : "#f87d6d"
        });
    },
    onPosterTab: function() {
        var e = this;
        if (wx.showToast({
            title: "海报生成中...",
            icon: "loading",
            duration: 2e4,
            mask: !0
        }), e.data.posterUrl) wx.previewImage({
            current: e.data.posterUrl,
            urls: [ e.data.posterUrl ],
            success: function() {
                wx.hideToast();
            }
        }); else {
            wx.getStorageSync("appConfig");
            var i = e.data.img_root, r = wx.getStorageSync("userInfo"), t = (e.data.getreport, 
            e.data.linkaddress.id);
            app.ajax({
                url: "Cwx|getQRCode",
                data: {
                    link: "?share_user_id=" + r.id + "&l_id=" + t,
                    width: 120
                },
                success: function(t) {
                    var a = t.data;
                    e.setData({
                        posterinfo: {
                            avatar: r.img,
                            banner: i + "" + a.banner,
                            qr: a.root + a.path,
                            title: a.title,
                            wxcode_pic: a.root + a.path,
                            path: a.path,
                            msg: a.msg
                        },
                        loadImgKey: !0
                    });
                }
            });
        }
    },
    createPoster: function(t) {
        var a = t.detail;
        this.setData({
            posterUrl: a.url
        }), wx.previewImage({
            current: "" + t.detail.url,
            urls: [ t.detail.url ],
            success: function() {
                wx.hideToast();
            }
        });
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {},
    toApply: function() {
        app.reTo("/sqtg_sun/pages/plugin/distribution/distribution/distribution");
    }
});