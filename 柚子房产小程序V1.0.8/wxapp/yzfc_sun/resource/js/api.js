var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
    return typeof e;
} : function(e) {
    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
}, _rewx = require("./rewx.js"), app = getApp(), IndexData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Index", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, IndexRecHouseData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("IndexRecHouse", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, IndexNewsData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("IndexNews", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, NewsListData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("NewsList", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, NewsDetailsData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("NewsDetails", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, CollectData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Collect", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, HotHouseSetData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("HotHouseSet", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, HotHouseData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("HotHouse", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, HouseDetailsData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("HouseDetails", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, HouseTypeListData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("HouseTypeList", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, HouseTypeDetailsData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("HouseTypeDetails", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, HouseOrderData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("HouseOrder", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, QuestionClassifyData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("QuestionClassify", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, QuestionListData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("QuestionList", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, AskQuestionData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("AskQuestion", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, CompanyData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Company", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, BranchListData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("BranchList", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, CardlistData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Cardlist", e).then(function(s) {
        return new Promise(function(e, n) {
            var t = new Date().getTime() / 1e3, o = !0, i = !1, r = void 0;
            try {
                for (var a, u = s[Symbol.iterator](); !(o = (a = u.next()).done); o = !0) {
                    var f = a.value;
                    f.etime = (0, _rewx.getFullDate)(f.end_time - 0), t < f.start_time ? (f.btn = 1, 
                    f.btnTxt = "敬请期待") : t >= f.start_time && t < f.end_time ? (f.btn = 2, f.btnTxt = "马上参加") : t > f.end_time && (f.btn = 3, 
                    f.btnTxt = "已结束");
                }
            } catch (e) {
                i = !0, r = e;
            } finally {
                try {
                    !o && u.return && u.return();
                } finally {
                    if (i) throw r;
                }
            }
            e(s);
        });
    });
}, CardDetailsData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("CardDetails", e).then(function(a) {
        return new Promise(function(e, n) {
            var t = [], o = [], i = a.prizelist;
            for (var r in i) o.push(i[r]), r % 2 != 0 && (t.push(o), o = []), r % 2 == 0 && i.length < 2 && (t.push(o), 
            o = []);
            a.getter = t, e(a);
        });
    });
}, CardShareData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("CardShare", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, CardDrawData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("CardDraw", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, CardGetprizeData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("CardGetprize", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, GetPrizeBranchData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("GetPrizeBranch", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, PrizeInfoData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("PrizeInfo", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, NewHouseData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("NewHouse", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, RegionListData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("RegionList", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, FindClassifyData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("FindClassify", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, FindListData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("FindList", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, FindDetailsData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("FindDetails", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, FindComListData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("FindComList", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, FindComAddData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("FindComAdd", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, FindAddData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("FindAdd", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, MyPrizeData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("MyPrize", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, DelPrizeData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("DelPrize", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, MyOrderData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("MyOrder", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, DelOrderData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("DelOrder", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, MyQuestionData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("MyQuestion", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, MyFindData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("MyFind", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, DelFindData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("DelFind", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, MyCollectData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("MyCollect", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, AdminLoginData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("AdminLogin", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, AdminInfoData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("AdminInfo", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, SendPrizeData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("SendPrize", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, UpdatePrizeData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("UpdatePrize", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, CheckInfoData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("CheckInfo", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, CheckPrizeData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("CheckPrize", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, AdpicData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Adpic", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, NavsetData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Navset", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, ColorData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Color", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, SupportData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Support", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, UrlData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Url", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    });
}, OpenidData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Openid", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    }, function(t) {
        return new Promise(function(e, n) {
            n(t);
        });
    });
}, SaveAvatarData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Login", e).then(function(t) {
        return new Promise(function(e, n) {
            e(t);
        });
    }, function(t) {
        return new Promise(function(e, n) {
            n(t);
        });
    });
}, checkSessions = function() {
    return new Promise(function(e, n) {
        var t = wx.getStorageSync("fcInfo");
        t.session_key ? wx.checkSession({
            success: function() {
                n(t);
            },
            fail: function() {
                t.session_key = "", wx.removeStorageSync("fcInfo"), e();
            }
        }) : e();
    });
}, getUserInfo = function() {
    return checkSessions().then(function(e) {
        return Login();
    });
}, Login = function() {
    return new Promise(function(e, t) {
        var o = {
            openid: "",
            session_key: "",
            wxInfo: ""
        };
        wx.login({
            success: function(e) {
                var n = e.code;
                OpenidData({
                    code: n
                }).then(function(e) {
                    (e = JSON.parse(e)).openid ? (o.openid = e.openid, o.session_key = e.session_key, 
                    o.code = n, o.login = !1, wx.setStorageSync("fcInfo", o), t(o)) : wx.showModal({
                        title: e.errcode + "",
                        content: e.errmsg,
                        showCancel: !1,
                        success: function(e) {
                            e.confirm && getUserInfo();
                        }
                    });
                });
            }
        });
    });
}, gps = function() {
    return new Promise(function(n, e) {
        wx.getLocation({
            type: "wgs84",
            success: function(e) {
                n(e);
            },
            fail: function(e) {
                n(0);
            }
        });
    });
}, appPay = function(e) {
    return new Promise(function(n, t) {
        wx.requestPayment({
            timeStamp: res.timeStamp,
            nonceStr: res.nonceStr,
            package: res.package,
            signType: res.signType,
            paySign: res.paySign,
            success: function(e) {
                n(data);
            },
            fail: function(e) {
                t(e);
            }
        });
    });
};

module.exports = {
    AdpicData: AdpicData,
    NavsetData: NavsetData,
    ColorData: ColorData,
    SupportData: SupportData,
    UrlData: UrlData,
    OpenidData: OpenidData,
    SaveAvatarData: SaveAvatarData,
    getUserInfo: getUserInfo,
    gps: gps,
    appPay: appPay,
    IndexData: IndexData,
    IndexRecHouseData: IndexRecHouseData,
    IndexNewsData: IndexNewsData,
    NewsListData: NewsListData,
    NewsDetailsData: NewsDetailsData,
    CollectData: CollectData,
    HotHouseSetData: HotHouseSetData,
    HotHouseData: HotHouseData,
    HouseDetailsData: HouseDetailsData,
    HouseTypeListData: HouseTypeListData,
    HouseTypeDetailsData: HouseTypeDetailsData,
    HouseOrderData: HouseOrderData,
    QuestionClassifyData: QuestionClassifyData,
    QuestionListData: QuestionListData,
    AskQuestionData: AskQuestionData,
    CompanyData: CompanyData,
    BranchListData: BranchListData,
    CardlistData: CardlistData,
    CardDetailsData: CardDetailsData,
    CardShareData: CardShareData,
    CardDrawData: CardDrawData,
    CardGetprizeData: CardGetprizeData,
    GetPrizeBranchData: GetPrizeBranchData,
    PrizeInfoData: PrizeInfoData,
    NewHouseData: NewHouseData,
    RegionListData: RegionListData,
    FindClassifyData: FindClassifyData,
    FindListData: FindListData,
    FindDetailsData: FindDetailsData,
    FindComListData: FindComListData,
    FindComAddData: FindComAddData,
    FindAddData: FindAddData,
    MyPrizeData: MyPrizeData,
    DelPrizeData: DelPrizeData,
    MyOrderData: MyOrderData,
    DelOrderData: DelOrderData,
    MyQuestionData: MyQuestionData,
    MyFindData: MyFindData,
    DelFindData: DelFindData,
    MyCollectData: MyCollectData,
    AdminLoginData: AdminLoginData,
    AdminInfoData: AdminInfoData,
    SendPrizeData: SendPrizeData,
    UpdatePrizeData: UpdatePrizeData,
    CheckInfoData: CheckInfoData,
    CheckPrizeData: CheckPrizeData
};