function t(t, e, a) {
    return e in t ? Object.defineProperty(t, e, {
        value: a,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[e] = a, t;
}

var e, a = getApp();

Page((e = {
    data: {
        showList: 0,
        info: [],
        fav: "",
        imgs: [],
        tag_arr: [],
        facility_arr: [],
        pingtai: [],
        jiazai: 1,
        fenxiangbut: !1
    },
    onLoad: function(t) {
        var e = this;
        e.setData({
            id: t.id
        }), e.detailinfo(), a.util.getUserInfo(function(t) {
            t.memberInfo ? (a.util.request({
                url: "entry/wxapp/Api",
                data: {
                    m: "ox_reathouse",
                    r: "user.userinfo",
                    uid: t.memberInfo.uid
                },
                success: function(t) {
                    e.detailinfo();
                }
            }), wx.setStorageSync("uid", t.memberInfo.uid), console.log(t.memberInfo.uid)) : e.hideDialog();
        });
    },
    hideDialog: function() {
        this.setData({
            isShow: !this.data.isShow
        });
    },
    updateUserInfo: function(t) {
        var e = this;
        e.hideDialog(), console.log(t), t.detail.userInfo && a.util.getUserInfo(function(t) {
            a.util.request({
                url: "entry/wxapp/Api",
                data: {
                    m: "ox_reathouse",
                    r: "user.userinfo",
                    uid: t.memberInfo.uid
                },
                success: function(t) {
                    e.detailinfo();
                }
            }), wx.setStorageSync("uid", t.memberInfo.uid);
        }, t.detail);
    },
    detailinfo: function() {
        var t = this, e = {
            uid: wx.getStorageSync("uid"),
            id: t.data.id,
            m: "ox_reathouse",
            r: "detail.index"
        };
        a.util.request({
            url: "entry/wxapp/Api",
            data: e,
            method: "POST",
            success: function(e) {
                t.setData({
                    info: e.data.data,
                    fav: e.data.data.fav,
                    imgs: e.data.data.imgs,
                    tag_arr: e.data.data.tag_arr,
                    facility_arr: e.data.data.facility_arr,
                    pingtai: e.data.data.pingtai,
                    jiazai: 0
                }), t.data.facility_arr.length < 9 && t.setData({
                    showList: 1
                }), wx.setNavigationBarTitle({
                    title: t.data.pingtai.title + "·" + t.data.info.name + "·" + t.data.info.house_type_shi + "室" + t.data.info.house_type_ting + "厅"
                }), console.log(t.data.info);
            }
        });
    },
    fenxiang: function() {
        this.setData({
            fenxiangbut: !this.data.fenxiangbut
        });
    }
}, t(e, "hideDialog", function() {
    this.setData({
        isShow: !this.data.isShow
    });
}), t(e, "showiconlist", function() {
    this.setData({
        showList: 1
    });
}), t(e, "phoneCall", function(t) {
    wx.makePhoneCall({
        phoneNumber: this.data.pingtai.phone
    });
}), t(e, "gohome", function() {
    wx.switchTab({
        url: "../index/index"
    });
}), t(e, "mapphone", function() {
    wx.openLocation({
        latitude: Number(this.data.info.mapx),
        longitude: Number(this.data.info.mapy),
        name: this.data.info.name,
        address: this.data.info.address
    });
}), t(e, "favact", function() {
    var t = this;
    if ("" != wx.getStorageSync("uid") && "undefined" != wx.getStorageSync("uid")) {
        var e = {
            uid: wx.getStorageSync("uid"),
            id: t.data.id,
            m: "ox_reathouse",
            r: "detail.fav"
        };
        a.util.request({
            url: "entry/wxapp/Api",
            data: e,
            method: "POST",
            success: function(e) {
                t.setData({
                    fav: e.data.data.fav
                }), console.log(t.data.fav);
            }
        });
    } else t.hideDialog();
}), t(e, "poster", function(t) {
    wx.navigateTo({
        url: "poster/index?id=" + this.data.id
    });
}), t(e, "onShareAppMessage", function() {
    return {
        title: this.data.pingtai.title
    };
}), t(e, "shareimage", function(t) {
    var e = this;
    wx.showLoading({
        title: "稍等，马上好",
        mask: !0
    });
    var a = wx.createCanvasContext("shareCanvas", this);
    a.drawImage("/pages/images/share_tpl2.png", 0, 0, 414, 736), new Promise(function(t) {
        wx.getImageInfo({
            src: e.data.info.imgone,
            success: function(e) {
                a.drawImage(e.path, 0, 0, 414, 276), a.drawImage("/pages/images/box.png", 0, 174, 414, 562), 
                t();
            }
        });
    }).then(function() {
        return new Promise(function(t) {
            wx.getImageInfo({
                src: e.data.info.qrcode,
                success: function(e) {
                    console.log(e), a.drawImage(e.path, 167, 618, 80, 80), a.save(), a.beginPath(), 
                    a.arc(207, 658, 18, 0, 2 * Math.PI, !1), a.setStrokeStyle("white"), a.stroke(), 
                    a.clip(), a.restore(), t();
                }
            });
        });
    }).then(function() {
        return new Promise(function(t) {
            a.setFontSize(16), a.setTextAlign("center"), a.setFillStyle("#888888"), a.fillText(e.data.info.name + "-" + e.data.info.renovation_text, 207, 260), 
            a.setFontSize(16), a.setTextAlign("left"), a.setFillStyle("#888888"), a.fillText("类型：" + e.data.info.type_text, 60, 320), 
            a.setFontSize(16), a.setTextAlign("left"), a.setFillStyle("#888888"), a.fillText("服务电话：" + e.data.info.pingtai.phone, 60, 360), 
            a.setFontSize(16), a.setTextAlign("left"), a.setFillStyle("#888888"), a.fillText("店铺地址：" + e.data.info.address, 60, 400), 
            a.setFontSize(12), a.setTextAlign("center"), a.setFillStyle("#999999"), a.fillText("长按识别小程序码", 207, 590), 
            a.draw(), setTimeout(function() {
                return t();
            }, 1e3);
        });
    }).then(function() {
        wx.hideLoading(), wx.canvasToTempFilePath({
            canvasId: "shareCanvas",
            x: 0,
            y: 0,
            width: 414,
            height: 736,
            success: function(t) {
                var e = [ t.tempFilePath ];
                wx.previewImage({
                    urls: e
                });
            }
        }, e);
    });
}), e));