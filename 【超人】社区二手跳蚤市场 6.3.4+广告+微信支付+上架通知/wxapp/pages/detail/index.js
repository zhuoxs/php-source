var app = getApp(), Toptips = require("../../libs/zanui/toptips/index"), Toast = require("../../libs/zanui/toast/toast");

Page({
    data: {
        noticeDots: !1,
        vertical: !0,
        autoplay: !1,
        interval: 3e3,
        duration: 500,
        imgheights: [],
        current: 0,
        isIos: app.globalData.phone,
        iphoneX: app.globalData.iphoneX,
        hideVideo: !1,
        videoCache: !0,
        showOrder: !1,
        showPopup: !1,
        reprot: !1,
        confirmBar: !1,
        disabled: !1,
        blacklist: !1,
        cancelWithMask: !0,
        actions: [ {
            name: "已转让",
            loading: !1
        }, {
            name: "下架",
            loading: !1
        }, {
            name: "编辑",
            loading: !1
        } ],
        actions2: [ {
            name: "已转让",
            loading: !1
        }, {
            name: "上架",
            loading: !1
        }, {
            name: "编辑",
            loading: !1
        } ],
        cancelText: "取消",
        tips: {
            top: "您需要登录之后才能进行下一步操作",
            bottom: "点击确定按钮登录"
        },
        defaultBtn: !1
    },
    onLoad: function(t) {
        var a = this, e = wx.getStorageSync("loading_img"), i = wx.getStorageSync("sold_img"), s = wx.getStorageSync("post_time"), o = wx.getStorageSync("post_open");
        if (e ? a.setData({
            loadingImg: e
        }) : a.setData({
            loadingImg: "../../libs/images/loading.gif"
        }), i && a.setData({
            soldImg: i
        }), s && a.setData({
            post_time: s
        }), o) {
            var n = wx.getStorageSync("post_btn_data");
            a.setData({
                showPostBtn: !0,
                post_appid: n.appid,
                post_url: n.url,
                post_img: n.thumb
            });
        }
        app.viewCount();
        var r = t.id;
        t.share && a.setData({
            showShare: !0
        });
        var d = t.orderid, l = wx.getStorageSync("userInfo");
        if (l) {
            var c = l.memberInfo.uid;
            a.setData({
                uid: c,
                item_id: r
            });
        } else a.setData({
            item_id: r
        });
        t.myOrder && a.setData({
            showOrder: !0
        }), a.checkPlugin(), a.getItemDetail(r, d);
    },
    imageLoad: function(t) {
        var a = t.detail.width / t.detail.height, e = this.data.imgheights;
        e[t.target.dataset.index] = 750 / a, this.setData({
            imgheights: e
        });
    },
    bindSwiperChange: function(t) {
        this.setData({
            current: t.detail.current
        });
    },
    setVideoHide: function() {
        "ios" == this.data.isIos && this.setData({
            hideVideo: !0
        });
    },
    closeMask: function() {
        this.setData({
            showShare: !1
        });
    },
    checkPlugin: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/home",
            cachetime: "0",
            data: {
                act: "plugin",
                m: "superman_hand2"
            },
            success: function(t) {
                if (t.data.errno) e.showIconToast(t.data.errmsg); else {
                    var a = t.data.data;
                    e.setData({
                        wechat_on: 1 == a.superman_hand2_plugin_wechat,
                        canSetTop: 1 == a.superman_hand2_plugin_ad
                    });
                }
            },
            fail: function(t) {
                e.showIconToast(t.data.errmsg);
            }
        });
    },
    getItemDetail: function(t) {
        var a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : 0, p = this;
        app.util.request({
            url: "entry/wxapp/item",
            cachetime: "0",
            data: {
                act: "detail",
                id: t,
                orderid: a,
                lat: app.globalData.lat || "",
                lng: app.globalData.lng || "",
                m: "superman_hand2"
            },
            success: function(t) {
                if (t.data.errno) p.showIconToast(t.data.errmsg); else {
                    var a = t.data.data;
                    if (p.data.uid && p.data.uid == a.item.seller_uid && p.setData({
                        is_author: !0
                    }), 0 < a.item.is_favour && p.setData({
                        is_fav: !0
                    }), 0 < a.item.is_collect && p.setData({
                        is_collect: !0
                    }), -1 == a.item.status && p.setData({
                        soldOut: !0
                    }), a.item.status <= 0 && -1 != a.item.status && p.setData({
                        disabled: !0
                    }), !a.item.summary && 0 < a.item.book_fields.length) {
                        var e = a.item.book_fields, i = e.subtitle ? "-" + e.subtitle : "", s = e.author ? " ，作者：" + e.author : "", o = e.publisher ? "，" + e.publisher + e.pubdate + "出版" : "", n = e.pages ? " ，共" + e.pages + "页" : "", r = e.rating ? " ，豆瓣评分：" + e.rating : "", d = e.price ? " ，原价：" + e.price : "";
                        a.item.summary = a.item.title + i + s + o + n + r + d;
                    }
                    if (a.item.add_fields) {
                        for (var l = a.item.add_fields, c = 0; c < l.length; c++) "" == l[c].value && l.splice(c, 1);
                        a.item.add_fields = l;
                    }
                    if (0 < a.item.video.length) {
                        for (var u = a.item.video, h = p.data.imgheights, m = 0; m < u.length; m++) h.unshift("600");
                        p.setData({
                            imgheights: h
                        });
                    }
                    p.setData({
                        detail: a.item,
                        message: a.message,
                        notice: a.notice,
                        notice_type: a.notice_type,
                        set_top: 1 == a.set_top,
                        credit_title: app.globalData.credit_title,
                        completed: !0
                    });
                }
            },
            fail: function(t) {
                p.setData({
                    completed: !0
                }), p.showIconToast(t.data.errmsg);
            }
        });
    },
    getUserInfo: function(t) {
        var e = this;
        e.setData({
            showLogin: !1
        }), "getUserInfo:ok" == t.detail.errMsg && app.util.getUserInfo(function(t) {
            var a = t.memberInfo.uid;
            e.setData({
                uid: a
            }), e.data.liuyan && (e.setData({
                liuyan: !1
            }), e.leaveMsg()), e.data.huifu && (e.setData({
                huifu: !1
            }), e.replyMsg()), e.data.action && (e.setData({
                action: !1
            }), e.getItemDetail(e.data.item_id), e.itemAction()), e.data.action && (e.setData({
                action: !1
            }), e.itemAction()), e.data.chat && (e.setData({
                chat: !1
            }), e.getItemDetail(e.data.item_id), e.toChat());
        }, t.detail);
    },
    closeLogin: function() {
        this.setData({
            showLogin: !1
        });
    },
    previewImg: function(t) {
        var a = t.currentTarget.dataset.src;
        wx.previewImage({
            current: a,
            urls: this.data.detail.album
        });
    },
    showPosition: function(t) {
        var a = parseFloat(t.currentTarget.dataset.lat), e = parseFloat(t.currentTarget.dataset.lng);
        wx.openLocation({
            latitude: a,
            longitude: e,
            scale: 24
        });
    },
    showVideo: function(t) {
        var a = t.currentTarget.dataset.index, e = this.data.detail.video;
        this.setData({
            showPopup: !0,
            auto: !0,
            video: e[a]
        });
    },
    togglePopup: function() {
        this.setData({
            showPopup: !this.data.showPopup
        });
    },
    makeCall: function() {
        wx.makePhoneCall({
            phoneNumber: this.data.detail.order.mobile
        });
    },
    makePhone: function(t) {
        var a = t.currentTarget.dataset.phone;
        wx.showModal({
            title: "系统提示",
            content: "即将拨打电话给：" + a,
            success: function(t) {
                t.confirm && wx.makePhoneCall({
                    phoneNumber: a
                });
            }
        });
    },
    copyWechat: function(t) {
        var a = t.currentTarget.dataset.wechat;
        wx.setClipboardData({
            data: a
        }), wx.showModal({
            title: "系统提示",
            content: "已经复制卖家微信到剪贴板，请去微信添加好友与其联系吧",
            showCancel: !1
        });
    },
    copyValue: function(t) {
        var a = t.currentTarget.dataset.value;
        wx.setClipboardData({
            data: a
        }), wx.showModal({
            title: "系统提示",
            content: "已经复制该信息到剪贴板",
            showCancel: !1
        });
    },
    goToComment: function() {
        wx.navigateTo({
            url: "../comment/index?ct_uid=" + this.data.detail.seller_uid + "&one=" + this.data.detail.level_one + "&two=" + this.data.detail.level_two + "&three=" + this.data.detail.level_three
        });
    },
    leaveMsg: function(t) {
        this.data.uid ? this.setData({
            showModal: !0
        }) : this.setData({
            showLogin: !0,
            liuyan: !0
        });
    },
    replyMsg: function(t) {
        var a = t.currentTarget.dataset.id;
        this.data.uid ? this.setData({
            msg_id: a,
            showModal: !0
        }) : this.setData({
            showLogin: !0,
            huifu: !0
        });
    },
    itemAction: function(t) {
        var e = this, i = t.currentTarget.dataset.type, s = t.currentTarget.dataset.status, o = e.data.item_id, a = t.detail.formId;
        e.data.uid ? (app.util.request({
            url: "entry/wxapp/notice",
            cachetime: "0",
            data: {
                act: "formid",
                formid: a,
                m: "superman_hand2"
            },
            success: function(t) {
                0 == t.data.errno ? console.log("formid已添加") : console.log(t.data.errmsg);
            },
            fail: function(t) {
                console.log(t.data.errmsg);
            }
        }), app.util.request({
            url: "entry/wxapp/item",
            cachetime: "0",
            data: {
                act: "detail",
                id: o,
                type: i,
                status: s,
                m: "superman_hand2"
            },
            success: function(t) {
                if (t.data.errno) e.showIconToast(t.data.errmsg); else {
                    var a = "";
                    1 == i ? s ? (a = "取消点赞", e.setData({
                        is_fav: !1
                    })) : a = "点赞成功" : s ? (a = "取消收藏", e.setData({
                        is_collect: !1
                    })) : a = "收藏成功", e.showIconToast(a, "success"), e.getItemDetail(o);
                }
            }
        })) : e.setData({
            showLogin: !0,
            action: !0
        });
    },
    jubao: function() {
        this.setData({
            showModal: !0,
            report: !0
        });
    },
    closeModal: function() {
        this.setData({
            showModal: !1,
            report: !1
        });
    },
    formSubmit: function(t) {
        var a = this, e = t.detail.value.content, i = a.data.item_id, s = t.detail.formId;
        if ("" != e) if (app.util.request({
            url: "entry/wxapp/notice",
            cachetime: "0",
            data: {
                act: "formid",
                formid: s,
                m: "superman_hand2"
            },
            success: function(t) {
                0 == t.data.errno ? console.log("formid已添加") : console.log(t.data.errmsg);
            },
            fail: function(t) {
                console.log(t.data.errmsg);
            }
        }), a.data.report) app.util.request({
            url: "entry/wxapp/item",
            cachetime: "0",
            data: {
                act: "report",
                itemid: i,
                content: e,
                formid: s,
                m: "superman_hand2"
            },
            success: function(t) {
                a.setData({
                    showModal: !1,
                    report: !1
                }), t.data.errno || a.showIconToast("已举报，等待处理中...", "success");
            },
            fail: function(t) {
                a.setData({
                    showModal: !1,
                    report: !1
                }), a.showIconToast(t.data.errmsg);
            }
        }); else if (a.data.msg_id) {
            var o = a.data.msg_id;
            app.util.request({
                url: "entry/wxapp/item",
                cachetime: "0",
                data: {
                    act: "detail",
                    id: i,
                    msg_id: o,
                    reply: e,
                    m: "superman_hand2"
                },
                success: function(t) {
                    a.setData({
                        showModal: !1
                    }), t.data.errno ? a.showIconToast(t.data.errmsg) : (a.showIconToast("回复成功", "success"), 
                    a.getItemDetail(i));
                }
            });
        } else app.util.request({
            url: "entry/wxapp/item",
            cachetime: "0",
            data: {
                act: "detail",
                id: i,
                comment: e,
                m: "superman_hand2"
            },
            success: function(t) {
                a.setData({
                    showModal: !1
                }), t.data.errno ? a.showIconToast(t.data.errmsg) : (a.showIconToast("提交成功", "success"), 
                a.getItemDetail(i));
            }
        }); else Toptips("内容不能为空");
    },
    toChat: function(t) {
        var a = this;
        if (a.data.uid) {
            var e = t.detail.formId;
            if (app.util.request({
                url: "entry/wxapp/notice",
                cachetime: "0",
                data: {
                    act: "formid",
                    formid: e,
                    m: "superman_hand2"
                },
                success: function(t) {
                    0 == t.data.errno ? console.log("formid已添加") : console.log(t.data.errmsg);
                },
                fail: function(t) {
                    console.log(t.data.errmsg);
                }
            }), a.data.uid == a.data.detail.seller_uid) a.data.disabled || a.openActionSheet(); else {
                var i = a.data.uid, s = a.data.detail.seller_uid;
                app.util.request({
                    url: "entry/wxapp/item",
                    cachetime: "0",
                    data: {
                        act: "detail",
                        chat: 1,
                        id: a.data.item_id,
                        from_uid: i,
                        m: "superman_hand2"
                    },
                    success: function(t) {
                        t.data.errno ? a.showIconToast(t.errmsg) : wx.navigateTo({
                            url: "../chat/index?fromuid=" + s + "&itemid=" + a.data.item_id
                        });
                    }
                });
            }
        } else a.setData({
            showLogin: !0,
            chat: !0
        });
    },
    openActionSheet: function() {
        this.setData({
            show: !0
        });
    },
    closeActionSheet: function() {
        this.setData({
            show: !1
        });
    },
    handleActionClick: function(t) {
        var a = this, e = t.detail.index;
        if (0 == e || 1 == e) 0 == e ? a.setData({
            status: 2,
            tips: {
                top: "确定已转让吗？",
                bottom: "已转让物品将不能再次操作"
            },
            defaultBtn: !0,
            showLogin: !0
        }) : a.data.soldOut ? a.setData({
            status: 1,
            tips: {
                top: "确定上架吗？",
                bottom: ""
            },
            defaultBtn: !0,
            showLogin: !0
        }) : a.setData({
            status: -1,
            tips: {
                top: "确定下架吗？",
                bottom: "下架后别人将看不到物品",
                footer: "已下架物品将不再接收到聊天消息"
            },
            defaultBtn: !0,
            showLogin: !0
        }); else if (2 == e) {
            var i = a.data.item_id;
            wx.navigateTo({
                url: "../post/index?id=" + i
            }), a.setData({
                show: !1
            });
        }
    },
    goNext: function() {
        var a = this, e = a.data.item_id, i = a.data.status;
        app.util.request({
            url: "entry/wxapp/item",
            cachetime: "0",
            data: {
                act: "detail",
                id: e,
                status: i,
                m: "superman_hand2"
            },
            success: function(t) {
                t.data.errno ? a.showIconToast(t.data.errmsg) : (a.showIconToast("操作成功", "success"), 
                a.setData({
                    show: !1,
                    defaultBtn: !1,
                    showLogin: !1
                }), a.getItemDetail(e), 2 == i && a.setData({
                    disabled: !0
                }));
            },
            fail: function(t) {
                a.setData({
                    showLogin: !1
                }), wx.showModal({
                    title: "系统提示",
                    content: t.data.errmsg + "(" + t.data.errno + ")"
                });
            }
        });
    },
    buy: function(t) {
        var a = t.detail.formId;
        app.util.request({
            url: "entry/wxapp/notice",
            cachetime: "0",
            data: {
                act: "formid",
                formid: a,
                m: "superman_hand2"
            },
            success: function(t) {
                0 == t.data.errno ? console.log("formid已添加") : console.log(t.data.errmsg);
            },
            fail: function(t) {
                console.log(t.data.errmsg);
            }
        });
        var e = t.currentTarget.dataset.id, i = t.currentTarget.dataset.type;
        wx.navigateTo({
            url: "../cashier/index?type=" + i + "&id=" + e
        });
    },
    onShareAppMessage: function(t) {
        return "menu" === t.from && this.setData({
            showShare: !1
        }), {
            title: this.data.detail.title,
            path: "/pages/detail/index?id=" + this.data.item_id
        };
    },
    showIconToast: function(t) {
        var a = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : "fail";
        Toast({
            type: a,
            message: t,
            selector: "#zan-toast"
        });
    }
});