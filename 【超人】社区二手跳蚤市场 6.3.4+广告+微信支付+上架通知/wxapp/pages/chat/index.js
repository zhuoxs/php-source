var app = getApp(), WxEmoji = require("../../libs/WxEmojiView/WxEmojiView.js"), Toast = require("../../libs/zanui/toast/toast");

Page({
    data: {
        showMsg: !1,
        adjust: !0,
        bottom: app.globalData.iphoneX ? "68rpx" : 0,
        showConfirm: !1,
        iphoneX: app.globalData.iphoneX,
        pages: 1,
        hide: !0,
        more: !0,
        refresh: !0
    },
    onLoad: function(t) {
        var a = this, e = wx.getStorageSync("loading_img");
        e ? a.setData({
            loadingImg: e
        }) : a.setData({
            loadingImg: "../../libs/images/loading.gif"
        }), app.viewCount();
        var o = wx.getStorageSync("userInfo");
        a.setData({
            itemid: t.itemid,
            fromuid: t.fromuid,
            touid: o.memberInfo.uid
        }), a.getChatMsg(), app.globalData.isOpenSocket || (app.initChat(), app.globalData.isOpenSocket = !0), 
        WxEmoji.bindThis(a);
    },
    getChatMsg: function() {
        var n = this, t = n.data.itemid, a = n.data.fromuid;
        app.util.request({
            url: "entry/wxapp/message",
            data: {
                act: "chat",
                fromuid: a,
                itemid: t,
                m: "superman_hand2"
            },
            success: function(t) {
                if (t.data.errno) n.showIconToast(t.data.errmsg); else {
                    var a = t.data.data, e = a.from.nickname;
                    wx.setNavigationBarTitle({
                        title: "与" + e + "聊天中"
                    });
                    for (var o = a.message, s = new Date().setHours(0, 0, 0, 0) / 1e3, i = 0; i < o.length; i++) o[i].createtime > s ? o[i].date = app.util.dateToStr("HH:mm", new Date(1e3 * o[i].createtime)) : o[i].date = app.util.dateToStr("yyyy-MM-dd HH:mm", new Date(1e3 * o[i].createtime)), 
                    o[i].message = WxEmoji.explain(o[i].message);
                    n.setData({
                        info: a,
                        total: o.length,
                        msg_list: o,
                        credit_title: app.globalData.credit_title,
                        completed: !0
                    });
                }
            },
            fail: function(t) {
                n.setData({
                    completed: !0
                }), n.showIconToast(t.data.errmsg);
            }
        });
    },
    onShow: function() {
        var a = this;
        wx.onSocketMessage(function(t) {
            switch (JSON.parse(t.data).type) {
              case "ping":
                app.chatMessageSend({
                    type: "pong"
                });
                break;

              case "say":
                a.getChatMsg();
            }
        });
    },
    showPopup: function() {
        this.setData({
            showBottomPopup: !0
        });
    },
    toggleBottomPopup: function() {
        this.setData({
            showBottomPopup: !this.data.showBottomPopup
        });
    },
    showEmoji: function() {
        var t = this;
        t.data.showWxEmojiView ? t.setData({
            showWxEmojiView: !1,
            bottom: app.globalData.iphoneX ? "68rpx" : 0,
            paddingBottom: "90rpx"
        }) : t.setData({
            showWxEmojiView: !0,
            bottom: "300rpx",
            paddingBottom: "400rpx"
        });
    },
    setValue: function(t) {
        this.setData({
            msg: t.detail.value
        });
    },
    wxPreEmojiTap: function(t) {
        var a = this, e = t.currentTarget.dataset.text, o = a.data.msg;
        o ? a.setData({
            msg: o + e
        }) : a.setData({
            msg: e
        });
    },
    sendMsg: function(t) {
        var a = this;
        a.data.showWxEmojiView && a.setData({
            bottom: app.globalData.iphoneX ? "68rpx" : 0,
            showWxEmojiView: !1
        });
        var e = a.data.fromuid, o = a.data.itemid, s = a.data.touid, i = a.data.msg;
        if ("" == i) return a.showIconToast("内容不能为空"), !1;
        if (2048 <= i.length) return a.showIconToast("消息太长，请分开发送"), !1;
        var n = {
            type: "say",
            from_uid: s,
            to_uid: e,
            itemid: o,
            content: i,
            form_id: t.detail.formId,
            createtime: parseInt(new Date().getTime() / 1e3)
        };
        app.util.request({
            url: "entry/wxapp/notice",
            cachetime: "0",
            data: {
                act: "formid",
                formid: t.detail.formId,
                m: "superman_hand2"
            },
            success: function(t) {
                0 == t.data.errno ? console.log("formid已添加") : console.log(t.data.errmsg);
            },
            fail: function(t) {
                console.log(t.data.errmsg);
            }
        }), app.chatMessageSend(n, a.getChatMsg()), a.setData({
            msg: "",
            paddingBottom: "90rpx"
        });
        var r = wx.getSystemInfoSync().windowHeight;
        wx.pageScrollTo({
            scrollTop: r + 60
        });
    },
    onPullDownRefresh: function() {
        var s = this;
        if (s.data.refresh) {
            if (s.data.total < 20) return s.setData({
                more: !1
            }), void wx.stopPullDownRefresh();
            s.setData({
                hide: !1
            });
            var i = s.data.pages + 1;
            app.util.request({
                url: "entry/wxapp/message",
                cachetime: "0",
                data: {
                    act: "chat",
                    page: i,
                    m: "superman_hand2"
                },
                success: function(t) {
                    if (s.setData({
                        hide: !0
                    }), wx.stopPullDownRefresh(), 0 == t.data.errno) {
                        var a = t.data.data.message;
                        if (0 < a.length) {
                            var e = s.data.msg_list;
                            s.setData({
                                total: a.length
                            });
                            var o = e.concat(a);
                            s.setData({
                                msg_list: o,
                                pages: i
                            });
                        } else s.setData({
                            more: !1,
                            refresh: !1
                        });
                    } else s.showIconToast(t.errmsg);
                }
            });
        } else wx.stopPullDownRefresh();
    },
    jubao: function() {
        this.setData({
            showModal: !0
        });
    },
    formSubmit: function(t) {
        var a = this, e = t.detail.value.content, o = t.currentTarget.dataset.itemid, s = t.detail.formId;
        "" != e ? (app.util.request({
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
        }), app.util.request({
            url: "entry/wxapp/item",
            cachetime: "0",
            data: {
                act: "report",
                itemid: o,
                content: e,
                formid: s,
                m: "superman_hand2"
            },
            success: function(t) {
                a.setData({
                    showModal: !1
                }), t.data.errno || a.showIconToast("已举报，等待处理中...", "success");
            },
            fail: function(t) {
                a.setData({
                    showModal: !1,
                    report: !1
                }), a.showIconToast(t.data.errmsg);
            }
        })) : a.showIconToast("请输入举报原因");
    },
    closeModal: function() {
        this.setData({
            showModal: !1
        });
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