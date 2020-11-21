var _Page;

function _defineProperty(a, e, t) {
    return e in a ? Object.defineProperty(a, e, {
        value: t,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[e] = t, a;
}

var app = getApp();

Page((_defineProperty(_Page = {
    data: {
        umoney: [],
        cardnum: [],
        jszc: {
            js_name: "",
            js_logo: "",
            js_tel: ""
        },
        isIpx: app.globalData.isIpx,
        whichone: 5,
        open_distribution: !1
    },
    onLoad: function(a) {
        app.editTabBar();
        var e = this;
        e.getUrl(), wx.getUserInfo({
            success: function(a) {
                e.setData({
                    thumb: a.userInfo.avatarUrl,
                    nickname: a.userInfo.nickName
                });
            }
        });
        var t = this;
        wx.setNavigationBarColor({
            frontColor: wx.getStorageSync("fontcolor"),
            backgroundColor: wx.getStorageSync("color"),
            animation: {
                duration: 0,
                timingFunc: "easeIn"
            }
        }), app.util.request({
            url: "entry/wxapp/system",
            cachetime: "0",
            success: function(a) {
                "" != a.data.js_tel && null != a.data.js_tel && (t.data.jszc.js_tel = a.data.js_tel), 
                "" != a.data.js_name && null != a.data.js_name && (t.data.jszc.js_name = a.data.js_name), 
                "" != a.data.js_logo && null != a.data.js_logo && (t.data.jszc.js_logo = a.data.js_logo), 
                t.setData({
                    shop: a.data,
                    jszc: t.data.jszc
                });
            }
        }), app.util.request({
            url: "entry/wxapp/Plugin",
            data: {
                type: 1
            },
            showLoading: !1,
            success: function(a) {
                var e = 2 != a.data && a.data;
                console.log("分销"), console.log(a.data), t.setData({
                    open_distribution: e
                });
            }
        });
    },
    getUrl: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/url",
            cachetime: "0",
            success: function(a) {
                wx.setStorageSync("url", a.data), e.setData({
                    url: a.data
                });
            }
        });
    },
    onReady: function() {
        app.getNavList(2);
    },
    onShow: function() {
        var t = this, a = wx.getStorageSync("openid"), e = wx.getStorageSync("build_id");
        app.util.request({
            url: "entry/wxapp/Countcounp",
            method: "GET",
            data: {
                userid: a,
                build_id: e
            },
            success: function(a) {
                var e = a.data.length;
                t.setData({
                    cardnum: e
                }), t.Moneys();
            }
        });
    },
    Moneys: function() {
        var e = this, a = wx.getStorageSync("openid");
        app.util.request({
            url: "entry/wxapp/Money",
            method: "GET",
            data: {
                userid: a
            },
            success: function(a) {
                e.setData({
                    umoney: a.data
                });
            }
        });
    },
    toBackstage: function() {
        wx.navigateTo({
            url: "../backstage/index2/index2"
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {},
    onReachBottom: function() {},
    toService: function(a) {
        wx.navigateTo({
            url: "service/service"
        });
    },
    toAddress: function(a) {
        wx.navigateTo({
            url: "address/address"
        });
    }
}, "toBackstage", function(a) {
    wx.navigateTo({
        url: "../backstage/backstage"
    });
}), _defineProperty(_Page, "toDialogue", function(a) {
    wx.navigateTo({
        url: "dialogue/dialogue"
    });
}), _defineProperty(_Page, "toBgorder", function(a) {
    wx.navigateTo({
        url: "bgorder/bgorder"
    });
}), _defineProperty(_Page, "toRecharge", function(a) {
    wx.navigateTo({
        url: "recharge/recharge"
    });
}), _defineProperty(_Page, "toBargain", function(a) {
    wx.navigateTo({
        url: "bargain/bargain"
    });
}), _defineProperty(_Page, "toCards", function(a) {
    wx.navigateTo({
        url: "cards/cards"
    });
}), _defineProperty(_Page, "dialogYZ", function(a) {
    wx.makePhoneCall({
        phoneNumber: this.data.shop.js_tel
    });
}), _defineProperty(_Page, "toAddress", function() {
    var e = this;
    wx.chooseAddress({
        success: function(a) {
            console.log(a), console.log("获取地址成功"), e.setData({
                address: a,
                hasAddress: !0
            });
        },
        fail: function(a) {
            console.log("获取地址失败");
        }
    });
}), _defineProperty(_Page, "toMybill", function(a) {
    wx.navigateTo({
        url: "mybill/mybill"
    });
}), _defineProperty(_Page, "toFxCenter", function(a) {
    this.data.open_distribution;
    var e = wx.getStorageSync("openid"), t = a.detail.formId, n = wx.getStorageSync("users");
    app.util.request({
        url: "entry/wxapp/IsPromoter",
        data: {
            openid: e,
            form_id: t,
            uid: n.id,
            status: 3,
            m: app.globalData.Plugin_distribution
        },
        showLoading: !1,
        success: function(a) {
            a && 9 != a.data ? 0 == a.data ? wx.navigateTo({
                url: "/wnjz_sun/plugin/distribution/fxAddShare/fxAddShare"
            }) : wx.navigateTo({
                url: "/wnjz_sun/plugin/distribution/fxCenter/fxCenter"
            }) : wx.navigateTo({
                url: "/wnjz_sun/plugin/distribution/fxAddShare/fxAddShare"
            });
        }
    });
}), _Page));