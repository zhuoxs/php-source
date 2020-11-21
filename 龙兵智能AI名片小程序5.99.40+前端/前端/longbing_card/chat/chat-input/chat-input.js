var _page = void 0, inputObj = {}, recorderManager = void 0, windowHeight = void 0, windowWidth = void 0, singleVoiceTimeCount = 0, maxVoiceTime = 60, minVoiceTime = 1, startTimeDown = 54, timer = void 0, sendVoiceCbOk = void 0, sendVoiceCbError = void 0, startVoiceRecordCbOk = void 0, tabbarHeigth = 0, extraButtonClickEvent = void 0, canUsePress = !1, voiceFormat = void 0, cancelLineYPosition = 0, status = {
    START: 1,
    SUCCESS: 2,
    CANCEL: 3,
    SHORT: 4,
    FAIL: 5,
    UNAUTH: 6
};

function init(e, t) {
    windowHeight = t.systemInfo.windowHeight, windowWidth = t.systemInfo.windowWidth, 
    canUsePress = "1.5.0" < t.systemInfo.SDKVersion, minVoiceTime = t.minVoiceTime ? t.minVoiceTime : 1, 
    maxVoiceTime = t.maxVoiceTime && t.maxVoiceTime <= 60 ? t.maxVoiceTime : 60, voiceFormat = t.format || "mp3", 
    startTimeDown = t.startTimeDown && t.startTimeDown < maxVoiceTime && 0 < t.startTimeDown ? t.startTimeDown : 54, 
    isNaN(t.tabbarHeigth) || (tabbarHeigth = t.tabbarHeigth), windowHeight && windowWidth ? (_page = e, 
    initData(t), initVoiceData(), initExtraData(t.extraArr), initChangeInputWayEvent(), 
    wx.getRecorderManager ? (recorderManager = wx.getRecorderManager(), dealVoiceLongClickEventWithHighVersion()) : dealVoiceLongClickEventWithLowVersion(), 
    dealVoiceMoveEvent(), dealVoiceMoveEndEvent()) : console.error("没有获取到手机的屏幕尺寸：windowWidth", windowWidth, "windowHeight", windowHeight);
}

function clickExtraItemListener(e) {
    _page.chatInputExtraItemClickEvent = "function" == typeof e ? e : null;
}

function sendVoiceListener(e, t) {
    sendVoiceCbError = t, sendVoiceCbOk = e, recorderManager && ("function" == typeof e && recorderManager.onStop(function(e) {
        console.log(e, _page.data.inputObj.voiceObj.status), "short" !== _page.data.inputObj.voiceObj.status ? _page.data.inputObj.voiceObj.moveToCancel ? "function" == typeof startVoiceRecordCbOk && startVoiceRecordCbOk(status.CANCEL) : (console.log("录音成功"), 
        "function" == typeof startVoiceRecordCbOk && startVoiceRecordCbOk(status.SUCCESS), 
        "function" == typeof sendVoiceCbOk && sendVoiceCbOk(e, Math.round(e.duration / 1e3))) : "function" == typeof startVoiceRecordCbOk && startVoiceRecordCbOk(status.SHORT);
    }), "function" == typeof t && recorderManager.onError(function(e) {
        "function" == typeof startVoiceRecordCbOk && startVoiceRecordCbOk(status.FAIL), 
        "function" == typeof sendVoiceCbError && sendVoiceCbError(e);
    }));
}

function setVoiceRecordStatusListener() {
    startVoiceRecordCbOk = arguments[0];
}

function initChangeInputWayEvent() {
    _page.changeInputWayEvent = function() {
        _page.setData({
            "inputObj.inputStatus": "text" === _page.data.inputObj.inputStatus ? "voice" : "text",
            "inputObj.extraObj.chatInputShowExtra": !1
        });
    };
}

function initVoiceData() {
    var e = windowWidth / 2.6;
    _page.setData({
        "inputObj.inputStyle": _page.data.inputObj.inputStyle,
        "inputObj.canUsePress": canUsePress,
        "inputObj.inputStatus": "text",
        "inputObj.windowHeight": windowHeight,
        "inputObj.windowWidth": windowWidth,
        "inputObj.voiceObj.status": "end",
        "inputObj.voiceObj.startStatus": 0,
        "inputObj.voiceObj.voicePartWidth": e,
        "inputObj.voiceObj.moveToCancel": !1,
        "inputObj.voiceObj.voicePartPositionToBottom": (windowHeight - e / 2.4) / 2,
        "inputObj.voiceObj.voicePartPositionToLeft": (windowWidth - e) / 2
    }), cancelLineYPosition = .12 * windowHeight;
}

function setExtraButtonClickListener(e) {
    extraButtonClickEvent = e;
}

function initExtraData(e) {
    _page.setData({
        "inputObj.extraObj.chatInputExtraArr": e
    }), _page.chatInputExtraClickEvent = function() {
        _page.setData({
            "inputObj.extraObj.chatInputShowExtra": !0
        }), _page.pageScrollToBottom(), extraButtonClickEvent && extraButtonClickEvent(!0);
    };
}

function dealVoiceLongClickEventWithHighVersion() {
    recorderManager.onStart(function() {
        singleVoiceTimeCount = 0, timer = setInterval(function() {
            startTimeDown <= ++singleVoiceTimeCount && singleVoiceTimeCount < maxVoiceTime ? _page.setData({
                "inputObj.voiceObj.timeDownNum": maxVoiceTime - singleVoiceTimeCount,
                "inputObj.voiceObj.status": "timeDown"
            }) : maxVoiceTime <= singleVoiceTimeCount && (_page.setData({
                "inputObj.voiceObj.status": "timeout"
            }), delayDismissCancelView(), clearInterval(timer), endRecord());
        }, 1e3);
    }), _page.long$click$voice$btn = function(e) {
        "send$voice$btn" === e.currentTarget.id && (_page.setData({
            "inputObj.voiceObj.showCancelSendVoicePart": !0,
            "inputObj.voiceObj.timeDownNum": maxVoiceTime - singleVoiceTimeCount,
            "inputObj.voiceObj.status": "start",
            "inputObj.voiceObj.startStatus": 1,
            "inputObj.voiceObj.moveToCancel": !1
        }), "function" == typeof startVoiceRecordCbOk && startVoiceRecordCbOk(status.START), 
        checkRecordAuth(function() {
            recorderManager.start({
                duration: 6e4,
                format: voiceFormat
            });
        }, function(e) {
            console.error("录音拒绝授权"), clearInterval(timer), endRecord(), _page.setData({
                "inputObj.voiceObj.status": "end",
                "inputObj.voiceObj.showCancelSendVoicePart": !1
            }), "function" == typeof startVoiceRecordCbOk && startVoiceRecordCbOk(status.UNAUTH), 
            sendVoiceCbError ? "function" == typeof sendVoiceCbError && sendVoiceCbError(e) : wx.openSetting ? wx.showModal({
                title: "您未授权语音功能",
                content: "暂时不能使用语音",
                confirmText: "去设置",
                success: function(e) {
                    e.confirm ? wx.openSetting({
                        success: function(e) {
                            e.authSetting["scope.record"] && _page.setData({
                                "inputObj.extraObj.chatInputShowExtra": !1
                            });
                        }
                    }) : _page.setData({
                        "inputObj.inputStatus": "text",
                        "inputObj.extraObj.chatInputShowExtra": !1
                    });
                }
            }) : wx.showModal({
                title: "无法使用语音",
                content: "请将微信升级至最新版本才可使用语音功能",
                success: function(e) {
                    e.confirm;
                }
            });
        }));
    };
}

function dealVoiceLongClickEventWithLowVersion() {
    _page.long$click$voice$btn = function(e) {
        "send$voice$btn" === e.currentTarget.id && (singleVoiceTimeCount = 0, _page.setData({
            "inputObj.voiceObj.showCancelSendVoicePart": !0,
            "inputObj.voiceObj.timeDownNum": maxVoiceTime - singleVoiceTimeCount,
            "inputObj.voiceObj.status": "start",
            "inputObj.voiceObj.startStatus": 1,
            "inputObj.voiceObj.moveToCancel": !1
        }), "function" == typeof startVoiceRecordCbOk && startVoiceRecordCbOk(status.START), 
        checkRecordAuth(function() {
            wx.startRecord({
                success: function(e) {
                    console.log(e, _page.data.inputObj.voiceObj.status), "short" !== _page.data.inputObj.voiceObj.status ? _page.data.inputObj.voiceObj.moveToCancel ? "function" == typeof startVoiceRecordCbOk && startVoiceRecordCbOk(status.CANCEL) : (console.log("录音成功"), 
                    "function" == typeof startVoiceRecordCbOk && startVoiceRecordCbOk(status.SUCCESS), 
                    "function" == typeof sendVoiceCbOk && sendVoiceCbOk(e, singleVoiceTimeCount + "")) : "function" == typeof startVoiceRecordCbOk && startVoiceRecordCbOk(status.SHORT);
                },
                fail: function(e) {
                    "function" == typeof startVoiceRecordCbOk && startVoiceRecordCbOk(status.FAIL), 
                    "function" == typeof sendVoiceCbError && sendVoiceCbError(e);
                }
            }), timer = setInterval(function() {
                startTimeDown <= ++singleVoiceTimeCount && singleVoiceTimeCount < maxVoiceTime ? _page.setData({
                    "inputObj.voiceObj.timeDownNum": maxVoiceTime - singleVoiceTimeCount,
                    "inputObj.voiceObj.status": "timeDown"
                }) : maxVoiceTime <= singleVoiceTimeCount && (_page.setData({
                    "inputObj.voiceObj.status": "timeout"
                }), delayDismissCancelView(), clearInterval(timer), endRecord());
            }, 1e3);
        }, function(e) {
            console.error("录音拒绝授权"), clearInterval(timer), endRecord(), _page.setData({
                "inputObj.voiceObj.status": "end",
                "inputObj.voiceObj.showCancelSendVoicePart": !1
            }), "function" == typeof startVoiceRecordCbOk && startVoiceRecordCbOk(status.UNAUTH), 
            sendVoiceCbError ? "function" == typeof sendVoiceCbError && sendVoiceCbError(e) : wx.openSetting ? wx.showModal({
                title: "您未授权语音功能",
                content: "暂时不能使用语音",
                confirmText: "去设置",
                success: function(e) {
                    e.confirm ? wx.openSetting({
                        success: function(e) {
                            e.authSetting["scope.record"] && _page.setData({
                                "inputObj.extraObj.chatInputShowExtra": !1
                            });
                        }
                    }) : _page.setData({
                        "inputObj.inputStatus": "text",
                        "inputObj.extraObj.chatInputShowExtra": !1
                    });
                }
            }) : wx.showModal({
                title: "无法使用语音",
                content: "请将微信升级至最新版本才可使用语音功能",
                success: function(e) {
                    e.confirm;
                }
            });
        }));
    };
}

function dealVoiceMoveEvent() {
    _page.send$voice$move$event = function(e) {
        if ("send$voice$btn" === e.currentTarget.id) {
            var t = windowHeight + tabbarHeigth - e.touches[0].clientY;
            cancelLineYPosition < t ? inputObj.voiceObj.moveToCancel || _page.setData({
                "inputObj.voiceObj.moveToCancel": !0
            }) : inputObj.voiceObj.moveToCancel && _page.setData({
                "inputObj.voiceObj.moveToCancel": !1
            });
        }
    };
}

function dealVoiceMoveEndEvent() {
    _page.send$voice$move$end$event = function(e) {
        "send$voice$btn" === e.currentTarget.id && (singleVoiceTimeCount < minVoiceTime ? (_page.setData({
            "inputObj.voiceObj.status": "short"
        }), delayDismissCancelView()) : _page.setData({
            "inputObj.voiceObj.showCancelSendVoicePart": !1,
            "inputObj.voiceObj.status": "end"
        }), timer && clearInterval(timer), endRecord());
    };
}

function checkRecordAuth(t, i) {
    getApp().getNetworkConnected ? wx.getSetting ? wx.getSetting({
        success: function(e) {
            e.authSetting["scope.record"] ? t && t() : wx.authorize({
                scope: "scope.record",
                success: function(e) {
                    console.log("同意", e);
                },
                fail: function(e) {
                    console.log("拒绝", e), i && i();
                }
            });
        }
    }) : wx.showModal({
        title: "无法使用语音",
        content: "请将微信升级至最新版本才可使用语音功能",
        success: function(e) {
            e.confirm;
        }
    }) : t && t();
}

function closeExtraView() {
    _page.setData({
        "inputObj.extraObj.chatInputShowExtra": !1
    });
}

function delayDismissCancelView() {
    setTimeout(function() {
        "start" !== inputObj.voiceObj.status && _page.setData({
            "inputObj.voiceObj.showCancelSendVoicePart": !1,
            "inputObj.voiceObj.status": "end"
        });
    }, 1e3);
}

function initData(e) {
    _page.data.inputObj = inputObj = {
        voiceObj: {},
        inputStyle: {
            sendButtonBgColor: e.sendButtonBgColor || "mediumseagreen",
            sendButtonTextColor: e.sendButtonTextColor || "white"
        }
    };
}

function endRecord() {
    _page.setData({
        "inputObj.voiceObj.startStatus": 0
    }), recorderManager ? recorderManager.stop() : wx.stopRecord();
}

function setTextMessageListener(t) {
    _page && (_page.chatInputBindFocusEvent = function() {
        _page.setData({
            "inputObj.inputType": "text"
        });
    }, _page.chatInputBindBlurEvent = function() {
        _page.setData({
            "inputObj.inputType": "none",
            "inputObj.extraObj.chatInputShowExtra": !1
        });
    }, _page.chatInputSendTextMessage = function(e) {
        (_page.setData({
            textMessage: ""
        }), inputObj.inputValueEventTemp && inputObj.inputValueEventTemp.detail.value) && ("function" == typeof t && getApp().util.promisify(t)({
            e: JSON.parse(JSON.stringify(inputObj.inputValueEventTemp))
        }).then(function(e) {
            console.log("获取openGId结果："), console.log(e), _page.setData({
                textMessage: "",
                "inputObj.inputType": "none"
            }), inputObj.inputValueEventTemp = null;
        }).catch(function(e) {
            wx.showToast({
                icon: "none",
                title: "网络异常，请重新发送！",
                duration: 3e3
            });
        }));
    }, _page.chatInputSendTextMessage02 = function() {
        (_page.setData({
            textMessage: ""
        }), inputObj.inputValueEventTemp && inputObj.inputValueEventTemp.detail.value) && ("function" == typeof t && getApp().util.promisify(t)({
            e: JSON.parse(JSON.stringify(inputObj.inputValueEventTemp))
        }).then(function(e) {
            console.log("获取openGId结果："), console.log(e), _page.setData({
                textMessage: "",
                "inputObj.inputType": "none"
            }), inputObj.inputValueEventTemp = null;
        }).catch(function(e) {
            wx.showToast({
                icon: "none",
                title: "网络异常，请重新发送！",
                duration: 3e3
            });
        }));
    }, _page.chatInputGetValueEvent = function(e) {
        inputObj.inputValueEventTemp = e;
    });
}

function setTextMessageValue(e) {
    _page.setData({
        textMessage: e + "-----"
    });
}

module.exports = {
    init: init,
    clickExtraListener: clickExtraItemListener,
    closeExtraView: closeExtraView,
    recordVoiceListener: sendVoiceListener,
    setVoiceRecordStatusListener: setVoiceRecordStatusListener,
    setTextMessageListener: setTextMessageListener,
    setExtraButtonClickListener: setExtraButtonClickListener,
    VRStatus: status,
    setTextMessageValue: setTextMessageValue
};