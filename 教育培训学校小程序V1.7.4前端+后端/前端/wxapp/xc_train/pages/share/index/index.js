var a = getApp(), e = require("../../common/common.js"), t = require("../../../../wxParse/wxParse.js");

Page({
    data: {
        nav: [ {
            img: "/xc_train/resource/fen_nav01.png",
            name: "可提现佣金(元)",
            value: 0,
            link: "../withdraw/index"
        }, {
            img: "/xc_train/resource/fen_nav02.png",
            name: "已提现佣金(元)",
            value: 0,
            link: "../record/index?&type=2"
        }, {
            img: "/xc_train/resource/fen_nav03.png",
            name: "分销订单(笔)",
            value: 0,
            link: "../order/index"
        }, {
            img: "/xc_train/resource/fen_nav04.png",
            name: "我的团队(人)",
            value: 0,
            link: "../team/index"
        } ],
        menu: [ {
            name: "提现记录",
            img: "/xc_train/resource/fen_menu01.png",
            link: "../record/index?&type=1"
        }, {
            name: "佣金明细",
            img: "/xc_train/resource/fen_menu02.png",
            link: "../order/count"
        } ],
        code: ""
    },
    pro_on: function() {
        this.setData({
            pro: !0
        });
    },
    pro_close: function() {
        this.setData({
            pro: !1
        });
    },
    code_on: function() {
        var e = this;
        "" != e.data.code ? e.setData({
            share_code: !0
        }) : a.util.request({
            url: "entry/wxapp/index",
            data: {
                op: "share_code"
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                "" != t.data && e.setData({
                    code: t.data.code,
                    share_code: !0
                });
            }
        });
    },
    code_save: function() {
        var a = this;
        a.setData({
            share_code: !1
        }), wx.showLoading({
            title: "保存中"
        }), wx.downloadFile({
            url: a.data.code,
            success: function(a) {
                wx.saveImageToPhotosAlbum({
                    filePath: a.tempFilePath,
                    success: function(a) {
                        wx.hideLoading(), wx.showToast({
                            title: "保存成功",
                            icon: "success",
                            duration: 2e3
                        });
                    },
                    fail: function(a) {
                        wx.hideLoading(), wx.showToast({
                            title: "保存失败",
                            icon: "success",
                            duration: 2e3
                        });
                    }
                });
            }
        });
    },
    onLoad: function(a) {
        var t = this;
        e.config(t), e.theme(t);
    },
    onReady: function() {},
    onShow: function() {
        this.getData(), e.audio_end(this);
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        this.getData();
    },
    onReachBottom: function() {},
    onShareAppMessage: function() {
        var a = this;
        a.setData({
            share_code: !1
        });
        var e = "/xc_train/pages/index/index";
        return e = escape(e), {
            title: a.data.config.title + "-首页",
            path: "/xc_train/pages/base/base?&share=" + e + "&share_id=" + a.data.user.id,
            success: function(a) {
                console.log(a);
            },
            fail: function(a) {
                console.log(a);
            }
        };
    },
    getData: function() {
        var e = this;
        a.util.request({
            url: "entry/wxapp/index",
            data: {
                op: "share_index"
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var n = a.data;
                if ("" != n.data) {
                    if ("" != n.data.user && null != n.data.user && e.setData({
                        user: n.data.user
                    }), "" != n.data.share && null != n.data.share && (e.setData({
                        share: n.data.share
                    }), "" != n.data.share.pro_content && null != n.data.share.pro_content)) t.wxParse("article", "html", n.data.share.pro_content, e, 0);
                    "" != n.data.poster && null != n.data.poster && e.setData({
                        poster: n.data.poster
                    });
                    var o = e.data.nav;
                    o[0].value = n.data.user.share_fee, o[1].value = n.data.withdraw, o[2].value = n.data.order, 
                    o[3].value = n.data.team, e.setData({
                        nav: o
                    });
                }
            }
        });
    }
});