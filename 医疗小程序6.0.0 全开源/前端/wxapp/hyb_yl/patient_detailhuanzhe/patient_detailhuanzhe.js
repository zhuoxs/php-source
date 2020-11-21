var app = getApp();

Page({
    data: {
        disabled: !1,
        img_arr: [],
        data_arr: []
    },
    chakanimg: function(a) {
        wx.previewImage({
            current: a.currentTarget.dataset.src,
            urls: this.data.info.pic
        });
    },
    chooseLocation: function() {
        var t = this;
        wx.chooseAddress ? wx.chooseAddress({
            success: function(a) {
                console.log(JSON.stringify(a));
                var e = a.provinceName + a.cityName + a.countyName + a.detailInfo;
                console.log(a), t.setData({
                    address: e,
                    flag: !1
                });
            },
            fail: function(a) {
                console.log(JSON.stringify(a)), console.info("收货地址授权失败");
            }
        }) : console.log("当前微信版本不支持chooseAddress");
    },
    formSubmit: function(a) {
        var e = this, t = a.detail.value, n = t.dmoney, o = (t.rg, t.hzid, t.zid, t.username), s = t.dorder, d = t.docname, i = (e.data.data_arr, 
        e.data.useropenid, t.address);
        console.log(i, o, d, s);
        var r = e.data.cid, c = wx.getStorageSync("openid");
        "" == a.detail.value.rg ? wx.showToast({
            title: "请填写处方",
            image: "/hyb_yl/images/err.png"
        }) : "" == i ? wx.showToast({
            title: "请选择收货地址",
            image: "/hyb_yl/images/err.png"
        }) : app.util.request({
            url: "entry/wxapp/Pay",
            header: {
                "Content-Type": "application/xml"
            },
            method: "GET",
            data: {
                openid: c,
                z_tw_money: n
            },
            success: function(a) {
                wx.requestPayment({
                    timeStamp: a.data.timeStamp,
                    nonceStr: a.data.nonceStr,
                    package: a.data.package,
                    signType: a.data.signType,
                    paySign: a.data.paySign,
                    success: function(a) {
                        app.util.request({
                            url: "entry/wxapp/Upcforder",
                            data: {
                                cid: r,
                                address: i,
                                username: o,
                                docname: d,
                                ky_yibao: s
                            },
                            success: function(a) {
                                console.log(a), e.setData({
                                    state: !0
                                });
                            }
                        });
                    }
                });
            }
        });
    },
    onLoad: function(a) {
        var e = this, t = a.username, n = a.ksname, o = a.money, s = a.phone, d = a.tjtime, i = a.yytime, r = a.dorder, c = a.sex, u = a.age, p = a.zjid, l = a.hzid, m = wx.getStorageSync("color"), y = a.cid, f = a.useropenid, g = app.siteInfo.uniacid;
        1 == a.state ? e.setData({
            state: !0
        }) : e.setData({
            state: !1
        }), app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(a) {
                console.log(a), e.setData({
                    url: a.data
                });
            }
        }), "undefined" !== a.utype && e.setData({
            utype: a.utype
        }), y && app.util.request({
            url: "entry/wxapp/Selcetcfinfo",
            data: {
                cid: y
            },
            success: function(a) {
                console.log(a), e.setData({
                    dorder: a.data.data.orderarr,
                    username: a.data.data.username,
                    sex: a.data.data.mysex,
                    age: a.data.data.myage,
                    phone: a.data.data.myphone,
                    dmoney: a.data.data.dmoney,
                    money: a.data.data.dmoney,
                    content: a.data.data.content,
                    info: a.data.data,
                    address: a.data.data.address
                });
            }
        });
        var h = a.z_name;
        wx.setNavigationBarColor({
            frontColor: "#ffffff",
            backgroundColor: m
        });
        e = this, a.id, a.ky_yibao;
        e.setData({
            username: t,
            ksname: n,
            money: o,
            phone: s,
            tjtime: d,
            yytime: i,
            dorder: r,
            sex: c,
            age: u,
            zjid: p,
            hzid: l,
            z_name: h,
            uniacid: g,
            useropenid: f,
            cid: y
        });
    },
    onReady: function() {
        this.getDocinfo();
    },
    onShow: function() {},
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    getDocinfo: function() {
        var e = this, a = e.data.zjid;
        app.util.request({
            url: "entry/wxapp/Docinfo",
            data: {
                zid: a
            },
            success: function(a) {
                console.log(a), e.setData({
                    z_name: a.data.data.z_name
                });
            }
        });
    }
});