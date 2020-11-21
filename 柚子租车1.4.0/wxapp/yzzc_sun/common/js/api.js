var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
    return typeof e;
} : function(e) {
    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
}, _rewx = require("./rewx.js"), app = getApp(), NavsetData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Navset", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, SupportData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Support", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, UrlData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Url", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, ColorData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Color", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, AdpicData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Adpic", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, ShouyeData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Shouye", e).then(function(r) {
        return new Promise(function(e, t) {
            for (var n in r.car) r.car[n].distance ? r.car[n].dis = (r.car[n].distance - 0).toFixed(2) : r.car[n].dis = -1;
            e(r);
        });
    });
}, HomeSign = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Sign", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, CouponListData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("CouponList", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, GetCouponData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("GetCoupon", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, ActiveData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Active", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, ActiveInfoData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("ActiveInfo", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, YdcarData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Ydcar", e).then(function(r) {
        return new Promise(function(e, t) {
            var n = r;
            switch (r.structure - 0) {
              case 1:
                n.carType = "两厢";
                break;

              case 2:
                n.carType = "三厢";
            }
            switch (r.grarbox - 0) {
              case 1:
                n.carControl = "手动";
                break;

              case 2:
                n.carControl = "自动";
            }
            n.shopName = r.shopinfo.area_name + r.shopinfo.name, e(n);
        });
    });
}, CheckOrdData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("CheckOrd", e).then(function(n) {
        return new Promise(function(e, t) {
            switch (n.carinfo.structure - 0) {
              case 1:
                n.carinfo.carType = "两厢";
                break;

              case 2:
                n.carinfo.carType = "三厢";
            }
            switch (n.carinfo.grarbox - 0) {
              case 1:
                n.carinfo.carControl = "手动";
                break;

              case 2:
                n.carinfo.carControl = "自动";
            }
            e(n);
        });
    });
}, KycouponData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Kycoupon", e).then(function(r) {
        return new Promise(function(e, t) {
            for (var n in r) r[n].checked = !1;
            e(r);
        });
    });
}, OrderData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Order", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, OrderarrData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Orderarr", e).then(function(n) {
        return console.log(n), new Promise(function(e, t) {
            e(n);
        });
    });
}, IsorderData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Isorder", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, TaocanData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Taocan", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, CityshopData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Cityshop", e).then(function(r) {
        return new Promise(function(e, t) {
            for (var n in r) r[n].shopName = r[n].area_name + r[n].name;
            e(r);
        });
    });
}, CartypeData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Cartype", e).then(function(r) {
        return new Promise(function(e, t) {
            for (var n in r) r[n].shopName = r[n].area_name + r[n].name;
            e(r);
        });
    });
}, CarlistData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Carlist", e).then(function(o) {
        return new Promise(function(e, t) {
            if (console.log(o), o.res) for (var n in console.log(111), o.res) {
                switch (o.res[n].structure - 0) {
                  case 1:
                    o.res[n].carType = "两厢";
                    break;

                  case 2:
                    o.res[n].carType = "三厢";
                }
                switch (o.res[n].grarbox - 0) {
                  case 1:
                    o.res[n].carControl = "手动";
                    break;

                  case 2:
                    o.res[n].carControl = "自动";
                }
            }
            if (0 < o.res1.length) for (var r in console.log(222), o.res1) {
                switch (o.res1[r].structure - 0) {
                  case 1:
                    o.res1[r].carType = "两厢";
                    break;

                  case 2:
                    o.res1[r].carType = "三厢";
                }
                switch (o.res1[r].grarbox - 0) {
                  case 1:
                    o.res1[r].carControl = "手动";
                    break;

                  case 2:
                    o.res1[r].carControl = "自动";
                }
            }
            e(o);
        });
    });
}, QrpicData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Qrpic", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, DelimgData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Delimg", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, AllcityData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Allcity", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, GetareaData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Getarea", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, FjshopData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Fjshop", e).then(function(o) {
        return new Promise(function(e, t) {
            var n = o;
            for (var r in n) n[r].distance = (n[r].distance - 0).toFixed(2) + "km", o[r].shopName = o[r].name;
            e(o);
        });
    });
}, AreashopData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Areashop", e).then(function(o) {
        return new Promise(function(e, t) {
            var n = o;
            for (var r in n) n[r].distance = (n[r].distance - 0).toFixed(2) + "km";
            e(o);
        });
    });
}, BranchData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Branch", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, OrderInfoData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("OrderInfo", e).then(function(r) {
        return new Promise(function(e, t) {
            var n = r;
            switch (r.carinfo.structure - 0) {
              case 1:
                n.carType = "两厢";
                break;

              case 2:
                n.carType = "三厢";
            }
            switch (r.carinfo.grarbox - 0) {
              case 1:
                n.carControl = "手动";
                break;

              case 2:
                n.carControl = "自动";
            }
            n.sdate = getDate(2, r.start_time), n.edate = getDate(2, r.end_time), n.stime = getTime(2, r.start_time), 
            n.etime = getTime(2, r.end_time), n.sweek = "周" + "日一二三四五六".charAt(new Date(1e3 * r.start_time).getDay()), 
            n.eweek = "周" + "日一二三四五六".charAt(new Date(1e3 * r.end_time).getDay()), e(n);
        });
    });
}, CancelData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Cancel", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, PaysuccessData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Paysuccess", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, GetcarData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Getcar", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, OrderListData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("OrderList", e).then(function(o) {
        return new Promise(function(e, t) {
            var n = o;
            for (var r in n) {
                switch (n[r].status) {
                  case "0":
                    n[r].payType = "已完成";
                    break;

                  case "1":
                    n[r].payType = "待支付";
                    break;

                  case "2":
                    n[r].payType = "已支付";
                    break;

                  case "3":
                    n[r].payType = "已取车";
                    break;

                  case "4":
                    n[r].payType = "已取消";
                    break;

                  case "5":
                    n[r].payType = "已退款";
                }
                switch (n[r].carinfo.structure - 0) {
                  case 1:
                    n[r].carType = "两厢";
                    break;

                  case 2:
                    n[r].carType = "三厢";
                }
                switch (n[r].carinfo.grarbox - 0) {
                  case 1:
                    n[r].carControl = "手动";
                    break;

                  case 2:
                    n[r].carControl = "自动";
                }
                n[r].sdate = getDate(2, n[r].start_time), n[r].edate = getDate(2, n[r].end_time), 
                n[r].stime = getTime(2, n[r].start_time), n[r].etime = getTime(2, n[r].end_time), 
                n[r].sweek = "周" + "日一二三四五六".charAt(new Date(1e3 * n[r].start_time).getDay()), n[r].eweek = "周" + "日一二三四五六".charAt(new Date(1e3 * n[r].end_time).getDay());
            }
            e(n);
        });
    });
}, IntegralData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Integral", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, ExchangeData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Exchange", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, IntegralDetailsData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("IntegralDetails", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, UsersData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Users", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, MemberData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Member", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, MycouponData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Mycoupon", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, HelpsData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Helps", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, RuleData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Rule", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, WeData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("We", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, AdminInfoData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("AdminInfo", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, BranchCarlsitData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("BranchCarlsit", e).then(function(o) {
        return new Promise(function(e, t) {
            var n = o;
            for (var r in o) {
                switch (o[r].structure - 0) {
                  case 1:
                    n[r].carType = "两厢";
                    break;

                  case 2:
                    n[r].carType = "三厢";
                }
                switch (o[r].grarbox - 0) {
                  case 1:
                    n[r].carControl = "手动";
                    break;

                  case 2:
                    n[r].carControl = "自动";
                }
            }
            e(n);
        });
    });
}, DoCarData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("DoCar", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, BranchOrderData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("BranchOrder", e).then(function(o) {
        return new Promise(function(e, t) {
            var n = o;
            for (var r in n) {
                switch (n[r].status) {
                  case "0":
                    n[r].payType = "已完成";
                    break;

                  case "1":
                    n[r].payType = "待支付";
                    break;

                  case "2":
                    n[r].payType = "已支付";
                    break;

                  case "3":
                    n[r].payType = "已取车";
                    break;

                  case "4":
                    n[r].payType = "已取消";
                }
                switch (n[r].carinfo.structure - 0) {
                  case 1:
                    n[r].carType = "两厢";
                    break;

                  case 2:
                    n[r].carType = "三厢";
                }
                switch (n[r].carinfo.grarbox - 0) {
                  case 1:
                    n[r].carControl = "手动";
                    break;

                  case 2:
                    n[r].carControl = "自动";
                }
                n[r].sdate = getDate(2, n[r].start_time), n[r].edate = getDate(2, n[r].end_time), 
                n[r].stime = getTime(2, n[r].start_time), n[r].etime = getTime(2, n[r].end_time), 
                n[r].sweek = "周" + "日一二三四五六".charAt(new Date(1e3 * n[r].start_time).getDay()), n[r].eweek = "周" + "日一二三四五六".charAt(new Date(1e3 * n[r].end_time).getDay());
            }
            e(n);
        });
    });
}, ReturnCarData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("ReturnCar", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, Userdcarlist = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("userdcarlist", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, Getcity = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("getcity", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, Getbrand = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("getbrand", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, Choosecity = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("choosecity", e).then(function(n) {
        return console.log(n), new Promise(function(e, t) {
            e(n);
        });
    });
}, Userdcar = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("userdcar", e).then(function(n) {
        return console.log(n), new Promise(function(e, t) {
            e(n);
        });
    });
}, Refund = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("refund", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, Refundcancel = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("refundcancel", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, OpenidData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Openid", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, SaveAvatarData = function(e) {
    return "object" !== (void 0 === e ? "undefined" : _typeof(e)) && (e = {}), (0, _rewx.post)("Login", e).then(function(n) {
        return new Promise(function(e, t) {
            e(n);
        });
    });
}, checkSessions = function() {
    return new Promise(function(e, t) {
        var n = wx.getStorageSync("userInfo");
        n.session_key ? wx.checkSession({
            success: function() {
                t(n);
            },
            fail: function() {
                n.session_key = "", wx.removeStorageSync("userInfo"), e();
            }
        }) : e();
    });
}, getUserInfo = function() {
    return checkSessions().then(function(e) {
        return Login();
    });
}, Login = function() {
    return new Promise(function(e, n) {
        var r = {
            openid: "",
            session_key: "",
            wxInfo: ""
        };
        wx.login({
            success: function(e) {
                var t = e.code;
                OpenidData({
                    code: t
                }).then(function(e) {
                    (e = JSON.parse(e)).openid ? (r.openid = e.openid, r.session_key = e.session_key, 
                    r.code = t, r.login = !1, wx.setStorageSync("userInfo", r), n(r)) : wx.showModal({
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
    return new Promise(function(t, e) {
        wx.getLocation({
            type: "wgs84",
            success: function(e) {
                t(e);
            },
            fail: function(e) {
                t(0);
            }
        });
    });
}, appPay = function(e) {
    return new Promise(function(n, r) {
        OrderarrData(e).then(function(e) {
            var t = e;
            wx.requestPayment({
                timeStamp: e.timeStamp,
                nonceStr: e.nonceStr,
                package: e.package,
                signType: e.signType,
                paySign: e.paySign,
                success: function(e) {
                    n(t);
                },
                fail: function(e) {
                    r(e);
                }
            });
        }, function(e) {
            wx.showToast({
                title: "支付调用失败！",
                icon: "none",
                duration: 1e3
            });
        });
    });
};

function getDate(e, t) {
    var n = null;
    return 0 == e ? n = new Date() : 1 == e ? (n = new Date()).setDate(n.getDate() + 1) : 2 == e ? n = new Date(1e3 * t) : 3 == e && (n = new Date(1e3 * t)).setDate(n.getDate() + 1), 
    n.getFullYear() + "-" + (9 < n.getMonth() + 1 ? n.getMonth() + 1 : "0" + (n.getMonth() + 1)) + "-" + (9 < n.getDate() ? n.getDate() : "0" + n.getDate());
}

function getTime(e, t) {
    var n = null;
    return 0 == e ? n = new Date() : 1 == e ? (n = new Date()).setDate(n.getDate() + 1) : 2 == e ? n = new Date(1e3 * t) : 3 == e && (n = new Date(1e3 * t)).setDate(n.getDate() + 1), 
    (9 < n.getHours() ? n.getHours() : "0" + n.getHours()) + ":" + (9 < n.getMinutes() ? n.getMinutes() : "0" + n.getMinutes());
}

function getTimeStr(e) {
    return e = (e = e.replace(/-/g, ":").replace(" ", ":")).split(":"), new Date(e[0], e[1] - 1, e[2], e[3], e[4]).getTime() / 1e3;
}

module.exports = {
    ColorData: ColorData,
    UrlData: UrlData,
    OpenidData: OpenidData,
    SaveAvatarData: SaveAvatarData,
    getUserInfo: getUserInfo,
    gps: gps,
    appPay: appPay,
    AdpicData: AdpicData,
    ShouyeData: ShouyeData,
    HomeSign: HomeSign,
    CouponListData: CouponListData,
    GetCouponData: GetCouponData,
    ActiveData: ActiveData,
    ActiveInfoData: ActiveInfoData,
    YdcarData: YdcarData,
    CheckOrdData: CheckOrdData,
    KycouponData: KycouponData,
    TaocanData: TaocanData,
    OrderData: OrderData,
    OrderarrData: OrderarrData,
    IsorderData: IsorderData,
    CityshopData: CityshopData,
    CartypeData: CartypeData,
    CarlistData: CarlistData,
    QrpicData: QrpicData,
    DelimgData: DelimgData,
    AllcityData: AllcityData,
    GetareaData: GetareaData,
    FjshopData: FjshopData,
    AreashopData: AreashopData,
    BranchData: BranchData,
    OrderInfoData: OrderInfoData,
    CancelData: CancelData,
    PaysuccessData: PaysuccessData,
    GetcarData: GetcarData,
    OrderListData: OrderListData,
    UsersData: UsersData,
    MemberData: MemberData,
    IntegralData: IntegralData,
    ExchangeData: ExchangeData,
    IntegralDetailsData: IntegralDetailsData,
    MycouponData: MycouponData,
    HelpsData: HelpsData,
    RuleData: RuleData,
    BranchCarlsitData: BranchCarlsitData,
    DoCarData: DoCarData,
    BranchOrderData: BranchOrderData,
    ReturnCarData: ReturnCarData,
    AdminInfoData: AdminInfoData,
    WeData: WeData,
    NavsetData: NavsetData,
    SupportData: SupportData,
    Choosecity: Choosecity,
    Getbrand: Getbrand,
    Getcity: Getcity,
    Userdcarlist: Userdcarlist,
    Userdcar: Userdcar,
    Refund: Refund,
    Refundcancel: Refundcancel
};