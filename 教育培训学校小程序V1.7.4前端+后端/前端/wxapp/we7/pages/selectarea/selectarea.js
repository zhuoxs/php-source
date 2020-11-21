var e = require("../utils/util"), t = "http://japi.zto.cn/zto/api_utf8/baseArea?msg_type=GET_AREA&data=", a = {
    addDot: function(e) {
        e instanceof Array && e.map(function(e) {
            return e.fullName.length > 4 ? (e.fullNameDot = e.fullName.slice(0, 4) + "...", 
            e) : (e.fullNameDot = e.fullName, e);
        });
    },
    load: function(d) {
        d.setData({
            isShow: !1
        }), (0, e.Promise)(wx.request, {
            url: t + "0",
            method: "GET"
        }).then(function(l) {
            var c = l.data.result[0];
            return a.addDot(l.data.result), d.setData({
                proviceData: l.data.result,
                "selectedProvince.index": 0,
                "selectedProvince.code": c.code,
                "selectedProvince.fullName": c.fullName
            }), (0, e.Promise)(wx.request, {
                url: t + c.code,
                method: "GET"
            });
        }).then(function(l) {
            var c = l.data.result[0];
            return a.addDot(l.data.result), d.setData({
                cityData: l.data.result,
                "selectedCity.index": 0,
                "selectedCity.code": c.code,
                "selectedCity.fullName": c.fullName
            }), (0, e.Promise)(wx.request, {
                url: t + c.code,
                method: "GET"
            });
        }).then(function(e) {
            var t = e.data.result[0];
            a.addDot(e.data.result), d.setData({
                districtData: e.data.result,
                "selectedDistrict.index": 0,
                "selectedDistrict.code": t.code,
                "selectedDistrict.fullName": t.fullName
            });
        }).catch(function(e) {
            console.log(e);
        });
    },
    tapProvince: function(d, l) {
        var c = d.currentTarget.dataset;
        (0, e.Promise)(wx.request, {
            url: t + c.code,
            method: "GET"
        }).then(function(d) {
            return a.addDot(d.data.result), l.setData({
                cityData: d.data.result,
                "selectedProvince.code": c.code,
                "selectedProvince.fullName": c.fullName,
                "selectedCity.code": d.data.result[0].code,
                "selectedCity.fullName": d.data.result[0].fullName
            }), (0, e.Promise)(wx.request, {
                url: t + d.data.result[0].code,
                method: "GET"
            });
        }).then(function(e) {
            a.addDot(e.data.result), l.setData({
                districtData: e.data.result,
                "selectedProvince.index": d.currentTarget.dataset.index,
                "selectedCity.index": 0,
                "selectedDistrict.index": 0,
                "selectedDistrict.code": e.data.result[0].code,
                "selectedDistrict.fullName": e.data.result[0].fullName
            });
        }).catch(function(e) {
            console.log(e);
        });
    },
    tapCity: function(d, l) {
        var c = d.currentTarget.dataset;
        (0, e.Promise)(wx.request, {
            url: t + c.code,
            method: "GET"
        }).then(function(e) {
            a.addDot(e.data.result), l.setData({
                districtData: e.data.result,
                "selectedCity.index": d.currentTarget.dataset.index,
                "selectedCity.code": c.code,
                "selectedCity.fullName": c.fullName,
                "selectedDistrict.index": 0,
                "selectedDistrict.code": e.data.result[0].code,
                "selectedDistrict.fullName": e.data.result[0].fullName
            });
        }).catch(function(e) {
            console.log(e);
        });
    },
    tapDistrict: function(e, t) {
        var a = e.currentTarget.dataset;
        t.setData({
            "selectedDistrict.index": e.currentTarget.dataset.index,
            "selectedDistrict.code": a.code,
            "selectedDistrict.fullName": a.fullName
        });
    },
    confirm: function(e, t) {
        t.setData({
            address: t.data.selectedProvince.fullName + " " + t.data.selectedCity.fullName + " " + t.data.selectedDistrict.fullName,
            isShow: !1
        });
    },
    cancel: function(e) {
        e.setData({
            isShow: !1
        });
    },
    choosearea: function(e) {
        e.setData({
            isShow: !0
        });
    }
};

module.exports = {
    SA: a
};