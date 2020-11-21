var _xx_util = require("../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../resource/apis/index.js");

function _interopRequireDefault(t) {
    return t && t.__esModule ? t : {
        default: t
    };
}

function _asyncToGenerator(t) {
    return function() {
        var r = t.apply(this, arguments);
        return new Promise(function(i, s) {
            return function e(t, a) {
                try {
                    var o = r[t](a), n = o.value;
                } catch (t) {
                    return void s(t);
                }
                if (!o.done) return Promise.resolve(n).then(function(t) {
                    e("next", t);
                }, function(t) {
                    e("throw", t);
                });
                i(n);
            }("next");
        });
    };
}

var app = getApp(), chatInput = require("../../chat/chat-input/chat-input.js"), regeneratorRuntime = _xx_util2.default.regeneratorRuntime, beginTime = 0, endTime = 0;

Page({
    data: {
        user_id: "",
        chat_to_uid: "",
        contactUserName: "",
        chatAvatarUrl: "",
        toChatAvatarUrl: "",
        messageDate: "",
        chatInfo: {},
        messageList: [],
        limit: 0,
        staffDefaultData: {
            title: "",
            phone: "",
            wechat: "",
            info: [ {
                img: "/longbing_card/resource/images/img/1.png",
                name: "进入我的名片"
            }, {
                img: "/longbing_card/resource/images/img/2.png",
                name: "查看公司官网"
            }, {
                img: "/longbing_card/resource/images/img/3.png",
                name: "查看公司商品"
            }, {
                img: "/longbing_card/resource/images/img/4.png",
                name: "查看我的动态"
            } ]
        },
        countMessage: 0
    },
    onLoad: function(D) {
        var w = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            var n, i, e, a, s, o, r, u, c, d, l, g, f, h, m, _, p, x, v;
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    if (n = w, i = D.goods_id, e = D.is_tpl, a = D.to_uid, s = D.chat_to_uid, o = D.chatid, 
                    r = D.chatAvatarUrl, u = D.toChatAvatarUrl, c = D.contactUserName, d = wx.getStorageSync("userid"), 
                    l = getApp().globalData.isIphoneX, 1 != e) {
                        t.next = 17;
                        break;
                    }
                    return g = {
                        user_id: d,
                        target_id: a
                    }, t.next = 8, _index.baseModel.getChatInfo(g);

                  case 8:
                    f = t.sent, h = f.data, m = h.user_info, _ = h.target_info, p = h.chat_id, x = _.nickName, 
                    v = _.avatarUrl, o = p, s = a, r = m.avatarUrl, u = v, c = x;

                  case 17:
                    n.setData({
                        isIphoneX: l,
                        is_tpl: e || 0,
                        user_id: d,
                        chat_to_uid: s,
                        "chatInfo.chat_id": o,
                        chatAvatarUrl: r,
                        toChatAvatarUrl: u,
                        contactUserName: c
                    }, function() {
                        if (n.initData(), n.getCardIndexData(), n.getChat(), n.subscribe(), i) {
                            console.log(i, "options.goods_id*************//");
                            var t = _xx_util2.default.getPage(-1).data.detailData, e = t.name, a = t.cover_true, o = {
                                text: {
                                    user_id: d,
                                    target_id: s,
                                    content: "您好，我想咨询下产品【" + e + "】的相关信息。",
                                    type: "text",
                                    status: 1
                                },
                                image: {
                                    user_id: d,
                                    target_id: s,
                                    content: a,
                                    type: "image",
                                    status: 1
                                }
                            };
                            n.setData({
                                tmpGoodsData: o
                            });
                        }
                    });

                  case 18:
                  case "end":
                    return t.stop();
                }
            }, t, w);
        }))();
    },
    subscribe: function() {
        var e = this;
        return _asyncToGenerator(regeneratorRuntime.mark(function t() {
            return regeneratorRuntime.wrap(function(t) {
                for (;;) switch (t.prev = t.next) {
                  case 0:
                    getApp().websocket.subscribe("getMsg", e.addMessageToList);

                  case 1:
                  case "end":
                    return t.stop();
                }
            }, t, e);
        }))();
    },
    addMessageToList: function(t) {
        var e = this, a = e.data, o = a.chat_to_uid, n = a.user_id, i = a.messageList, s = t.data2.user_id || t.user_id;
        if (console.log("接收到用户" + s + "发送的消息;当前聊天对象" + o), o != s) return !1;
        var r = t.data2 ? t.data2 : {
            user_id: s,
            target_id: n,
            content: t.data,
            type: t.type || "text",
            status: 1,
            uniacid: getApp().siteInfo.uniacid
        }, u = i.length;
        if (0 < u) i[u - 1].list.push(r); else {
            var c = (new Date().getTime() / 1e3).toFixed(0), d = _xx_util2.default.formatTime(1e3 * c, "YY-M-D h:m:s");
            i.push({
                create_time: d,
                list: [ r ]
            });
        }
        e.setData({
            messageList: i
        }, function() {
            e.pageScrollToBottom();
        });
    },
    onUnload: function() {
        console.log("页面卸载"), getApp().websocket.unSubscribe("unread"), getApp().websocket.unSubscribe("getMsg");
    },
    onPullDownRefresh: function() {
        console.log("监听用户下拉动作");
        var t = this;
        if (!t.data.messageDate && 1 == t.data.messageList.length) {
            var e = t.data.messageList[0].list[0].id;
            t.setData({
                messageDate: e
            }), console.log(e);
        }
        t.setData({
            show: !0
        }), t.getMessageList(), setTimeout(function() {
            wx.stopPullDownRefresh();
        }, 1e3);
    },
    initData: function() {
        var t = wx.getSystemInfoSync();
        chatInput.init(this, {
            systemInfo: t,
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
            pageHeight: t.windowHeight
        }), this.textButton(), this.extraButton();
    },
    textButton: function() {
        var n = this;
        chatInput.setTextMessageListener(function(t) {
            t.success;
            var e = t.e, a = (t.fail, e.detail.value), o = {
                user_id: n.data.user_id,
                target_id: n.data.chat_to_uid,
                content: a,
                type: "text",
                status: 1
            };
            n.toSendMessage(o, 1);
        });
    },
    extraButton: function() {
        var o = this;
        chatInput.clickExtraListener(function(t) {
            var e = parseInt(t.currentTarget.dataset.index);
            1 !== e ? (wx.chooseImage({
                count: 1,
                sizeType: [ "compressed" ],
                sourceType: 0 === e ? [ "album" ] : [ "camera" ],
                success: function(t) {
                    var e = t.tempFiles;
                    wx.showLoading({
                        title: "发送中..."
                    }), console.log(e), wx.uploadFile({
                        url: _xx_util2.default.getUrl("upload", "longbing_card"),
                        filePath: e[0].path,
                        name: "upfile",
                        formData: {},
                        success: function(t) {
                            console.log(t, "******/////////////////////res"), wx.hideLoading();
                            var e = JSON.parse(t.data).data.path, a = {
                                user_id: o.data.user_id,
                                target_id: o.data.chat_to_uid,
                                content: e,
                                type: "image",
                                status: 1
                            };
                            o.toSendMessage(a, 3);
                        }
                    });
                }
            }), o.hideExtra(), chatInput.closeExtraView()) : wx.chooseVideo({
                maxDuration: 10,
                success: function(t) {
                    console.log(t);
                    var e = t.tempFilePath, a = t.thumbTempFilePath;
                    wx.showLoading({
                        title: "发送中..."
                    }), console.log(e, a);
                },
                fail: function(t) {},
                complete: function(t) {}
            });
        }), chatInput.setExtraButtonClickListener(function(t) {
            console.log("Extra弹窗是否消息", t);
        });
    },
    pageScrollToBottom: function() {
        wx.createSelectorQuery().select(".speak_box").boundingClientRect(function(t) {
            console.log(t), wx.pageScrollTo({
                scrollTop: t.height
            });
        }).exec();
    },
    hideExtra: function(t) {
        this.setData({
            "inputObj.extraObj.chatInputShowExtra": !1
        });
    },
    toSendMessage: function(t, e) {
        var a = this;
        getApp().websocket.sendMessage(t);
        var o = (new Date().getTime() / 1e3).toFixed(0), n = _xx_util2.default.formatTime(1e3 * o, "YY-M-D h:m:s"), i = a.data, s = i.messageList, r = i.countMessage, u = s.length;
        0 < u ? s[u - 1].list.push(t) : s.push({
            create_time: n,
            list: [ t ]
        }), a.SendTemplate(o, t.content, t.type), a.setData({
            messageList: s,
            countMessage: r ? 1 * r + 1 : 0
        }, function() {
            a.pageScrollToBottom();
        });
    },
    SendTemplate: function(t, e, a) {
        var o = {
            to_uid: this.data.chat_to_uid,
            date: t,
            content: e,
            type: a
        };
        _index.staffModel.getSendTemplate(o).then(function(t) {
            _xx_util2.default.hideAll();
        });
    },
    getChat: function() {
        var e = this;
        _index.staffModel.getChatId({
            to_uid: e.data.chat_to_uid
        }).then(function(t) {
            _xx_util2.default.hideAll(), 0 == t.errno && (e.setData({
                chatInfo: t.data,
                chatAvatarUrl: t.data.user_info.avatarUrl,
                toChatAvatarUrl: t.data.target_info.avatarUrl
            }), e.getMessageList());
        });
    },
    getMessageList: function() {
        var r = this, t = r.data, u = t.tmpGoodsData, e = t.messageDate, a = {
            chat_id: t.chatInfo.chat_id
        };
        e && (a.create_time = e), _index.staffModel.getMessages(a).then(function(t) {
            if (_xx_util2.default.hideAll(), 0 == t.errno) {
                var e = t.data.list;
                if (0 == e.length) return r.setData({
                    more: !1,
                    loading: !1,
                    isEmpty: !0,
                    show: !0
                }), !1;
                r.setData({
                    loading: !0,
                    messageDate: t.data.create_time
                });
                var a, o = r.data.messageList;
                for (var n in 1 == r.data.onPullDownRefresh && (o = []), o = o.reverse(), e) e[n].create_time.length < 12 && (e[n].create_time = _xx_util2.default.formatTime(1e3 * e[n].create_time, "YY-M-D h:m:s"));
                a = (e = e.reverse())[0].create_time, o.push({
                    create_time: a,
                    list: e
                }), o = o.reverse();
                var i = 0;
                for (var s in o) i += o[s].list.length;
                r.setData({
                    messageList: o,
                    onPullDownRefresh: !1,
                    countMessage: i
                }), u && (r.toSendMessage(u.text, 3), setTimeout(function() {
                    r.toSendMessage(u.image, 3), r.setData({
                        tmpGoodsData: !1
                    });
                }, 1e3));
            }
        });
    },
    getCardIndexData: function() {
        var s = this;
        _xx_util2.default.showLoading();
        var t = {
            to_uid: s.data.chat_to_uid
        };
        _index.userModel.getCardShow(t).then(function(t) {
            _xx_util2.default.hideAll(), console.log("getCardShow ==>", t.data);
            var e = t.data, a = e.info, o = a.name, n = a.phone, i = a.wechat;
            wx.setNavigationBarTitle({
                title: o
            }), s.setData({
                cardIndexData: e,
                contactUserName: o,
                "staffDefaultData.phone": n,
                "staffDefaultData.wechat": i,
                "staffDefaultData.title": "你好，我是" + o + "，有什么可以帮到你？记得联系我！"
            });
        });
    },
    toJump: function(t) {
        var e = this, a = t.currentTarget.dataset.status, o = t.currentTarget.dataset.index, n = t.currentTarget.dataset.type, i = t.currentTarget.dataset.content;
        if ("toHome" == a) _xx_util2.default.goUrl(t); else if ("toSeeStaff" == a) {
            var s = "/longbing_card/pages/index/index?to_uid=" + e.data.chat_to_uid + "&from_id=" + app.globalData.from_id + "&currentTabBar=";
            0 == o ? s += "toCard" : 1 == o ? s += "toCompany" : 2 == o ? s += "toShop" : 3 == o && (s += "toNews"), 
            wx.navigateTo({
                url: s
            });
        } else if ("toCallCopy" == a) {
            if (!i) return !1;
            2 == n ? wx.makePhoneCall({
                phoneNumber: i,
                success: function(t) {
                    e.toCopyRecord(n);
                }
            }) : 4 == n && wx.setClipboardData({
                data: i,
                success: function(t) {
                    wx.getClipboardData({
                        success: function(t) {
                            e.toCopyRecord(n);
                        }
                    });
                }
            });
        } else "toCopy" == a ? (console.log("复制聊天内容 || 复制微信 || 打电话"), _xx_util2.default.goUrl(t)) : "toCopyWechat" == a ? (wx.setClipboardData({
            data: i,
            success: function(t) {
                console.log(t), wx.getClipboardData({
                    success: function(t) {
                        console.log("复制文本成功 ==>>", t.data);
                    }
                });
            }
        }), e.toCopyRecord(n)) : "toCallPhone" == a ? (_xx_util2.default.goUrl(t), e.toCopyRecord(n)) : "toSaveCard" == a ? wx.navigateTo({
            url: "/longbing_card/users/pages/card/share/share"
        }) : "previewImage" == a && (console.log(t), wx.previewImage({
            current: i,
            urls: [ i ]
        }));
    },
    toCopyRecord: function(t) {
        var e = {
            type: t,
            to_uid: this.data.chat_to_uid
        };
        _index.userModel.getCopyRecord(e).then(function(t) {
            _xx_util2.default.hideAll();
        });
    },
    formSubmit: function(t) {
        var e = t.detail.formId;
        _index.baseModel.getFormId({
            formId: e
        });
    },
    getWebSocketErrorTime: function() {
        endTime = new Date();
        var t = beginTime;
        console.log("beginTime", beginTime, "endTime", endTime);
        var e = endTime.getTime() - t.getTime(), a = Math.floor(e / 864e5), o = e % 864e5, n = Math.floor(o / 36e5), i = o % 36e5, s = Math.floor(i / 6e4), r = i % 6e4, u = Math.round(r / 1e3);
        console.log(" 相差 " + a + "天 " + n + "小时 " + s + " 分钟" + u + " 秒");
    }
});