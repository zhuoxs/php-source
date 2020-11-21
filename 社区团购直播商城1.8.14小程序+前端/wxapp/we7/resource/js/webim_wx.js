var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
    return typeof e;
} : function(e) {
    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
};

module.exports = function() {
    "function" != typeof Array.prototype.forEach && (Array.prototype.forEach = function(e) {
        for (var t = 0; t < this.length; t++) e.apply(this, [ this[t], t, this ]);
    });
    var tt = {}, e = {
        login: function(e, t, n) {},
        syncMsgs: function(e, t) {},
        getC2CHistoryMsgs: function(e, t, n) {},
        syncGroupMsgs: function(e, t, n) {},
        sendMsg: function(e, t, n) {},
        logout: function(e, t) {},
        setAutoRead: function(e, t, n) {},
        getProfilePortrait: function(e, t, n) {},
        setProfilePortrait: function(e, t, n) {},
        applyAddFriend: function(e, t, n) {},
        getPendency: function(e, t, n) {},
        deletePendency: function(e, t, n) {},
        responseFriend: function(e, t, n) {},
        getAllFriend: function(e, t, n) {},
        deleteFriend: function(e, t, n) {},
        addBlackList: function(e, t, n) {},
        getBlackList: function(e, t, n) {},
        deleteBlackList: function(e, t, n) {},
        uploadPic: function(e, t, n) {},
        createGroup: function(e, t, n) {},
        applyJoinGroup: function(e, t, n) {},
        handleApplyJoinGroup: function(e, t, n) {},
        deleteApplyJoinGroupPendency: function(e, t, n) {},
        quitGroup: function(e, t, n) {},
        getGroupPublicInfo: function(e, t, n) {},
        getGroupInfo: function(e, t, n) {},
        modifyGroupBaseInfo: function(e, t, n) {},
        destroyGroup: function(e, t, n) {},
        getJoinedGroupListHigh: function(e, t, n) {},
        getGroupMemberInfo: function(e, t, n) {},
        addGroupMember: function(e, t, n) {},
        modifyGroupMember: function(e, t, n) {},
        forbidSendMsg: function(e, t, n) {},
        deleteGroupMember: function(e, t, n) {},
        getPendencyGroup: function(e, t, n) {},
        getPendencyReport: function(e, t, n) {},
        getPendencyGroupRead: function(e, t, n) {},
        sendCustomGroupNotify: function(e, t, n) {},
        Msg: function(e, t, n, o, r, i, s, u, a) {},
        MsgStore: {
            sessMap: function() {
                return {};
            },
            sessCount: function() {
                return 0;
            },
            sessByTypeId: function(e, t) {
                return {};
            },
            delSessByTypeId: function(e, t) {
                return !0;
            },
            resetCookieAndSyncFlag: function() {},
            downloadMap: {}
        }
    };
    return function(t) {
        var l = "1.7.2", p = "537048168", d = "10", U = !0, f = {
            FORMAL: {
                COMMON: "https://webim.tim.qq.com",
                PIC: "https://pic.tim.qq.com"
            },
            TEST: {
                COMMON: "https://test.tim.qq.com",
                PIC: "https://pic.tim.qq.com"
            }
        }, e = {}, D = "openim", k = "group_open_http_svc", s = "sns", c = "profile", u = "recentcontact", g = "openpic", a = "group_open_http_noauth_svc", w = "group_open_long_polling_http_noauth_svc", o = "imopenstat", m = "recentcontact", n = "webim", I = {
            openim: "v4",
            group_open_http_svc: "v4",
            sns: "v4",
            profile: "v4",
            recentcontact: "v4",
            openpic: "v4",
            group_open_http_noauth_svc: "v1",
            group_open_long_polling_http_noauth_svc: "v1",
            imopenstat: "v4",
            webim: "v3"
        }, M = {
            login: 1,
            pic_up: 3,
            apply_join_group: 9,
            create_group: 10,
            longpolling: 18,
            send_group_msg: 19,
            sendmsg: 20
        }, q = {
            C2C: "C2C",
            GROUP: "GROUP"
        }, B = "OK", x = "FAIL", K = {
            TEXT: "TIMTextElem",
            FACE: "TIMFaceElem",
            IMAGE: "TIMImageElem",
            CUSTOM: "TIMCustomElem",
            SOUND: "TIMSoundElem",
            FILE: "TIMFileElem",
            LOCATION: "TIMLocationElem",
            GROUP_TIP: "TIMGroupTipElem"
        }, r = {
            ORIGIN: 1,
            LARGE: 2,
            SMALL: 3
        }, i = {
            JPG: 1,
            JPEG: 1,
            GIF: 2,
            PNG: 3,
            BMP: 4,
            UNKNOWN: 255
        }, y = 1, h = "10001", _ = "grouptalk.c2c.qq.com", E = 2106, T = 2107, C = {
            IMAGE: 1,
            FILE: 2,
            SHORT_VIDEO: 3,
            SOUND: 4
        }, A = "2.1", v = 1, z = 1, H = 3, J = 4, Y = 5, V = 6, X = 7, j = 8, Q = 9, W = 10, $ = {
            COMMON: 0
        }, Z = 92, ee = 96, te = {
            COMMON: 0,
            LOVEMSG: 1,
            TIP: 2,
            REDPACKET: 3
        }, ne = 1, oe = 3, re = {
            JOIN: 1,
            QUIT: 2,
            KICK: 3,
            SET_ADMIN: 4,
            CANCEL_ADMIN: 5,
            MODIFY_GROUP_INFO: 6,
            MODIFY_MEMBER_INFO: 7
        }, ie = {
            FACE_URL: 1,
            NAME: 2,
            OWNER: 3,
            NOTIFICATION: 4,
            INTRODUCTION: 5
        }, se = {
            JOIN_GROUP_REQUEST: 1,
            JOIN_GROUP_ACCEPT: 2,
            JOIN_GROUP_REFUSE: 3,
            KICK: 4,
            DESTORY: 5,
            CREATE: 6,
            INVITED_JOIN_GROUP_REQUEST: 7,
            QUIT: 8,
            SET_ADMIN: 9,
            CANCEL_ADMIN: 10,
            REVOKE: 11,
            READED: 15,
            CUSTOM: 255,
            INVITED_JOIN_GROUP_REQUEST_AGREE: 12
        }, ue = {
            FRIEND_ADD: 1,
            FRIEND_DELETE: 2,
            PENDENCY_ADD: 3,
            PENDENCY_DELETE: 4,
            BLACK_LIST_ADD: 5,
            BLACK_LIST_DELETE: 6,
            PENDENCY_REPORT: 7,
            FRIEND_UPDATE: 8
        }, ae = 1, ce = {
            INIT: -1,
            ON: 0,
            RECONNECT: 1,
            OFF: 9999
        }, le = 14, pe = ce.INIT, de = !1, fe = 0, ge = 6e4, me = 60008, Ie = null, Me = 0, S = 0, ye = [], he = null, _e = {
            sdkAppID: null,
            appIDAt3rd: null,
            accountType: null,
            identifier: null,
            tinyid: null,
            identifierNick: null,
            userSig: null,
            a2: null,
            contentType: "json",
            apn: 1
        }, G = {}, F = 0, b = {}, N = 0, Ee = [], Te = [], R = [], O = {
            downloadMap: {}
        }, L = {
            "[惊讶]": 0,
            "[撇嘴]": 1,
            "[色]": 2,
            "[发呆]": 3,
            "[得意]": 4,
            "[流泪]": 5,
            "[害羞]": 6,
            "[闭嘴]": 7,
            "[睡]": 8,
            "[大哭]": 9,
            "[尴尬]": 10,
            "[发怒]": 11,
            "[调皮]": 12,
            "[龇牙]": 13,
            "[微笑]": 14,
            "[难过]": 15,
            "[酷]": 16,
            "[冷汗]": 17,
            "[抓狂]": 18,
            "[吐]": 19,
            "[偷笑]": 20,
            "[可爱]": 21,
            "[白眼]": 22,
            "[傲慢]": 23,
            "[饿]": 24,
            "[困]": 25,
            "[惊恐]": 26,
            "[流汗]": 27,
            "[憨笑]": 28,
            "[大兵]": 29,
            "[奋斗]": 30,
            "[咒骂]": 31,
            "[疑问]": 32,
            "[嘘]": 33,
            "[晕]": 34
        }, P = {}, Ce = new function() {
            this.formatTimeStamp = function(e, t) {
                if (!e) return 0;
                var n;
                t = t || "yyyy-MM-dd hh:mm:ss";
                var o = new Date(1e3 * e), r = {
                    "M+": o.getMonth() + 1,
                    "d+": o.getDate(),
                    "h+": o.getHours(),
                    "m+": o.getMinutes(),
                    "s+": o.getSeconds()
                };
                for (var i in n = /(y+)/.test(t) ? t.replace(RegExp.$1, (o.getFullYear() + "").substr(4 - RegExp.$1.length)) : t, 
                r) new RegExp("(" + i + ")").test(n) && (n = n.replace(RegExp.$1, 1 == RegExp.$1.length ? r[i] : ("00" + r[i]).substr(("" + r[i]).length)));
                return n;
            }, this.groupTypeEn2Ch = function(e) {
                var t = null;
                switch (e) {
                  case "Public":
                    t = "公开群";
                    break;

                  case "ChatRoom":
                    t = "聊天室";
                    break;

                  case "Private":
                    t = "私有群";
                    break;

                  case "AVChatRoom":
                    t = "直播聊天室";
                    break;

                  default:
                    t = e;
                }
                return t;
            }, this.groupTypeCh2En = function(e) {
                var t = null;
                switch (e) {
                  case "公开群":
                    t = "Public";
                    break;

                  case "聊天室":
                    t = "ChatRoom";
                    break;

                  case "私有群":
                    t = "Private";
                    break;

                  case "直播聊天室":
                    t = "AVChatRoom";
                    break;

                  default:
                    t = e;
                }
                return t;
            }, this.groupRoleEn2Ch = function(e) {
                var t = null;
                switch (e) {
                  case "Member":
                    t = "成员";
                    break;

                  case "Admin":
                    t = "管理员";
                    break;

                  case "Owner":
                    t = "群主";
                    break;

                  default:
                    t = e;
                }
                return t;
            }, this.groupRoleCh2En = function(e) {
                var t = null;
                switch (e) {
                  case "成员":
                    t = "Member";
                    break;

                  case "管理员":
                    t = "Admin";
                    break;

                  case "群主":
                    t = "Owner";
                    break;

                  default:
                    t = e;
                }
                return t;
            }, this.groupMsgFlagEn2Ch = function(e) {
                var t = null;
                switch (e) {
                  case "AcceptAndNotify":
                    t = "接收并提示";
                    break;

                  case "AcceptNotNotify":
                    t = "接收不提示";
                    break;

                  case "Discard":
                    t = "屏蔽";
                    break;

                  default:
                    t = e;
                }
                return t;
            }, this.groupMsgFlagCh2En = function(e) {
                var t = null;
                switch (e) {
                  case "接收并提示":
                    t = "AcceptAndNotify";
                    break;

                  case "接收不提示":
                    t = "AcceptNotNotify";
                    break;

                  case "屏蔽":
                    t = "Discard";
                    break;

                  default:
                    t = e;
                }
                return t;
            }, this.formatText2Html = function(e) {
                var t = e;
                return t && (t = (t = (t = this.xssFilter(t)).replace(/ /g, "&nbsp;")).replace(/\n/g, "<br/>")), 
                t;
            }, this.formatHtml2Text = function(e) {
                var t = e;
                return t && (t = (t = t.replace(/&nbsp;/g, " ")).replace(/<br\/>/g, "\n")), t;
            }, this.getStrBytes = function(e) {
                if (null == e || void 0 === e) return 0;
                if ("string" != typeof e) return 0;
                var t, n, o, r = 0;
                for (n = 0, o = e.length; n < o; n++) r += (t = e.charCodeAt(n)) <= 127 ? 1 : t <= 2047 ? 2 : t <= 65535 ? 3 : 4;
                return r;
            }, this.xssFilter = function(e) {
                return e = (e = (e = (e = e.toString()).replace(/[<]/g, "&lt;")).replace(/[>]/g, "&gt;")).replace(/"/g, "&quot;");
            }, this.trimStr = function(e) {
                return e ? (e = e.toString()).replace(/(^\s*)|(\s*$)/g, "") : "";
            }, this.validNumber = function(e) {
                return (e = e.toString()).match(/(^\d{1,8}$)/g);
            }, this.getReturnError = function(e, t) {
                return t || (t = -100), {
                    ActionStatus: x,
                    ErrorCode: t,
                    ErrorInfo: e + "[" + t + "]"
                };
            }, this.replaceObject = function(e, t) {
                for (var n in t) if (e[n]) if (t[e[n]] = t[n], delete t[n], t[e[n]] instanceof Array) for (var o = t[e[n]].length, r = 0; r < o; r++) t[e[n]][r] = this.replaceObject(e, t[e[n]][r]); else "object" === _typeof(t[e[n]]) && (t[e[n]] = this.replaceObject(e, t[e[n]]));
                return t;
            };
        }(), Ae = new function() {
            var t = !0;
            this.setOn = function(e) {
                t = e;
            }, this.getOn = function() {
                return t;
            }, this.error = function(e) {
                try {
                    t && console.error(e);
                } catch (e) {}
            }, this.warn = function(e) {
                try {
                    t && console.warn(e);
                } catch (e) {}
            }, this.info = function(e) {
                try {
                    t && console.info(e);
                } catch (e) {}
            }, this.debug = function(e) {
                try {
                    t && console.debug(e);
                } catch (e) {}
            };
        }(), ve = function(e) {
            return e || (e = new Date()), Math.round(e.getTime() / 1e3);
        }, Se = function() {
            return N ? N += 1 : N = Math.round(1e7 * Math.random()), N;
        }, Ge = function() {
            return Math.round(4294967296 * Math.random());
        }, Fe = function(e, t, n, o, r, i, s) {
            var u, a, c, l, p;
            u = e, a = t, c = JSON.stringify(n), l = function(e) {
                var t = null;
                e && (t = e), i && i(t);
            }, p = s, wx.request({
                url: a,
                data: c,
                dataType: "json",
                method: u,
                header: {
                    "Content-Type": "application/json"
                },
                success: function(e) {
                    fe = Me = 0, l && l(e.data);
                },
                fail: function(e) {
                    setTimeout(function() {
                        var e = Ce.getReturnError("请求服务器失败,请检查你的网络是否正常", -2);
                        p && p(e);
                    }, 16);
                }
            });
        }, be = function() {
            return _e.sdkAppID && _e.identifier;
        }, Ne = function(e, t) {
            if (!be()) {
                if (t) {
                    var n = Ce.getReturnError("请登录", -4);
                    e && e(n);
                }
                return !1;
            }
            return !0;
        }, Re = function() {
            return U;
        }, Oe = function(e, t, n) {
            var o = null;
            return he && ye[0] ? o = "http://" + ye[0] + "/asn.com/stddownload_common_file?authkey=" + he + "&bid=" + h + "&subbid=" + _e.sdkAppID + "&fileid=" + e + "&filetype=" + T + "&openid=" + t + "&ver=0&filename=" + encodeURIComponent(n) : Ae.error("拼接文件下载url不报错：ip或者authkey为空"), 
            O.downloadMap["uuid_" + e] = o;
        }, Le = function(e, t, n, o, r, i, s) {
            var u = {
                From_Account: t,
                To_Account: r,
                os_platform: 10,
                Timestamp: ve().toString(),
                Random: Ge().toString(),
                request_info: [ {
                    busi_id: i,
                    download_flag: o,
                    type: s,
                    uuid: e,
                    version: v,
                    auth_key: he,
                    ip: ye[0]
                } ]
            };
            Ve(u, function(e) {
                0 == e.error_code && e.response_info && (O.downloadMap["uuid_" + u.uuid] = e.response_info.url), 
                onAppliedDownloadUrl && onAppliedDownloadUrl({
                    uuid: u.uuid,
                    url: e.response_info.url,
                    maps: O.downloadMap
                });
            }, function(e) {
                Ae.error("获取下载地址失败", u.uuid);
            });
        }, Pe = function() {
            !function() {
                for (var e in b) {
                    var t = b[e];
                    t && (t.abort(), b[F] = null);
                }
                F = 0, b = {};
            }(), _e = {
                sdkAppID: null,
                appIDAt3rd: null,
                accountType: null,
                identifier: null,
                identifierNick: null,
                userSig: null,
                contentType: "json",
                apn: 1
            }, G = {}, N = 0, R = [], Ze.clear(), $e.clear(), Ie = null;
        }, Ue = function(e, t, n) {
            if ("longpolling" != e || t != me && 91101 != t) {
                var o = M[e];
                if (o) {
                    var r = ve(), i = null, s = {
                        Code: t,
                        ErrMsg: n
                    };
                    if (_e.a2 ? i = _e.a2.substring(0, 10) + "_" + r + "_" + Ge() : _e.userSig && (i = _e.userSig.substring(0, 10) + "_" + r + "_" + Ge()), 
                    i) {
                        var u = {
                            UniqKey: i,
                            EventId: o,
                            ReportTime: r,
                            MsgCmdErrorCode: s
                        };
                        if ("login" == e) {
                            var a = [];
                            a.push(u), Je({
                                EvtItems: a,
                                MainVersion: l,
                                Version: "0"
                            }, function(e) {
                                a = null;
                            }, function(e) {
                                a = null;
                            });
                        } else {
                            if (R.push(u), 20 <= R.length) Je({
                                EvtItems: R,
                                MainVersion: l,
                                Version: "0"
                            }, function(e) {
                                R = [];
                            }, function(e) {
                                R = [];
                            });
                        }
                    }
                }
            }
        }, De = function(t) {
            Xe.apiCall(n, "accesslayer", {}, function(e) {
                0 === e.ErrorCode && 1 === e.WebImAccessLayer && (f.FORMAL.COMMON = "https://events.tim.qq.com"), 
                t();
            }, function() {
                t();
            });
        }, ke = function(i, n) {
            Xe.apiCall(D, "login", {
                State: "Online"
            }, function(e) {
                if (e.TinyId) _e.tinyid = e.TinyId; else if (n) return void n(Ce.getReturnError("TinyId is empty", -10));
                if (e.A2Key) _e.a2 = e.A2Key; else if (n) return void n(Ce.getReturnError("A2Key is empty", -11));
                var t = {
                    From_Account: _e.identifier,
                    To_Account: [ _e.identifier ],
                    LastStandardSequence: 0,
                    TagList: [ "Tag_Profile_IM_Nick", "Tag_Profile_IM_Image" ]
                };
                ze(t, function(e) {
                    var t, n;
                    if (e.UserProfileItem && 0 < e.UserProfileItem.length) for (var o in e.UserProfileItem) for (var r in e.UserProfileItem[o].ProfileItem) switch (e.UserProfileItem[o].ProfileItem[r].Tag) {
                      case "Tag_Profile_IM_Nick":
                        (t = e.UserProfileItem[o].ProfileItem[r].Value) && (_e.identifierNick = t);
                        break;

                      case "Tag_Profile_IM_Image":
                        (n = e.UserProfileItem[o].ProfileItem[r].Value) && (_e.headurl = n);
                    }
                    i && i(_e.identifierNick, _e.headurl);
                }, n);
            }, n);
        }, we = function(e, t, n) {
            if (!Ne(n, !1)) return Pe(), void (t && t({
                ActionStatus: B,
                ErrorCode: 0,
                ErrorInfo: "logout success"
            }));
            "all" == e ? Xe.apiCall(D, "logout", {}, function(e) {
                Pe(), t && t(e);
            }, n) : Xe.apiCall(D, "longpollinglogout", {
                LongPollingId: Ie
            }, function(e) {
                Pe(), t && t(e);
            }, n);
        }, qe = function(e, t, n, o) {
            if (Ne(o, !0)) {
                var r = [];
                for (var i in t) {
                    var s = {
                        To_Account: t[i].toAccount,
                        LastedMsgTime: t[i].lastedMsgTime
                    };
                    r.push(s);
                }
                Xe.apiCall(D, "msgreaded", {
                    C2CMsgReaded: {
                        Cookie: e,
                        C2CMsgReadedItem: r
                    }
                }, n, o);
            }
        }, Be = function(e, t, n) {
            Ne(n, !0) && Xe.apiCall(k, "get_joined_group_list", {
                Member_Account: e.Member_Account,
                Limit: e.Limit,
                Offset: e.Offset,
                GroupType: e.GroupType,
                ResponseFilter: {
                    GroupBaseInfoFilter: e.GroupBaseInfoFilter,
                    SelfInfoFilter: e.SelfInfoFilter
                }
            }, t, n);
        }, xe = function(e, t, n) {
            Ne(n, !0) && Xe.apiCall(k, "msg_read_report", {
                GroupId: e.GroupId,
                MsgReadedSeq: e.MsgReadedSeq
            }, t, n);
        }, Ke = function(e) {
            var t = [];
            if (e.Fail_Account && e.Fail_Account.length && (t = e.Fail_Account), e.Invalid_Account && e.Invalid_Account.length) for (var n in e.Invalid_Account) t.push(e.Invalid_Account[n]);
            if (t.length) for (var o in e.ActionStatus = x, e.ErrorCode = 99999, e.ErrorInfo = "", 
            t) {
                var r = t[o];
                for (var i in e.ResultItem) if (e.ResultItem[i].To_Account == r) {
                    var s = e.ResultItem[i].ResultCode;
                    e.ResultItem[i].ResultInfo = "[" + s + "]" + e.ResultItem[i].ResultInfo, e.ErrorInfo += e.ResultItem[i].ResultInfo + "\n";
                    break;
                }
            }
            return e;
        }, ze = function(e, u, a) {
            100 < e.To_Account.length && (e.To_Account.length = 100, Ae.error("获取用户资料人数不能超过100人")), 
            Ne(a, !0) && Xe.apiCall(c, "portrait_get", {
                From_Account: _e.identifier,
                To_Account: e.To_Account,
                TagList: e.TagList
            }, function(e) {
                var t = [];
                if (e.Fail_Account && e.Fail_Account.length && (t = e.Fail_Account), e.Invalid_Account && e.Invalid_Account.length) for (var n in e.Invalid_Account) t.push(e.Invalid_Account[n]);
                if (t.length) for (var o in e.ActionStatus = x, e.ErrorCode = 99999, e.ErrorInfo = "", 
                t) {
                    var r = t[o];
                    for (var i in e.UserProfileItem) if (e.UserProfileItem[i].To_Account == r) {
                        var s = e.UserProfileItem[i].ResultCode;
                        e.UserProfileItem[i].ResultInfo = "[" + s + "]" + e.UserProfileItem[i].ResultInfo, 
                        e.ErrorInfo += "账号:" + r + "," + e.UserProfileItem[i].ResultInfo + "\n";
                        break;
                    }
                }
                e.ActionStatus == x ? a && a(e) : u && u(e);
            }, a);
        }, He = function(e, t, n) {
            var o;
            Ne(n, !0) && (o = Re() ? "pic_up" : "pic_up_test", Xe.apiCall(g, o, {
                App_Version: A,
                From_Account: _e.identifier,
                To_Account: e.To_Account,
                Seq: e.Seq,
                Timestamp: e.Timestamp,
                Random: e.Random,
                File_Str_Md5: e.File_Str_Md5,
                File_Size: e.File_Size,
                File_Type: e.File_Type,
                Server_Ver: v,
                Auth_Key: he,
                Busi_Id: e.Busi_Id,
                PkgFlag: e.PkgFlag,
                Slice_Offset: e.Slice_Offset,
                Slice_Size: e.Slice_Size,
                Slice_Data: e.Slice_Data
            }, t, n));
        }, Je = function(e, t, n) {
            Ne(n, !0) && Xe.apiCall(o, "web_report", e, t, n);
        }, Ye = function(e, t, n) {
            Ne(n, !0) && Xe.apiCall(D, "getlongpollingid", {}, function(e) {
                t && t(e);
            }, n);
        }, Ve = function(e, t, n) {
            Xe.apiCall(g, "apply_download", e, t, n);
        };
        e = "wechat";
        var Xe = new function() {
            var o = null;
            this.init = function(e, t, n) {
                e && (o = e);
            }, this.callBack = function(e) {
                o && o(e);
            }, this.clear = function() {
                o = null;
            }, this.apiCall = function(r, i, s, u, a, e, t) {
                var c = function(e, t, n, o) {
                    var r = f;
                    r = Re() ? f.FORMAL.COMMON : f.TEST.COMMON, e == g && (r = Re() ? f.FORMAL.PIC : f.TEST.PIC);
                    var i = r + "/" + I[e] + "/" + e + "/" + t + "?websdkappid=" + p + "&v=" + l + "&platform=" + d;
                    if (be()) {
                        if ("login" == t || "accesslayer" == t) i += "&identifier=" + encodeURIComponent(_e.identifier) + "&usersig=" + _e.userSig; else if (_e.tinyid && _e.a2) i += "&tinyid=" + _e.tinyid + "&a2=" + _e.a2; else if (o) return Ae.error("tinyid或a2为空[" + e + "][" + t + "]"), 
                        o(Ce.getReturnError("tinyid或a2为空[" + e + "][" + t + "]", -5)), !1;
                        i += "&contenttype=" + _e.contentType;
                    }
                    return i += "&sdkappid=" + _e.sdkAppID + "&accounttype=" + _e.accountType + "&apn=" + _e.apn + "&reqtime=" + ve();
                }(r, i, 0, a);
                0 != c && Fe("POST", c, s, 0, 0, function(e) {
                    var t = null, n = "";
                    "pic_up" == i && (s.Slice_Data = "");
                    var o = "\n request url: \n" + c + "\n request body: \n" + JSON.stringify(s) + "\n response: \n" + JSON.stringify(e);
                    e.ActionStatus == B ? (Ae.info("[" + r + "][" + i + "]success: " + o), u && u(e), 
                    t = 0, n = "") : (t = e.ErrorCode, n = e.ErrorInfo, a && (e.SrcErrorInfo = e.ErrorInfo, 
                    e.ErrorInfo = "[" + r + "][" + i + "]failed: " + o, "longpolling" == i && e.ErrorCode == me || Ae.error(e.ErrorInfo), 
                    a(e))), Ue(i, t, n);
                }, function(e) {
                    a && a(e), Ue(i, e.ErrorCode, e.ErrorInfo);
                });
            };
        }(), je = function e(t, n, o, r, i, s) {
            this._impl = {
                skey: e.skey(t, n),
                type: t,
                id: n,
                name: o,
                icon: r,
                unread: 0,
                isAutoRead: !1,
                time: 0 <= i ? i : 0,
                curMaxMsgSeq: 0 <= s ? s : 0,
                msgs: [],
                isFinished: 1
            };
        };
        je.skey = function(e, t) {
            return e + t;
        }, je.prototype.type = function() {
            return this._impl.type;
        }, je.prototype.id = function() {
            return this._impl.id;
        }, je.prototype.name = function() {
            return this._impl.name;
        }, je.prototype.icon = function() {
            return this._impl.icon;
        }, je.prototype.unread = function(e) {
            if (void 0 === e) return this._impl.unread;
            this._impl.unread = e;
        }, je.prototype.isFinished = function(e) {
            if (void 0 === e) return this._impl.isFinished;
            this._impl.isFinished = e;
        }, je.prototype.time = function() {
            return this._impl.time;
        }, je.prototype.curMaxMsgSeq = function(e) {
            if (void 0 === e) return this._impl.curMaxMsgSeq;
            this._impl.curMaxMsgSeq = e;
        }, je.prototype.msgCount = function() {
            return this._impl.msgs.length;
        }, je.prototype.msg = function(e) {
            return this._impl.msgs[e];
        }, je.prototype.msgs = function() {
            return this._impl.msgs;
        }, je.prototype._impl_addMsg = function(e, t) {
            this._impl.msgs.push(e), e.time > this._impl.time && (this._impl.time = e.time), 
            e.seq > this._impl.curMaxMsgSeq && (this._impl.curMaxMsgSeq = e.seq), e.isSend || this._impl.isAutoRead || !t || this._impl.unread++;
        };
        var Qe = function(e, t) {
            this.toAccount = e, this.lastedMsgTime = t;
        }, We = function(e, t, n, o, r, i, s, u, a) {
            this.sess = e, this.subType = 0 <= s ? s : 0, this.fromAccount = i, this.fromAccountNick = u || i, 
            this.fromAccountHeadurl = a || null, this.isSend = Boolean(t), this.seq = 0 <= n ? n : Se(), 
            this.random = 0 <= o ? o : Ge(), this.time = 0 <= r ? r : ve(), this.elems = [], 
            e.type();
        };
        We.prototype.getSession = function() {
            return this.sess;
        }, We.prototype.getType = function() {
            return this.subType;
        }, We.prototype.getSubType = function() {
            return this.subType;
        }, We.prototype.getFromAccount = function() {
            return this.fromAccount;
        }, We.prototype.getFromAccountNick = function() {
            return this.fromAccountNick;
        }, We.prototype.getIsSend = function() {
            return this.isSend;
        }, We.prototype.getSeq = function() {
            return this.seq;
        }, We.prototype.getTime = function() {
            return this.time;
        }, We.prototype.getRandom = function() {
            return this.random;
        }, We.prototype.getElems = function() {
            return this.elems;
        }, We.prototype.getMsgUniqueId = function() {
            return this.uniqueId;
        }, We.prototype.addText = function(e) {
            this.addElem(new t.Msg.Elem(K.TEXT, e));
        }, We.prototype.addFace = function(e) {
            this.addElem(new t.Msg.Elem(K.FACE, e));
        }, We.prototype.addImage = function(e) {
            this.addElem(new t.Msg.Elem(K.IMAGE, e));
        }, We.prototype.addLocation = function(e) {
            this.addElem(new t.Msg.Elem(K.LOCATION, e));
        }, We.prototype.addFile = function(e) {
            this.addElem(new t.Msg.Elem(K.FILE, e));
        }, We.prototype.addCustom = function(e) {
            this.addElem(new t.Msg.Elem(K.CUSTOM, e));
        }, We.prototype.addElem = function(e) {
            this.elems.push(e);
        }, We.prototype.toHtml = function() {
            var e = "";
            for (var t in this.elems) {
                e += this.elems[t].toHtml();
            }
            return e;
        }, (We.Elem = function(e, t) {
            this.type = e, this.content = t;
        }).prototype.getType = function() {
            return this.type;
        }, We.Elem.prototype.getContent = function() {
            return this.content;
        }, We.Elem.prototype.toHtml = function() {
            return this.content.toHtml();
        }, We.Elem.Text = function(e) {
            this.text = Ce.xssFilter(e);
        }, We.Elem.Text.prototype.getText = function() {
            return this.text;
        }, We.Elem.Text.prototype.toHtml = function() {
            return this.text;
        }, We.Elem.Face = function(e, t) {
            this.index = e, this.data = t;
        }, We.Elem.Face.prototype.getIndex = function() {
            return this.index;
        }, We.Elem.Face.prototype.getData = function() {
            return this.data;
        }, We.Elem.Face.prototype.toHtml = function() {
            var e = null, t = L[this.data], n = P[t];
            return n && n[1] && (e = n[1]), e ? "<img src='" + e + "'/>" : this.data;
        }, We.Elem.Location = function(e, t, n) {
            this.latitude = t, this.longitude = e, this.desc = n;
        }, We.Elem.Location.prototype.getLatitude = function() {
            return this.latitude;
        }, We.Elem.Location.prototype.getLongitude = function() {
            return this.longitude;
        }, We.Elem.Location.prototype.getDesc = function() {
            return this.desc;
        }, We.Elem.Location.prototype.toHtml = function() {
            return "经度=" + this.longitude + ",纬度=" + this.latitude + ",描述=" + this.desc;
        }, We.Elem.Images = function(e, t) {
            this.UUID = e, "number" != typeof t && (t = parseInt(i[t] || i.UNKNOWN, 10)), this.ImageFormat = t, 
            this.ImageInfoArray = [];
        }, We.Elem.Images.prototype.addImage = function(e) {
            this.ImageInfoArray.push(e);
        }, We.Elem.Images.prototype.toHtml = function() {
            var e = this.getImage(r.SMALL), t = this.getImage(r.LARGE), n = this.getImage(r.ORIGIN);
            return t || (t = e), n || (n = e), "<img src='" + e.getUrl() + "#" + t.getUrl() + "#" + n.getUrl() + "' style='CURSOR: hand' id='" + this.getImageId() + "' bigImgUrl='" + t.getUrl() + "' onclick='imageClick(this)' />";
        }, We.Elem.Images.prototype.getImageId = function() {
            return this.UUID;
        }, We.Elem.Images.prototype.getImageFormat = function() {
            return this.ImageFormat;
        }, We.Elem.Images.prototype.getImage = function(t) {
            for (var e in this.ImageInfoArray) if (this.ImageInfoArray[e].getType() == t) return this.ImageInfoArray[e];
            var n = null;
            return this.ImageInfoArray.forEach(function(e) {
                e.getType() == t && (n = e);
            }), n;
        }, We.Elem.Images.Image = function(e, t, n, o, r) {
            this.type = e, this.size = t, this.width = n, this.height = o, this.url = r;
        }, We.Elem.Images.Image.prototype.getType = function() {
            return this.type;
        }, We.Elem.Images.Image.prototype.getSize = function() {
            return this.size;
        }, We.Elem.Images.Image.prototype.getWidth = function() {
            return this.width;
        }, We.Elem.Images.Image.prototype.getHeight = function() {
            return this.height;
        }, We.Elem.Images.Image.prototype.getUrl = function() {
            return this.url;
        }, We.Elem.Sound = function(e, t, n, o, r, i, s) {
            var u, a, c;
            this.uuid = e, this.second = t, this.size = n, this.senderId = o, this.receiverId = r, 
            this.downFlag = i, this.busiId = s == q.C2C ? 2 : 1, void 0 !== this.downFlag && void 0 !== this.busiId ? Le(e, o, 0, i, r, this.busiId, C.SOUND) : this.downUrl = (u = e, 
            a = o, c = null, he && ye[0] ? c = "https://" + _ + "/asn.com/stddownload_common_file?authkey=" + he + "&bid=" + h + "&subbid=" + _e.sdkAppID + "&fileid=" + u + "&filetype=" + E + "&openid=" + a + "&ver=0" : Ae.error("拼接语音下载url不报错：ip或者authkey为空"), 
            c);
        }, We.Elem.Sound.prototype.getUUID = function() {
            return this.uuid;
        }, We.Elem.Sound.prototype.getSecond = function() {
            return this.second;
        }, We.Elem.Sound.prototype.getSize = function() {
            return this.size;
        }, We.Elem.Sound.prototype.getSenderId = function() {
            return this.senderId;
        }, We.Elem.Sound.prototype.getDownUrl = function() {
            return this.downUrl;
        }, We.Elem.Sound.prototype.toHtml = function() {
            return "ie" == e.type && parseInt(e.ver) <= 8 ? "[这是一条语音消息]demo暂不支持ie8(含)以下浏览器播放语音,语音URL:" + this.downUrl : '<audio id="uuid_' + this.uuid + '" src="' + this.downUrl + '" controls="controls" onplay="onChangePlayAudio(this)" preload="none"></audio>';
        }, We.Elem.File = function(e, t, n, o, r, i, s) {
            this.uuid = e, this.name = t, this.size = n, this.senderId = o, this.receiverId = r, 
            this.downFlag = i, this.busiId = s == q.C2C ? 2 : 1, void 0 !== i && void 0 !== busiId ? Le(e, o, 0, i, r, this.busiId, C.FILE) : this.downUrl = Oe(e, o, t);
        }, We.Elem.File.prototype.getUUID = function() {
            return this.uuid;
        }, We.Elem.File.prototype.getName = function() {
            return this.name;
        }, We.Elem.File.prototype.getSize = function() {
            return this.size;
        }, We.Elem.File.prototype.getSenderId = function() {
            return this.senderId;
        }, We.Elem.File.prototype.getDownUrl = function() {
            return this.downUrl;
        }, We.Elem.File.prototype.getDownFlag = function() {
            return this.downFlag;
        }, We.Elem.File.prototype.toHtml = function() {
            var e, t;
            return e = this.size, t = "Byte", 1024 <= this.size && (e = Math.round(this.size / 1024), 
            t = "KB"), {
                uuid: this.uuid,
                name: this.name,
                size: e,
                unitStr: t
            };
        }, We.Elem.GroupTip = function(e, t, n, o, r, i) {
            this.opType = e, this.opUserId = t, this.groupId = n, this.groupName = o, this.userIdList = r || [], 
            this.groupInfoList = [], this.memberInfoList = [], this.groupMemberNum = null, this.userinfo = i || [];
        }, We.Elem.GroupTip.prototype.addGroupInfo = function(e) {
            this.groupInfoList.push(e);
        }, We.Elem.GroupTip.prototype.addMemberInfo = function(e) {
            this.memberInfoList.push(e);
        }, We.Elem.GroupTip.prototype.getOpType = function() {
            return this.opType;
        }, We.Elem.GroupTip.prototype.getOpUserId = function() {
            return this.opUserId;
        }, We.Elem.GroupTip.prototype.getGroupId = function() {
            return this.groupId;
        }, We.Elem.GroupTip.prototype.getGroupName = function() {
            return this.groupName;
        }, We.Elem.GroupTip.prototype.getUserIdList = function() {
            return this.userIdList;
        }, We.Elem.GroupTip.prototype.getUserInfo = function() {
            return this.userinfo;
        }, We.Elem.GroupTip.prototype.getGroupInfoList = function() {
            return this.groupInfoList;
        }, We.Elem.GroupTip.prototype.getMemberInfoList = function() {
            return this.memberInfoList;
        }, We.Elem.GroupTip.prototype.getGroupMemberNum = function() {
            return this.groupMemberNum;
        }, We.Elem.GroupTip.prototype.setGroupMemberNum = function(e) {
            return this.groupMemberNum = e;
        }, We.Elem.GroupTip.prototype.toHtml = function() {
            var e = "[群提示消息]";
            switch (this.opType) {
              case re.JOIN:
                for (var t in e += this.opUserId + "邀请了", this.userIdList) if (e += this.userIdList[t] + ",", 
                10 < this.userIdList.length && 9 == t) {
                    e += "等" + this.userIdList.length + "人";
                    break;
                }
                e += "加入该群";
                break;

              case re.QUIT:
                e += this.opUserId + "主动退出该群";
                break;

              case re.KICK:
                for (var t in e += this.opUserId + "将", this.userIdList) if (e += this.userIdList[t] + ",", 
                10 < this.userIdList.length && 9 == t) {
                    e += "等" + this.userIdList.length + "人";
                    break;
                }
                e += "踢出该群";
                break;

              case re.SET_ADMIN:
                for (var t in e += this.opUserId + "将", this.userIdList) if (e += this.userIdList[t] + ",", 
                10 < this.userIdList.length && 9 == t) {
                    e += "等" + this.userIdList.length + "人";
                    break;
                }
                e += "设为管理员";
                break;

              case re.CANCEL_ADMIN:
                for (var t in e += this.opUserId + "取消", this.userIdList) if (e += this.userIdList[t] + ",", 
                10 < this.userIdList.length && 9 == t) {
                    e += "等" + this.userIdList.length + "人";
                    break;
                }
                e += "的管理员资格";
                break;

              case re.MODIFY_GROUP_INFO:
                for (var t in e += this.opUserId + "修改了群资料：", this.groupInfoList) {
                    var n = this.groupInfoList[t].getType(), o = this.groupInfoList[t].getValue();
                    switch (n) {
                      case ie.FACE_URL:
                        e += "群头像为" + o + "; ";
                        break;

                      case ie.NAME:
                        e += "群名称为" + o + "; ";
                        break;

                      case ie.OWNER:
                        e += "群主为" + o + "; ";
                        break;

                      case ie.NOTIFICATION:
                        e += "群公告为" + o + "; ";
                        break;

                      case ie.INTRODUCTION:
                        e += "群简介为" + o + "; ";
                        break;

                      default:
                        e += "未知信息为:type=" + n + ",value=" + o + "; ";
                    }
                }
                break;

              case re.MODIFY_MEMBER_INFO:
                for (var t in e += this.opUserId + "修改了群成员资料:", this.memberInfoList) {
                    var r = this.memberInfoList[t].getUserId(), i = this.memberInfoList[t].getShutupTime();
                    if (e += r + ": ", e += null != i && void 0 !== i ? 0 == i ? "取消禁言; " : "禁言" + i + "秒; " : " shutupTime为空", 
                    10 < this.memberInfoList.length && 9 == t) {
                        e += "等" + this.memberInfoList.length + "人";
                        break;
                    }
                }
                break;

              case re.READED:
                Log.info("消息已读同步");
                break;

              default:
                e += "未知群提示消息类型：type=" + this.opType;
            }
            return e;
        }, We.Elem.GroupTip.GroupInfo = function(e, t) {
            this.type = e, this.value = t;
        }, We.Elem.GroupTip.GroupInfo.prototype.getType = function() {
            return this.type;
        }, We.Elem.GroupTip.GroupInfo.prototype.getValue = function() {
            return this.value;
        }, We.Elem.GroupTip.MemberInfo = function(e, t) {
            this.userId = e, this.shutupTime = t;
        }, We.Elem.GroupTip.MemberInfo.prototype.getUserId = function() {
            return this.userId;
        }, We.Elem.GroupTip.MemberInfo.prototype.getShutupTime = function() {
            return this.shutupTime;
        }, We.Elem.Custom = function(e, t, n) {
            this.data = e, this.desc = t, this.ext = n;
        }, We.Elem.Custom.prototype.getData = function() {
            return this.data;
        }, We.Elem.Custom.prototype.getDesc = function() {
            return this.desc;
        }, We.Elem.Custom.prototype.getExt = function() {
            return this.ext;
        }, We.Elem.Custom.prototype.toHtml = function() {
            return this.data;
        };
        var $e = new function() {
            var u = {}, e = [];
            tt = {}, this.cookie = "", this.syncFlag = 0;
            var i = function(e) {
                for (var t in u) e(u[t]);
            };
            this.sessMap = function() {
                return u;
            }, this.sessCount = function() {
                return e.length;
            }, this.sessByTypeId = function(e, t) {
                var n = je.skey(e, t);
                return void 0 === n || null == n ? null : u[n];
            }, this.delSessByTypeId = function(e, t) {
                var n = je.skey(e, t);
                return void 0 !== n && null != n && (u[n] && (delete u[n], delete tt[n]), !0);
            }, this.resetCookieAndSyncFlag = function() {
                this.cookie = "", this.syncFlag = 0;
            }, this.setAutoRead = function(e, t, n) {
                if (n && i(function(e) {
                    e._impl.isAutoRead = !1;
                }), e && (e._impl.isAutoRead = t)) if (e._impl.unread = 0, e._impl.type == q.C2C) {
                    var o = [];
                    o.push(new Qe(e._impl.id, e._impl.time)), qe($e.cookie, o, function(e) {
                        Ae.info("[setAutoRead]: c2CMsgReaded success");
                    }, function(e) {
                        Ae.error("[setAutoRead}: c2CMsgReaded failed:" + e.ErrorInfo);
                    });
                } else if (e._impl.type == q.GROUP) {
                    var r = {
                        GroupId: e._impl.id,
                        MsgReadedSeq: e._impl.curMaxMsgSeq
                    };
                    xe(r, function(e) {
                        Ae.info("groupMsgReaded success");
                    }, function(e) {
                        Ae.error("groupMsgReaded failed:" + e.ErrorInfo);
                    });
                }
            }, this.c2CMsgReaded = function(e, t, n) {
                var o = [];
                o.push(new Qe(e.To_Account, e.LastedMsgTime)), qe($e.cookie, o, function(e) {
                    t && (Ae.info("c2CMsgReaded success"), t(e));
                }, function(e) {
                    n && (Ae.error("c2CMsgReaded failed:" + e.ErrorInfo), n(e));
                });
            }, this.addSession = function(e) {
                u[e._impl.skey] = e;
            }, this.delSession = function(e) {
                delete u[e._impl.skey];
            }, this.clear = function() {
                u = {}, e = [], tt = {}, this.cookie = "", this.syncFlag = 0;
            }, this.addMsg = function(e, t) {
                if (o = !1, r = (n = e).sess._impl.skey, i = n.isSend + n.seq + n.random, tt[r] && tt[r][i] && (o = !0), 
                tt[r] || (tt[r] = {}), tt[r][i] = {
                    time: n.time
                }, o) return !1;
                var n, o, r, i, s = e.sess;
                return u[s._impl.skey] || this.addSession(s), s._impl_addMsg(e, t), !0;
            }, this.updateTimeline = function() {
                var t = new Array();
                i(function(e) {
                    t.push(e);
                }), t.sort(function(e, t) {
                    return t.time - e.time;
                }), e = t;
            };
        }(), Ze = new function() {
            var y = null, R = null, d = {
                1: null,
                2: null,
                3: null,
                4: null,
                5: null,
                6: null,
                7: null,
                8: null,
                9: null,
                10: null,
                11: null,
                15: null,
                255: null,
                12: null
            }, s = {
                1: null,
                2: null,
                3: null,
                4: null,
                5: null,
                6: null,
                7: null,
                8: null
            }, u = {
                1: null
            }, l = null, a = !1, i = 0, f = 0, p = null, g = !1, m = {}, I = 90, M = null, h = {}, c = {
                92: null,
                96: null
            }, _ = {}, E = {};
            this.setLongPollingOn = function(e) {
                a = e;
            }, this.getLongPollingOn = function() {
                return a;
            }, this.resetLongPollingInfo = function() {
                a = !1, f = i = 0;
            }, this.setBigGroupLongPollingOn = function(e) {
                g = e;
            }, this.checkBigGroupLongPollingOn = function(e) {
                return !!M[e];
            }, this.setBigGroupLongPollingKey = function(e, t) {
                M[e] = t;
            }, this.resetBigGroupLongPollingInfo = function(e) {
                g = !1, m[e] = 0, M[e] = null, h[e] = {};
            }, this.setBigGroupLongPollingMsgMap = function(e, t) {
                var n = h[e];
                n ? (n = parseInt(n) + t, h[e] = n) : h[e] = t;
            }, this.clear = function() {
                d = {
                    1: R = null,
                    2: null,
                    3: null,
                    4: null,
                    5: null,
                    6: null,
                    7: null,
                    8: null,
                    9: null,
                    10: null,
                    11: null,
                    15: null,
                    255: null,
                    12: null
                }, s = {
                    1: null,
                    2: null,
                    3: null,
                    4: null,
                    5: null,
                    6: null,
                    7: null,
                    8: null
                }, f = i = 0, g = a = !(u = {
                    1: null
                }), m = {}, M = {}, h = {}, E = {}, ye = [], he = p = y = null;
            };
            var T = function(t, n) {
                var e, o;
                e = function(e) {
                    ye = e.IpList, he = e.AuthKey, e.ExpireTime, t && t(e);
                }, Ne(o = function(e) {
                    Ae.error("initIpAndAuthkey failed:" + e.ErrorInfo), n && n(e);
                }, !0) && Xe.apiCall(D, "authkey", {}, e, o);
            }, C = function(e, t) {
                for (var n in e) {
                    var o = e[n];
                    if (o.From_Account) {
                        var r = P(o, !1, !0);
                        r && t.push(r), i = o.ToGroupId, s = o.MsgSeq, void 0, (u = _[i]) ? u < s && (_[i] = s) : _[i] = s;
                    }
                }
                var i, s, u;
                return t;
            }, A = function(e, t) {
                var n = {}, o = [];
                for (var r in t) {
                    var i = n[t[r].ToGroupId];
                    i || (i = n[t[r].ToGroupId] = {
                        min: 99999999,
                        max: -1,
                        msgs: []
                    }), t[r].NoticeSeq > f && (Ae.warn("noticeSeq=" + f + ",msgNoticeSeq=" + t[r].NoticeSeq), 
                    f = t[r].NoticeSeq), t[r].Event = e, n[t[r].ToGroupId].msgs.push(t[r]), t[r].MsgSeq < i.min && (n[t[r].ToGroupId].min = t[r].MsgSeq), 
                    t[r].MsgSeq > i.max && (n[t[r].ToGroupId].max = t[r].MsgSeq);
                }
                for (var s in n) o = C(n[s].msgs, o);
                o.length && $e.updateTimeline(), y && o.length && y(o);
            }, v = function(e, t) {
                var n = {}, o = [];
                for (var r in t) {
                    var i = n[t[r].ToGroupId];
                    i || (i = n[t[r].ToGroupId] = {
                        min: 99999999,
                        max: -1,
                        msgs: []
                    }), t[r].NoticeSeq > f && (Ae.warn("noticeSeq=" + f + ",msgNoticeSeq=" + t[r].NoticeSeq), 
                    f = t[r].NoticeSeq), t[r].Event = e, n[t[r].ToGroupId].msgs.push(t[r]), t[r].MsgSeq < i.min && (n[t[r].ToGroupId].min = t[r].MsgSeq), 
                    t[r].MsgSeq > i.max && (n[t[r].ToGroupId].max = t[r].MsgSeq);
                }
                for (var s in n) o = C(n[s].msgs, o);
                o.length && $e.updateTimeline(), y && o.length && y(o);
            }, S = function(e, t) {
                for (var n in e) {
                    var o = e[n], r = o.MsgBody, i = r.ReportType;
                    0 == t && o.NoticeSeq && o.NoticeSeq > f && (f = o.NoticeSeq);
                    o.GroupInfo.To_Account;
                    if (t) {
                        var s = o.ToGroupId + "_" + i + "_" + r.Operator_Account;
                        if (E[s]) {
                            Ae.warn("收到重复的群系统消息：key=" + s);
                            continue;
                        }
                        E[s] = !0;
                    }
                    var u = {
                        SrcFlag: 0,
                        ReportType: i,
                        GroupId: o.ToGroupId,
                        GroupName: o.GroupInfo.GroupName,
                        Operator_Account: r.Operator_Account,
                        MsgTime: o.MsgTimeStamp,
                        groupReportTypeMsg: r
                    };
                    switch (i) {
                      case se.JOIN_GROUP_REQUEST:
                        u.RemarkInfo = r.RemarkInfo, u.MsgKey = r.MsgKey, u.Authentication = r.Authentication, 
                        u.UserDefinedField = o.UserDefinedField, u.From_Account = o.From_Account, u.MsgSeq = o.ClientSeq, 
                        u.MsgRandom = o.MsgRandom;
                        break;

                      case se.JOIN_GROUP_ACCEPT:
                      case se.JOIN_GROUP_REFUSE:
                        u.RemarkInfo = r.RemarkInfo;
                        break;

                      case se.KICK:
                      case se.DESTORY:
                      case se.CREATE:
                      case se.INVITED_JOIN_GROUP_REQUEST:
                      case se.INVITED_JOIN_GROUP_REQUEST_AGREE:
                      case se.QUIT:
                      case se.SET_ADMIN:
                      case se.CANCEL_ADMIN:
                      case se.REVOKE:
                      case se.READED:
                        break;

                      case se.CUSTOM:
                        u.MsgSeq = o.MsgSeq, u.UserDefinedField = r.UserDefinedField;
                        break;

                      default:
                        Ae.error("未知群系统消息类型：reportType=" + i);
                    }
                    if (t) d[i] ? d[i](u) : Ae.error("未知群系统消息类型：reportType=" + i); else if (d[i]) if (i == se.READED) for (var a = u.groupReportTypeMsg.GroupReadInfoArray, c = 0, l = a.length; c < l; c++) {
                        var p = a[c];
                        d[i](p);
                    } else d[i](u);
                }
            }, G = function(e, t) {
                var n, o, r;
                for (var i in e) {
                    switch (o = (n = e[i]).PushType, 0 == t && n.NoticeSeq && n.NoticeSeq > f && (f = n.NoticeSeq), 
                    r = {
                        Type: o
                    }, o) {
                      case ue.FRIEND_ADD:
                        r.Accounts = n.FriendAdd_Account;
                        break;

                      case ue.FRIEND_DELETE:
                        r.Accounts = n.FriendDel_Account;
                        break;

                      case ue.PENDENCY_ADD:
                        r.PendencyList = n.PendencyAdd;
                        break;

                      case ue.PENDENCY_DELETE:
                        r.Accounts = n.FrienPencydDel_Account;
                        break;

                      case ue.BLACK_LIST_ADD:
                        r.Accounts = n.BlackListAdd_Account;
                        break;

                      case ue.BLACK_LIST_DELETE:
                        r.Accounts = n.BlackListDel_Account;
                        break;

                      default:
                        Ae.error("未知好友系统通知类型：friendNotice=" + JSON.stringify(n));
                    }
                    t ? o == ue.PENDENCY_ADD && s[o] && s[o](r) : s[o] && s[o](r);
                }
            }, F = function(e, t) {
                var n, o, r;
                for (var i in e) {
                    switch (o = (n = e[i]).PushType, 0 == t && n.NoticeSeq && n.NoticeSeq > f && (f = n.NoticeSeq), 
                    r = {
                        Type: o
                    }, o) {
                      case ae:
                        r.Profile_Account = n.Profile_Account, r.ProfileList = n.ProfileList;
                        break;

                      default:
                        Ae.error("未知资料系统通知类型：profileNotice=" + JSON.stringify(n));
                    }
                    t ? o == ae && u[o] && u[o](r) : u[o] && u[o](r);
                }
            }, b = function(e) {
                var t = e.MsgBody, n = t.ReportType, o = (e.GroupInfo.To_Account, {
                    SrcFlag: 1,
                    ReportType: n,
                    GroupId: e.ToGroupId,
                    GroupName: e.GroupInfo.GroupName,
                    Operator_Account: t.Operator_Account,
                    MsgTime: e.MsgTimeStamp
                });
                switch (n) {
                  case se.JOIN_GROUP_REQUEST:
                    o.RemarkInfo = t.RemarkInfo, o.MsgKey = t.MsgKey, o.Authentication = t.Authentication, 
                    o.UserDefinedField = e.UserDefinedField, o.From_Account = e.From_Account, o.MsgSeq = e.ClientSeq, 
                    o.MsgRandom = e.MsgRandom;
                    break;

                  case se.JOIN_GROUP_ACCEPT:
                  case se.JOIN_GROUP_REFUSE:
                    o.RemarkInfo = t.RemarkInfo;
                    break;

                  case se.KICK:
                  case se.DESTORY:
                  case se.CREATE:
                  case se.INVITED_JOIN_GROUP_REQUEST:
                  case se.INVITED_JOIN_GROUP_REQUEST_AGREE:
                  case se.QUIT:
                  case se.SET_ADMIN:
                  case se.CANCEL_ADMIN:
                  case se.REVOKE:
                    break;

                  case se.CUSTOM:
                    o.MsgSeq = e.MsgSeq, o.UserDefinedField = t.UserDefinedField;
                    break;

                  default:
                    Ae.error("未知群系统消息类型：reportType=" + n);
                }
                d[n] && d[n](o);
            }, N = function(e) {
                for (var t = 0, n = e.length; t < n; t++) o(e[t]);
            }, o = function(e) {
                var t = e.SubMsgType;
                switch (t) {
                  case Z:
                    if (Ae.warn("C2C已读消息通知"), e.ReadC2cMsgNotify && e.ReadC2cMsgNotify.UinPairReadArray && c[t]) for (var n = 0, o = e.ReadC2cMsgNotify.UinPairReadArray.length; n < o; n++) {
                        var r = e.ReadC2cMsgNotify.UinPairReadArray[n];
                        c[t](r);
                    }
                    break;

                  case ee:
                    Ae.warn("多终端互踢通知"), we("instance"), c[t] && c[t]();
                    break;

                  default:
                    Ae.error("未知C2c系统消息：subType=" + t);
                }
            };
            this.longPolling = function(e, o) {
                var r = {
                    Timeout: ge / 1e3,
                    Cookie: {
                        NotifySeq: i,
                        NoticeSeq: f
                    }
                };
                function t() {
                    var e, t, n;
                    e = r, t = function(e) {
                        for (var t in e.EventArray) {
                            var n = e.EventArray[t];
                            switch (n.Event) {
                              case z:
                                i = n.NotifySeq, Ae.warn("longpolling: received new c2c msg"), Ze.syncMsgs();
                                break;

                              case H:
                                Ae.warn("longpolling: received new group msgs"), v(n.Event, n.GroupMsgArray);
                                break;

                              case J:
                              case V:
                                Ae.warn("longpolling: received new group tips"), v(n.Event, n.GroupTips);
                                break;

                              case Y:
                                Ae.warn("longpolling: received new group system msgs"), S(n.GroupTips, !1);
                                break;

                              case X:
                                Ae.warn("longpolling: received new friend system notice"), G(n.FriendListMod, !1);
                                break;

                              case j:
                                Ae.warn("longpolling: received new profile system notice"), F(n.ProfileDataMod, !1);
                                break;

                              case Q:
                                f = n.C2cMsgArray[0].NoticeSeq, Ae.warn("longpolling: received new c2c_common msg", f), 
                                A(n.Event, n.C2cMsgArray);
                                break;

                              case W:
                                f = n.C2cNotifyMsgArray[0].NoticeSeq, Ae.warn("longpolling: received new c2c_event msg"), 
                                N(n.C2cNotifyMsgArray);
                                break;

                              default:
                                Ae.error("longpolling收到未知新消息类型: Event=" + n.Event);
                            }
                        }
                        O({
                            ActionStatus: B,
                            ErrorCode: 0
                        });
                    }, n = function(e) {
                        O(e), o && o(e);
                    }, (U || "undefined" == typeof stopPolling || 1 != stopPolling) && Ne(n, !0) && Xe.apiCall(D, "longpolling", e, t, n, ge, !0);
                }
                Ie ? (r.Cookie.LongPollingId = Ie, t()) : Ye(0, function(e) {
                    Ie = r.Cookie.LongPollingId = e.LongPollingId, ge = 60 < e.Timeout ? ge : 1e3 * e.Timeout, 
                    t();
                });
            }, this.bigGroupLongPolling = function(a, c, n) {
                var e, t, o, r, i = {
                    USP: 1,
                    StartSeq: m[a],
                    HoldTime: I,
                    Key: M[a]
                };
                e = i, t = function(e) {
                    var t = [];
                    if (m[a] = e.NextSeq, I = e.HoldTime, M[a] = e.Key, e.RspMsgList && 0 < e.RspMsgList.length) {
                        for (var n, o, r, i = 0, s = e.RspMsgList.length - 1; 0 <= s; s--) {
                            n = e.RspMsgList[s];
                            if (!(n = Ce.replaceObject({
                                F_Account: "From_Account",
                                T_Account: "To_Account",
                                FAType: "EnumFrom_AccountType",
                                TAType: "EnumTo_AccountType",
                                GCode: "GroupCode",
                                GName: "GroupName",
                                GId: "GroupId",
                                MFlg: "MsgFlag",
                                FAEInfo: "MsgFrom_AccountExtraInfo",
                                Evt: "Event",
                                GInfo: "GroupInfo",
                                BPlc: "IsPlaceMsg",
                                MBody: "MsgBody",
                                Pri: "MsgPriority",
                                Rdm: "MsgRandom",
                                MSeq: "MsgSeq",
                                TStp: "MsgTimeStamp",
                                TGId: "ToGroupId",
                                UEInfo: "UinExtInfo",
                                UId: "UserId",
                                BSys: "IsSystemMsg",
                                FAHUrl: "From_AccountHeadurl",
                                FANick: "From_AccountNick"
                            }, n)).IsPlaceMsg && n.From_Account && n.MsgBody && 0 != n.MsgBody.length) switch (o = n.Event) {
                              case H:
                                Ae.info("bigGroupLongPolling: return new group msg"), (r = P(n, !1, !1)) && t.push(r), 
                                i += 1;
                                break;

                              case J:
                              case V:
                                Ae.info("bigGroupLongPolling: return new group tip"), (r = P(n, !1, !1)) && t.push(r);
                                break;

                              case Y:
                                Ae.info("bigGroupLongPolling: new group system msg"), b(n);
                                break;

                              default:
                                Ae.error("bigGroupLongPolling收到未知新消息类型: Event=" + o);
                            }
                        }
                        0 < i && (Ze.setBigGroupLongPollingMsgMap(n.ToGroupId, i), Ae.warn("current bigGroupLongPollingMsgMap: " + JSON.stringify(h)));
                    }
                    Me = 0;
                    var u = {
                        ActionStatus: B,
                        ErrorCode: ce.ON,
                        ErrorInfo: "connection is ok..."
                    };
                    Xe.callBack(u), c ? c(t) : p && p(t), g && Ze.bigGroupLongPolling(a);
                }, o = function(e) {
                    if (10018 == e.ErrorCode ? m[a] = 0 : e.ErrorCode != me && (Ae.error(e.ErrorInfo), 
                    Me++), 91101 == e.ErrorCode && (Ae.error("多实例登录，被kick"), l && l()), Me < 10) g && Ze.bigGroupLongPolling(a); else {
                        var t = {
                            ActionStatus: x,
                            ErrorCode: ce.OFF,
                            ErrorInfo: "connection is off"
                        };
                        Xe.callBack(t);
                    }
                    n && n(e);
                }, r = 1e3 * I, Xe.apiCall(w, "get_msg", e, t, o, r);
            };
            var O = function(e) {
                if (0 == e.ErrorCode || e.ErrorCode == me) {
                    var t;
                    fe = 0;
                    var n = de = !1;
                    switch (pe) {
                      case ce.INIT:
                        n = !0, pe = ce.ON, t = "create connection successfully(INIT->ON)";
                        break;

                      case ce.ON:
                        t = "connection is on...(ON->ON)";
                        break;

                      case ce.RECONNECT:
                        pe = ce.ON, t = "connection is on...(RECONNECT->ON)";
                        break;

                      case ce.OFF:
                        n = !0, pe = ce.RECONNECT, t = "reconnect successfully(OFF->RECONNECT)";
                    }
                    var o = {
                        ActionStatus: B,
                        ErrorCode: pe,
                        ErrorInfo: t
                    };
                    n && Xe.callBack(o), a && Ze.longPolling();
                } else if (91101 == e.ErrorCode) Ae.error("多实例登录，被kick"), l && l(); else if (fe++, 
                Ae.warn("longPolling接口第" + fe + "次报错: " + e.ErrorInfo), fe <= 10) setTimeout(L, 100); else {
                    var r = {
                        ActionStatus: x,
                        ErrorCode: pe = ce.OFF,
                        ErrorInfo: "connection is off"
                    };
                    0 == de && Xe.callBack(r), de = !0, Ae.warn("5000毫秒之后,SDK会发起新的longPolling请求..."), 
                    setTimeout(L, 5e3);
                }
            }, L = (A = function(e, t) {
                var n, o = [];
                for (var r in n = t) {
                    var i, s, u = n[r], a = u.From_AccountHeadurl || "";
                    u.From_Account == _e.identifier ? (i = !0, s = u.To_Account) : (i = !1, s = u.From_Account);
                    var c = $e.sessByTypeId(q.C2C, s);
                    c || (c = new je(q.C2C, s, s, a, 0, 0));
                    var l = new We(c, i, u.MsgSeq, u.MsgRandom, u.MsgTimeStamp, u.From_Account, $.COMMON, u.From_AccountNick, a), p = null, d = null, f = null;
                    for (var g in u.MsgBody) {
                        switch (f = (p = u.MsgBody[g]).MsgType) {
                          case K.TEXT:
                            d = new We.Elem.Text(p.MsgContent.Text);
                            break;

                          case K.FACE:
                            d = new We.Elem.Face(p.MsgContent.Index, p.MsgContent.Data);
                            break;

                          case K.IMAGE:
                            for (var m in d = new We.Elem.Images(p.MsgContent.UUID, p.MsgContent.ImageFormat || ""), 
                            p.MsgContent.ImageInfoArray) {
                                var I = p.MsgContent.ImageInfoArray[m];
                                d.addImage(new We.Elem.Images.Image(I.Type, I.Size, I.Width, I.Height, I.URL));
                            }
                            break;

                          case K.SOUND:
                            p.MsgContent ? d = new We.Elem.Sound(p.MsgContent.UUID, p.MsgContent.Second, p.MsgContent.Size, u.From_Account, u.To_Account, p.MsgContent.Download_Flag, q.C2C) : (f = K.TEXT, 
                            d = new We.Elem.Text("[语音消息]下载地址解析出错"));
                            break;

                          case K.LOCATION:
                            d = new We.Elem.Location(p.MsgContent.Longitude, p.MsgContent.Latitude, p.MsgContent.Desc);
                            break;

                          case K.FILE:
                          case K.FILE + " ":
                            f = K.FILE, p.MsgContent ? d = new We.Elem.File(p.MsgContent.UUID, p.MsgContent.FileName, p.MsgContent.FileSize, u.From_Account, u.To_Account, p.MsgContent.Download_Flag, q.C2C) : (f = K.TEXT, 
                            d = new We.Elem.Text("[文件消息下载地址解析出错]"));
                            break;

                          case K.CUSTOM:
                            try {
                                var M = JSON.parse(p.MsgContent.Data);
                                if (M && M.userAction && M.userAction == le) continue;
                            } catch (e) {}
                            f = K.CUSTOM, d = new We.Elem.Custom(p.MsgContent.Data, p.MsgContent.Desc, p.MsgContent.Ext);
                            break;

                          default:
                            f = K.TEXT, d = new We.Elem.Text("web端暂不支持" + p.MsgType + "消息");
                        }
                        l.elems.push(new We.Elem(f, d));
                    }
                    0 < l.elems.length && $e.addMsg(l, !0) && o.push(l);
                }
                0 < o.length && $e.updateTimeline(), 0 < o.length && y && y(o);
            }, function() {
                a && Ze.longPolling();
            });
            this.syncMsgs = function(m, t) {
                var I = [], M = [];
                !function n(e, t, o, r) {
                    Ne(r, !0) && Xe.apiCall(D, "getmsg", {
                        Cookie: e,
                        SyncFlag: t
                    }, function(e) {
                        if (e.MsgList && e.MsgList.length) for (var t in e.MsgList) Ee.push(e.MsgList[t]);
                        1 == e.SyncFlag ? n(e.Cookie, e.SyncFlag, o, r) : (e.MsgList = Ee, Ee = [], o && o(e));
                    }, r);
                }($e.cookie, $e.syncFlag, function(e) {
                    for (var t in 2 == e.SyncFlag && ($e.syncFlag = 0), M = e.MsgList, $e.cookie = e.Cookie, 
                    M) {
                        var n, o, r, i = M[t];
                        i.From_Account == _e.identifier ? (n = !0, o = i.To_Account) : (n = !1, o = i.From_Account), 
                        r = "";
                        var s = $e.sessByTypeId(q.C2C, o);
                        s || (s = new je(q.C2C, o, o, r, 0, 0));
                        var u = new We(s, n, i.MsgSeq, i.MsgRandom, i.MsgTimeStamp, i.From_Account, $.COMMON, i.From_AccountNick, i.From_AccountHeadurl), a = null, c = null, l = null;
                        for (var p in i.MsgBody) {
                            switch (l = (a = i.MsgBody[p]).MsgType) {
                              case K.TEXT:
                                c = new We.Elem.Text(a.MsgContent.Text);
                                break;

                              case K.FACE:
                                c = new We.Elem.Face(a.MsgContent.Index, a.MsgContent.Data);
                                break;

                              case K.IMAGE:
                                for (var d in c = new We.Elem.Images(a.MsgContent.UUID, a.MsgContent.ImageFormat), 
                                a.MsgContent.ImageInfoArray) {
                                    var f = a.MsgContent.ImageInfoArray[d];
                                    c.addImage(new We.Elem.Images.Image(f.Type, f.Size, f.Width, f.Height, f.URL));
                                }
                                break;

                              case K.SOUND:
                                a.MsgContent ? c = new We.Elem.Sound(a.MsgContent.UUID, a.MsgContent.Second, a.MsgContent.Size, i.From_Account, i.To_Account, a.MsgContent.Download_Flag, q.C2C) : (l = K.TEXT, 
                                c = new We.Elem.Text("[语音消息]下载地址解析出错"));
                                break;

                              case K.LOCATION:
                                c = new We.Elem.Location(a.MsgContent.Longitude, a.MsgContent.Latitude, a.MsgContent.Desc);
                                break;

                              case K.FILE:
                              case K.FILE + " ":
                                l = K.FILE, a.MsgContent ? c = new We.Elem.File(a.MsgContent.UUID, a.MsgContent.FileName, a.MsgContent.FileSize, i.From_Account, i.To_Account, a.MsgContent.Download_Flag, q.C2C) : (l = K.TEXT, 
                                c = new We.Elem.Text("[文件消息下载地址解析出错]"));
                                break;

                              case K.CUSTOM:
                                try {
                                    var g = JSON.parse(a.MsgContent.Data);
                                    if (g && g.userAction && g.userAction == le) continue;
                                } catch (e) {}
                                l = K.CUSTOM, c = new We.Elem.Custom(a.MsgContent.Data, a.MsgContent.Desc, a.MsgContent.Ext);
                                break;

                              default:
                                l = K.TEXT, c = new We.Elem.Text("web端暂不支持" + a.MsgType + "消息");
                            }
                            u.elems.push(new We.Elem(l, c));
                        }
                        0 < u.elems.length && $e.addMsg(u, !0) && I.push(u);
                    }
                    !function(e) {
                        for (var t in e) {
                            var n = e[t];
                            switch (S(n.GroupTips, !0), n.Event) {
                              case Y:
                                Ae.warn("handlerApplyJoinGroupSystemMsgs： handler new group system msg"), S(n.GroupTips, !0);
                                break;

                              default:
                                Ae.error("syncMsgs收到未知的群系统消息类型: Event=" + n.Event);
                            }
                        }
                    }(e.EventArray), 0 < I.length && $e.updateTimeline(), m ? m(I) : 0 < I.length && y && y(I);
                }, function(e) {
                    Ae.error("getMsgs failed:" + e.ErrorInfo), t && t(e);
                });
            }, this.getC2CHistoryMsgs = function(I, M, t) {
                if (I.Peer_Account || !t) if (I.MaxCnt || (I.MaxCnt = 15), I.MaxCnt <= 0 && t) t(Ce.getReturnError("MaxCnt should be greater than 0", -14)); else {
                    if (15 < I.MaxCnt) return t ? void t(Ce.getReturnError("MaxCnt can not be greater than 15", -15)) : void 0;
                    null != I.MsgKey && void 0 !== I.MsgKey || (I.MsgKey = ""), function a(c, l, p) {
                        Ne(p, !0) && Xe.apiCall(D, "getroammsg", c, function(e) {
                            var t = c.MaxCnt, n = e.Complete, o = e.MaxCnt, r = e.MsgKey, i = e.LastMsgTime;
                            if (e.MsgList && e.MsgList.length) for (var s in e.MsgList) Te.push(e.MsgList[s]);
                            var u = null;
                            0 == n && o < t && (u = {
                                Peer_Account: c.Peer_Account,
                                MaxCnt: t - o,
                                LastMsgTime: i,
                                MsgKey: r
                            }), u ? a(u, l, p) : (e.MsgList = Te, Te = [], l && l(e));
                        }, p);
                    }({
                        Peer_Account: I.Peer_Account,
                        MaxCnt: I.MaxCnt,
                        LastMsgTime: I.LastMsgTime,
                        MsgKey: I.MsgKey
                    }, function(e) {
                        var t, n = [];
                        t = e.MsgList;
                        var o = $e.sessByTypeId(q.C2C, I.Peer_Account);
                        for (var r in o || (o = new je(q.C2C, I.Peer_Account, I.Peer_Account, "", 0, 0)), 
                        t) {
                            var i, s = t[r], u = s.From_AccountHeadurl || "";
                            s.From_Account == _e.identifier ? (i = !0, s.To_Account) : (i = !1, s.From_Account);
                            var a = new We(o, i, s.MsgSeq, s.MsgRandom, s.MsgTimeStamp, s.From_Account, $.COMMON, s.From_AccountNick, u), c = null, l = null, p = null;
                            for (var d in s.MsgBody) {
                                switch (p = (c = s.MsgBody[d]).MsgType) {
                                  case K.TEXT:
                                    l = new We.Elem.Text(c.MsgContent.Text);
                                    break;

                                  case K.FACE:
                                    l = new We.Elem.Face(c.MsgContent.Index, c.MsgContent.Data);
                                    break;

                                  case K.IMAGE:
                                    for (var f in l = new We.Elem.Images(c.MsgContent.UUID, c.MsgContent.ImageFormat), 
                                    c.MsgContent.ImageInfoArray) {
                                        var g = c.MsgContent.ImageInfoArray[f];
                                        l.addImage(new We.Elem.Images.Image(g.Type, g.Size, g.Width, g.Height, g.URL));
                                    }
                                    break;

                                  case K.SOUND:
                                    c.MsgContent ? l = new We.Elem.Sound(c.MsgContent.UUID, c.MsgContent.Second, c.MsgContent.Size, s.From_Account, s.To_Account, c.MsgContent.Download_Flag, q.C2C) : (p = K.TEXT, 
                                    l = new We.Elem.Text("[语音消息]下载地址解析出错"));
                                    break;

                                  case K.LOCATION:
                                    l = new We.Elem.Location(c.MsgContent.Longitude, c.MsgContent.Latitude, c.MsgContent.Desc);
                                    break;

                                  case K.FILE:
                                  case K.FILE + " ":
                                    p = K.FILE, c.MsgContent ? l = new We.Elem.File(c.MsgContent.UUID, c.MsgContent.FileName, c.MsgContent.FileSize, s.From_Account, s.To_Account, c.MsgContent.Download_Flag, q.C2C) : (p = K.TEXT, 
                                    l = new We.Elem.Text("[文件消息下载地址解析出错]"));
                                    break;

                                  case K.CUSTOM:
                                    p = K.CUSTOM, l = new We.Elem.Custom(c.MsgContent.Data, c.MsgContent.Desc, c.MsgContent.Ext);
                                    break;

                                  default:
                                    p = K.TEXT, l = new We.Elem.Text("web端暂不支持" + c.MsgType + "消息");
                                }
                                a.elems.push(new We.Elem(p, l));
                            }
                            $e.addMsg(a), n.push(a);
                        }
                        if ($e.updateTimeline(), M) {
                            var m = {
                                Complete: e.Complete,
                                MsgCount: n.length,
                                LastMsgTime: e.LastMsgTime,
                                MsgKey: e.MsgKey,
                                MsgList: n
                            };
                            o.isFinished(e.Complete), M(m);
                        }
                    }, function(e) {
                        Ae.error("getC2CHistoryMsgs failed:" + e.ErrorInfo), t && t(e);
                    });
                } else t(Ce.getReturnError("Peer_Account is empty", -13));
            }, this.syncGroupMsgs = function(e, u, t) {
                if (e.ReqMsgSeq <= 0) {
                    if (t) {
                        var n = Ce.getReturnError("ReqMsgSeq must be greater than 0", -16);
                        t(n);
                    }
                } else {
                    var o, r, i, s = {
                        GroupId: e.GroupId,
                        ReqMsgSeq: e.ReqMsgSeq,
                        ReqMsgNumber: e.ReqMsgNumber
                    };
                    o = s, r = function(e) {
                        var t = [], n = (e.GroupId, e.RspMsgList), o = e.IsFinished;
                        if (null != n && void 0 !== n) {
                            for (var r = n.length - 1; 0 <= r; r--) {
                                var i = n[r];
                                if (!i.IsPlaceMsg && i.From_Account && i.MsgBody && 0 != i.MsgBody.length) {
                                    var s = P(i, !0, !0, o);
                                    s && t.push(s);
                                }
                            }
                            0 < t.length && $e.updateTimeline(), u ? u(t) : 0 < t.length && y && y(t);
                        } else u && u([]);
                    }, Ne(i = function(e) {
                        Ae.error("getGroupMsgs failed:" + e.ErrorInfo), t && t(e);
                    }, !0) && Xe.apiCall(k, "group_msg_get", {
                        GroupId: o.GroupId,
                        ReqMsgSeq: o.ReqMsgSeq,
                        ReqMsgNumber: o.ReqMsgNumber
                    }, r, i);
                }
            };
            var P = function(e, t, n, o) {
                if (e.IsPlaceMsg || !e.From_Account || !e.MsgBody || 0 == e.MsgBody.length) return null;
                var r, i, s, u, a = e.ToGroupId, c = a;
                e.GroupInfo && e.GroupInfo.GroupName && (c = e.GroupInfo.GroupName), s = e.From_Account, 
                e.GroupInfo && (e.GroupInfo.From_AccountNick && (s = e.GroupInfo.From_AccountNick), 
                u = e.GroupInfo.From_AccountHeadurl ? e.GroupInfo.From_AccountHeadurl : null), r = e.From_Account == _e.identifier, 
                e.From_Account, i = "";
                var l = $e.sessByTypeId(q.GROUP, a);
                l || (l = new je(q.GROUP, a, c, i, 0, 0)), void 0 !== o && l.isFinished(o || 0);
                var p = te.COMMON;
                if (J == e.Event || V == e.Event) {
                    p = te.TIP;
                    var d = e.MsgBody;
                    e.MsgBody = [], e.MsgBody.push({
                        MsgType: K.GROUP_TIP,
                        MsgContent: d
                    });
                } else e.MsgPriority && (e.MsgPriority == ne ? p = te.REDPACKET : e.MsgPriority == oe && (p = te.LOVEMSG));
                var f = new We(l, r, e.MsgSeq, e.MsgRandom, e.MsgTimeStamp, e.From_Account, p, s, u), g = null, m = null, I = null;
                for (var M in e.MsgBody) {
                    switch (I = (g = e.MsgBody[M]).MsgType) {
                      case K.TEXT:
                        m = new We.Elem.Text(g.MsgContent.Text);
                        break;

                      case K.FACE:
                        m = new We.Elem.Face(g.MsgContent.Index, g.MsgContent.Data);
                        break;

                      case K.IMAGE:
                        for (var y in m = new We.Elem.Images(g.MsgContent.UUID, g.MsgContent.ImageFormat || ""), 
                        g.MsgContent.ImageInfoArray) m.addImage(new We.Elem.Images.Image(g.MsgContent.ImageInfoArray[y].Type, g.MsgContent.ImageInfoArray[y].Size, g.MsgContent.ImageInfoArray[y].Width, g.MsgContent.ImageInfoArray[y].Height, g.MsgContent.ImageInfoArray[y].URL));
                        break;

                      case K.SOUND:
                        g.MsgContent ? m = new We.Elem.Sound(g.MsgContent.UUID, g.MsgContent.Second, g.MsgContent.Size, e.From_Account, e.To_Account, g.MsgContent.Download_Flag, q.GROUP) : (I = K.TEXT, 
                        m = new We.Elem.Text("[语音消息]下载地址解析出错"));
                        break;

                      case K.LOCATION:
                        m = new We.Elem.Location(g.MsgContent.Longitude, g.MsgContent.Latitude, g.MsgContent.Desc);
                        break;

                      case K.FILE:
                      case K.FILE + " ":
                        I = K.FILE;
                        Oe(g.MsgContent.UUID, e.From_Account, g.MsgContent.FileName);
                        g.MsgContent ? m = new We.Elem.File(g.MsgContent.UUID, g.MsgContent.FileName, g.MsgContent.FileSize, e.From_Account, e.To_Account, g.MsgContent.Download_Flag, q.GROUP) : (I = K.TEXT, 
                        m = new We.Elem.Text("[文件消息]地址解析出错"));
                        break;

                      case K.GROUP_TIP:
                        var h = g.MsgContent.OpType;
                        if (m = new We.Elem.GroupTip(h, g.MsgContent.Operator_Account, a, e.GroupInfo.GroupName, g.MsgContent.List_Account, g.MsgContent.MsgMemberExtraInfo), 
                        re.JOIN == h || re.QUIT == h) m.setGroupMemberNum(g.MsgContent.MemberNum); else if (re.MODIFY_GROUP_INFO == h) {
                            var _ = !1, E = {
                                GroupId: a,
                                GroupFaceUrl: null,
                                GroupName: null,
                                OwnerAccount: null,
                                GroupNotification: null,
                                GroupIntroduction: null
                            }, T = g.MsgContent.MsgGroupNewInfo;
                            if (T.GroupFaceUrl) {
                                var C = new We.Elem.GroupTip.GroupInfo(ie.FACE_URL, T.GroupFaceUrl);
                                m.addGroupInfo(C), _ = !0, E.GroupFaceUrl = T.GroupFaceUrl;
                            }
                            if (T.GroupName) {
                                var A = new We.Elem.GroupTip.GroupInfo(ie.NAME, T.GroupName);
                                m.addGroupInfo(A), _ = !0, E.GroupName = T.GroupName;
                            }
                            if (T.Owner_Account) {
                                var v = new We.Elem.GroupTip.GroupInfo(ie.OWNER, T.Owner_Account);
                                m.addGroupInfo(v), _ = !0, E.OwnerAccount = T.Owner_Account;
                            }
                            if (T.GroupNotification) {
                                var S = new We.Elem.GroupTip.GroupInfo(ie.NOTIFICATION, T.GroupNotification);
                                m.addGroupInfo(S), _ = !0, E.GroupNotification = T.GroupNotification;
                            }
                            if (T.GroupIntroduction) {
                                var G = new We.Elem.GroupTip.GroupInfo(ie.INTRODUCTION, T.GroupIntroduction);
                                m.addGroupInfo(G), _ = !0, E.GroupIntroduction = T.GroupIntroduction;
                            }
                            0 == t && _ && R && R(E);
                        } else if (re.MODIFY_MEMBER_INFO == h) {
                            var F = g.MsgContent.MsgMemberInfo;
                            for (var b in F) {
                                var N = F[b];
                                m.addMemberInfo(new We.Elem.GroupTip.MemberInfo(N.User_Account, N.ShutupTime));
                            }
                        }
                        break;

                      case K.CUSTOM:
                        I = K.CUSTOM, m = new We.Elem.Custom(g.MsgContent.Data, g.MsgContent.Desc, g.MsgContent.Ext);
                        break;

                      default:
                        I = K.TEXT, m = new We.Elem.Text("web端暂不支持" + g.MsgType + "消息");
                    }
                    f.elems.push(new We.Elem(I, m));
                }
                return 0 == n ? f : $e.addMsg(f, !0) ? (f.extraInfo = e.GroupInfo.MsgFrom_AccountExtraInfo, 
                f) : null;
            };
            this.init = function(e, t, n) {
                var r, o, i;
                (e.onMsgNotify || Ae.warn("listeners.onMsgNotify is empty"), y = e.onMsgNotify, 
                e.onBigGroupMsgNotify ? p = e.onBigGroupMsgNotify : Ae.warn("listeners.onBigGroupMsgNotify is empty"), 
                e.onC2cEventNotifys ? c = e.onC2cEventNotifys : Ae.warn("listeners.onC2cEventNotifys is empty"), 
                e.onGroupSystemNotifys ? d = e.onGroupSystemNotifys : Ae.warn("listeners.onGroupSystemNotifys is empty"), 
                e.onGroupInfoChangeNotify ? R = e.onGroupInfoChangeNotify : Ae.warn("listeners.onGroupInfoChangeNotify is empty"), 
                e.onFriendSystemNotifys ? s = e.onFriendSystemNotifys : Ae.warn("listeners.onFriendSystemNotifys is empty"), 
                e.onProfileSystemNotifys ? u = e.onProfileSystemNotifys : Ae.warn("listeners.onProfileSystemNotifys is empty"), 
                e.onKickedEventCall ? l = e.onKickedEventCall : Ae.warn("listeners.onKickedEventCall is empty"), 
                e.onLongPullingNotify ? onLongPullingNotify = e.onLongPullingNotify : Ae.warn("listeners.onKickedEventCall is empty"), 
                e.onAppliedDownloadUrl ? e.onAppliedDownloadUrl : Ae.warn("listeners.onAppliedDownloadUrl is empty"), 
                _e.identifier && _e.userSig) ? (r = function(e) {
                    Ae.info("initMyGroupMaxSeqs success"), T(function(e) {
                        (Ae.info("initIpAndAuthkey success"), t) && (Ae.info("login success(have login state))"), 
                        t({
                            ActionStatus: B,
                            ErrorCode: 0,
                            ErrorInfo: "login success"
                        }));
                        Ze.setLongPollingOn(!0), a && Ze.longPolling(t);
                    }, n);
                }, o = n, i = {
                    Member_Account: _e.identifier,
                    Limit: 1e3,
                    Offset: 0,
                    GroupBaseInfoFilter: [ "NextMsgSeq" ]
                }, Be(i, function(e) {
                    if (!e.GroupIdList || 0 == e.GroupIdList.length) return Ae.info("initMyGroupMaxSeqs: 目前还没有加入任何群组"), 
                    void (r && r(e));
                    for (var t = 0; t < e.GroupIdList.length; t++) {
                        var n = e.GroupIdList[t].GroupId, o = e.GroupIdList[t].NextMsgSeq - 1;
                        _[n] = o;
                    }
                    r && r(e);
                }, function(e) {
                    Ae.error("initMyGroupMaxSeqs failed:" + e.ErrorInfo), o && o(e);
                })) : t && t({
                    ActionStatus: B,
                    ErrorCode: 0,
                    ErrorInfo: "login success(no login state)"
                });
            }, this.sendMsg = function(o, r, i) {
                !function(e, t, n) {
                    if (Ne(n, !0)) {
                        var o = null;
                        switch (e.sess.type()) {
                          case q.C2C:
                            o = {
                                From_Account: _e.identifier,
                                To_Account: e.sess.id().toString(),
                                MsgTimeStamp: e.time,
                                MsgSeq: e.seq,
                                MsgRandom: e.random,
                                MsgBody: [],
                                OfflinePushInfo: e.offlinePushInfo
                            };
                            break;

                          case q.GROUP:
                            var r = e.getSubType();
                            switch (o = {
                                GroupId: e.sess.id().toString(),
                                From_Account: _e.identifier,
                                Random: e.random,
                                MsgBody: []
                            }, r) {
                              case te.COMMON:
                                o.MsgPriority = "COMMON";
                                break;

                              case te.REDPACKET:
                                o.MsgPriority = "REDPACKET";
                                break;

                              case te.LOVEMSG:
                                o.MsgPriority = "LOVEMSG";
                                break;

                              case te.TIP:
                                Ae.error("不能主动发送群提示消息,subType=" + r);
                                break;

                              default:
                                return Ae.error("发送群消息时，出现未知子消息类型：subType=" + r);
                            }
                        }
                        for (var i in e.elems) {
                            var s = e.elems[i], u = null, a = s.type;
                            switch (a) {
                              case K.TEXT:
                                u = {
                                    Text: s.content.text
                                };
                                break;

                              case K.FACE:
                                u = {
                                    Index: s.content.index,
                                    Data: s.content.data
                                };
                                break;

                              case K.IMAGE:
                                var c = [];
                                for (var l in s.content.ImageInfoArray) c.push({
                                    Type: s.content.ImageInfoArray[l].type,
                                    Size: s.content.ImageInfoArray[l].size,
                                    Width: s.content.ImageInfoArray[l].width,
                                    Height: s.content.ImageInfoArray[l].height,
                                    URL: s.content.ImageInfoArray[l].url
                                });
                                u = {
                                    ImageFormat: s.content.ImageFormat,
                                    UUID: s.content.UUID,
                                    ImageInfoArray: c
                                };
                                break;

                              case K.SOUND:
                                Ae.warn("web端暂不支持发送语音消息");
                                continue;

                              case K.LOCATION:
                                Ae.warn("web端暂不支持发送地理位置消息");
                                continue;

                              case K.FILE:
                                u = {
                                    UUID: s.content.uuid,
                                    FileName: s.content.name,
                                    FileSize: s.content.size,
                                    DownloadFlag: s.content.downFlag
                                };
                                break;

                              case K.CUSTOM:
                                u = {
                                    Data: s.content.data,
                                    Desc: s.content.desc,
                                    Ext: s.content.ext
                                }, a = K.CUSTOM;
                                break;

                              default:
                                Ae.warn("web端暂不支持发送" + s.type + "消息");
                                continue;
                            }
                            e.PushInfoBoolean && (o.OfflinePushInfo = e.PushInfo), o.MsgBody.push({
                                MsgType: a,
                                MsgContent: u
                            });
                        }
                        e.sess.type() == q.C2C ? Xe.apiCall(D, "sendmsg", o, t, n) : e.sess.type() == q.GROUP && Xe.apiCall(k, "send_group_msg", o, t, n);
                    }
                }(o, function(e) {
                    if (o.sess.type() == q.C2C) {
                        if (!$e.addMsg(o)) {
                            var t = "sendMsg: addMsg failed!", n = Ce.getReturnError(t, -17);
                            return Ae.error(t), void (i && i(n));
                        }
                        $e.updateTimeline();
                    }
                    r && r(e);
                }, function(e) {
                    i && i(e);
                });
            };
        }(), et = new function() {
            this.fileMd5 = null;
            this.uploadFile = function(t, n, o) {
                var s = {
                    init: function(e, t, n) {
                        var o = this;
                        o.file = e.file, o.onProgressCallBack = e.onProgressCallBack, e.abortButton && (e.abortButton.onclick = o.abortHandler), 
                        o.total = o.file.size, o.loaded = 0, o.step = 1105920, o.sliceSize = 0, o.sliceOffset = 0, 
                        o.timestamp = ve(), o.seq = Se(), o.random = Ge(), o.fromAccount = _e.identifier, 
                        o.toAccount = e.To_Account, o.fileMd5 = e.fileMd5, o.businessType = e.businessType, 
                        o.fileType = e.fileType, o.cbOk = t, o.cbErr = n, o.reader = new FileReader(), o.blobSlice = File.prototype.mozSlice || File.prototype.webkitSlice || File.prototype.slice, 
                        o.reader.onloadstart = o.onLoadStart, o.reader.onprogress = o.onProgress, o.reader.onabort = o.onAbort, 
                        o.reader.onerror = o.onerror, o.reader.onload = o.onLoad, o.reader.onloadend = o.onLoadEnd;
                    },
                    upload: function() {
                        s.readBlob(0);
                    },
                    onLoadStart: function() {},
                    onProgress: function(e) {
                        var t = s;
                        t.loaded += e.loaded, t.onProgressCallBack && t.onProgressCallBack(t.loaded, t.total);
                    },
                    onAbort: function() {},
                    onError: function() {},
                    onLoad: function(e) {
                        var n = s;
                        if (e.target.readyState == FileReader.DONE) {
                            var t = e.target.result, o = t.indexOf(",");
                            -1 != o && (t = t.substr(o + 1));
                            var r = {
                                From_Account: n.fromAccount,
                                To_Account: n.toAccount,
                                Busi_Id: n.businessType,
                                File_Type: n.fileType,
                                File_Str_Md5: n.fileMd5,
                                PkgFlag: y,
                                File_Size: n.total,
                                Slice_Offset: n.sliceOffset,
                                Slice_Size: n.sliceSize,
                                Slice_Data: t,
                                Seq: n.seq,
                                Timestamp: n.timestamp,
                                Random: n.random
                            }, i = function(e) {
                                if (0 == e.IsFinish) n.loaded = e.Next_Offset, n.loaded < n.total ? n.readBlob(n.loaded) : n.loaded = n.total; else if (n.cbOk) {
                                    var t = {
                                        ActionStatus: e.ActionStatus,
                                        ErrorCode: e.ErrorCode,
                                        ErrorInfo: e.ErrorInfo,
                                        File_UUID: e.File_UUID,
                                        File_Size: e.Next_Offset,
                                        URL_INFO: e.URL_INFO,
                                        Download_Flag: e.Download_Flag
                                    };
                                    n.fileType == C.FILE && (t.URL_INFO = Oe(e.File_UUID, _e.identifier, n.file.name)), 
                                    n.cbOk(t);
                                }
                                S = 0;
                            };
                            He(r, i, function e(t) {
                                S < 20 ? (S++, setTimeout(function() {
                                    He(r, i, e);
                                }, 1e3)) : n.cbErr(t);
                            });
                        }
                    },
                    onLoadEnd: function() {},
                    readBlob: function(e) {
                        var t, n = s, o = n.file, r = e + n.step;
                        r > n.total ? (r = n.total, n.sliceSize = r - e) : n.sliceSize = n.step, n.sliceOffset = e, 
                        t = n.blobSlice.call(o, e, r), n.reader.readAsDataURL(t);
                    },
                    abortHandler: function() {
                        var e = s;
                        e.reader && e.reader.abort();
                    }
                };
                !function(o, i, t) {
                    var r = null;
                    try {
                        r = new FileReader();
                    } catch (e) {
                        if (t) return t(Ce.getReturnError("当前浏览器不支持FileReader", -18));
                    }
                    var s = File.prototype.mozSlice || File.prototype.webkitSlice || File.prototype.slice;
                    if (s || !t) {
                        var u = 2097152, a = Math.ceil(o.size / u), c = 0, l = new SparkMD5();
                        r.onload = function(e) {
                            for (var t = "", n = new Uint8Array(e.target.result), o = n.byteLength, r = 0; r < o; r++) t += String.fromCharCode(n[r]);
                            l.appendBinary(t), ++c < a ? p() : (this.fileMd5 = l.end(), i && i(this.fileMd5));
                        }, p();
                    } else t(Ce.getReturnError("当前浏览器不支持FileAPI", -19));
                    function p() {
                        var e = c * u, t = e + u >= o.size ? o.size : e + u, n = s.call(o, e, t);
                        r.readAsArrayBuffer(n);
                    }
                }(t.file, function(e) {
                    Ae.info("fileMd5: " + e), t.fileMd5 = e, s.init(t, n, o), s.upload();
                }, o);
            };
        }();
        t.SESSION_TYPE = q, t.MSG_MAX_LENGTH = {
            C2C: 12e3,
            GROUP: 8898
        }, t.C2C_MSG_SUB_TYPE = $, t.GROUP_MSG_SUB_TYPE = te, t.MSG_ELEMENT_TYPE = K, t.GROUP_TIP_TYPE = re, 
        t.IMAGE_TYPE = r, t.GROUP_SYSTEM_TYPE = se, t.FRIEND_NOTICE_TYPE = ue, t.GROUP_TIP_MODIFY_GROUP_INFO_TYPE = ie, 
        t.BROWSER_INFO = e, t.Emotions = t.EmotionPicData = P, t.EmotionDataIndexs = t.EmotionPicDataIndex = L, 
        t.TLS_ERROR_CODE = {
            OK: 0,
            SIGNATURE_EXPIRATION: 11
        }, t.CONNECTION_STATUS = ce, t.UPLOAD_PIC_BUSSINESS_TYPE = {
            GROUP_MSG: 1,
            C2C_MSG: 2,
            USER_HEAD: 3,
            GROUP_HEAD: 4
        }, t.RECENT_CONTACT_TYPE = {
            C2C: 1,
            GROUP: 2
        }, t.UPLOAD_RES_TYPE = C, t.Tool = Ce, t.Log = Ae, t.Msg = We, t.Session = je, t.MsgStore = {
            sessMap: function() {
                return $e.sessMap();
            },
            sessCount: function() {
                return $e.sessCount();
            },
            sessByTypeId: function(e, t) {
                return $e.sessByTypeId(e, t);
            },
            delSessByTypeId: function(e, t) {
                return $e.delSessByTypeId(e, t);
            },
            resetCookieAndSyncFlag: function() {
                return $e.resetCookieAndSyncFlag();
            }
        }, t.Resources = O, t.login = t.init = function(e, t, n, o, r) {
            var i, s, u, a, c;
            Xe.init(t.onConnNotify, o, r), i = e, s = t, u = n, a = o, c = r, Pe(), u && (G = u), 
            0 == G.isAccessFormalEnv && (Ae.error("请切换为正式环境！！！！"), U = G.isAccessFormalEnv), 
            0 == G.isLogOn && Ae.setOn(G.isLogOn), i || !c ? i.sdkAppID || !c ? i.accountType || !c ? (i.identifier && (_e.identifier = i.identifier.toString()), 
            i.identifier && !i.userSig && c ? c(Ce.getReturnError("loginInfo.userSig is empty", -9)) : (i.userSig && (_e.userSig = i.userSig.toString()), 
            _e.sdkAppID = i.sdkAppID, _e.accountType = i.accountType, _e.identifier && _e.userSig ? De(function() {
                ke(function(t, n) {
                    Ze.init(s, function(e) {
                        a && (e.identifierNick = t, e.headurl = n, a(e));
                    }, c);
                }, c);
            }) : Ze.init(s, a, c))) : c(Ce.getReturnError("loginInfo.accountType is empty", -8)) : c(Ce.getReturnError("loginInfo.sdkAppID is empty", -7)) : c(Ce.getReturnError("loginInfo is empty", -6));
        }, t.logout = t.offline = function(e, t) {
            return we("instance", e, t);
        }, t.logoutAll = function(e, t) {
            return we("all", e, t);
        }, t.sendMsg = function(e, t, n) {
            return Ze.sendMsg(e, t, n);
        }, t.syncMsgs = function(e, t) {
            return Ze.syncMsgs(e, t);
        }, t.getC2CHistoryMsgs = function(e, t, n) {
            return Ze.getC2CHistoryMsgs(e, t, n);
        }, t.syncGroupMsgs = function(e, t, n) {
            return Ze.syncGroupMsgs(e, t, n);
        }, t.c2CMsgReaded = function(e, t, n) {
            return $e.c2CMsgReaded(e, t, n);
        }, t.groupMsgReaded = function(e, t, n) {
            return xe(e, t, n);
        }, t.setAutoRead = function(e, t, n) {
            return $e.setAutoRead(e, t, n);
        }, t.createGroup = function(e, t, n) {
            return function(e, t, n) {
                if (Ne(n, !0)) {
                    for (var o = {
                        Type: e.Type,
                        Name: e.Name
                    }, r = [], i = 0; i < e.MemberList.length; i++) r.push({
                        Member_Account: e.MemberList[i]
                    });
                    o.MemberList = r, e.GroupId && (o.GroupId = e.GroupId), e.Owner_Account && (o.Owner_Account = e.Owner_Account), 
                    e.Introduction && (o.Introduction = e.Introduction), e.Notification && (o.Notification = e.Notification), 
                    e.MaxMemberCount && (o.MaxMemberCount = e.MaxMemberCount), e.ApplyJoinOption && (o.ApplyJoinOption = e.ApplyJoinOption), 
                    e.AppDefinedData && (o.AppDefinedData = e.AppDefinedData), e.FaceUrl && (o.FaceUrl = e.FaceUrl), 
                    Xe.apiCall(k, "create_group", o, t, n);
                }
            }(e, t, n);
        }, t.createGroupHigh = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(k, "create_group", o, r, i));
            var o, r, i;
        }, t.applyJoinGroup = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && (o.GroupId = String(o.GroupId), Xe.apiCall(k, "apply_join_group", {
                GroupId: o.GroupId,
                ApplyMsg: o.ApplyMsg,
                UserDefinedField: o.UserDefinedField
            }, r, i)));
            var o, r, i;
        }, t.handleApplyJoinGroupPendency = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(k, "handle_apply_join_group", {
                GroupId: o.GroupId,
                Applicant_Account: o.Applicant_Account,
                HandleMsg: o.HandleMsg,
                Authentication: o.Authentication,
                MsgKey: o.MsgKey,
                ApprovalMsg: o.ApprovalMsg,
                UserDefinedField: o.UserDefinedField
            }, r, function(e) {
                10024 == e.ErrorCode ? r && r({
                    ActionStatus: B,
                    ErrorCode: 0,
                    ErrorInfo: "该申请已经被处理过"
                }) : i && i(e);
            }));
            var o, r, i;
        }, t.getPendencyGroup = function(e, t, n) {
            return o = e, r = t, void (Ne(n, !0) && Xe.apiCall(k, "get_pendency", {
                StartTime: o.StartTime,
                Limit: o.Limit,
                Handle_Account: _e.identifier
            }, r, function(e) {}));
            var o, r;
        }, t.getPendencyGroupRead = function(e, t, n) {
            return o = e, r = t, void (Ne(n, !0) && Xe.apiCall(k, "report_pendency", {
                ReportTime: o.ReportTime,
                From_Account: _e.identifier
            }, r, function(e) {}));
            var o, r;
        }, t.handleInviteJoinGroupRequest = function(e, t, n) {
            return o = e, r = t, void (Ne(n, !0) && Xe.apiCall(k, "handle_invite_join_group", {
                GroupId: o.GroupId,
                Inviter_Account: o.Inviter_Account,
                HandleMsg: o.HandleMsg,
                Authentication: o.Authentication,
                MsgKey: o.MsgKey,
                ApprovalMsg: o.ApprovalMsg,
                UserDefinedField: o.UserDefinedField
            }, r, function(e) {}));
            var o, r;
        }, t.deleteApplyJoinGroupPendency = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(D, "deletemsg", o, r, i));
            var o, r, i;
        }, t.quitGroup = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(k, "quit_group", {
                GroupId: o.GroupId
            }, r, i));
            var o, r, i;
        }, t.searchGroupByName = function(e, t, n) {
            return o = e, r = t, i = n, void Xe.apiCall(k, "search_group", o, r, i);
            var o, r, i;
        }, t.getGroupPublicInfo = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(k, "get_group_public_info", {
                GroupIdList: o.GroupIdList,
                ResponseFilter: {
                    GroupBasePublicInfoFilter: o.GroupBasePublicInfoFilter
                }
            }, function(e) {
                if (e.ErrorInfo = "", e.GroupInfo) for (var t in e.GroupInfo) {
                    var n = e.GroupInfo[t].ErrorCode;
                    0 < n && (e.ActionStatus = x, e.GroupInfo[t].ErrorInfo = "[" + n + "]" + e.GroupInfo[t].ErrorInfo, 
                    e.ErrorInfo += e.GroupInfo[t].ErrorInfo + "\n");
                }
                e.ActionStatus == x ? i && i(e) : r && r(e);
            }, i));
            var o, r, i;
        }, t.getGroupInfo = function(e, t, n) {
            return function(e, t, n) {
                if (Ne(n, !0)) {
                    var o = {
                        GroupIdList: e.GroupIdList,
                        ResponseFilter: {
                            GroupBaseInfoFilter: e.GroupBaseInfoFilter,
                            MemberInfoFilter: e.MemberInfoFilter
                        }
                    };
                    e.AppDefinedDataFilter_Group && (o.ResponseFilter.AppDefinedDataFilter_Group = e.AppDefinedDataFilter_Group), 
                    e.AppDefinedDataFilter_GroupMember && (o.ResponseFilter.AppDefinedDataFilter_GroupMember = e.AppDefinedDataFilter_GroupMember), 
                    Xe.apiCall(k, "get_group_info", o, t, n);
                }
            }(e, t, n);
        }, t.modifyGroupBaseInfo = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(k, "modify_group_base_info", o, r, i));
            var o, r, i;
        }, t.getGroupMemberInfo = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(k, "get_group_member_info", {
                GroupId: o.GroupId,
                Offset: o.Offset,
                Limit: o.Limit,
                MemberInfoFilter: o.MemberInfoFilter,
                MemberRoleFilter: o.MemberRoleFilter,
                AppDefinedDataFilter_GroupMember: o.AppDefinedDataFilter_GroupMember
            }, r, i));
            var o, r, i;
        }, t.addGroupMember = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(k, "add_group_member", {
                GroupId: o.GroupId,
                Silence: o.Silence,
                MemberList: o.MemberList
            }, r, i));
            var o, r, i;
        }, t.modifyGroupMember = function(e, t, n) {
            return function(e, t, n) {
                if (Ne(n, !0)) {
                    var o = {};
                    e.GroupId && (o.GroupId = e.GroupId), e.Member_Account && (o.Member_Account = e.Member_Account), 
                    e.Role && (o.Role = e.Role), e.MsgFlag && (o.MsgFlag = e.MsgFlag), e.ShutUpTime && (o.ShutUpTime = e.ShutUpTime), 
                    e.NameCard && (o.NameCard = e.NameCard), e.AppMemberDefinedData && (o.AppMemberDefinedData = e.AppMemberDefinedData), 
                    Xe.apiCall(k, "modify_group_member_info", o, t, n);
                }
            }(e, t, n);
        }, t.deleteGroupMember = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(k, "delete_group_member", {
                GroupId: o.GroupId,
                Silence: o.Silence,
                MemberToDel_Account: o.MemberToDel_Account,
                Reason: o.Reason
            }, r, i));
            var o, r, i;
        }, t.destroyGroup = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(k, "destroy_group", {
                GroupId: o.GroupId
            }, r, i));
            var o, r, i;
        }, t.changeGroupOwner = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(k, "change_group_owner", o, r, i));
            var o, r, i;
        }, t.getJoinedGroupListHigh = function(e, t, n) {
            return Be(e, t, n);
        }, t.getRoleInGroup = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(k, "get_role_in_group", {
                GroupId: o.GroupId,
                User_Account: o.User_Account
            }, r, i));
            var o, r, i;
        }, t.forbidSendMsg = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(k, "forbid_send_msg", {
                GroupId: o.GroupId,
                Members_Account: o.Members_Account,
                ShutUpTime: o.ShutUpTime
            }, r, i));
            var o, r, i;
        }, t.sendCustomGroupNotify = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(k, "send_group_system_notification", o, r, i));
            var o, r, i;
        }, t.applyJoinBigGroup = function(e, t, n) {
            return r = t, i = n, (o = e).GroupId = String(o.GroupId), s = Ne(i, !1) ? k : a, 
            void (Ze.checkBigGroupLongPollingOn(o.GroupId) ? i && i(Ce.getReturnError("Join Group failed; You have already been in this group, you have to quit group before you rejoin", 10013)) : Xe.apiCall(s, "apply_join_group", {
                GroupId: o.GroupId,
                ApplyMsg: o.ApplyMsg,
                UserDefinedField: o.UserDefinedField
            }, function(e) {
                if (e.JoinedStatus && "JoinedSuccess" == e.JoinedStatus) {
                    if (!e.LongPollingKey) return void (i && i(Ce.getReturnError("Join Group succeed; But the type of group is not AVChatRoom: groupid=" + o.GroupId, -12)));
                    Ze.setBigGroupLongPollingOn(!0), Ze.setBigGroupLongPollingKey(o.GroupId, e.LongPollingKey), 
                    Ze.setBigGroupLongPollingMsgMap(o.GroupId, 0), Ze.bigGroupLongPolling(o.GroupId);
                }
                r && r(e);
            }, function(e) {
                i && i(e);
            }));
            var o, r, i, s;
        }, t.quitBigGroup = function(e, t, n) {
            return o = e, r = t, s = Ne(i = n, !1) ? k : a, Ze.resetBigGroupLongPollingInfo(o.GroupId), 
            void Xe.apiCall(s, "quit_group", {
                GroupId: o.GroupId
            }, function(e) {
                $e.delSessByTypeId(q.GROUP, o.GroupId), r && r(e);
            }, i);
            var o, r, i, s;
        }, t.getProfilePortrait = function(e, t, n) {
            return ze(e, t, n);
        }, t.setProfilePortrait = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(c, "portrait_set", {
                From_Account: _e.identifier,
                ProfileItem: o.ProfileItem
            }, function(e) {
                for (var t in o.ProfileItem) {
                    var n = o.ProfileItem[t];
                    if ("Tag_Profile_IM_Nick" == n.Tag) {
                        _e.identifierNick = n.Value;
                        break;
                    }
                }
                r && r(e);
            }, i));
            var o, r, i;
        }, t.applyAddFriend = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(s, "friend_add", {
                From_Account: _e.identifier,
                AddFriendItem: o.AddFriendItem
            }, function(e) {
                var t = Ke(e);
                t.ActionStatus == x ? i && i(t) : r && r(t);
            }, i));
            var o, r, i;
        }, t.getPendency = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(s, "pendency_get", {
                From_Account: _e.identifier,
                PendencyType: o.PendencyType,
                StartTime: o.StartTime,
                MaxLimited: o.MaxLimited,
                LastSequence: o.LastSequence
            }, r, i));
            var o, r, i;
        }, t.getPendencyReport = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(s, "PendencyReport", {
                From_Account: _e.identifier,
                LatestPendencyTimeStamp: o.LatestPendencyTimeStamp
            }, r, i));
            var o, r, i;
        }, t.deletePendency = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(s, "pendency_delete", {
                From_Account: _e.identifier,
                PendencyType: o.PendencyType,
                To_Account: o.To_Account
            }, function(e) {
                var t = Ke(e);
                t.ActionStatus == x ? i && i(t) : r && r(t);
            }, i));
            var o, r, i;
        }, t.responseFriend = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(s, "friend_response", {
                From_Account: _e.identifier,
                ResponseFriendItem: o.ResponseFriendItem
            }, function(e) {
                var t = Ke(e);
                t.ActionStatus == x ? i && i(t) : r && r(t);
            }, i));
            var o, r, i;
        }, t.getAllFriend = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(s, "friend_get_all", {
                From_Account: _e.identifier,
                TimeStamp: o.TimeStamp,
                StartIndex: o.StartIndex,
                GetCount: o.GetCount,
                LastStandardSequence: o.LastStandardSequence,
                TagList: o.TagList
            }, r, i));
            var o, r, i;
        }, t.deleteChat = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && (1 == o.chatType ? Xe.apiCall(m, "delete", {
                From_Account: _e.identifier,
                Type: o.chatType,
                To_Account: o.To_Account
            }, r, i) : Xe.apiCall(m, "delete", {
                From_Account: _e.identifier,
                Type: o.chatType,
                ToGroupid: o.To_Account
            }, r, i)));
            var o, r, i;
        }, t.deleteFriend = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(s, "friend_delete", {
                From_Account: _e.identifier,
                To_Account: o.To_Account,
                DeleteType: o.DeleteType
            }, function(e) {
                var t = Ke(e);
                t.ActionStatus == x ? i && i(t) : r && r(t);
            }, i));
            var o, r, i;
        }, t.addBlackList = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(s, "black_list_add", {
                From_Account: _e.identifier,
                To_Account: o.To_Account
            }, function(e) {
                var t = Ke(e);
                t.ActionStatus == x ? i && i(t) : r && r(t);
            }, i));
            var o, r, i;
        }, t.deleteBlackList = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(s, "black_list_delete", {
                From_Account: _e.identifier,
                To_Account: o.To_Account
            }, function(e) {
                var t = Ke(e);
                t.ActionStatus == x ? i && i(t) : r && r(t);
            }, i));
            var o, r, i;
        }, t.getBlackList = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(s, "black_list_get", {
                From_Account: _e.identifier,
                StartIndex: o.StartIndex,
                MaxLimited: o.MaxLimited,
                LastSequence: o.LastSequence
            }, r, i));
            var o, r, i;
        }, t.getRecentContactList = function(e, t, n) {
            return o = e, r = t, void (Ne(i = n, !0) && Xe.apiCall(u, "get", {
                From_Account: _e.identifier,
                Count: o.Count
            }, r, i));
            var o, r, i;
        }, t.uploadFile = t.uploadPic = function(e, t, n) {
            return et.uploadFile(e, t, n);
        }, t.submitUploadFileForm = function(e, t, n) {
            return et.submitUploadFileForm(e, t, n);
        }, t.uploadFileByBase64 = t.uploadPicByBase64 = function(e, t, n) {
            var o = {
                To_Account: e.toAccount,
                Busi_Id: e.businessType,
                File_Type: e.File_Type,
                File_Str_Md5: e.fileMd5,
                PkgFlag: y,
                File_Size: e.totalSize,
                Slice_Offset: 0,
                Slice_Size: e.totalSize,
                Slice_Data: e.base64Str,
                Seq: Se(),
                Timestamp: ve(),
                Random: Ge()
            };
            return He(o, t, n);
        }, t.getLongPollingId = function(e, t, n) {
            return Ye(0, t, n);
        }, t.applyDownload = function(e, t, n) {
            return Ve(e, t, n);
        }, t.checkLogin = function(e, t) {
            return Ne(e, t);
        };
    }(e), e;
}();