var _Page;

function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp(), util = require("../../utils/util.js");

Page((_defineProperty(_Page = {
    data: {
        tid: 0,
        fid: 0,
        scrollTop: 0,
        message: "",
        nickName: "",
        avatarUrl: "",
        news_input_val: "",
        tabdata: {
            nickname: "好兄弟"
        },
        u_id: "",
        timeT: "",
        setinterval: "",
        centendata: [],
        open: !1,
        bot_bottom: [ {
            img: "https://lg-o8nytxik-1257013711.cos.ap-shanghai.myqcloud.com/pic_icon1.png",
            text: "照片",
            bind: "chooseimg"
        } ]
    },
    bindChange: function(t) {
        this.setData({
            news_input_val: t.detail.value
        });
    },
    add: function(t) {
        var e = this, a = new Date(), i = util.formatTime(a), n = t.detail.formId, o = e.data.f_name, d = e.data.nickName, s = e.data.avatarUrl, r = e.data.is_img, c = e.data.docid, u = e.data.u_id, l = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/UserFormId",
            data: {
                form_id: n,
                openid: l
            },
            success: function(t) {
                console.log(t), "" == e.data.news_input_val ? wx.showModal({
                    title: "提示",
                    content: "输入消息不能为空"
                }) : app.util.request({
                    url: "entry/wxapp/SaveChatMsg",
                    data: {
                        openid: wx.getStorageSync("openid"),
                        fid: e.data.fid,
                        tid: e.data.tid,
                        t_msg: e.data.news_input_val,
                        f_name: o,
                        nickName: d,
                        touxiang: s,
                        is_img: r,
                        docid: c,
                        u_id: u
                    },
                    success: function(t) {
                        if (console.log(t), t) {
                            var a = e.data.centendata;
                            a.push({
                                time: i,
                                is_show_right: 1,
                                is_img: !1,
                                show_rignt: !0,
                                content: e.data.news_input_val,
                                head_owner: t.data.data.f_avatar
                            }), e.setData({
                                centendata: a,
                                news_input_val: "",
                                open: !1
                            }), e.bottom();
                        }
                    }
                });
            }
        });
    },
    onLoad: function(a) {
        var t = wx.getStorageSync("color"), e = a.docimg, i = a.docid, n = a.u_id;
        console.log(n), wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: t
        });
        var o = this, d = a.bk_id;
        o.setData({
            tid: a.tid,
            fid: a.fid,
            bk_id: d,
            f_name: a.name,
            is_img: e,
            docid: i,
            u_id: n
        }), d || app.util.request({
            url: "entry/wxapp/Ifzhuanjia",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                console.log(t), 0 == t.data.data && o.setData({
                    lt: t.data.data
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Hzuid",
            data: {
                openid: wx.getStorageSync("openid")
            },
            success: function(t) {
                t.data.data.u_id == a.fid && app.util.request({
                    url: "entry/wxapp/Base",
                    success: function(t) {
                        var a = t.data.data.tztim, e = t.data.data.fwtim, i = 0, n = o.data.timeT;
                        n = setInterval(function() {
                            (i += 1) - 0 == 60 * a && setTimeout(function() {
                                wx.showToast({
                                    title: "会话即将过期",
                                    image: "/hyb_yl/images/err.png"
                                });
                            }, 2e3), 60 * e <= i - 0 && app.util.request({
                                url: "entry/wxapp/Mybkstate1",
                                data: {
                                    bk_id: d
                                },
                                success: function(t) {
                                    wx.navigateBack({}), clearInterval(n);
                                }
                            });
                        }, 1e3), o.setData({
                            timeT: n
                        });
                    }
                });
            }
        });
        var s = wx.getStorageSync("userInfo");
        console.log(s), o.setData({
            nickName: s.nickName,
            avatarUrl: s.avatarUrl
        }), wx.setNavigationBarTitle({
            title: a.name
        }), app.util.request({
            url: "entry/wxapp/ReadMsg",
            data: {
                openid: wx.getStorageSync("openid"),
                fid: o.data.fid,
                tid: o.data.tid
            },
            success: function(t) {
                console.log(t), o.setData({
                    centendata: t.data.data.chat_list
                }), o.bottom();
            }
        });
        var r = setInterval(function() {
            app.util.request({
                url: "entry/wxapp/ReadMsg",
                data: {
                    openid: wx.getStorageSync("openid"),
                    fid: o.data.fid,
                    tid: o.data.tid
                },
                success: function(t) {
                    o.setData({
                        centendata: t.data.data.chat_list,
                        open: !1
                    });
                }
            }), wx.hideNavigationBarLoading(), o.bottom();
        }, 6e3);
        o.setData({
            setinterval: r
        });
    },
    onUnload: function() {
        clearInterval(this.data.setinterval), clearInterval(this.data.timeT), this.setData({
            timeT: ""
        });
    },
    onHide: function() {
        clearInterval(this.data.timeT), this.setData({
            timeT: ""
        });
    },
    onReady: function() {
        wx.hideNavigationBarLoading();
    },
    loaddata: function(t) {
        app.jtappid, app._openid, zx_info_id, openid_talk;
    },
    bottom: function() {
        var a = this, t = wx.createSelectorQuery();
        t.select("#hei").boundingClientRect(), t.selectViewport().scrollOffset(), t.exec(function(t) {
            a.setData({
                scrollTop: t[0].height
            });
        });
    },
    chooseimg: function() {
        var i = this, n = i.data.centendata, o = new Date();
        wx.chooseImage({
            sourceType: [ "album", "camera" ],
            success: function(t) {
                for (var a = t.tempFilePaths, e = 0; e < a.length; e++) n.push({
                    time: util.formatTime1(o),
                    is_show_right: 1,
                    is_img: !0,
                    show_rignt: !0,
                    content: "",
                    head_owner: i.data.avatarUrl,
                    img: a[e]
                });
                i.setData({
                    centendata: n,
                    open: !1
                }), setTimeout(function() {
                    i.bottom();
                }, 100);
            }
        });
    },
    previewImg: function(t) {
        for (var a = this.data.centendata, e = [], i = 0; i < a.length; i++) a[i].img && e.push(a[i].img);
        wx.previewImage({
            current: 0,
            urls: e
        });
    }
}, "onHide", function() {}), _defineProperty(_Page, "open_bot", function() {
    this.setData({
        open: !this.data.open
    });
}), _defineProperty(_Page, "close_modal", function() {
    this.setData({
        open: !1
    });
}), _Page));