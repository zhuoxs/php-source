var _xx_util = require("../../../../resource/js/xx_util.js"), _xx_util2 = _interopRequireDefault(_xx_util), _index = require("../../../../resource/apis/index.js");

function _interopRequireDefault(e) {
    return e && e.__esModule ? e : {
        default: e
    };
}

function _toConsumableArray(e) {
    if (Array.isArray(e)) {
        for (var t = 0, a = Array(e.length); t < e.length; t++) a[t] = e[t];
        return a;
    }
    return Array.from(e);
}

var app = getApp(), chatInput = require("../../../../chat/chat-input/chat-input.js"), regeneratorRuntime = _xx_util2.default.regeneratorRuntime;

Page({
    data: {
        tagType: 0,
        useMessageType: [],
        currUType: 0,
        useMessage: [],
        showEditSec: !1,
        dataList: {
            page: 1,
            total_page: 1,
            list: [],
            refresh: !1,
            loading: !0
        }
    },
    onLoad: function(e) {
        var t = this;
        wx.hideShareMenu();
        var a = "", s = e.status, i = e.type, n = e.text, o = {
            status: s,
            type: i
        };
        if (e.status && ("manager" == e.status && (a = n), "message" == e.status)) {
            a = "群发";
            var d = _xx_util2.default.getPage(-1).data;
            o.count = d.check_lable_count, o.lable_id = d.check_lable_id, o.lable_name = d.check_lable_name;
        }
        wx.setNavigationBarTitle({
            title: a
        }), getApp().getConfigInfo().then(function() {
            t.setData({
                globalData: app.globalData,
                paramObj: o
            }, function() {
                t.initData(), "manager" == o.status && t.toGetAdminRecord();
            });
        });
    },
    onPullDownRefresh: function() {
        var e = this, t = e.data, a = t.paramObj, s = t.dataList;
        "manager" == a.status && (s.page == s.total_page || s.loading || e.setData({
            "dataList.page": parseInt(s.page) + 1,
            "dataList.loading": !0
        }, function() {
            e.toGetAdminRecord();
        }));
    },
    initData: function() {
        var e = this, t = wx.getSystemInfoSync();
        chatInput.init(this, {
            systemInfo: t,
            minVoiceTime: 1,
            maxVoiceTime: 60,
            startTimeDown: 56,
            format: "mp3",
            sendButtonBgColor: "mediumseagreen",
            sendButtonTextColor: "white",
            extraArr: []
        }), e.setData({
            pageHeight: t.windowHeight
        }), e.textButton(), e.extraButton(), e.getReplyList();
    },
    textButton: function() {
        var i = this;
        chatInput.setTextMessageListener(function(e) {
            var s = e.success, t = e.e, a = (e.fail, {
                content: t.detail.value,
                lable_id: i.data.paramObj.lable_id
            });
            _index.staffModel.getGroupSend(a).then(function(a) {
                _xx_util2.default.hideAll(), setTimeout(function() {
                    var e = i.data.paramObj;
                    if (0 == a.errno) {
                        _xx_util2.default.showSuccess("发送成功");
                        var t = "message" == e.status && "next" == e.type ? 2 : 1;
                        wx.navigateBack({
                            delta: t
                        }), s(!0);
                    }
                    -1 == a.errno && _xx_util2.default.showFail("发送失败");
                }, 2e3);
            });
        });
    },
    extraButton: function() {
        var s = this;
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
                            var t = JSON.parse(e.data).data.path, a = {
                                user_id: s.data.user_id,
                                target_id: s.data.chat_to_uid,
                                content: t,
                                type: "image",
                                uniacid: app.siteInfo.uniacid
                            };
                            a = JSON.stringify(a);
                        }
                    });
                }
            }), s.hideExtra()) : wx.chooseVideo({
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
    toGetAdminRecord: function() {
        var i = this, n = i.data.dataList;
        n.refresh || _xx_util2.default.showLoading();
        var e = {
            page: n.page
        };
        _index.staffModel.getAdminRecord(e).then(function(e) {
            _xx_util2.default.hideAll();
            var t = n, a = e.data;
            for (var s in t.list = t.list.reverse(), n.refresh || (a.list = [].concat(_toConsumableArray(t.list), _toConsumableArray(a.list))), 
            a.list) a.list[s].last_time2 = _xx_util2.default.formatTime(1e3 * a.list[s].create_time);
            a.page = a.page, a.refresh = !1, a.loading = !1, a.list = a.list.reverse(), i.setData({
                dataList: a
            }, function() {
                i.pageScrollToBottom();
            });
        });
    },
    toSendMessage: function(e) {
        var s = this;
        _index.staffModel.getGroupSend(e).then(function(a) {
            _xx_util2.default.hideAll(), console.log("getGroupSend ==>", a.data), setTimeout(function() {
                var e = s.data.paramObj;
                if (0 == a.errno) {
                    _xx_util2.default.showSuccess("发送成功");
                    var t = "message" == e.status && "next" == e.type ? 2 : 1;
                    wx.navigateBack({
                        delta: t
                    });
                }
                -1 == a.errno && _xx_util2.default.showFail("发送失败");
            }, 2e3);
        });
    },
    getReplyList: function() {
        var i = this;
        _index.staffModel.getReplyList().then(function(e) {
            if (_xx_util2.default.hideAll(), 0 != e.errno) return !1;
            var t = e.data, a = i.data.useMessageType;
            for (var s in t) a.push(t[s].title);
            i.setData({
                useMessage: t,
                useMessageType: a
            });
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
        var a = this, s = a.data.useMessage, i = s[a.data.currUType].list;
        _index.staffModel.getEditReply({
            id: i[a.data.toEditInd].id,
            content: t
        }).then(function(e) {
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
    toJump: function(e) {
        var t = this, a = _xx_util2.default.getData(e), s = a.status, i = a.type, n = a.index, o = a.content;
        if ("toHome" == s || "toJumpUrl" == s) _xx_util2.default.goUrl(e); else if ("toStarMark" == s) ; else if ("previewImage" == s) wx.previewImage({
            current: o,
            urls: [ o ]
        }); else if ("toCopy" == s) _xx_util2.default.goUrl(e); else if ("toUse" == s) t.setData({
            showUseMessage: !0
        }); else if ("toSetTab" == s) t.setData({
            currUType: n,
            showEditSec: !1
        }); else if ("toSendMessage" == s) {
            var d = {
                content: o,
                lable_id: t.data.paramObj.lable_id
            };
            t.setData({
                showUseMessage: !1,
                showAddUseSec: !1,
                showAddUseSecContent: "",
                toEditInd: ""
            }, function() {
                t.toSendMessage(d);
            });
        } else if ("toClose" == s) t.setData({
            showUseMessage: !1,
            showAddUseSec: !1,
            showAddUseSecContent: "",
            toEditInd: ""
        }); else if ("toAdd" == s) t.setData({
            showAddUseSec: !0
        }); else if ("toEditSec" == s) {
            var l;
            1 == i && (l = !1), 0 == i && (l = !0), t.setData({
                showEditSec: l
            });
        } else "toEdit" == s ? t.setData({
            showAddUseSecContent: o,
            showAddUseSec: !0,
            toEditInd: n
        }) : "toDelete" == s && wx.showModal({
            title: "",
            content: "是否确认删除此数据？",
            success: function(e) {
                e.confirm ? t.getDelReply(n) : t.setData({
                    showEditSec: !1
                });
            }
        });
    },
    formSubmit: function(e) {
        var t = e.detail.formId, a = _xx_util2.default.getFormData(e).status;
        if (_index.baseModel.getFormId({
            formId: t
        }), "toJumpUrl" == a) _xx_util2.default.goUrl(e, !0); else if ("toCancel" == a) this.setData({
            showAddUseSec: !1,
            showAddUseSecContent: "",
            toEditInd: ""
        }); else if ("toSaveUseMessage" == a) {
            var s = e.detail.value.newuse;
            this.data.showAddUseSecContent ? this.getEditReply(s) : this.getAddReply(s);
        }
    }
});