/*www.lanrenzhijia.com   time:2019-06-01 22:11:49*/
var i = getApp(),
    t = require("../../../zhy/template/wxParse/wxParse.js");
i.Base({
    data: {
        flag: 0,
        icon: [{
            title: "普通商品",
            img: "/zhy/resource/images/application/goods.png",
            oindex: 1
        }, {
            title: "抢购商品",
            img: "/zhy/resource/images/application/snap.png",
            oindex: 2
        }, {
            title: "拼购商品",
            img: "/zhy/resource/images/application/spell.png",
            oindex: 3
        }, {
            title: "会员卡",
            img: "/zhy/resource/images/application/sale.png",
            oindex: 4
        }]
    },
    onLoad: function(i) {
        var t = this;
        this.checkLogin(function(i) {
            t.setData({
                show: !0,
                user_id: i.id
            }), t.onLoadData(i)
        }, "/plugin/distribution/memberapplicationtxt/memberapplicationtxt")
    },
    onLoadData: function(a) {
        var e = this,
            n = this,
            o = [],
            s = n.data.icon;
        Promise.all([i.api.apiDistributionGetDistributionset(), i.api.apiDistributionIsDistributionpromoter({
            user_id: a.id
        })]).then(function(a) {
            if (a[0].data) {
                a[0].data.join_module_z.forEach(function(i) {
                    s.forEach(function(t) {
                        i == t.oindex && o.push(s[i - 1])
                    })
                });
                var r = a[0].data.exclusive_rights;
                t.wxParse("detail", "html", r, n, 20), e.setData({
                    show: !0,
                    info: a[0].data,
                    ocheck: a[1].data,
                    img_root: a[0].other.img_root,
                    model: o
                })
            } else i.alert("跳转到首页", function() {
                i.reTo("/pages/home/home")
            }, 0, "商家未配置分销基本信息")
        }).
        catch (function(t) {
            i.tips(t.msg)
        })
    },
    onBtnTap: function() {},
    getValue: function(i) {},
    toggleMask: function() {
        this.setData({
            flag: !this.data.flag
        })
    },
    application: function(t) {
        var a = this,
            e = this.data.info;
        if (1 == e.distribution_condition) {
            var n = {
                user_id: a.data.user_id,
                type: 1,
                form_id: t.detail.formId
            };
            a.data.ajax || (a.setData({
                ajax: !0
            }), i.api.apiDistributionSetDistributionpromoter(n).then(function(t) {
                1 == e.is_check && i.alert("待审核", function() {
                    i.reTo("/pages/mine/mine")
                }, 0, "返回上一页"), 0 == e.is_check && i.alert("申请成功", function() {
                    i.reTo("/plugin/distribution/distributioncenter/distributioncenter")
                }, 0, "返回上一页")
            }).
            catch (function(t) {
                a.setData({
                    ajax: !1
                }), t.code, i.tips(t.msg)
            }))
        } else if (5 == e.distribution_condition) {
            var o = {
                user_id: a.data.user_id
            };
            a.data.ajax || (a.setData({
                ajax: !0
            }), i.api.apiDistributionSetDistributionpromoter(o).then(function(t) {
                1 == e.is_check && i.alert("待审核", function() {
                    i.reTo("/pages/mine/mine")
                }, 0, "返回上一页"), 0 == e.is_check && i.alert("申请成功", function() {
                    i.reTo("/plugin/distribution/distributioncenter/distributioncenter")
                }, 0, "返回上一页")
            }).
            catch (function(t) {
                a.setData({
                    ajax: !1
                }), t.code, i.tips(t.msg)
            }))
        } else i.navTo("/plugin/distribution/memberapplicationform/memberapplicationform")
    },
    toDistributionTap: function() {
        i.navTo("/plugin/distribution/distributioncenter/distributioncenter")
    }
});