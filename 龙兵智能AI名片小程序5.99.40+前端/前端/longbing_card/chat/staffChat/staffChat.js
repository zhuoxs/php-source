var _xx_util = require("../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _asyncToGenerator(e) {
    return function() {
        var r = e.apply(this, arguments);
        return new Promise(function(n, o) {
            return function t(e, a) {
                try {
                    var s = r[e](a), i = s.value;
                } catch (e) {
                    return void o(e);
                }
                if (!s.done) return Promise.resolve(i).then(function(e) {
                    t("next", e);
                }, function(e) {
                    t("throw", e);
                });
                n(i);
            }("next");
        });
    };
}

var app = getApp(), chatInput = require("../../chat/chat-input/chat-input.js"), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        user_id: "",
        chat_to_uid: "",
        contactUserName: "",
        chatAvatarUrl: "",
        toChatAvatarUrl: "",
        messageDate: "",
        useMessageType: [],
        currUType: 0,
        useMessage: [],
        showEditSec: !1,
        clientSource: [],
        messageList: [],
        showAddUseSec: !1,
        showUseMessage: !1,
        countMessage: 0
    },
    onLoad: function(w) {
        var v = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            var t, a, s, i, n, o, r, u, d, c, l, h, f, g, _, p, x, m;
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    if (t = v, console.log(w, "options"), a = w.is_tpl, s = w.to_uid, i = w.chat_to_uid, 
                    n = w.chatid, o = w.chatAvatarUrl, r = w.toChatAvatarUrl, u = w.contactUserName, 
                    d = wx.getStorageSync("userid"), c = getApp().globalData.isIphoneX, 1 != a) {
                        e.next = 18;
                        break;
                    }
                    return l = {
                        user_id: d,
                        target_id: s
                    }, e.next = 9, _index.baseModel.getChatInfo(l);

                  case 9:
                    h = e.sent, f = h.data, g = f.user_info, _ = f.target_info, p = f.chat_id, x = _.nickName, 
                    m = _.avatarUrl, n = p, i = s, o = g.avatarUrl, r = m, u = x;

                  case 18:
                    t.setData({
                        isIphoneX: c,
                        is_tpl: a || 0,
                        user_id: d,
                        chat_to_uid: i,
                        "chatInfo.chat_id": n || 0,
                        chatAvatarUrl: o,
                        toChatAvatarUrl: r,
                        contactUserName: u
                    }, function() {
                        t.initData(), 0 < t.data.chatInfo.chat_id ? t.getMessageList() : t.getChat(), wx.setNavigationBarTitle({
                            title: u
                        }), t.subscribe();
                    });

                  case 19:
                  case "end":
                    return e.stop();
                }
            }, e, v);
        }))();
    },
    subscribe: function() {
        var t = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function e() {
            return regeneratorRuntime.wrap(function(e) {
                for (;;) switch (e.prev = e.next) {
                  case 0:
                    getApp().websocket.subscribe("getMsg", t.addMessageToList);

                  case 1:
                  case "end":
                    return e.stop();
                }
            }, e, t);
        }))();
    },
    addMessageToList: function(e) {
        var t = this, a = t.data, s = a.chat_to_uid, i = a.user_id, n = a.messageList, o = e.data2.user_id || e.user_id;
        if (console.log("接收到用户" + o + "发送的消息;当前聊天对象" + s), s != o) return !1;
        var r = e.data2 ? e.data2 : {
            user_id: o,
            target_id: i,
            content: e.data,
            type: e.type || "text",
            status: 1,
            uniacid: getApp().siteInfo.uniacid
        }, u = n.length;
        if (0 < u) n[u - 1].list.push(r); else {
            var d = (new Date().getTime() / 1e3).toFixed(0), c = _xx_util2.default.formatTime(1e3 * d, "YY-M-D h:m:s");
            n.push({
                create_time: c,
                list: [ r ]
            });
        }
        t.setData({
            messageList: n
        }, function() {
            t.pageScrollToBottom();
        });
    },
    onShow: function() {
        var e = this;
        e.setData({
            "useMessage.list": [],
            useMessageType: []
        }, function() {
            e.getSource();
        });
    },
    onUnload: function() {
        getApp().websocket.unSubscribe("getMsg");
    },
    catchtouchmove: function() {
        return !1;
    },
    onPullDownRefresh: function() {
        console.log("监听用户下拉动作");
        var e = this;
        if (!e.data.messageDate && 1 == e.data.messageList.length) {
            var t = e.data.messageList[0].list[0].id;
            e.setData({
                messageDate: t
            });
        }
        e.setData({
            show: !0,
            "useMessage.list": [],
            useMessageType: [],
            showUseMessage: !1,
            showClientSource: !1
        }, function() {
            e.getMessageList(), e.getSource();
        }), setTimeout(function() {
            wx.stopPullDownRefresh();
        }, 1e3);
    },
    initData: function() {
        var e = wx.getSystemInfoSync();
        chatInput.init(this, {
            systemInfo: e,
            minVoiceTime: 1,
            maxVoiceTime: 60,
            startTimeDown: 56,
            format: "mp3",
            sendButtonBgColor: "mediumseagreen",
            sendButtonTextColor: "white",
            extraArr: [ {
                picName: "choose_picture",
                description: "照片"
            } ]
        }), this.setData({
            pageHeight: e.windowHeight
        }), this.textButton(), this.extraButton();
    },
    textButton: function() {
        var i = this;
        chatInput.setTextMessageListener(function(e) {
            e.success;
            var t = e.e, a = (e.fail, t.detail.value), s = {
                user_id: i.data.user_id,
                target_id: i.data.chat_to_uid,
                content: a,
                type: "text",
                status: 1
            };
            i.toSendMessage(s, 1);
        });
    },
    extraButton: function() {
        var i = this;
        chatInput.clickExtraListener(function(e) {
            var t = parseInt(e.currentTarget.dataset.index);
            1 !== t ? (wx.chooseImage({
                count: 1,
                sizeType: [ "compressed" ],
                sourceType: 0 === t ? [ "album" ] : [ "camera" ],
                success: function(e) {
                    var t = e.tempFiles;
                    wx.showLoading({
                        title: "发送中..."
                    }), wx.uploadFile({
                        url: _xx_util2.default.getUrl("upload", "longbing_card"),
                        filePath: t[0].path,
                        name: "upfile",
                        formData: {},
                        success: function(e) {
                            wx.hideLoading();
                            var t = JSON.parse(e.data).data.path, a = i.data, s = {
                                user_id: a.user_id,
                                target_id: a.chat_to_uid,
                                content: t,
                                type: "image",
                                status: 1
                            };
                            i.toSendMessage(s, 3);
                        }
                    });
                }
            }), i.hideExtra()) : wx.chooseVideo({
                maxDuration: 10,
                success: function(e) {
                    e.tempFilePath, e.thumbTempFilePath;
                    wx.showLoading({
                        title: "发送中..."
                    });
                },
                fail: function(e) {},
                complete: function(e) {}
            });
        }), chatInput.setExtraButtonClickListener(function(e) {});
    },
    pageScrollToBottom: function() {
        wx.createSelectorQuery().select(".speak_box").boundingClientRect(function(e) {
            wx.pageScrollTo({
                scrollTop: e.height
            });
        }).exec();
    },
    hideExtra: function(e) {
        this.setData({
            "inputObj.extraObj.chatInputShowExtra": !1
        });
    },
    toSendMessage: function(e, t) {
        var a = this;
        console.log(e, "sendMessage"), getApp().websocket.sendMessage(e);
        var s = (new Date().getTime() / 1e3).toFixed(0), i = _xx_util2.default.formatTime(1e3 * s, "YY-M-D h:m:s"), n = a.data, o = n.messageList, r = n.showUseMessage, u = n.showAddUseSec, d = n.countMessage, c = o.length;
        0 < c ? o[c - 1].list.push(e) : o.push({
            create_time: i,
            list: [ e ]
        }), a.SendTemplateCilent(s, e.content, e.type), a.setData({
            messageList: o,
            showUseMessage: 2 != t && r,
            showAddUseSec: 2 != t && u,
            countMessage: d ? 1 * d + 1 : 0
        }, function() {
            a.pageScrollToBottom();
        });
    },
    SendTemplateCilent: function(e, t, a) {
        var s = {
            client_id: this.data.chat_to_uid,
            date: e,
            content: t,
            type: a
        };
        _index.staffModel.getSendTemplateCilent(s).then(function(e) {
            _xx_util2.default.hideAll();
        });
    },
    getSource: function() {
        var n = this;
        _index.staffModel.getSource({
            client_id: n.data.chat_to_uid
        }).then(function(e) {
            if (_xx_util2.default.hideAll(), 0 == e.errno) {
                var t = e.data.share_str, a = n.data.contactUserName, s = {};
                if (-1 < t.indexOf("//XL:")) {
                    var i = t.split("//XL:");
                    s.clientSourceStr = i, s.clientSourceType = "group", a = a + " " + i[0] + i[1];
                } else a = a + " " + t;
                wx.setNavigationBarTitle({
                    title: a
                }), n.setData({
                    clientSource: e.data,
                    showClientSourceData: s
                });
            }
        }), n.getReplyList();
    },
    getChat: function() {
        var t = this;
        _index.staffModel.getChatId({
            to_uid: t.data.chat_to_uid
        }).then(function(e) {
            _xx_util2.default.hideAll(), 0 == e.errno && (t.setData({
                chatInfo: e.data,
                chatAvatarUrl: e.data.user_info.avatarUrl,
                toChatAvatarUrl: e.data.target_info.avatarUrl
            }), t.getMessageList());
        });
    },
    getMessageList: function() {
        var r = this, e = {
            chat_id: r.data.chatInfo.chat_id
        };
        r.data.messageDate && (e.create_time = r.data.messageDate), _index.staffModel.getMessages(e).then(function(e) {
            if (_xx_util2.default.hideAll(), 0 == e.errno) {
                var t = e.data.list;
                if (0 == t.length) return r.setData({
                    more: !1,
                    loading: !1,
                    isEmpty: !0,
                    show: !0
                }), !1;
                r.setData({
                    loading: !0,
                    messageDate: e.data.create_time
                });
                var a, s = r.data.messageList;
                for (var i in 1 == r.data.onPullDownRefresh && (s = []), s = s.reverse(), t) t[i].create_time.length < 12 && (t[i].create_time = _xx_util2.default.formatTime(1e3 * t[i].create_time, "YY-M-D h:m:s"));
                a = (t = t.reverse())[0].create_time, s.push({
                    create_time: a,
                    list: t
                }), s = s.reverse();
                var n = 0;
                for (var o in s) n += s[o].list.length;
                r.setData({
                    messageList: s,
                    onPullDownRefresh: !1,
                    countMessage: n
                });
            }
        });
    },
    getReplyList: function() {
        var i = this;
        _index.staffModel.getReplyList().then(function(e) {
            if (_xx_util2.default.hideAll(), 0 == e.errno) {
                var t = e.data, a = i.data.useMessageType;
                for (var s in t) a.push(t[s].title);
                i.setData({
                    useMessage: t,
                    useMessageType: a
                });
            }
        });
    },
    getAddReply: function(t) {
        var a = this, s = a.data.useMessage, i = s[a.data.currUType].list;
        _index.staffModel.getAddReply({
            content: t
        }).then(function(e) {
            _xx_util2.default.hideAll(), 0 == e.errno && (i.push({
                id: e.data.id,
                content: t
            }), a.setData({
                currUType: 0,
                useMessage: s,
                showAddUseSec: !1
            }));
        });
    },
    getEditReply: function(t) {
        var a = this, s = a.data.useMessage, i = s[a.data.currUType].list, e = {
            id: i[a.data.toEditInd].id,
            content: t
        };
        _index.staffModel.getEditReply(e).then(function(e) {
            _xx_util2.default.hideAll(), 0 == e.errno ? (i[a.data.toEditInd].content = t, a.setData({
                useMessage: s,
                showAddUseSecContent: "",
                showAddUseSec: !1,
                showEditSec: !1
            })) : a.setData({
                showAddUseSecContent: "",
                showAddUseSec: !1,
                showEditSec: !1
            });
        });
    },
    getDelReply: function(t) {
        var a = this, s = a.data.useMessage, i = s[a.data.currUType].list;
        _index.staffModel.getDelReply({
            id: i[t].id
        }).then(function(e) {
            _xx_util2.default.hideAll(), 0 == e.errno ? (wx.showToast({
                icon: "none",
                title: "已成功删除数据！",
                duration: 1e3
            }), i.splice(t, 1), a.setData({
                useMessage: s,
                showEditSec: !1
            })) : a.setData({
                showEditSec: !1
            });
        });
    },
    toSetStarMark: function() {
        var a = this, e = {
            client_id: a.data.chat_to_uid
        };
        _index.staffModel.getStarMark(e).then(function(e) {
            _xx_util2.default.hideAll();
            var t = 1;
            1 == a.data.clientSource.start && (t = 0), a.setData({
                "clientSource.start": t
            });
        });
    },
    toJump: function(e) {
        var t = this, a = e.currentTarget.dataset.status, s = e.currentTarget.dataset.index, i = e.currentTarget.dataset.type, n = e.currentTarget.dataset.content;
        if ("toHome" == a || "toJumpUrl" == a) _xx_util2.default.goUrl(e); else if ("toSource" == a) t.setData({
            showClientSource: !0
        }); else if ("toStarMark" == a) t.toSetStarMark(); else if ("previewImage" == a) wx.previewImage({
            current: n,
            urls: [ n ]
        }); else if ("toCopy" == a) _xx_util2.default.goUrl(e); else if ("toUse" == a) t.setData({
            showUseMessage: !0
        }, function() {
            t.catchtouchmove();
        }); else if ("toSetTab" == a) t.setData({
            currUType: s,
            showEditSec: !1
        }); else if ("toSendMessage" == a) {
            var o = {
                user_id: t.data.user_id,
                target_id: t.data.chat_to_uid,
                content: n,
                type: "text",
                status: 1
            };
            t.toSendMessage(o, 2);
        } else if ("toClose" == a) t.setData({
            showClientSource: !1,
            showUseMessage: !1,
            showAddUseSec: !1,
            showAddUseSecContent: "",
            toEditInd: ""
        }); else if ("toAdd" == a) t.setData({
            showAddUseSec: !0
        }); else if ("toEditSec" == a) {
            var r;
            1 == i && (r = !1), 0 == i && (r = !0), t.setData({
                showEditSec: r
            });
        } else "toEdit" == a ? t.setData({
            showAddUseSecContent: n,
            showAddUseSec: !0,
            toEditInd: s
        }) : "toDelete" == a && wx.showModal({
            title: "",
            content: "是否确认删除此数据？",
            success: function(e) {
                e.confirm ? t.getDelReply(s) : t.setData({
                    showEditSec: !1
                });
            }
        });
    },
    formSubmit: function(e) {
        var t = e.detail.target.dataset.status, a = e.detail.formId;
        if (_index.baseModel.getFormId({
            formId: a
        }), "toCancel" == t) this.setData({
            showAddUseSec: !1,
            showAddUseSecContent: "",
            toEditInd: ""
        }); else if ("toSaveUseMessage" == t) {
            var s = e.detail.value.newuse;
            if (!s) return wx.showModal({
                title: "",
                content: "请输入您的话术！",
                confirmText: "知道啦",
                showCancel: !1
            }), !1;
            this.data.showAddUseSecContent ? this.getEditReply(s) : this.getAddReply(s);
        }
    }
});