var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var i in e) Object.prototype.hasOwnProperty.call(e, i) && (t[i] = e[i]);
    }
    return t;
}, _reload = require("../../common/js/reload.js"), _api = require("../../common/js/api.js");

function _defineProperty(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t;
}

var app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        show: !1,
        imgLink: wx.getStorageSync("url"),
        navList: [],
        chooseNav: 0,
        list: {
            load: !1,
            over: !1,
            page: 1,
            length: 10,
            none: !1,
            data: []
        },
        sort: "asc",
        first: 0,
        details: [],
        click: !0
    },
    onLoad: function(t) {
        this.setData({
            options: t
        });
    },
    onloadData: function(t) {
        var a = this, e = JSON.parse(this.data.options.param);
        this.setData({
            param: e
        }), console.log(e), t.detail.login && (this.data.first = 1, this.setData({
            show: !0
        }), this.checkUrl().then(function(t) {
            return (0, _api.CartypeData)();
        }).then(function(t) {
            a.setData({
                navList: t
            }), a.getListData();
        }).catch(function(t) {
            -1 === t.code ? a.tips(t.msg) : a.tips("false");
        }));
    },
    onShow: function() {
        1 == this.data.first && this.onloadData({
            detail: {
                login: 1
            }
        });
    },
    getListData: function() {
        var o = this;
        if (this.data.click) {
            if (this.setData({
                click: !1
            }), this.data.list.over) return void this.setData({
                click: !0
            });
            this.setData(_defineProperty({}, "list.load", !0));
            var t = {
                page: this.data.list.page,
                length: this.data.list.length,
                sid: this.data.param.sid,
                cartype: this.data.navList[this.data.chooseNav].id,
                sort: this.data.sort,
                stime: this.data.param.start_time,
                etime: this.data.param.end_time
            };
            (0, _api.CarlistData)(t).then(function(e) {
                var t;
                console.log(e), e.res = Object.values(e.res);
                for (var a = 0; a < e.res.length; a++) e.res[a].show_money = ((e.res[a].money - 0) * o.data.param.mealMoney / 100).toFixed(2);
                1 == o.data.list.page && o.setData({
                    list: {
                        load: !1,
                        over: !1,
                        page: 1,
                        length: 10,
                        none: !1,
                        data: []
                    }
                });
                var i = o.data.list.data.concat(e.res), s = o.data.details.concat(e.res1);
                return e.res.length < o.data.list.length && o.setData(_defineProperty({}, "list.over", !0)), 
                0 === i.length && o.setData(_defineProperty({}, "list.none", !0)), o.setData((_defineProperty(t = {}, "list.load", !1), 
                _defineProperty(t, "list.page", ++o.data.list.page), _defineProperty(t, "list.data", i), 
                _defineProperty(t, "details", s), t)), new Promise(function(t, a) {
                    t(e);
                });
            }).then(function(t) {
                console.log(t);
                for (var a = 0; a < t.res.length; a++) t.res[a].n_money = parseFloat(t.res[a].money * t.res[a].mealMoney / 100).toFixed(2);
                o.setData({
                    click: !0
                });
            }).catch(function(t) {
                -1 == t.code ? o.tips(t.msg) : o.tips("false"), o.setData({
                    click: !0
                });
            });
        }
    },
    onReachBottom: function() {
        this.getListData();
    },
    onNavTab: function(t) {
        var a = t.currentTarget.dataset.idx;
        this.setData({
            chooseNav: a
        }), this.setData({
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                none: !1,
                data: []
            },
            details: []
        }), this.getListData();
    },
    changeRank: function() {
        "asc" == this.data.sort ? this.setData({
            sort: "desc"
        }) : this.setData({
            sort: "asc"
        }), this.setData({
            list: {
                load: !1,
                over: !1,
                page: 1,
                length: 10,
                none: !1,
                data: []
            }
        }), this.getListData();
    },
    onSendTab: function(t) {
        var a = this, e = t.currentTarget.dataset.idx;
        this.data.param.cid = this.data.list.data[e].id, this.data.param.carType = this.data.list.data[e].carType, 
        this.data.param.carControl = this.data.list.data[e].carControl, this.data.param.carnum = this.data.list.data[e].carnum;
        var i = JSON.stringify(this.data.param);
        (0, _api.IsorderData)({
            cid: this.data.list.data[e].id,
            carnum: this.data.list.data[e].carnum,
            uid: wx.getStorageSync("userInfo").wxInfo.id,
            stime: this.data.param.start_time,
            etime: this.data.param.end_time
        }).then(function(t) {
            a.navTo("../checkorder/checkorder?param=" + i + "&cid=" + a.data.list.data[e].id);
        }, function(t) {
            -1 === t.code ? a.navTo("../orderinfo/orderinfo?oid=" + t.data.oid + "&table=1") : wx.showModal({
                title: "提示",
                content: t.msg,
                showCancel: !1
            });
        });
    }
}));