var app = getApp();

Page({
    data: {
        blo: 0,
        page_signs: "/sudu8_page/card/card",
        provinces: [],
        citys: [],
        areas: [],
        province: "",
        city: "",
        area: "",
        value: [ 0, 0, 0 ]
    },
    onPullDownRefresh: function() {
        var a = this;
        a.getbaseinfo(), a.getAbout(), a.provinceget(), wx.stopPullDownRefresh();
    },
    onLoad: function(a) {
        var t = this, e = wx.createAnimation({
            duration: 500,
            transformOrigin: "50% 50%",
            timingFunction: "ease"
        });
        t.animation = e;
        var i = 0;
        a.fxsid && (i = a.fxsid, t.setData({
            fxsid: a.fxsid
        })), t.getbaseinfo(), app.util.getUserInfo(t.getinfos, i);
    },
    getinfos: function() {
        var t = this;
        wx.getStorage({
            key: "openid",
            success: function(a) {
                t.setData({
                    openid: a.data
                }), t.getAbout(), t.provinceget();
            }
        });
    },
    redirectto: function(a) {
        var t = a.currentTarget.dataset.link, e = a.currentTarget.dataset.linktype;
        app.util.redirectto(t, e);
    },
    getbaseinfo: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/BaseMin",
            cachetime: "30",
            data: {
                vs1: 1
            },
            success: function(a) {
                if (a.data.data.c_b_bg) var t = "bg";
                e.setData({
                    baseinfo: a.data.data,
                    c_b_bg1: t
                }), wx.setNavigationBarTitle({
                    title: "会员卡"
                }), wx.setNavigationBarColor({
                    frontColor: e.data.baseinfo.base_tcolor,
                    backgroundColor: e.data.baseinfo.base_color
                });
            },
            fail: function(a) {}
        });
    },
    getAbout: function() {
        var i = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/globaluserinfo",
            data: {
                openid: a
            },
            success: function(a) {
                var t = a.data.data, e = 1;
                e = t.mobile && t.realname ? 1 : 0, i.setData({
                    blo: e,
                    userinfo: t,
                    myname: t.realname,
                    mymobile: t.mobile,
                    provinceName: t.resideprovince,
                    cityName: t.residecity,
                    countyName: t.residedist,
                    detailInfo: t.residecommunity,
                    birthday: t.birth,
                    areaInfo: t.resideprovince + " " + t.residecity + " " + t.residedist
                });
            }
        });
    },
    weixinadd: function() {
        var r = this;
        wx.chooseAddress({
            success: function(a) {
                var t = a.provinceName, e = a.cityName, i = a.countyName, n = a.detailInfo, s = a.userName, o = a.telNumber;
                r.setData({
                    myname: s,
                    mymobile: o,
                    provinceName: t,
                    cityName: e,
                    countyName: i,
                    detailInfo: n,
                    areaInfo: t + " " + e + " " + i
                });
            }
        });
    },
    provinceget: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/provincejson",
            success: function(a) {
                var t = a.data[0].id;
                e.setData({
                    provinces: a.data,
                    allprovinces: a.data,
                    id: t
                }), e.cityget();
            }
        });
    },
    cityget: function() {
        var t = this, e = t.data.id;
        app.util.request({
            url: "entry/wxapp/cityjson",
            success: function(a) {
                t.setData({
                    citys: a.data[e],
                    allcitys: a.data,
                    cid: a.data[e][0].id
                }), t.areaget();
            }
        });
    },
    areaget: function() {
        var t = this, e = (t.data.id, t.data.cid);
        app.util.request({
            url: "entry/wxapp/areajson",
            success: function(a) {
                t.setData({
                    areas: a.data[e],
                    allareas: a.data
                });
            }
        });
    },
    moren_set: function(a) {
        var t = this, e = (t.data.moren, a.currentTarget.dataset.id), i = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/setmoaddress",
            data: {
                openid: i,
                id: e
            },
            success: function(a) {
                t.myaddress();
            }
        });
    },
    selectDistrict: function(a) {
        this.data.addressMenuIsShow || this.startAddressAnimation(!0);
    },
    startAddressAnimation: function(a) {
        a ? this.animation.translateY("0vh").step() : this.animation.translateY("40vh").step(), 
        this.setData({
            animationAddressMenu: this.animation.export(),
            addressMenuIsShow: a
        });
    },
    cityCancel: function(a) {
        this.startAddressAnimation(!1);
    },
    citySure: function(a) {
        var t = this, e = (t.data.city, t.data.value);
        t.startAddressAnimation(!1);
        var i = t.data.provinces[e[0]].name + "," + t.data.citys[e[1]].name + "," + t.data.areas[e[2]].name;
        t.setData({
            areaInfo: i,
            provinceName: t.data.provinces[e[0]].name,
            cityName: t.data.citys[e[1]].name,
            countyName: t.data.areas[e[2]].name
        });
    },
    hideCitySelected: function(a) {
        this.startAddressAnimation(!1);
    },
    cityChange: function(a) {
        var t = a.detail.value, e = this.data.provinces, i = (this.data.citys, this.data.areas, 
        this.data.allprovinces, this.data.allcitys), n = this.data.allareas, s = t[0], o = t[1], r = t[2];
        if (this.data.value[0] != s) {
            var d = e[s].id;
            this.setData({
                value: [ s, 0, 0 ],
                citys: i[d],
                areas: n[i[d][0].id]
            });
        } else if (this.data.value[1] != o) {
            d = i[e[s].id][o].id;
            this.setData({
                value: [ s, o, 0 ],
                areas: n[d]
            });
        } else this.setData({
            value: [ s, o, r ]
        });
    },
    bindInputChangename: function(a) {
        var t = a.detail.value;
        this.setData({
            myname: t
        });
    },
    bindInputChangetel: function(a) {
        var t = a.detail.value;
        this.setData({
            mymobile: t
        });
    },
    bindInputChangedz: function(a) {
        var t = a.detail.value;
        this.setData({
            detailInfo: t
        });
    },
    saves: function() {
        var t = this, a = t.data.myname, e = t.data.mymobile, i = t.data.provinceName, n = t.data.cityName, s = t.data.countyName, o = t.data.detailInfo, r = t.data.birthday, d = wx.getStorageSync("openid");
        return a ? e ? void app.util.request({
            url: "entry/wxapp/updatehuiyuan",
            data: {
                openid: d,
                myname: a,
                mymobile: e,
                provinceName: i,
                cityName: n,
                countyName: s,
                detailInfo: o,
                birthday: r
            },
            success: function(a) {
                t.getAbout();
            }
        }) : (wx.showModal({
            title: "提现",
            content: "请填写您的手机！",
            showCancel: !1
        }), !1) : (wx.showModal({
            title: "提现",
            content: "请填写您的姓名！",
            showCancel: !1
        }), !1);
    },
    bindDateChange: function(a) {
        var t = a.detail.value;
        this.setData({
            birthday: t
        });
    },
    changxx: function() {
        this.setData({
            blo: 0
        });
    }
});