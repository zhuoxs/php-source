/*www.lanrenzhijia.com   time:2019-06-01 22:11:53*/
function t(t, a, e) {
    return a in t ? Object.defineProperty(t, a, {
        value: e,
        enumerable: !0,
        configurable: !0,
        writable: !0
    }) : t[a] = e, t
}
var a = getApp();
a.Base({
    data: {
        pageType: 0,
        agree: !0,
        money: ""
    },
    onLoad: function(t) {
        var a = this;
        this.setData({
            id: t.id,
            pageType: t.page
        }), this.checkLogin(function(t) {
            a.onLoadData(t)
        }, "/base/deposit/deposit")
    },
    onLoadData: function(t) {
        var e = this;
        1 == this.data.pageType && (wx.setNavigationBarTitle({
            title: "商家提现"
        }), Promise.all([a.api.apiWithdrawGetWithDrawSet({
            store_id: this.data.id
        }), a.api.apiStoreCheckStoreUserPermission({
            user_id: t.id
        })]).then(function(t) {
            var a = {
                canMoney: t[1].data.store.balance,
                minMoney: t[0].data.min_money,
                rate: t[0].data.cms_rates,
                wxFee: t[0].data.wd_wxrates,
                rich: t[0].data.wd_content
            };
            e.setData({
                msg: a,
                info: t[0].data,
                shop: t[1].data,
                show: !0
            })
        }).
        catch (function(t) {
            "请联系管理人员设置后台相关提现设置,在进行申请提现" == t.msg ? a.alert("请联系管理人员设置后台相关提现设置,在进行申请提现", function() {
                wx.navigateBack({
                    delta: 1
                })
            }, 1) : a.tips(t.msg)
        }))
    },
    taggleAgreeTap: function(t) {
        this.setData({
            agree: !this.data.agree
        })
    },
    onRichTap: function() {
        a.navTo("/base/rich/rich?id=1&info=" + this.data.info.wd_content)
    },
    getMoney: function(t) {
        var e = (t.detail.value.trim() - 0).toFixed(2);
        isNaN(e) ? (this.setData({
            money: ""
        }), a.tips("请输入正确的金额！")) : this.data.msg.canMoney - 0 < this.data.msg.minMoney - 0 ? (this.setData({
            money: ""
        }), a.tips("对不起，您的金额不足可提现金额！")) : e < this.data.msg.minMoney - 0 ? (this.setData({
            money: this.data.msg.minMoney - 0
        }), a.tips("提现金额不得少于" + this.data.msg.minMoney + "元！")) : e > this.data.msg.canMoney - 0 ? (this.setData({
            money: this.data.msg.canMoney - 0
        }), a.tips("余额不足以提现！")) : this.setData({
            money: e
        })
    },
    onDepositTap: function() {
        var t = this;
        if (this.data.agree) if (this.data.msg.canMoney - 0 < this.data.msg.minMoney - 0) a.tips("余额不足以提现！");
        else if ("" != this.data.money) if (this.data.money < this.data.msg.minMoney - 0) a.tips("提现金额不得少于" + this.data.msg.minMoney + "元！");
        else if (this.data.money > this.data.msg.canMoney - 0) a.tips("余额不足以提现！");
        else if (this.data.money) {
            var e = "确定要提现" + this.data.money + "元吗？";
            a.alert(e, function() {
                if (!t.data.ajax && (t.data.ajax = !0, 1 == t.data.pageType)) {
                    var e = {
                        money: t.data.money,
                        store_id: t.data.shop.store.id,
                        user_id: t.data.shop.store.user_id
                    };
                    a.api.apiWithdrawSetWithDraw(e).then(function(e) {
                        a.tips("申请成功,请等待审核！"), t.reloadShop(), setTimeout(function() {
                            t.data.ajax = !1
                        }, 1e3)
                    }).
                    catch (function(e) {
                        a.tips(e.msg), setTimeout(function() {
                            t.data.ajax = !1
                        }, 1e3)
                    })
                }
            })
        } else a.tips("请输入金额！");
        else a.tips("请输入金额！");
        else a.tips("请同意提现须知！")
    },
    reloadShop: function() {
        var e = this,
            i = getCurrentPages();
        i[i.length - 2].setData({
            reload: !0
        }), 1 == this.data.pageType ? a.api.postApiAdminAdminInfo({
            user_id: this.data.user.id
        }).then(function(a) {
            e.setData(t({
                shopMsg: a.data
            }, "msg.canMoney", a.data.shopinfo.money)), wx.setStorageSync("shopEnterMsg", a.data)
        }).
        catch (function(t) {
            a.tips(t.msg)
        }) : 2 == this.data.pageType && a.api.postApiDistributionGetApplySetting({
            user_id: this.data.user.id
        }).then(function(a) {
            e.setData(t({}, "msg.canMoney", a.data.distribution.money))
        }).
        catch (function(t) {
            a.tips(t.msg)
        })
    }
});