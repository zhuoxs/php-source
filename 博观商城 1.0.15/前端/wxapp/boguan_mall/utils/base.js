function e(e, t) {
    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
}

Object.defineProperty(exports, "__esModule", {
    value: !0
}), exports.Base = void 0;

var t = function() {
    function e(e, t) {
        for (var n = 0; n < t.length; n++) {
            var a = t[n];
            a.enumerable = a.enumerable || !1, a.configurable = !0, "value" in a && (a.writable = !0), 
            Object.defineProperty(e, a.key, a);
        }
    }
    return function(t, n, a) {
        return n && e(t.prototype, n), a && e(t, a), t;
    };
}(), n = require("token.js"), a = getApp(), o = require("../../siteinfo.js"), r = new (require("qqmap-wx-jssdk.js"))({
    key: "SEEBZ-CESW6-YFUSS-MG73T-36HG2-P4F7S"
}), u = function() {
    function u() {
        e(this, u);
    }
    return t(u, [ {
        key: "getDataSet",
        value: function(e, t) {
            return e.currentTarget.dataset[t];
        }
    }, {
        key: "Call",
        value: function(e) {
            wx.makePhoneCall({
                phoneNumber: e
            });
        }
    }, {
        key: "getUserCity",
        value: function(e) {
            wx.getLocation({
                type: "gcj02",
                success: function(t) {
                    t.latitude, t.longitude;
                    r.reverseGeocoder({
                        location: {
                            latitude: t.latitude,
                            longitude: t.longitude
                        },
                        success: function(t) {
                            var n = {
                                city: t.result.address_component.city,
                                latitude: t.result.ad_info.location.lat,
                                longitude: t.result.ad_info.location.lng
                            };
                            e && e(n);
                        },
                        fail: function(t) {
                            e && e(!1);
                        }
                    });
                },
                fail: function(t) {
                    e && e(!1);
                }
            });
        }
    }, {
        key: "geocoder",
        value: function(e, t) {
            r.geocoder({
                address: e,
                success: function(e) {
                    t && t(e);
                },
                fail: function(e) {
                    t && t(e);
                }
            });
        }
    }, {
        key: "clearPrice",
        value: function(e) {
            var t = e.toString();
            return this.amount = t.replace(/[^\d.]/g, ""), this.amount = this.amount.replace(/\.{2,}/g, "."), 
            this.amount = this.amount.replace(".", "$#$").replace(/\./g, "").replace("$#$", "."), 
            this.amount = this.amount.replace(/^(\-)*(\d+)\.(\d\d).*$/, "$1$2.$3"), this.amount.indexOf(".") < 0 && "" != this.amount && (this.amount = parseFloat(e)), 
            this.amount = this.amount.toString().replace(/^\./g, ""), this.amount;
        }
    }, {
        key: "toZero",
        value: function(e, t) {
            return console.log("去零数据类型=>", e.constructor, t), e;
        }
    }, {
        key: "checkPhone",
        value: function(e, t) {
            /^1[34578]\d{9}$/.test(e) ? t && t(!0) : t && t(!1);
        }
    }, {
        key: "getDateDays",
        value: function(e) {
            for (var t = this.getCurrentMonthFirst(), n = [], a = 0; a < e; a++) {
                var o = this.dateLater(t, a);
                n.push(o);
            }
            return n;
        }
    }, {
        key: "dateLater",
        value: function(e, t) {
            var n = {}, a = new Array("星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"), o = new Date(e);
            o.setDate(o.getDate() + t);
            var r = o.getDay();
            return n.year = o.getFullYear(), n.month = o.getMonth() + 1 < 10 ? o.getMonth() + 1 : o.getMonth(), 
            n.day = (o.getDate(), o.getDate()), n.week = a[r], n;
        }
    }, {
        key: "getCurrentMonthFirst",
        value: function() {
            var e = new Date();
            return e.getFullYear() + "-" + (e.getMonth() + 1 < 10 ? "0" + (e.getMonth() + 1) : e.getMonth()) + "-" + (e.getDate() < 10 ? "0" + e.getDate() : e.getDate());
        }
    }, {
        key: "getData",
        value: function(e, t, n) {
            var r = this;
            wx.request({
                url: a.globalData.api_root + e.url,
                data: e.data || {},
                method: e.method || "POST",
                header: {
                    "content-type": "application/json",
                    token: wx.getStorageSync("token"),
                    uniacid: o.uniacid
                },
                success: function(a) {
                    var o = a.statusCode.toString();
                    "2" == o.charAt(0) ? t && t(a.data) : ("401" == o && (n || r._refetch(e, t)), r._processError(a), 
                    t && t(a.data));
                },
                fail: function(e) {
                    r._processError(e), t && t(e);
                }
            });
        }
    }, {
        key: "_processError",
        value: function(e) {
            console.log("错误提示=>", e.data);
        }
    }, {
        key: "_refetch",
        value: function(e, t) {
            var o = this;
            new n.Token().getTokenFromServer(a.globalData.api_root, function(n) {
                console.log("第二次获取的token=>", n), o.getData(e, t, !0);
            });
        }
    } ]), u;
}();

exports.Base = u;