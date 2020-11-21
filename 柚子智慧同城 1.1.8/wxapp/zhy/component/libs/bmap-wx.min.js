function t(t, a) {
    if (!(t instanceof a)) throw new TypeError("Cannot call a class as a function");
}

var a = function() {
    function t(t, a) {
        for (var e = 0; e < a.length; e++) {
            var i = a[e];
            i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), 
            Object.defineProperty(t, i.key, i);
        }
    }
    return function(a, e, i) {
        return e && t(a.prototype, e), i && t(a, i), a;
    };
}(), e = function() {
    function e(a) {
        t(this, e), this.ak = a.ak;
    }
    return a(e, [ {
        key: "getWXLocation",
        value: function(t, a, e, i) {
            t = t || "gcj02", a = a || function() {}, e = e || function() {}, i = i || function() {}, 
            wx.getLocation({
                type: t,
                success: a,
                fail: e,
                complete: i
            });
        }
    }, {
        key: "search",
        value: function(t) {
            var a = this, e = {
                query: (t = t || {}).query || "生活服务$美食&酒店",
                scope: t.scope || 1,
                filter: t.filter || "",
                coord_type: t.coord_type || 2,
                page_size: t.page_size || 10,
                page_num: t.page_num || 0,
                output: t.output || "json",
                ak: a.ak,
                sn: t.sn || "",
                timestamp: t.timestamp || "",
                radius: t.radius || 2e3,
                ret_coordtype: "gcj02ll"
            }, i = {
                iconPath: t.iconPath,
                iconTapPath: t.iconTapPath,
                width: t.width,
                height: t.height,
                alpha: t.alpha || 1,
                success: t.success || function() {},
                fail: t.fail || function() {}
            }, n = function(t) {
                e.location = t.latitude + "," + t.longitude, wx.request({
                    url: "https://api.map.baidu.com/place/v2/search",
                    data: e,
                    header: {
                        "content-type": "application/json"
                    },
                    method: "GET",
                    success: function(t) {
                        var a = t.data;
                        if (0 === a.status) {
                            var e = a.results, n = {};
                            n.originalData = a, n.wxMarkerData = [];
                            for (var o = 0; o < e.length; o++) n.wxMarkerData[o] = {
                                id: o,
                                latitude: e[o].location.lat,
                                longitude: e[o].location.lng,
                                title: e[o].name,
                                iconPath: i.iconPath,
                                iconTapPath: i.iconTapPath,
                                address: e[o].address,
                                telephone: e[o].telephone,
                                alpha: i.alpha,
                                width: i.width,
                                height: i.height
                            };
                            i.success(n);
                        } else i.fail({
                            errMsg: a.message,
                            statusCode: a.status
                        });
                    },
                    fail: function(t) {
                        i.fail(t);
                    }
                });
            };
            if (t.location) {
                var o = t.location.split(",")[1];
                n({
                    errMsg: "input location",
                    latitude: t.location.split(",")[0],
                    longitude: o
                });
            } else a.getWXLocation("gcj02", n, function(t) {
                i.fail(t);
            }, function() {});
        }
    }, {
        key: "suggestion",
        value: function(t) {
            var a = this, e = {
                query: (t = t || {}).query || "",
                region: t.region || "全国",
                city_limit: t.city_limit || !1,
                output: t.output || "json",
                ak: a.ak,
                sn: t.sn || "",
                timestamp: t.timestamp || "",
                ret_coordtype: "gcj02ll"
            }, i = {
                success: t.success || function() {},
                fail: t.fail || function() {}
            };
            wx.request({
                url: "https://api.map.baidu.com/place/v2/suggestion",
                data: e,
                header: {
                    "content-type": "application/json"
                },
                method: "GET",
                success: function(t) {
                    var a = t.data;
                    0 === a.status ? i.success(a) : i.fail({
                        errMsg: a.message,
                        statusCode: a.status
                    });
                },
                fail: function(t) {
                    i.fail(t);
                }
            });
        }
    }, {
        key: "regeocoding",
        value: function(t) {
            var a = this, e = {
                coordtype: (t = t || {}).coordtype || "gcj02ll",
                pois: t.pois || 0,
                output: t.output || "json",
                ak: a.ak,
                sn: t.sn || "",
                timestamp: t.timestamp || "",
                ret_coordtype: "gcj02ll"
            }, i = {
                iconPath: t.iconPath,
                iconTapPath: t.iconTapPath,
                width: t.width,
                height: t.height,
                alpha: t.alpha || 1,
                success: t.success || function() {},
                fail: t.fail || function() {}
            }, n = function(t) {
                e.location = t.latitude + "," + t.longitude, wx.request({
                    url: "https://api.map.baidu.com/geocoder/v2/",
                    data: e,
                    header: {
                        "content-type": "application/json"
                    },
                    method: "GET",
                    success: function(a) {
                        var e = a.data;
                        if (0 === e.status) {
                            var n = e.result, o = {};
                            o.originalData = e, o.wxMarkerData = [], o.wxMarkerData[0] = {
                                id: 0,
                                latitude: t.latitude,
                                longitude: t.longitude,
                                address: n.formatted_address,
                                iconPath: i.iconPath,
                                iconTapPath: i.iconTapPath,
                                desc: n.sematic_description,
                                business: n.business,
                                alpha: i.alpha,
                                width: i.width,
                                height: i.height
                            }, i.success(o);
                        } else i.fail({
                            errMsg: e.message,
                            statusCode: e.status
                        });
                    },
                    fail: function(t) {
                        i.fail(t);
                    }
                });
            };
            if (t.location) {
                var o = t.location.split(",")[1];
                n({
                    errMsg: "input location",
                    latitude: t.location.split(",")[0],
                    longitude: o
                });
            } else a.getWXLocation("gcj02", n, function(t) {
                i.fail(t);
            }, function() {});
        }
    }, {
        key: "weather",
        value: function(t) {
            var a = this, e = {
                coord_type: (t = t || {}).coord_type || "gcj02",
                output: t.output || "json",
                ak: a.ak,
                sn: t.sn || "",
                timestamp: t.timestamp || ""
            }, i = {
                success: t.success || function() {},
                fail: t.fail || function() {}
            }, n = function(t) {
                e.location = t.longitude + "," + t.latitude, wx.request({
                    url: "https://api.map.baidu.com/telematics/v3/weather",
                    data: e,
                    header: {
                        "content-type": "application/json"
                    },
                    method: "GET",
                    success: function(t) {
                        var a = t.data;
                        if (0 === a.error && "success" === a.status) {
                            var e = a.results, n = {};
                            n.originalData = a, n.currentWeather = [], n.currentWeather[0] = {
                                currentCity: e[0].currentCity,
                                pm25: e[0].pm25,
                                date: e[0].weather_data[0].date,
                                temperature: e[0].weather_data[0].temperature,
                                weatherDesc: e[0].weather_data[0].weather,
                                wind: e[0].weather_data[0].wind
                            }, i.success(n);
                        } else i.fail({
                            errMsg: a.message,
                            statusCode: a.status
                        });
                    },
                    fail: function(t) {
                        i.fail(t);
                    }
                });
            };
            if (t.location) {
                var o = t.location.split(",")[0];
                n({
                    errMsg: "input location",
                    latitude: t.location.split(",")[1],
                    longitude: o
                });
            } else a.getWXLocation("gcj02", n, function(t) {
                i.fail(t);
            }, function() {});
        }
    } ]), e;
}();

module.exports.BMapWX = e;