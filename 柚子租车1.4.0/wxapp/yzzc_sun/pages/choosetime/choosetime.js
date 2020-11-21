var _extends = Object.assign || function(t) {
    for (var e = 1; e < arguments.length; e++) {
        var a = arguments[e];
        for (var i in a) Object.prototype.hasOwnProperty.call(a, i) && (t[i] = a[i]);
    }
    return t;
}, _reload = require("../../common/js/reload.js"), _api = require("../../common/js/api.js");

function _defineProperty(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var app = getApp();

function getDate(t, e, a) {
    var i = null;
    return 0 == t ? i = new Date() : 1 == t ? (i = new Date()).setDate(i.getDate() + e) : 2 == t ? i = new Date(1e3 * a) : 3 == t && (i = new Date(1e3 * a)).setDate(i.getDate() + e), 
    i.getFullYear() + "-" + (9 < i.getMonth() + 1 ? i.getMonth() + 1 : "0" + (i.getMonth() + 1)) + "-" + (9 < i.getDate() ? i.getDate() : "0" + i.getDate());
}

function getTime(t, e, a) {
    var i = null;
    return 0 == t ? i = new Date() : 1 == t ? (i = new Date()).setDate(i.getDate() + e) : 2 == t ? i = new Date(1e3 * a) : 3 == t && (i = new Date(1e3 * a)).setDate(i.getDate() + e), 
    (9 < i.getHours() ? i.getHours() : "0" + i.getHours()) + ":" + (9 < i.getMinutes() ? i.getMinutes() : "0" + i.getMinutes());
}

function getTimeStr(t) {
    return t = (t = t.replace(/-/g, ":").replace(" ", ":")).split(":"), new Date(t[0], t[1] - 1, t[2], t[3], t[4]).getTime() / 1e3;
}

Page(_extends({}, _reload.reload, {
    data: {
        login: !0,
        gps: !0,
        imgLink: wx.getStorageSync("url"),
        showAdmire: !1,
        closeMask: !1,
        preventCheck: !1,
        table: 0,
        citys: [],
        cityIndex: 0,
        shops: [],
        shopIndex: 0,
        startDate: "2016-09-01",
        startTime: "12:01",
        endDate: "2016-09-01",
        endTime: "12:01",
        minDate: "",
        minTime: "",
        mealList: [],
        chooseNav: 0,
        goHome: 0,
        gettype: 1,
        hidePage: !1
    },
    onLoad: function(t) {
        this.setData({
            options: t
        });
    },
    onloadData: function(t) {
        var s = this;
        t.detail.login && this.checkUrl().then(function(t) {
            if ("2" === s.data.options.table) (0, _api.TaocanData)().then(function(t) {
                t.length < 1 && (s.setData({
                    hidePage: !0
                }), wx.showModal({
                    content: "暂无套餐！",
                    showCancel: !1,
                    confirmText: "朕知道了",
                    success: function(t) {
                        wx.redirectTo({
                            url: "../home/home"
                        });
                    }
                })), console.log(t);
                var e = getDate(0), a = getDate(1, t[0].day - 0);
                s.setData({
                    chooseDay: t[0].day - 0,
                    mealList: t,
                    table: s.data.options.table,
                    startDate: getDate(0),
                    startTime: getTime(0),
                    startWeek: "周" + "日一二三四五六".charAt(new Date(e).getDay()),
                    endDate: getDate(1, t[0].day - 0),
                    endTime: getTime(1, t[0].day - 0),
                    endWeek: "周" + "日一二三四五六".charAt(new Date(a).getDay()),
                    durationD: t[0].day - 0,
                    minStartDate: getDate(0),
                    minDate: getDate(1, t[0].day - 0),
                    minTime: getTime(1, t[0].day - 0)
                }), console.log(getDate(1, t[0].day - 0));
            }, function(t) {
                console.log("err" + t);
            }); else {
                var e = getDate(0), a = getDate(1, 1);
                s.setData({
                    chooseDay: 1,
                    table: s.data.options.table,
                    startDate: getDate(0),
                    startTime: getTime(0),
                    startWeek: "周" + "日一二三四五六".charAt(new Date(e).getDay()),
                    endDate: getDate(1, 1),
                    endTime: getTime(1, 1),
                    endWeek: "周" + "日一二三四五六".charAt(new Date(a).getDay()),
                    durationD: 1,
                    minStartDate: getDate(0),
                    minDate: getDate(1, 1),
                    minTime: getTime(1, 1)
                }), console.log(getDate(1, 1));
            }
            if ("5" === s.data.options.table && s.loadGPS().then(function(t) {
                0 !== t && (s.setData({
                    lat: t.latitude,
                    lng: t.longitude
                }), s.setData({
                    gps: t,
                    goHome: 1,
                    gettype: 2
                }), s.getNearList());
            }).catch(function(t) {
                -1 === t.code ? s.tips(t.msg) : s.tips("false");
            }), "1" === s.data.options.table) s.setData({
                preventCheck: !0
            }), (0, _api.YdcarData)({
                cid: s.data.options.cid
            }).then(function(t) {
                s.setData({
                    msg: t,
                    shops: [ {
                        shopName: t.shopName
                    } ],
                    citys: [ {
                        fullname: t.shopinfo.city_name
                    } ]
                });
            }, function(t) {
                console.log("err" + t);
            }); else if ("6" === s.data.options.table) {
                var i, n = JSON.parse(s.data.options.param);
                s.setData((_defineProperty(i = {
                    param: n,
                    preventCheck: !0
                }, "param", JSON.parse(s.data.options.param)), _defineProperty(i, "shops", [ {
                    shopName: n.name
                } ]), _defineProperty(i, "citys", [ {
                    fullname: n.city
                } ]), i));
            } else "2" !== s.data.options.table && "3" !== s.data.options.table && "4" !== s.data.options.table || (0, 
            _api.AllcityData)().then(function(t) {
                s.setData({
                    citys: t
                }), (0, _api.CityshopData)({
                    code: t[0].city
                }).then(function(t) {
                    s.setData({
                        shops: t
                    });
                }, function(t) {
                    console.log("err" + t);
                });
            }, function(t) {
                console.log("err" + t);
            });
        }).catch(function(t) {
            -1 === t.code ? s.tips(t.msg) : s.tips("false");
        });
    },
    getNearList: function() {
        var e = this, a = this, t = {
            lat: this.data.lat,
            lng: this.data.lng
        };
        (0, _api.FjshopData)(t).then(function(t) {
            console.log(t), e.setData({
                shops: t,
                citys: [ {
                    fullname: "附近"
                } ]
            }), t.length < 1 && (e.setData(_defineProperty({
                showAdmire: !0
            }, "options.table", "4")), wx.showModal({
                title: "提示",
                content: "暂无配送范围内的门店",
                success: function(t) {
                    t.confirm && a.onloadData({
                        detail: {
                            login: 1
                        }
                    });
                }
            })), !1 === t && wx.showModal({
                title: "提示",
                content: "暂无配送范围内的门店",
                showCancel: !1,
                success: function(t) {
                    t.confirm && wx.reLaunch({
                        url: "../home/home"
                    });
                }
            });
        }, function(t) {
            console.log("err" + t);
        });
    },
    bindPickerCity: function(t) {
        var e = this;
        this.setData({
            cityIndex: t.detail.value
        }), (0, _api.CityshopData)({
            code: this.data.citys[t.detail.value].city
        }).then(function(t) {
            e.setData({
                shops: t
            });
        }, function(t) {
            console.log("err" + t);
        });
    },
    bindPickerChange: function(t) {
        this.setData({
            shopIndex: t.detail.value
        });
    },
    bindStartDateChange: function(t) {
        console.log(t);
        var e = getTimeStr(t.detail.value + " " + this.data.startTime), a = getTimeStr(this.data.endDate + " " + this.data.endTime), i = null;
        a < e + 86400 * this.data.chooseDay ? (this.setData({
            startDate: t.detail.value,
            endDate: getDate(3, this.data.chooseDay, e),
            endTime: this.data.startTime
        }), i = this.data.chooseDay) : (this.setData({
            startDate: t.detail.value
        }), i = ((a - e) / 86400).toFixed(0)), this.setData({
            minDate: getDate(3, this.data.chooseDay, e),
            minTime: getTime(3, this.data.chooseDay, e),
            durationD: i,
            startWeek: "周" + "日一二三四五六".charAt(new Date(1e3 * e).getDay())
        });
    },
    bindStartTimeChange: function(t) {
        var e, a = getTimeStr(this.data.startDate + " " + t.detail.value);
        getTimeStr(this.data.endDate + " " + this.data.endTime);
        this.setData({
            startTime: t.detail.value,
            endDate: getDate(3, this.data.chooseDay, a),
            endTime: t.detail.value
        }), e = this.data.chooseDay, this.setData({
            minDate: getDate(3, this.data.chooseDay, a),
            minTime: getTime(3, this.data.chooseDay, a),
            durationD: e
        });
    },
    bindEndDateChange: function(t) {
        var e = getTimeStr(this.data.startDate + " " + this.data.startTime), a = getTimeStr(t.detail.value + " " + this.data.endTime), i = ((a - e) / 86400).toFixed(0);
        this.setData({
            endDate: t.detail.value,
            durationD: i,
            endWeek: "周" + "日一二三四五六".charAt(new Date(1e3 * a).getDay())
        });
    },
    bindEndTimeChange: function(t) {
        var e = getTimeStr(this.data.startDate + " " + this.data.startTime), a = ((getTimeStr(this.data.endDate + " " + t.detail.value) - e) / 86400).toFixed(0);
        this.setData({
            endTime: t.detail.value,
            durationD: a + .5
        });
    },
    onSendTab: function(t) {
        var e = this, a = getTimeStr(this.data.startDate + " " + this.data.startTime), i = getTimeStr(this.data.endDate + " " + this.data.endTime), n = {
            uid: wx.getStorageSync("userInfo").wxInfo.id,
            start_time: a,
            end_time: i,
            day: this.data.durationD,
            startDate: this.data.startDate,
            endDate: this.data.endDate,
            startTime: this.data.startTime,
            endTime: this.data.endTime,
            startWeek: this.data.startWeek,
            endWeek: this.data.endWeek,
            gettype: this.data.gettype,
            active: 0
        };
        if ("1" === this.data.table) {
            n.type = 1, n.cid = this.data.msg.id, n.carnum = this.data.msg.carnum, n.shopname = this.data.msg.shopinfo.city_name + "-" + this.data.msg.shopinfo.area_name + "-" + this.data.msg.shopinfo.name, 
            n.carType = this.data.msg.carType, n.carControl = this.data.msg.carControl;
            var s = JSON.stringify(n);
            (0, _api.IsorderData)({
                cid: this.data.msg.id,
                carnum: this.data.msg.carnum,
                uid: wx.getStorageSync("userInfo").wxInfo.id,
                stime: a,
                etime: i
            }).then(function(t) {
                e.navTo("../checkorder/checkorder?param=" + s);
            }, function(t) {
                -1 === t.code ? e.navTo("../orderinfo/orderinfo?oid=" + t.data.oid + "&table=1") : wx.showModal({
                    title: "提示",
                    content: t.msg,
                    showCancel: !1
                });
            });
        } else {
            "6" === this.data.table ? n.sid = this.data.param.sid : n.sid = this.data.shops[this.data.shopIndex].id, 
            n.type = 1, "2" === this.data.table ? (n.type = 2, n.typeid = this.data.mealList[this.data.chooseNav].id, 
            n.mealMoney = this.data.mealList[this.data.chooseNav].money) : "3" === this.data.table && (n.active = 1), 
            console.log(n);
            var o = JSON.stringify(n);
            this.navTo("../choosecar/choosecar?param=" + o);
        }
    },
    onNavTab: function(t) {
        var e = t.currentTarget.dataset.idx;
        this.setData({
            chooseNav: e
        });
        var a = this.data.mealList[e].day - 0, i = getDate(0), n = getDate(1, a);
        this.setData({
            chooseDay: a,
            startDate: getDate(0),
            startTime: getTime(0),
            startWeek: "周" + "日一二三四五六".charAt(new Date(i).getDay()),
            endDate: getDate(1, a),
            endTime: getTime(1, a),
            endWeek: "周" + "日一二三四五六".charAt(new Date(n).getDay()),
            durationD: a,
            minStartDate: getDate(0),
            minDate: getDate(1, a),
            minTime: getTime(1, a)
        });
    },
    onCloseMaskTab: function() {
        this.setData({
            closeMask: !this.data.closeMask
        });
    },
    closeLocal: function() {
        this.setData({
            gps: !this.data.gps
        }), this.lunchTo("../home/home");
    },
    getGPS: function(t) {
        var e = this;
        t.detail.authSetting["scope.userLocation"] ? (this.setData({
            gps: !0,
            showPage: !0
        }), this.loadGPS().then(function(t) {
            e.data.gps && e.setData({
                lat: t.latitude,
                lng: t.longitude
            }), e.onloadData({
                detail: {
                    login: 1
                }
            });
        })) : this.setData({
            gps: !1
        }), t.detail.authSetting["scope.userInfo"] || this.setData({
            login: !1
        });
    },
    loadGPS: function() {
        var i = this;
        if (wx.getStorageSync("gps")) {
            var t = new Date().getTime();
            return wx.getStorageSync("gps").time - 0 + 72e5 < t ? (0, _api.gps)().then(function(a) {
                return 0 === a ? (i.setData({
                    gps: !1
                }), new Promise(function(t, e) {
                    t(0);
                })) : (i.setData({
                    gps: !0
                }), a.time = new Date().getTime(), wx.setStorageSync("gps", a), new Promise(function(t, e) {
                    t(a);
                }));
            }) : new Promise(function(t, e) {
                i.setData({
                    gps: !0
                }), t(wx.getStorageSync("gps"));
            });
        }
        return (0, _api.gps)().then(function(a) {
            return 0 === a ? (i.setData({
                gps: !1
            }), new Promise(function(t, e) {
                t(0);
            })) : (i.setData({
                gps: !0
            }), a.time = new Date().getTime(), wx.setStorageSync("gps", a), new Promise(function(t, e) {
                t(a);
            }));
        });
    }
}));