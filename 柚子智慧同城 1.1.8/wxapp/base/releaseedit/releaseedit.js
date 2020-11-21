/*www.lanrenzhijia.com   time:2019-06-01 22:11:53*/
function a(a, t, e) {
    return t in a ? Object.defineProperty(a, t, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : a[t] = e, a
}
var t = getApp(),
    e = require("../../zhy/template/wxParse/wxParse.js"),
    i = require("../../zhy/resource/js/qqmap-wx-jssdk.min.js");
t.Base({
    data: {
        param: {
            name: "",
            detail: "",
            contact: "",
            phone: "",
            user_id: ""
        },
        address: "",
        flag: !1,
        areaShow: !0,
        remark: ""
    },
    onLoad: function(t) {
        var e = this,
            i = wx.getStorageSync("cityaddress");
        i && this.setData({
            cityaddress: i
        }), this.checkLogin(function(i) {
            e.setData({
                show: !0,
                cat_id: t.id,
                user: i
            }), e.getLatLng(function(t) {
                if (t) {
                    var i;
                    e.setData((i = {}, a(i, "param.lng", t.lng), a(i, "param.lat", t.lat), i))
                }
                return e.onLoadData()
            })
        }, "/base/releaseedit/releaseedit?id=" + t.id)
    },
    getNowPlace: function(a) {
        var t = this,
            e = this.data.cityaddress;
        new i({
            key: a
        }).reverseGeocoder({
            location: {
                latitude: e ? e.citylat : t.data.lat,
                longitude: e ? e.citylng : t.data.lng
            },
            success: function(a) {
                var e = a.result;
                t.setData({
                    area_adcode: e.ad_info.adcode,
                    address: e.address,
                    adcode_address: e.address
                })
            }
        })
    },
    onLoadData: function() {
        var a = this;
        t.api.apiInfoGetInfosettings().then(function(t) {
            var i = t.data.release_notice;
            e.wxParse("detail", "html", i, a, 20), a.getNowPlace(t.data.map_key), a.setData({
                mes: t.data
            })
        }).
        catch (function(a) {
            t.tips(a.msg)
        })
    },
    getImages: function(a) {
        this.setData({
            images: a.detail
        })
    },
    getAddress: function(t) {
        var e, i = t.detail;
        this.setData((e = {}, a(e, "param.lat", i.latitude), a(e, "param.lng", i.longitude), a(e, "address", i.address), a(e, "get_address", i), e))
    },
    switchChange: function(a) {
        var e = this;
        a.detail.value ? (t.api.apiIGetInfotop().then(function(a) {
            a.data.length > 0 ? e.setData({
                info: a.data
            }) : t.tips("后台未设置顶置功能")
        }).
        catch (function(a) {
            t.tips(a.msg)
        }), this.setData({
            showChoice: !0,
            overhead: !0,
            flag: !0
        })) : this.setData({
            showChoice: !1,
            overhead: !1,
            flag: !1
        })
    },
    close: function(a) {
        this.setData({
            flag: !1,
            showChoice: !1,
            overhead: !1
        })
    },
    onTxtTap: function(a) {
        var t = a.currentTarget.dataset.index,
            e = this.data.info;
        this.setData({
            overhead: !1,
            showChoice: !0,
            choiceMoney: e[t].name + "￥" + e[t].money,
            top_id: e[t].id
        })
    },
    formSubmit: function(a) {
        var e = this,
            i = this,
            s = a.detail.value,
            d = s.describe,
            n = this.data.cityaddress,
            o = this.data.get_address;
        if (d.length < 1) t.tips("请输入内容描述！");
        else if (this.data.images) {
            var r = s.name;
            if (r && "" != r) {
                var c = i.data.phone || s.phone.replace(/\s+/g, "");
                if (/^1(3|4|5|7|8|9)\d{9}$/.test(c)) if (1 == this.data.mes.post_address && this.data.address.length < 1) t.tips("请选择具体位置！");
                else {
                    var h = {
                        cat_id: this.data.cat_id || 0,
                        content: d,
                        pic: this.data.images,
                        name: r,
                        phone: c,
                        address: this.data.address,
                        lng: o ? o.longitude : n ? n.citylng : this.data.lng,
                        lat: o ? o.latitude : n ? n.citylat : this.data.lat,
                        user_id: i.data.user.id,
                        area_adcode: this.data.area_adcode,
                        adcode_address: this.data.adcode_address
                    };
                    this.data.top_id > 0 ? h.top_id = this.data.top_id : h.top_id = 0, i.data.ajax || (i.setData({
                        ajax: !0
                    }), t.api.apiISetInfo(h).then(function(a) {
                        a.data && e.data.flag || 1 == e.data.mes.posting_fee_switch ? wx.requestPayment({
                            appId: a.data.appId,
                            nonceStr: a.data.nonceStr,
                            package: a.data.package,
                            paySign: a.data.paySign,
                            prepay_id: a.data.prepay_id,
                            signType: a.data.signType,
                            timeStamp: a.data.timeStamp,
                            success: function(a) {
                                t.tips("恭喜发布成功！"), setTimeout(function() {
                                    wx.navigateBack({})
                                }, 2e3), i.setData({
                                    ajax: !1
                                })
                            },
                            fail: function() {
                                t.tips("您已取消发布！"), setTimeout(function() {
                                    wx.navigateBack({})
                                }, 2e3), i.setData({
                                    ajax: !1
                                })
                            }
                        }) : (t.tips("发布成功！"), setTimeout(function() {
                            wx.navigateBack({})
                        }, 2e3))
                    }).
                    catch (function(a) {
                        i.setData({
                            ajax: !1
                        }), a.code, t.tips(a.msg)
                    }))
                } else t.tips("请输入正确的手机号码！")
            } else t.tips("请输入您的姓名！")
        } else t.tips("请选择发布图片！")
    },
    getRemark: function(a) {
        this.setData({
            remark: a.detail.value
        })
    },
    checkWarm: function() {
        this.setData({
            popWin: !0,
            areaShow: !1
        })
    },
    agree: function() {
        this.setData({
            popWin: !1,
            areaShow: !0,
            remark: this.data.remark
        })
    }
});