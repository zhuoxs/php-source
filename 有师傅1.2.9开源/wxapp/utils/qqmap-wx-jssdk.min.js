function e(e, t) {
    if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
}

var t = function() {
    function e(e, t) {
        for (var o = 0; o < t.length; o++) {
            var n = t[o];
            n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), 
            Object.defineProperty(e, n.key, n);
        }
    }
    return function(t, o, n) {
        return o && e(t.prototype, o), n && e(t, n), t;
    };
}(), o = {
    KEY_ERR: 311,
    KEY_ERR_MSG: "key格式错误",
    PARAM_ERR: 310,
    PARAM_ERR_MSG: "请求参数信息有误",
    SYSTEM_ERR: 600,
    SYSTEM_ERR_MSG: "系统错误",
    WX_ERR_CODE: 1e3,
    WX_OK_CODE: 200
}, n = "https://apis.map.qq.com/ws/", i = n + "place/v1/suggestion", a = {
    location2query: function(e) {
        if ("string" == typeof e) return e;
        for (var t = "", o = 0; o < e.length; o++) {
            var n = e[o];
            t && (t += ";"), n.location && (t = t + n.location.lat + "," + n.location.lng), 
            n.latitude && n.longitude && (t = t + n.latitude + "," + n.longitude);
        }
        return t;
    },
    rad: function(e) {
        return e * Math.PI / 180;
    },
    getEndLocation: function(e) {
        for (var t = e.split(";"), o = [], n = 0; n < t.length; n++) o.push({
            lat: parseFloat(t[n].split(",")[0]),
            lng: parseFloat(t[n].split(",")[1])
        });
        return o;
    },
    getDistance: function(e, t, o, n) {
        var i = this.rad(e), a = this.rad(o), s = i - a, l = this.rad(t) - this.rad(n), r = 2 * Math.asin(Math.sqrt(Math.pow(Math.sin(s / 2), 2) + Math.cos(i) * Math.cos(a) * Math.pow(Math.sin(l / 2), 2)));
        return r *= 6378136.49, r = Math.round(1e4 * r) / 1e4, parseFloat(r.toFixed(0));
    },
    getWXLocation: function(e, t, o) {
        wx.getLocation({
            type: "gcj02",
            success: e,
            fail: t,
            complete: o
        });
    },
    getLocationParam: function(e) {
        return "string" == typeof e && (e = 2 === e.split(",").length ? {
            latitude: e.split(",")[0],
            longitude: e.split(",")[1]
        } : {}), e;
    },
    polyfillParam: function(e) {
        e.success = e.success || function() {}, e.fail = e.fail || function() {}, e.complete = e.complete || function() {};
    },
    checkParamKeyEmpty: function(e, t) {
        if (!e[t]) {
            var n = this.buildErrorConfig(o.PARAM_ERR, o.PARAM_ERR_MSG + t + "参数格式有误");
            return e.fail(n), e.complete(n), !0;
        }
        return !1;
    },
    checkKeyword: function(e) {
        return !this.checkParamKeyEmpty(e, "keyword");
    },
    checkLocation: function(e) {
        var t = this.getLocationParam(e.location);
        if (!t || !t.latitude || !t.longitude) {
            var n = this.buildErrorConfig(o.PARAM_ERR, o.PARAM_ERR_MSG + " location参数格式有误");
            return e.fail(n), e.complete(n), !1;
        }
        return !0;
    },
    buildErrorConfig: function(e, t) {
        return {
            status: e,
            message: t
        };
    },
    handleData: function(e, t, o) {
        if ("search" === o) {
            for (var n = t.data, i = [], a = 0; a < n.length; a++) i.push({
                id: n[a].id || null,
                title: n[a].title || null,
                latitude: n[a].location && n[a].location.lat || null,
                longitude: n[a].location && n[a].location.lng || null,
                address: n[a].address || null,
                category: n[a].category || null,
                tel: n[a].tel || null,
                adcode: n[a].ad_info && n[a].ad_info.adcode || null,
                city: n[a].ad_info && n[a].ad_info.city || null,
                district: n[a].ad_info && n[a].ad_info.district || null,
                province: n[a].ad_info && n[a].ad_info.province || null
            });
            e.success(t, {
                searchResult: n,
                searchSimplify: i
            });
        } else if ("suggest" === o) {
            for (var s = t.data, l = [], a = 0; a < s.length; a++) l.push({
                adcode: s[a].adcode || null,
                address: s[a].address || null,
                category: s[a].category || null,
                city: s[a].city || null,
                district: s[a].district || null,
                id: s[a].id || null,
                latitude: s[a].location && s[a].location.lat || null,
                longitude: s[a].location && s[a].location.lng || null,
                province: s[a].province || null,
                title: s[a].title || null,
                type: s[a].type || null
            });
            e.success(t, {
                suggestResult: s,
                suggestSimplify: l
            });
        } else if ("reverseGeocoder" === o) {
            var r = t.result, c = {
                address: r.address || null,
                latitude: r.location && r.location.lat || null,
                longitude: r.location && r.location.lng || null,
                adcode: r.ad_info && r.ad_info.adcode || null,
                city: r.address_component && r.address_component.city || null,
                district: r.address_component && r.address_component.district || null,
                nation: r.address_component && r.address_component.nation || null,
                province: r.address_component && r.address_component.province || null,
                street: r.address_component && r.address_component.street || null,
                street_number: r.address_component && r.address_component.street_number || null,
                recommend: r.formatted_addresses && r.formatted_addresses.recommend || null,
                rough: r.formatted_addresses && r.formatted_addresses.rough || null
            };
            if (r.pois) {
                for (var u = r.pois, d = [], a = 0; a < u.length; a++) d.push({
                    id: u[a].id || null,
                    title: u[a].title || null,
                    latitude: u[a].location && u[a].location.lat || null,
                    longitude: u[a].location && u[a].location.lng || null,
                    address: u[a].address || null,
                    category: u[a].category || null,
                    adcode: u[a].ad_info && u[a].ad_info.adcode || null,
                    city: u[a].ad_info && u[a].ad_info.city || null,
                    district: u[a].ad_info && u[a].ad_info.district || null,
                    province: u[a].ad_info && u[a].ad_info.province || null
                });
                e.success(t, {
                    reverseGeocoderResult: r,
                    reverseGeocoderSimplify: c,
                    pois: u,
                    poisSimplify: d
                });
            } else e.success(t, {
                reverseGeocoderResult: r,
                reverseGeocoderSimplify: c
            });
        } else if ("geocoder" === o) {
            var f = t.result, p = {
                title: f.title || null,
                latitude: f.location && f.location.lat || null,
                longitude: f.location && f.location.lng || null,
                adcode: f.ad_info && f.ad_info.adcode || null,
                province: f.address_components && f.address_components.province || null,
                city: f.address_components && f.address_components.city || null,
                district: f.address_components && f.address_components.district || null,
                street: f.address_components && f.address_components.street || null,
                street_number: f.address_components && f.address_components.street_number || null,
                level: f.level || null
            };
            e.success(t, {
                geocoderResult: f,
                geocoderSimplify: p
            });
        } else if ("getCityList" === o) {
            var g = t.result[0], _ = t.result[1], m = t.result[2];
            e.success(t, {
                provinceResult: g,
                cityResult: _,
                districtResult: m
            });
        } else if ("getDistrictByCityId" === o) {
            var y = t.result[0];
            e.success(t, y);
        } else if ("calculateDistance" === o) {
            for (var h = t.result.elements, v = [], a = 0; a < h.length; a++) v.push(h[a].distance);
            e.success(t, {
                calculateDistanceResult: h,
                distance: v
            });
        } else e.success(t);
    },
    buildWxRequestConfig: function(e, t, n) {
        var i = this;
        return t.header = {
            "content-type": "application/json"
        }, t.method = "GET", t.success = function(t) {
            var o = t.data;
            0 === o.status ? i.handleData(e, o, n) : e.fail(o);
        }, t.fail = function(t) {
            t.statusCode = o.WX_ERR_CODE, e.fail(i.buildErrorConfig(o.WX_ERR_CODE, t.errMsg));
        }, t.complete = function(t) {
            switch (+t.statusCode) {
              case o.WX_ERR_CODE:
                e.complete(i.buildErrorConfig(o.WX_ERR_CODE, t.errMsg));
                break;

              case o.WX_OK_CODE:
                var n = t.data;
                0 === n.status ? e.complete(n) : e.complete(i.buildErrorConfig(n.status, n.message));
                break;

              default:
                e.complete(i.buildErrorConfig(o.SYSTEM_ERR, o.SYSTEM_ERR_MSG));
            }
        }, t;
    },
    locationProcess: function(e, t, n, i) {
        var s = this;
        n = n || function(t) {
            t.statusCode = o.WX_ERR_CODE, e.fail(s.buildErrorConfig(o.WX_ERR_CODE, t.errMsg));
        }, i = i || function(t) {
            t.statusCode == o.WX_ERR_CODE && e.complete(s.buildErrorConfig(o.WX_ERR_CODE, t.errMsg));
        }, e.location ? s.checkLocation(e) && t(a.getLocationParam(e.location)) : s.getWXLocation(t, n, i);
    }
}, s = function() {
    function o(t) {
        if (e(this, o), !t.key) throw Error("key值不能为空");
        this.key = t.key;
    }
    return t(o, [ {
        key: "search",
        value: function(e) {
            var t = this;
            if (e = e || {}, a.polyfillParam(e), a.checkKeyword(e)) {
                var o = {
                    keyword: e.keyword,
                    orderby: e.orderby || "_distance",
                    page_size: e.page_size || 10,
                    page_index: e.page_index || 1,
                    output: "json",
                    key: t.key
                };
                e.address_format && (o.address_format = e.address_format), e.filter && (o.filter = e.filter);
                var n = e.distance || "1000", i = e.auto_extend || 1, s = null, l = null;
                e.region && (s = e.region), e.rectangle && (l = e.rectangle);
                a.locationProcess(e, function(t) {
                    o.boundary = s && !l ? "region(" + s + "," + i + "," + t.latitude + "," + t.longitude + ")" : l && !s ? "rectangle(" + l + ")" : "nearby(" + t.latitude + "," + t.longitude + "," + n + "," + i + ")", 
                    wx.request(a.buildWxRequestConfig(e, {
                        url: "https://apis.map.qq.com/ws/place/v1/search",
                        data: o
                    }, "search"));
                });
            }
        }
    }, {
        key: "getSuggestion",
        value: function(e) {
            var t = this;
            if (e = e || {}, a.polyfillParam(e), a.checkKeyword(e)) {
                var o = {
                    keyword: e.keyword,
                    region: e.region || "全国",
                    region_fix: e.region_fix || 0,
                    policy: e.policy || 0,
                    page_size: e.page_size || 10,
                    page_index: e.page_index || 1,
                    get_subpois: e.get_subpois || 0,
                    output: "json",
                    key: t.key
                };
                if (e.address_format && (o.address_format = e.address_format), e.filter && (o.filter = e.filter), 
                e.location) {
                    a.locationProcess(e, function(t) {
                        o.location = t.latitude + "," + t.longitude, wx.request(a.buildWxRequestConfig(e, {
                            url: i,
                            data: o
                        }, "suggest"));
                    });
                } else wx.request(a.buildWxRequestConfig(e, {
                    url: i,
                    data: o
                }, "suggest"));
            }
        }
    }, {
        key: "reverseGeocoder",
        value: function(e) {
            var t = this;
            e = e || {}, a.polyfillParam(e);
            var o = {
                coord_type: e.coord_type || 5,
                get_poi: e.get_poi || 0,
                output: "json",
                key: t.key
            };
            e.poi_options && (o.poi_options = e.poi_options);
            a.locationProcess(e, function(t) {
                o.location = t.latitude + "," + t.longitude, wx.request(a.buildWxRequestConfig(e, {
                    url: "https://apis.map.qq.com/ws/geocoder/v1/",
                    data: o
                }, "reverseGeocoder"));
            });
        }
    }, {
        key: "geocoder",
        value: function(e) {
            var t = this;
            if (e = e || {}, a.polyfillParam(e), !a.checkParamKeyEmpty(e, "address")) {
                var o = {
                    address: e.address,
                    output: "json",
                    key: t.key
                };
                e.region && (o.region = e.region), wx.request(a.buildWxRequestConfig(e, {
                    url: "https://apis.map.qq.com/ws/geocoder/v1/",
                    data: o
                }, "geocoder"));
            }
        }
    }, {
        key: "getCityList",
        value: function(e) {
            var t = this;
            e = e || {}, a.polyfillParam(e);
            var o = {
                output: "json",
                key: t.key
            };
            wx.request(a.buildWxRequestConfig(e, {
                url: "https://apis.map.qq.com/ws/district/v1/list",
                data: o
            }, "getCityList"));
        }
    }, {
        key: "getDistrictByCityId",
        value: function(e) {
            var t = this;
            if (e = e || {}, a.polyfillParam(e), !a.checkParamKeyEmpty(e, "id")) {
                var o = {
                    id: e.id || "",
                    output: "json",
                    key: t.key
                };
                wx.request(a.buildWxRequestConfig(e, {
                    url: "https://apis.map.qq.com/ws/district/v1/getchildren",
                    data: o
                }, "getDistrictByCityId"));
            }
        }
    }, {
        key: "calculateDistance",
        value: function(e) {
            var t = this;
            if (e = e || {}, a.polyfillParam(e), !a.checkParamKeyEmpty(e, "to")) {
                var o = {
                    mode: e.mode || "walking",
                    to: a.location2query(e.to),
                    output: "json",
                    key: t.key
                };
                if (e.from && (e.location = e.from), "straight" == o.mode) {
                    n = function(t) {
                        for (var n = a.getEndLocation(o.to), i = {
                            message: "query ok",
                            result: {
                                elements: []
                            },
                            status: 0
                        }, s = 0; s < n.length; s++) i.result.elements.push({
                            distance: a.getDistance(t.latitude, t.longitude, n[s].lat, n[s].lng),
                            duration: 0,
                            from: {
                                lat: t.latitude,
                                lng: t.longitude
                            },
                            to: {
                                lat: n[s].lat,
                                lng: n[s].lng
                            }
                        });
                        for (var l = i.result.elements, r = [], s = 0; s < l.length; s++) r.push(l[s].distance);
                        return e.success(i, {
                            calculateResult: l,
                            distanceResult: r
                        });
                    };
                    a.locationProcess(e, n);
                } else {
                    var n = function(t) {
                        o.from = t.latitude + "," + t.longitude, wx.request(a.buildWxRequestConfig(e, {
                            url: "https://apis.map.qq.com/ws/distance/v1/",
                            data: o
                        }, "calculateDistance"));
                    };
                    a.locationProcess(e, n);
                }
            }
        }
    } ]), o;
}();

module.exports = s;