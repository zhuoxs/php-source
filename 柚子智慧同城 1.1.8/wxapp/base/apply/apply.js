/*www.lanrenzhijia.com   time:2019-06-01 22:11:53*/
function a(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a
}
var t = getApp();
t.Base({
    data: {
        prevent: !1,
        showPage: 1,
        reChoose: 0,
        circle: 0,
        classify_idx: 0,
        time1: "00:00",
        time2: "00:00",
        service: [{
            name: "免费Wifi"
        }, {
            name: "禁止吸烟"
        }, {
            name: "刷卡支付"
        }, {
            name: "免费停车"
        }, {
            name: "提供包间"
        }, {
            name: "沙发休闲"
        }],
        param: {
            district_id: "",
            cat_id: "",
            name: "",
            detail: "",
            contact: "",
            tel: "",
            service: "",
            phone: "",
            per_consumption: "",
            user_id: "",
            time: "",
            pic: "",
            pic_bg: "",
            icon: "",
            posterpic: "",
            store_wechat: "",
            banner: "",
            address: "",
            pay_type: 1,
            id: 0
        }
    },
    onLoad: function(a) {
        var t = this;
        this.checkLogin(function(a) {
            t.onLoadData(a)
        }, "/base/apply/apply")
    },
    onLoadData: function(e) {
        var i = this;
        this.data.param.user_id = e.id, Promise.all([t.api.apiStoreGetMyStore({
            user_id: e.id
        }), t.api.apiStoreGetStoreRecharges(), t.api.apiStoreGetStoreDistrictList(), t.api.apiStoreGetStoreCategoryList()]).then(function(e) {
            i.setData({
                imgRoot: e[0].other.img_root
            });
            for (var s in e[1].data) e[1].data[s].price = e[1].data[s].price - 0, e[1].data[s].price <= 0 && (e[1].data[s].price = 0), e[1].data[s].show_select = e[1].data[s].days + "天";
            for (var n in e[2].data) e[2].data[n].business = e[2].data[n].name;
            for (var r in e[3].data) e[3].data[r].classify_select = e[3].data[r].name;
            if (e[0].data && e[0].data.check_status) if (0 == e[0].data.state && 2 == e[0].data.check_status) t.alert("您已成功入驻，查看我的管理后台？", function() {
                i.reloadPrevious();
                var a = wx.getStorageSync("setting").nav,
                    e = !1;
                for (var s in a) if ("/base/apply/apply" == a[s].link) {
                    e = !0;
                    break
                }
                e ? t.navTo("/base/admin/admin") : t.reTo("/base/admin/admin")
            }, function() {
                t.lunchTo("/pages/home/home")
            });
            else {
                var o, d = e[0].data.check_status,
                    c = "";
                1 == e[0].data.state ? 1 == d ? c = 2 : 2 == d ? (c = 0, t.alert("您已经入驻，是否跳转商家后台？", function() {
                    i.reloadPrevious();
                    var a = wx.getStorageSync("setting").nav,
                        e = !1;
                    for (var s in a) if ("/base/apply/apply" == a[s].link) {
                        e = !0;
                        break
                    }
                    e ? t.navTo("/base/admin/admin") : t.reTo("/base/admin/admin")
                }, function() {
                    wx.navigateBack({
                        delta: 1
                    })
                })) : 3 == d && (c = 3) : c = 1;
                var p = e[0].data.business_range.trim().split("-"),
                    l = JSON.parse(e[0].data.banner),
                    m = i.data.service,
                    h = e[0].data.service.split(",");
                m.forEach(function(a) {
                    h.forEach(function(t) {
                        a.name == t && (a.checked = !0)
                    })
                }), i.setData((o = {
                    imgRoot: e[0].other.img_root,
                    showPage: c,
                    service: m,
                    time1: p[0].substring(0, 5),
                    time2: p[1].substring(1, 6)
                }, a(o, "param.name", e[0].data.name), a(o, "param.details", e[0].data.details), a(o, "param.contact", e[0].data.contact), a(o, "param.phone", e[0].data.phone), a(o, "param.tel", e[0].data.tel), a(o, "param.service", e[0].data.service), a(o, "param.logo", [e[0].data.logo]), a(o, "param.icon", [e[0].data.icon]), a(o, "param.banner", l), a(o, "param.posterpic", [e[0].data.posterpic]), a(o, "param.address", e[0].data.address), a(o, "param.lat", e[0].data.lat), a(o, "param.lng", e[0].data.lng), a(o, "param.id", e[0].data.id), a(o, "param.per_consumption", e[0].data.per_consumption), a(o, "param.store_wechat", [e[0].data.store_wechat]), o))
            }
            if (e[1].data.length < 1) t.alert("平台暂未设置入驻费用，请等待平台信息完善之后再入驻！", function() {
                t.lunchTo("/pages/home/home")
            }, 0);
            else {
                var u;
                i.setData((u = {
                    shop: e[0].data,
                    recharge: e[1].data,
                    district: e[2].data,
                    classify: e[3].data
                }, a(u, "param.cid", e[1].data.length > 0 ? e[1].data[0].id : ""), a(u, "param.district_id", e[2].data.length > 0 ? e[2].data[0].id : ""), a(u, "param.cat_id", e[3].data.length > 0 ? e[3].data[0].id : ""), a(u, "show", !0), u))
            }
        }).
        catch (function(a) {
            t.tips(a.msg)
        })
    },
    getName: function(t) {
        var e = t.detail.value.trim();
        this.setData(a({}, "param.name", e))
    },
    getContact: function(t) {
        var e = t.detail.value.trim();
        this.setData(a({}, "param.contact", e))
    },
    getPhone: function(t) {
        var e = t.detail.value.trim();
        this.setData(a({}, "param.phone", e))
    },
    getTel: function(t) {
        var e = t.detail.value.trim();
        this.setData(a({}, "param.tel", e))
    },
    getConsumption: function(t) {
        var e = t.detail.value.trim();
        this.setData(a({}, "param.per_consumption", e))
    },
    getRecharge: function(t) {
        var e = t.detail.value;
        this.setData(a({
            reChoose: e
        }, "param.cid", this.data.recharge[e].id))
    },
    getDistrict: function(t) {
        var e = t.detail.value;
        this.setData(a({
            circle: e
        }, "param.district_id", this.data.district[e].id))
    },
    getClassify: function(t) {
        var e = t.detail.value;
        this.setData(a({
            classify_idx: e
        }, "param.cat_id", this.data.classify[e].id))
    },
    getAddress: function(t) {
        var e, i = t.detail;
        this.setData((e = {}, a(e, "param.lat", i.latitude), a(e, "param.lng", i.longitude), a(e, "param.address", i.address), e))
    },
    checkboxChange: function(t) {
        var e = [];
        e.push(t.detail.value), this.setData(a({}, "param.service", e))
    },
    getDetail: function(t) {
        var e = t.detail.value.trim();
        this.setData(a({}, "param.details", e))
    },
    getPic: function(t) {
        this.setData(a({}, "param.logo", t.detail))
    },
    getIcon: function(t) {
        this.setData(a({}, "param.icon", t.detail))
    },
    getBnner: function(t) {
        this.setData(a({}, "param.banner", t.detail))
    },
    getPosterpic: function(t) {
        this.setData(a({}, "param.posterpic", t.detail))
    },
    getWechat: function(t) {
        this.setData(a({}, "param.store_wechat", t.detail))
    },
    startTimeChange1: function(a) {
        this.setData({
            time1: a.detail.value
        })
    },
    startTimeChange2: function(a) {
        this.setData({
            time2: a.detail.value
        })
    },
    onApplyTap: function() {
        var a = this;
        if (this.data.prevent) this.wxpayAjax();
        else {
            var e = this.data.param;
            if (e.business_range = this.data.time1.substring(0, 5) + ":00 - " + this.data.time2.substring(0, 5) + ":00", e.name.length < 1) t.tips("请输入店铺名称！");
            else if (e.contact.length < 1) t.tips("请输入联系人姓名！");
            else if (e.tel.length < 1) t.tips("请输入正确的联系电话！");
            else if (e.phone.length < 11) t.tips("请输入正确的商家手机！");
            else if (e.service.length < 1) t.tips("请选择服务设施！");
            else if (e.per_consumption.length < 1) t.tips("请输入人均消费！");
            else if (e.address.length < 1) t.tips("请选择店铺地址！");
            else if (!e.details || e.details.length < 1) t.tips("请输入店铺简介！");
            else if (!e.logo || e.logo.length < 1) t.tips("请选择店铺LOGO图！");
            else {
                if (e.icon && !(e.icon.length < 1)) return !e.banner || e.banner.length < 1 ? (console.log(e.banner), void t.tips("请选择Banner图片！")) : void(!e.posterpic || e.posterpic.length < 1 ? t.tips("请选择海报图！") : !e.store_wechat || e.store_wechat.length < 1 ? t.tips("请选择商家微信图！") : this.data.ajax || (this.data.ajax = !0, t.api.apiStoreApplyStore(e).then(function(e) {
                    a.setData({
                        prevent: !0
                    }), e.data.paydata ? (a.setData({
                        payStamp: e.data.paydata
                    }), a.wxpayAjax(e.data.paydata)) : (t.alert("申请成功，请耐心等待审核！", function() {
                        t.lunchTo("/pages/home/home")
                    }, 0), a.data.ajax = !1)
                }).
                catch (function(e) {
                    "[ name ]字段唯一" == e.msg ? t.tips("该店铺名称已经存在，请重新输入店铺名称！") : t.tips(e.msg), a.data.ajax = !1
                })));
                t.tips("请选择首页菜单图标！")
            }
        }
    },
    wxpayAjax: function() {
        var a = this.data.payStamp,
            e = this;
        wx.requestPayment({
            timeStamp: a.timeStamp,
            nonceStr: a.nonceStr,
            package: a.package,
            signType: a.signType,
            paySign: a.paySign,
            success: function(a) {
                setTimeout(function() {
                    t.alert("申请成功，请耐心等待审核！", function() {
                        e.reloadPrevious(), t.lunchTo("/pages/home/home")
                    }, 0), e.data.ajax = !1
                }, 1e3)
            },
            fail: function(a) {
                e.data.ajax = !1, t.tips("您已取消支付，请重新支付！")
            }
        })
    },
    onReasonTap: function() {
        2 == this.data.showPage ? t.lunchTo("/pages/home/home") : this.setData({
            showPage: 1
        })
    }
});