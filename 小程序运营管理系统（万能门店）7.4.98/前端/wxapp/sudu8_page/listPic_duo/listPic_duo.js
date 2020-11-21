var _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(a) {
    return typeof a;
} : function(a) {
    return a && "function" == typeof Symbol && a.constructor === Symbol && a !== Symbol.prototype ? "symbol" : typeof a;
}, app = getApp();

Page({
    data: {
        page: 1,
        morePro: !1,
        ProductsList: [],
        baseinfo: [],
        subcate: [],
        footer: {
            i_tel: app.globalData.i_tel,
            i_add: app.globalData.i_add,
            i_time: app.globalData.i_time,
            i_view: app.globalData.i_view,
            close: app.globalData.close,
            v_ico: app.globalData.v_ico
        },
        where: [],
        cids: 0,
        hid: 0,
        pid: [],
        actcatas: [],
        tmp: 0,
        subShow: 0,
        heighthave: 0
    },
    onPullDownRefresh: function() {
        this.getBase(), this.getList(), this.setData({
            page: 1
        }), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this;
        t.setData({
            isIphoneX: app.globalData.isIphoneX
        }), t.setData({
            page_sign: "listCon" + a.cid,
            cid: a.cid,
            uid: a.cid
        });
        var e = 0;
        a.fxsid && (e = a.fxsid, t.setData({
            fxsid: a.fxsid
        })), t.getBase(), app.util.getUserInfo(t.getinfos, e);
    },
    getinfos: function() {
        var t = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                t.setData({
                    openid: a.data
                }), t.getList(), t.getall();
            }
        });
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    getBase: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/BaseMin",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(a) {
                t.setData({
                    baseinfo: a.data.data
                }), wx.setNavigationBarColor({
                    frontColor: t.data.baseinfo.base_tcolor,
                    backgroundColor: t.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        });
    },
    handleTap: function(a) {
        var t = a.target.dataset.index;
        if ("object" != _typeof(this.data.actcatas)) {
            if (this.data.actcatas = new Array(), void 0 === this.data.actcatas[t]) {
                this.data.actcatas[t] = 0;
                var e = this;
                this.setData({
                    actcata: e.data.actcatas
                });
            }
        } else if (void 0 === this.data.actcatas[t]) {
            this.data.actcatas[t] = 0;
            e = this;
            this.setData({
                actcata: e.data.actcatas
            });
        }
        if (this.data.cids == a.target.dataset.id && 1 == this.data.subShow) this.setData({
            cid: 0,
            page: 1,
            subShow: 1
        }), this.data.cids = 0; else {
            var i = a.currentTarget.id.slice(1);
            i && (this.setData({
                cid: i,
                page: 1,
                subShow: 1
            }), this.data.cids = i);
        }
    },
    getCate: function(a) {
        var t = this;
        app.util.request({
            url: "entry/wxapp/getcate",
            cachetime: "0",
            data: {
                cid: a
            },
            success: function(a) {
                t.setData({
                    subinfo: a.data
                });
            },
            fail: function(a) {}
        });
    },
    getall: function() {
        var t = this;
        app.util.request({
            url: "entry/wxapp/changelist",
            cachetime: "0",
            data: {
                multi_id: t.data.uid,
                page: 1
            },
            success: function(a) {
                t.setData({
                    cate_list: a.data.pro_list,
                    subinfo: ""
                });
            },
            fail: function(a) {}
        });
    },
    changelist: function(a) {
        var t = a.target.dataset.pid, e = this;
        e.data.page = 1;
        for (var i = !0, s = 0; s < this.data.pid.length; s++) e.data.pid[s] == t && (i = !1);
        var o = a.target.dataset.index, c = a.target.dataset.id, d = this.data.topcate, n = d[o].sons;
        if ("0" == c) d[o].title = d[o].varible; else for (s = 0; s < n.length; s++) if (n[s].id == c) {
            d[o].title = n[s].varible;
            break;
        }
        var r = e.data.actcatas;
        if ("object" != (void 0 === r ? "undefined" : _typeof(r)) && (e.data.actcatas = new Array()), 
        0 == this.data.actcatas.length && (this.data.actcatas[0] = 0, this.data.pid[0] = e.data.tmp), 
        3 == this.data.actcatas.length) for (s = 0; s < this.data.actcatas.length; s++) 0 == parseInt(this.data.actcatas[s]) && this.data.actcatas.splice(s, 1);
        this.data.actcatas[o] = c, 1 == i && (this.data.pid[o] = t), this.setData({
            topcate: d,
            actcata: e.data.actcatas
        });
        var l = this, p = a.target.dataset.id, h = l.data.actcatas.join(",");
        app.util.request({
            url: "entry/wxapp/changelist",
            cachetime: "0",
            data: {
                cid: h,
                pid: l.data.pid.join("-"),
                multi_id: l.data.uid,
                page: 1
            },
            success: function(a) {
                l.setData({
                    cate_list: a.data.pro_list,
                    hid: parseInt(p),
                    subShow: 0
                });
            },
            fail: function(a) {}
        });
    },
    getList: function() {
        var i = this;
        app.util.request({
            url: "entry/wxapp/listArt_duo",
            cachetime: "30",
            data: {
                types: "showArt",
                multi_id: i.data.cid
            },
            success: function(a) {
                for (var t = a.data.topcate, e = 0; e < t.length; e++) t[e].title = t[e].varible;
                i.data.tmp = a.data.topcate[0].id, i.setData({
                    hid: i.data.hid,
                    cid: i.data.cids,
                    cateinfo: a.data.cate,
                    topcate: a.data.topcate
                }), wx.setNavigationBarTitle({
                    title: a.data.cate.name
                }), wx.setStorageSync("isShowLoading", !1), wx.hideNavigationBarLoading(), wx.stopPullDownRefresh();
            },
            fail: function(a) {}
        });
    },
    onReachBottom: function() {
        var t = this, e = t.data.page + 1;
        t.data.cid;
        app.util.request({
            url: "entry/wxapp/changelist",
            data: {
                multi_id: t.data.uid,
                cid: t.data.actcatas ? t.data.actcatas.join(",") : 0,
                pid: t.data.pid.join("-"),
                page: e
            },
            success: function(a) {
                t.setData({
                    cate_list: t.data.cate_list.concat(a.data.pro_list),
                    page: e
                });
            }
        });
    },
    swiperLoad: function(i) {
        var s = this;
        wx.getSystemInfo({
            success: function(a) {
                var t = i.detail.width / i.detail.height, e = a.windowWidth / t;
                s.data.heighthave || s.setData({
                    minHeight: e,
                    heighthave: 1
                });
            }
        });
    },
    makePhoneCall: function(a) {
        var t = this.data.baseinfo.tel;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    makePhoneCallB: function(a) {
        var t = this.data.baseinfo.tel_b;
        wx.makePhoneCall({
            phoneNumber: t
        });
    },
    openMap: function(a) {
        wx.openLocation({
            latitude: parseFloat(this.data.baseinfo.latitude),
            longitude: parseFloat(this.data.baseinfo.longitude),
            name: this.data.baseinfo.name,
            address: this.data.baseinfo.address,
            scale: 22
        });
    },
    onShareAppMessage: function() {
        return {
            title: this.data.cateinfo.name + "-" + this.data.baseinfo.name
        };
    }
});