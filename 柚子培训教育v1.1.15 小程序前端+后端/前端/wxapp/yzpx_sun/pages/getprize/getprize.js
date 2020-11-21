var _extends = Object.assign || function(t) {
    for (var a = 1; a < arguments.length; a++) {
        var e = arguments[a];
        for (var i in e) Object.prototype.hasOwnProperty.call(e, i) && (t[i] = e[i]);
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
        var a = null;
        a = "3" !== t.prizetype ? t.prizetype : "1", this.setData({
            title: t.title,
            img: t.img,
            cid: t.cid,
            prizetype: t.prizetype,
            type: a
        }), this.onloadData();
    },
    onloadData: function() {
        var e = this;
        (0, _api.WeData)().then(function(t) {
            return e.setData({
                info: t
            }), (0, _api.GetPrizeSchoolData)();
        }).then(function(t) {
            var a = {
                id: 0,
                name: e.data.info.name + "(总校)",
                address: e.data.info.address,
                lat: e.data.info.lat,
                lng: e.data.info.lng
            };
            t.unshift(a), e.setData({
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
        var a = null, e = t.currentTarget.dataset.idx;
        a = 0 === e ? "1" : "2";
        var i = this.data.nav;
        for (var n in i) {
            i[n = n - 0].choose = n === e;
        }
        this.setData({
            nav: i,
            type: a
        });
    },
    onGPSTab: function() {
        var t = this.data.school[this.data.choose].lat - 0, a = this.data.school[this.data.choose].lng - 0;
        wx.openLocation({
            latitude: t,
            longitude: a,
            scale: 28
        });
    },
    getName: function(t) {
        var a = t.detail.value.trim();
        this.setData({
            name: a
        });
    },
    getTel: function(t) {
        var a = t.detail.value.trim();
        this.setData({
            tel: a
        });
    },
    getAddress: function(t) {
        var a = t.detail.value.trim();
        this.setData({
            address: a
        });
    },
    onSendTab: function() {
        var a = this, t = wx.getStorageSync("userInfo"), e = {
            cid: this.data.cid,
            uid: t.wxInfo.id,
            type: this.data.type,
            username: t.wxInfo.user_name,
            headurl: t.wxInfo.headimg,
            address: this.data.address,
            name: this.data.name,
            tel: this.data.tel,
            sid: this.data.school[this.data.choose].id
        };
        e.name.length < 2 ? wx.showToast({
            title: "请输入正确姓名",
            icon: "none",
            duration: 2e3
        }) : e.tel.length < 11 ? wx.showToast({
            title: "请输入正确手机号码",
            icon: "none",
            duration: 2e3
        }) : e.address.length < 6 && "2" === e.type ? wx.showToast({
            title: "请输入正确地址",
            icon: "none",
            duration: 2e3
        }) : (0, _api.CardGetprizeData)(e).then(function(t) {
            wx.showToast({
                title: "恭喜您，提交成功！",
                icon: "none",
                duration: 1e3
            }), setTimeout(function() {
                a.reTo("../card/card?pid=" + t.pid + "&title=" + a.data.title + "&img=" + a.data.img);
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