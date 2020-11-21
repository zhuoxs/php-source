var _extends = Object.assign || function(t) {
    for (var e = 1; e < arguments.length; e++) {
        var a = arguments[e];
        for (var i in a) Object.prototype.hasOwnProperty.call(a, i) && (t[i] = a[i]);
    }
    return t;
}, _reload = require("../../resource/js/reload.js"), _api = require("../../resource/js/api.js"), app = getApp();

Page(_extends({}, _reload.reload, {
    data: {
        nav: [ {
            name: "到店自取",
            choose: !0
        }, {
            name: "快递寄送",
            choose: !1
        } ],
        name: "",
        tel: "",
        address: "",
        choose: 0
    },
    onLoad: function(t) {
        var e = null;
        e = "3" !== t.prizetype ? t.prizetype : "1", this.setData({
            title: t.title,
            img: t.img,
            cid: t.cid,
            prizetype: t.prizetype,
            type: e
        }), this.onloadData();
    },
    onloadData: function() {
        var e = this;
        (0, _api.GetPrizeBranchData)({
            cid: this.data.cid
        }).then(function(t) {
            e.setData({
                school: t
            });
        }).catch(function(t) {
            -1 === t.code ? e.tips(t.msg) : e.tips("false");
        });
    },
    bindPickerChange: function(t) {
        this.setData({
            choose: t.detail.value
        });
    },
    onNavTab: function(t) {
        var e = null, a = t.currentTarget.dataset.idx;
        e = 0 === a ? "1" : "2";
        var i = this.data.nav;
        for (var o in i) {
            i[o = o - 0].choose = o === a;
        }
        this.setData({
            nav: i,
            type: e
        });
    },
    onGPSTab: function() {
        var t = this.data.school[this.data.choose].lat - 0, e = this.data.school[this.data.choose].lng - 0;
        wx.openLocation({
            latitude: t,
            longitude: e,
            scale: 28
        });
    },
    getName: function(t) {
        var e = t.detail.value.trim();
        this.setData({
            name: e
        });
    },
    getTel: function(t) {
        var e = t.detail.value.trim();
        this.setData({
            tel: e
        });
    },
    getAddress: function(t) {
        var e = t.detail.value.trim();
        this.setData({
            address: e
        });
    },
    getWxAddress: function() {
        wx.chooseAddress({
            success: function(t) {
                wx.setStorageSync("address", t), console.log(t);
            }
        });
    },
    onSendTab: function() {
        var e = this, t = wx.getStorageSync("fcInfo"), a = {
            cid: this.data.cid,
            uid: t.wxInfo.id,
            type: this.data.type,
            username: t.wxInfo.username,
            headurl: t.wxInfo.headurl,
            address: this.data.address,
            name: this.data.name,
            tel: this.data.tel,
            sid: this.data.school[this.data.choose].id
        };
        a.name.length < 2 ? wx.showToast({
            title: "请输入正确姓名",
            icon: "none",
            duration: 2e3
        }) : a.tel.length < 11 ? wx.showToast({
            title: "请输入正确手机号码",
            icon: "none",
            duration: 2e3
        }) : a.address.length < 6 && "2" === a.type ? wx.showToast({
            title: "请输入正确地址",
            icon: "none",
            duration: 2e3
        }) : (0, _api.CardGetprizeData)(a).then(function(t) {
            wx.showToast({
                title: "恭喜您，提交成功！",
                icon: "none",
                duration: 1e3
            }), setTimeout(function() {
                e.reTo("../card/card?pid=" + t.pid + "&title=" + e.data.title + "&img=" + e.data.img);
            }, 1e3);
        }).catch(function(t) {
            wx.showToast({
                title: t.msg,
                icon: "none",
                duration: 2e3
            });
        });
    }
}));